<div class="row">
    <div class="panel panel-transparent">
        <div class="panel-body">
            <h3>Upload Spreadsheet</h3>
        </div>
    </div>
    <!-- END PANEL -->
</div>

<?php

if(Yii::app()->user->hasFlash('hasData'))
{

?>

    <div class="modal fade slide-up" id="selectbusiness" tabindex="-1" role="dialog" aria-hidden="false" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                        <h5><span class="semi-bold">Create Vehicles</span></h5>
                        <p class="p-b-10">Following data has been imported from spreadsheet</p>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-hover" id="businessesList">
                                    <thead>
                                    <tr>
                                        <td class="bold">REG <span class="text-danger">*</span></td>
                                        <td class="bold">MAKE <span class="text-danger">*</span></td>
                                        <td class="bold">MODEL <span class="text-danger">*</span></td>
                                        <td class="bold">Serial</td>
                                        <td class="bold">Type <span class="text-danger">*</span></td>
                                        <td class="bold">Gross Weight</td>
                                        <td class="bold">Next MOT</td>
                                        <td class="bold">Tax Expires</td>
                                        <td class="bold">STATUS</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sheet_data=Yii::app()->user->getState('excelData');

                                    foreach($sheet_data as $vehicle):

                                        if(empty($vehicle['reg']))
                                        {
                                            $reg='<span class="text-danger">Required</span>';
                                        }
                                        else
                                        {
                                            if($vehicle['reg_exists']==true)
                                            {
                                                $reg="<span class='text-danger'>".$vehicle['reg']."</span>";
                                            }
                                            else
                                            {
                                                $reg=$vehicle['reg'];
                                            }
                                        }


                                    ?>
                                        <tr>
                                            <td class="v-align-middle semi-bold <?php echo $vehicle['valid']==false?'invalid-td':'';?>">
                                                <?php echo $reg;?>
                                            </td>
                                            <td class="v-align-middle semi-bold <?php echo $vehicle['valid']==false?'invalid-td':'';?>">
                                                <?php echo !empty($vehicle['make'])?$vehicle['make']:'<span class="text-danger">Required</span>';?>
                                            </td>
                                            <td class="v-align-middle semi-bold <?php echo $vehicle['valid']==false?'invalid-td':'';?>">
                                                <?php echo !empty($vehicle['model'])?$vehicle['model']:'<span class="text-danger">Required</span>';?>
                                            </td>
                                            <td class="v-align-middle semi-bold <?php echo $vehicle['valid']==false?'invalid-td':'';?>">
                                                <?php echo !empty($vehicle['serial_number'])?$vehicle['serial_number']:'N/A';?>
                                            </td>
                                            <td class="v-align-middle semi-bold <?php echo $vehicle['valid']==false?'invalid-td':'';?>">

                                                <?php
                                                if(!empty($vehicle['vehicle_type']))
                                                {
                                                    $validTypes=array('S-Type'=>'S-Type','R-Type'=>'R-Type','Car'=>'Car','Van'=>'Van','Truck'=>'Truck');
                                                    if(!in_array($vehicle['vehicle_type'],$validTypes))
                                                    {
                                                        $vType='<span class="text-danger">'.$vehicle["vehicle_type"].'<br/>Invalid Type</span>';
                                                    }
                                                    else
                                                    {
                                                        $vType=$vehicle["vehicle_type"];
                                                    }
                                                }
                                                else
                                                {
                                                    $vType='<span class="text-danger">Required</span>';
                                                }

                                                ?>

                                                <?php echo $vType;?>
                                            </td>
                                            <td class="v-align-middle semi-bold <?php echo $vehicle['valid']==false?'invalid-td':'';?>">
                                                <?php echo !empty($vehicle['gross_vehicle_weight'])?$vehicle['gross_vehicle_weight']:'N/A';?>

                                            </td>
                                            <td class="v-align-middle semi-bold <?php echo $vehicle['valid']==false?'invalid-td':'';?>">
                                                <?php
                                                $next_mot=!empty($vehicle['next_mot'])?date('d/m/Y',strtotime($vehicle['next_mot'])):'N/A';
                                                echo $next_mot=='01/01/1970'?'<span class="text-danger">Invalid Date Format</span>':$next_mot;
                                                ?>
                                            </td>
                                            <td class="v-align-middle semi-bold <?php echo $vehicle['valid']==false?'invalid-td':'';?>">
                                                <?php
                                                $tax_expires=!empty($vehicle['tax_expires'])?date('d/m/Y',strtotime($vehicle['tax_expires'])):'N/A';
                                                echo $tax_expires=='01/01/1970'?'<span class="text-danger">Invalid Date Format</span>':$tax_expires;
                                                ?>
                                            </td>
                                            <td class="v-align-middle semi-bold <?php echo $vehicle['valid']==false?'invalid-td':'';?>">
                                                <?php
                                                $str='New';
                                                if($vehicle['reg_exists']==true)
                                                {
                                                    $str='<span class=\'text-danger\'>Vehicle Exists</span>';

                                                }
                                                else
                                                {
                                                    if($vehicle['valid']==false)
                                                    {
                                                        $str='<span class=\'text-danger\'>Invalid Data</span>';
                                                    }
                                                }
                                                ?>
                                                <?php echo $str;?>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <p class="alert alert-warning">Please note that only vehicles with status 'New' will be created</p>
                            </div>
                            <div class="col-sm-4 m-t-10 sm-m-t-10">
                                <button type="button" class="btn btn-primary btn-block m-t-5" id="create-vehicles"><?php echo (SpreadsheetForm::hasNewVehicle())?'Create Vehicles':'Dismiss';?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>

    <script>
        $(window).load(function(){
            $("#selectbusiness").modal('show');
        });
        $("#create-vehicles").click(function(){
            $.ajax({
                type: 'post',
                url: '<?php echo Yii::app()->createUrl("fleetmanager/vehicles/createfromsheet");?>',
                success: function(response){
                    window.location='<?php echo Yii::app()->createUrl("fleetmanager/vehicles");?>';
                }
            });
        });




    </script>

<?php }
?>
<div class="col-sm-7">
    <!-- START PANEL -->
    <div class="panel panel-transparent">
        <div class="panel-body">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'update-profile-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
            ));
            ?>
            <?php
            $errors=$model->getErrors();
            if(!empty($errors)):?>
                <div class="alert alert-danger">
                    <?php echo $form->errorSummary($model);?>
                </div>
            <?php endif;?>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'file'); ?>
                <?php echo $form->fileField($model, 'file'); ?>
            </div>
            <div class="m-t-20">
                <?php echo CHtml::submitButton('Upload', array('class' => 'btn btn-success')); ?>
                <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/vehicles" class="btn btn-default"><i class="pg-close"></i> Cancel</a>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<style>
    .invalid-td
    {
        background: rgba(255, 0, 0, 0.04) !important;
    }
</style>