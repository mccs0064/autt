<div class="row">
    <div class="panel panel-transparent">
        <div class="panel-heading">
            <div class="panel-title">
            </div>
        </div>
        <div class="panel-body">
            <h3>Add New Company Info</h3>
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
                'id' => 'add-fleet-manager-form',
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
                        <?php echo $form->label($model, 'first_name'); ?>
                        <?php echo $form->textField($model, 'first_name', array('placeholder' => 'Enter First Name','class'=>'form-control','required'=>true)); ?>
                    </div>
                    <div class="form-group form-group-default required">
                        <?php echo $form->label($model, 'last_name'); ?>
                        <?php echo $form->textField($model, 'last_name', array('placeholder' => 'Enter Last Name','class'=>'form-control','required'=>true)); ?>
                    </div>
                    <div class="form-group form-group-default required">
                        <?php echo $form->label($model, 'email'); ?>
                        <?php echo $form->emailField($model, 'email', array('placeholder' => 'Enter Email','class'=>'form-control','required'=>true)); ?>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group form-group-default required">
                                <?php echo $form->label($model, 'password'); ?>
                                <?php echo $form->passwordField($model, 'password', array('placeholder' => 'Enter Password','class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-group-default required">
                                <?php echo $form->label($model, 'confirmPassword'); ?>
                                <?php echo $form->passwordField($model, 'confirmPassword', array('placeholder' => 'Enter Password Again','class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                    </div>


            <div class="m-t-20">
                <?php echo CHtml::submitButton('Add', array('class' => 'btn btn-success')); ?>
                <a href="<?php echo Yii::app()->request->baseUrl;?>/admin/fleetmanagers" class="btn btn-default"><i class="pg-close"></i> Cancel</a>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>