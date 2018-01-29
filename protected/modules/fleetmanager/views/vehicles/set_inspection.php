<div class="row">
    <div class="panel panel-transparent">
        <div class="panel-heading">
            <div class="panel-title">Vehicles
            </div>
        </div>
        <div class="panel-body">
            <h3>Set Inspection</h3>
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
                'id' => 'set-inspection-form',
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
                    <div class="form-group form-group-default">
                        <label>Vehicle Registration Number</label>
                        <p><?php echo $vehicle->vehicle_reg;?></p>
                    </div>
                    <div class="form-group form-group-default required">
                        <?php echo $form->label($model, 'due_date'); ?>
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'attribute' => 'due_date',
                            'model' => $model,
                            'options' => array(
                                'dateFormat' => 'd MM, yy',
                                'changeYear' => true,
                            ),
                            'htmlOptions' => array(
                                'class' => 'form-control',
                                'value' => ($model->due_date) ? date('j F, Y', strtotime($model->due_date)) : null
                            ),
                        ));
                        ?>
                    </div>
                    <h3>Checklists</h3>
                    <div class="checklist-item">
                        <input type="text" name="checklists[]" class="form-control checklist-input"/>
                        <div class="checklist-actions">
                            <i class="fa fa-plus add-item" onclick="addItem()"></i>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="m-t-20">
                        <?php echo CHtml::submitButton('Set Inspection', array('class' => 'btn btn-success')); ?>
                        <button class="btn btn-default"><i class="pg-close"></i> Clear</button>
                    </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<style>
    .checklist-input
    {
        float:left;
        width:85%;
    }
    .add-item
    {
        padding: 5px;
        font-size: 20px;
        cursor: pointer;
    }
    .remove-item
    {
        font-size: 20px;
        padding-left: 10px;
        cursor: pointer;
    }
    .checklist-item
    {
        margin-bottom:10px;
    }
</style>

<script>
    var checklistHTML='<div class="checklist-item"><input type="text" name="checklists[]" class="form-control checklist-input"/> <div class="checklist-actions"> <i class="fa fa-plus add-item" onclick="addItem()"></i> <i class="fa fa-minus remove-item" onclick="removeItem(this)"></i></div> <div class="clearfix"></div> </div>';
    function addItem()
    {
        $(checklistHTML).insertAfter($(".checklist-item:last"));
    }
    function removeItem(obj)
    {
        var $this=$(obj);
        $this.parent().parent().remove();
    }
</script>