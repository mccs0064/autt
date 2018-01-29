<?php

class DashboardCharts {

    public static function getAllDrivers()
    {
        $drivers=Driver::model()->findAllByAttributes(array('fleetmanager_id'=>Yii::app()->user->id));
        return $drivers;
    }
    public static function getAllVehicles()
    {
        $vehicles=Vehicle::model()->findAllByAttributes(array('fleetmanager_id'=>Yii::app()->user->id));
        foreach ($vehicles as $key=>$vehicle)
        {
            $vehicles[$key]['select_option']=$vehicle['vehicle_reg'].'-'.$vehicle['make'];
        }
        return $vehicles;
    }

    public static function accidentsPerDriverBar($range)
    {
        $criteria=new CDbCriteria();
        $criteria->select='count(t.id) as total';
        $criteria->with=array('driver');
        $criteria->group='t.driver_id';
        $driver_id=Yii::app()->request->getQuery('driver_id',null);
        $criteria->condition='driver.fleetmanager_id='.Yii::app()->user->id;
        if(!empty($driver_id))
        {
            $criteria->addCondition('t.driver_id='.$driver_id);
        }
        if (!empty($range)) {
            $rangeData = explode(' to ', $range);
            $starting_date = !empty($rangeData[0]) ? $rangeData[0] : null;
            $ending_date = !empty($rangeData[1]) ? $rangeData[1] : null;
            if ($starting_date == $ending_date) {
                $criteria->addCondition("occured_at like '" . $starting_date . "%'");
            } else {
                $criteria->addCondition("occured_at>=DATE('" . $starting_date . "') and occured_at<=DATE('" . $ending_date . "')");

            }
        }
        $criteria->order='total desc';

        $result=Accident::model()->findAll($criteria);


        $reponse=array();
        if(!empty($result))
        {
            foreach($result as $item)
            {
                $driver=$item->driver;
                $driver_unique_name=$driver->autium_id."-".$driver->full_name;
                $element=array();
                array_push($element,$driver_unique_name);
                array_push($element,intval($item['total']));
                array_push($reponse,$element);
            }
        }
        return CJSON::encode($reponse);
    }

    public static function accidentsPerDriverLine()
    {
        $criteria=new CDbCriteria();
        $criteria->select="count(t.id) as total,occured_at";
        $criteria->condition='driver.fleetmanager_id='.Yii::app()->user->id;
        $criteria->group='driver_id,DATE_FORMAT(occured_at, \'%Y%m\')';
        $criteria->with=array('driver');
        $criteria->order='occured_at asc';
        $driver_id=Yii::app()->request->getQuery('driver_id',null);
        if(!empty($driver_id))
        {
            $criteria->addCondition('t.driver_id='.$driver_id);
        }

        $result=Accident::model()->findAll($criteria);
        $reponse=array();
        $drivers=array();
        if(!empty($result))
        {
            $reponse[0]=array('x');
            foreach($result as $key=>$item)
            {
                array_push($reponse[0],date('Y-m',strtotime($item->occured_at)));
                if(!array_key_exists($item->driver->full_name,$drivers))
                    array_push($drivers,$item->driver->full_name);
            }
            $drivers=array_values(array_unique($drivers));

            if(!empty($drivers))
            {
                foreach($drivers as $driver)
                {
                    array_push($reponse,array($driver));
                }
            }

            foreach ($result as $key=>$item)
            {
                foreach($reponse as $innerKey=> $element) {
                    $nameBox = $reponse[$innerKey][0];
                    if ($nameBox == $item->driver->full_name)
                    {
                        array_push($reponse[$innerKey],$item->total);
                    }
                }
            }
        }
        return CJSON::encode($reponse);
    }

    public static function accidentsPerMonthLine($range)
    {
        if (!empty($range)) {
            $rangeData = explode(' to ', $range);
            $starting_date = !empty($rangeData[0]) ? $rangeData[0] : null;
            $ending_date = !empty($rangeData[1]) ? $rangeData[1] : null;
            if ($starting_date == $ending_date) {
                $query="SELECT driver.fleetmanager_id,COUNT(*) as total,DATE_FORMAT(occured_at, '%Y-%m-%d') as occured_at  FROM accident left join driver on accident.driver_id=driver.id where driver.fleetmanager_id=".Yii::app()->user->id." AND YEAR(occured_at) =  YEAR(CURDATE()) AND occured_at like '" . $starting_date . "%' GROUP BY  MONTH(occured_at)";
            } else {
                $query="SELECT driver.fleetmanager_id,COUNT(*) as total,DATE_FORMAT(occured_at, '%Y-%m-%d') as occured_at  FROM accident left join driver on accident.driver_id=driver.id where driver.fleetmanager_id=".Yii::app()->user->id." AND YEAR(occured_at) =  YEAR(CURDATE()) AND occured_at>=DATE('" . $starting_date . "') and occured_at<=DATE('" . $ending_date . "') GROUP BY  MONTH(occured_at)";
            }
        }
        else
        {
            $query="SELECT driver.fleetmanager_id,COUNT(*) as total,DATE_FORMAT(occured_at, '%Y-%m-%d') as occured_at  FROM accident left join driver on accident.driver_id=driver.id where driver.fleetmanager_id=".Yii::app()->user->id." GROUP BY  Year(occured_at) order by occured_at asc";
        }

        $result=Yii::app()->db->createCommand($query)->queryAll();
        $reponse=array();
        if(!empty($result))
        {

            $dates=array();
            $counts=array();
            array_push($dates,'x');
            array_push($counts,'Claims');
            foreach($result as $item)
            {
                array_push($dates,$item['occured_at']);
                array_push($counts,$item['total']);
            }
            array_push($reponse,$dates);
            array_push($reponse,$counts);
        }
        return CJSON::encode($reponse);
    }

