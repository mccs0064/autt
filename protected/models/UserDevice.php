<?php

/**
 * This is the model class for table "user_device".
 *
 * The followings are the available columns in table 'user_device':
 * @property integer $id
 * @property string $device_name
 * @property string $device_token
 * @property string $device_type
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property User $user
 */
class UserDevice extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user_device';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id,device_token', 'required'),
            array('device_token', 'uniqueDevice'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('device_name, device_token', 'length', 'max' => 255),
            array('device_type', 'length', 'max' => 7),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, device_name, device_token, device_type, user_id', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'device_name' => 'Device Name',
            'device_token' => 'Device Token',
            'device_type' => 'Device Type',
            'user_id' => 'User',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('device_name', $this->device_name, true);
        $criteria->compare('device_token', $this->device_token, true);
        $criteria->compare('device_type', $this->device_type, true);
        $criteria->compare('user_id', $this->user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserDevice the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    function uniqueDevice()
    {
        $device=  UserDevice::model()->findByAttributes(array('user_id'=>$this->user_id, 'device_token'=>$this->device_token));
        if(!empty($device))
        {
            $this->addError('device_token','This device is already registered with this user');
        }
        
    }

}
