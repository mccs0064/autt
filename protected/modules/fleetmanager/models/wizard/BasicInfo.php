<?php

/**
 * @property integer $driver_id
 * @property integer $vehicle_id
 * @property string $occured_at
 * @property double $longitude
 * @property double $latitude
 * @property string $vehicle_reg
 * @property string $make
 * @property string $model
 * @property string $oldLocation
 */
class BasicInfo extends AccidentWizard
{

    public $driver_id;
    public $occured_at;
    public $location;
    public $vehicle_id;
    public $oldLocation;
    public $longitude;
    public $latitude;
    public $weather_condition;

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('vehicle_id,driver_id,occured_at,weather_condition,location', 'required'),
            array('location','validateLocation'),
            array('driver_id', 'numerical', 'integerOnly'=>true),
            array('longitude, latitude', 'numerical'),
            array('occured_at,weather_condition', 'length', 'max'=>255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, driver_id, occured_at, longitude, latitude, vehicle_reg, make, model', 'safe', 'on'=>'search'),
        );
    }

    public function attributeLabels()
    {
       return array(
           'driver_id'=>'Driver',
           'vechile_id'=>'Vechile Reg',
           'occured_at'=>'Accident Date & Time',
           'location'=>'Location'
       );
    }

    public function validateLocation()
    {
//        if(!empty($this->location))
//        {
//            if($this->oldLocation!=$this->location)
//            {
//                $response=Yii::app()->commons->getLongLatFromLocation($this->location);
//                if(!empty($response['longitude']))
//                {
//                    $this->longitude=$response['longitude'];
//                }
//                if(!empty($response['latitude']))
//                {
//                    $this->latitude=$response['latitude'];
//                }
//            }
//
//        }
    }
}
