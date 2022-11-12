<?php

return [
    'class' => 'yii\db\Connection',
/*    'dsn' => $_ENV['DB_SECOND_DSN'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'], */
    'dsn' => 'mysql:host=db-second;port=3306;dbname=library',
    'username' => 'root',
    'password' => 'editor',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
