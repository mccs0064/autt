<?php
$controller=Yii::app()->controller->id;
$action=Yii::app()->controller->action->id;
$currentPage=$controller.$action;

switch($currentPage)
{
    case 'dashboardindex':
        $pageName='Dashboard';
        break;
    case 'fleetmanagersindex':
        $pageName='All Companies';
        break;
    case 'fleetmanagersadd':
        $pageName='Add Company';
        break;
    case 'fleetmanagersupdate':
        $pageName='Update Company';
        break;
    case 'fleetmanagersprofile':
        $pageName='Company Profile';
        break;
    case 'fleetmanagersdrivers':
        $pageName='Drivers';
        break;
    case 'fleetmanagersaccidents':
        $pageName='Accidents';
        break;
    case 'fleetmanagersvehicles':
        $pageName='Vehicles';
        break;
    case 'fleetmanagersaccidentdetail':
        $pageName='Accident Detail';
        break;
    case 'fleetmanagersinspectionreports':
        $pageName='Vehicle Inspection Reports';
        break;
    case 'fleetmanagersinspectiondetail':
        $pageName='Inspection Detail';
        break;
    default:
        $pageName='Dashboard';
        break;
}

?>

<div class="jumbotron" data-pages="parallax">
    <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
        <div class="inner">
            <!-- START BREADCRUMB -->
            <ul class="breadcrumb">
                <li>
                    <p>Administrator</p>
                </li>
                <li><a href="" class="active"><?php echo $pageName;?></a>
                </li>
            </ul>
            <!-- END BREADCRUMB -->
        </div>
    </div>
</div>