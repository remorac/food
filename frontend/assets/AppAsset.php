<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 * Using metronic demo-2
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700",
        "metronic/plugins/custom/fullcalendar/fullcalendar.bundle.css",
		"metronic/plugins/global/plugins.bundle.css",
		"metronic/plugins/custom/prismjs/prismjs.bundle.css",
		"metronic/css/style.bundle.css",
		"metronic/css/themes/layout/header/base/light.css",
		"metronic/css/themes/layout/header/menu/light.css",
		"metronic/css/themes/layout/brand/dark.css",
        "metronic/css/themes/layout/aside/dark.css",
		"metronic/media/logos/favicon.ico",
		'css/metronic-override.css',
    ];
    public $js = [
		// "metronic/plugins/global/plugins.bundle.js", // conflict with JqueryAsset: see config/main.php
		"metronic/plugins/custom/prismjs/prismjs.bundle.js",
		"metronic/js/scripts.bundle.js",
		"metronic/plugins/custom/fullcalendar/fullcalendar.bundle.js",
		"//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM",
		"metronic/plugins/custom/gmaps/gmaps.js",
		"metronic/js/pages/widgets.js",
	];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
