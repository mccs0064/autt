<?php

class ContactForm extends CFormModel {

    public $name;
    public $email;
    public $subject;
    public $message;
    public $verifyCode;

    public function rules() {
        return array(
// name, email, subject and body are required
            array('name, email, subject, message', 'required'),
// email has to be a valid email address
            array('email', 'email'),
// verifyCode needs to be entered correctly
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
        );
    }

    public function attributeLabels() {
        return array(
            'verifyCode' => 'Verification Code',
        );
    }

}
