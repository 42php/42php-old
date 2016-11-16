<?php

$tables = [
    'Sessions' => [
        'id' => 'auto_increment',
        'data' => 'text',
        'expire' => '!int(11)'
    ],
    'Applications' => [
        'id' => 'auto_increment',
        'key' => 'text',
        'secret' => 'text',
        'device' => 'text'
    ],
    'User' => [
        'id' => 'auto_increment',
        'email' => 'text',
        'password' => 'text',
        'firstname' => 'text',
        'lastname' => 'text',
        'genre' => 'text',
        'registered' => 'datetime',
        'admin' => 'tinyint(1)',
        'slug' => 'text',
        'lang' => 'text',
        'photo' => 'text',
        'email_verified' => 'tinyint(1)'
    ],
    'ProviderAccounts' => [
        'id' => 'auto_increment',
        'userid' => 'int',
        'provider' => 'text',
        'providerid' => 'text'
    ]
];

foreach ($tables as $tablename => $fields) {
    $keys = [];
    $primaryKey = false;
    $list = [];

    foreach ($fields as $field => $type) {
        if (substr($type, 0, 1) == '!') {
            $type = substr($type, 1);
            $keys[] = $field;
        }
        if ($type == 'auto_increment') {
            $primaryKey = $field;
            $type = 'int(11) NOT NULL AUTO_INCREMENT';
        }
        $list[] = '`' . $field . '` ' . $type;
    }

    if ($primaryKey)
        $list[] = 'PRIMARY KEY (`' . $primaryKey . '`)';

    foreach ($keys as $key)
        $list[] = 'KEY `' . $key . '` (`' . $key . '`)';

    $query = 'CREATE TABLE IF NOT EXISTS `' . $tablename . '` (' . implode(', ', $list) . ') DEFAULT CHARSET=utf8';

    echo "Creating $tablename ... ";
    \Core\Db::getInstance()->exec($query);
    echo "Done.\n";
}