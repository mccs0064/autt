<?php

class ReportsController extends Controller {

    public $layout = 'main';

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index','getvehiclesbytype','export'),
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

  public function actionIndex()
  {

      $model=new DailyInspectionReport();
      $vehicle_types=array('S-Type'=>'S-Type','R-Type'=>'R-Type','Car'=>'Car','Van'=>'Van','Truck'=>'Truck');
      $vehicle_type=Yii::app()->request->getQuery('vehicle_type',null);
      $vehicle=Yii::app()->request->getQuery('vehicle',null);
      $date_range=Yii::app()->request->getQuery('range',null);
      $defects=Yii::app()->request->getQuery('defects',null);
      if($vehicle=='All Vehicles')
      {
          $vehicle=null;
      }
      $driver=Yii::app()->request->getQuery('driver',null);

      $vehicles=Vehicle::model()->findAllByAttributes(array('fleetmanager_id'=>Yii::app()->user->id));
      foreach ($vehicles as $key=>$item)
      {
          $vehicles[$key]['select_option']=$item['vehicle_reg']." - ".$item['make'];
      }

      $drivers=Driver::model()->findAllByAttributes(array('fleetmanager_id'=>Yii::app()->user->id));
      if(!empty($vehicle_type))
      {
          $model->vehicle_type=$vehicle_type;
      }
      if(!empty($vehicle))
      {
          $model->vehicle_id=$vehicle;

      }
      if(!empty($driver))
      {
          $model->driver_id=$driver;
      }


      $this->render('index',array('model'=>$model,'defects'=>$defects,'date_range'=>$date_range,'vehicle_type'=>$vehicle_type,'vehicle_types'=>$vehicle_types,'vehicles'=>$vehicles,'drivers'=>$drivers,'vehicle'=>$vehicle,'driver'=>$driver));

  }

  public function actionExport()
  {
      $model=new DailyInspectionReport();
      $vehicle=Yii::app()->request->getQuery('vehicle',null);
      if($vehicle=='All Vehicles')
      {
          $vehicle=null;
      }
      $driver=Yii::app()->request->getQuery('driver',null);
      if(!empty($vehicle_type))
      {
          $model->vehicle_type=$vehicle_type;
      }
      if(!empty($vehicle))
      {
          $model->vehicle_id=$vehicle;

      }
      if(!empty($driver))
      {
          $model->driver_id=$driver;
      }
          $data=$model->searchModel()->getData();
          $name=time();
          $this->triggerExport($data,$name);

  }

  private function triggerExport($inpsections,$name)
  {
          $data = array(
              1 => array (
                  'Vehicle Type',
                  'Vehicle',
                  'Total Defects Reported',
                  'Date Submission',
                  'Driver',
              )
          );
          if(!empty($inpsections))
          {
              foreach ($inpsections as $inspection)
              {
                  $inspection_item['vehicle_type']=$inspection->vehicle->vehicle_type;
                  $inspection_item['vehicle']=$inspection->vehicle->make." - ".$inspection->vehicle->vehicle_reg;
                  $inspection_item['defects']=DailyInspectionReport::getTotalDefects($inspection->id);
                  $inspection_item['submission_date']=date("d M Y",strtotime($inspection->submitted_date));
                  $inspection_item['driver']=$inspection->user_type=="Fleet Manager"?"Fleet Manager":$inspection->driver->full_name;

                  array_push($data,$inspection_item);
              }

              Yii::import('application.extensions.phpexcel.JPhpExcel');
              $xls = new JPhpExcel();
              $xls->addArray($data);
              $xls->generateXML($name);
          }
          else

          {
              Yii::app()->user->setFlash('error','There is no data to export for selected search criteria');
              $url=Yii::app()->request->getUrl();
              $url=str_replace('export','index',$url);
              $this->redirect($url);
          }
  }

  public function actiongetvehiclesbytype()
  {
      $vehicle_type=Yii::app()->request->getPost('vehicle_type',null);
      if(!empty($vehicle_type))
      {
          $vehicles=Vehicle::model()->findAllByAttributes(array('vehicle_type'=>$vehicle_type,'fleetmanager_id'=>Yii::app()->user->id));
      }
      else
      {
            $vehicles=Vehicle::model()->findAllByAttributes(array('fleetmanager_id'=>Yii::app()->user->id));
      }
      $response=array();
      if(!empty($vehicles))
      {
          foreach ($vehicles as $item)
          {
              $vItem['id']=$item['id'];
              $vItem['name']=$item['make']." - ".$item['vehicle_reg'];
              $response[]=$vItem;
          }
      }
      echo CJSON::encode($response);

  }



}
