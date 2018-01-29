<?php

class ChangepasswordController extends Controller
{

    public $layout = 'main';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index'),
                'roles' => array('Fleet'),
            )
        );
    }

    public function actionIndex()
    {

        $this->pageTitle = "Fleet Manager | Change Password";
        $model = new ChangePasswordFleet();
        if (isset($_POST['ChangePasswordFleet'])) {
            $model->attributes = $_POST['ChangePasswordFleet'];
            if ($model->validate()) {

                $user = Fleetmanager::model()->findByPk(Yii::app()->user->id);
                $user->password = CPasswordHelper::hashPassword($model->password);
                if ($user->update()) {

                    Yii::app()->user->setFlash('success', 'Your password has been changed successfully');
                    $model->unsetAttributes();
                }
            }
        }
        $this->render('changepassword', array('model' => $model));
    }


}
