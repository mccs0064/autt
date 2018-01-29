<?php

/**
 * This is the model class for table "inspection_template".
 *
 * The followings are the available columns in table 'inspection_template':
 * @property integer $id
 * @property string $template_name
 * @property integer $fleetmanager_id
 * @property string $created_at
 * @property string $udpated_at
 */
class InspectionTemplate extends CActiveRecord
{
    public $total_defects;
    public $linked_vehicles;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'inspection_template';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('template_name, fleetmanager_id', 'required'),
			array('fleetmanager_id', 'numerical', 'integerOnly'=>true),
			array('template_name', 'length', 'max'=>255),
			array('created_at, udpated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, template_name, fleetmanager_id, created_at, udpated_at', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'template_name' => 'Template Name',
			'fleetmanager_id' => 'Fleetmanager',
			'created_at' => 'Created At',
			'udpated_at' => 'Udpated At',
		);
	}


    public static function getTotalDefects($template_id)
    {
        $total_defects=InspectionTemplateItems::model()->findAllByAttributes(array('template_id'=>$template_id));
        return count($total_defects);
    }

    public static function getLinkedVehicles($template_id)
    {
        $criteria=new  CDbCriteria();
        $criteria->select='id';
        $criteria->condition='inspection_template_id='.$template_id;
        $vehicleCount=Vehicle::model()->count($criteria);
        return $vehicleCount;
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
		$criteria->compare('template_name',$this->template_name,true);
		$criteria->compare('fleetmanager_id',$this->fleetmanager_id);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('udpated_at',$this->udpated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InspectionTemplate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function allTemplates()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('template_name',$this->template_name,true);
        $criteria->compare('fleetmanager_id',Yii::app()->user->id);
        $criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('udpated_at',$this->udpated_at,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
