
<div class="page-header">
    <div class="row">
        <div class="medium-6 columns">
            <ul class="breadcrumbs">
                <li><a href="<?php echo Yii::app()->request->getBaseUrl(true); ?>">Home</a></li>
                <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/login">Login</a></li>
            </ul>
        </div>
    </div>
</div>


<div class="main-content login-content">
    <div class="row">
        <div class="columns text-center">
            <h1>Login</h1>
            <p>Don't have any account?<br><a href="<?php echo Yii::app()->request->baseUrl; ?>/register">Sign Up</a></p>
            <div class="row sign-with-socials">
                <div class="medium-6 columns text-right">
                    <a href="<?php echo $facebook_url; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/facebook-register.png" alt=""></a>
                </div>
                <div class="medium-6 columns text-left">
                    <a href="<?php echo $linkedin_url; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/linkedin-register.png" alt=""></a>
                </div>
                <br>
                <br>
                <p><em>By clicking Log in, Facebook or Linkedin you agree to our T&C's</em></p>
            </div>
            <br>
            <br>
            <div class="or"><span>or</span></div>
            <br>
        </div>
    </div>

    <div class="row">
        <div class="columns medium-centered">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'login-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>
            <div class="row">
                <div class="columns">
                    <?php
                    $errors = $login->getErrors();
                    if (!empty($errors)) {
                        ?>
                        <div class="alert-box alert radius">
                            <?php echo $form->errorSummary($login); ?>
                        </div>
                    <?php } ?>
                    <?php if (Yii::app()->user->hasFlash('error')) { ?>
                        <div class="alert-box alert radius"><?php echo Yii::app()->user->getFlash('error'); ?></div>
                    <?php } ?>
                    <?php if (Yii::app()->user->hasFlash('success')) { ?>
                        <div class="alert-box alert-success radius"><p class="white-text"><?php echo Yii::app()->user->getFlash('success'); ?></p></div>
                    <?php } ?>
                    <br>
                </div>
            </div>
            <p>
                <label>EMAIL</label>
                <?php echo $form->emailField($login, 'email'); ?>
                <?php if ($login->getError('email')): ?>
                    <label id="email-error" class="error" for="email"><?php echo $login->getError('email'); ?></label>
                <?php endif; ?>
            </p>
            <p>
                <label>PASSWORD</label>
                <?php echo $form->passwordField($login, 'password'); ?>
                <?php if ($login->getError('password')): ?>
                    <label id="password-error" class="error" for="password"><?php echo $login->getError('password'); ?></label>
                <?php endif; ?>
            </p>
            <div class="row collapse">
                <div class="medium-6 columns">
                    <span class="checkbox-wrapper">
                        <input type="checkbox">
                    </span>
                    <span class="remember-me">REMEMBER ME</span>
                </div>
                <div class="medium-6 columns text-right">
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/forgotpassword" class="forgot-password">Forgot password?</a>
                </div>
            </div>
            <button type="submit" class="button clearfix">
                <span class="icon-wrapper"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/secure.png" alt=""></span>
                <span class="name">SECURE LOGIN</span>
            </button>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
