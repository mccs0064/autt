<?php

/**
 * This is the model class for table "accident_media".
 *
 * The followings are the available columns in table 'accident_media':
 * @property integer $id
 * @property integer $accident_id
 * @property string $vehicle_reg
 * @property string $number_of_pessengers
 *
 * The followings are the available model relations:
 * @property Accident $accident
 */
class AccidentVehicles extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'accident_vehicles';
	}

	public $driver_name;
    public $phone_number;
    public $insurer;
    public $address;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('accident_id, vehicle_reg, number_of_pessengers', 'required'),
			array('accident_id', 'numerical', 'integerOnly'=>true),
            array('driver_name,insurer,phone_number,address','length','max'=>255),
            array('driver_name,insurer,phone_number,address','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, accident_id, vehicle_reg, number_of_pessengers,driver_name,insurer,phone_number,address', 'safe', 'on'=>'search'),
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
			'accident' => array(self::BELONGS_TO, 'Accident', 'accident_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'accident_id' => 'Accident',
			'vehicle_reg' => 'Vehicle Registration Number',
			'number_of_pessengers' => 'Number of Pessengers'
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

		$criteria->compare('id',$this->id);
		$criteria->compare('accident_id',$this->accident_id);
		$criteria->compare('vehicle_reg',$this->vehicle_reg,true);
		$criteria->compare('number_of_pessengers',$this->number_of_pessengers,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AccidentVehicles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
