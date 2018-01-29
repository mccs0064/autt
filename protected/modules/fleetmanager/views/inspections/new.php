<div class="container-fluid container-fixed-lg">
    <!-- START PANEL -->
    <div class="panel panel-transparent">
        <div class="panel-heading">
            <div class="panel-title">Complete an Inspection
            </div>
        </div>
        <div class="panel-body">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'update-profile-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'htmlOptions' => array('class' => 'form-horizontal')
            ));
            ?>
            <div class="row">
                <div class="col-xs-5">
                    <div class="form-group form-group-default">
                       <label>Vehicle</label>
                        <?php echo $form->dropDownList($model, 'vehicle_id',CHtml::listData($vehicles,'id','select_option'),array('class'=>'form-control','onchange'=>'loadInspectionList(this)','id'=>'vehicle_select','prompt'=>'Please select')); ?>
                    </div>
                </div>
                <div class="col-xs-7">
                    <p class="alert alert-info" style="margin-left: 10px;">Only vehicles appearing in the list where inspection template is connected</p>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-5">
                    <div class="form-group form-group-default">
                        <label>Date and Time</label>
                        <?php
                        $this->widget(
                            'ext.jui.EJuiDateTimePicker',
                            array(
                                'model'     => $model,
                                'attribute' => 'date_submitted',
                                'language'=> 'en',//default Yii::app()->language
                                'mode'    => 'datetime',//'datetime' or 'time' ('datetime' default)
                                'options'   => array(
                                    'dateFormat' => 'dd/mm/yy',
                                    'timeFormat' => 'hh:mm tt'
                                ),
                                'htmlOptions'=>array(
                                    'class'=>'form-control',
                                    'id'=>'date_submitted'
                                )
                            )
                        );
                        ?>
                    </div>
                </div>
            </div>
            <br/>
            <br/><br/>

            <div id="inspection_container">

            </div>
<br/><br/>
            <div class="row">
                <div class="col-xs-12">

                    <a href="#" class="btn btn-primary pull-right">Cancel</a> &nbsp;
                    <button class="btn btn-primary pull-right" style="margin-right: 10px;" onclick="return submitInspection()">Submit</button>
                </div>
            </div>


            <?php $this->endWidget();?>
        </div>
    </div>
    <!-- END PANEL -->
</div>

<div class="modal fade slide-up" id="add-note-modal" tabindex="-1" role="dialog" aria-hidden="false" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                    </button>
                    <h5><span class="semi-bold">Defect Details</span></h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <textarea id="note-area" class="form-control" rows="5"></textarea>
                        <input type="hidden" id="inspection_note_id">
                        <br/>
                        <button class="btn btn-primary" onclick="saveNote()">Save Note</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>

<script>

    function hasNotes() {
        $('.defect-row').each(function(){
            var content=$(this).attr('data-content');
            if(content.length>0)
            {
                $(this).find('.add-note-btn').html('Add note <i class="fa fa-list"></i>');
            }
            else
            {
                $(this).find('.add-note-btn').html('Add note');
            }
        });
    }
    function loadInspectionList(obj)
    {
        var $this=$(obj);
        var vehicle_id=$this.val();
        if(vehicle_id=='')
        {
            $("#inspection_container").hide();
        }
        else
        {
            $("#inspection_container").show();
        }
        $.ajax({
            type: 'post',
            data: {vehicle_id: vehicle_id},
            url: '<?php echo Yii::app()->createUrl("fleetmanager/inspections/loadlist");?>',
            success: function(res){
                $("#inspection_container").html(res);
                $('.defect-row').find('.onoffswitch-checkbox').prop('checked',false);
                hasNotes();
                $(".onoffswitch-checkbox").each(function () {
                    changeDefectStatus(this);
                });
            }
        });
    }

    function addNote(row_id) {
        var existing_content=$("#"+row_id).attr('data-content');
        $("#note-area").val(existing_content);
        $('#inspection_note_id').val(row_id);
        $("#add-note-modal").modal('show');

    }
    
    function saveNote() {

        var row_id=$("#inspection_note_id").val();
        var note_content=$("#note-area").val();
        if(note_content=='')
        {
            alert('Please enter notes and then press save');
            return false;
        }
        $("#"+row_id).attr('data-content',note_content);
        $("#add-note-modal").modal('hide');
        hasNotes();
        
    }

    $(document).ready(function () {
        $("#vehicle_select").trigger('change');


    });
    function submitInspection() {

        var vehicle_id=$("#vehicle_select").val();
        if(vehicle_id=='')
            return false;
        var choice=window.confirm('Are you sure you want to submit the inspection?');
        if(choice==true)
        {

            var date_submitted=$("#date_submitted").val();
            if(date_submitted=='')
            {
                alert('Please select the date of submission');
                return false;
            }
            var defects=[];
            $(".defect-row").each(function () {
                var defectObj={};
                defectObj.content=$(this).attr('data-content');
                defectObj.defect_name=$(this).find('td').eq(1).text();
                defectObj.inspected=$(this).find('.onoffswitch-checkbox').prop('checked');
                defects.push(defectObj);

            });
            $.ajax({
                type: 'post',
                data: {vehicle_id: vehicle_id,date_submitted: date_submitted,defects: defects},
                url: '<?php echo Yii::app()->createUrl("fleetmanager/inspections/savefleetinspection");?>',
                success: function (res) {
                    var response=$.parseJSON(res);
                    if(response.status==true)
                    {
                        window.location=response.url;
                    }
                }
            });
        }

        return false;
    }
    
    function changeDefectStatus(obj) {
        var $this=$(obj);
        var checked=$this.prop('checked');
        var buttonref=$this.closest('td').prev().find('.add-note-btn');
        if(checked==true)
        {
            buttonref.attr('disabled',false);
        }
        else
        {
            buttonref.attr('disabled',true);
        }
    }
</script>

<style>
    .ui-datepicker
    {
        z-index: 9999 !important;
    }
</style>