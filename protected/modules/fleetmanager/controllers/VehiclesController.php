<?php

class VehiclesController extends Controller
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
                'actions' => array('index', 'add', 'update', 'setinspection', 'addspreadsheet', 'createfromsheet', 'migratedrivers','details'),
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

        $this->pageTitle = 'Fleet Manager-All Vehicles';
        $model = new Vehicle();
        if (isset($_GET['Vehicle'])) {
            $model->attributes = $_GET['Vehicle'];
        }
        $this->render('all_vehicles', array('model' => $model));
    }


    public function actionAdd()
    {
        $model = new Vehicle();
        $model->vehicle_type=null;
        $drivers = Driver::model()->findAllByAttributes(array('fleetmanager_id'=>Yii::app()->user->id));
        if (isset($_POST['Vehicle'])) {
            $model->attributes = $_POST['Vehicle'];
            $model->fleetmanager_id = Yii::app()->user->id;
            if ($model->validate()) {
                if(!empty($model->next_mot))
                {
                    $model->next_mot=date('Y-m-d',strtotime($model->next_mot));
                }
                if(!empty($model->tax_expires))
                {
                    $model->tax_expires=date('Y-m-d',strtotime($model->tax_expires));
                }
                $model->save();
                $driversData = !empty($_POST['drivers']) ? $_POST['drivers'] : array();
                $model->updateDrivers($driversData);
                Yii::app()->user->setFlash('success', 'New Vehicle is added succesfully');
                $model->refresh();
                $this->redirect(array('/fleetmanager/vehicles'));

            }
        }
        $this->render('add_vehicle', array('model' => $model, 'drivers' => $drivers));
    }

    public function actionUpdate($id)
    {
        $model = Vehicle::model()->findByPk($id);
        if (empty($id))
            throw new CHttpException(500, 'No vehicle found with this ID');

        if ($model->fleetmanager_id != Yii::app()->user->id)
            throw new CHttpException(401, 'You are not authorized to update some other fleet manager vehicle');

        $drivers = Driver::model()->findAllByAttributes(array('fleetmanager_id'=>Yii::app()->user->id));
        if(!isset($_POST['Vehicle']))
        {
            if(!empty($model->next_mot))
            {
                $model->next_mot=date('d/m/Y',strtotime($model->next_mot));
            }
            if(!empty($model->tax_expires))
            {
                $model->tax_expires=date('d/m/Y',strtotime($model->tax_expires));
            }
        }


        if (isset($_POST['Vehicle'])) {

            $model->attributes = $_POST['Vehicle'];
            if(!empty($model->next_mot))
            {
                $model->next_mot=DateTime::createFromFormat('d/m/Y',$model->next_mot)->format('Y-m-d');
            }
            if(!empty($model->tax_expires))
            {
                $model->tax_expires=DateTime::createFromFormat('d/m/Y',$model->tax_expires)->format('Y-m-d');
            }
            if ($model->validate()) {
                $model->update();
                $driversData = !empty($_POST['drivers']) ? $_POST['drivers'] : array();
                $model->updateDrivers($driversData);
                Yii::app()->user->setFlash('success', 'Vehicle Details have been updated');
                $model->refresh();
                $this->redirect(array('/fleetmanager/vehicles'));
            }
            else
            {
                if(!empty($model->next_mot))
                {
                    $model->next_mot=date('d/m/Y',strtotime($model->next_mot));
                }
                if(!empty($model->tax_expires))
                {
                    $model->tax_expires=date('d/m/Y',strtotime($model->tax_expires));
                }
            }
        }
        $this->render('add_vehicle', array('model' => $model, 'drivers' => $drivers));
    }

    public function actionSetInspection($id)
    {
        $vehicle = Vehicle::model()->findByPk($id);
        if (empty($vehicle))
            throw new CHttpException(404, 'No vehicle found with this ID');

        if ($vehicle->fleetmanager_id != Yii::app()->user->id)
            throw new CHttpException(401, 'You are not authorized to update some other fleet manager vehicle');

        $model = new VehicleInspection();
        if (isset($_POST['VehicleInspection'])) {
            $model->attributes = $_POST['VehicleInspection'];
            $model->vehicle_id = $id;
            if ($model->validate()) {
                $model->due_date = date('Y-m-d', strtotime($_POST['VehicleInspection']['due_date']));
                $model->save();
                if (!empty($_POST['checklists'][0])) {
                    foreach ($_POST['checklists'] as $item) {
                        $checklist = new InspectionChecklist();
                        $checklist->item_name = $item;
                        $checklist->is_done = false;
                        $checklist->inspection_report_id = $model->id;
                        $checklist->save();
                    }
                }
                $this->redirect(array('/fleetmanager/vehicles'));
            }
        }
        $this->render('set_inspection', array('model' => $model, 'vehicle' => $vehicle));

    }

    public function actionAddSpreadsheet()
    {
        $model = new SpreadsheetForm();


        if (isset($_POST['SpreadsheetForm'])) {
            $model->file = CUploadedFile::getInstance($model, 'file');
            if ($model->validate()) {
                Yii::app()->user->setFlash('hasData', $model->file);
            }
        }

        $this->render('addsheet', array('model' => $model));
    }

    public function actionCreateFromSheet()
    {
        if (SpreadsheetForm::hasNewVehicle()) {
            $sheet_data = Yii::app()->user->getState('excelData');
            foreach ($sheet_data as $vehicle) {
                if ($vehicle['valid'] == true) {
                    $this->createVehicleItem($vehicle);
                }

            }
        }
        Yii::app()->user->setState('excelData', null);
    }

    private function createVehicleItem($vehicle_data)
    {
        $model = new Vehicle();
        $model->make = $vehicle_data['make'];
        $model->model = $vehicle_data['model'];
        $model->vehicle_reg = $vehicle_data['reg'];
        $model->serial_number = !empty($vehicle_data['serial_number'])?$vehicle_data['serial_number']:null;
        $model->gross_vehicle_weight = !empty($vehicle_data['gross_vehicle_weight'])?$vehicle_data['gross_vehicle_weight']:null;
        $model->vehicle_type = !empty($vehicle_data['vehicle_type'])?$vehicle_data['vehicle_type']:'Car';
        $model->next_mot = !empty($vehicle_data['next_mot'])?date('Y-m-d',strtotime($vehicle_data['next_mot'])):null;
        $model->tax_expires = !empty($vehicle_data['tax_expires'])?date('Y-m-d',strtotime($vehicle_data['tax_expires'])):null;
        $model->fleetmanager_id = Yii::app()->user->id;
        $model->save(false);
    }

    public function actionMigrateDrivers()
    {
        $vehicles = Vehicle::model()->findAll();
        foreach ($vehicles as $vehicle) {
            $vehicleDriverExist = VehicleDriver::model()->findByAttributes(array('vehicle_id' => $vehicle['id'], 'driver_id' => $vehicle['driver_id']));
            if (empty($vehicleDriverExist)) {
                if (!empty($vehicle['driver_id'])) {
                    $model = new VehicleDriver();
                    $model->vehicle_id = $vehicle['id'];
                    $model->driver_id = $vehicle['driver_id'];
                    $model->save();
                }
            }
        }

    }

    private function getDriverByEmail($email)
    {
        $model = Driver::model()->findByAttributes(array('email' => $email));
        if (!empty($model)) {
            return $model->id;
        }
        return null;
    }

    public function actionDetails($id)
    {
       $model=Vehicle::model()->findByPk($id);
        $search=new DriverSearch();
        $search->id=$id;

        $this->render('vehicle_detail',array('model'=>$model,'search'=>$search));
    }

}
