<?php

class FleetmanagersController extends Controller
{

    public $layout = 'main';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index', 'add', 'changepassword','update','profile','drivers','accidents','vehicles','inspectionreports','driverdetail','accidentdetail','inspectiondetail','vechiledetail'),
                'roles' => array('Admin'),
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

        $this->pageTitle = 'Fleet Manager-All Fleet Managers';
        $model = new Fleetmanager();
        if (isset($_GET['Fleetmanager'])) {
            $model->attributes = $_GET['Fleetmanager'];
        }
        $this->render('all_fleets', array('model' => $model));
    }


    public function actionAdd()
    {
        $model = new NewFleetManager();
        if (isset($_POST['NewFleetManager'])) {
            $model->attributes = $_POST['NewFleetManager'];
            if ($model->validate()) {
                $model->password = CPasswordHelper::hashPassword($model->password);
                $model->status = 'Active';
                $model->role = 'Fleet';
                if ($model->save(false)) {
                    Yii::app()->user->setFlash('success', 'Fleet Manager is added succesfully');
                    $model->refresh();
                    $this->redirect(array('/admin/fleetmanagers'));
                }
            }
            $model->unsetAttributes(array('password', 'confirmPassword'));
        }
        $this->render('add_fleet', array('model' => $model));
    }

    public function actionUpdate($id)
    {
        $model=Fleetmanager::model()->findByPk($id);
        if(empty($model))
            throw new CHttpException(400, 'No fleet manager found with this id');

        if(isset($_POST['Fleetmanager']))
        {
            $model->attributes=$_POST['Fleetmanager'];
            if($model->validate())
            {
                $model->update();
                Yii::app()->user->setFlash('success','Fleetmanager details has have been updated successfully');
                $model->refresh();
                $this->redirect(array('/admin/fleetmanagers'));

            }
        }

        $this->render('update_fleet',array('model'=>$model));
    }

    public function actionProfile($id)
    {
        $model=Fleetmanager::model()->findByPk($id);

        $this->render('fleet_profile',array('model'=>$model));
    }

    public function actionVehicles($id){

        $model=new Vehicle();
        $model->fleetmanager_id=$id;

        $this->render('all_vehicles',array('model'=>$model));

    }
    public function actionDrivers($id){
        $model=new Driver();
        $model->fleetmanager_id=$id;

        $this->render('all_drivers',array('model'=>$model));

    }
    public function actionAccidents($id){

        $fleetManager=Fleetmanager::model()->findByPk($id);
        $model=new Accident();
        $model->fleetManagerId=$id;

        $this->render('all_accidents',array('model'=>$model,'fleetManager'=>$fleetManager));

    }

    public function actionAccidentDetail($id)
    {
        $model=Accident::model()->findByPk($id);
        $this->render('accident_detail',array('model'=>$model));
    }
    public function actionInspectionReports($id){
        $fleetManager=Fleetmanager::model()->findByPk($id);
        $model=new VehicleInspection();
        $model->fleetManagerId=$id;

        $this->render('all_inspections',array('model'=>$model,'fleetManager'=>$fleetManager));

    }

    public function actionInspectionDetail($id)
    {
        $model=VehicleInspection::model()->findByPk($id);
        $this->render('inspection_detail',array('model'=>$model));

    }

}
