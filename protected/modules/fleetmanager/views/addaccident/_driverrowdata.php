<div class="row passenger-row">
    <div class="col-xs-2">
        <div class="form-group form-group-default">
            <label>Reg</label>
            <input type="text" name="vehicle_regs[]" value="<?php echo $vehicle['reg'];?>" class="form-control"/>
        </div>
    </div>
    <div class="col-xs-1">
        <div class="form-group form-group-default">
            <label>Passengers</label>
            <input type="number" value="<?php echo $vehicle['passengers'];?>" name="number_of_pessengers[]" min="0" step="1" class="form-control"/>
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group form-group-default">
            <label>Driver Name</label>
            <input type="text" value="<?php echo $vehicle['driver_name'];?>" name="driver_name[]" class="form-control"/>
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group form-group-default">
            <label>Phone</label>
            <input type="text" value="<?php echo $vehicle['phone_number'];?>" name="phone_number[]" class="form-control"/>
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group form-group-default">
            <label>Insurer</label>
            <input type="text" value="<?php echo $vehicle['insurer'];?>" name="insurer[]"  class="form-control"/>
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group form-group-default">
            <label>Address</label>
            <input type="text" value="<?php echo $vehicle['address'];?>" name="address[]"  class="form-control"/>
        </div>
    </div>
    <div class="col-xs-1">
        <i class="fa fa-2x fa-remove remove-passenger" onclick="removePassengerRow(this)"></i>
    </div>

</div>