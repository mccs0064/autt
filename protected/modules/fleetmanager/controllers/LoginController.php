<?php

class LoginController extends CController {


    public function actionIndex() {

        if(!Yii::app()->user->isGuest)
            $this->redirect(array('/fleetmanager/dashboard'));
        $this->layout = 'login';
        $model=new SigninForm();
        $model->userType='Fleet';
        if(isset($_POST['SigninForm']))
        {
            $model->attributes=$_POST['SigninForm'];
            if($model->validate()&&$model->login())
            {
                $manager=Fleetmanager::model()->findByPk(Yii::app()->user->id);
                Yii::app()->user->setState('first_name',$manager->first_name);
                Yii::app()->user->setState('last_name',$manager->last_name);
                Yii::app()->user->setState('picture',$manager->picture);
                $this->redirect(array('/fleetmanager/dashboard'));
            }
        }
        $this->render('login',array('model'=>$model));

      }


}
