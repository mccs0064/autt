<?php


class DriverInfo extends AccidentWizard
{

    public $driver_name;
    public $address;
    public $phone_number;
    public $insurer;
    public $reg;

    public function rules() {
        return array(
            array('driver_name,address,phone_number,insurer,reg','safe')
        );
    }

    public function attributeLabels()
    {
       return array(
           'driver_name'=>'Driver Name',
           'address'=>'Address',
           'phone_number'=>'Phone Number',
           'insurer'=>'Insurer',
           'reg'=>'Registration Number',
       );
    }
}
