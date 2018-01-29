<div class="panel-body">
    <br/><br/>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-2 cell-bg">
                <p><strong>Report ID:</strong></p>
                <p>INS-000<?php echo $model->id;?></p>
            </div>
            <div class="col-xs-2 cell-bg">
                <p><strong>Vehicle Details:</strong></p>
                <p>
                    <?php $vehicle=$model->vehicle;
                    $driver=Driver::model()->findByPk($model->driver_id);
                    ?>
                    <?php echo $vehicle->make." - ".$vehicle->model." - ".$vehicle->vehicle_reg;?>
                </p>
            </div>
            <div class="col-xs-3 cell-bg">
                <p><strong>Date Submission:</strong></p>
                <p><?php echo date('d M Y',strtotime($model->submitted_date));?> (<?php echo date('h:i',strtotime($model->submitted_date));?>)
                </p>
            </div>
            <div class="col-xs-3 cell-bg">
                <p><strong>Driver Name:</strong></p>
                <?php
                 $driver_str=$model->user_type=='Fleet Manager'?'Fleet Manager':$driver->autium_id." : ".$driver->full_name;
                ?>
                <p><?php echo $driver_str;?>
                </p>
            </div>
            <div class="col-xs-2 cell-bg" style="border-right: 1px solid">
                <p><strong>Total Defects Reported:</strong></p>
                <p><?php echo DailyInspectionReport::getTotalDefects($model->id);?>
                </p>
            </div>

        </div>
    </div>

    <br/> <br/>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $model->inspectionReportItems(),
//            'filter' => $model,
        'summaryText' => '',
        'emptyText' => 'There is no inspection data to show',
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
                'name'=>'Defect ID',
                'value'=>'"DEF-000".$data->id',
                'htmlOptions'=>array('class'=>'v-align-middle')
            ),
            'defect_name'=>array(
                'name'=>'Defect Name',
                'value'=>'$data->name',
                'htmlOptions'=>array('class'=>'v-align-middle')
            ),
            'defect'=>array(
                'name'=>'Defect',
                'value'=>'$data->inspected=="1"?"Yes":"No"',
                'htmlOptions'=>array('class'=>'v-align-middle defect_reported_class')
            ),
            'notes'=>array(
                'name'=>'Notes',
                'value'=>'$data->notes',
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
<?php $this->renderPartial('_styling');?>