<?php
$root = dirname(dirname(dirname(__FILE__)));
Yii::setPathOfAlias('root', $root);
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Autium Ltd',
    // preloading 'log' component
    'preload' => array('log'),
    'timeZone' => 'Europe/London',
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.controllers.*',
        'application.modules.*'
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool

        'gii' => array(
            'generatorPaths' => array(
            // 'bootstrap.gii',
            ),
            'class' => 'system.gii.GiiModule',
            'password' => '123456',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
        'api' => array(
        ),
        'fleetmanager'=>array(
        ),
        'admin'=>array(
        )
    ),
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            'class' => 'WebUser',
            'loginUrl' => array('login/'),
        ),
        'easyImage' => array(
            'class' => 'application.extensions.easyimage.EasyImage',
            'driver' => 'Imagick',
            //'quality' => 100,
            //'cachePath' => '/assets/easyimage/',
            'cacheTime' => 60400,
            //'retinaSupport' => false,
        ),
        'helper'=>array(
            'class'=>'Helper'
        ),
        'yexcel' => array(
            'class' => 'ext.yexcel.Yexcel'
        ),
        'commons' => array(
            'class' => 'Commons'
        ),
        'session' => array(
            'timeout' => 86400,
        ),
        'db' => include 'db.php',
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => FALSE,
            'rules' => include 'routes.php'
        ),
        'log' => array(
            'class' => 'CLogRouter',
'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
       'params' => array(
        'isLive' =>false,
           'adminEmail' => 'admin@autium.co.uk',
        'meta_keywords' => 'keywords here',
        'meta_description' => 'Website description goes here',
    )
);





