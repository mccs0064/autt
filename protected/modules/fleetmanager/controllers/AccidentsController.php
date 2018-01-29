<?php

class AccidentsController extends Controller {

    public $layout = 'main';

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index','detail','updatenotes','download'),
                'roles' => array('Fleet'),
            ),
            array('allow',
                'actions' => array('login','pdf'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    private function isFleetManagerAccident($model)
    {
        if(!empty($model))
        {
            if($model->driver->fleetmanager_id=!Yii::app()->user->id)
                throw new CHttpException(403,'You are not authorized to access this page');
        }
        else
        {
            throw new CHttpException(404,'Page not found with this ID');
        }
    }

    public function actionIndex() {

        $this->pageTitle='Fleet Manager-All Accidents';
        $model=new Accident();
        if(isset($_GET['Accident']))
        {
            $model->attributes=$_GET['Accident'];
        }
         $this->render('all_accidents',array('model'=>$model));
    }
    public function actionDetail($id)
    {
       $model=Accident::model()->findByPk($id);
        $this->isFleetManagerAccident($model);
        $this->render('accident_detail',array('model'=>$model));
    }

    public function actionUpdateNotes()
    {
        $model=Accident::model()->findByPk(Yii::app()->request->getPost('accident_id'));
        $model->notes=Yii::app()->request->getPost('notes');
        $model->note_type=Yii::app()->request->getPost('note_type');
        $model->claim_cost=doubleval(Yii::app()->request->getPost('claim_cost'));

        $model->update();
    }

    public function actionPdf($id)
    {
        $this->layout='blank';
        $model=Accident::model()->findByPk($id);

        $this->render('pdf',array('model'=>$model));
    }

    public function actionDownload($id)
    {
        $accident=Accident::model()->findByPk($id);
        if(!empty($accident))
        {
            if($accident->driver->fleetmanager_id!=Yii::app()->user->id)
                throw new CHttpException(401,'You are unauthorized to download this report');

            $pageURL = Yii::app()->request->getBaseUrl(true) . '/fleetmanager/accidents/pdf/id/' . $id;
            $generatedFileName = 'accident-' . rand(0, 9999) . Yii::app()->user->id . ".pdf";


            Yii::import('application.extensions.WKHTMLTOPDF.*');
            $wkhtmltopdf = new Wkhtmltopdf(array('path'=>'uploads/reports'));
            $wkhtmltopdf->setZoom(0.9);
            $wkhtmltopdf->setMargins(array('left'=>5,'right'=>5,'top'=>5,'bottom'=>5));


            $wkhtmltopdf->setUrl($pageURL);
            $wkhtmltopdf->output(Wkhtmltopdf::MODE_DOWNLOAD, $generatedFileName);

        }
    }
}
