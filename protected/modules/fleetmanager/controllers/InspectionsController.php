<?php

class InspectionsController extends Controller {

    public $layout = 'main';

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index','detail','export','download','new','loadlist','savefleetinspection','updateclaimcost'),
                'roles' => array('Fleet','Admin'),
            ),
            array('allow',
                'actions' => array('login','reportformat'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    private function isFleetManagerInspection($model)
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

    public function actionIndex()
    {
        $model=new DailyInspectionReport();

        $this->render('index',array('model'=>$model));
    }

    public function actionDetail($id)
    {
        $model=DailyInspectionReport::model()->findByPk($id);
        $this->isFleetManagerInspection($model);
        $model->id=$id;

       $this->render('inspection_detail',array('model'=>$model));
    }

    public function actionExport()
    {
        $inspections=DailyInspectionReport::model()->findAllByAttributes(array('fleetmanager_id'=>Yii::app()->user->id));
        $this->generateSheet($inspections,'vehicle_inspections');
    }
    private function generateSheet($inspections,$name)
    {
        $data = array(
            1 => array (
                'Report ID',
                'Vehicle Type',
                'Vehicle',
                'Total Defects Reported',
                'Date Submission',
                'Recorded From',
                'Claim Cost'
            )
        );
        if(!empty($inspections))
        {
            foreach ($inspections as $inspection)
            {
                $driver=Driver::model()->findByPk($inspection['driver_id']);
                $inspection_item['id']="INS-000".$inspection['id'];
                $inspection_item['vehicle_type']=$inspection->vehicle->vehicle_type;
                $inspection_item['vehicle']=$inspection->vehicle->vehicle_reg;
                $inspection_item['defects']=DailyInspectionReport::getTotalDefects($inspection->id);
                $inspection_item['submission_date']=date("d F Y",strtotime($inspection->submitted_date));
                $inspection_item['recorded_from']=$inspection->user_type=='Fleet Manager'?'Fleet Manager':$driver->full_name." ".$driver->autium_id;
                $inspection_item['claim_cost']=!empty($inspection->claim_cost)?"£".number_format($inspection->claim_cost,2):'N/A';
                array_push($data,$inspection_item);
            }

            Yii::import('application.extensions.phpexcel.JPhpExcel');
            $xls = new JPhpExcel();
            $xls->addArray($data);
            $xls->generateXML($name);
        }
        else
        {
            Yii::app()->user->setFlash('warning','There is no data to export for this period');
            $this->redirect(array('/fleetmanager/inspections'));
        }
    }

    public function actionDownload($id)
    {
        $inspectionReport=DailyInspectionReport::model()->findByPk($id);
        if(!empty($inspectionReport))
        {
            $this->isFleetManagerInspection($inspectionReport);

            $pageURL = Yii::app()->request->getBaseUrl(true) . '/fleetmanager/inspections/reportformat/id/' . $id;
            $generatedFileName = 'inspectionreport-' . rand(0, 9999) . Yii::app()->user->id . ".pdf";

            Yii::import('application.extensions.WKHTMLTOPDF.*');
            $wkhtmltopdf = new Wkhtmltopdf(array('path'=>'uploads/reports'));


            $wkhtmltopdf->setUrl($pageURL);
            $wkhtmltopdf->output(Wkhtmltopdf::MODE_DOWNLOAD, $generatedFileName);

        }
    }

    public function actionReportFormat($id)
    {
        $this->layout='blank';
        $model=DailyInspectionReport::model()->findByPk($id);

        $this->render('pdf_report',array('model'=>$model));
    }

    public function actionNew()
    {
        $model=new NewInspectionForm();
        $criteria=new CDbCriteria();
        $criteria->condition='fleetmanager_id='.Yii::app()->user->id.' and inspection_template_id is not null';
        $vehicles=Vehicle::model()->findAll($criteria);
        foreach($vehicles as $key=>$vehicle)
        {
            $vehicles[$key]['select_option']=$vehicles[$key]['vehicle_reg']." - ".$vehicles[$key]['make']." ".$vehicles[$key]['model'];
        }
        $this->render('new',array('vehicles'=>$vehicles,'model'=>$model));
    }

    public function actionLoadList()
    {
        $vehicle_id=Yii::app()->request->getPost('vehicle_id',null);
        $vehicle=Vehicle::model()->findByPk($vehicle_id);
        $template_id=$vehicle->inspection_template_id;
        $template=InspectionTemplate::model()->findByPk($template_id);
        $templateItems=InspectionTemplateItems::model()->findAllByAttributes(array('template_id'=>$template_id,'visible'=>'1'));
        echo $this->renderPartial('_templateview',array('template'=>$template,'templateItems'=>$templateItems),true);
    }

    public function actionsavefleetinspection()
    {
        $vehicle_id=Yii::app()->request->getPost('vehicle_id',null);
        $date_submitted=str_replace("/","-",Yii::app()->request->getPost('date_submitted',null));
        $defects=Yii::app()->request->getPost('defects',null);

        $model=new DailyInspectionReport();
        $model->vehicle_id=$vehicle_id;
        $model->driver_id=Yii::app()->user->id;
        $model->fleetmanager_id=Yii::app()->user->id;
        $model->submitted_date=date('Y-m-d H:i:s',strtotime($date_submitted));
        $model->user_type='Fleet Manager';
        $response['status']=false;
        $transaction=Yii::app()->db->beginTransaction();
        try{
            if($model->save())
            {
                if(!empty($defects))
                {
                    foreach ($defects as $defect)
                    {

                        $modelI=new DailyInspectionReportItems();
                        $modelI->name=$defect['defect_name'];
                        $modelI->notes=!empty($defect['content'])?$defect['content']:'';
                        $modelI->inspected=($defect['inspected'])=='false'?0:1;
                        $modelI->report_id=$model->id;
                        $modelI->save();
                    }
                }
            }

            $transaction->commit();
            $response['status']=true;
            $response['url']=Yii::app()->request->getBaseUrl(true).'/fleetmanager/inspections/detail/id/'.$model->id;

        }
        catch (Exception $exception)
        {
            $transaction->rollback();
        }
        echo CJSON::encode($response);

    }

    public function actionupdateclaimcost()
    {
        $claim_cost=Yii::app()->request->getPost('claim_cost',null);
        $model_id=Yii::app()->request->getPost('model_id',null);
        $model=DailyInspectionReport::model()->findByPk($model_id);
        $model->claim_cost=$claim_cost;
        $model->update();
    }
}
