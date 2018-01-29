<script src="<?php echo Yii::app()->request->baseUrl;?>/js/wizard.js" type="text/javascript"></script>

<div id="rootwizard" class="m-t-50">

    <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm">
        <?php $this->renderPartial('_topmenu');?>
    </ul>

    <div class="tab-content">
        <div class="tab-pane padding-20 slide-left active" id="basic-details">

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'driver-info-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'htmlOptions'=>array(
                    'data-module'=>'Basic'
                )
            ));
            ?>
            <h3>Driver Information</h3>
            <?php $this->renderPartial('_error',array('model'=>$model));?>

            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'driver_name'); ?>
                <?php echo $form->textField($model, 'driver_name', array('placeholder' => 'Enter Driver Name','class'=>'form-control','required'=>false)); ?>
            </div>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'address'); ?>
                <?php echo $form->textArea($model, 'address', array('rows'=>10,'placeholder' => 'Enter Driver Address','class'=>'form-control','required'=>false)); ?>
            </div>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'phone_number'); ?>
                <?php echo $form->textField($model, 'phone_number', array('placeholder' => 'Enter Driver Phone','class'=>'form-control','required'=>false)); ?>
            </div>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'insurer'); ?>
                <?php echo $form->textField($model, 'insurer', array('placeholder' => 'Enter Insurer Information','class'=>'form-control','required'=>false)); ?>
            </div>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'reg'); ?>
                <?php echo $form->textField($model, 'reg', array('placeholder' => 'Enter Vehicle Registration Number','class'=>'form-control','required'=>false)); ?>
            </div>
            <div class="m-t-20">
                <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-success')); ?>
            </div>
            <?php $this->endWidget(); ?>
            <div class="row">
                <div class="col-xs-12 text-right">
                    <a class="btn btn-danger" href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/addaccident/navigate/route/othervehicles">Back</a>
                    <a class="btn btn-primary" href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/addaccident/navigate/route/othervehiclephotos">Next</a>
                </div>
            </div>
        </div>
    </div>
</div>