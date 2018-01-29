<?php
if(!empty($model['location']))
{
    $location=$model['location'];
}
else
{
    $location=Yii::app()->commons->getLocationFromCord($model['longitude'],$model['latitude']);
}
?>

<div class="row">
    <div class="col-xs-6">
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-6">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/autium-header-logo-green.png" class="img-responsive">
                    </div>
                </div>
            </div>
            <div class="col-xs-12"><h3 class="report-header">Accident Details Form</h3></div>
        </div>

    </div>
    <div class="col-xs-6 text-right">
        <div>
            <span class="header-label theme-color">Accident ID: </span>
            <span
                class="header-label-value"><?php echo date('Ymd', strtotime($model->occured_at)); ?><?php echo $model->id; ?></span>
        </div>
        <div>
            <span class="header-label theme-color">Accident Date & Time: </span>
            <span
                class="header-label-value"><?php echo date('d/m/Y H:i', strtotime($model->occured_at)); ?></span>
        </div>
        <div>
            <span class="header-label theme-color">Location: </span>
            <span
                class="header-label-value"><?php echo !empty($location)?$location:'N/A'; ?></span>
        </div>
        <div>
            <span class="header-label theme-color">Weather: </span>
            <span
                class="header-label-value"><?php echo !empty($model->weather_condition)?$model->weather_condition:'N/A'; ?></span>
        </div>
        <div>
            <span class="header-label theme-color">Recorded From: </span>
            <span
                class="header-label-value"><?php echo $model->source;?></span>
        </div>
        <div>
            <span class="header-label theme-color">Accident Cause: </span>
            <span
                class="header-label-value"><?php echo !empty($model->note_type)?$model->note_type:'N/A';?></span>
        </div>
        <div>
            <span class="header-label theme-color">Claim Cost: </span>
            <span
                class="header-label-value"><?php echo !empty($model->claim_cost)?"£".number_format($model->claim_cost,2): 'N/A';?></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="separator-report" style="margin: 15px 0 !important;"></div>
    </div>
</div>
<?php
$otherVehicles = $model->involvedVehicles;
$otherDriver = AccidentDriver::model()->findByAttributes(array('accident_id'=>$model->id));
$police = AccidentPolice::model()->findByAttributes(array('accident_id'=>$model->id));
$myVehiclePhotos=AccidentMedia::model()->findAllByAttributes(array('accident_id'=>$model->id,'media_type'=>'Image','image_type'=>'Self'));
$otherVehiclePhotos=AccidentMedia::model()->findAllByAttributes(array('accident_id'=>$model->id,'media_type'=>'Image','image_type'=>'Other'));
$audio=AccidentMedia::model()->findAllByAttributes(array('accident_id'=>$model->id,'media_type'=>'Audio'));
$myPicturesCount=count($myVehiclePhotos);
$otherVehiclePhotosCount=count($otherVehiclePhotos);
$hasPolice=!empty($police)?"Yes":'No';
$hasAudio=!empty($audio)?"Yes":'No';
$mainVehicle=Vehicle::model()->findByAttributes(array('vehicle_reg'=>$model->vehicle_reg));
if(!empty($mainVehicle))
{
    $mainVehicleType=$mainVehicle->vehicle_type;
}
else

{
    $mainVehicleType='N/A';
}
?>


