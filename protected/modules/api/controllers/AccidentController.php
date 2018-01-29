<?php

class AccidentController extends APIController
{

    public function actionIndex()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                if (!empty($_GET['id'])) {
                    $this->getSingleAccidentDetails($_GET['id']);
                } else {
                    $this->getDriverAccidents();
                }
                break;
            default:
                break;
        }
    }

    public function getDriverAccidents()
    {
        $driver_id = $this->_getUser();
        $criteria=new CDbCriteria();
        $criteria->select='*';
        $criteria->condition='driver_id='.$driver_id;
        $criteria->compare('make',Yii::app()->request->getQuery('make',null),true);
        $criteria->compare('model',Yii::app()->request->getQuery('model',null),true);
        $criteria->compare('vehicle_reg',Yii::app()->request->getQuery('vehicle_reg',null),true);
        $accidents=Accident::model()->findAll($criteria);
        $response=array();
        if(!empty($accidents))
        {
            foreach($accidents as $accident)
            {
                $accidentDetail=Yii::app()->helper->getAccidentDetails($accident['id']);
                $response[]=$accidentDetail;
            }
        }
        $this->sendData($response);
    }

    public function getSingleAccidentDetails($accident_id)
    {
        $this->_getUser();
        $this->sendData(Yii::app()->helper->getAccidentDetails($accident_id));
    }
    public function getDetail()
    {
        $driver_id = $this->_getUser();
        $accident_id=Yii::app()->request->getQuery('accident_id',null);
        $this->sendData(Yii::app()->helper->getAccidentDetails($accident_id));
    }

    public function actionCreate()
    {
        $driver_id = $this->_getUser();
        $model = new Accident();
        $model->driver_id = $driver_id;
        $model->make = Yii::app()->request->getPost('make', null);
        $model->model = Yii::app()->request->getPost('model', null);
        $model->longitude = Yii::app()->request->getPost('longitude', null);
        $model->latitude = Yii::app()->request->getPost('latitude', null);
        $model->location = Yii::app()->request->getPost('location', null);
        $model->vehicle_reg = Yii::app()->request->getPost('vehicle_reg', null);
        $model->weather_condition = Yii::app()->request->getPost('weather_condition', null);
        $model->occured_at = Yii::app()->request->getPost('occured_at', null);
        if ($model->validate()) {
            $model->occured_at=date('Y-m-d H:i:s',strtotime($model->occured_at));
            $model->save();
            $this->sendData(Yii::app()->helper->getAccidentDetails($model->id));
        } else {
            $errors = Yii::app()->helper->getModelErrors($model->getErrors());
            $this->sendError($errors);
        }
    }
/****************UPLOAD OWN,OTHER VEHICLES IMAGES and SOUND RECORDING********************/
    public function actionUploadFile()
    {
        $driver_id = $this->_getUser();
        $accident_id = Yii::app()->request->getPost('accident_id', null);
        $media_type = Yii::app()->request->getPost('media_type', 'Image');
        if ($accident_id == null) {
            $this->sendError('Please specify the accident_id for which you want to add file');
        } else {
            $accident = Accident::model()->findbyPk($accident_id);

            if (!empty($accident)) {
                if ($accident->driver_id != $driver_id) {
                    $this->sendError('You are unauthorized to add file to a accident that was not created by you.',401);
                } else {
                    if (!empty($_FILES['file'])) {
                        if($this->addAttachment($accident_id, $media_type))
                        {
                            $this->sendData(Yii::app()->helper->getAccidentDetails($accident_id));
                        }
                        else
                        {
                            $this->sendError('There was some problem uploading the file.Please try later',500);

                        }
                    } else {
                        $this->sendError('Please upload at least one file');
                    }
                }
            } else {
                $this->sendError('Not accident found with this ID');
            }
        }
    }

    public function addAttachment($accident_id, $media_type)
    {
        $uploaded=false;
        if (!empty($_FILES)) {
            $files = CUploadedFile::getInstancesByName('file');

            foreach ($files as $file) {
                $fileDirectory = date('mY');
                $folder = 'uploads/' . $fileDirectory . "/";
                if (!file_exists($folder)) {
                    mkdir("uploads/" . $fileDirectory, 0777);
                }
                $uploadedFileName = $accident_id . rand(0, 99999) . "-" . $file->name;
                $filePath = $folder . $uploadedFileName;
                $file->saveAs($filePath);
                $fileModel = new AccidentMedia();
                $fileModel->directory_name = $fileDirectory;
                $fileModel->filename = $uploadedFileName;
                $fileModel->accident_id = $accident_id;
                $fileModel->media_type = $media_type;
                if($media_type=='Image')
                {
                    $fileModel->image_type=Yii::app()->request->getPost('image_type','Self');
                }
                $fileModel->save();
                $uploaded=true;
            }
        }
        return $uploaded;

    }

