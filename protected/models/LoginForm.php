<?php

class LoginForm extends CFormModel {

    public $email_address;
    public $password;
    private $_identity;
    public $userType;
    public $rememberMe;

    public function rules()
    {
        return array(
            array('email_address,password', 'required'),
            array('password', 'authenticate'),
        );
    }

    public function authenticate($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            $this->_identity = new UserIdentity($this->email_address, $this->password,$this->userType);
            $this->_identity->authenticate();

            if ($this->_identity->errorCode === UserIdentity::ERROR_INACTIVE_ACCOUNT)
                $this->addError('password', 'Your account is currently inactive. Once your account is active then you can login into the app');

            if ($this->_identity->errorCode === UserIdentity::ERROR_PASSWORD_INVALID || $this->_identity->errorCode === UserIdentity::ERROR_USERNAME_INVALID)
                $this->addError('password', 'Incorrect email or password entered. Please try again');
        }
    }

    public function login()
    {
        if ($this->_identity === null)
        {
            $this->_identity = new UserIdentity($this->email_address, $this->password,$this->userType);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE)
        {
            
            Yii::app()->user->login($this->_identity,24*3600);
            return true;
        } else
            return false;
    }
    

}
