<?php

class ResetPasswordForm extends CFormModel {

    public $reset_key;
    public $password;
    public $confirm_password;

    public function rules()
    {
        return array(
            array('reset_key,password, confirm_password', 'required'),
            array('confirm_password', 'compare', 'compareAttribute' => 'password'),
             array('reset_key', 'validateKey'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'reset_key' => 'Reset Key',
            'password' => 'New Password',
            'confirm_password' => 'Confirm Password'
        );
    }

    public function validateKey()
    {
        if (!$this->hasErrors())
        {
            $user = ResetRequestToken::model()->findByAttributes(array('token' => $this->reset_key));
            if (empty($user))
                $this->addError('reset_key', 'Invalid reset key or it has been expired');
        }
    }

}