<div class="row">
    <div class="col-xs-12">
        <div class="information-row">
            <div class="title"><strong>Summary</strong></div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="summary-box">
            <div class="summary-title">Other Vehicles</div>
            <div class="summary-value"><?php echo count($otherVehicles);?></div>
        </div>
        <div class="summary-box">
            <div class="summary-title">Police Involve</div>
            <div class="summary-value"><?php echo $hasPolice;?></div>
        </div>
        <div class="summary-box">
            <div class="summary-title">My Vehicle Photos</div>
            <div class="summary-value"><?php echo $myPicturesCount;?></div>
        </div>
        <div class="summary-box">
            <div class="summary-title">Other Vehicle Photos</div>
            <div class="summary-value"><?php echo $otherVehiclePhotosCount;?></div>
        </div>
        <div class="summary-box">
            <div class="summary-title">Audio Recording</div>
            <div class="summary-value"><?php echo $hasAudio;?></div>
        </div>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-xs-12">
        <div class="information-row">
            <div class="title"><strong>Driver Information</strong></div>
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
                    <div class="col-xs-3">
                        <div class="box-row">
                            <div class="name">
                                ID
                            </div>
                            <div class="value">
                                <strong><?php echo $driver->autium_id; ?></strong>
                            </div>
                        </div>

                    </div>
                    <?php
                    $regString='N/A';
                    $fleetManagerData=Driver::model()->findByPk($driver->id);
                    $vehicleDataa=Vehicle::model()->findByAttributes(array('vehicle_reg'=>$model->vehicle_reg,'fleetmanager_id'=>$fleetManagerData->id));
                    if(!empty($vehicleDataa))
                    {
                        $regString=$vehicleDataa['vehicle_reg']." ".$model['make']."-".$model['model']." (".$vehicleDataa['vehicle_type'].")";
                    }
                    ?>
                    <div class="col-xs-4">
                        <div class="box-row">
                            <div class="name">
                                Vehicle
                            </div>
                            <div class="value">
                                <strong><?php echo $regString; ?></strong>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div><br/>



<?php


if (!empty($otherVehicles)):?>
    <div class="row">
        <div class="col-xs-12">
            <div class="information-row">
                <div class="title"><strong>Other Vehicle Information</strong></div>
                <div class="box">
                    <div class="row" style="margin-left:0; margin-right:0">
                        <div class="col-xs-2">
                                <div class="box-row">
                                    <div class="name">
                                        <strong class="td-title">Reg</strong>
                                    </div>
                                </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="box-row">
                                <div class="name">
                                    <strong class="td-title">Passengers</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="box-row">
                                <div class="name">
                                    <strong class="td-title">Driver</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="box-row">
                                <div class="name">
                                    <strong class="td-title">Phone</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="box-row">
                                <div class="name">
                                    <strong class="td-title">Insurer</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="box-row">
                                &nbsp;
                            </div>
                        </div>

                    </div>

                    <?php foreach ($otherVehicles as $key => $vehicle): ?>
                        <div class="row" style="margin-left:0; margin-right:0">
                            <div class="col-xs-2">
                                <div class="box-row">
                                    <div class="value-v reg"><?php echo !empty($vehicle->vehicle_reg)?$vehicle->vehicle_reg:'&nbsp;'; ?>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xs-2">
                                <div class="box-row">
                                    <div class="value-v">
                                        <?php echo !empty($vehicle->number_of_pessengers)?$vehicle->number_of_pessengers:'&nbsp;'; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="box-row">
                                    <div class="value-v">
                                       <?php echo !empty($vehicle->driver_name)?$vehicle->driver_name:'&nbsp;'; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="box-row">
                                    <div class="value-v">
                                        <?php echo !empty($vehicle->phone_number)?$vehicle->phone_number:'&nbsp;'; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="box-row">
                                    <div class="value-v">
                                        <?php echo !empty($vehicle->insurer)?$vehicle->insurer:'&nbsp;'; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="box-row">

                                    <div class="value-v">
                                        <strong class="button-box">Vehicle <?php echo $key + 1; ?></strong>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div><br/>
<?php endif; ?>

<?php


if (!empty($otherDriver)):?>
    <div class="row">
        <div class="col-xs-12">
            <div class="information-row">
                <div class="title"><strong>Other Driver Information</strong></div>
                <div class="box">
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="box-row">
                                    <div class="name">
                                        Name
                                    </div>
                                    <div class="value"><strong><?php echo $otherDriver->driver_name; ?>
                                        </strong>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xs-3">
                                <div class="box-row">
                                    <div class="name">
                                        Phone
                                    </div>
                                    <div class="value">
                                        <strong><?php echo $otherDriver->phone_number; ?></strong>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xs-3">
                                <div class="box-row">
                                    <div class="name">
                                        Registration
                                    </div>
                                    <div class="value">
                                        <strong><?php echo $otherDriver->reg; ?></strong>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xs-3">
                                <div class="box-row">
                                    <div class="name">
                                        Address
                                    </div>
                                    <div class="value">
                                        <strong><?php echo $otherDriver->address; ?></strong>
                                    </div>
                                </div>

                            </div>

                        </div>
                </div>
            </div>
        </div>
    </div><br/>
