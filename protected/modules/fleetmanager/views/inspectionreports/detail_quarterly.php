<div class="container-fluid container-fixed-lg">


    <!-- START PANEL -->
    <div class="panel panel-transparent">
        <div class="panel-heading">
            <div class="panel-title">Quarterly Inspection Report Detail
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
                                <p class="number_plate"><?php echo $model->vehicle->vehicle_reg; ?></p>
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
                            <p class="text-uppercase"><strong>Notification Date:</strong></p>
                        </div>
                        <div class="col-xs-3">
                            <p class=""><?php echo date('jS F, Y', strtotime($model['due_date'])); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">
                            <p class="text-uppercase"><strong>Submitted Date:</strong></p>
                        </div>
                        <div class="col-xs-3">
                            <p class=""><?php echo date('jS F, Y', strtotime($model['submitted_date'])); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">
                            <p class="text-uppercase"><strong>Notes By Driver:</strong></p>
                        </div>
                        <div class="col-xs-3">
                            <p class=""><?php echo $model->notes; ?></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <ul class="nav nav-tabs nav-tabs-fillup" data-init-reponsive-tabs="dropdownfx">
                                <li class="active">
                                    <a data-toggle="tab" href="#tab-pictures"><span>Pictures</span></a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab-list"><span>List</span></a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab-notes"><span>Notes</span></a>
                                </li>

                            </ul>


                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-pictures">
                                    <div class="accident-images" id="accidentImages">
                                        <?php
                                        $screenshots=array();
                                        if(!empty($model->image1))
                                        {
                                            $file1Path=Yii::app()->request->baseUrl.'/uploads/'.$model['directory_name'].'/'.$model['image1'];
                                            array_push($screenshots,$file1Path);

                                        }
                                        if(!empty($model->image2))
                                        {
                                            $file2Path=Yii::app()->request->baseUrl.'/uploads/'.$model['directory_name'].'/'.$model['image2'];
                                            array_push($screenshots,$file2Path);
                                        }
                                        foreach ($screenshots as $key => $screenshot):
                                            ?>
                                            <div class="col-sm-4 gallery-container" href='<?php echo $screenshot;?>' style="margin-top:50px;">
                                                <div class="gallery-thumb">
                                                    <img src="<?php echo $screenshot;?>" class="img-responsive"/>
                                                </div>
                                            </div>
                                            <?php
                                        endforeach;
                                        ?>
                                    </div>
                                </div>
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
                                <div class="tab-pane" id="tab-notes">
                                    <div class="row">
                                        <?php echo $model->notes; ?>
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
<script type="text/javascript">
    $(document).ready(function() {
        $("#accidentImages").lightGallery({
            showThumbByDefault: false,
            download: false
        });
    });
</script>

