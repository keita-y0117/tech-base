<?php

// ----------------------------
// DB接続設定
// ----------------------------
require __DIR__ . '/../db_connect.php';


// ----------------------------
// 削除するidを指定
// ----------------------------
$id = 2;


// ----------------------------
// DELETE文
// ----------------------------
$sql = "DELETE FROM tbtest WHERE id=:id";


// SQLを準備する
$stmt = $pdo->prepare($sql);


// プレースホルダに値を入れる
$stmt->bindParam(':id', $id, PDO::PARAM_INT);


// SQLを実行する
$stmt->execute();


// 削除後のデータを表示
$sql = "SELECT * FROM tbtest";
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();

foreach ($results as $row) {
    echo $row['id'] . ",";
    echo $row['name'] . ",";
    echo $row['comment'] . "<br>";
}

?>
