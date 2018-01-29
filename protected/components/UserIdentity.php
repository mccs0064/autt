<?php

class UserIdentity extends CUserIdentity {

    private $_id;
    public $email;
    public $password;
    public $userType;

    const ERROR_NONE = 0;
    const ERROR_USERNAME_INVALID = 1;
    const ERROR_PASSWORD_INVALID = 2;
    const ERROR_UNKNOWN_IDENTITY = 100;
    const ERROR_INACTIVE_ACCOUNT = 3;
    const ERROR_BLOCKED_ACCOUNT = 4;

    public function __construct($username, $password, $userType) {
        $this->username = $username;
        $this->password = $password;
        $this->userType = $userType;
        parent::__construct($username, $password);
    }

    public function authenticate($social = false) {


        switch ($this->userType) {            
            case 'Admin':
                $user = Admin::model()->findByAttributes(array("email" => $this->username));
                break;
            case 'Driver':
                $user = Driver::model()->findByAttributes(array("autium_id" => $this->username));
                break;
            case 'Fleet':
                $user = Fleetmanager::model()->findByAttributes(array("email" => $this->username));
                break;
            default :
                $user = Driver::model()->findByAttributes(array("email" => $this->username));
                break;
        }

        if ($user) {
            if (!CPasswordHelper::verifyPassword($this->password, $user->password)) {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            } else {
                 if(!empty($user['status']))
                 {
                     if($user['status']=='Pending'||$user['status']=='Inactive')
                         $this->errorCode = self::ERROR_INACTIVE_ACCOUNT;
                     else
                     {
                         $this->_id = $user->id;
                         $this->setState('roles', $user->role);
                         $this->errorCode = self::ERROR_NONE;
                     }
                 }
                 else
                 {
                     $this->_id = $user->id;
                     $this->setState('roles', $user->role);
                     if($user->role=='Fleet')
                     {
                         Yii::app()->user->setState('first_name',$user->first_name);
                         Yii::app()->user->setState('last_name',$user->last_name);
                     }
                     $this->errorCode = self::ERROR_NONE;
                 }

            }

        } else {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }

        return !$this->errorCode;
    }

    public function getId() {
        return $this->_id;
    }

}
