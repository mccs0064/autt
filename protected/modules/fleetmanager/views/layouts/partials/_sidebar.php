<div class="sidebar-menu">
    <!-- BEGIN SIDEBAR MENU ITEMS-->
    <ul class="menu-items">
        <li class="m-t-30 ">
            <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/dashboard" class="detailed">
                <span class="title">Dashboard</span>
            </a>
            <span onclick="window.location='<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/dashboard'" class="bg-success icon-thumbnail"><i class="pg-home"></i></span>
        </li>

        <li>
            <a href="javascript:;"><span class="title">Drivers</span>
                <span class=" arrow"></span></a>
            <span class="icon-thumbnail"><i class="fa fa-male"></i></span>
            <ul class="sub-menu">
                <li class="">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/drivers">View All</a>
                    <span onclick="window.location='<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/drivers'" class="icon-thumbnail"><i class="fa fa-eye"></i></span>
                </li>
                <li class="">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/drivers/add">Add New</a>
                    <span onclick="window.location='<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/drivers/add'" class="icon-thumbnail"><i class="fa fa-plus-circle"></i></span>
                </li>
                <li class="">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/drivers/uploadsheet">Upload Spreadsheet</a>
                    <span onclick="window.location='<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/drivers/uploadsheet'" class="icon-thumbnail"><i class="fa fa-plus-circle"></i></span>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;"><span class="title">Vehicles</span>
                <span class=" arrow"></span></a>
            <span class="icon-thumbnail"><i class="fa fa-truck"></i></span>
            <ul class="sub-menu">
                <li class="">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/vehicles">View All</a>
                    <span onclick="window.location='<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/vehicles'" class="icon-thumbnail"><i class="fa fa-eye"></i></span>
                </li>
                <li class="">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/vehicles/add">Add New</a>
                    <span onclick="window.location='<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/vehicles/add'" class="icon-thumbnail"><i class="fa fa-plus-circle"></i></span>
                </li>
                <li class="">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/vehicles/addspreadsheet">Upload Spreadsheet</a>
                    <span onclick="window.location='<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/vehicles/addspreadsheet'" class="icon-thumbnail"><i class="fa fa-upload"></i></span>
                </li>

            </ul>
        </li>
        <li>
            <a href="javascript:;"><span class="title">Accidents</span>
                <span class=" arrow"></span>
            </a>
            <span class="icon-thumbnail"><i class="fa fa-exclamation-triangle"></i></span>
            <ul class="sub-menu">
                <li class="">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/accidents">View All</a>
                    <span onclick="window.location='<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/accidents'" class="icon-thumbnail"><i class="fa fa-eye"></i></span>
                </li>
                <li class="">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/addaccident/basicinfo">Add New</a>
                    <span onclick="window.location='<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/addaccident/basicinfo'" class="icon-thumbnail"><i class="fa fa-plus-circle"></i></span>
                </li>

            </ul>
        </li>

        <li>
            <a href="javascript:;"><span class="title">Inspections</span>
                <span class=" arrow"></span></a>
            <span class="icon-thumbnail"><i class="fa fa-eye"></i></span>
            <ul class="sub-menu">
                <li class="">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/inspections">View Submitted Inspections</a>
                    <span onclick="window.location='<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/inspections'" class="icon-thumbnail"><i class="fa fa-cog"></i></span>
                </li>

                <li class="">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/inspectiontemplates/add">Build Inspection</a>
                    <span onclick="window.location='<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/inspectiontemplates/add'" class="icon-thumbnail"><i class="fa fa-plus"></i></span>
                </li>
                <li class="">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/inspectiontemplates">Existing Inspection</a>
                    <span onclick="window.location='<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/inspectiontemplates'" class="icon-thumbnail"><i class="fa fa-list"></i></span>
                </li>
                <li class="">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/inspections/new">Complete an Inspection</a>
                    <span onclick="window.location='<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/inspections/new'" class="icon-thumbnail"><i class="fa fa-check"></i></span>
                </li>
                <li class="">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/reports">Reports</a>
                    <span onclick="window.location='<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/reports'" class="icon-thumbnail"><i class="fa fa-check"></i></span>
                </li>

            </ul>
        </li>


        <li>
            <a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/profile" class="detailed">
                <span class="title">Profile</span>
            </a>
            <span onclick="window.location='<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/profile'" class="icon-thumbnail"><i class="fa fa-user"></i></span>
        </li>
        <li>
            <a href="<?php echo Yii::app()->request->baseUrl;?>/logout" class="detailed">
                <span class="title">Logout</span>
            </a>
            <span onclick="window.location='<?php echo Yii::app()->request->baseUrl;?>/logout'" class="icon-thumbnail"><i class="fa fa-sign-out"></i></span>
        </li>


    </ul>
    <div class="clearfix"></div>
</div>
<style>
    .icon-thumbnail
    {
        cursor: pointer;
    }

</style>
<script>
    $(".icon-thumbnail").click(function () {
        $(this).prev('a').click();
    });
</script>