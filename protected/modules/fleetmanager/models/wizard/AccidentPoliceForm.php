<?php


class AccidentPoliceForm extends AccidentWizard
{
    public $officer_name='N/A';
    public $police_station='N/A';
    public $phone_number='N/A';
    public $batch_number='N/A';
    public function rules() {
        return array(
            array('officer_name', 'required'),
            array('police_station,phone_number,batch_number','safe')
        );
    }

    public function attributeLabels()
    {
        return array('batch_number'=>'Officer Badge Number');
    }

}
