<script src="<?php echo Yii::app()->request->baseUrl;?>/js/wizard.js" type="text/javascript"></script>

<div id="rootwizard" class="m-t-50">

    <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm">
        <?php $this->renderPartial('_topmenu');?>
    </ul>

    <div class="tab-content">
        <div class="tab-pane padding-20 slide-left active" id="basic-details">
            <h3>Accident Recording</h3>
            <span class="alert alert-info"><i class="fa fa-info-circle"></i> Upload the audio file related to the accident</span>

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'audio-info-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'htmlOptions' => array('class' => 'form-horizontal m-t-40', 'enctype' => 'multipart/form-data')
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
                <?php echo $form->label($model, 'file'); ?>
                <?php echo $form->fileField($model, 'file', array('placeholder' => 'Upload Audio File','class'=>'form-control','required'=>true)); ?>
            </div>

            <div class="m-t-20">
                <?php echo CHtml::submitButton('Upload', array('class' => 'btn btn-success')); ?>
            </div>

            <?php $this->endWidget(); ?>
        </div>
        <?php if(Yii::app()->user->hasState('audio')):
            $audio_path=Yii::app()->user->getState('audio');
            ?>
        <div class="row">
            <div class="col-xs-12">
            <h5>Existing Uploaded File</h5>
            <audio src="<?php echo Yii::app()->request->getBaseUrl(true).'/'.$audio_path;?>" preload="auto"/>
            <script>
                $(document).ready(function () {
                    audiojs.events.ready(function () {
                        var as = audiojs.createAll();
                    });
                });
            </script>
            </div>
        </div>
        <?php endif;?>
        <div class="row">
            <div class="col-xs-12 text-right">
                <a class="btn btn-danger" href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/addaccident/navigate/route/othervehiclephotos">Back</a>
                <a class="btn btn-primary" href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/addaccident/navigate/route/police">Next</a>
            </div>
        </div>
    </div>
</div>