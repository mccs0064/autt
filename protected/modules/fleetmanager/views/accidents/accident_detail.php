<div class="container-fluid container-fixed-lg">


    <!-- START PANEL -->
    <div class="panel panel-transparent">
        <div class="panel-body">
            <div class="row">

                    <div class="col-xs-12">
                        <div class="panel panel-transparent">

                            <div class="pull-right">
                                <a href="<?php echo Yii::app()->request->baseUrl; ?>/fleetmanager/accidents/download/id/<?php echo $model->id; ?>"
                                   class="btn btn-success">Download as PDF</a>
                            </div>


                        </div>
                    </div>

                <div class="col-sm-12">

                    <div class="panel panel-transparent ">
                        <br/>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Accident ID:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p><?php echo date("Ymd").$model->id;?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Vehicle Registration Number:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class="number_plate"><?php echo $model['vehicle_reg'];?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Accident Date & Time:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p><?php echo date('d/m/Y h:i',strtotime($model->occured_at));?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Make:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo $model['make'];?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Model:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo $model['model'];?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Type:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo Accident::getVehicleTypeInAccident($model['vehicle_reg']);?></p>
                            </div>
                        </div>
                        <?php
                        $driverOfAccident=$model->driver;


                        ?>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Driver:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo $driverOfAccident->full_name."-".$driverOfAccident->autium_id;?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Other Vehicles:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p><?php echo Accident::getAccidentVehiclesCount($model->id);?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Weather:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo $model->weather_condition;?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Recorded From:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo $model->source;?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Claim Cost:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo !empty($model->claim_cost)?"&pound".number_format($model->claim_cost,2):'N/A';?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <p><strong>Accident Cause:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo !empty($model->note_type)?$model->note_type:'N/A';?></p>
                            </div>
                        </div>
                        <br><br>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-fillup" data-init-reponsive-tabs="dropdownfx">
                            <li class="active">
                                <a data-toggle="tab" href="#tab-screenshots"><span>My Photos</span></a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab-othervehicles"><span>Other Vehicles</span></a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab-othervehiclesphotos"><span>Other Vehicles Photos</span></a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab-audios"><span>Audios</span></a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab-police"><span>Police</span></a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab-accidentmap" onclick="resizeMap()"><span>Accident Location</span></a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab-notes" onclick="resizeMap()"><span>Post Accident Interview</span></a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-screenshots">
                                <div class="row column-seperation">

                                        <?php
                                        $screenshots = AccidentMedia::model()->findAllByAttributes(array('media_type' => 'Image', 'accident_id' => $model['id'],'image_type'=>'Self'));
                                        if (!empty($screenshots)):?>

                                                <div class="accident-images" id="accidentImages">
                                                    <?php
                                                    foreach ($screenshots as $key => $screenshot):
                                                        $filePath=Yii::app()->request->baseUrl.'/uploads/'.$screenshot['directory_name'].'/'.$screenshot['filename'];
                                                        ?>
                                                        <div class="col-sm-4 gallery-container" href='<?php echo $filePath;?>' style="margin-top:50px;">
                                                            <div class="gallery-thumb cursor">
                                                                <img src="<?php echo $filePath;?>" class="img-responsive"/>
                                                            </div>
                                                        </div>
                                                        <?php
//                                                        $key++;
//                                                    if($key>0&&$key%3==0):
//                                                        echo "<div class='clearfix'></div>";
//                                                        endif;
                                                    endforeach;
                                                    ?>
                                                </div>
                                            <?php
                                        else:?>
                                            <p>This accident does not have any associated images.</p>
                                        <?php endif;
                                        ?>

                                </div>
                            </div>
                            <div class="tab-pane" id="tab-othervehicles">
                                <div class="row">
                                    <?php $otherVehicles=AccidentVehicles::model()->findAllByAttributes(array('accident_id'=>$model->id));
                                     if(!empty($otherVehicles))
                                     {?>

                                         <table class="table table-hover table-condensed">
                                             <thead>
                                             <tr>
                                                 <th>Registration</th>
                                                 <th>Pessengers</th>
                                                 <th>Driver Name</th>
                                                 <th>Phone</th>
                                                 <th>Insurer</th>
                                                 <th>Address</th>
                                             </tr>
                                             </thead>
                                             <tbody id="other-drivers-vehicles">


                                         <?php foreach($otherVehicles as $v):?>
                                                <tr>
                                                    <td><?php echo $v['vehicle_reg'];?></td>
                                                    <td><?php echo $v['number_of_pessengers'];?></td>
                                                     <td><?php echo $v['driver_name'];?></td>
                                                     <td><?php echo $v['phone_number'];?></td>
                                                     <td><?php echo $v['insurer'];?></td>
                                                     <td colspan="2"><?php echo $v['address'];?></td>
                                                </tr>
                                         <?php endforeach;{?>
                                             </tbody>
                                             </table>
                                     <?php
                                         }
                                    }
                                    else{?>
                                        <div class="col-xs-6">
                                            <p>No other vehicles were involved</p>
                                        </div>

                                   <?php }?>

                                </div>
                            </div>
                            <div class="tab-pane" id="tab-othervehiclesphotos">
                                <div class="row column-seperation">

                                    <?php
                                    $screenshots = AccidentMedia::model()->findAllByAttributes(array('media_type' => 'Image', 'accident_id' => $model['id'],'image_type'=>'Other'));
                                    if (!empty($screenshots)):?>

                                        <div class="accident-images" id="accidentImagesOther">
                                            <?php
                                            foreach ($screenshots as $key => $screenshot):
                                                $filePath=Yii::app()->request->baseUrl.'/uploads/'.$screenshot['directory_name'].'/'.$screenshot['filename'];
                                                ?>
                                                <div class="col-sm-4 gallery-container" href='<?php echo $filePath;?>' style="margin-top:50px;">
                                                    <div class="gallery-thumb">
                                                        <img src="<?php echo $filePath;?>" class="img-responsive"/>
                                                    </div>
                                                </div>
                                                <?php