    public static function accidentsPerMonthBar($range)
    {
        $criteria=new CDbCriteria();
        $criteria->select='count(t.id) as total,occured_at';
        $criteria->with=array('driver');
        $criteria->condition='driver.fleetmanager_id='.Yii::app()->user->id;
        $criteria->group='DATE_FORMAT(t.occured_at, \'%m\') asc,DATE_FORMAT(t.occured_at, \'%Y\')';
        if (!empty($range)) {
            $rangeData = explode(' to ', $range);
            $starting_date = !empty($rangeData[0]) ? $rangeData[0] : null;
            $ending_date = !empty($rangeData[1]) ? $rangeData[1] : null;
            if ($starting_date == $ending_date) {
                $criteria->addCondition("t.occured_at like '" . $starting_date . "%'");
            } else {
                $criteria->addCondition("t.occured_at>=DATE('" . $starting_date . "') and t.occured_at<=DATE('" . $ending_date . "')");

            }
        }
        $criteria->order='t.occured_at asc';

        $result=Accident::model()->findAll($criteria);
        $reponse=array();
        if(!empty($result))
        {
            foreach($result as $item)
            {
                $element=array();
                array_push($element,date('Y-m',strtotime($item->occured_at)));
                array_push($element,intval($item['total']));
                array_push($reponse,$element);
            }
        }
        return CJSON::encode($reponse);
    }

    public static function AccidentsByVehicle()
    {

        $criteria=new CDbCriteria();
        $criteria->select='t.vehicle_reg,count(t.id) as total';
        $criteria->with=array('driver');
        $criteria->condition='driver.fleetmanager_id='.Yii::app()->user->id;
        $criteria->group='t.vehicle_reg';
        $vehicle_reg=Yii::app()->request->getQuery('reg',null);
        if(!empty($vehicle_reg))
        {
            $criteria->addCondition('t.vehicle_reg="'.$vehicle_reg.'"');
        }
        if (!empty($range)) {
            $rangeData = explode(' to ', $range);
            $starting_date = !empty($rangeData[0]) ? $rangeData[0] : null;
            $ending_date = !empty($rangeData[1]) ? $rangeData[1] : null;
            if ($starting_date == $ending_date) {
                $criteria->addCondition("occured_at like '" . $starting_date . "%'");
            } else {
                $criteria->addCondition("occured_at>=DATE('" . $starting_date . "') and occured_at<=DATE('" . $ending_date . "')");

            }
        }
        $criteria->order='total desc';

        $result=Accident::model()->findAll($criteria);

        $reponse=array();
        if(!empty($result))
        {
            foreach($result as $item)
            {
                $element=array();
                array_push($element,$item['vehicle_reg']);
                array_push($element,intval($item['total']));
                array_push($reponse,$element);
            }
        }
        return CJSON::encode($reponse);
    }

    public static function accidentsByWeather()
    {
        $criteria=new CDbCriteria();
        $criteria->select='weather_condition,count(t.id) as total';
        $criteria->with=array('driver');
        $criteria->condition='driver.fleetmanager_id='.Yii::app()->user->id;
        $criteria->group='t.weather_condition';
        $vehicle_reg=Yii::app()->request->getQuery('weather',null);
        if(!empty($vehicle_reg))
        {
            $criteria->addCondition('t.weather="'.$vehicle_reg.'"');
        }
        $range=Yii::app()->request->getQuery('date_range',null);
        if (!empty($range)) {
            $rangeData = explode(' to ', $range);
            $starting_date = !empty($rangeData[0]) ? $rangeData[0] : null;
            $ending_date = !empty($rangeData[1]) ? $rangeData[1] : null;
            if ($starting_date == $ending_date) {
                $criteria->addCondition("occured_at like '" . $starting_date . "%'");
            } else {
                $criteria->addCondition("occured_at>=DATE('" . $starting_date . "') and occured_at<=DATE('" . $ending_date . "')");

            }
        }
        $criteria->order='total desc';

        $result=Accident::model()->findAll($criteria);

        $reponse=array();
        if(!empty($result))
        {
            foreach($result as $item)
            {
                $element=array();
                array_push($element,$item['weather_condition']);
                array_push($element,intval($item['total']));
                array_push($reponse,$element);
            }
        }
        return CJSON::encode($reponse);
    }

}
