<div class="row">
    <div class="panel panel-transparent">
        <div class="panel-heading">
            <div class="panel-title">Fleet Mananger
            </div>
        </div>
        <div class="panel-body">
            <h3>Update Profile</h3>
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
                <?php echo $form->label($model, 'first_name'); ?>
                <?php echo $form->textField($model, 'first_name', array('placeholder' => 'Enter First Name','class'=>'form-control')); ?>
            </div>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'last_name'); ?>
                <?php echo $form->textField($model, 'last_name', array('placeholder' => 'Enter Last Name','class'=>'form-control')); ?>
            </div>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'picture'); ?>
                <?php echo $form->fileField($model, 'picture'); ?>
            </div>
            <div class="m-t-20">
                <?php echo CHtml::submitButton('Update Profile', array('class' => 'btn btn-success')); ?>
                <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/vehicles" class="btn btn-default"><i class="pg-close"></i> Cancel</a>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>