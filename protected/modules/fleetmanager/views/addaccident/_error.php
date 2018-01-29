<?php if(Yii::app()->user->hasFlash('error')):?>
<div class="alert alert-danger">
    <?php echo Yii::app()->user->getFlash('error');?>
</div>
<?php endif;?>

<?php
$errors=$model->getErrors();
if(!empty($errors)):?>
    <div class="alert alert-danger">
        <?php echo $form->errorSummary($model);?>
    </div>
<?php endif;?>
