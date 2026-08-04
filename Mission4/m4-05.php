<?php

// ----------------------------
// DB接続設定（Mission4-1）
// ----------------------------
require __DIR__ . '/../db_connect.php';


// ----------------------------
// 登録するデータを変数に入れる
// ----------------------------

// 名前
$name = "Taro";

// コメント
$comment = "こんばんわ";


// ----------------------------
// INSERT文を書く
// ----------------------------
$sql = "INSERT INTO tbtest (name, comment)
        VALUES (:name, :comment)";


// SQLを準備する
$stmt = $pdo->prepare($sql);


// プレースホルダに変数を入れる
$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);


// SQLを実行する
$stmt->execute();

echo "データを登録しました";

?>
