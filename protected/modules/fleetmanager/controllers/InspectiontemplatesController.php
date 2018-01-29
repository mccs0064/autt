<?php

class InspectiontemplatesController extends Controller {

    public $layout = 'main';

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index','add','delete','update','addrow','template','deletedefect','delete','getitems'),
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

    private function isFleetManagerTemplate($model)
    {
        if(!empty($model))
        {
            if($model->fleetmanager_id=!Yii::app()->user->id)
                throw new CHttpException(403,'You are not authorized to access this page');
        }
        else
        {
            throw new CHttpException(404,'Page not found with this ID');
        }
    }

    public function actionIndex() {

        $this->pageTitle='Fleet Manager-Inspection Templates';
        $model = new InspectionTemplate();
        if (isset($_GET['InspectionTemplate'])) {
            $model->attributes = $_GET['InspectionTemplate'];
        }
        $this->render('index', array('model' => $model));
    }

    public function actionAdd()
    {
        $model=new InspectionTemplate();

        $this->render('add',array('model'=>$model,'items'=>array()));
    }

    public function actionUpdate($id)
    {
       $model=InspectionTemplate::model()->findByPk($id);
        $this->isFleetManagerTemplate($model);
       $templateItems=InspectionTemplateItems::model()->findAllByAttributes(array('template_id'=>$id));

        $this->render('add',array('model'=>$model,'items'=>$templateItems));
    }

    public function actionAddRow()
    {
        $defect_name=Yii::app()->request->getPost('defect_name',null);
        $id=Yii::app()->request->getPost('last_id',null);
        $id=intval($id);
        $id++;


        $html=$this->renderPartial('_defectitem',array('id'=>$id,'name'=>$defect_name,'visible'=>1,'db_id'=>'0'),true);

        $response=array('status'=>true,'html'=>$html);
        echo CJSON::encode($response);
    }

    public function actionTemplate()
    {
        $defects=Yii::app()->request->getPost('defects');
        $template_name=Yii::app()->request->getPost('template_name');
        $record_id=Yii::app()->request->getPost('record_id',null);
        if(!empty($record_id))
        {

            $model=InspectionTemplate::model()->findByPk($record_id);

            $model->udpated_at=new CDbExpression('NOW()');

            $model->template_name=$template_name;
            $model->fleetmanager_id=Yii::app()->user->id;
            $model->update();

        }
        else
        {
            $model=new InspectionTemplate();
            $model->created_at=new CDbExpression('NOW()');
            $model->udpated_at=new CDbExpression('NOW()');
            $model->template_name=$template_name;
            $model->fleetmanager_id=Yii::app()->user->id;
            $model->save();
        }
        if(!empty($defects))
        {
            foreach ($defects as $defect)
            {
                if($defect['isOld']=='0')
                {
                    $dModel=new InspectionTemplateItems();
                    $dModel->template_id=$model->id;
                    $dModel->name=$defect['name'];
                    $dModel->visible=$defect['visible']=='false'?0:1;
                    $dModel->created_at=new CDbExpression('NOW()');
                    $dModel->save();
                }
                else
                {
                    $dModel=InspectionTemplateItems::model()->findByPk($defect['id']);
                    $dModel->name=$defect['name'];
                    $dModel->visible=$defect['visible']=='false'?0:1;
                    $dModel->update();
                }

            }
        }

    }

    public function actionDeleteDefect()
    {
        $defect_id=Yii::app()->request->getPost('defect_id');
        InspectionTemplate::model()->deleteByPk($defect_id);
    }

    public function actionDelete()
    {
        $template_id=Yii::app()->request->getPost('id',null);
        $vehicles=Vehicle::model()->findAllByAttributes(array('inspection_template_id'=>$template_id));
        $transaction=Yii::app()->db->beginTransaction();
        $response['status']=false;
        try
        {
            $model=InspectionTemplate::model()->findByPk($template_id);
            if(!empty($model))
            {
                if(!empty($vehicles))
                {
                    foreach($vehicles as $vehicle)
                    {
                        $vehicle->inspection_template_id=null;
                        $vehicle->update();
                    }
                }
                $inspectionItems=InspectionTemplateItems::model()->findAllByAttributes(array('template_id'=>$template_id));
                if(!empty($inspectionItems))
                {
                    foreach($inspectionItems as $iItem)
                    {
                        $iItem->delete();
                    }
                }
                $model->delete();
                $transaction->commit();
                $response['status']=true;
            }
        }
        catch (Exception $exception)
        {
            $transaction->rollback();
            $response['message']=$exception->getMessage();
        }
        echo CJSON::encode($response);

    }

    public function actiongetitems()
    {
        $template_id=Yii::app()->request->getPost('template_id',null);
        $response='No items to show';
        $inspectionItems=InspectionTemplateItems::model()->findAllByAttributes(array('template_id'=>$template_id));
        if(!empty($inspectionItems))
        {
            $itemsCount=count($inspectionItems);
            $itemText=$itemsCount==1?'item':'items';
            $response='List Found: '.count($inspectionItems)." ".$itemText." <br/>";
            foreach ($inspectionItems as $item)
            {
                $response.=$item['name'].", ";
            }
        }
        echo chop($response,", ");
    }

}
