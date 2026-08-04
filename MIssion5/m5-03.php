<?php

// ----------------------------
// DB接続
// ----------------------------
require __DIR__ . '/../db_connect.php';


// ----------------------------
// フォームに表示する初期値
// ----------------------------
$edit_name = "";
$edit_comment = "";
$edit_id = "";


// ----------------------------
// 新規投稿・編集実行
// ----------------------------
if (
    isset($_POST["submit"]) &&
    !empty($_POST["name"]) &&
    !empty($_POST["comment"])
) {
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $post_edit_id = $_POST["edit_id"];

    // edit_idが空なら新規投稿
    if (empty($post_edit_id)) {

        $sql = "INSERT INTO tbboard (name, comment, date)
                VALUES (:name, :comment, NOW())";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);

        $stmt->execute();

    // edit_idがあれば編集
    } else {

        $sql = "UPDATE tbboard
                SET name = :name,
                    comment = :comment
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':id', $post_edit_id, PDO::PARAM_INT);

        $stmt->execute();
    }
}


// ----------------------------
// 削除処理
// ----------------------------
if (
    isset($_POST["delete"]) &&
    !empty($_POST["delete_id"])
) {
    $delete_id = $_POST["delete_id"];

    $sql = "DELETE FROM tbboard WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);

    $stmt->execute();
}


// ----------------------------
// 編集対象のデータを取得
// ----------------------------
if (
    isset($_POST["edit"]) &&
    !empty($_POST["edit_number"])
) {
    $edit_number = $_POST["edit_number"];

    $sql = "SELECT * FROM tbboard WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $edit_number, PDO::PARAM_INT);

    $stmt->execute();

    $result = $stmt->fetch();

    if ($result) {
        $edit_name = $result["name"];
        $edit_comment = $result["comment"];
        $edit_id = $result["id"];
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>掲示板</title>
</head>

<body>

    <!-- 新規投稿・編集フォーム -->
    <form action="" method="post">
        <input
            type="text"
            name="name"
            placeholder="名前"
            value="<?php echo htmlspecialchars($edit_name, ENT_QUOTES, 'UTF-8'); ?>"
        >

        <input
            type="text"
            name="comment"
            placeholder="コメント"
            value="<?php echo htmlspecialchars($edit_comment, ENT_QUOTES, 'UTF-8'); ?>"
        >

        <input
            type="hidden"
            name="edit_id"
            value="<?php echo htmlspecialchars($edit_id, ENT_QUOTES, 'UTF-8'); ?>"
        >

        <input type="submit" name="submit" value="送信">
    </form>

    <br>

    <!-- 削除フォーム -->
    <form action="" method="post">
        <input
            type="number"
            name="delete_id"
            placeholder="削除対象番号"
        >

        <input type="submit" name="delete" value="削除">
    </form>

    <br>

    <!-- 編集番号指定フォーム -->
    <form action="" method="post">
        <input
            type="number"
            name="edit_number"
            placeholder="編集対象番号"
        >

        <input type="submit" name="edit" value="編集">
    </form>

    <hr>

    <?php

    // ----------------------------
    // 投稿一覧を表示
    // ----------------------------
    $sql = "SELECT * FROM tbboard";
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();

    foreach ($results as $row) {
        echo $row['id'] . ",";
        echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . ",";
        echo htmlspecialchars($row['comment'], ENT_QUOTES, 'UTF-8') . ",";
        echo $row['date'] . "<br>";
    }

    ?>

</body>

</html>
