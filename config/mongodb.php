<?php

return [

    'class' => '\yii\mongodb\Connection',
    'dsn' => 'mongodb://@localhost:27017/api',
    'options' => [
      "username" => "admin",
      "password" => "0000"
    ]
  
//    'class' => 'yii\db\Connection',
//    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
//    'username' => 'root',
//    'password' => '',
//    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
