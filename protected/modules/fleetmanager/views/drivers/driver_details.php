<div class="container-fluid container-fixed-lg">


    <!-- START PANEL -->
    <div class="panel panel-transparent">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">

                    <div class="panel panel-transparent ">
                        <br/>
                        <div class="row">
                            <div class="col-xs-2">
                                <p><strong>Name:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p><?php echo $model['full_name']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2">
                                <p><strong>Autium ID:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p><?php echo $model['autium_id']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2">
                                <p><strong>Address:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo (!empty($model['address'])) ? $model['address'] : 'N/A'; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2">
                                <p><strong>Driving License:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo (!empty($model['driving_license'])) ? $model['driving_license'] : 'N/A'; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2">
                                <p><strong>License Type:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo (!empty($model['license_type'])) ? $model['license_type'] : 'N/A'; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2">
                                <p><strong>Date of Brith:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo (!empty($model['dob'])) ? date('d/m/Y',strtotime($model['dob'])) : 'N/A'; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2">
                                <p><strong>Nationality:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo (!empty($model['nationality'])) ? $model['nationality'] : 'N/A'; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2">
                                <p><strong>Points:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo isset($model['points']) ? $model['points'] : '0'; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2">
                                <p><strong>Driving Convictions:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo (!empty($model['driving_convictions'])) ? $model['driving_convictions'] : 'N/A'; ?></p>
                            </div>
                        </div>
                        <br><br>

                        <h3>Linked Vehicles</h3>
                        <div class="row">
                            <div class="col-xs-12">
                                <?php
                                $this->widget('zii.widgets.grid.CGridView', array(
                                    'dataProvider' => $vehicles->driverVehicles($model->id),
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
                                        'id' => array(
                                            'name' => 'Autium Vehicle ID',
                                            'value' => '"VH-000".$data->id',
                                            'htmlOptions' => array('class' => 'v-align-middle')
                                        ),
                                        'vehicle_reg' => array(
                                            'name' => 'Registration',
                                            'value' => '$data->vehicle->vehicle_reg',
                                            'htmlOptions' => array('class' => 'v-align-middle')
                                        ),
                                        'make' => array(
                                            'name' => 'Make',
                                            'value' => '$data->vehicle->make',
                                            'htmlOptions' => array('class' => 'v-align-middle')
                                        ),
                                        'model' => array(
                                            'name' => 'Model',
                                            'value' => '$data->vehicle->model',
                                            'htmlOptions' => array('class' => 'v-align-middle')
                                        ),
                                        'vehicle_type' => array(
                                            'name' => 'Type',
                                            'value' => '$data->vehicle->vehicle_type',
                                            'htmlOptions' => array('class' => 'v-align-middle')
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

