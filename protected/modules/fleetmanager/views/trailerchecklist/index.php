<div class="row">
    <div class="panel panel-transparent">
        <div class="panel-body">
            <h3>Build Trailer Inspection List</h3>
        </div>
    </div>
    <!-- END PANEL -->
</div>
<div class="col-sm-7">
    <!-- START PANEL -->
    <div class="panel panel-transparent">
        <div class="panel-body">

            <div class="form-group form-group-default">
                <?php echo CHtml::textField('checklist_item', '', array('class' => 'form-control', 'id' => 'checklist-input')) ?>
            </div>

            <div class="m-t-20">
                <?php echo CHtml::button('Add', array('class' => 'btn btn-success', 'id' => 'add-btn')); ?>
            </div>
            <div>
                <h4>List Items</h4>
                <div id="inspection-list">
                    <?php if (!empty($items)):
                        foreach ($items as $item):?>
                            <div class="row checklist-item">
                                <div class="col-xs-6 large-text">
                                    <?php echo $item['item_name']; ?>
                                </div>
                                <div class="col-xs-1">
                                    <i class="fa fa-remove fa-2x cursor delete-item"
                                       data-id="<?php echo $item['id']; ?>"></i>
                                </div>
                            </div>
                        <?php endforeach;
                    else:?>
                        <div class="alert alert-info">
                            Your inspection checklist is empty
                        </div>


                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>


<script>
    $("#add-btn").click(function () {
        var checklist_name = $("#checklist-input").val();
        if (checklist_name == '' || checklist_name == undefined || checklist_name == null) {
            alert('Please enter the name of checklist item');
            return false;
        }

        $.ajax({
            type: 'post',
            url: '<?php echo Yii::app()->createUrl("fleetmanager/trailerchecklist/add");?>',
            data: {item_name: checklist_name},
            success: function (resp) {
                var response = $.parseJSON(resp);
                if (response.status == true) {
                    if ($("#inspection-list").find('.checklist-item').length == 0) {
                        $("#inspection-list").html('');
                    }

                    var appendHTML = '<div class="row checklist-item"><div class="col-xs-6 large-text">' + response.data.item_name + ' </div> <div class="col-xs-1"> <i class="fa fa-remove fa-2x cursor delete-item" data-id="' + response.data.id + '"></i> </div></div>';
                    $("#inspection-list").append(appendHTML);
                    $("#checklist-input").val('');
                }

            }
        });

    });
    $(".delete-item").on('click',function(){
        var inspection_id = $(this).attr('data-id');
        var $this = $(this);
        $.ajax({
            type: 'post',
            url: '<?php echo Yii::app()->createUrl("fleetmanager/trailerchecklist/delete");?>',
            data: {inspection_id: inspection_id},
            success: function (resp) {
                var response = $.parseJSON(resp);
                if (response.status == true) {
                    $this.parent().parent().remove();
                    if ($("#inspection-list").find('.checklist-item').length == 0) {
                        $("#inspection-list").html(' <div class="alert alert-info">Your inspection checklist is empty </div>');
                    }
                }

            }
        });
    });
</script>

