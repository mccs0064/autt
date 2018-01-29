<div class="container-fluid container-fixed-lg">


    <!-- START PANEL -->
    <div class="panel panel-transparent">
        <div class="panel-heading">
            <div class="panel-title">Inspection Report Detail
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">

                    <div class="panel panel-transparent ">
                        <br/>
                        <div class="row">
                            <div class="col-xs-2">
                                <p class="text-uppercase"><strong>Vehicle Reg No:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class="number_plate"><?php echo $model->vehicle->vehicle_reg; ?></p>
                            </div>
                            <div class="col-xs-7">
                                <div class="pull-right">
                                    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/inspectionreports/download/id/<?php echo $model->id;?>" class="btn btn-success">Download as PDF</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2">
                                <p class="text-uppercase"><strong>Status:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo $model['status']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2">
                                <p class="text-uppercase"><strong>Due Date:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo $model['due_date']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2">
                                <p class="text-uppercase"><strong>Notes By Driver:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo $model->notes; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">


                                <div class="accident-images">
                                    <?php if (!empty($model->image1)): ?>
                                        <img
                                            class="img-responsive" data-lightbox="accident-image"
                                            src="<?php echo Yii::app()->request->baseUrl; ?>/uploads/<?php echo $model['directory_name']; ?>/<?php echo $model['image1']; ?>"/>
                                    <?php endif; ?>

                                </div>

                            </div>
                            <?php
                            if (!empty($model->image2)): ?>
                            <div class="col-xs-6">


                                <div class="accident-images">
                                    <img class="img-responsive"
                                         data-lightbox="accident-image"
                                         src="<?php echo Yii::app()->request->baseUrl; ?>/uploads/<?php echo $model['directory_name']; ?>/<?php echo $model['image2']; ?>"/>

                                    <?php endif; ?>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <!-- END PANEL -->

        </div>