<?php endif; ?>

<?php


if (!empty($police)):?>
    <div class="row">
        <div class="col-xs-12">
            <div class="information-row">
                <div class="title"><strong>Police Involvement</strong></div>
                <div class="box">
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="box-row">
                                <div class="name">
                                    Officer Name
                                </div>
                                <div class="value"><strong><?php echo $police->officer_name; ?>
                                    </strong>
                                </div>
                            </div>

                        </div>
                        <div class="col-xs-3">
                            <div class="box-row">
                                <div class="name">
                                    Phone Number
                                </div>
                                <div class="value">
                                    <strong><?php echo $police->phone_number; ?></strong>
                                </div>
                            </div>

                        </div>
                        <div class="col-xs-3">
                            <div class="box-row">
                                <div class="name">
                                    Police Station
                                </div>
                                <div class="value">
                                    <strong><?php echo $police->police_station; ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="box-row">
                                <div class="name">
                                    Badge Number
                                </div>
                                <div class="value">
                                    <strong><?php echo $police->batch_number; ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
<?php endif; ?>

<div class="row page-break-after">
    <div class="col-xs-12">
        <div class="information-row">
            <div class="title"><strong>Post Accident Interview</strong></div>
            <div class="box" style="background: none">
               <div class="box-row notes-box" style="min-height: 100px;">
                   <?php echo $model->notes;?>
               </div>
            </div>
        </div>
    </div>
</div>

<?php

?>
<div class="page-break-before">
    <div class="row">
        <div class="col-xs-12">
            <div class="section-head">
                <div class="left"><strong>My Vehicle Photos-<?php echo $model->vehicle_reg;?></strong></div>
                <div class="right">
                    <strong>
                        <?php if ($myPicturesCount > 1):
                            echo $myPicturesCount . " Pictures attached";
                        elseif ($myPicturesCount == 1):
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
                <?php if(!empty($myVehiclePhotos)):
                    foreach ($myVehiclePhotos as $key=> $photo):
                        $root=Yii::getPathOfAlias('root');
                        $directoryPath='uploads/'.$photo['directory_name'].'/';
                        $filePath='uploads/'.$photo['directory_name'].'/'.rawurlencode($photo['filename']);
                        ?>
                        <div class="col-xs-6">
                            <div class="container-image-box">
                                <img src="<?php echo Yii::app()->commons->getResizedImage($filePath, 500, null, $directoryPath, 60); ?>" class="img-responsive container-image"/>
                            </div>
                        </div>
                        <?php
                        if(($key+1)%2==0)
                        {?>
                            <div class="clearfix"></div>

                        <?php }
                    endforeach;
                endif;?>

            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12">
        <div class="section-head">
            <div class="left"><strong>Other Vehicle Photos</strong></div>
            <div class="right">
                <strong>
                    <?php if ($otherVehiclePhotosCount > 1):
                        echo $otherVehiclePhotosCount . " Pictures attached";
                    elseif ($otherVehiclePhotosCount == 1):
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
            <?php if(!empty($otherVehiclePhotos)):
                foreach ($otherVehiclePhotos as $key=> $photo):
                    $root=Yii::getPathOfAlias('root');
                    $directoryPath='uploads/'.$photo['directory_name'].'/';
                    $filePath='uploads/'.$photo['directory_name'].'/'.$photo['filename'];
                    ?>
                    <div class="col-xs-6">
                        <div class="container-image-box">
                            <img src="<?php echo Yii::app()->commons->getResizedImage($filePath, 500, null, $directoryPath, 60); ?>" class="img-responsive container-image"/>
                        </div>
                    </div>
                    <?php
                    if(($key+1)%2==0)
                    {?>
                        <div class="clearfix"></div>

                    <?php }
                endforeach;
            endif;?>

        </div>
    </div>
</div>
<style>
    .page-break-before	{ display: block; page-break-before: always; }
    .page-break-after	{ display: block; page-break-after: always; }
    * {
        overflow: visible !important;
    }
</style>
