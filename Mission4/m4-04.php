<?php

// ----------------------------
// DB接続設定（Mission4-1）
// ----------------------------
require __DIR__ . '/../db_connect.php';


// ----------------------------
// tbtestテーブルの構成を取得
// ----------------------------
$sql = "SHOW CREATE TABLE tbtest";

// SQLを実行
$result = $pdo->query($sql);


// ----------------------------
// 結果を表示
// ----------------------------
foreach ($result as $row) {

    // CREATE TABLE文を表示
    echo $row[1];

    // 見やすいように改行
    echo "<br><br>";
}

?>
