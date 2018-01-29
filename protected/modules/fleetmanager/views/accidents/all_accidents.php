<div class="panel panel-transparent">
    <div class="panel-heading">
        <div class="panel-title">All Accidents
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $model->search(),
//            'filter' => $model,
            'summaryText' => '',
            'emptyText' => 'There is no accident data to show',
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
                    'name'=>'Accident ID',
                    'value'=>'date("Ymd").$data->id',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'driver_id'=>array(
                    'name'=>'Driver',
                    'value'=>'$data->driver->full_name',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'vehicle_type'=>array(
                    'name'=>'Type',
                    'value'=>'Accident::getVehicleTypeInAccident($data->vehicle_reg)',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'vehicle_reg'=>array(
                    'name'=>'Vehicle',
                    'value'=>'$data->vehicle_reg.", ".$data->make.", ".$data->model',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'claim_cost'=>array(
                    'name'=>'Claim Cost',
                    'value'=>'!empty($data->claim_cost)?"&pound".number_format($data->claim_cost,2):"N/A"',
                    'htmlOptions'=>array('class'=>'v-align-middle'),
                    'type'=>'raw'
                ),
                'occured_at'=>array(
                    'name'=>'Occured At',
                    'value'=>'date("jS M, Y",strtotime($data->occured_at))',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'source'=>array(
                    'name'=>'From',
                    'value'=>'$data->source',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'detail'=>array(
                    'name'=>'',
                    'value'=>'CHtml::link("Detail",Yii::app()->createUrl("fleetmanager/accidents/detail",array("id"=>$data->id)),array("class"=>"btn btn-primary"))',
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
        background: #e9ffd6 !important;
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