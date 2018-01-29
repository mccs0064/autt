<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title><?php echo $this->pageTitle;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <link rel="apple-touch-icon" href="pages/ico/60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="pages/ico/76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="pages/ico/120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="pages/ico/152.png">
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="<?php echo Yii::app()->request->baseUrl;?>/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl;?>/plugins/bootstrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl;?>/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl;?>/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo Yii::app()->request->baseUrl;?>/plugins/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo Yii::app()->request->baseUrl;?>/plugins/switchery/css/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo Yii::app()->request->baseUrl;?>/css/pages-icons.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->request->baseUrl;?>/plugins/lightbox/css/lightbox.min.css" rel="stylesheet" type="text/css">
    <link class="main-stylesheet" href="<?php echo Yii::app()->request->baseUrl;?>/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/responsiveslides.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/lightgallery.css" rel="stylesheet">
    <!--[if lte IE 9]>
    <link href="<?php echo Yii::app()->request->baseUrl;?>/plugins/codrops-dialogFx/dialog.ie.css" rel="stylesheet" type="text/css" media="screen" />
    <![endif]-->
    <script src="<?php echo Yii::app()->request->baseUrl;?>/plugins/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/plugins/audiojs/audio.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/plugins/lightbox/js/lightbox.min.js"></script>
    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCy55I7oiEbfkd9q4NH2Gk2Fd1b2NVnbjo"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/responsiveslides.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lightgallery.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lg-thumbnail.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lg-fullscreen.min.js"></script>
</head>
<body class="fixed-header menu-pin">

<!-- BEGIN SIDEBPANEL-->
<nav class="page-sidebar" data-pages="sidebar">
    <!-- BEGIN SIDEBAR MENU TOP TRAY CONTENT-->
    <div class="sidebar-overlay-slide from-top" id="appMenu">
        <div class="row">
            <div class="col-xs-6 no-padding">
                <a href="#" class="p-l-40"><img src="<?php echo Yii::app()->request->baseUrl;?>/img/demo/social_app.svg" alt="socail">
                </a>
            </div>
            <div class="col-xs-6 no-padding">
                <a href="#" class="p-l-10"><img src="<?php echo Yii::app()->request->baseUrl;?>/img/demo/email_app.svg" alt="socail">
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 m-t-20 no-padding">
                <a href="#" class="p-l-40"><img src="<?php echo Yii::app()->request->baseUrl;?>/img/demo/calendar_app.svg" alt="socail">
                </a>
            </div>
            <div class="col-xs-6 m-t-20 no-padding">
                <a href="#" class="p-l-10"><img src="<?php echo Yii::app()->request->baseUrl;?>/img/demo/add_more.svg" alt="socail">
                </a>
            </div>
        </div>
    </div>
    <!-- END SIDEBAR MENU TOP TRAY CONTENT-->
    <!-- BEGIN SIDEBAR MENU HEADER-->
    <div class="sidebar-header">
        <img src="<?php echo Yii::app()->request->baseUrl;?>/img/autium-header-logo-green.png" alt="logo" class="brand" data-src="<?php echo Yii::app()->request->baseUrl;?>/img/autium-header-logo-green.png" data-src-retina="<?php echo Yii::app()->request->baseUrl;?>/img/autium-header-logo-green.png">
        <div class="sidebar-header-controls">
            <button type="button" class="btn btn-xs sidebar-slide-toggle btn-link m-l-20">
            </button>
            <button type="button" class="btn btn-link visible-lg-inline" data-toggle-pin="sidebar" id="open-sidebar"><i class="fa fs-12"></i>
            </button>
        </div>
    </div>
    <!-- END SIDEBAR MENU HEADER-->
    <!-- START SIDEBAR MENU -->
        <?php $this->renderPartial('../layouts/partials/_sidebar');?>
    <!-- END SIDEBAR MENU -->
