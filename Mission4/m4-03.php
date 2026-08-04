<?php
// ----------------------
// DB接続設定
// ----------------------
require __DIR__ . '/../db_connect.php';

// ----------------------
// テーブル一覧を取得
// ----------------------
$sql = "SHOW TABLES";

// SQLを実行
$result = $pdo->query($sql);

// 取得したテーブル名を表示
foreach ($result as $row) {

    // テーブル名を表示
    echo $row[0];

    // 改行
    echo "<br>";
}

// 区切り線
echo "<hr>";
?>
