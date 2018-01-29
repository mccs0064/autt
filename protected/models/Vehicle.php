<?php

/**
 * This is the model class for table "vehicle".
 *
 * The followings are the available columns in table 'vehicle':
 * @property integer $id
 * @property integer $fleetmanager_id
 * @property integer $vehicle_reg
 * @property integer $serial_number
 * @property integer $gross_vehicle_weight
 * @property integer $next_mot
 * @property integer $tax_expires
 * @property integer $inspection_template_id

 * The followings are the available model relations:
 * @property VehicleInspection[] $vehicleInspections
 */
class Vehicle extends CActiveRecord
{
    public $linkedDrivers;
    public $linked_template;
    public $select_option;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vehicle';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fleetmanager_id,make,model,vehicle_reg,vehicle_type', 'required'),
			array('fleetmanager_id', 'numerical', 'integerOnly'=>true),
            array('serial_number,gross_vehicle_weight,next_mot,tax_expires,vehicle_type,make,model,fleetmanager_id,inspection_template_id','safe'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fleetmanager_id,make,model,vehicle_reg,driver_id,vehicle_type,inspection_template_id', 'safe', 'on'=>'search'),
		);
	}


    public static function getLinkedDrivers($vehicle_id)
    {
        $vehicle_drivers=VehicleDriver::model()->findAllByAttributes(array('vehicle_id'=>$vehicle_id));
       return count($vehicle_drivers);
    }

    public static function getLinkedInspections($template_id)
    {
        if(!empty($template_id))
        {
            $model=InspectionTemplate::model()->findByPk($template_id);
            if(!empty($model))
            {
                return $model->template_name;
            }
            return null;
        }
        return null;
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'vehicleInspections' => array(self::HAS_MANY, 'VehicleInspection', 'vehicle_id'),
            'vehicleDrivers' => array(self::HAS_MANY, 'VehicleDriver', 'vehicle_id'),
            'fleetManager' => array(self::BELONGS_TO, 'Fleetmanager', 'fleetmanager_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fleetmanager_id' => 'Fleetmanager ID',
            'make'=>'Make',
            'model'=>'Model',
            'vehicle_reg'=>'Vehicle Registration Number',
            'inspection_template_id'=>'Inspection Template'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
        $criteria->condition='fleetmanager_id='.Yii::app()->user->id;

		$criteria->compare('id',$this->id);
        $criteria->compare('make',$this->make);
        $criteria->compare('model',$this->model);
        $criteria->compare('vehicle_reg',$this->vehicle_reg);
		$criteria->compare('fleetmanager_id',Yii::app()->user->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}



	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Vehicle the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getDrivers()
    {
        $drivers=array();
        $vehicleDrivers=VehicleDriver::model()->findAllByAttributes(array('vehicle_id'=>$this->id));
        if(!empty($vehicleDrivers))
        {
            foreach ($vehicleDrivers as $driver)
            {
                array_push($drivers,$driver['driver_id']);
            }
        }
        return $drivers;
    }

    public function updateDrivers($drivers)
    {
        $vehicleDrivers = VehicleDriver::model()->findAllByAttributes(array('vehicle_id' => $this->id));
        if (!empty($vehicleDrivers))
        {
            foreach($vehicleDrivers as $vD)
                $vD->delete();
        }

        if(!empty($drivers))
        {
            foreach($drivers as $driver)
            {
                $model=new VehicleDriver();
                $model->vehicle_id=$this->id;
                $model->driver_id=$driver;
                $model->save();
            }
        }
    }
}
