<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public $layout = 'main';

    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {

       $this->redirect(array('/fleetmanager/login'));
    }


    public function actionError() {


        if ($error = Yii::app()->errorHandler->error) {

            $this->pageTitle = "Error " . $error['code'] . " | " . Yii::app()->name;
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                CVarDumper::dump($error,10,1);exit;
//                $this->render('error', $error);
        }
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }



}
