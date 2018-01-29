<?php
$controller=Yii::app()->controller->id;
$action=Yii::app()->controller->action->id;
$currentPage=$controller.$action;
$linkName='Dashboard';
$linkItem='/fleetmanager';
$subLinkItem='';
$subLinkName='';

switch($currentPage)
{
    case 'driversindex':
        $pageName='All Drivers';
        break;
    case 'driversadd':
        $pageName='Add Driver';
        break;
    case 'driversupdate':
        $pageName='Update Driver';
        break;
    case 'driversuploadsheet':
        $pageName='Bulk Driver Create using Spreadsheet';
        break;
    case 'accidentsindex':
        $pageName='All Accidents';
        break;
    case 'accidentsdetail':
        $pageName='Accident Detail';
        break;
    case 'inspectionreportsindex':
        $pageName='Inspection Reports';
        break;
    case 'inspectionreportsdetail':
        $pageName='Inspection Report Detail';
        break;
    case 'vehiclesindex':
        $pageName='All Vehicles';
        break;
    case 'vehiclesadd':
        $pageName='Add Vehicle';
        break;
    case 'vehiclesupdate':
        $pageName='Update Vehicle';
        break;
    case 'vehiclessetinspection':
        $pageName='Set Inspection on Vehicle';
        break;
    case 'driversview':
        $pageName='Driver Profile';
        break;
    case 'vehiclesaddspreadsheet':
        $pageName='Uplaod Spreadsheet';
        break;
    case 'addaccidentbasicinfo':
        $pageName='Add Accident Basic Info';
        break;
    case 'addaccidentmyvehiclephotos':
        $pageName='Accident My Vehicle Photos';
        break;
    case 'addaccidentothervehicles':
        $pageName='Accident Other Vehicles';
        break;
    case 'addaccidentdriverinfo':
        $pageName='Accident Driver Info';
        break;
    case 'addaccidentothervehiclephotos':
        $pageName='Accident Other Vehicle Photos';
        break;
    case 'addaccidentaudio':
        $pageName='Accident Audio Recording';
        break;
    case 'addaccidentpolice':
        $pageName='Accident Police Information';
        break;
    case 'addaccidentnotes':
        $pageName='Accident Notes';
        break;
    case 'inspectionreportsquarterly':
        $pageName='Quarterly Inspection Reports';
        break;
    case 'inspectionreportsdaily':
        $pageName='Daily Inspection Reports';
        break;
    case 'inspectionreportsadd':
        $pageName='Send Quarterly Inspection';
        break;
    case 'inspectionchecklistindex':
        $pageName='Build Inspection List';
        break;
    case 'trailerchecklistindex':
        $pageName='Build Trailer Inspection List';
        break;
    case 'passwordrequestsindex':
        $pageName='Password Requests';
        break;
    case 'driverschangepassword':
        $pageName='Change Password';
        break;
    case 'profileindex':
        $pageName='Update Profile';
        break;
    case 'dashboardindex':
        $pageName='Update Profile';
        $linkItem='/dashboard';
        break;
    case 'inspectionsindex':
        $pageName='Submitted Inspections';
        break;
    case 'inspectiontemplatesindex':
        $pageName='Inspection Templates';
        break;
    default:
        $pageName='';
        $linkName='Dashboard';
        break;
}

?>

<?php

if($currentPage=='dashboardindex'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $linkName='Dashboard';
    $this->renderPartial('../layouts/partials/_dashboard',array('link'=>$link,'linkName'=>$linkName));
}

elseif($currentPage=='driversindex'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $linkName='Dashboard';
    $pageName='All Drivers';
    $this->renderPartial('../layouts/partials/_single',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName));
}

elseif($currentPage=='driversupdate'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $subLink=Yii::app()->request->getBaseUrl(true).'/fleetmanager/drivers';
    $linkName='Dashboard';
    $subLinkName='All Drivers';
    $pageName='Update Driver';
    $this->renderPartial('../layouts/partials/_twice',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName,'subLink'=>$subLink,'subLinkName'=>$subLinkName));
}
elseif($currentPage=='driversview'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $subLink=Yii::app()->request->getBaseUrl(true).'/fleetmanager/drivers';
    $linkName='Dashboard';
    $subLinkName='All Drivers';
    $pageName='Driver Profile';
    $this->renderPartial('../layouts/partials/_twice',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName,'subLink'=>$subLink,'subLinkName'=>$subLinkName));
}

elseif($currentPage=='driversadd'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $linkName='Dashboard';
    $pageName='Add Driver';
    $this->renderPartial('../layouts/partials/_single',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName));
}
elseif($currentPage=='driversuploadsheet'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $linkName='Dashboard';
    $pageName='Driver List Upload';
    $this->renderPartial('../layouts/partials/_single',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName));
}

elseif($currentPage=='vehiclesindex'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $linkName='Dashboard';
    $pageName='All Vehicles';
    $this->renderPartial('../layouts/partials/_single',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName));
}

elseif($currentPage=='vehiclesupdate'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $subLink=Yii::app()->request->getBaseUrl(true).'/fleetmanager/vehicles';
    $linkName='Dashboard';
    $subLinkName='All Vehicles';
    $pageName='Update Vehicle';
    $this->renderPartial('../layouts/partials/_twice',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName,'subLink'=>$subLink,'subLinkName'=>$subLinkName));
}

