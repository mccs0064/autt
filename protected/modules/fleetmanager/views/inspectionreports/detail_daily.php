<div class="container-fluid container-fixed-lg">


    <!-- START PANEL -->
    <div class="panel panel-transparent">
        <div class="panel-heading">
            <div class="panel-title"><?php echo $model->inspection_type;?> Inspection Report Detail
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">

                    <div class="panel panel-transparent ">
                        <br/>
                        <div class="row">
                            <div class="col-xs-3">
                                <p class="text-uppercase"><strong>Vehicle Reg No:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <?php $reg=$model->inspection_type=='Daily'?$model->vehicle->vehicle_reg:$model->vehicle_reg;?>
                                <p class="number_plate"><?php echo $reg; ?></p>
                            </div>
                            <div class="col-xs-6">
                                <div class="pull-right">
                                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/fleetmanager/inspectionreports/download/id/<?php echo $model->id; ?>"
                                       class="btn btn-success">Download as PDF</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">
                            <p class="text-uppercase"><strong>Status:</strong></p>
                        </div>
                        <div class="col-xs-3">
                            <p class=""><?php echo $model['status']; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">
                            <p class="text-uppercase"><strong>Submitted Date:</strong></p>
                        </div>
                        <div class="col-xs-3">
                            <p class=""><?php echo date('jS F, Y H:i:s', strtotime($model['submitted_date'])); ?></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <ul class="nav nav-tabs nav-tabs-fillup" data-init-reponsive-tabs="dropdownfx">
                                <li>
                                    <a data-toggle="tab" href="#tab-list" id="listFleet"><span>List</span></a>
                                </li>
                            </ul>


                            <div class="tab-content">
                                <div class="tab-pane" id="tab-list">
                                    <div class="row">
                                        <?php
                                        $checklistItems = $model->inspectionChecklists;
                                        if (!empty($checklistItems)):
                                            foreach ($checklistItems as $item):?>
                                                <div class="col-xs-12">
                                                    <div class="row">
                                                        <div class="col-xs-4"><?php echo $item['item_name']; ?></div>
                                                        <div class="col-xs-4">
                                                            <?php if ($item['is_done']): ?>
                                                                <i class="fa fa-check"></i>
                                                            <?php else: ?>
                                                                <i class="fa fa-remove"></i>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php endforeach;
                                        endif;
                                        ?>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END PANEL -->
</div>

<script>
    $(document).ready(function () {
        $("#listFleet").click();
    });
</script>
