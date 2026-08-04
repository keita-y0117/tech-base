<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_2-2</title>
</head>
<body>

<form action="" method="post">
    <input type="text" name="comment" value="コメント">
    <input type="submit" name="submit" value="送信">
</form>

<?php
$filename = "mission_2-2.txt";

if (!empty($_POST["comment"])) {
    $comment = $_POST["comment"];

    $fp = fopen($filename, "w");
    fwrite($fp, $comment);
    fclose($fp);

    echo $comment . "を保存しました<br>";

    if ($comment == "完成") {
        echo "おめでとう！";
    }
}
?>

</body>
</html>