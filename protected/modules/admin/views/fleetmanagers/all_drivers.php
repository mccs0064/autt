<div class="panel panel-transparent">
    <div class="panel-heading">
        <div class="panel-title">All Drivers of <?php echo $model->fleetmanager->first_name.' '.$model->fleetmanager->last_name;?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $model->search(),
//            'filter' => $model,
            'summaryText' => '',
            'emptyText' => 'There are no drivers to show',
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
                'email'=>array(
                    'name'=>'Email',
                    'value'=>'$data->email',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'full_name'=>array(
                    'name'=>'Full Name',
                    'value'=>'$data->full_name',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'status'=>array(
                    'name'=>'Status',
                    'value'=>'$data->status',
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