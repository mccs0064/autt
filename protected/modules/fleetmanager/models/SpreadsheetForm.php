<?php

class SpreadsheetForm extends CFormModel {

    public $file;

    public function rules() {
        return array(
            array('file', 'file',
                'types' => 'ods,xls,xlsx',
                'maxSize' => 1024 * 1024 * 1,
                'allowEmpty' => false),
            array('file','validateSheet')
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
            if(!empty($firstRow['A'])&&!empty($firstRow['B'])&&!empty($firstRow['C']))
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
            $vehicle=array();
            $vehicle['reg']=!empty($item['A'])?$item['A']:null;
            $vehicle['make']=!empty($item['B'])?$item['B']:null;
            $vehicle['model']=!empty($item['C'])?$item['C']:null;
            $vehicle['serial_number']=!empty($item['D'])?$item['D']:null;
            $vehicle['vehicle_type']=!empty($item['E'])?$item['E']:null;
            $vehicle['reg_exists']=$this->isVehicleExists($item['A']);
            $vehicle['gross_vehicle_weight']=!empty($item['F'])?$item['F']:null;
            $vehicle['next_mot']=!empty($item['G'])?$item['G']:null;
            $vehicle['tax_expires']=!empty($item['H'])?$item['H']:null;
            $vehicle['valid']=$this->validVehicle($vehicle);
            $sheet_data[]=$vehicle;
        }
        Yii::app()->user->setState('excelData',$sheet_data);
    }

    public function validVehicle($vehicle)
    {
        $valid=true;
        if(empty($vehicle['reg'])||$vehicle['reg_exists']==true||empty($vehicle['make'])||empty($vehicle['model'])||empty($vehicle['vehicle_type']))
        {
            $valid=false;
        }
        if(!empty($vehicle['next_mot']))
        {
            $mot=date('d/m/Y',strtotime($vehicle['next_mot']));
            if($mot=='01/01/1970')
                $valid=false;
        }
        if(!empty($vehicle['tax_expires']))
        {
            $tax=date('d/m/Y',strtotime($vehicle['tax_expires']));
            if($tax=='01/01/1970')
                $valid=false;
        }
        if(!empty($vehicle['vehicle_type']))
        {
            $validTypes=array('S-Type'=>'S-Type','R-Type'=>'R-Type','Car'=>'Car','Van'=>'Van','Truck'=>'Truck');
            if(!in_array($vehicle['vehicle_type'],$validTypes))
            {
                $valid=false;
            }
        }
        return $valid;
    }

    private function isVehicleExists($reg){
        $model=Vehicle::model()->findAllByAttributes(array('vehicle_reg'=>$reg,'fleetmanager_id'=>Yii::app()->user->id));
        if(!empty($model))
            return true;
        return false;
    }

    public static function hasNewVehicle()
    {
        $response=false;
        $sheet_data=Yii::app()->user->getState('excelData');
        foreach($sheet_data as $vehicle)
        {
            if($vehicle['reg_exists']==false)
            {
                $response=true;
                break;
            }

        }
        return $response;

    }
}
