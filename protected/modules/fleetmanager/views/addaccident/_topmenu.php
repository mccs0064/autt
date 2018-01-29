<?php
$action=Yii::app()->controller->action->id;
?>

<li class="<?php echo $action=='basicinfo'?'active':null;?>">
    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/addaccident/navigate/route/basicinfo"><i class="fa fa-list tab-icon"></i> <span>Basic Info</span></a>
</li>
<li class="<?php echo $action=='myvehiclephotos'?'active':null;?>">
    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/addaccident/navigate/route/myvehiclephotos"><i class="fa fa-file-image-o tab-icon"></i> <span>My Photos</span></a>
</li>
<li class="<?php echo $action=='othervehicles'?'active':null;?>">
    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/addaccident/navigate/route/othervehicles"><i class="fa fa-car tab-icon"></i> <span>Other Vehicles</span></a>
</li>
<li class="<?php echo $action=='othervehiclephotos'?'active':null;?>">
    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/addaccident/navigate/route/othervehiclephotos"><i class="fa fa-file-image-o tab-icon"></i> <span>Other Vehicles Photos</span></a>
</li>
<li class="<?php echo $action=='audio'?'active':null;?>">
    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/addaccident/navigate/route/audio"><i class="fa fa-file-sound-o tab-icon"></i> <span>Audio</span></a>
</li>
<li class="<?php echo $action=='police'?'active':null;?>">
    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/addaccident/navigate/route/police"><i class="fa fa-male tab-icon"></i> <span>Police</span></a>
</li>
<li class="<?php echo $action=='notes'?'active':null;?>">
    <a  href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/addaccident/navigate/route/notes"><i class="fa fa-sticky-note tab-icon"></i> <span>Post Accident Interview</span></a>
</li>