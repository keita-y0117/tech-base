<?php

// ----------------------------
// DB接続設定
// ----------------------------
require __DIR__ . '/../db_connect.php';

// ----------------------------
// 更新後の内容を用意
// ----------------------------
$id = 1;
$name = 'keita';
$comment = 'おっはよー！';

// ----------------------------
// UPDATE文を作る
// ----------------------------
$sql = "UPDATE tbtest
        SET name = :name, comment = :comment
        WHERE id = :id";

// SQLを準備
$stmt = $pdo->prepare($sql);

// プレースホルダに値を入れる
$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

// SQLを実行
$stmt->execute();

// ----------------------------
// 更新後のデータを表示して確認
// ----------------------------
$sql = "SELECT * FROM tbtest ORDER BY id";
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();

foreach ($results as $row) {
    echo $row['id'] . ',';
    echo $row['name'] . ',';
    echo $row['comment'] . '<br>';
}
?>
