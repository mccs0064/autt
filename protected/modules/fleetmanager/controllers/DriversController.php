<?php

class DriversController extends Controller
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
                'actions' => array('index', 'add', 'changepassword', 'update', 'view', 'uploadsheet','createfromsheet'),
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

        $this->pageTitle = 'Fleet Manager-All Drivers';
        $model = new DriverSearch();
        if (isset($_GET['Driver'])) {
            $model->attributes = $_GET['Driver'];
        }
        $this->render('all_drivers', array('model' => $model));
    }


    public function actionAdd()
    {
        $model = new NewDriver('newUser');

        $vehicles = Vehicle::model()->findAllByAttributes(array('fleetmanager_id' => Yii::app()->user->id));
        if (isset($_POST['NewDriver'])) {
            $model->attributes = $_POST['NewDriver'];
            $model->autium_id = $this->generateAutiumID();
            $model->token_expiry = new CDbExpression('NOW()');
            if ($model->validate()) {
                $model->password = CPasswordHelper::hashPassword($model->password);
                $model->status = 'Active';
                $model->role = 'Driver';
                $model->fleetmanager_id = Yii::app()->user->id;
                if (!empty($model->dob)) {
                    $model->dob = DateTime::createFromFormat('d/m/Y',$model->dob)->format('Y-m-d');
                }
                if ($model->save(false)) {
                    $vehiclesData = !empty($_POST['vehicles']) ? $_POST['vehicles'] : array();
                    $model->updateVehicles($vehiclesData);
                    Yii::app()->user->setFlash('success', 'New Driver is added succesfully');
                    $model->refresh();
                    $this->redirect(array('/fleetmanager/drivers'));
                }
            }
            $model->unsetAttributes(array('password', 'confirmPassword'));
        }
        $this->render('add_driver', array('model' => $model, 'vehicles' => $vehicles));
    }

    public function actionChangePassword($id)
    {
        $model = ForgotPasswordRequests::model()->findByPk($id);
        $formModel = new ChangePasswordForm();
        if (isset($_POST['ChangePasswordForm'])) {
            $formModel->attributes = $_POST['ChangePasswordForm'];
            $formModel->email = $model->email;
            if ($formModel->validate()) {
                $driver = Driver::model()->findByAttributes(array('email' => $formModel->email));
                $driver->password = CPasswordHelper::hashPassword($formModel->password);
                if ($driver->update()) {
                    $model->status = 'Changed';
                    $model->update();
                    Yii::app()->user->setFlash('success', 'Driver password has been reset successfully');
                    $this->redirect(array('/fleetmanager/passwordrequests'));
                }
            }
        }
        $this->render('change_password', array('model' => $model, 'formModel' => $formModel));
    }

    public function actionUpdate($id)
    {
        $model = NewDriver::model()->findByPk($id);
        $vehicles = Vehicle::model()->findAllByAttributes(array('fleetmanager_id' => Yii::app()->user->id));
        if (empty($model))
            throw new CHttpException(400, 'No driver found with this id');

        if ($model->fleetmanager_id != Yii::app()->user->id)
            throw new CHttpException(401, 'You are not authorized to update someone else record');

        if (isset($_POST['NewDriver'])) {
            $model->attributes = $_POST['NewDriver'];

            if (!empty($model->dob)) {
                $model->dob = DateTime::createFromFormat('d/m/Y',$model->dob)->format('Y-m-d');
            } else {
                $model->dob = null;
            }
            if ($model->validate()) {
                $model->update();
                $vehicleData = !empty($_POST['vehicles']) ? $_POST['vehicles'] : array();
                $model->updateVehicles($vehicleData);
                Yii::app()->user->setFlash('success', 'Driver details has have been updated successfully');
                $model->refresh();
                $this->redirect(array('/fleetmanager/drivers'));

            }
        }
        if(!empty($model->dob))
        {
            $model->dob=date('d/m/Y',strtotime($model->dob));
        }
        $model->unsetAttributes(array('password'));
        $this->render('add_driver', array('model' => $model, 'vehicles' => $vehicles));
    }

    public function actionUploadSheet()
    {

        $model = new DriverSheet();
        if (isset($_POST['DriverSheet'])) {
            $model->file = CUploadedFile::getInstance($model, 'file');
            if ($model->validate()) {
                Yii::app()->user->setFlash('hasData', $model->file);
//                if(!empty($model->drivers))
//                {
//
//                    $this->redirect(array('/fleetmanager/drivers'));
//                }
            }
        }

        $this->render('driver_sheet', array('model' => $model));
    }

    public function actionView($id)
    {
        $model = Driver::model()->findByPk($id);
        if (empty($model))
            throw new CHttpException(400, 'No driver found with this id');

        if ($model->fleetmanager_id != Yii::app()->user->id)
            throw new CHttpException(401, 'You are not authorized to view this information');

        $vehicles = new VehicleDriver();
        if (isset($_GET['VehicleDriver'])) {
            $vehicles->attributes = $_GET['VehicleDriver'];
        }
        $this->render('driver_details', array('model' => $model, 'vehicles' => $vehicles));
    }

    public function generateAutiumID()
    {
        $query = 'select id from driver order by id desc limit 1';
        $data = Yii::app()->db->createCommand($query)->queryAll();
        if (!empty($data[0]['id'])) {
            $last_id = $data[0]['id'];
            $return_id = intval($last_id);
            $return_id++;
            return 'AUT-0000' . $return_id;
        }
    }


    private function createDriver($driver)
    {


        $driverModel = new Driver();
        $driverModel->full_name = !empty($driver['full_name']) ? $driver['full_name'] : null;

        $driverName=explode(" ",$driverModel->full_name);
        $driverNameForPassword=!empty($driverName[0])?$driverName[0]."1":null;

        $driverModel->password = !empty($driverNameForPassword) ? CPasswordHelper::hashPassword($driverNameForPassword) : null;
        $driverModel->autium_id = $this->generateAutiumID();
        $driverModel->policy_number = !empty($driver['policy_number']) ? $driver['policy_number'] : null;
        $driverModel->insurer = !empty($driver['insurer']) ? $driver['insurer'] : null;
        $driverModel->vehicle_reg = !empty($driver['vehicle_reg']) ? $driver['vehicle_reg'] : null;
        $driverModel->address = !empty($driver['address']) ? $driver['address'] : null;
        $driverModel->driving_license = !empty($driver['driving_license']) ? $driver['driving_license'] : null;
        $driverModel->dob = !empty($driver['dob']) ? date('Y-m-d',strtotime($driver['dob'])) : null;
        $driverModel->status = 'Active';
        $driverModel->fleetmanager_id = Yii::app()->user->id;
        $driverModel->role = 'Driver';
        $driverModel->license_type = !empty($driver['license_type']) ? $driver['license_type'] : null;
        $driverModel->nationality = !empty($driver['nationality']) ? $driver['nationality'] : null;
        $driverModel->points = !empty($driver['points']) ? $driver['points'] : null;
        $driverModel->license_type = !empty($driver['driving_convictions']) ? $driver['driving_convictions'] : null;
        $driverModel->token_expiry = new CDbExpression('NOW()');
        $driverModel->save(false);

    }

    public function actionCreateFromSheet()
    {
        if (DriverSheet::hasValidDriver()) {
            $sheet_data = Yii::app()->user->getState('driver_sheet');
            foreach ($sheet_data as $vehicle) {
                if ($vehicle['valid'] == true) {
                    $this->createDriver($vehicle);
                }

            }
        }
        Yii::app()->user->setState('driver_sheet', null);
    }

}
