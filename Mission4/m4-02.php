<?php
require __DIR__ . '/../db_connect.php';

$sql = "CREATE TABLE IF NOT EXISTS tbtest"
    . " ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name CHAR(32),"
    . "comment TEXT"
    . ");";

$stmt = $pdo->query($sql);

echo "tbtestを作成しました";
?>
