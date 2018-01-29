<?php

class ChangePasswordFleet extends CFormModel {

    public $current_password;
    public $password;
    public $confirmPassword;

    public function rules() {
        return array(
            array('current_password,password,confirmPassword','required'),
            array('confirmPassword', 'compare', 'compareAttribute' => 'password'),
            array('password','checkUserPassword'),
            array('password', 'length', 'min' => 6, 'max' => 40)
        );
    }

    public function attributeLabels() {
        return array(
            'current_password',
            'password' => 'New Password',
            'confirmPassword' => 'Confirm Password',
            'email' => 'Email',
        );
    }
    public function checkUserPassword() {
        if (!$this->hasErrors()) {
            $user = Fleetmanager::model()->findByPk(Yii::app()->user->id);
            if (!CPasswordHelper::verifyPassword($this->current_password, $user->password))
                $this->addError('current_password', 'Your current password is incorrect');
        }
    }
}
