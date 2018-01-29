<?php

class PasswordRequestsController extends Controller {

    public $layout = 'main';

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index','add','detail'),
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

        $this->pageTitle='Fleet Manager-Password Requests';
        $model=new ForgotPasswordRequests();
        if(isset($_GET['ForgotPasswordRequests']))
        {
            $model->attributes=$_GET['ForgotPasswordRequests'];
        }
         $this->render('all_requests',array('model'=>$model));
    }

}
