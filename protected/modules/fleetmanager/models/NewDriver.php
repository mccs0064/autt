<?php

/**
 * This is the model class for table "driver".
 *
 * The followings are the available columns in table 'driver':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $full_name
 * @property string $policy_number
 * @property string $insurer
 * @property string $vehicle_reg
 * @property string $address
 * @property string $status
 * @property integer $fleetmanager_id
 * @property string $role
 *
 * The followings are the available model relations:
 * @property Accident[] $accidents
 * @property Fleetmanager $fleetmanager
 */
class NewDriver extends Driver
{

    public $confirmPassword;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'driver';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('full_name,dob,driving_license', 'required'),
            array('password','required','on'=>'newUser'),
//            array('password','length','min'=>6,'on','newUser'),
            array('confirmPassword', 'compare', 'compareAttribute' => 'password','on'=>'newUser'),
            array('status','safe'),
            array('license_type,nationality,points,driving_convictions,autium_id, driving_license, dob,password, full_name, policy_number, insurer, vehicle_reg, address', 'length', 'max'=>255),

            );
	}

	public function attributeLabels()
    {
        return array('full_name'=>'Driver Name','dob'=>'Date of Birth');
    }

    /**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Driver the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    public function updateVehicles($vehicles)
    {
        $vehicleDrivers = VehicleDriver::model()->findAllByAttributes(array('driver_id' => $this->id));
        if (!empty($vehicleDrivers))
        {
            foreach($vehicleDrivers as $vD)
                $vD->delete();
        }

        if(!empty($vehicles))
        {
            foreach($vehicles as $vehicle)
            {
                $model=new VehicleDriver();
                $model->driver_id=$this->id;
                $model->vehicle_id=$vehicle;
                $model->save();
            }
        }
    }

    public function getVehicles()
    {
        $vehicles=array();
        $vehicleDrivers=VehicleDriver::model()->findAllByAttributes(array('driver_id'=>$this->id));
        if(!empty($vehicleDrivers))
        {
            foreach ($vehicleDrivers as $vehicle)
            {
                array_push($vehicles,$vehicle['vehicle_id']);
            }
        }
        return $vehicles;
    }
}
