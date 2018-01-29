<?php

/**
 * This is the model class for table "accident".
 *
 * The followings are the available columns in table 'accident':
 * @property integer $id
 * @property integer $driver_id
 * @property string $occured_at
 * @property double $longitude
 * @property double $latitude
 * @property string $vehicle_reg
 * @property string $make
 * @property string $model
 *
 * The followings are the available model relations:
 * @property Driver $driver
 * @property AccidentMedia[] $accidentMedias
 * @property AccidentPolice[] $accidentPolices
 * @property AccidentWitness[] $accidentWitnesses
 */
class NewAccident extends Accident
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'accident';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('occured_at, longitude, latitude, vehicle_reg, make, model', 'required'),
            array('driver_id', 'numerical', 'integerOnly'=>true),
            array('longitude, latitude', 'numerical'),
            array('vehicle_reg, make, model', 'length', 'max'=>255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, driver_id, occured_at, longitude, latitude, vehicle_reg, make, model', 'safe', 'on'=>'search'),
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
            'occured_at' => 'Occured At',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'vehicle_reg' => 'Vehicle Reg',
            'make' => 'Make',
            'model' => 'Model',
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
        $criteria->compare('occured_at',$this->occured_at,true);
        $criteria->compare('longitude',$this->longitude);
        $criteria->compare('latitude',$this->latitude);
        $criteria->compare('vehicle_reg',$this->vehicle_reg,true);
        $criteria->compare('make',$this->make,true);
        $criteria->compare('model',$this->model,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Accident the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
