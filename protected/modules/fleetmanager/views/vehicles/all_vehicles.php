<div class="panel panel-transparent">
    <div class="panel-heading">
        <div class="panel-title">All Vehicles
        </div>
        <div class="btn-group pull-right m-b-10">
            <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/vehicles/add" class="btn btn-success">Add New Vehicle</a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $model->search(),
//            'filter' => $model,
            'summaryText' => '',
            'emptyText' => 'There are no vehicles to show',
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
                    'name'=>'Vehicle ID',
                    'value'=>'"VH-000".$data->id',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'vehicle_reg'=>array(
                    'name'=>'Reg',
                    'value'=>'$data->vehicle_reg',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'make'=>array(
                    'name'=>'Make',
                    'value'=>'$data->make',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'model'=>array(
                    'name'=>'Model',
                    'value'=>'$data->model',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'vehicle_type'=>array(
                    'name'=>'Type',
                    'value'=>'$data->vehicle_type',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'linked_drivers'=>array(
                    'name'=>'Linked Drivers',
                    'value'=>'Vehicle::getLinkedDrivers($data->id)',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'inspection_template'=>array(
                    'name'=>'Inspection Template',
                    'value'=>'Vehicle::getLinkedInspections($data->inspection_template_id)',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'update'=>array(
                    'name'=>'',
                    'value'=>'CHtml::link("Update",Yii::app()->createUrl("fleetmanager/vehicles/update",array("id"=>$data->id)),array("class"=>"btn btn-primary"))',
                    'type'=>'raw',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'details'=>array(
                    'name'=>'',
                    'value'=>'CHtml::link("Details",Yii::app()->createUrl("fleetmanager/vehicles/details",array("id"=>$data->id)),array("class"=>"btn btn-primary"))',
                    'type'=>'raw',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                )
            ),
            'htmlOptions' => array(
                'class' => 'table-responsive',
                'id' => "fleet-manager-driver-grid",
            )
        ));
        ?>
    </div>
</div>