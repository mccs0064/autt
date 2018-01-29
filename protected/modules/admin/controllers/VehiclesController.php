<?php

class VehiclesController extends Controller {

    public $layout = 'main';

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index','add','update','setinspection'),
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

        $this->pageTitle='Fleet Manager-All Vehicles';
        $model=new Vehicle();
        if(isset($_GET['Vehicle']))
        {
            $model->attributes=$_GET['Vehicle'];
        }
         $this->render('all_vehicles',array('model'=>$model));
    }



   public function actionAdd()
   {
       $model=new Vehicle();
       $drivers=Driver::model()->findAll();
       if(isset($_POST['Vehicle']))
       {
           $model->attributes=$_POST['Vehicle'];
           $model->fleetmanager_id=Yii::app()->user->id;
           if($model->validate())
           {
               $model->save();
                   Yii::app()->user->setFlash('success','New Vehicle is added succesfully');
                   $model->refresh();
                   $this->redirect(array('/fleetmanager/vehicles'));

           }
       }
       $this->render('add_vehicle',array('model'=>$model,'drivers'=>$drivers));
   }

    public function actionUpdate($id)
    {
        $model=Vehicle::model()->findByPk($id);
        if(empty($id))
            throw new CHttpException(500,'No vehicle found with this ID');

        if($model->fleetmanager_id!=Yii::app()->user->id)
            throw new CHttpException(401,'You are not authorized to update some other fleet manager vehicle');

        $drivers=Driver::model()->findAll();

        if(isset($_POST['Vehicle']))
        {
            $model->attributes=$_POST['Vehicle'];
            if($model->validate())
            {
                if(!empty($model->driver_id))
                {
                    $model->driver_id=intval($model->driver_id);
                }
                $model->update();

                    Yii::app()->user->setFlash('success','Vehicle Details have been updated');
                    $model->refresh();
                    $this->redirect(array('/fleetmanager/vehicles'));
            }
        }
        $this->render('add_vehicle',array('model'=>$model,'drivers'=>$drivers));
    }

    public function actionSetInspection($id)
    {
        $vehicle=Vehicle::model()->findByPk($id);
        if(empty($vehicle))
            throw new CHttpException(404,'No vehicle found with this ID');

        if($vehicle->fleetmanager_id!=Yii::app()->user->id)
            throw new CHttpException(401,'You are not authorized to update some other fleet manager vehicle');

        $model=new VehicleInspection();
        $this->render('set_inspection',array('model'=>$model,'vehicle'=>$vehicle));

    }

}
