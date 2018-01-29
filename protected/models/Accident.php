<?php

/**
 * This is the model class for table "accident".
 *
 * The followings are the available columns in table 'accident':
 * @property integer $id
 * @property integer $driver_id
 * @property string $occured_at
 * @property double $longitude
 * @property double $latitude
 * @property double $location
 * @property string $vehicle_reg
 * @property string $make
 * @property string $model
 * @property string $notes
 * @property string $note_type
 * @property string $weather_condition
 *
 * The followings are the available model relations:
 * @property Driver $driver
 * @property AccidentMedia[] $accidentMedias
 * @property AccidentPolice[] $accidentPolices
 * @property AccidentWitness[] $accidentWitnesses
 * @property AccidentWitness[] $involvedVehicles
 */
class Accident extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $fleetManagerId;
    public $note_type;
    public $total;
    public $occured_month;
    public $occured_year;

	public function tableName()
	{
		return 'accident';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('driver_id, vehicle_reg, make, model,occured_at', 'required'),
			array('driver_id', 'numerical', 'integerOnly'=>true),
			array('longitude, latitude,claim_cost', 'numerical'),
            array('notes,note_type,weather_condition,claim_cost','safe'),
			array('vehicle_reg, make, model,location,note_type,weather_condition,source', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, driver_id, occured_at,weather_condition, location,longitude, notes,latitude,weather_condition, vehicle_reg, make, model,source', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'driver' => array(self::BELONGS_TO, 'Driver', 'driver_id'),
			'accidentMedias' => array(self::HAS_MANY, 'AccidentMedia', 'accident_id'),
			'accidentPolices' => array(self::HAS_MANY, 'AccidentPolice', 'accident_id'),
			'accidentWitnesses' => array(self::HAS_MANY, 'AccidentWitness', 'accident_id'),
            'involvedVehicles' => array(self::HAS_MANY, 'AccidentVehicles', 'accident_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'driver_id' => 'Driver',
            'location'=>'location',
			'occured_at' => 'Occured At',
			'longitude' => 'Longitude',
			'latitude' => 'Latitude',
			'vehicle_reg' => 'Vehicle Reg',
			'make' => 'Make',
			'model' => 'Model',
            'notes'=>'notes'
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
        $criteria->with=array('driver');
        $criteria->condition='driver.fleetmanager_id='.Yii::app()->user->id;
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.driver_id',$this->driver_id);
		$criteria->compare('t.occured_at',$this->occured_at,true);
		$criteria->compare('t.longitude',$this->longitude);
		$criteria->compare('t.latitude',$this->latitude);
		$criteria->compare('t.vehicle_reg',$this->vehicle_reg,true);
		$criteria->compare('t.make',$this->make,true);
		$criteria->compare('t.model',$this->model,true);
        $criteria->compare('t.weather_condition',$this->model,true);
        $criteria->order='t.occured_at desc';


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function adminSearch()
    {
        $criteria=new CDbCriteria;

        $criteria->with=array('driver');
        $criteria->condition='driver.fleetmanager_id='.$this->fleetManagerId;
        $criteria->compare('driver_id',$this->driver_id);
        $criteria->compare('occured_at',$this->occured_at,true);
        $criteria->compare('longitude',$this->longitude);
        $criteria->compare('latitude',$this->latitude);
        $criteria->compare('vehicle_reg',$this->vehicle_reg,true);
        $criteria->compare('make',$this->make,true);
        $criteria->compare('model',$this->model,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Accident the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getAccidentVehiclesCount($accident_id)
    {
        $model=AccidentVehicles::model()->findAllByAttributes(array('accident_id'=>$accident_id));
        return count($model);
    }

    public static function getVehicleTypeInAccident($reg)
    {
        $model=Vehicle::model()->findByAttributes(array('vehicle_reg'=>$reg,'fleetmanager_id'=>Yii::app()->user->id));
        if(!empty($model))
        {
            return $model->vehicle_type;
        }
        return '';
    }

}
