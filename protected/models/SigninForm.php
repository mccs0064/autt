<?php

class SigninForm extends CFormModel {

    public $email;
    public $password;
    public $social;
    public $userType;
    private $_identity;

    public function rules()
    {
        return array(
            array('email,password', 'required'),
            array('password', 'authenticate'),
        );
    }

    public function authenticate($attribute, $params)
    {

        if (!$this->hasErrors())
        {

            $this->_identity = new UserIdentity($this->email, $this->password,$this->userType);
            $this->_identity->authenticate($this->social);

            if ($this->_identity->errorCode === UserIdentity::ERROR_INACTIVE_ACCOUNT)
                $this->addError('email', 'Your account is inactive. Please get your account activated to login into your account.');

            if ($this->_identity->errorCode === UserIdentity::ERROR_BLOCKED_ACCOUNT)
                $this->addError('email', 'Your account is blocked by administrator, please contact admin at <a href="mailto:support@resumemarket.com">mailto:support@resumemarket.com</a>');


            if ($this->_identity->errorCode === UserIdentity::ERROR_PASSWORD_INVALID || $this->_identity->errorCode === UserIdentity::ERROR_USERNAME_INVALID)
                $this->addError('email', 'Incorrect email or password entered. Please try again');
        }
    }

    public function login()
    {
        if ($this->_identity === null)
        {
            $this->_identity = new UserIdentity($this->email, $this->password,$this->userType);
            $this->_identity->authenticate($this->social);
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE)
        {
            Yii::app()->user->login($this->_identity, 3600 * 24 * 7);
            return true;
        } else
            return false;
    }
    

}
