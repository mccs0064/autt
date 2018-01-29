<div class="panel panel-transparent">
    <div class="panel-heading">
        <div class="panel-title">All Accidents of <?php echo $fleetManager->first_name." ".$fleetManager->last_name ;?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $model->adminSearch(),
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
                    'name'=>'ID',
                    'value'=>'$data->id',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'driver_id'=>array(
                    'name'=>'Driver',
                    'value'=>'$data->driver->full_name',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'vehicle_reg'=>array(
                    'name'=>'Vehicle Reg',
                    'value'=>'$data->vehicle_reg',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'occured_at'=>array(
                    'name'=>'Occured At',
                    'value'=>'date("jS F, Y",strtotime($data->occured_at))',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'detail'=>array(
                    'name'=>'View Detail',
                    'value'=>'CHtml::link("View Detail",Yii::app()->createUrl("admin/fleetmanagers/accidentdetail",array("id"=>$data->id)),array("class"=>"btn btn-primary"))',
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