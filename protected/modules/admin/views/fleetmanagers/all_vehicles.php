<div class="panel panel-transparent">
    <div class="panel-heading">
        <div class="panel-title">All Vehicles of <?php echo $model->fleetManager->first_name.' '.$model->fleetManager->last_name;?>
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
                    'name'=>'ID',
                    'value'=>'$data->id',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'vehicle_reg'=>array(
                    'name'=>'Registration Number',
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
                'driver_id'=>array(
                    'name'=>'Driver',
                    'value'=>'!empty($data->driver)?$data->driver->full_name:""',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
            ),
            'htmlOptions' => array(
                'class' => 'table-responsive',
                'id' => "fleet-manager-driver-grid",
            )
        ));
        ?>
    </div>
</div>