<?php

class DailyinspectionreportController extends APIController
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


    public function actionSave()
    {
        $driver_id = $this->_getUser();
        $model = new DailyInspectionReport();
        $model->driver_id = $driver_id;
        $model->vehicle_id = Yii::app()->request->getPost('vehicle_id', null);
        $model->fleetmanager_id=$this->getFleetManagerFromDriver($driver_id);
        $model->submitted_date = Yii::app()->request->getPost('submitted_date', null);
        if ($model->validate()) {
            $model->save();
            $this->saveItems($model->id);
            $inspection = DailyInspectionReport::model()->findByPk($model->id);
            $this->sendData(array($this->getInspectionDetail($inspection)));
        } else {
            $errors = Yii::app()->helper->getModelErrors($model->getErrors());
            $this->sendError($errors);
        }
    }

    private function saveItems($report_id)
    {
        $item_names = Yii::app()->request->getPost('item_name', null);
        $item_statuses = Yii::app()->request->getPost('item_status', null);
        $item_notes = Yii::app()->request->getPost('notes', null);

        if (!empty($item_names)) {

            foreach ($item_names as $key => $name) {
                $checklistModel = new DailyInspectionReportItems();
                $checklistModel->name = $name;
                $checklistModel->inspected = boolval($item_statuses[$key])==true?1:0;
                $checklistModel->notes = $item_notes[$key];
                $checklistModel->report_id = $report_id;
                $checklistModel->save();

            }
        }
    }

    public function getFleetManagerFromDriver($driver_id)
    {
        $driver=Driver::model()->findByPk($driver_id);
        if(!empty($driver))
            return $driver->fleetmanager_id;

        return null;
    }



    private function getAll()
    {
        $driver_id= $this->_getUser();
        $criteria=new CDbCriteria();
        $criteria->select="*";
        $criteria->condition='t.driver_id='.$driver_id;
        $inspections=DailyInspectionReport::model()->findAll($criteria);
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
        $inspection=DailyInspectionReport::model()->findByPk($inspection_id);
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
        $responseObj['vehicle']=Yii::app()->helper->getVehicleDetailsData($inspection['vehicle_id']);
        $responseObj['submitted_date']=$inspection['submitted_date'];
        $responseObj['defects']=$this->getChecklists($inspection['id']);
        return $responseObj;
    }

    private  function getChecklists($report_id)
    {
        $response=array();
        $defects=DailyInspectionReportItems::model()->findAllByAttributes(array('report_id'=>$report_id));
        if(!empty($defects))
        {
            foreach($defects as $checklist)
            {
                $checklistItem=array();
                $checklistItem['id']=$checklist['id'];
                $checklistItem['name']=$checklist['name'];
                $checklistItem['inspected']=$checklist['inspected'];
                $checklistItem['notes']=$checklist['notes'];
                $response[]=$checklistItem;
            }
        }
        return $response;
    }


}
