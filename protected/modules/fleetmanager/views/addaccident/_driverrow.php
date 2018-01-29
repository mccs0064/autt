<div class="row passenger-row">
<div class="col-xs-2">
    <div class="form-group form-group-default">
        <label>Reg</label>
        <input type="text" name="vehicle_regs[]"  class="form-control" value="N/A"/>
    </div>
</div>
<div class="col-xs-1">
    <div class="form-group form-group-default">
        <label>Passengers</label>
        <input type="number"  name="number_of_pessengers[]" min="0" step="1" required class="form-control" value="0"/>
    </div>
</div>
<div class="col-xs-2">
    <div class="form-group form-group-default">
        <label>Driver Name</label>
        <input type="text"  name="driver_name[]" class="form-control" value="N/A"/>
    </div>
</div>
<div class="col-xs-2">
    <div class="form-group form-group-default">
        <label>Phone</label>
        <input type="text"  name="phone_number[]" class="form-control" value="N/A"/>
    </div>
</div>
<div class="col-xs-2">
    <div class="form-group form-group-default">
        <label>Insurer</label>
        <input type="text"  name="insurer[]"  class="form-control" value="N/A"/>
    </div>
</div>
<div class="col-xs-2">
    <div class="form-group form-group-default">
        <label>Address</label>
        <input type="text"  name="address[]" class="form-control" value="N/A"/>
    </div>
</div>
    <div class="col-xs-1">
        <i class="fa fa-2x fa-remove remove-passenger" onclick="removePassengerRow(this)"></i>
    </div>
</div>