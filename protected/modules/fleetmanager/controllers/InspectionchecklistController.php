<?php

class InspectionchecklistController extends Controller {

    public $layout = 'main';

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index','add','delete'),
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

    public function actionIndex() {

        $this->pageTitle='Fleet Manager-Build Inspection Checklist';
        $items=InspectionChecklistFleet::model()->findAllByAttributes(array('fleetmanager_id'=>Yii::app()->user->id));
         $this->render('index',array('items'=>$items));
    }

    public function actionAdd()
    {
        $checklist_name=Yii::app()->request->getPost('item_name',null);
        $model=new InspectionChecklistFleet();
        $model->fleetmanager_id=Yii::app()->user->id;
        $model->item_name=$checklist_name;
        if($model->validate())
        {
            $model->save();
            echo CJSON::encode(array('status'=>true,'data'=>$model->attributes));
        }
        else
        {
            echo CJSON::encode(array('status'=>false,'errors'=>$model->getErrors()));
        }
    }

    public function actionDelete()
    {
        $checklist_id=Yii::app()->request->getPost('inspection_id',null);
        $item=InspectionChecklistFleet::model()->findByPk($checklist_id);
        if($item->fleetmanager_id==Yii::app()->user->id)
        {
            $item->delete();
            echo CJSON::encode(array('status'=>true));
        }
        else
        {
            echo CJSON::encode(array('status'=>true,'error'=>'You are not authorized to delete that'));
        }
    }

}
