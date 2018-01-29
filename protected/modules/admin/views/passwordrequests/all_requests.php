<div class="panel panel-transparent">
    <div class="panel-heading">
        <div class="panel-title">All Change Password Requests
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $model->search(),
            'summaryText' => '',
            'emptyText' => 'There are no change password requests to show',
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
                    'value'=>'$data->email',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'date_requested'=>array(
                    'name'=>'Date Requested',
                    'value'=>'date("jS F, Y",strtotime($data->date_requested))',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'status'=>array(
                    'name'=>'status',
                    'value'=>'$data->status',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'detail'=>array(
                    'name'=>'View Detail',
                    'value'=>'CHtml::link("Change",Yii::app()->createUrl("fleetmanager/drivers/changepassword",array("id"=>$data->id)),array("class"=>"btn btn-primary"))',
                    'type'=>'raw',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                )
            ),
            'htmlOptions' => array(
                'class' => 'table-responsive',
                'id' => "password-request-grid",
            )
        ));
        ?>
    </div>
</div>