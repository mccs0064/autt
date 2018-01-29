<div class="row">
    <div class="panel panel-transparent">
        <div class="panel-heading">
            <div class="panel-title">Drivers
            </div>
        </div>
        <div class="panel-body">
            <h3>Update Driver Details</h3>
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
                'id' => 'update-driver-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>
                    <?php
                    $errors=$model->getErrors();
                    if(!empty($errors)):?>
                        <div class="alert alert-danger">
                            <?php echo $form->errorSummary($model);?>
                        </div>
                    <?php endif;?>
                    <div class="form-group form-group-default required">
                        <?php echo $form->label($model, 'full_name'); ?>
                        <?php echo $form->textField($model, 'full_name', array('placeholder' => 'Enter Driver Name','class'=>'form-control','required'=>true)); ?>
                    </div>
                    <div class="form-group form-group-default required">
                        <?php echo $form->label($model, 'autium_id'); ?>
                        <?php echo $form->textField($model, 'autium_id', array('placeholder' => 'Enter Driver Autium ID','class'=>'form-control','required'=>true)); ?>
                    </div>
                    <div class="form-group form-group-default">
                        <?php echo $form->label($model, 'address'); ?>
                        <?php echo $form->textArea($model, 'address', array('placeholder' => 'Enter Driver Address','class'=>'form-control')); ?>
                    </div>
                    <div class="form-group form-group-default">
                        <?php echo $form->label($model, 'status'); ?>
                        <?php echo $form->dropDownList($model, 'status',array('Pending'=>'Pending','Active'=>'Active'), array('class'=>'form-control','required'=>true)); ?>
                    </div>
            <div class="m-t-20">
                <?php echo CHtml::submitButton('Update Driver', array('class' => 'btn btn-success')); ?>
                <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/drivers" class="btn btn-default"><i class="pg-close"></i> Cancel</a>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>