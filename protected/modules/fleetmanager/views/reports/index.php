<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl;?>/css/daterangepicker.min.css">
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/js/momen.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/js/jquery.daterangepicker.min.js"></script>
<div class="row">
    <div class="panel panel-transparent">
        <div class="panel-heading">
            <div class="panel-title">Search Reports
            </div>
        </div>
    </div>
    <!-- END PANEL -->
</div>
<div class="col-xs-12">
    <!-- START PANEL -->
    <div class="panel panel-transparent">
       <div class="panel-body">
           <?php if(Yii::app()->user->hasFlash('error')):?>
           <div class="row">
               <div class="col-xs-8">
                   <div class="alert alert-danger"><?php echo Yii::app()->user->getFlash('error');?></div>
               </div>
           </div><br/>
           <?php endif;?>
           <form method="get">
               <div class="row">
                   <div class="col-xs-2">
                       <?php echo CHtml::dropDownList('vehicle_type',$vehicle_type,$vehicle_types,array('class'=>'form-control','prompt'=>'All Vehicle Types','onchange'=>'getVehiclesByType(this)'));?>
                   </div>
                   <div class="col-xs-2">
                       <?php echo CHtml::dropDownList('vehicle',$vehicle,CHtml::listData($vehicles,'id','select_option'),array('class'=>'form-control','prompt'=>'All Vehicles','id'=>'vehicle_id'));?>
                   </div>
                   <div class="col-xs-2">
                       <?php echo CHtml::dropDownList('driver',$driver,CHtml::listData($drivers,'id','full_name'),array('class'=>'form-control','prompt'=>'All Drivers'));?>
                   </div>
                   <div class="col-xs-2">
                       <input type="text" name="range" value="<?php echo $date_range;?>" id="date_range" class="form-control"/>
                   </div>
                   <div class="col-xs-2">


                           <input type="checkbox" onchange="changeCheck(this)" name="defects" value="<?php echo $defects;?>" <?php echo $defects==true?'checked':'';?>/>
                           <label>Defects</label>


                   </div>
                   <div class="col-xs-2">
                       <?php echo CHtml::submitButton('Search',array('class'=>'btn btn-primary','id'=>'search'));?>
                   </div>
               </div>
               <br/>

               <div class="row">
                   <div class="col-xs-12">
                       <?php
                       $url=Yii::app()->request->baseUrl.'/fleetmanager/reports/export?'.Yii::app()->request->getQueryString();

                       ?>
                       <a href="<?php echo $url;?>" class="btn btn-primary pull-right">Export as .xls</a>
                   </div>
               </div>
           </form>
           <?php

           $this->widget('zii.widgets.grid.CGridView', array(
               'dataProvider' => $model->searchModel(),
//            'filter' => $model,
               'summaryText' => '',
               'emptyText' => 'There is no inspection items data to show',
               'itemsCssClass' => 'table table-hover',
               'pagerCssClass' => 'dataTables_paginate paging_bootstrap text-center paginationBg',
               'pager' => array(
                   'prevPageLabel' => '‹  Previous',
                   'nextPageLabel' => 'Next  ›',
                   'firstPageLabel' => '«  First',
                   'lastPageLabel' => 'Last  »',
                   'header' => '',
                   'htmlOptions' => array('class' => 'pagination')
               ),
               'columns' => array(
                   'vehicle_type'=>array(
                       'name'=>'Vehicle Type',
                       'value'=>'$data->vehicle->vehicle_type',
                       'htmlOptions'=>array('class'=>'v-align-middle')
                   ),
                   'vehicle'=>array(
                       'name'=>'Vehicle',
                       'value'=>'$data->vehicle->make." - ".$data->vehicle->vehicle_reg',
                       'htmlOptions'=>array('class'=>'v-align-middle')
                   ),
                   'total_defects'=>array(
                       'name'=>'Total Defects Reported',
                       'value'=>'DailyInspectionReport::getTotalDefects($data->id)',
                       'htmlOptions'=>array('class'=>'v-align-middle')
                   ),
                   'submission_date'=>array(
                       'name'=>'Submission Date',
                       'value'=>'date("d M Y",strtotime($data->submitted_date))',
                       'htmlOptions'=>array('class'=>'v-align-middle')
                   ),
                   'driver'=>array(
                       'name'=>'Driver',
                       'value'=>'$data->user_type=="Fleet Manager"?"Fleet Manager":$data->driver->full_name',
                       'htmlOptions'=>array('class'=>'v-align-middle')
                   ),

               ),
               'htmlOptions' => array(
                   'class' => 'table-responsive',
                   'id' => "inspections-grid",
               )
           ));
           ?>
       </div>

    </div>
</div>

<script>
    function getVehiclesByType(obj) {
        var vehicle_type=$(obj).val();
        $.ajax({
            type: 'post',
            url: '<?php echo Yii::app()->createUrl("fleetmanager/reports/getvehiclesbytype");?>',
            data: {vehicle_type: vehicle_type},
            success: function(data){
                $("#vehicle_id").html('').append('<option>All Vehicles</option>');
                var response=$.parseJSON(data);
                $.each(response, function (i, item) {
                    $('#vehicle_id').append($('<option>', {
                        value: item.id,
                        text : item.name
                    }));
                });

            }

        });
    }
   function changeCheck(obj) {
       var checked=$(obj).prop('checked');
       $(obj).val(checked);
   }
    $(document).ready(function () {
        $("#date_range").dateRangePicker({
            endDate: new Date()
        });
    });
    
</script>

<style>
    .fleet-td
    {
        background: #e4f5cb !important;
    }
</style>
<script>
    $("#inspections-grid").find("tbody").find("tr").each(function(){
        var eType=$(this).find('td').eq(4).text();
        if(eType=='Fleet Manager')
        {
            $(this).find('td').addClass('fleet-td');
        }
    });
</script>