<script src="<?php echo Yii::app()->request->baseUrl;?>/js/wizard.js" type="text/javascript"></script>

<div id="rootwizard" class="m-t-50">

    <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm">
        <?php $this->renderPartial('_topmenu');?>
    </ul>

    <div class="tab-content">

        <div class="tab-pane padding-20 slide-left active" id="basic-details">
            <br/>
            <h3>Other Driver Information</h3>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'basic-info-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'htmlOptions'=>array(
                    'data-module'=>'Basic',
                    'class'=>'m-t-40'
                )
            ));
            ?>
            <div id="passengerrows">
            <?php if(Yii::app()->user->hasState('otherVehicles')):
            $otherVehicles=Yii::app()->user->getState('otherVehicles');

            foreach($otherVehicles as $key=> $vehicle):?>

                <?php $this->renderPartial('_driverrowdata',array('vehicle'=>$vehicle));?>

            </div>
            <?php endforeach;
            else:?>

<!--                    <div class="hidden">--><?php //$this->renderPartial('_driverrow');?><!--</div>-->


            <?php endif;?>
            </div>
            <div class="row">
                <a class="btn btn-primary" id="add-more-rows">Add Vehicle</a>

                <div class="m-t-20">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
<br/><br/>
            <div class="row">
                <div class="col-xs-12 text-right">
                    <a class="btn btn-danger" href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/addaccident/navigate/route/myvehiclephotos">Back</a>
                    <a class="btn btn-primary" href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/addaccident/navigate/route/othervehiclephotos">Next</a>
                </div>
            </div>


            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<div class="hidden" id="driver-row">
<?php $this->renderPartial('_driverrow');?>
</div>

<script>
    $("#add-more-rows").click(function(){
        var passengerRow=$("#driver-row").html();

//        var passengerRow='  <div class="row passenger-row"><div class="col-xs-2"><div class="form-group form-group-default required"><label>Vehicle Reg</label><input type="text" name="vehicle_regs[]"  required class="form-control"/></div></div><div class="col-xs-1"><div class="form-group form-group-default required"><label>Passengers</label><input type="number"  name="number_of_pessengers[]" min="1" step="1" required class="form-control"/></div></div> <div class="col-xs-2"><div class="form-group form-group-default required"><label>Driver Name</label><input type="text"  name="driver_name[]" class="form-control"/></div></div><div class="col-xs-2"><div class="form-group form-group-default required"><label>Phone</label><input type="text"  name="phone_number[]" class="form-control"/></div></div><div class="col-xs-2"><div class="form-group form-group-default required"><label>Insurer</label><input type="text"  name="insurer[]"  required class="form-control"/></div></div><div class="col-xs-2"><div class="form-group form-group-default required"><label>Address</label><input type="text"  name="address[]"  required class="form-control"/></div></div></div> <i class="fa fa-2x fa-remove remove-passenger" onclick="removePassengerRow(this)"></i> </div> </div>';
//        $(passengerRow).insertAfter($(".passenger-row:last"));
        $("#passengerrows").append(passengerRow);
    });

    function removePassengerRow(obj)
    {
        var $this=$(obj);
        $this.parent().parent().remove();
    }




</script>