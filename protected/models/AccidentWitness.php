<?php

/**
 * This is the model class for table "accident_witness".
 *
 * The followings are the available columns in table 'accident_witness':
 * @property integer $id
 * @property integer $accident_id
 * @property string $fullname
 * @property string $phone_number
 * @property string $date_of_birth
 * @property string $address
 * @property string $witness_audio_statement
 * @property string $directory_name
 *
 * The followings are the available model relations:
 * @property Accident $accident
 */
class AccidentWitness extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'accident_witness';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('accident_id, fullname, phone_number, date_of_birth, address, witness_audio_statement', 'required'),
			array('accident_id', 'numerical', 'integerOnly'=>true),
			array('fullname, phone_number, address, witness_audio_statement, directory_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, accident_id, fullname, phone_number, date_of_birth, address, witness_audio_statement, directory_name', 'safe', 'on'=>'search'),
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
			'fullname' => 'Fullname',
			'phone_number' => 'Phone Number',
			'date_of_birth' => 'Date Of Birth',
			'address' => 'Address',
			'witness_audio_statement' => 'Witness Audio Statement',
			'directory_name' => 'Directory Name',
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
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('phone_number',$this->phone_number,true);
		$criteria->compare('date_of_birth',$this->date_of_birth,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('witness_audio_statement',$this->witness_audio_statement,true);
		$criteria->compare('directory_name',$this->directory_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AccidentWitness the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
