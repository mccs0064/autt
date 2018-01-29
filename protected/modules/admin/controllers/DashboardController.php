<?php

class DashboardController extends Controller {

    public $layout = 'main';

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index','logout'),
                'roles' => array('Admin'),
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

        $this->pageTitle='Admin-Dashboard';
         $this->render('dashboard');
    }



    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(array('/admin'));
    }

}
