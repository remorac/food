<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '',
        ],
    ],
    'timeZone' => 'Asia/Jakarta',
    'modules' => [
        'audit' => [
            'class' => 'bedezign\yii2\audit\Audit',
            'layout' => null,
            'ignoreActions' => [
                'audit/*', 
                'debug/*', 
                'area/*', 
                'log/*',
            ],
            'accessRoles' => ['superuser'],
            'userIdentifierCallback' => ['common\models\entity\User', 'userIdentifierCallback'],
            'panels' => [
                'audit/request'    => ['maxAge' => 1],
                'audit/db'         => ['maxAge' => 1],
                'audit/log'        => ['maxAge' => 1],
                'audit/asset'      => ['maxAge' => 1],
                'audit/config'     => ['maxAge' => 1],
                'audit/profiling'  => ['maxAge' => 1],
                'audit/error'      => ['maxAge' => 1],
                'audit/javascript' => ['maxAge' => 1],
                'audit/trail'      => ['maxAge' => null],
                'audit/mail'       => ['maxAge' => 1],
                'audit/extra'      => ['maxAge' => 1],
                'audit/curl'       => ['maxAge' => 1],
                'audit/soap'       => ['maxAge' => 1],
            ],
        ],
    ],
];
