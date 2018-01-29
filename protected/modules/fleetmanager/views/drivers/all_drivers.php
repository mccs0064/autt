<div class="panel panel-transparent">
    <div class="panel-heading">
        <div class="panel-title">All Drivers
        </div>
        <div class="btn-group pull-right m-b-10">
            <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/drivers/add" class="btn btn-success">Add New Driver</a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $model->search(),
            'summaryText' => '',
            'emptyText' => 'There are no drivers to show',
            'itemsCssClass' => 'table table-hover table-condensed',
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
                'email'=>array(
                    'name'=>'autium_id',
                    'value'=>'$data->autium_id',
                    'filter'=>CHtml::activeTextField($model, 'autium_id',array("class"=>"form-control")),
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'full_name'=>array(
                    'name'=>'full_name',
                    'value'=>'$data->full_name',
                    'filter'=>CHtml::activeTextField($model, 'full_name',array("class"=>"form-control")),
                    'htmlOptions'=>array('class'=>'v-align-middle'),
                    'headerHtmlOptions'=>array('clsss'=>'sorting_asc'),
            ),
                'total_accidents'=>array(
                    'name'=>'Accidents',
                    'value'=>'DriverSearch::getTotalAccidents($data->id)',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'linked_vehicles'=>array(
                    'name'=>'Linked Vehicles',
                    'value'=>'DriverSearch::getLinkedVehicles($data->id)',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'status'=>array(
                    'name'=>'status',
                    'value'=>'$data->status=="Active"?"Active":"Inactive"',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'profile'=>array(
                    'name'=>'',
                    'value'=>'CHtml::link("Details",Yii::app()->createUrl("fleetmanager/drivers/view",array("id"=>$data->id)),array("class"=>"btn btn-primary"))',
                    'type'=>'raw',
                    'htmlOptions'=>array('class'=>'v-align-middle auto-width-btn')
                ),
                'update'=>array(
                    'name'=>'',
                    'value'=>'CHtml::link("Update",Yii::app()->createUrl("fleetmanager/drivers/update",array("id"=>$data->id)),array("class"=>"btn btn-primary"))',
                    'type'=>'raw',
                    'htmlOptions'=>array('class'=>'v-align-middle auto-width-btn')
                )
            ),
            'htmlOptions' => array(
                'class' => 'table table-responsive',
                'id' => "fleet-manager-driver-grid"
            )
        ));
        ?>
    </div>
</div>

<style>
    .inactive-td
    {
        background: rgba(255, 236, 236, 0.31) !important;
        color: #c3c0c0;
    }
    .table.table-condensed thead tr th, .table.table-condensed tbody tr td, .table.table-condensed tbody tr td *:not(.dropdown-default)
    {
        width: 130px;
    }
    .auto-width-btn
    {
        width: auto !important;
    }
</style>

<script>
    $(document).ready(function(){
        $("#fleet-manager-driver-grid").find('tbody').find('tr').each(function(){
            var $this=$(this);
            var status=$this.find('td').eq(4).text();
            if(status=='Inactive')
            {
                $this.find('td').addClass('inactive-td');
            }
        });
    });
    
</script>