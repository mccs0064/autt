<?php

class DriverController extends APIController {

    public function actionIndex()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'DELETE':
                break;
            case 'GET':
                $this->getDriverProfile();
                break;
            default:
                break;
        }
    }

    public function getDriverProfile()
    {
        $driver_id=$this->_getUser();
        $driver=Yii::app()->helper->getDriverDetails($driver_id);
        $this->sendData($driver);
    }

    public function actionLogin()
    {
        $model = new LoginForm;
        $model->attributes = $_POST;
        $model->email_address = Yii::app()->request->getPost('autium_id',null);
        $password=Yii::app()->request->getPost('password',null);
        if($password)
        {
            $model->password = Yii::app()->helper->decodePassword($_POST['password']);
        }

        $model->userType='Driver';

        if ($model->validate())
        {
            if ($model->login())
            {
                $user = Driver::model()->findByAttributes(array('autium_id' => $model->email_address));
                Yii::app()->helper->getAccessToken($user->autium_id);
                $this->setPreferences($user->id);
                $this->sendData(Yii::app()->helper->getDriverDetails($user->id));
            }
        } else
        {
            $validation_errors = Yii::app()->helper->getModelErrors($model->getErrors());
            if (!empty($validation_errors))
            {
                $this->sendError($validation_errors);
            }
        }
    }

    public function actionForgotPassword()
    {
        $model=new ForgotPasswordRequests();
        $model->email=Yii::app()->request->getPost('email',null);
        if($model->validate())
        {
            $driver=Driver::model()->findByAttributes(array('email'=>$model->email));

            $model->date_requested=new CDbExpression('NOW()');
            $model->status='Pending';
            $model->fleetmanager_id=$driver->fleetmanager_id;
            $model->save();
            $this->sendData('Your request has been received. The fleet manager will reset your password and notify you.');
        }
        else
        {
            $errors=Yii::app()->helper->getModelErrors($model->getErrors());
            $this->sendError($errors);
        }
    }

    public function actionResetPassword()
    {
        $model=new RequestResetForm();

        $model->autium_id=Yii::app()->request->getPost('autium_id',null);
        $model->dob=Yii::app()->request->getPost('dob',null);
        $model->driving_license=Yii::app()->request->getPost('driving_license',null);
        if($model->validate())
        {
            $request=new ResetRequestToken();
            $request->driver_id=$model->driver_id;

            $token = Yii::app()->getSecurityManager()->generateRandomString(40, false) . $model->driver_id;
            $currentDate = date('Y-m-d H:i:s');
            $request->token=$token;
            $request->expiry=date('Y-m-d H:i:s', strtotime($currentDate . ' + 10 minutes'));
            $request->created_at=new CDbExpression('NOW()');
            $request->save();
            $response=array();
            $response['reset_key']=$token;
            $this->sendData($response);
        }
        else
        {
            $validation_errors = Yii::app()->helper->getModelErrors($model->getErrors());
            if (!empty($validation_errors))
            {
                $this->sendError($validation_errors);
            }
        }
    }

    public function actionChangePassword()
    {
        $model = new ResetPasswordForm();
        $model->reset_key=Yii::app()->request->getPost('reset_key',null);
        $model->password=Yii::app()->request->getPost('password',null);
        $model->confirm_password=Yii::app()->request->getPost('confirm_password',null);
        if($model->validate())
        {
            $keyDetails=ResetRequestToken::model()->findByAttributes(array('token'=>$model->reset_key));
            $driver_id=$keyDetails->driver_id;
            $user = Driver::model()->findByPk($driver_id);
            $user->password = CPasswordHelper::hashPassword($model->password);
            $user->update();
            $this->sendData('Password has been changed');
        }
        else
        {
            $validation_errors = Yii::app()->helper->getModelErrors($model->getErrors());
            if (!empty($validation_errors))
            {
                $this->sendError($validation_errors);
            }
        }
    }

    public function actionPreferences()
    {
        $driver_id=$this->_getUser();
        $preferences=$this->getPreferences($driver_id);
        $this->sendData($preferences);
    }

    private function getPreferences($driver_id)
    {
        $preferences=Preferences::model()->findByAttributes(array('driver_id'=>$driver_id));
        $response=array();
        if(!empty($preferences))
        {
            $response['id']=$preferences['id'];
            $response['push_notifications']=$preferences['push_notifications'];
        }
        return $response;
    }

    public function actionUpdatePreferences()
    {
        $driver_id=$this->_getUser();
        $preferences=Preferences::model()->findByAttributes(array('driver_id'=>$driver_id));
        $preferences->push_notifications=Yii::app()->request->getPost('push_notifications',null);
        if($preferences->update())
        {
            $pref=$this->getPreferences($driver_id);
            $this->sendData($pref);
        }
    }

    private function setPreferences($driver_id)
    {
        $preferencesExist=Preferences::model()->findByAttributes(array('driver_id'=>$driver_id));
        if(empty($preferencesExist))
        {
            $model=new Preferences();
            $model->push_notifications='Yes';
            $model->driver_id=$driver_id;
            $model->save();
        }
    }
}
