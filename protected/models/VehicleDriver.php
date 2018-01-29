<?php

/**
 * This is the model class for table "vehicle_driver".
 *
 * The followings are the available columns in table 'vehicle_driver':
 * @property integer $id
 * @property integer $vehicle_id
 * @property integer $driver_id
 */
class VehicleDriver extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vehicle_driver';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vehicle_id, driver_id', 'required'),
			array('vehicle_id, driver_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, vehicle_id, driver_id', 'safe', 'on'=>'search'),
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
            'vehicle' => array(self::BELONGS_TO, 'Vehicle', 'vehicle_id'),
            'driver' => array(self::BELONGS_TO, 'Driver', 'driver_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'vehicle_id' => 'Vehicle',
			'driver_id' => 'Driver',
		);
	}

    public function driverVehicles($driver_id)
    {
        $criteria=new CDbCriteria;


        $criteria->condition='t.driver_id='.$driver_id;
        $criteria->with=array('vehicle');
        $criteria->addCondition('vehicle.fleetmanager_id='.Yii::app()->user->id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
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

		$criteria->compare('id',$this->id);
		$criteria->compare('vehicle_id',$this->vehicle_id);
		$criteria->compare('driver_id',$this->driver_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VehicleDriver the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
