<div class="login-container bg-white">
	<div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
		<img src="<?php echo Yii::app()->request->baseUrl;?>/img/aut_white_logo-cust.png" alt="logo" >
		<!-- START Login Form -->
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'login-form',
			'enableAjaxValidation'=>true,
			'htmlOptions'=>array(
				'class'=>'p-t-15',
				'role'=>'form'
			)
		)); ?>
		<?php
		$errors=$model->getErrors();
		if(!empty($errors)):?>
			<div class="alert alert-danger">
				<?php echo $form->errorSummary($model);?>
			</div>
		<?php endif;?>
			<!-- START Form Control-->
			<div class="form-group form-group-default">

				<label>Login</label>
				<div class="controls">
					<?php echo $form->emailField($model,'email',array('class'=>'form-control','placeholder'=>'Email')); ?>
				</div>
			</div>
			<!-- END Form Control-->
			<!-- START Form Control-->
			<div class="form-group form-group-default">
				<label>Password</label>
				<div class="controls">
					<?php echo $form->passwordField($model,'password',array('class'=>'form-control','placeholder'=>'Password')); ?>
				</div>
			</div>
			<!-- END Form Control-->
		<?php echo CHtml::submitButton('Login',array('class'=>'btn btn-primary btn-cons m-t-10')); ?>

		<?php $this->endWidget(); ?>
		<!--END Login Form-->
		<div class="pull-bottom sm-pull-bottom">
			<div class="m-b-30 p-r-80 sm-m-t-20 sm-p-r-15 sm-p-b-20 clearfix">

				<div class="col-sm-9 no-padding m-t-10">
					<p>
						<small>

						</small>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>










