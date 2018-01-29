<?php

/**
 * This is the model class for table "daily_inspection_report".
 *
 * The followings are the available columns in table 'daily_inspection_report':
 * @property integer $id
 * @property integer $driver_id
 * @property integer $vehicle_id
 * @property integer $fleetmanager_id
 * @property string $submitted_date
 */
class DailyInspectionReport extends CActiveRecord
{
    public $totalDefects;
    public $defectUser;
    public $vehicle_type;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'daily_inspection_report';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('driver_id, vehicle_id, fleetmanager_id, submitted_date', 'required'),
			array('driver_id, vehicle_id, fleetmanager_id', 'numerical', 'integerOnly'=>true),
			array('user_type,claim_cost','safe'),
            // The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, driver_id, vehicle_id, fleetmanager_id, submitted_date,user_type,claim_cost', 'safe', 'on'=>'search'),
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
            'driver' => array(self::BELONGS_TO, 'Driver', 'driver_id'),
            'defects'=>array(self::HAS_MANY,'DailyInspectionReportItems','report_id')
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
			'vehicle_id' => 'Vehicle',
			'fleetmanager_id' => 'Fleetmanager',
			'submitted_date' => 'Submitted Date',
            'user_type'=>'User Type'
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
		$criteria->compare('driver_id',$this->driver_id);
		$criteria->compare('vehicle_id',$this->vehicle_id);
		$criteria->compare('fleetmanager_id',$this->fleetmanager_id);
		$criteria->compare('submitted_date',$this->submitted_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    public static function getTotalDefects($report_id)
    {
        $inspectionreportItems=DailyInspectionReportItems::model()->findAllByAttributes(array('report_id'=>$report_id,'inspected'=>true));
        return count($inspectionreportItems);
    }

    public static function getDefectUser($user_type,$driver_id)
    {
        if($user_type=='Driver')
        {
            $driver=Driver::model()->findByPk($driver_id);
            return $driver->full_name;
        }
        else
        {
           return 'Fleet Manager';
        }

    }

    public function allInspections()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('driver_id',$this->driver_id);
        $criteria->compare('vehicle_id',$this->vehicle_id);
        $criteria->compare('fleetmanager_id',Yii::app()->user->id);
        $criteria->compare('submitted_date',$this->submitted_date,true);
        $criteria->order='submitted_date desc';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }


    /**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DailyInspectionReport the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function inspectionReportItems()
    {
        $criteria=new CDbCriteria;
        $criteria->condition='report_id='.$this->id;
        $criteria->compare('report_id',$this->id);

        return new CActiveDataProvider('DailyInspectionReportItems', array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>500)
        ));
    }

    public function searchModel()
    {
        $criteria=new CDbCriteria;
        $range = Yii::app()->request->getQuery('range', null);
        $defects = Yii::app()->request->getQuery('defects', null);
        if($defects=='true')
        {
            $criteria->condition='t.fleetmanager_id='.Yii::app()->user->id." and defects.inspected=1";
        }
        else
        {
            $criteria->condition='t.fleetmanager_id='.Yii::app()->user->id;
        }

        $criteria->compare('t.vehicle_id',$this->vehicle_id);
        $criteria->compare('t.driver_id',$this->driver_id);
        $criteria->compare('vehicle.vehicle_type',$this->vehicle_type);
        $criteria->with=array('defects','vehicle','driver');


        if (!empty($range)) {
            $rangeData = explode(' to ', $range);
            $starting_date = !empty($rangeData[0]) ? $rangeData[0] : null;
            $ending_date = !empty($rangeData[1]) ? $rangeData[1] : null;
            if ($starting_date == $ending_date) {
                $criteria->addCondition("submitted_date like '" . $starting_date . "%'");
            } else {
                $criteria->addCondition("submitted_date>=DATE('" . $starting_date . "') and submitted_date<=DATE('" . $ending_date . "')");

            }
        }
        $criteria->together=true;
        $criteria->order='submitted_date desc';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>5000)
        ));
    }
}
