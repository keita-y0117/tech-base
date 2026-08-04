<?php

// ----------------------------
// DB接続
// ----------------------------
require __DIR__ . '/../db_connect.php';


// ----------------------------
// 新規投稿処理
// ----------------------------
if (
    !empty($_POST["name"]) &&
    !empty($_POST["comment"])
) {
    $name = $_POST["name"];
    $comment = $_POST["comment"];

    $sql = "INSERT INTO tbboard (name, comment, date)
            VALUES (:name, :comment, NOW())";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);

    $stmt->execute();
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>掲示板</title>
</head>

<body>

    <form action="" method="post">
        <input type="text" name="name" placeholder="名前">
        <input type="text" name="comment" placeholder="コメント">
        <input type="submit" value="送信">
    </form>

    <hr>

    <?php

    // ----------------------------
    // 投稿一覧を取得
    // ----------------------------
    $sql = "SELECT * FROM tbboard";
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();

    foreach ($results as $row) {
        echo $row['id'] . ",";
        echo $row['name'] . ",";
        echo $row['comment'] . ",";
        echo $row['date'] . "<br>";
    }

    ?>

</body>

</html>
