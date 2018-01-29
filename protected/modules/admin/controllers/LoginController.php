<?php

class LoginController extends CController {


    public function actionIndex() {

        if(!Yii::app()->user->isGuest)
            $this->redirect(array('/admin/fleetmanagers'));
        $this->layout = 'login';
        $model=new SigninForm();
        $model->userType='Admin';
        if(isset($_POST['SigninForm']))
        {
            $model->attributes=$_POST['SigninForm'];
            if($model->validate()&&$model->login())
            {
                $this->redirect(array('/admin/fleetmanagers'));
            }
        }
        $this->render('login',array('model'=>$model));

      }

      public function actionLogout()
      {
          Yii::app()->user->logout();
          $this->redirect(array('/admin/login'));
      }


}
