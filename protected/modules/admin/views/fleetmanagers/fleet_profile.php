<div class="container-fluid container-fixed-lg">


    <!-- START PANEL -->
    <div class="panel panel-transparent">
        <div class="panel-heading">
            <div class="panel-title">Fleet Manager Profile
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">

                    <div class="panel panel-transparent ">
                        <br/>
                        <div class="row">
                            <div class="col-xs-2">
                                <p class="text-uppercase"><strong>Name:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p><?php echo $model->first_name." ".$model->last_name ; ?></p>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-xs-2">
                                <p class="text-uppercase"><strong>Email:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p><?php echo $model->email ; ?></p>
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
                        <br/><br/>
                        <div class="row">
                            <div class="col-xs-2">
                                <a  target="_blank"  href="<?php echo Yii::app()->request->baseUrl;?>/admin/fleetmanagers/vehicles/id/<?php echo $model->id;?>" class="btn btn-primary">Vehicles</a>
                            </div>
                            <div class="col-xs-2">
                                <a  target="_blank" href="<?php echo Yii::app()->request->baseUrl;?>/admin/fleetmanagers/drivers/id/<?php echo $model->id;?>" class="btn btn-primary">Drivers</a>
                            </div>
                            <div class="col-xs-2">
                                <a  target="_blank"  href="<?php echo Yii::app()->request->baseUrl;?>/admin/fleetmanagers/accidents/id/<?php echo $model->id;?>" class="btn btn-primary">Accidents</a>
                            </div>
                            <div class="col-xs-2">
                                <a  target="_blank"  href="<?php echo Yii::app()->request->baseUrl;?>/admin/fleetmanagers/inspectionreports/id/<?php echo $model->id;?>" class="btn btn-primary">Inspection Reports</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- END PANEL -->

        </div>

