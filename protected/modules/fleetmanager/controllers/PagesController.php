<?php

class PagesController extends Controller {

    public $layout = 'main';

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('privacypolicy','terms','subscription'),
                'roles' => array('Fleet','Admin'),
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

    public function actionSubscription()
    {
        if(Yii::app()->user->roles=='Admin')
            $this->layout='admin';
        $this->render('subscription');
    }

    public function actionPrivacyPolicy()
    {
        if(Yii::app()->user->roles=='Admin')
            $this->layout='admin';
        $this->render('privacy_policy');
    }

    public function actionTerms()
    {
        if(Yii::app()->user->roles=='Admin')
            $this->layout='admin';
        $this->render('terms');
    }


}
