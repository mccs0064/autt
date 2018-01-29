<div class="container-fluid container-fixed-lg">
    <!-- START PANEL -->
    <div class="panel panel-transparent">
        <div class="panel-heading">
            <div class="panel-title" style="width:300px;">Inspection Report
<br/><br/>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="form-group form-group-default">
                            <span>Claim Cost:</span><input type="number" step="any" class="form-control" id="claim_cost" value="<?php echo $model->claim_cost;?>"/>
                            <input type="hidden" value="<?php echo $model->id;?>" id="model_id"/>
                        </div>

                    </div>
                    <div class="col-xs-4">
                        <button class="btn btn-primary" id="save-claim-cost">Save</button>
                    </div>
                </div>
            </div>
            <div class="pull-right">
                <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/inspections/download/id/<?php echo $model->id;?>" class="btn btn-primary">Download PDF</a>
            </div>
        </div>
       <?php $this->renderPartial('_inspection_detail',array('model'=>$model));?>
    </div>
    <!-- END PANEL -->
</div>
<?php $this->renderPartial('_styling');?>

<script>
    $("#save-claim-cost").click(function(){
        var model_id=$("#model_id").val();
        var claim_cost=$("#claim_cost").val();
        $.ajax({
            type: 'post',
            url: '<?php echo Yii::app()->createUrl("fleetmanager/inspections/updateclaimcost");?>',
            data: {claim_cost: claim_cost, model_id: model_id},
            success: function (res) {
                window.location.reload();

            }
        });
    });

    $(document).ready(function(){
        $(".defect_reported_class").each(function(){
            var $this=$(this);
            if($this.text()=='Yes')
            {
                var row=$this.closest('tr');
                row.each(function(){
                    $(this).find('td').addClass('fleet-td');
                });
            }
        });
    });
</script>
