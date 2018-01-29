<div class="panel panel-transparent">
    <div class="panel-heading">
        <div class="panel-title">View Submitted Inspections
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12">
                <div class="pull-right">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/inspections/export" class="btn btn-primary">Export as .xls</a>
                </div>
            </div>
        </div>
        <?php

        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $model->allInspections(),
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
                'id'=>array(
                    'name'=>'Report ID',
                    'value'=>'"INS-000".$data->id',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'vehicle_type'=>array(
                    'name'=>'Vehicle Type',
                    'value'=>'$data->vehicle->vehicle_type',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'vehicle'=>array(
                    'name'=>'Vehicle',
                    'value'=>'$data->vehicle->vehicle_reg',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'defects'=>array(
                    'name'=>'Total Defects Reported',
                    'value'=>'DailyInspectionReport::getTotalDefects($data->id)',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'claim_cost'=>array(
                    'name'=>'Claim Cost',
                    'value'=>'!empty($data->claim_cost)?"&pound".number_format($data->claim_cost,2):"N/A"',
                    'htmlOptions'=>array('class'=>'v-align-middle'),
                    'type'=>'raw'
                ),
                'submission_date'=>array(
                    'name'=>'Date Submission',
                    'value'=>'date("d M Y",strtotime($data->submitted_date))',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'defect_user'=>array(
                    'name'=>'Recorded From',
                    'value'=>'DailyInspectionReport::getDefectUser($data->user_type,$data->driver_id)',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'detail'=>array(
                    'name'=>'',
                    'value'=>'CHtml::link("View Detail",Yii::app()->createUrl("fleetmanager/inspections/detail",array("id"=>$data->id)),array("class"=>"btn btn-primary"))',
                    'type'=>'raw',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                )
            ),
            'htmlOptions' => array(
                'class' => 'table-responsive',
                'id' => "accidents-grid",
            )
        ));
        ?>
    </div>
</div>
<style>
    .fleet-td
    {
        background: #e4f5cb !important;
    }
</style>
<script>
    $("#accidents-grid").find("tbody").find("tr").each(function(){
        var eType=$(this).find('td').eq(6).text();
        if(eType=='Fleet Manager')
        {
            $(this).find('td').addClass('fleet-td');
        }
    });
</script>