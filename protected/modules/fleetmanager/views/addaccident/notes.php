<script src="<?php echo Yii::app()->request->baseUrl;?>/js/wizard.js" type="text/javascript"></script>

<div id="rootwizard" class="m-t-50">

    <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm">
        <?php $this->renderPartial('_topmenu');?>
    </ul>

    <div class="tab-content">
        <div class="tab-pane padding-20 slide-left active" id="basic-details">
            <h3>Post Accident Interview</h3>

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
            <?php $this->renderPartial('_error',array('model'=>$model,'form'=>$form));?>
            <div class="form-group form-group-default required">
                <?php echo $form->label($model, 'note_type');?>
                <?php

                $note_types=array(
                    'Changing lanes'=>'Changing lanes',
                    'Accidental Damage'=>'Accidental Damage',
                    'Collision whilst reversing'=>'Collision whilst reversing',
                    'Collision with a  moving vehicle'=>'Collision with a  moving vehicle',
                    'Collision with a stationary vehicle'=>'Collision with a stationary vehicle',
                    'Blowout'=>'Blowout',
                    'Vehicle failure'=>'Vehicle failure',
                    'Theft'=>'Theft',
                    'Fire'=>'Fire',
                    'Hit a TP in the rear'=>'Hit a TP in the rear',
                    'TP at fault'=>'TP at fault',
                    'Vehicle tipping'=>'Vehicle tipping',
                );
                ?>
                <?php echo $form->dropDownList($model, 'note_type', $note_types,array('class'=>'form-control','prompt'=>'Please select')); ?>
            </div>

            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'claim_cost'); ?>
                <?php echo $form->numberField($model, 'claim_cost', array('rows'=>20,'placeholder' => 'Enter Claim Cost','class'=>'form-control')); ?>
            </div>

            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'notes'); ?>
                <?php echo $form->textarea($model, 'notes', array('rows'=>20,'placeholder' => 'Enter Notes','class'=>'form-control tArea')); ?>
            </div>



            <div class="m-t-20">
                <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-success')); ?>
            </div>

            <?php $this->endWidget(); ?>
            <div class="row">
                <div class="col-xs-12 text-right">
                    <a class="btn btn-danger" href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/addaccident/navigate/route/police">Back</a>
                    <a onclick="submitAccident();" class="btn btn-primary">Submit Accident</a>
                </div>
            </div>


        </div>
    </div>
</div>

<div class="hidden">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'submit-accidents-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions'=>array(
            'data-module'=>'Basic'
        )
    ));
    ?>
    <div class="form-group form-group-default required">
        <?php echo $form->textArea($wizardModel, 'vehicle_reg', array('rows'=>20,'placeholder' => 'Enter Notes','class'=>'form-control','required'=>true)); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>

<script>
    function submitAccident() {
        var choice=window.confirm("Are you sure you want to submit the accident?");
        if(choice==true) {
            $("#submit-accidents-form").submit();
        }
    }

</script>