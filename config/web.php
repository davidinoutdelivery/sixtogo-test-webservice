<?php

/**
 * -----------------------------------------------------------------------------
 * Creado Por     | Yii Software LLC
 * Fecha Creación | Desconocida
 * -----------------------------------------------------------------------------
 * Empresa        | InOutDelivery 
 * Aplicación     | webfront-yii2
 * Desarrolladores| David Alejandro Domínguez Rivera                      (DADR)
 * -----------------------------------------------------------------------------
 * Historial de modificaciones:
 * (DADR) 14/Ago/2018 16:30 - 14/Ago/2018 17:20 = Test[success]
 * -    Se agrego el urlManager para manejar las url amigables.
 * (DADR) 15/Ago/2018 11:30 - 15/Ago/2018 12:00 = Test[success]
 * -    Se agrego el assetManager para la libreria yii2-google-maps-library para
 *      el manejo de GoogleMaps.
 */

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => '-BgLebI3QZV9r9DS6krJNmi5-NQgyHKr',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '' => '/site/index',
                ['class' => 'yii\rest\UrlRule', 'controller' => 'driver'],
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => ['@app/views' => '@app/themes/sixtogo'],
                'baseUrl' => '@web/themes/sixtogo',
            ],
        ],
//        'assetManager' => [
//            'bundles' => [
//                'dosamigos\google\maps\MapAsset' => [
//                    'options' => [
//                        'key' => 'AIzaSyAGygNhTiCiqhrTTCeLamEB6BMswcMnx_A',
////                        'language' => 'id',
//                        'version' => '3.1.18'
//                    ]
//                ]
//            ]
//        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
            //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
            //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
