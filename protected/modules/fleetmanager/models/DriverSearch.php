<?php


class DriverSearch extends Driver
{
    /**
     * @return string the associated database table name
     */
    public $Update;
    public $Profile;
    public $linked_vehicles;
    public $total_accidents;

    public static function getLinkedVehicles($driver_id)
    {
        $vehicles=VehicleDriver::model()->findAllByAttributes(array('driver_id'=>$driver_id));
        return count($vehicles);
    }

    public static function getTotalAccidents($driver_id)
    {
        $accidents=Accident::model()->findAllByAttributes(array('driver_id'=>$driver_id));
        return count($accidents);
    }

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

    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'accidents' => array(self::HAS_MANY, 'Accident', 'driver_id'),
            'fleetmanager' => array(self::BELONGS_TO, 'Fleetmanager', 'fleetmanager_id'),
            'vehicle_driver'=>array(self::HAS_MANY, 'VehicleDriver', 'driver_id')
        );
    }

    public function linkedSearch()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.


        $criteria=new CDbCriteria();
        $criteria->select='*';
        $criteria->with=array('vehicle_driver');
        $criteria->condition='vehicle_driver.vehicle_id='.$this->id." and t.fleetmanager_id=".Yii::app()->user->id;
        $criteria->together=true;

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
