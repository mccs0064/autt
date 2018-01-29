<?php

class QuarterlyInspection extends VehicleInspection  {

    public $vehicle_id;
    public $driver_id;
    public $due_date;

    public function rules() {
        return array(
           array('vehicle_id,driver_id','required'),
            array('driver_id','hasChecklist'),
            array('due_date','safe')
        );
    }

    public function hasChecklist()
    {
        if(!$this->hasErrors())
        {
            if(!empty($_POST['checklists']))
            {
                if(empty($_POST['checklists'][0]))
                    $this->addError('driver_id','Please enter at least one checklist item');
            }
        }
    }

    public function attributeLabels()
    {
        return array(
            'driver_id'=>'Driver',
            'vehicle_id'=>'Vehicle'
        );
    }
}
