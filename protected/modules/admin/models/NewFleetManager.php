<?php

/**
 * This is the model class for table "fleetmanager".
 *
 * The followings are the available columns in table 'fleetmanager':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $picture
 * @property string $role
 *
 * The followings are the available model relations:
 * @property Driver[] $drivers
 */
class NewFleetManager extends Fleetmanager
{
    public $confirmPassword;

    public function tableName()
    {
        return 'fleetmanager';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('email, password, first_name, last_name', 'required'),
            array('email', 'unique', 'className' => 'Fleetmanager','message'=>'The email "{value}" is already registered with some Fleet Manager. Please choose different email.'),
            array('password','length','min'=>6),
            array('confirmPassword', 'compare', 'compareAttribute' => 'password'),

        );
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'confirmPassword' => 'Confirm Password',
            'first_name' => 'First name',
            'last_name' => 'Last Name',
            'picture' => 'Picture',
            'role' => 'Role',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Fleetmanager the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
