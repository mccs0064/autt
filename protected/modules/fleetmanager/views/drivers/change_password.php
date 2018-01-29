<div class="row">
    <div class="panel panel-transparent">
        <div class="panel-heading">
            <div class="panel-title">Drivers
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
                'id' => 'add-driver-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>
                    <?php
                    $errors=$formModel->getErrors();
                    if(!empty($errors)):?>
                        <div class="alert alert-danger">
                            <?php echo $form->errorSummary($formModel);?>
                        </div>
                    <?php endif;?>


                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group form-group-default required">
                                <?php echo $form->label($formModel, 'password'); ?>
                                <?php echo $form->passwordField($formModel, 'password', array('placeholder' => 'Enter Password','class'=>'form-control','required'=>true)); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-group-default required">
                                <?php echo $form->label($formModel, 'confirmPassword'); ?>
                                <?php echo $form->passwordField($formModel, 'confirmPassword', array('placeholder' => 'Enter Password Again','class'=>'form-control','required'=>true)); ?>
                            </div>
                            <?php echo $form->hiddenField($model,'email');?>
                        </div>
                    </div>
            <div class="m-t-20">
                <?php echo CHtml::submitButton('Update', array('class' => 'btn btn-success')); ?>
                <button class="btn btn-default"><i class="pg-close"></i> Clear</button>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>