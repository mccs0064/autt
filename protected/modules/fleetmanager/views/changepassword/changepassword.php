<div class="row">
    <div class="panel panel-transparent">
        <div class="panel-heading">
            <div class="panel-title">Fleet Mananger
            </div>
        </div>
        <div class="panel-body">
            <h3>Change Password</h3>
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
                'id' => 'change-password-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'htmlOptions' => array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'),
            ));
            ?>


            <?php
            if(Yii::app()->user->hasFlash('success')):?>
                <div class="alert alert-success">
                    <?php echo Yii::app()->user->getFlash('success');?>
                </div>
           <?php endif; ?>
            <?php
            $errors=$model->getErrors();
            if(!empty($errors)):?>
                <div class="alert alert-danger">
                    <?php echo $form->errorSummary($model);?>
                </div>
            <?php endif;?>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'current_password'); ?>
                <?php echo $form->passwordField($model, 'current_password', array('placeholder' => 'Enter current password','class'=>'form-control')); ?>
            </div>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'password'); ?>
                <?php echo $form->passwordField($model, 'password', array('placeholder' => 'Enter new password','class'=>'form-control')); ?>
            </div>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'confirmPassword'); ?>
                <?php echo $form->passwordField($model, 'confirmPassword', array('placeholder' => 'Enter password again','class'=>'form-control')); ?>
            </div>
            <div class="m-t-20">
                <?php echo CHtml::submitButton('Change Password', array('class' => 'btn btn-success')); ?>
                <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/dashboard" class="btn btn-default"><i class="pg-close"></i> Cancel</a>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>