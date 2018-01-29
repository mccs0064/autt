<div class="panel panel-transparent">
    <div class="panel-heading">
        <div class="panel-title">Daily Inspection Reports
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $model->search(),
//            'filter' => $model,
            'summaryText' => '',
            'emptyText' => 'There are no vehicle inspection reports to show',
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
                'vehicle_id'=>array(
                    'name'=>'Vehicle',
                    'value'=>'$data->vehicle->vehicle_reg',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'due_date'=>array(
                    'name'=>'Submitted Date',
                    'value'=>'date("jS F, Y",strtotime($data->submitted_date))',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'occured_at'=>array(
                    'name'=>'status',
                    'value'=>'$data->status',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'detail'=>array(
                    'name'=>'Details',
                    'value'=>'CHtml::link("View Detail",Yii::app()->createUrl("fleetmanager/inspectionreports/detail",array("id"=>$data->id)),array("class"=>"btn btn-primary"))',
                    'type'=>'raw',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                )
            ),
            'htmlOptions' => array(
                'class' => 'table-responsive',
                'id' => "inspection-report-grid",
            )
        ));
        ?>
    </div>
</div>