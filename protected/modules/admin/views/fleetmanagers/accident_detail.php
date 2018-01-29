<div class="container-fluid container-fixed-lg">


    <!-- START PANEL -->
    <div class="panel panel-transparent">
        <div class="panel-heading">
            <div class="panel-title">Accident Detail
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
                                <p class="number_plate"><?php echo $model['vehicle_reg'];?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2">
                                <p class="text-uppercase"><strong>Make:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo $model['make'];?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2">
                                <p class="text-uppercase"><strong>Model:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo $model['model'];?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2">
                                <p class="text-uppercase"><strong>Accident Time:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo date('jS F, Y h:i:s A',strtotime($model['occured_at']));?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-2">
                                <p class="text-uppercase"><strong>Driver:</strong></p>
                            </div>
                            <div class="col-xs-3">
                                <p class=""><?php echo $model->driver->full_name;?></p>
                            </div>
                        </div>
                        <br><br>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-fillup" data-init-reponsive-tabs="dropdownfx">
                            <li class="active">
                                <a data-toggle="tab" href="#tab-screenshots"><span>Screenshots</span></a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab-audios"><span>Audios</span></a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab-eyewitness"><span>Eye Witnesses</span></a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab-police"><span>Police</span></a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab-accidentmap" onclick="resizeMap()"><span>Accident Location</span></a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-screenshots">
                                <div class="row column-seperation">

                                        <?php
                                        $screenshots = AccidentMedia::model()->findAllByAttributes(array('media_type' => 'Image', 'accident_id' => $model['id']));
                                        if (!empty($screenshots)):?>

                                                <div class="accident-images" id="accidentImages">
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
                            <div class="tab-pane" id="tab-eyewitness">
                                <?php $eyeWitnesses = $model->accidentWitnesses;
                                if (!empty($eyeWitnesses)):
                                    foreach ($eyeWitnesses as $key=>$eyeWitness):
                                        ?>
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <div class="panel panel-transparent">
                                                    <div class="panel-heading">
                                                        <div class="panel-title"><?php echo "Eye Witness ".($key+1);?>
                                                        </div>
                                                    </div>
                                                    <div class="panel-body">
                                                        <address class="margin-bottom-20 margin-top-10">
                                                            <strong><?php echo $eyeWitness['fullname'];?></strong>
                                                            <br><?php echo $eyeWitness['address'];?>
                                                            <br>
                                                            <abbr title="DOB">DOB:</abbr><?php echo $eyeWitness['date_of_birth'];?>
                                                            <br>
                                                            <abbr title="Phone">P:</abbr><?php echo $eyeWitness['phone_number'];?>
                                                        </address>
                                                        <br/>
                                                        <address>
                                                            <strong>Eye Witness Audio Statement</strong>
                                                            <br><br>
                                                            <audio src="<?php echo Yii::app()->request->baseUrl; ?>/uploads/<?php echo $eyeWitness['directory_name']; ?>/<?php echo $eyeWitness['witness_audio_statement']; ?>" preload="auto"/>
                                                        </address><br><br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach;?>

                                <?php else:?>
                                    <p>This accident does not have any eye witnesses</p>
                                <?php endif; ?>
                            </div>
                            <div class="tab-pane" id="tab-police">
                                <?php $accidentPolice = $model->accidentPolices;
                                if (!empty($accidentPolice)):
                                foreach ($accidentPolice as $key=>$police):
                                ?>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="panel panel-transparent">
                                            <div class="panel-heading">
                                                <div class="panel-title"><?php echo "Police Officer ".($key+1);?>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <address class="margin-bottom-20 margin-top-10">
                                                    <strong><?php echo $police['officer_name'];?></strong>
                                                    <br><?php echo $police['police_station'];?>
                                                    <br>
                                                    <abbr title="Phone">P:</abbr><?php echo $police['phone_number'];?>
                                                </address>
                                                <br/><br/>
                                            </div>
                                        </div>
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
                                            <h3>Loction where accident occured</h3>
                                            <div id="accidentMap" style="width:615px; height:315px" data-longitude="<?php echo $model['longitude'];?>" data-latitude="<?php echo $model['latitude'];?>">
                                            </div>
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
        $(document).ready(function () {
            audiojs.events.ready(function () {
                var as = audiojs.createAll();
            });
            initialize();
        });
        function resizeMap()
        {

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
    });
</script>
<style>
    html, body { height:100%; }
</style>