<?php

/**
 * This is the model class for table "vehicle_inspection".
 *
 * The followings are the available columns in table 'vehicle_inspection':
 * @property integer $id
 * @property integer $vehicle_id
 * @property integer $driver_id
 * @property integer $inspection_type
 * @property string $due_date
 * @property string $notification_date
 * @property string $status
 * @property string $directory_name
 * @property string $image1
 * @property string $image2
 * @property string $notes
 * @property string $vehicle_reg
 *
 * The followings are the available model relations:
 * @property Vehicle $vehicle
 */
class VehicleInspection extends CActiveRecord
{
    public $fleetManagerId;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'vehicle_inspection';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('driver_id', 'required'),
            array('vehicle_id','required','on'=>'daily'),
            array('notes,image1,image2', 'required', 'on' => 'updateReport'),
            array('status', 'length', 'max' => 9),
            array('directory_name, image1, image2', 'length', 'max' => 255),
            array('driver_id', 'checklistItems', 'on' => 'saveDaily'),
            array('driver_id', 'checklistItems', 'on' => 'Trailer'),
            array('vehicle_reg','required','on'=>'Trailer'),
//            // The following rule is used by search().
//            // @todo Please remove those attributes that should not be searched.
            array('id, vehicle_id, due_date,vechile_reg notification_date,submitted_date, driver_id, inspection_type,status, directory_name, image1, image2, notes', 'safe', 'on' => 'search'),
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
            'inspectionChecklists' => array(self::HAS_MANY, 'InspectionChecklist', 'inspection_report_id'),
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
            'due_date' => 'Due Date',
            'notification_date' => 'Notification Date',
            'inspection_type' => 'Inspection Type',
            'driver_id' => 'driver_id',
            'status' => 'Status',
            'directory_name' => 'Directory Name',
            'image1' => 'Inspection Image 1',
            'image2' => 'Inspection Image 2',
            'notes' => 'Notes',
            'vehicle_reg' => 'Vehicle Registration'
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
        $criteria->compare('vehicle_id', $this->vehicle_id);
        $criteria->compare('due_date', $this->due_date, true);
        $criteria->compare('submitted_date', $this->submitted_date, true);
        $criteria->compare('notification_date', $this->notification_date, true);
        $criteria->compare('driver_id', $this->driver_id, true);
        $criteria->compare('inspection_type', $this->inspection_type, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('directory_name', $this->directory_name, true);
        $criteria->compare('image1', $this->image1, true);
        $criteria->compare('image2', $this->image2, true);
        $criteria->compare('notes', $this->notes, true);
        $criteria->order='id desc';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function adminSearch()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->with = array('vehicle');
        $criteria->condition = "vehicle.fleetmanager_id=" . $this->fleetManagerId;

        $criteria->compare('id', $this->id);
        $criteria->compare('vehicle_id', $this->vehicle_id);
        $criteria->compare('due_date', $this->due_date, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('directory_name', $this->directory_name, true);
        $criteria->compare('image1', $this->image1, true);
        $criteria->compare('image2', $this->image2, true);
        $criteria->compare('notes', $this->notes, true);
        $criteria->compare('vehicle_reg', $this->notes, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return VehicleInspection the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function checklistItems()
    {
        if(!$this->hasErrors())
        {
            if(empty($_POST['item_name']))
                $this->addError('driver_id','Please add at least one checklist item');
        }
    }
}
