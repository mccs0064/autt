<div class="panel panel-transparent">
    <div class="panel-heading">
        <div class="panel-title">All Companies
        </div>
        <div class="btn-group pull-right m-b-10">
            <a href="<?php echo Yii::app()->request->baseUrl;?>/admin/fleetmanagers/add" class="btn btn-success">Add new</a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $model->search(),
//            'filter' => $model,
            'summaryText' => '',
            'emptyText' => 'There are no companies to show',
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
                    'name'=>'Name',
                    'value'=>'$data->first_name." ".$data->last_name',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'status'=>array(
                    'name'=>'Status',
                    'value'=>'$data->status=="Active"?"Active":"Inactive"',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                ),
                'update'=>array(
                    'name'=>'Update',
                    'value'=>'CHtml::link("Update",Yii::app()->createUrl("admin/fleetmanagers/update",array("id"=>$data->id)),array("class"=>"btn btn-primary"))',
                    'type'=>'raw',
                    'htmlOptions'=>array('class'=>'v-align-middle')
                )
            ),
            'htmlOptions' => array(
                'class' => 'table-responsive',
                'id' => "fleet-managers-grid",
            )
        ));
        ?>
    </div>
</div>
<script>
    $("#fleet-managers-grid").find('tr').each(function(){
        var $tr=$(this);
        if($tr.find('td').eq(3).text()=='Inactive')
        {
            $tr.find('td').addClass('inactive-td');
        }
    });
</script>
<style>
    .inactive-td
    {
        color: rgba(128, 128, 128, 0.58) !important;
        background: rgba(211, 211, 211, 0.27) !important;
    }
</style>