</nav>
<!-- END SIDEBAR -->
<!-- END SIDEBPANEL-->
<!-- START PAGE-CONTAINER -->
<div class="page-container ">
    <!-- START HEADER -->
    <div class="header ">
        <!-- START MOBILE CONTROLS -->
        <div class="container-fluid relative">
            <!-- LEFT SIDE -->
            <div class="pull-left full-height visible-sm visible-xs">
                <!-- START ACTION BAR -->
                <div class="header-inner">
                    <a href="#" class="btn-link toggle-sidebar visible-sm-inline-block visible-xs-inline-block padding-5" data-toggle="sidebar">
                        <span class="icon-set menu-hambuger"></span>
                    </a>
                </div>
                <!-- END ACTION BAR -->
            </div>
            <div class="pull-center hidden-md hidden-lg">
                <div class="header-inner">
                    <div class="brand inline">
                        <img src="<?php echo Yii::app()->request->baseUrl;?>/img/autium-header-logo-green.png" alt="logo" data-src="<?php echo Yii::app()->request->baseUrl;?>/img/autium-header-logo-green.png" data-src-retina="<?php echo Yii::app()->request->baseUrl;?>/img/autium-header-logo-green.png">
                    </div>
                </div>
            </div>
            <!-- RIGHT SIDE -->
            <div class="pull-right full-height visible-sm visible-xs">
                <!-- START ACTION BAR -->
                <div class="header-inner">
                    <a href="#" class="btn-link visible-sm-inline-block visible-xs-inline-block" data-toggle="quickview" data-toggle-element="#quickview">
                        <span class="icon-set menu-hambuger-plus"></span>
                    </a>
                </div>
                <!-- END ACTION BAR -->
            </div>
        </div>
        <!-- END MOBILE CONTROLS -->
        <div class=" pull-left sm-table hidden-xs hidden-sm">
            <div class="header-inner">
                <div class="brand inline">
                    <img src="<?php echo Yii::app()->request->baseUrl;?>/img/autium-header-logo-green.png" alt="logo" data-src="<?php echo Yii::app()->request->baseUrl;?>/img/autium-header-logo-green.png" data-src-retina="<?php echo Yii::app()->request->baseUrl;?>/img/autium-header-logo-green.png">
                </div>
       </div>
            </div>
        <div class=" pull-right">
            <div class="header-inner">
                <a href="#" class="btn-link icon-set menu-hambuger-plus m-l-20 sm-no-margin hidden-sm hidden-xs" data-toggle="quickview" data-toggle-element="#quickview"></a>
            </div>
        </div>
        <div class=" pull-right">
            <!-- START User Info-->
            <div class="visible-lg visible-md m-t-10">
                <div class="pull-left p-r-10 p-t-10 fs-16 font-heading">

                    <span class="semi-bold"><?php echo Yii::app()->user->getState('first_name'); ?></span> <span class="text-master"><?php echo Yii::app()->user->getState('last_name'); ?></span>
                </div>
                <?php
                $picture_path=Yii::app()->request->baseUrl.'/img/avatar_default.jpg';
                $picture=Yii::app()->user->getState('picture');
                if(!empty($picture))
                {
                    $picture_path=Yii::app()->request->baseUrl.'/uploads/profile/'.$picture;
                }
                ?>
                <div class="dropdown pull-right">
                    <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="thumbnail-wrapper d32 circular inline m-t-5">
                <img src="<?php echo $picture_path;?>" alt="" data-src="<?php echo $picture_path;?>" data-src-retina="<?php echo Yii::app()->request->baseUrl;?>/img/profiles/avatar_small2x.jpg" width="32" height="32">
            </span>
                    </button>
                    <ul class="dropdown-menu profile-dropdown" role="menu">
                        <li><a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/profile"><i class="pg-outdent"></i> Profile</a>
                        </li>
                        <li><a href="<?php echo Yii::app()->request->baseUrl;?>/fleetmanager/changepassword"><i class="pg-outdent"></i> Change Password</a>
                        </li>

                        <li class="bg-master-lighter">
                            <a href="<?php echo Yii::app()->request->baseUrl;?>/logout" class="clearfix">
                                <span class="pull-left">Logout</span>
                                <span class="pull-right"><i class="pg-power"></i></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- END User Info-->
        </div>
    </div>
    <!-- END HEADER -->
    <!-- START PAGE CONTENT WRAPPER -->
    <div class="page-content-wrapper ">
        <!-- START PAGE CONTENT -->
        <div class="content ">
            <!-- START JUMBOTRON -->
          <?php $this->renderPartial('../layouts/partials/_breadcrumbs');?>
            <!-- END JUMBOTRON -->
            <!-- START CONTAINER FLUID -->
            <div class="container-fluid container-fixed-lg bg-white" id="bg-white-container">
                <!-- BEGIN PlACE PAGE CONTENT HERE -->
                <?php echo $content;?>
                <!-- END PLACE PAGE CONTENT HERE -->
            </div>
            <!-- END CONTAINER FLUID -->
        </div>
        <!-- END PAGE CONTENT -->
        <!-- START COPYRIGHT -->
        <!-- START CONTAINER FLUID -->
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid container-fixed-lg footer">
            <div class="copyright sm-text-center">
                <p class="small no-margin pull-left sm-pull-reset">
                    <span class="hint-text">Copyright &copy; <?php echo date('Y');?> </span>
                    <span class="font-montserrat"><?php echo Yii::app()->name;?></span>.
                    <span class="hint-text">All rights reserved. </span>
                    <span class="sm-block"><a href="<?php echo Yii::app()->request->baseUrl;?>/terms" class="m-l-10 m-r-10">Terms of use</a> | <a href="<?php echo Yii::app()->request->baseUrl;?>/privacypolicy" class="m-l-10">Privacy Policy</a></span>  | <a href="<?php echo Yii::app()->request->baseUrl;?>/subscription" class="m-l-10">Subscription</a></span>
                </p>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- END COPYRIGHT -->
    </div>
    <!-- END PAGE CONTENT WRAPPER -->
</div>
<!-- END PAGE CONTAINER -->

<!-- BEGIN VENDOR JS -->
<script src="<?php echo Yii::app()->request->baseUrl;?>/plugins/pace/pace.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/plugins/modernizr.custom.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/plugins/bootstrapv3/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/plugins/jquery/jquery-easy.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/plugins/jquery-bez/jquery.bez.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/plugins/jquery-ios-list/jquery.ioslist.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/plugins/jquery-actual/jquery.actual.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/plugins/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/plugins/bootstrap-select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/plugins/classie/classie.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl;?>/plugins/switchery/js/switchery.min.js" type="text/javascript"></script>
<!-- END VENDOR JS -->
<!-- BEGIN CORE TEMPLATE JS -->
<script src="<?php echo Yii::app()->request->baseUrl;?>/js/pages.js"></script>
<!-- END CORE TEMPLATE JS -->
<!-- BEGIN PAGE LEVEL JS -->
<script src="<?php echo Yii::app()->request->baseUrl;?>/js/scripts.js" type="text/javascript"></script>
<!-- END PAGE LEVEL JS -->
</body>
</html>
