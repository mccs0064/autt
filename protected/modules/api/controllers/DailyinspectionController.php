<?php

class DailyinspectionController extends InspectionreportController
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

    public function actionGetList()
    {
        $driver_id= $this->_getUser();
        $driver=Driver::model()->findByPk($driver_id);
        $fleetmanager_id=$driver->fleetmanager_id;
        $inspectionList=InspectionChecklistFleet::model()->findAllByAttributes(array('fleetmanager_id'=>$fleetmanager_id));
        $response=array();
        if(!empty($inspectionList))
        {
            foreach ($inspectionList as $listItem)
            {
                $item=array();
                $item['id']=$listItem['id'];
                $item['item_name']=$listItem['item_name'];
                $response[]=$item;
            }
        }
        $this->sendData($response);
    }

    public function actionSave()
    {
        $driver_id=$this->_getUser();
        $model=new VehicleInspection();
        $model->driver_id=$driver_id;
        $model->vehicle_id=Yii::app()->request->getPost('vehicle_id',null);
        $model->inspection_type='Daily';
        $model->notification_date=null;
        $model->submitted_date=Yii::app()->request->getPost('submitted_date',null);
        $model->due_date=new CDbExpression('NOW()');
        $model->status='Completed';
        $model->notes=Yii::app()->request->getPost('notes',null);
        $model->setScenario('daily');
        if($model->validate())
        {
            $model->save();
            $this->saveItems($model->id);
            $inspection=VehicleInspection::model()->findByPk($model->id);
            $this->sendData(array($this->getInspectionDetail($inspection)));
        }
        else
        {
            $errors=Yii::app()->helper->getModelErrors($model->getErrors());
            $this->sendError($errors);
        }


    }

    private function saveItems($report_id)
    {
        $item_names=Yii::app()->request->getPost('item_name',null);
        $item_statuses=Yii::app()->request->getPost('item_status',null);
        if(!empty($item_names))
        {
            foreach($item_names as $key=>$name)
            {
                $checklistModel=new InspectionChecklist();
                $checklistModel->item_name=$name;
                $checklistModel->is_done=boolval($item_statuses[$key]);
                $checklistModel->inspection_report_id=$report_id;
                $checklistModel->save();
            }
        }
    }



}
