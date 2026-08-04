<?php

// ----------------------------
// DB接続設定（Mission4-1）
// ----------------------------
require __DIR__ . '/../db_connect.php';


// ----------------------------
// SELECT文を書く
// ----------------------------
$sql = "SELECT * FROM tbtest";


// SQLを実行
$stmt = $pdo->query($sql);


// 取得したデータを全部配列に入れる
$results = $stmt->fetchAll();


// ----------------------------
// 1件ずつ表示する
// ----------------------------
foreach($results as $row){

    // id
    echo $row["id"] . ",";

    // 名前
    echo $row["name"] . ",";

    // コメント
    echo $row["comment"];

    // 改行
    echo "<br>";

    // 区切り線
    echo "<hr>";
}

?>
