<div class="row">
    <div class="panel panel-transparent">
        <div class="panel-body">
            <h3><?php echo $model->isNewRecord?'Add New':'Update';?> Driver</h3>
        </div>
    </div>
    <!-- END PANEL -->
</div>
<div class="col-sm-7">
    <!-- START PANEL -->
    <div class="panel panel-transparent">
        <div class="panel-body">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'add-driver-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>
            <?php
            $errors = $model->getErrors();
            if (!empty($errors)):?>
                <div class="alert alert-danger">
                    <?php echo $form->errorSummary($model); ?>
                </div>
            <?php endif; ?>

            <div class="form-group form-group-default disabled">
                <?php echo $form->label($model, 'autium_id'); ?>
                <span><?php echo $model->isNewRecord?'Auto Generated':$model->autium_id;?></span>
            </div>

            <div class="form-group form-group-default required">
                <?php echo $form->label($model, 'full_name'); ?>
                <?php echo $form->textField($model, 'full_name', array('placeholder' => 'Enter Driver Name', 'class' => 'form-control', 'required' => true)); ?>
            </div>
            <?php if($model->isNewRecord==true):?>
            <div class="row clearfix">
                <div class="col-sm-6">
                    <div class="form-group form-group-default required">
                        <?php echo $form->label($model, 'password'); ?>
                        <?php echo $form->passwordField($model, 'password', array('placeholder' => 'Enter Password', 'class' => 'form-control', 'required' => true)); ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group form-group-default required">
                        <?php echo $form->label($model, 'confirmPassword'); ?>
                        <?php echo $form->passwordField($model, 'confirmPassword', array('placeholder' => 'Enter Password Again', 'class' => 'form-control', 'required' => true)); ?>
                    </div>
                </div>
            </div>
            <?php endif;?>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'address'); ?>
                <?php echo $form->textArea($model, 'address', array('placeholder' => 'Enter Driver Address', 'class' => 'form-control')); ?>
            </div>
            <div class="form-group form-group-default required">
                <?php echo $form->label($model, 'driving_license'); ?>
                <?php echo $form->textField($model, 'driving_license', array('placeholder' => 'Enter Driving License', 'class' => 'form-control')); ?>
            </div>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'license_type'); ?>
                <?php echo $form->textField($model, 'license_type', array('placeholder' => 'Enter Driving License Type', 'class' => 'form-control')); ?>
            </div>
            <div class="form-group form-group-default required">
                <?php echo $form->label($model, 'dob'); ?>
                <?php
                if(!empty($model->dob))
                {
                    $model->dob=str_replace('-','/',$model->dob);
                }
                $this->widget(
                    'ext.jui.EJuiDateTimePicker',
                    array(
                        'model' => $model,
                        'attribute' => 'dob',
                        'language' => 'en',//default Yii::app()->language
                        'mode'    => 'date',//'datetime' or 'time' ('datetime' default)
                        'options' => array(
                            'dateFormat' => 'dd/mm/yy',
                            //'timeFormat' => '',//'hh:mm tt' default
                        ),
                        'htmlOptions' => array(
                            'class' => 'form-control',
                            'placeholder'=>'DD/MM/YYYY'
                        )
                    )
                );
                ?>
            </div>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'nationality'); ?>
                <?php echo $form->textField($model, 'nationality',array('placeholder' => 'Enter Nationality', 'class' => 'form-control')); ?>
            </div>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'points'); ?>
                <?php

                $points=array(
                    0=>0,
                    1=>1,
                    2=>2,
                    3=>3,
                    4=>4,
                    5=>5,
                    6=>6,
                    7=>7,
                    8=>8,
                    9=>9,
                    10=>10,
                    11=>11,
                    12=>12
                );
                ?>
                <?php echo $form->dropDownList($model, 'points', $points,array('placeholder' => 'Enter Points', 'class' => 'form-control')); ?>
            </div>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'driving_convictions'); ?>
                <?php echo $form->dropDownList($model, 'driving_convictions', array('No'=>'No','Yes'=>'Yes'),array('placeholder' => 'Enter Driving Convictions', 'class' => 'form-control')); ?>
            </div>
            <div class="form-group form-group-default <?php echo $model->isNewRecord==true?'hidden':'';?>">
                <?php echo $form->label($model, 'status'); ?>
                <?php echo $form->dropDownList($model, 'status', array( 'Active' => 'Active','Pending' => 'Inactive'), array('class' => 'form-control', 'required' => true)); ?>
            </div>
            <div class="form-group">
                <label>Assign Vehicles</label>
            </div>
            <div>
                <span>
                    <select class="" id="driver-ms" multiple="multiple" name="vehicles[]">
                <?php foreach ($vehicles as $vehicle): ?>
                    <option <?php echo in_array($vehicle['id'], $model->getVehicles()) ? 'selected="selected"' : null; ?>
                        value="<?php echo $vehicle['id']; ?>"><?php echo $vehicle['vehicle_reg']; ?></option>
                <?php endforeach; ?>
            </select>
                </span>

                 <span><button style="margin-top: 10px; margin-bottom: 10px;" class="btn btn-sm btn-primary" onclick="return selectAllVehicles()">Select All Vehicles</button></span>

            </div>


            <div class="m-t-20">
                <?php echo CHtml::submitButton($model->isNewRecord?'Add':'Save Changes', array('class' => 'btn btn-success')); ?>
                <a href="<?php echo Yii::app()->request->baseUrl; ?>/fleetmanager/drivers" class="btn btn-default"><i
                        class="pg-close"></i> Cancel</a>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#driver-ms").select2();
    });
    function selectAllVehicles()
    {
        var selectedItems = [];
        var allOptions = $("#driver-ms option");
        allOptions.each(function() {
            selectedItems.push( $(this).val() );
        });
        $("#driver-ms").val(selectedItems).trigger("change");
        return false;
    }
</script>

<style>
    .select2-container {
        min-width: 500px !important;
    }
</style>