<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',

    'language' => 'es-ES',
    'sourceLanguage' => 'en-US',
    'name' => "Venderor",
    'components' => [

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' =>  false,
            //'enableStrictParsing' => true,
			 'rules' => [
				'<alias:\w+>' => 'site/<alias>',
				//'<alias:\w+>' => 'house/<alias>',
				],

        ],

        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
        ],
         'mobile-detect' =>[
            'class' => \common\components\mobile_detection\MobileDetectionComponent::className(),
        ],
         'view' =>[
            'class' => \common\components\mobile_detection\ResponsiveView::className()
        ]

    ],

];
