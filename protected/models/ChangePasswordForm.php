<?php

class ChangePasswordForm extends CFormModel {

    public $email;
    public $password;
    public $confirmPassword;

    public function rules() {
        return array(
            array('email,password,confirmPassword', 'required', 'on' => 'normalUser'),
            array('confirmPassword', 'compare', 'compareAttribute' => 'password'),
            array('password', 'length', 'min' => 6, 'max' => 40)
        );
    }

    public function attributeLabels() {
        return array(
            'password' => 'Password',
            'confirmPassword' => 'Confirm Password',
            'email' => 'Email',
        );
    }

}
