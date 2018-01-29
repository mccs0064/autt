<?php

class DeviceController extends APIController {

    public function actionIndex()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                $this->addDevice();
                break;
            case 'GET':
                $this->getDevices();
                break;
            default:
                break;
        }
    }

    private function addDevice()
    {
        $user_id = $this->_getUser();
        $model = new UserDevice();
        $model->attributes = $_POST;
        $model->user_id = $user_id;

        if ($model->validate())
        {
            $existing_device = UserDevice::model()->findByAttributes(array('device_token' => $model->device_token));
            if (!empty($existing_device))
            {
                $existing_device->device_token = $model->device_token;
                $existing_device->user_id = $user_id;
                if ($existing_device->update())
                {
                    $this->sendData($existing_device);
                }
            } else
            {
                $model->save();
                $this->sendData($model);
            }
        } else
        {
            $errors=Yii::app()->helper->getModelErrors($model->getErrors());
            $this->sendError($errors);
        }
    }

    private function getDevices()
    {
        $user_id = $this->_getUser();
        $criteria = new CDbCriteria();
        $criteria->select = "*";
        $criteria->condition = "user_id=" . $user_id;
        $criteria->compare('device_type', Yii::app()->request->getQuery('device_type', null));
        $devices = UserDevice::model()->findAll($criteria);
        $data = array();
        foreach ($devices as $device)
        {
            $device_data = array();
            $device_data['id'] = $device['id'];
            $device_data['device_name'] = $device['device_name'];
            $device_data['device_token'] = $device['device_token'];
            $device_data['device_type'] = $device['device_type'];
            $data[] = $device_data;
        }
        $this->sendData($data);
    }

}
