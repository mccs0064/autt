<?php

class InspectionreportController extends APIController
{

    public function actionIndex()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'DELETE':
            case 'GET':
                if (!empty($_GET['id'])) {
                    $this->getSingleInspectionReport($_GET['id']);
                } else {
                    $this->getAll();
                }
                break;
            default:
                break;
        }
    }


    public function actionUpdate()
    {
        $inspection_id=Yii::app()->request->getPost('inspection_id',null);
        if($inspection_id)
        {
            $inspection=VehicleInspection::model()->findByPk($inspection_id);
            if(!empty($inspection))
            {
                $inspection->notes=Yii::app()->request->getPost('notes',null);
                $inspectionImages=$this->uploadImages($inspection->id);
                if(!empty($inspectionImages['directory_name']))
                {
                    $inspection->image1=$inspectionImages['image1'];
                    $inspection->image2=$inspectionImages['image2'];
                    $inspection->directory_name=$inspectionImages['directory_name'];
                }
                $this->updateChecklsits();
                $inspection->setScenario('updateReport');
                if($inspection->validate())
                {
                    $inspection->status='Completed';
                    $inspection->update();
                    $this->sendData(array('Inspection report data has been updated'));
                }
                else
                {
                    $errors=Yii::app()->helper->getModelErrors($inspection->getErrors());
                    $this->sendError($errors);
                }
            }
            else
            {
                $this->sendError('No inspection report found with this ID');
            }
        }
        else
        {
            $this->sendError('Please specify the inspection report ID you wish to update');
        }

    }

    private function uploadImages($inspection_id)
    {
        $response=array('directory_name'=>null,'image1'=>null,'image2'=>null);
        if (!empty($_FILES)) {
            $files = CUploadedFile::getInstancesByName('inspection_images');

            foreach ($files as $key=>$file) {
                $fileDirectory = date('mY');
                $folder = 'uploads/' . $fileDirectory . "/";
                if (!file_exists($folder)) {
                    mkdir("uploads/" . $fileDirectory, 0777);
                }
                $uploadedFileName = $inspection_id . rand(0, 99999) . "-" . $file->name;
                $filePath = $folder . $uploadedFileName;
                $file->saveAs($filePath);
                $response['directory_name']=$fileDirectory;
                if($key==0)
                {
                    $response['image1']=$uploadedFileName;
                }
                else if($key==1)
                {
                    $response['image2']=$uploadedFileName;
                }
            }
        }
        return $response;
    }

    private function updateChecklsits()
    {
        $updated=false;
        $checklist_ids=Yii::app()->request->getPost('checklist_ids',null);
        $checklist_status=Yii::app()->request->getPost('checklist_status',null);
        if(!empty($checklist_ids))
        {
            foreach($checklist_ids as $key=>$checklist_id)
            {
                $checklistModel=InspectionChecklist::model()->findByPk($checklist_id);
                $checklistModel->is_done=boolval($checklist_status[$key]);
                $checklistModel->update();
                $updated=true;
            }
        }
        return $updated;
    }

    private function getAll()
    {
        $driver_id= $this->_getUser();
        $criteria=new CDbCriteria();
        $criteria->select="*";
        $criteria->with=array('vehicle','inspectionChecklists');
        $criteria->condition='t.driver_id='.$driver_id;
        $criteria->compare('t.status',Yii::app()->request->getQuery('status',null),true);
        $criteria->compare('t.inspection_type',Yii::app()->request->getQuery('type',null),true);
        $inspections=VehicleInspection::model()->findAll($criteria);
        $data=array();
        if(!empty($inspections))
        {
            foreach ($inspections as $inspection)
            {
                $data[]=$this->getInspectionDetail($inspection);
            }
        }
        $this->sendData($data);
    }

    public function getSingleInspectionReport($inspection_id)
    {
        $inspection=VehicleInspection::model()->findByPk($inspection_id);
        if(!empty($inspection))
        {
            $this->sendData(array($this->getInspectionDetail($inspection)));
        }
        else
        {
            $this->sendError('No inspection report exists with this ID');
        }
    }


    public function getInspectionDetail($inspection)
    {
        $responseObj=array();
        $responseObj['id']=$inspection['id'];
        $responseObj['vehicle']=Yii::app()->helper->getVehicleDetails($inspection['vehicle_id'],$inspection['vehicle_reg']);
        $responseObj['status']=$inspection['status'];
        $responseObj['due_date']=$inspection['due_date'];
        $responseObj['notification_date']=$inspection['notification_date'];
        $responseObj['submitted_date']=$inspection['submitted_date'];
        $responseObj['inspection_type']=$inspection['inspection_type'];
        $responseObj['notes']=!empty($inspection['notes'])?$inspection['notes']:null;
        $responseObj['image1']=!empty($inspection['image1'])?Yii::app()->request->getBaseUrl(true) . "/uploads/" . $inspection['directory_name'] . "/" . rawurlencode($inspection['image1']):null;
        $responseObj['image2']=!empty($inspection['image2'])?Yii::app()->request->getBaseUrl(true) . "/uploads/" . $inspection['directory_name'] . "/" . rawurlencode($inspection['image2']):null;
        $responseObj['checklists']=$this->getChecklists($inspection['inspectionChecklists']);
        return $responseObj;
    }

    private  function getChecklists($checklists)
    {
        $response=array();
        if(!empty($checklists))
        {
            foreach($checklists as $checklist)
            {
                $checklistItem=array();
                $checklistItem['id']=$checklist['id'];
                $checklistItem['item_name']=$checklist['item_name'];
                $checklistItem['is_done']=$checklist['is_done'];
                $response[]=$checklistItem;
            }
        }
        return $response;
    }




}
