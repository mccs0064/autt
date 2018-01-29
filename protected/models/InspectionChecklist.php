<?php

/**
 * This is the model class for table "inspection_checklist".
 *
 * The followings are the available columns in table 'accident_police':
 * @property integer $id
 * @property integer $item_name
 * @property string $is_done
 * @property string $inspection_report_id
 *
 * The followings are the available model relations:
 * @property InspectionReport $inspectionReport
 */
class InspectionChecklist extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'inspection_checklist';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_name, inspection_report_id', 'required'),
			array('inspection_report_id', 'numerical', 'integerOnly'=>true),
			array('item_name', 'length', 'max'=>255),
			array('id, item_name, inspection_report_id, is_done', 'safe', 'on'=>'search'),
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
			'vehicleInspection' => array(self::BELONGS_TO, 'VehicleInspection', 'inspection_report_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'item_name' => 'Item Name',
			'is_done' => 'Is Done',
			'inspection_report_id' => 'Inspection Report ID',
		);
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InspectionChecklist the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
