<?php

class RequestResetForm extends CFormModel {

    public $driver_id;
    public $autium_id;
    public $dob;
    public $driving_license;

    public function rules()
    {
        return array(
            array('autium_id', 'required'),
            array('autium_id','validateDriver'),
            array('dob,driving_license,driver_id', 'length', 'max' => 255)
        );
    }

    public function attributeLabels()
    {
        return array(
            'autium_id' => 'Autium ID',
            'password' => 'Date of Birth',
            'driving_license' => 'Driving License'
        );
    }

    public function validateDriver()
    {
        if(!$this->hasErrors())
        {
            $driver=Driver::model()->findByAttributes(array('autium_id'=>$this->autium_id));
            if(!empty($driver))
            {
                $this->driver_id=$driver->id;
                if(!empty($driver->driving_license)) {
                    if ($this->driving_license != $driver->driving_license)
                    {
                        $this->addError('autium_id','Incorrect driving license number');
                    }
                }
                if(!empty($driver->dob)) {
                    if ($this->dob != $driver->dob)
                    {
                        $this->addError('autium_id','Incorrect Date of Birth');
                    }
                }
            }
            else
            {
                $this->addError('autium_id','No driver exists with this autium_id');
            }
        }
    }

}
