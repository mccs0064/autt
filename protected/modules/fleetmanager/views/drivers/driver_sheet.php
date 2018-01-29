<div class="row">
    <div class="panel panel-transparent">
        <div class="panel-body">
            <h3>Upload Driver's Spreadsheet</h3>
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
                        <h5><span class="semi-bold">Create Drivers</span></h5>
                        <p class="p-b-10">Following data has been imported from spreadsheet</p>
                        <p>Fields marked with <span class="text-danger"> *</span> are mandatory</p>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-hover" id="businessesList">
                                    <thead>
                                    <tr>
                                        <td class="bold">Full Name<span class="text-danger"> *</span></td>
                                        <td class="bold">Address</td>
                                        <td class="bold">Driving License Number<span class="text-danger"> *</span></td>
                                        <td class="bold">License Type</td>
                                        <td class="bold">Date of Birth<span class="text-danger"> *</span></td>
                                        <td class="bold">Nationality</td>
                                        <td class="bold">Points</td>
                                        <td class="bold">Driving Convictions</td>
                                        <td class="bold">Status</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sheet_data=Yii::app()->user->getState('driver_sheet');

                                    foreach($sheet_data as $driver):
                                        ?>
                                        <tr>
                                            <td class="v-align-middle semi-bold <?php echo $driver['valid']==false?'invalid-td':null;?>">
                                                <?php echo !empty($driver['full_name'])?$driver['full_name']:'<span class="text-danger">Required</span>';?>
                                            </td>
                                            <td class="v-align-middle semi-bold <?php echo $driver['valid']==false?'invalid-td':null;?> ">
                                                <?php echo !empty($driver['address'])?$driver['address']:'N/A';?>
                                            </td>
                                            <td class="v-align-middle semi-bold <?php echo $driver['valid']==false?'invalid-td':null;?> ">
                                                <?php echo !empty($driver['driving_license'])?$driver['driving_license']:'<span class="text-danger">Required</span>';?>
                                            </td>
                                            <td class="v-align-middle semi-bold <?php echo $driver['valid']==false?'invalid-td':null;?> ">
                                                <?php echo !empty($driver['license_type'])?$driver['license_type']:'N/A';?>
                                            </td>

                                            <td class="v-align-middle semi-bold <?php echo $driver['valid']==false?'invalid-td':null;?> ">
                                                <?php
                                                $dob=!empty($driver['dob'])?date('d/m/Y',strtotime($driver['dob'])):'<span class="text-danger">Required</span>';

                                                echo $dob=='01/01/1970'?'<span class="text-danger">Invalid Date Format</span>':$dob;

                                                ?>
                                            </td>
                                            <td class="v-align-middle semi-bold <?php echo $driver['valid']==false?'invalid-td':null;?> ">
                                                <?php echo !empty($driver['nationality'])?$driver['nationality']:'N/A';?>
                                            </td>
                                            <td class="v-align-middle semi-bold <?php echo $driver['valid']==false?'invalid-td':null;?> ">
                                                <?php echo !empty($driver['points'])?$driver['points']:'0';?>
                                            </td>
                                            <td class="v-align-middle semi-bold <?php echo $driver['valid']==false?'invalid-td':null;?>">
                                                <?php echo !empty($driver['driving_convictions'])?$driver['driving_convictions']:'No';?>
                                            </td>
                                            <td class="v-align-middle semi-bold <?php echo $driver['valid']==false?'invalid-td':null;?>">
                                                <?php echo ($driver['valid']==true)?'Valid':$driver['reason'];?>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <p class="alert alert-warning">Please note that only drivers with status 'Valid' will be created</p>
                            </div>
                            <div class="col-sm-4 m-t-10 sm-m-t-10">
                                <button type="button" class="btn btn-primary btn-block m-t-5" id="create-drivers"><?php echo (DriverSheet::hasValidDriver())?'Create Drivers':'Dismiss';?></button>
                            </div>
                            <div class="col-sm-2  m-t-10 sm-m-t-10">
                                <a class="btn btn-primary btn-block m-t-5" data-dismiss="modal">Cancel</a>
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
        $("#create-drivers").click(function(){
            $.ajax({
                type: 'post',
                url: '<?php echo Yii::app()->createUrl("fleetmanager/drivers/createfromsheet");?>',
                success: function(response){
                    window.location='<?php echo Yii::app()->createUrl("fleetmanager/drivers");?>';
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
        background: rgba(255, 0, 0, 0.09) !important;
    }
    .table tbody tr td
    {
        padding: 20px 20px 20px 15px;
    }
    @media (min-width: 992px)
    {
        .modal-lg {
            width: 1200px;
        }
    }

</style>