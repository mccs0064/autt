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
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/pdf.css" rel="stylesheet">
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

<div class="page-container ">
    <div class="page-content-wrapper ">
        <div class="content ">
            <div class="container-fluid container-fixed-lg bg-white">
                <?php echo $content;?>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTAINER -->

<!-- BEGIN VENDOR JS -->
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
