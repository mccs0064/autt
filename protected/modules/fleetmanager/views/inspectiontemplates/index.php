<div class="panel panel-transparent">
    <div class="panel-heading">
        <div class="panel-title">Existing Inspection Templates
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $model->allTemplates(),
            'summaryText' => '',
            'emptyText' => 'There are no templates to show',
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
                'template_name'=>array(
                    'name'=>'Inspection Template',
                    'value'=>'$data->template_name',
                    'headerHtmlOptions'=>array('clsss'=>'sorting_asc'),
                ),
                'defects_list'=>array(
                    'name'=>'Defects List',
                    'value'=>'InspectionTemplate::getTotalDefects($data->id)',
                    'headerHtmlOptions'=>array('clsss'=>'sorting_asc'),
                ),
                'linked_vehicles'=>array(
                    'name'=>'Linked With',
                    'value'=>'InspectionTemplate::getLinkedVehicles($data->id) ." Vehicles"',
                    'headerHtmlOptions'=>array('clsss'=>'sorting_asc'),
                ),
                'update'=>array(
                    'class'=>'CButtonColumn',
                    'template'=>'{update} {delete}',
                    'buttons'=>array(
                        'update'=>array(
                            'label'=>'<span><button class="btn btn-primary">Update</button></span>',
                            'imageUrl'=>false,
                        ),
                        'delete'=>array(
                            'label'=>'<span><button class="btn btn-primary delete-template">Delete</button></span>',
                            'imageUrl'=>false,
                        ),

                    ),
                    'header'=>'',
                    'headerHtmlOptions'=>array('clsss'=>'sorting_asc'),
                    'updateButtonUrl'=>'Yii::app()->request->getBaseUrl(true)."/fleetmanager/inspectiontemplates/update/id/".$data->id',
                    'deleteButtonUrl'=>'$data->id',
                )
            ),
            'htmlOptions' => array(
                'class' => 'table-responsive',
                'id' => "inspection-templates-grid",
            )
        ));
        ?>
    </div>
</div>

<script>
    $('.delete').click(function(e){
        e.stopPropagation();

        var choice=window.confirm('Are you sure want to delete this template?');
        if(choice==true)
        {
            var id=$(this).attr('href');
            $.ajax({
                type: 'post',
                url: '<?php echo Yii::app()->request->getBaseUrl(true);?>/fleetmanager/inspectiontemplates/delete',
                data: {id: id},
                success: function(res)
                {
                    var response=$.parseJSON(res);
                    if(response.status==true)
                    {
                        window.location.reload();
                    }
                }
            })
        }
        return false;
    });
</script>