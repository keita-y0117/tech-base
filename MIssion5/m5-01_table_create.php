<?php

require __DIR__ . '/../db_connect.php';

$sql = "CREATE TABLE IF NOT EXISTS tbboard (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(32),
    comment TEXT,
    date DATETIME
)";

$stmt = $pdo->query($sql);

echo "テーブルを作成しました";

?>
