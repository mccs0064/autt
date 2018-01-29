<div class="row">
    <div class="panel panel-transparent">
        <div class="panel-heading">
            <div class="panel-title"><?php echo ($model->isNewRecord == true) ? 'Add New' : 'Update'; ?> Vehicle
            </div>
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
                'id' => 'add-vehicle-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>
            <?php
            $errors = $model->getErrors();
            if (!empty($errors)):?>
                <div class="alert alert-danger">
                    <?php echo $form->errorSummary($model); ?>
                </div>
            <?php endif; ?>
            <div class="form-group form-group-default required">
                <?php echo $form->label($model, 'vehicle_reg'); ?>
                <?php echo $form->textField($model, 'vehicle_reg', array('placeholder' => 'Enter Vehicle Registration Number', 'class' => 'form-control', 'required' => true)); ?>
            </div>
            <div class="form-group form-group-default required">
                <?php echo $form->label($model, 'make'); ?>
                <?php echo $form->textField($model, 'make', array('placeholder' => 'Enter Vehicle Make', 'class' => 'form-control', 'required' => true)); ?>
            </div>
            <div class="form-group form-group-default required">
                <?php echo $form->label($model, 'model'); ?>
                <?php echo $form->textField($model, 'model', array('placeholder' => 'Enter Vehicle Model', 'class' => 'form-control', 'required' => true)); ?>
            </div>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'serial_number'); ?>
                <?php echo $form->textField($model, 'serial_number', array('placeholder' => 'Enter Serial Number', 'class' => 'form-control')); ?>
            </div>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'gross_vehicle_weight'); ?>
                <?php echo $form->textField($model, 'gross_vehicle_weight', array('placeholder' => 'Enter Gross Vehicle Weight', 'class' => 'form-control')); ?>
            </div>
            <div class="form-group form-group-default required">
                <?php echo $form->label($model, 'vehicle_type'); ?>
                <?php echo $form->dropDownList($model, 'vehicle_type',array('S-Type'=>'S-Type','R-Type'=>'R-Type','Car'=>'Car','Van'=>'Van','Truck'=>'Truck'), array('prompt' => 'Please select', 'class' => 'form-control')); ?>
            </div>
            <?php
             $inspectionTemplates=InspectionTemplate::model()->findAllByAttributes(array('fleetmanager_id'=>Yii::app()->user->id));

            ?>


            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'next_mot'); ?>
                <?php
                $this->widget(
                    'ext.jui.EJuiDateTimePicker',
                    array(
                        'model' => $model,
                        'attribute' => 'next_mot',
                        'language' => 'en',//default Yii::app()->language
                        'mode'    => 'date',//'datetime' or 'time' ('datetime' default)
                        'options' => array(
                            'dateFormat' => 'dd/mm/yy',
                            //'timeFormat' => '',//'hh:mm tt' default
                        ),
                        'htmlOptions' => array(
                            'class' => 'form-control',
                            'placeholder'=>'DD/MM/YYYY'
                        )
                    )
                );
                ?>
            </div>
            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'tax_expires'); ?>
                <?php
                $this->widget(
                    'ext.jui.EJuiDateTimePicker',
                    array(
                        'model' => $model,
                        'attribute' => 'tax_expires',
                        'language' => 'en',//default Yii::app()->language
                        'mode'    => 'date',//'datetime' or 'time' ('datetime' default)
                        'options' => array(
                            'dateFormat' => 'dd/mm/yy',
                            //'timeFormat' => '',//'hh:mm tt' default
                        ),
                        'htmlOptions' => array(
                            'class' => 'form-control',
                            'placeholder'=>'DD/MM/YYYY'
                        )
                    )
                );
                ?>
            </div>

            <div class="form-group">
                <label>Linked Drivers</label>

            </div>

            <div>
                <span>
                    <select class="" id="driver-ms" multiple="multiple" name="drivers[]">
                        <?php foreach ($drivers as $driver): ?>
                            <option <?php echo in_array($driver['id'], $model->getDrivers()) ? 'selected="selected"' : null; ?>
                                value="<?php echo $driver['id']; ?>"><?php echo $driver['full_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </span>
                <span><button style="margin-top: 10px; margin-bottom: 10px;" class="btn btn-sm btn-primary" onclick="return selectAllDrivers()">Select All Drivers</button></span>
            </div>

            <div class="form-group form-group-default">
                <?php echo $form->label($model, 'inspection_template_id'); ?>
                <?php echo $form->dropDownList($model, 'inspection_template_id',CHtml::listData($inspectionTemplates,'id','template_name') ,array('prompt' => 'None', 'class' => 'form-control','onchange'=>'getInspectionItems(this)','id'=>'change_insp')); ?>

            </div>
            <div id="inspection_template_items"></div>
            <div class="m-t-20">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Add Vehicle' : 'Update Vehicle', array('class' => 'btn btn-success')); ?>
                <a href="<?php echo Yii::app()->request->baseUrl; ?>/fleetmanager/vehicles" class="btn btn-default"><i
                        class="pg-close"></i> Cancel</a>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#driver-ms").select2();
        $("#change_insp").trigger('change');
    });

    function selectAllDrivers()
    {
        var selectedItems = [];
        var allOptions = $("#driver-ms option");
        allOptions.each(function() {
            selectedItems.push( $(this).val() );
        });
        $("#driver-ms").val(selectedItems).trigger("change");
        return false;
    }
    function getInspectionItems(obj) {
        var $this=$(obj);
        var template_id=$this.val();
        $.ajax({
            type: 'post',
            url: '<?php echo Yii::app()->request->getBaseUrl(true);?>/fleetmanager/inspectiontemplates/getitems',
            data: {template_id: template_id},
            success: function(response)
            {
                $("#inspection_template_items").html(response);
            }
        });
    }
</script>

<style>
    .select2-container {
        min-width: 500px !important;
    }
</style>