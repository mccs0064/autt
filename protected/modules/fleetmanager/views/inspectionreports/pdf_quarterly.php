<div class="row">
    <div class="col-xs-2">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/autium-header-logo-green.png" class="img-responsive">
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <h3 class="report-header">Quarterly Inspection Report</h3>
    </div>
    <div class="col-xs-6 text-right">
        <div>
            <span class="header-label theme-color">Inspection ID: </span>
            <span
                class="header-label-value"><?php echo date('Ymd', strtotime($model->due_date)); ?><?php echo $model->id; ?></span>
        </div>
        <div>
            <span class="header-label theme-color">Notification Sent: </span>
            <span
                class="header-label-value"><?php echo date('d/m/Y H:i', strtotime($model->notification_date)); ?></span>
        </div>
        <div>
            <span class="header-label theme-color">Inspection Received: </span>
            <span class="header-label-value"><?php echo date('d/m/Y H:i', strtotime($model->submitted_date)); ?></span>
        </div>
        <div>
            <span class="header-label theme-color">Vehicle: </span>
            <span class="header-label-value">
                <?php $vehicle = $model->vehicle;
                echo $vehicle->make . ", " . $vehicle->model . " " . $vehicle->vehicle_reg;
                ?>
            </span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="separator-report"></div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="information-row">
            <div class="title"><strong>Inspection Submitted By</strong></div>
            <div class="box">
                <div class="row">
                    <div class="col-xs-4">
                        <div class="box-row">
                            <div class="name">
                                Name
                            </div>
                            <div class="value">
                                <strong><?php
                                    $driver = $model->driver;
                                    echo $driver->full_name;
                                    ?></strong>
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-4">
                        <div class="box-row">
                            <div class="name">
                                ID
                            </div>
                            <div class="value">
                                <strong><?php echo "AU-000" . $driver->id; ?></strong>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="checklist-row">
        <div class="col-xs-6 right-border-attribute">
            <?php
            $checklists = $model->inspectionChecklists;
            if (!empty($checklists)):
                foreach ($checklists as $checklist):?>
                    <div class="inspection-item">
                        <span><i
                                class="fa fa-check item-bool <?php echo $checklist['item_name'] == true ? 'done' : 'skipped'; ?>"></i> <?php echo $checklist['item_name']; ?></span>
                    </div>
                <?php endforeach;
            endif;
            ?>
        </div>
        <div class="col-xs-6">

        </div>
    </div>

</div>

<?php
$pictures_count = 0;
if (!empty($model->image1))
    $pictures_count++;

if (!empty($model->image2))
    $pictures_count++;


?>

<div class="row">
    <div class="col-xs-12">
        <div class="section-head">
            <div class="left"><strong>Photos</strong></div>
            <div class="right">
                <strong>
                    <?php if ($pictures_count > 1):
                        echo $pictures_count . " Pictures attached";
                    elseif ($pictures_count == 1):
                        echo "1 Picture attached";
                    else:
                        echo "No Picture attached";
                    endif; ?>

                </strong>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="row">
            <?php if(!empty($model['image1'])):?>
            <div class="col-xs-6">
                <div class="container-image-box">
                    <img src="<?php echo Yii::app()->request->baseUrl;?>/uploads/<?php echo $model['directory_name'];?>/<?php echo $model['image1'];?>" class="img-responsive container-image"/>
                </div>
            </div>
            <?php endif;?>
            <?php if(!empty($model['image2'])):?>
                <div class="col-xs-6">
                    <div class="container-image-box">
                        <img src="<?php echo Yii::app()->request->baseUrl;?>/uploads/<?php echo $model['directory_name'];?>/<?php echo $model['image2'];?>" class="img-responsive container-image"/>
                    </div>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="information-row">
            <div class="title"><strong>Notes</strong></div>
            <div class="box">
               <div class="box-row notes-box">
                   <?php echo $model->notes;?>
               </div>
            </div>
        </div>
    </div>
</div>