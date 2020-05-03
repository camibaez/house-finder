<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            /*
            'dsn' => 'mysql:host=localhost;dbname=finder',
            'username' => 'root',
            'password' => '',
             */
             
            
            'dsn' => 'mysql:host=venderordb.cbx8bjw8wytz.us-east-2.rds.amazonaws.com;dbname=venderordb',
            'username' => 'admin',
            'password' => 'admin123',
          
            'charset' => 'utf8',
		
        /*
          'enableSchemaCache' => true,

          // Duration of schema cache.
          'schemaCacheDuration' => 3600,

          // Name of the cache component used to store schema information
          'schemaCache' => 'cache',
         */
        ],
    ],
];
