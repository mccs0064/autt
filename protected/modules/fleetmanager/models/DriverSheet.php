<?php

class DriverSheet extends CFormModel {

    public $file;
    public $drivers;

    public function rules() {
        return array(
            array('file', 'file',
                'types' => 'ods,xls,xlsx',
                'maxSize' => 1024 * 1024 * 1,
                'allowEmpty' => false),
            array('file','validateSheet'),
            array('drivers','safe')
        );
    }

    public function validateSheet()
    {
        if(!$this->hasErrors())
        {
            $file=CUploadedFile::getInstance($this,'file');
            $sheet_array = Yii::app()->yexcel->readActiveSheet($file->tempName);
            if($this->isValidAutiumSheet($sheet_array))
            {
                $this->setSheetInSession($sheet_array);
            }
            else
            {
                $this->addError('file','The uploaded file does not contain the required data');
            }
        }
    }
    public function isValidAutiumSheet($sheet)
    {
        if (!empty($sheet[1]))
        {
            $firstRow=$sheet[1];
            if(!empty($firstRow['A']))
            {
                return true;
            }
        }
        return false;
    }

    private function setSheetInSession($sheet)
    {

        $sheet_data=array();
        foreach($sheet as $item)
        {
            $driver=array();
            $driver['full_name']=!empty($item['A'])?$item['A']:null;
            $driver['dob']=!empty($item['B'])?$item['B']:null;
            $driver['address']=!empty($item['C'])?$item['C']:null;
            $driver['driving_license']=!empty($item['D'])?$item['D']:null;
            $driver['license_type']=!empty($item['E'])?$item['E']:null;
            $driver['nationality']=!empty($item['F'])?$item['F']:null;
            $driver['points']=!empty($item['G'])?$item['G']:null;
            $driver['driving_convictions']=!empty($item['H'])?$item['H']:null;
            $driver['password']=!empty($item['I'])?$item['I']:null;
            $driver['valid']=true;
            $validation=self::validateDriver($driver);
            $driver['valid']=$validation['valid'];
            $driver['reason']=$validation['reason'];
            $sheet_data[]=$this->resetDataParms($driver);
        }
        Yii::app()->user->setState('driver_sheet',$sheet_data);
        $this->drivers=$sheet_data;
    }

    public function resetDataParms($driver)
    {
        if(empty($driver['driving_convictions']))
        {
            $driver['driving_convictions']="No";
        }
        return $driver;
    }

    private static function validateDriver($driver)
    {


        $dateOfBirth='';
        $response['valid']=true;
        $response['reason']=null;
        if(!empty($driver['dob']))
        {
            $dateOfBirth=date('Y-m-d',strtotime($driver['dob']));

            if($dateOfBirth=='1970-01-01')
            {
                $response['reason']='Invalid Data';
                $response['valid']=false;
            }
        }
        $driverData=Driver::model()->findByAttributes(array('dob'=>$dateOfBirth,'driving_license'=>$driver['driving_license'],'fleetmanager_id'=>Yii::app()->user->id,'full_name'=>$driver['full_name']));
        if(!empty($driverData))
        {
            $response['reason']='Exist';
            $response['valid']=false;
        }
        if(empty($driver['driving_license'])||empty($driver['dob']))
        {
            $response['reason']='Invalid Data';
            $response['valid']=false;
        }
        return $response;

    }

    public static function hasValidDriver()
    {
        $response=false;
        $sheet_data=Yii::app()->user->getState('driver_sheet');
        foreach($sheet_data as $driver)
        {
            if($driver['valid']==true)
            {
                $response=true;
                break;
            }

        }
        return $response;

    }

}
