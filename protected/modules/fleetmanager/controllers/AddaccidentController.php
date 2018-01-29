<?php

class AddaccidentController extends Controller
{

    public $layout = 'main';
    public $baseUrl;

    public $routeOrder=array(
        'basicinfo','myvehiclephotos','othervehicles','othervehiclephotos','audio','police','notes'
    );

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('basicinfo', 'myvehiclephotos', 'othervehiclephotos', 'othervehicles', 'audio', 'police', 'notes','navigate','removephoto','driverinfo'),
                'roles' => array('Fleet'),
            ),
            array('allow',
                'actions' => array('login'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionBasicInfo()
    {
        $this->baseUrl=Yii::app()->request->getBaseUrl(true).'/fleetmanager/addaccident/';
        AccidentWizard::getAccidentUniqueID();
        $this->pageTitle = 'Add Accident-Basic Details';
        $drivers = Driver::model()->findAllByAttributes(array('fleetmanager_id' => Yii::app()->user->id));
        $vehicles = Vehicle::model()->findAllByAttributes(array('fleetmanager_id' => Yii::app()->user->id));
        $model = new BasicInfo();
        $model->assignFromSession('basic_info', $model);
        $model->oldLocation = $model->location;

        if (isset($_POST['BasicInfo'])) {
            $model->attributes = $_POST['BasicInfo'];
            if ($model->validate()) {
                Yii::app()->user->setState('basic_info', $model->attributes);
                Yii::app()->user->setState('basicInfoValidated',true);
                $this->redirect($this->baseUrl.'myvehiclephotos');
            }
            else
            {
                Yii::app()->user->setState('basicInfoValidated',null);
            }
        }

        $this->render('basicinfo', array('model' => $model, 'drivers' => $drivers,'vehicles'=>$vehicles));
    }

    public function actionMyVehiclePhotos()
    {

        $this->pageTitle = 'Add Accident-My Vehicle Photos';


        $this->render('myvehiclephotos');
    }

    public function actionOtherVehicles()
    {
        $this->pageTitle = 'Add Accident-Other Vehicles';

        if (isset($_POST['vehicle_regs'])) {
            $otherVehicles = array();
            foreach ($_POST['vehicle_regs'] as $key => $item) {
                $vehicleItem['reg'] = $item;
                $vehicleItem['passengers'] = !empty($_POST['number_of_pessengers'][$key]) ? $_POST['number_of_pessengers'][$key] : 0;
                $vehicleItem['driver_name'] = !empty($_POST['driver_name'][$key]) ? $_POST['driver_name'][$key] : null;
                $vehicleItem['phone_number'] = !empty($_POST['phone_number'][$key]) ? $_POST['phone_number'][$key] : null;
                $vehicleItem['insurer'] = !empty($_POST['insurer'][$key]) ? $_POST['insurer'][$key] : null;
                $vehicleItem['address'] = !empty($_POST['address'][$key]) ? $_POST['address'][$key] : null;

                $otherVehicles[] = $vehicleItem;
            }
            Yii::app()->user->setState('otherVehicles', $otherVehicles);
            $this->actionNavigate('othervehiclephotos');

        }

        $this->render('othervehicles');
    }

    public function actionDriverInfo()
    {
        $this->baseUrl=Yii::app()->request->getBaseUrl(true).'/fleetmanager/addaccident/';
        AccidentWizard::getAccidentUniqueID();
        $this->pageTitle = 'Add Accident-Driver Info';
        $model = new DriverInfo();
        $model->assignFromSession('driver_info', $model);

        if (isset($_POST['DriverInfo'])) {
            $model->attributes = $_POST['DriverInfo'];
            if ($model->validate()) {
                Yii::app()->user->setState('driver_info', $model->attributes);
                $this->redirect($this->baseUrl.'othervehiclephotos');
            }
        }
        $this->render('driver_info',array('model'=>$model));
    }

    public function actionOtherVehiclePhotos()
    {
        $this->pageTitle = 'Add Accident-Other Vehicles Photos';


        $this->render('othervehiclephotos');
    }

    public function actionAudio()
    {
        $this->pageTitle = 'Add Accident-Audio';
        $model = new AccidentAudio();
        $accident_id = AccidentWizard::getAccidentUniqueID();
        $fullDirectoryPath = AccidentWizard::setDirectory('audio', $accident_id);

        if (isset($_POST['AccidentAudio'])) {
            $model->file = CUploadedFile::getInstance($model, 'file');
            if ($model->validate()) {
                $uploadedFile = $model->file;
                $newFileName = time() . '-' . $uploadedFile->name;
                $filePath = $fullDirectoryPath . '/' . $newFileName;
                $uploadedFile->saveAs($filePath);
                AccidentAudio::removeExistingFile();
                Yii::app()->user->setState('audio', $filePath);
            }
        }

        $this->render('audio', array('model' => $model));
    }

    public function actionPolice()
    {
        $this->pageTitle = 'Add Accident-Police';

        $model = new AccidentPoliceForm();
        $model->assignFromSession('police', $model);

        if (isset($_POST['AccidentPoliceForm'])) {
            $model->attributes = $_POST['AccidentPoliceForm'];
            if ($model->validate()) {
                Yii::app()->user->setState('police', $model->attributes);
            }
        }


        $this->render('police', array('model' => $model));
    }

    public function actionNotes()
    {

        $this->pageTitle = 'Add Accident-Notes';
        $model = new NotesForm();
        $model->assignFromSession('notes', $model);

        if (isset($_POST['NotesForm'])) {
            $model->attributes = $_POST['NotesForm'];
            if ($model->validate()) {
                Yii::app()->user->setState('notes', $model->attributes);
            }
        }

        $wizardModel = new WizardRecord();
        $wizardModel->source='Fleet Manager';
        if (isset($_POST['WizardRecord'])) {
            $basicInfo=Yii::app()->user->getState('basic_info');
            $wizardModel->attributes =$basicInfo;
            if(Yii::app()->user->hasState('notes'))
            {
                $wizardModel->attributes=Yii::app()->user->getState('notes');
            }
            $vehicle=Vehicle::model()->findByPk($basicInfo['vehicle_id']);
            $wizardModel->make=$vehicle->make;
            $wizardModel->model=$vehicle->model;
            $wizardModel->vehicle_reg=$vehicle->vehicle_reg;

            if(!empty($wizardModel->occured_at))
            {
                $wizardModel->occured_at=str_replace("/","-",$wizardModel->occured_at);
            }
            $wizardModel->occured_at=!empty($wizardModel->occured_at)?date('Y-m-d h:i:s',strtotime($wizardModel->occured_at)):new CDbExpression('NOW()');
            if ($wizardModel->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {

                    $wizardModel->save();

                    $transaction->commit();
                    $wizardModel->clearSessionAndFiles();
                    $url=Yii::app()->request->getBaseUrl(true).'/fleetmanager/accidents/detail/id/'.$wizardModel->id;
                    $this->redirect($url);
                } catch (CException $e) {
                    $transaction->rollBack();
                    Yii::app()->user->setFlash('error',$e->getMessage());
                }
            }
        }
        $this->render('notes', array('model' => $model,'wizardModel'=>$wizardModel));
    }

    public function actionRemovePhoto()
    {
        $response=array('status'=>false);
        $filePath=Yii::app()->request->getPost('filePath');
        $type=Yii::app()->request->getPost('type');
        if(Yii::app()->user->hasState($type))
        {
            $existingFiles=Yii::app()->user->getState($type);
            foreach($existingFiles as $key=>$file)
            {
                if($file==$filePath)
                {

                    unset($existingFiles[$key]);
                    $response['status']=true;
                    $baseUrl=Yii::app()->request->getBaseUrl(true)."/";
                    $removePath=str_replace($baseUrl,"",$filePath);
                    unlink($removePath);
                    $remainingFiles = array_values($existingFiles);
                    Yii::app()->user->setState($type,$remainingFiles);
                    break;
                }
            }
        }
        echo CJSON::encode($response);
    }

    public function actionNavigate($route)
    {
        $this->baseUrl=Yii::app()->request->getBaseUrl(true).'/fleetmanager/addaccident/';
        if(!AccidentWizard::isBasicInfoValidated())
        {
            Yii::app()->user->setFlash('error','You must enter accident basic info to proceed further');

            $this->redirect($this->baseUrl.'basicinfo');
        }
        else
        {
            $this->redirect($this->baseUrl.$route);
        }

    }


}
