<?php

$configFile = __DIR__ . '/db_config.php';

if (!file_exists($configFile)) {
    throw new RuntimeException(
        'db_config.php がありません。db_config.example.php をコピーして接続情報を設定してください。'
    );
}

$dbConfig = require $configFile;

foreach (['dsn', 'user', 'password'] as $requiredKey) {
    if (!isset($dbConfig[$requiredKey]) || $dbConfig[$requiredKey] === '') {
        throw new RuntimeException('db_config.php の接続情報が不足しています。');
    }
}

$pdo = new PDO(
    $dbConfig['dsn'],
    $dbConfig['user'],
    $dbConfig['password'],
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

