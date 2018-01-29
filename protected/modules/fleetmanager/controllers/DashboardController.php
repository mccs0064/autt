<?php

class DashboardController extends Controller {

    public $layout = 'main';

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index','logout','inspections','accidents','accidentspermonth','accidentsbyvehicle','accidentsbyweather'),
                'roles' => array('Fleet'),
            ),
            array('allow',
                'actions' => array('login'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {

        $this->layout='main';
        $this->pageTitle='Fleet Manager-Dashboard';
        $drivers=DashboardCharts::getAllDrivers();
        $vehicles=DashboardCharts::getAllVehicles();
         $this->render('dashboard',array('drivers'=>$drivers,'vehicles'=>$vehicles));
    }

    public function actionInspections()
    {
        echo $this->getInspections();
    }

    public function actionAccidents()
    {
        $type=Yii::app()->request->getQuery('chart_type',null);
        $date_range=Yii::app()->request->getQuery('date_range',null);
        echo DashboardCharts::accidentsPerDriverBar($date_range);
    }


    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(array('/admin'));
    }

    public function getInspections($range = 'week') {

        switch ($range) {
            case 'today':
                $time_range = '0 days';
                break;
            case 'week':
                $time_range = '-7 days';
                break;
            case 'month':
                $time_range = '-' . date('d') . ' days';
                break;
            case 'last_30':
                $time_range = '-30 days';
                break;
            default:
                $time_range = null;
        }

        $time = strtotime($time_range, time());
        $date = date("Y-m-d", $time);
        $yesterday_time = strtotime('-1 days', time());
        $yesterday = date('Y-m-d', $yesterday_time);
        $order_data = array();
        $order_data[0] = array();
        $order_data[1] = array();
        array_push($order_data[0], 'date');
        array_push($order_data[1], 'inspections');


        while (strtotime($date) <= strtotime($yesterday)) {
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            $sql = "SELECT *,COUNT(id) AS total_inspections FROM `vehicle_inspection` `t` WHERE  submitted_date LIKE '" . $date . "%' ";
            $orders = Yii::app()->db->createCommand($sql)->queryAll();
            if (!empty($orders)) {
                foreach ($orders as $order) {
                    array_push($order_data[0], $date);
                    array_push($order_data[1], $order['total_inspections']);
                }
            }
        }
        return json_encode($order_data);
    }


    public function actionAccidentsPerMonth() {

        $type=Yii::app()->request->getQuery('chart_type',null);
        $date_range=Yii::app()->request->getQuery('date_range',null);
        if($type=='Bar')
        {
            echo DashboardCharts::accidentsPerMonthBar($date_range);
        }
        else
        {
            echo DashboardCharts::accidentsPerMonthLine($date_range);
        }
    }

    public function actionAccidentsByVehicle() {

        echo DashboardCharts::AccidentsByVehicle();
    }

    public function actionAccidentsByWeather() {

        echo DashboardCharts::accidentsByWeather();
    }




}
