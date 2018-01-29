<?php

class InspectionreportsController extends Controller {

    public $layout = 'main';

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index','add','detail','download','reportformat'),
                'roles' => array('Fleet'),
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

    public function actionIndex() {

        $this->pageTitle='Fleet Manager-Inspection Reports';
        $model=new VehicleInspection();
        if(isset($_GET['VehicleInspection']))
        {
            $model->attributes=$_GET['VehicleInspection'];
        }
         $this->render('all_inspections',array('model'=>$model));
    }
    public function actionDetail($id)
    {
       $model=VehicleInspection::model()->findByPk($id);
        $this->render('inspection_detail',array('model'=>$model));
    }

    public function actionDownload($id)
    {
        $inspectionReport=VehicleInspection::model()->findByPk($id);
        if(!empty($inspectionReport))
        {
            if($inspectionReport->vehicle->fleetmanager_id!=Yii::app()->user->id)
                throw new CHttpException(401,'You are unauthorized to download this report');

            $pageURL = Yii::app()->request->getBaseUrl(true) . '/fleetmanager/inspectionreports/reportformat/id/' . $id;
            $generatedFileName = 'inspectionreport-' . rand(0, 9999) . Yii::app()->user->id . ".pdf";

            Yii::import('application.extensions.WKHTMLTOPDF.*');
            $wkhtmltopdf = new Wkhtmltopdf(array('path'=>'uploads/reports'));


            $wkhtmltopdf->setUrl($pageURL);
            $wkhtmltopdf->output(Wkhtmltopdf::MODE_DOWNLOAD, $generatedFileName);

        }
    }

    public function actionReportFormat($id)
    {
        $this->layout=false;
        $inspectionReport=VehicleInspection::model()->findByPk($id);

        $this->render('pdf_report',array('model'=>$inspectionReport));
    }

}
