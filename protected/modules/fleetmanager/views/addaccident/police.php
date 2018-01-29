<script src="<?php echo Yii::app()->request->baseUrl;?>/js/wizard.js" type="text/javascript"></script>

<div id="rootwizard" class="m-t-50">

    <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm">
        <?php $this->renderPartial('_topmenu');?>
    </ul>

    <div class="tab-content">
        <div class="tab-pane padding-20 slide-left active" id="basic-details">
            <h3>Police</h3>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'basic-info-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'htmlOptions'=>array(
                    'class'=>'m-t-30'
                )
            ));
            ?>
            <div class="form-group form-group-default required">
                <?php echo $form->label($model, 'officer_name'); ?>
                <?php echo $form->textField($model, 'officer_name', array('placeholder' => 'Enter Officer Name','class'=>'form-control')); ?>
            </div>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'police_station'); ?>
                <?php echo $form->textArea($model, 'police_station', array('placeholder' => 'Enter Police Station','class'=>'form-control')); ?>
            </div>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'phone_number'); ?>
                <?php echo $form->textField($model, 'phone_number', array('placeholder' => 'Enter Phone Number','class'=>'form-control')); ?>
            </div>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'batch_number'); ?>
                <?php echo $form->textField($model, 'batch_number', array('placeholder' => 'Enter Officer Badge Number','class'=>'form-control')); ?>
            </div>
            <div class="m-t-20">
                <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-success')); ?>
            </div>

            <?php $this->endWidget(); ?>
            <div class="row">
                <div class="col-xs-12 text-right">
                    <a class="btn btn-danger" href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/addaccident/navigate/route/audio">Back</a>
                    <a class="btn btn-primary" href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/addaccident/navigate/route/notes">Next</a>

                </div>
            </div>
        </div>
    </div>
</div>