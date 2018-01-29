<?php

class AccidentWizard extends CFormModel
{
    public function assignFromSession($param,$model)
    {
       if(Yii::app()->user->hasState($param))
       {
           $session_data=Yii::app()->user->getState($param);
           $model->attributes=$session_data;
       }
    }

    public static function getAccidentUniqueID()
    {
        if(Yii::app()->user->hasState('accidentUID'))
        {
            return Yii::app()->user->getState('accidentUID');
        }
        else
        {
            $UID=time();
            Yii::app()->user->setState('accidentUID',$UID);
        }
    }

    public static function setDirectory($directory,$accident_id)
    {
        self::createAccidentDirectory($accident_id);
        $directoryPath='uploads/temp/accidents/'.$accident_id.'/'.$directory;
        if (!file_exists($directoryPath)) {
            $oldmask = umask(0);
            mkdir($directoryPath, 0777);
            umask($oldmask);
        }
        return $directoryPath;
    }

    private static function createAccidentDirectory($accident_id)
    {
        $directoryPath='uploads/temp/accidents/'.$accident_id;
        if (!file_exists($directoryPath)) {
            $oldmask = umask(0);
            mkdir($directoryPath, 0777);
            umask($oldmask);
        }
        return $directoryPath;
    }

    public static function setPhotoInSession($url,$image_type)
    {
        if ($image_type == 'myphotos')
        {
            self::setMyPhoto($url);
        }
        else
        {
            self::setOtherPhoto($url);
        }
    }

    private static function setMyPhoto($url)
    {
        if(Yii::app()->user->hasState('myPhotos'))
        {
            $existingPhotos=Yii::app()->user->getState('myPhotos');
            array_push($existingPhotos,$url);
            Yii::app()->user->setState('myPhotos',$existingPhotos);
        }
        else
        {
            $photos=array();
            array_push($photos,$url);
            Yii::app()->user->setState('myPhotos',$photos);
        }
    }

    private static function setOtherPhoto($url)
    {
        if(Yii::app()->user->hasState('otherPhotos'))
        {
            $existingPhotos=Yii::app()->user->getState('otherPhotos');
            array_push($existingPhotos,$url);
            Yii::app()->user->setState('otherPhotos',$existingPhotos);
        }
        else
        {
            $photos=array();
            array_push($photos,$url);
            Yii::app()->user->setState('otherPhotos',$photos);
        }
    }

    public static function isBasicInfoValidated()
    {
        if(!Yii::app()->user->hasState('basicInfoValidated'))
            return false;
        else
            return true;
    }
}
