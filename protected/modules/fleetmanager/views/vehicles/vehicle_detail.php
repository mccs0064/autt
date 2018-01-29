<div class="container-fluid container-fixed-lg">


    <!-- START PANEL -->
    <div class="panel panel-transparent">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">

                    <div class="panel panel-transparent ">
                        <br/>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Autium Vehicle ID:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p>VH-000<?php echo $model['id']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Registration Number:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p><?php echo $model['vehicle_reg']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Make:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p><?php echo $model['make']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Model:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p><?php echo $model['model']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Type:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p><?php echo $model['vehicle_type']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Gross Vehicle Weight:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p><?php echo $model['gross_vehicle_weight']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Next MOT:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p><?php echo !empty($model["next_mot"])?date('d/m/Y',strtotime($model["next_mot"])):'';?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Tax Expires:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p><?php echo !empty($model["tax_expires"])?date('d/m/Y',strtotime($model["tax_expires"])):'';?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Serial Number:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p><?php echo $model["serial_number"];?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Inspection Template:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <?php
                                $template_name=null;
                                $countItems=null;
                                if(!empty($model['inspection_template_id']))
                                {
                                    $inspectionModel=InspectionTemplate::model()->findByPk($model['inspection_template_id']);
                                    $template_items_model=InspectionTemplateItems::model()->findAllByAttributes(array('template_id'=>$model['inspection_template_id']));
                                    $template_items_count=count($template_items_model);
                                    $template_name=$inspectionModel->template_name;
                                    $item_text=$template_items_count==1?'Item':' Items';
                                    $countItems=$template_items_count>0?' ('.$template_items_count.' '.$item_text.')':' (No '.$item_text.')';
                                }?>
                                <p><?php echo $template_name.$countItems;?></p>
                            </div>
                        </div>

                        <h3>Linked Drivers</h3>
                        <div class="row">
                            <div class="col-xs-12">
                                <?php
                                $this->widget('zii.widgets.grid.CGridView', array(
                                    'dataProvider' => $search->linkedSearch(),
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
                                            'value'=>'$data->autium_id'
                                        ),
                                        'full_name'=>array(
                                            'name'=>'full_name',
                                            'value'=>'$data->full_name',
                                            'headerHtmlOptions'=>array('clsss'=>'sorting_asc'),
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
                    </div>
                </div>
            </div>
        </div>
        <!-- END PANEL -->

    </div>

