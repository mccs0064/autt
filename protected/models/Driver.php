<?php

/**
 * This is the model class for table "driver".
 *
 * The followings are the available columns in table 'driver':
 * @property integer $id
 * @property string $autium_id
 * @property string $password
 * @property string $full_name
 * @property string $policy_number
 * @property string $insurer
 * @property string $vehicle_reg
 * @property string $address
 * @property string $driving_license
 * @property string $dob
 * @property string $status
 * @property integer $fleetmanager_id
 * @property string $role
 * @property string $license_type
 * @property string $nationality
 * @property string $points
 * @property string $driving_convictions
 *
 * The followings are the available model relations:
 * @property Accident[] $accidents
 * @property Fleetmanager $fleetmanager
 */
class Driver extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $Update;
    public $Profile;
    public $select_driver;
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
			array('autium_id, password, full_name,status, fleetmanager_id', 'required'),
			array('fleetmanager_id', 'numerical', 'integerOnly'=>true),
            array('autium_id', 'unique', 'className' => 'Driver','message'=>'The Autium ID "{value}" is already registered with some driver. Please choose different ID.'),
			array('license_type,nationality,points,driving_convictions,autium_id, driving_license, dob,password, full_name, policy_number, insurer, vehicle_reg, address', 'length', 'max'=>255),
			array('status', 'length', 'max'=>8),
			array('role', 'length', 'max'=>6),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, autium_id, password, full_name, policy_number, insurer, vehicle_reg, address, status, fleetmanager_id, role,access_token,token_expiry', 'safe', 'on'=>'search'),
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
			'accidents' => array(self::HAS_MANY, 'Accident', 'driver_id'),
			'fleetmanager' => array(self::BELONGS_TO, 'Fleetmanager', 'fleetmanager_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'autium_id' => 'Autium ID',
			'password' => 'Password',
			'full_name' => 'Full Name',
			'policy_number' => 'Policy Number',
			'insurer' => 'Insurer',
			'vehicle_reg' => 'Vehicle Reg',
			'address' => 'Address',
            'driving_license' => 'Driving License',
            'dob' => 'Date of Birth',
			'status' => 'Status',
			'fleetmanager_id' => 'Fleetmanager',
			'role' => 'Role',
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
		$criteria->compare('autium_id',$this->autium_id,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('full_name',$this->full_name,true);
		$criteria->compare('vehicle_reg',$this->vehicle_reg,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('fleetmanager_id',Yii::app()->user->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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

}
