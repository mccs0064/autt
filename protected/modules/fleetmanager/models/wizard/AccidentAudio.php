<?php


class AccidentAudio extends AccidentWizard
{

    public $file;

    public function rules() {
        return array(
            array('file', 'file',
                'types' => 'mp3,wav,raw,rm,m4a,wma,ogg',
                'maxSize' => 1024 * 1024 * 10,
                'allowEmpty' => false)
        );
    }

    public function attributeLabels()
    {
       return array(
           'file'=>'Audio File'
       );
    }

    public static function removeExistingFile()
    {
        if(Yii::app()->user->hasState('audio'))
        {
            $filePath=Yii::app()->user->getState('audio');
            @unlink($filePath);
        }
    }


}
