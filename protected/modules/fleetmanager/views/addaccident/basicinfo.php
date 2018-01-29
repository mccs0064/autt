<script src="<?php echo Yii::app()->request->baseUrl;?>/js/wizard.js" type="text/javascript"></script>

<div id="rootwizard" class="m-t-50">

    <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm">
        <?php $this->renderPartial('_topmenu');?>
    </ul>

    <div class="tab-content">
        <div class="tab-pane padding-20 slide-left active" id="basic-details">

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'basic-info-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'htmlOptions'=>array(
                    'data-module'=>'Basic'
                )
            ));
            ?>
            <h3>Accident Basic Information</h3>
            <?php $this->renderPartial('_error',array('model'=>$model,'form'=>$form));?>
            <div class="form-group form-group-default required">
                <?php echo $form->label($model, 'vehicle_id'); ?>
                <?php
                foreach($vehicles as $key=>$vehicle)
                {
                    $vehicles[$key]['select_option']=$vehicle['vehicle_reg']." (".$vehicle['make']."-".$vehicle['model'].")";
                }

                ?>
                <?php echo $form->dropDownList($model, 'vehicle_id', CHtml::listData($vehicles,'id','select_option'),array('class'=>'form-control','prompt'=>'Please select')); ?>
            </div>
            <div class="form-group form-group-default required">
                <?php echo $form->label($model, 'location'); ?>
                <?php echo $form->textField($model, 'location', array('placeholder' => 'Enter accident location','class'=>'form-control','required'=>false)); ?>
            </div>
            <div class="form-group form-group-default required">
                <?php echo $form->label($model, 'weather_condition'); ?>
                <?php echo $form->dropDownList($model, 'weather_condition',array('Foggy'=>'Foggy','Raining'=>'Raining','Dry'=>'Dry','Snow'=>'Snow','Icy'=>'Icy'), array('prompt' => 'Select Weather Condition','class'=>'form-control','required'=>false)); ?>
            </div>
            <div class="form-group form-group-default required">
                <?php echo $form->label($model, 'driver_id'); ?>

                <?php

                foreach($drivers as $key=>$driver)
                {
                    $drivers[$key]['select_driver']=$driver['full_name']." - ".$driver['autium_id'];
                }
                ?>
                <?php echo $form->dropDownList($model, 'driver_id', CHtml::listData($drivers,'id','select_driver'),array('class'=>'form-control','prompt'=>'Please select')); ?>
            </div>
            <div class="form-group form-group-default required">
                <?php echo $form->label($model, 'occured_at'); ?>
                <?php
                $this->widget(
                    'ext.jui.EJuiDateTimePicker',
                    array(
                        'model'     => $model,
                        'attribute' => 'occured_at',
                        'language'=> 'en',//default Yii::app()->language
                        //'mode'    => 'datetime',//'datetime' or 'time' ('datetime' default)
                        'options'   => array(
                            'dateFormat' => 'dd/mm/yy',
                            //'timeFormat' => '',//'hh:mm tt' default
                        ),
                        'htmlOptions'=>array(
                            'class'=>'form-control',
                            'placeholder'=>'Accident Date & Time'
                        )
                    )
                );
                ?>
            </div>
            <div class="m-t-20">
                <?php echo CHtml::submitButton('Next', array('class' => 'btn btn-success pull-right')); ?>
            </div>


            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>