//                                                        $key++;
//                                                    if($key>0&&$key%3==0):
//                                                        echo "<div class='clearfix'></div>";
//                                                        endif;
                                            endforeach;
                                            ?>
                                        </div>
                                        <?php
                                    else:?>
                                        <p>This accident does not have any associated images.</p>
                                    <?php endif;
                                    ?>

                                </div>
                            </div>
                            <div class="tab-pane" id="tab-audios">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <?php
                                        $audios = AccidentMedia::model()->findAllByAttributes(array('media_type' => 'Audio', 'accident_id' => $model['id']));
                                        if (!empty($audios)):
                                            foreach ($audios as $key => $audio):
                                                ?>
                                                <h4>Audio <?php echo $key + 1; ?></h4>
                                                <audio
                                                    src="<?php echo Yii::app()->request->baseUrl; ?>/uploads/<?php echo $audio['directory_name']; ?>/<?php echo $audio['filename']; ?>"
                                                    preload="auto"/>
                                                <?php
                                            endforeach; ?>

                                        <?php else: ?>
                                            <p>This accident does not have any associated audios.</p>
                                        <?php endif;
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="tab-police">
                                <?php $accidentPolice = $model->accidentPolices;
                                if (!empty($accidentPolice)):
                                foreach ($accidentPolice as $key=>$police):
                                ?>
                                <div class="row">
                                    <div class="col-xs-8">
                                        <table class="table table-hover table-condensed">
                                            <thead>
                                            <tr>
                                                <th style="color:#626262"><strong>Police Officer Name</strong></th>
                                                <th style="color:#626262;font-weight: normal"><?php echo $police['officer_name'];?></th>
                                            </tr>
                                            </thead>
                                            <tbody id="police-info-section">
                                            <tr>
                                                <td><strong>Phone Number</strong></td>
                                                <td><?php echo $police['phone_number'];?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Officer Badge Number</strong></td>
                                                <td><?php echo $police['batch_number'];?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Police Station</strong></td>
                                                <td><?php echo $police['police_station'];?></td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                    <?php endforeach;?>

                                   <?php else:?>
                                        <p>This accident does not involve police.</p>
                                    <?php endif; ?>
