<div class="sidebar-menu">
    <!-- BEGIN SIDEBAR MENU ITEMS-->
    <ul class="menu-items">

        <li class="m-t-30 ">
            <a href="javascript:;" id="click_fleet"><span class="title">Companies</span>
                <span class=" arrow"></span></a>
            <span class="icon-thumbnail cursor-pointer" onclick="$('#click_fleet').click()"><i class="fa fa-male"></i></span>
            <ul class="sub-menu">
                <li class="">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/admin/fleetmanagers">View All</a>
                    <span class="icon-thumbnail cursor-pointer" onclick="window.location='<?php echo Yii::app()->request->baseUrl;?>/admin/fleetmanagers'"><i class="fa fa-eye"></i></span>
                </li>
                <li class="">
                    <a href="<?php echo Yii::app()->request->baseUrl;?>/admin/fleetmanagers/add">Add New</a>
                    <span class="icon-thumbnail cursor-pointer" onclick="window.location='<?php echo Yii::app()->request->baseUrl;?>/admin/fleetmanagers/add'"><i class="fa fa-plus-circle"></i></span>
                </li>
            </ul>
        </li>
        <li>
            <a href="<?php echo Yii::app()->request->baseUrl;?>/logout" class="detailed">
                <span class="title">Logout</span>
            </a>
            <span class="icon-thumbnail cursor-pointer" onclick="window.location='<?php echo Yii::app()->request->baseUrl;?>/logout'"><i class="fa fa-sign-out"></i></span>
        </li>


    </ul>
    <div class="clearfix"></div>
</div>
<style>
    .cursor-pointer
    {
        cursor: pointer;
    }
</style>