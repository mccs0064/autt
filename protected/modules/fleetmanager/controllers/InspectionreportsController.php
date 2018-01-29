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
                'actions' => array('index','add','detail','download','reportformat','quarterly','daily','add','trailer'),
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


    public function actionQuarterly()
    {
        $this->pageTitle='Fleet Manager-Quarterly Inspection Reports';
        $model=new VehicleInspection();
        $model->inspection_type='Quarterly';
        if(isset($_GET['VehicleInspection']))
        {
            $model->attributes=$_GET['VehicleInspection'];
        }
        $this->render('quarterly_inspections',array('model'=>$model));
    }

    public function actionDaily()
    {
        $this->pageTitle='Fleet Manager-Daily Inspection Reports';
        $model=new VehicleInspection();
        $model->inspection_type='Daily';
        if(isset($_GET['VehicleInspection']))
        {
            $model->attributes=$_GET['VehicleInspection'];
        }
        $this->render('daily_inspections',array('model'=>$model));
    }
    public function actionTrailer()
    {
        $this->pageTitle='Fleet Manager-Trailer Inspection Reports';
        $model=new VehicleInspection();
        $model->inspection_type='Trailer';
        if(isset($_GET['VehicleInspection']))
        {
            $model->attributes=$_GET['VehicleInspection'];
        }
        $this->render('trailer_inspections',array('model'=>$model));
    }
    public function actionDetail($id)
    {
       $model=VehicleInspection::model()->findByPk($id);

            $view_name='detail_daily';
        $this->render($view_name,array('model'=>$model));
    }

    public function actionDownload($id)
    {
        $inspectionReport=VehicleInspection::model()->findByPk($id);
        if(!empty($inspectionReport))
        {
//            if($inspectionReport->vehicle->fleetmanager_id!=Yii::app()->user->id)
//                throw new CHttpException(401,'You are unauthorized to download this report');

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
        $this->layout='blank';
        $model=VehicleInspection::model()->findByPk($id);



        $this->render('pdf_daily',array('model'=>$model));
    }

    public function actionAdd()
    {
        $vehicles=Vehicle::model()->findAllByAttributes(array('fleetmanager_id'=>Yii::app()->user->id));
        $drivers=Driver::model()->findAllByAttributes(array('fleetmanager_id'=>Yii::app()->user->id));
        $model = new QuarterlyInspection();
        if (isset($_POST['QuarterlyInspection'])) {
            $model->attributes = $_POST['QuarterlyInspection'];
            $model->inspection_type='Quarterly';
            if ($model->validate()) {

                $model->notification_date = new CDbExpression('NOW()');
                $model->due_date = !empty($_POST[$_POST['QuarterlyInspection']['due_date']])?date('Y-m-d', strtotime($_POST['VehicleInspection']['due_date'])):new CDbExpression('NOW()');
                $model->save();
                if (!empty($_POST['checklists'][0])) {
                    foreach ($_POST['checklists'] as $item) {
                        $checklist = new InspectionChecklist();
                        $checklist->item_name = $item;
                        $checklist->is_done = false;
                        $checklist->inspection_report_id = $model->id;
                        $checklist->save();
                    }
                }
                $v=Vehicle::model()->findByPk($model->vehicle_id);
                $title='Quarterly Inspection: '.$v->vehicle_reg;
                $message="Fleet manager has requested you to do quarterly inspection for this vehicle";
                Yii::app()->commons->sendPushNotifications($model->driver_id,$title,$message);

                $this->redirect(array('/fleetmanager/inspectionreports/quarterly'));
            }
        }
        $this->render('add_quarterly', array('model' => $model, 'vehicles' => $vehicles,'drivers'=>$drivers));
    }

}
