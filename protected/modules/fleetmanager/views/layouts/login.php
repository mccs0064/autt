<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title><?php $this->pageTitle;?></title>
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
    <link class="main-stylesheet" href="<?php echo Yii::app()->request->baseUrl;?>/css/pages.css" rel="stylesheet" type="text/css" />
    <!--[if lte IE 9]>
    <link href="<?php echo Yii::app()->request->baseUrl;?>/css/ie9.css" rel="stylesheet" type="text/css" />
    <![endif]-->
</head>
<body class="fixed-header ">
<div class="login-wrapper ">
    <!-- START Login Background Pic Wrapper-->
    <div class="bg-pic">
        <img src="<?php echo Yii::app()->request->baseUrl;?>/img/login-cover.jpg" data-src="<?php echo Yii::app()->request->baseUrl;?>/img/login-cover.jpg" alt="" class="lazy">
        <!-- START Background Caption-->
        <div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
            <h2 class="semi-bold text-white">
                <img src="<?php echo Yii::app()->request->baseUrl;?>/img/autium-login-logo.png"/>
            </h2>

        </div>
        <!-- END Background Caption-->
    </div>
    <!-- END Login Background Pic Wrapper-->
    <!-- START Login Right Container-->
   <?php echo $content;?>
    <!-- END Login Right Container-->
</div>

<!-- BEGIN VENDOR JS -->
<script src="<?php echo Yii::app()->request->baseUrl;?>/plugins/pace/pace.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/plugins/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
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
<script src="<?php echo Yii::app()->request->baseUrl;?>/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<!-- END VENDOR JS -->
<script src="<?php echo Yii::app()->request->baseUrl;?>/js/pages.js"></script>
</body>
</html>