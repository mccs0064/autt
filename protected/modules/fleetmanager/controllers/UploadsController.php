<?php

class UploadsController extends Controller {

    public $layout = 'main';

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('myphotos','otherphotos'),
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

    public function actionMyPhotos()
    {
        $accident_id=AccidentWizard::getAccidentUniqueID();
        $uploadDirectory=$accident_id.'/myphotos';
        AccidentWizard::setDirectory('myphotos',$accident_id);

        Yii::import('ext.multiupload.UploadHandler');
        $upload_handler = new UploadHandler(null,true,null,$uploadDirectory,'myphotos');
    }

    public function actionOtherPhotos()
    {
        $accident_id=AccidentWizard::getAccidentUniqueID();
        $uploadDirectory=$accident_id.'/otherphotos';
        AccidentWizard::setDirectory('otherphotos',$accident_id);

        Yii::import('ext.multiupload.UploadHandler');
        $upload_handler = new UploadHandler(null,true,null,$uploadDirectory,'otherphotos');
    }
}
