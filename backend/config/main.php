<?php

use kartik\datecontrol\Module;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'food',
    'name' => 'food',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => '/user/index',
    // 'bootstrap' => ['log'],
    'params' => $params,
    'modules' => [
        'acf' => ['class' => 'mdm\admin\Module'],
        'gridview' => ['class' => 'kartik\grid\Module'],
        'datecontrol' =>  [
            'class' => '\kartik\datecontrol\Module',
            'displaySettings' => [
                Module::FORMAT_DATE => 'dd MMM yyyy',
                Module::FORMAT_TIME => 'hh:mm:ss a',
                Module::FORMAT_DATETIME => 'dd-MMM-yyyy hh:mm', 
            ],
            'saveSettings' => [
                Module::FORMAT_DATE => 'php:Y-m-d',
                Module::FORMAT_TIME => 'php:H:i:s',
                Module::FORMAT_DATETIME => 'php:U',
            ],
            'displayTimezone' => 'Asia/Jakarta',
            'saveTimezone' => 'UTC',
            'autoWidget' => true,
            'autoWidgetSettings' => [
                Module::FORMAT_DATE => ['type' => 2, 'pluginOptions' => ['autoclose' => true]], 
                Module::FORMAT_DATETIME => ['pluginOptions' => ['autoclose' => true]], 
                Module::FORMAT_TIME => ['pluginOptions' => ['autoclose' => true]], 
            ],
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\entity\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
            'name' => 'advanced-backend',
            'writeCallback' => function ($session) {
                return [
                    'user_id' => Yii::$app->user->id,
                    'ip_address' => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'],
                    'remote_addr' => $_SERVER['REMOTE_ADDR'],
                    'http_x_forwarded_for' => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? null,
                ];
            },
        ],
        /* 'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ], */
        'errorHandler' => [
            'errorAction' => 'site/error',
            'class' => '\bedezign\yii2\audit\components\web\ErrorHandler',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'js' => [
                        'metronic/plugins/global/plugins.bundle.js', // handler jquery conflict between yii and metronic
                    ]
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // 'cache' => 'cache',
            // 'defaultRoles' => ['administrator'],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@mdm/admin/views' => '@backend/views/_acf',
                    '@vendor/bedezign/yii2-audit/src/views' => '@backend/views/_audit',
                ],
            ],
        ],
        'formatter' => [
            'dateFormat'        => 'dd MMMM yyyy',
            'decimalSeparator'  => ',',
            'thousandSeparator' => '.',
            'currencyCode'      => 'Rp ',
            'locale'            => 'id_ID',
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'area/*',
            'site/*',
            'gridview/*',
            'datecontrol/*',
            'audit/js-log/*',
            // 'debug/*',
            // 'acf/*',
            '*',
        ]
    ],
];