</div>

                                <div class="tab-pane" id="tab-accidentmap">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php
                                            if(!empty($model['location']))
                                            {
                                                $longLat=Yii::app()->commons->getLongLatFromLocation($model['location']);
                                                $location=$model['location'];
                                                $long=null;
                                                $latitude=null;
                                            }
                                            else
                                            {
                                                $location=Yii::app()->commons->getLocationFromCord($model['longitude'],$model['latitude']);
                                                $long=$model['longitude'];
                                                $latitude=$model['latitude'];
                                            }


                                            ?>


                                            <?php if(!empty($model['location'])):
                                            ?>
                                                <table class="table table-hover table-condensed">
                                                    <thead>
                                                    <tr>
                                                        <th style="color:#626262"><strong>Manual Location</strong></th>
                                                        <th style="color:#626262"><strong><?php echo $model['location'];?></strong></th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                           <?php else:?>
                                                <table class="table table-hover table-condensed">
                                                    <thead>
                                                    <tr>
                                                        <th style="color:#626262"><strong>Automatic Location</strong></th>
                                                        <th style="color:#626262"><strong><?php echo $location;?></strong></th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                           <?php endif;?>

                                            <?php if(empty($model['location'])):?>
                                            <div id="accidentMap" style="width:615px; height:315px" data-longitude="<?php echo $long?>" data-latitude="<?php echo $latitude;?>">
                                            </div>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </div>
                            <div class="tab-pane" id="tab-notes">
                                <div class="row">
                                    <div class="col-xs-8">
                                        <div class="form-group form-group-default">
                                            <label>Accident <span class="text-danger">*</span></label>
                                            <select id="note_type" class="form-control">
                                                <option>Please select</option>
                                                <option <?php echo $model->note_type=='Changing lanes'?'selected':'';?> value="Changing lanes">Changing lanes</option>
                                                <option <?php echo $model->note_type=='Accidental Damage'?'selected':'';?>  value="Accidental Damage">Accidental Damage</option>
                                                <option <?php echo $model->note_type=='Collision whilst reversing'?'selected':'';?>  value="Collision whilst reversing">Collision whilst reversing</option>
                                                <option <?php echo $model->note_type=='Collision with a  moving vehicle'?'selected':'';?>  value="Collision with a  moving vehicle">Collision with a  moving vehicle</option>
                                                <option <?php echo $model->note_type=='Collision with a stationary vehicle'?'selected':'';?>  value="Collision with a stationary vehicle">Collision with a stationary vehicle</option>
                                                <option <?php echo $model->note_type=='Blowout'?'selected':'';?>  value="Blowout">Blowout</option>
                                                <option <?php echo $model->note_type=='Vehicle failure'?'selected':'';?>  value="Vehicle failure">Vehicle failure</option>
                                                <option <?php echo $model->note_type=='Theft'?'selected':'';?>  value="Theft">Theft</option>
                                                <option <?php echo $model->note_type=='Fire'?'selected':'';?>  value="Fire">Fire</option>
                                                <option <?php echo $model->note_type=='Hit a TP in the rear'?'selected':'';?>  value="Hit a TP in the rear">Hit a TP in the rear</option>
                                                <option <?php echo $model->note_type=='TP at fault'?'selected':'';?>  value="TP at fault">TP at fault</option>
                                                <option <?php echo $model->note_type=='Vehicle tipping'?'selected':'';?>  value="Vehicle tipping">Vehicle tipping</option>
                                            </select>
                                        </div>

                                    </div>
                                    <br/><br/>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group form-group-default">
                                                    <label>Claim Cost</label>
                                                    <input type="number" step="any" id="claim_cost" class="form-control" value="<?php echo $model->claim_cost;?>"/>
                                                </div>
                                            </div>
                                            <div class="col-md-4"><span class="text-danger">Avoid Currency Symbol</span></div>
                                        </div>

                                    </div>
                                    <br/>
                                    <div class="col-md-8">
                                        <div class="form-group form-group-default">
                                            <label>Notes</label>
                                            <textarea style="height:200px;" placeholder="Enter Notes" rows="10" cols="50" class="form-control" id="save-notes-box" data-accident="<?php echo $model->id;?>"><?php echo $model->notes;?></textarea>

                                        </div>
                                    </div>
                                    <br/> <br/> <br/>
                                    <div class="col-sm-12">
                                        <button id="save-notes" class="btn btn-primary">Save</button>
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

        $("#save-notes").click(function(){
            var note_type=$("#note_type").val();
            var claim_cost=$("#claim_cost").val();
            if(note_type=='Please select')
            {
                alert('Please select accident cause');
                return false;
            }

            var choice=window.confirm("Are you sure you want to update notes?");
            if(choice==true)
            {
                var content=$("#save-notes-box").val();
                var accident_id=$("#save-notes-box").attr('data-accident');

                $.ajax({
                    type: 'post',
                    url: '<?php echo Yii::app()->createUrl("fleetmanager/accidents/updatenotes");?>',
                    data: {'notes': content, 'accident_id': accident_id,note_type: note_type,claim_cost: claim_cost},
                    success: function(resp){
                        window.location.reload();
                    }
                });
            }

        });
        var myCenter=new google.maps.LatLng(53, -1.33);
        var marker=new google.maps.Marker({
            position:myCenter
        });
        var initialized=false;

        function initialize() {
            var mapProp = {
                center:myCenter,
                zoom: 14,
                draggable: false,
                scrollwheel: false,
                mapTypeId:google.maps.MapTypeId.ROADMAP
            };

            var map=new google.maps.Map(document.getElementById("accidentMap"),mapProp);
            marker.setMap(map);
            google.maps.event.trigger(map, "resize");

        };
        $(document).load(function () {
            initialize();
        });
        $(document).ready(function () {
            $(window).bind('resize',initialize);
            audiojs.events.ready(function () {
                var as = audiojs.createAll();
            });
            setTimeout(function(){
                $(window).trigger('resize');

            },3000);

        });
        function resizeMap()
        {
            $(window).trigger('resize');
          if(initialized==false)
          {
              initialize();
          }

            initialized=true;
        }

    </script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#accidentImages").lightGallery({
            showThumbByDefault: false,
            download: false
        });
        $("#accidentImagesOther").lightGallery({
            showThumbByDefault: false,
            download: false
        });
    });
</script>
<style>
    html, body { height:100%; }
</style>