/******************Service to upload witness statement*****************/
    public function actionAddEyeWitness()
    {
        $driver_id = $this->_getUser();
        $accident_id = Yii::app()->request->getPost('accident_id', null);
        if ($accident_id) {
            $accident=Accident::model()->findByPk($accident_id);
            if(!empty($accident))
            {
                if($accident->driver_id==$driver_id)
                {
                    $model=new AccidentWitness();
                    $model->accident_id=$accident_id;
                    $model->fullname=Yii::app()->request->getPost('full_name',null);
                    $model->phone_number=Yii::app()->request->getPost('phone_number',null);
                    $model->date_of_birth=Yii::app()->request->getPost('date_of_birth',null);
                    $model->address=Yii::app()->request->getPost('address',null);
                    $audioStatement=$this->eyeWitnessStatementUpload($accident_id);
                    $model->directory_name=$audioStatement['directory_name'];
                    $model->witness_audio_statement=$audioStatement['filename'];
                    if($model->validate())
                    {
                        $model->save();
                        $this->sendData(Yii::app()->helper->getAccidentDetails($accident_id));
                    }
                    else
                    {
                        $errors=Yii::app()->helper->getModelErrors($model->getErrors());
                        $this->sendError($errors);
                    }
                }
                else
                {
                    $this->sendError('You are only authorized to add eye witnesses to your accidents');
                }
            }
            else
            {
                $this->sendError('No accident found with this ID');
            }

        }
        else
        {
            $this->sendError('Please specify the accident_id for which you want to add file');
        }
    }

    public function eyeWitnessStatementUpload($accident_id)
    {
        $uploaded=array('directory_name'=>null,'file'=>null);
        if (!empty($_FILES)) {
            $file = CUploadedFile::getInstanceByName('witness_audio_statement');
                $fileDirectory = date('mY');
                $folder = 'uploads/' . $fileDirectory . "/";
                if (!file_exists($folder)) {
                    mkdir("uploads/" . $fileDirectory, 0777);
                }
                $uploadedFileName = $accident_id . rand(0, 99999) . "-" . $file->name;
                $filePath = $folder . $uploadedFileName;
                $file->saveAs($filePath);
                $uploaded=array('directory_name'=>$fileDirectory,'filename'=>$uploadedFileName);
        }

        return $uploaded;
    }
    /******************Service to add information about involved vehicles*****************/
    public function actionInvolvedVehicles()
    {
        $driver_id=$this->_getUser();
        $accident_id = Yii::app()->request->getPost('accident_id', null);
        if ($accident_id) {
            $accident=Accident::model()->findByPk($accident_id);
            if(!empty($accident))
            {
                if($accident->driver_id=$driver_id)
                {
                    $vehicles=Yii::app()->request->getPost('vehicle_reg',null);
                    $pessengers=Yii::app()->request->getPost('number_of_pessengers',null);
                    $diver_name=Yii::app()->request->getPost('driver_name',null);
                    $insurer=Yii::app()->request->getPost('insurer',null);
                    $phone_number=Yii::app()->request->getPost('phone_number',null);
                    $address=Yii::app()->request->getPost('address',null);
                    if(!empty($vehicles))
                    {
                        foreach ($vehicles as $key=> $vehicle_reg)
                        {
                            $model=new AccidentVehicles();
                            $model->accident_id=$accident_id;
                            $model->vehicle_reg=$vehicle_reg;
                            $model->number_of_pessengers=(!empty($pessengers[$key]))?$pessengers[$key]:0;
                            $model->driver_name=(!empty($diver_name[$key]))?$diver_name[$key]:null;
                            $model->insurer=(!empty($insurer[$key]))?$insurer[$key]:null;
                            $model->phone_number=(!empty($phone_number[$key]))?$phone_number[$key]:null;
                            $model->address=(!empty($address[$key]))?$address[$key]:null;
                            $model->save();
                        }
                        $this->sendData(Yii::app()->helper->getAccidentDetails($accident_id));

                    }
                    else
                    {
                        $this->sendError('Please add at least one vehicle registration number');
                    }
                }
                else
                {
                    $this->sendError('You are only authorized to add vehicles on your accidents');
                }
            }
            else
            {
                $this->sendError('No accident found with this ID');
            }
        }
        else
        {
            $this->sendError('Please specify the accident ID');
        }
    }
    /******************Service to add police involvement stateement*****************/
    public function actionAddPoliceInformation()
    {
        $driver_id = $this->_getUser();
        $accident_id = Yii::app()->request->getPost('accident_id', null);
        if ($accident_id) {
            $accident=Accident::model()->findByPk($accident_id);
            if(!empty($accident))
            {
                if($accident->driver_id==$driver_id)
                {
                    $model=new AccidentPolice();
                    $model->accident_id=$accident_id;
                    $model->officer_name=Yii::app()->request->getPost('officer_name',null);
                    $model->police_station=Yii::app()->request->getPost('police_station',null);
                    $model->phone_number=Yii::app()->request->getPost('phone_number',null);
                    $model->batch_number=Yii::app()->request->getPost('batch_number',null);
                    if($model->save())
                    {
                        $this->sendData(Yii::app()->helper->getAccidentDetails($accident_id));
                    }
                    else
                    {
                        $errors=Yii::app()->helper->getModelErrors($model->getErrors());
                        $this->sendError($errors);
                    }
                }
                else
                {
                    $this->sendError('You are only authorized to add police information for your accidents');
                }
            }
            else
            {
                $this->sendError('No accident found with this ID');
            }
          }
        else
        {
            $this->sendError('Please specify the accident ID');
        }
    }

    public function actionSaveOtherDriver()
    {
        $driver_id = $this->_getUser();
        $model = new AccidentDriver();
        $model->driver_name=Yii::app()->request->getPost('driver_name', null);
        $model->address=Yii::app()->request->getPost('address', null);
        $model->phone_number=Yii::app()->request->getPost('phone_number', null);
        $model->insurer=Yii::app()->request->getPost('insurer', null);
        $model->reg=Yii::app()->request->getPost('reg', null);
        $accident_id = Yii::app()->request->getPost('accident_id', null);
        if(!empty($accident_id))
        {
            $accident=Accident::model()->findByPk($accident_id);
            if(empty($accident))
                $this->sendError('No accident found with this ID');
            else if($accident->driver_id!=$driver_id)
                       $this->sendError('You are only authorized to other driver information for your accidents');
            else
                $model->accident_id=$accident_id;

        }
        if ($model->validate()) {
            $model->save();
            $this->sendData(Yii::app()->helper->getAccidentDetails($model->accident_id));
        } else {
            $errors = Yii::app()->helper->getModelErrors($model->getErrors());
            $this->sendError($errors);
        }
    }

}
