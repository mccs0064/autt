<?php

class ProfileController extends Controller
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
                'actions' => array('index'),
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

        $model=Fleetmanager::model()->findByPk(Yii::app()->user->id);
        $this->pageTitle = 'Fleet Manager-Update Profile';
        $oldFile = $model->picture;
        if (isset($_POST['Fleetmanager'])) {

            $model->attributes = $_POST['Fleetmanager'];
            if ($model->validate()) {

                $uploadedFile = CUploadedFile::getInstance($model, 'picture');
                if (!empty($uploadedFile)) {
                    $model->picture = time() . '-' . $uploadedFile->name;
                    $folder = 'uploads/profile/';
                    $uploadedFileName = time() . "-" . $uploadedFile->name;
                    $filePath = $folder . $uploadedFileName;
                    $uploadedFile->saveAs($filePath);
                    if ($oldFile) {
                        $media_path = Yii::app()->basePath . '/../uploads/profile/' . $oldFile;
                        @unlink($media_path);
                    }
                } else {
                    $model->picture = $oldFile;
                }
                $model->update();
                Yii::app()->user->setState('first_name',$model->first_name);
                Yii::app()->user->setState('last_name',$model->last_name);
                Yii::app()->user->setState('picture',$model->picture);
                Yii::app()->user->setFlash('success', 'Profile details habve  been updated');
                $this->redirect(array('/fleetmanager/vehicles'));
            }
        }
        $this->render('profile', array('model' => $model));
    }


}
