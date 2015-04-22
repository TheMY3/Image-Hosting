<?php
if (YII_DEBUG == true) {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=savepic',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ];
}
else {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=wapics',
        'username' => 'root',
        'password' => '1111',
        'charset' => 'utf8',
    ];
}