elseif($currentPage=='vehiclesadd'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $linkName='Dashboard';
    $pageName='Add New Vehicle';
    $this->renderPartial('../layouts/partials/_single',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName));
}
elseif($currentPage=='vehiclesaddspreadsheet'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $linkName='Dashboard';
    $pageName='Upload Vehicles';
    $this->renderPartial('../layouts/partials/_single',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName));
}
elseif($currentPage=='accidentsindex'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $linkName='Dashboard';
    $pageName='All Accidents';
    $this->renderPartial('../layouts/partials/_single',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName));
}

elseif($currentPage=='accidentsdetail'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $subLink=Yii::app()->request->getBaseUrl(true).'/fleetmanager/accidents';
    $linkName='Dashboard';
    $subLinkName='All Accidents';
    $pageName='Accident Detail';
    $this->renderPartial('../layouts/partials/_twice',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName,'subLink'=>$subLink,'subLinkName'=>$subLinkName));
}
elseif($controller=='addaccident'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $linkName='Dashboard';
    $pageName='Add New Accident';
    $this->renderPartial('../layouts/partials/_single',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName));
}

elseif($currentPage=='inspectionreportsdaily'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $linkName='Dashboard';
    $pageName='Daily Inspection Reports';
    $this->renderPartial('../layouts/partials/_single',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName));
}

elseif($currentPage=='inspectionreportsdetail'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $subLink=Yii::app()->request->getBaseUrl(true).'/fleetmanager/vehicles';
    $linkName='Dashboard';
    $subLinkName='Inspection Reports';
    $pageName='Detail';
    $this->renderPartial('../layouts/partials/_twice',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName,'subLink'=>$subLink,'subLinkName'=>$subLinkName));
}

elseif($controller=='inspectionchecklist'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $linkName='Dashboard';
    $pageName='Daily Inspection Checklist';
    $this->renderPartial('../layouts/partials/_single',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName));
}

elseif($controller=='trailerchecklist'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $linkName='Dashboard';
    $pageName='Trailer Inspection Checklist';
    $this->renderPartial('../layouts/partials/_single',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName));
}

elseif($currentPage=='inspectionreportstrailer'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $linkName='Dashboard';
    $pageName='Trailer Inspection Reports';
    $this->renderPartial('../layouts/partials/_single',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName));
}

elseif($controller=='profile'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $linkName='Dashboard';
    $pageName='Fleet Manager Info';
    $this->renderPartial('../layouts/partials/_single',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName));
}
elseif($currentPage=='inspectionsindex'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $linkName='Dashboard';
    $pageName='View Submitted Inspections';
    $this->renderPartial('../layouts/partials/_single',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName));
}
elseif($currentPage=='inspectionsdetail'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $subLink=Yii::app()->request->getBaseUrl(true).'/fleetmanager/inspections';
    $linkName='Dashboard';
    $subLinkName='View Submitted Inspections';
    $pageName='Inspection';

    $this->renderPartial('../layouts/partials/_twice',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName,'subLink'=>$subLink,'subLinkName'=>$subLinkName));
}
elseif($currentPage=='vehiclesdetails'){

    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $subLink=Yii::app()->request->getBaseUrl(true).'/fleetmanager/vehicles';
    $linkName='Dashboard';
    $subLinkName='All Vehicles';
    $pageName='Vehicle Details';

    $this->renderPartial('../layouts/partials/_twice',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName,'subLink'=>$subLink,'subLinkName'=>$subLinkName));
}
elseif($currentPage=='inspectiontemplatesindex'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $linkName='Dashboard';
    $pageName='Existing Inspections';
    $this->renderPartial('../layouts/partials/_single',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName));
}
elseif($currentPage=='inspectiontemplatesupdate'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $subLink=Yii::app()->request->getBaseUrl(true).'/fleetmanager/inspectiontemplates';
    $linkName='Dashboard';
    $subLinkName='Existing Inspections';
    $pageName='Update';

    $this->renderPartial('../layouts/partials/_twice',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName,'subLink'=>$subLink,'subLinkName'=>$subLinkName));
}
elseif($currentPage=='inspectiontemplatesadd'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $linkName='Dashboard';
    $pageName='Build Inspection';
    $this->renderPartial('../layouts/partials/_single',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName));
}
elseif($currentPage=='inspectionsnew'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $linkName='Dashboard';
    $pageName='Complete an Inspection';
    $this->renderPartial('../layouts/partials/_single',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName));
}
elseif($currentPage=='reportsindex'){
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $linkName='Dashboard';
    $pageName='Search Reports';
    $this->renderPartial('../layouts/partials/_single',array('link'=>$link,'linkName'=>$linkName,'pageName'=>$pageName));
}
else

{
    $link=Yii::app()->request->getBaseUrl(true).'/fleetmanager/dashboard';
    $linkName='Dashboard';
    $this->renderPartial('../layouts/partials/_dashboard',array('link'=>$link,'linkName'=>$linkName));
}


?>

<style>
    .main-element
    {
        color: #91c84d !important;
    }
</style>

