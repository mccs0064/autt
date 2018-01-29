<?php

/**
 * This is the model class for table "accident_police".
 *
 * The followings are the available columns in table 'accident_police':
 * @property integer $id
 * @property integer $accident_id
 * @property string $officer_name
 * @property string $police_station
 * @property string $phone_number
 *
 * The followings are the available model relations:
 * @property Accident $accident
 */
class AccidentPolice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'accident_police';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('accident_id, officer_name, police_station, phone_number', 'required'),
			array('accident_id', 'numerical', 'integerOnly'=>true),
			array('officer_name, police_station, phone_number,batch_number', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, accident_id, officer_name, police_station,batch_number, phone_number', 'safe', 'on'=>'search'),
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
			'officer_name' => 'Officer Name',
			'police_station' => 'Police Station',
			'phone_number' => 'Phone Number',
            'batch_number'=>'Badge Number'
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
		$criteria->compare('officer_name',$this->officer_name,true);
		$criteria->compare('police_station',$this->police_station,true);
		$criteria->compare('phone_number',$this->phone_number,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AccidentPolice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
