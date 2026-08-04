<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>m3-03</title>
</head>
<body>

<form action="" method="post">
    <input type="text" name="name" placeholder="名前">
    <input type="text" name="comment" placeholder="コメント">
    <input type="submit" name="submit" value="送信">
</form>

<?php
$filename = "mission_3.csv";

if (!empty($_POST["name"]) && !empty($_POST["comment"])) {
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $date = date("Y/m/d H:i:s");

    if (file_exists($filename)) {
        $lines = file($filename);
        $num = count($lines) + 1;
    } else {
        $num = 1;
    }

    $data = [$num, $name, $comment, $date];

    $fp = fopen($filename, "a");
    fputcsv($fp, $data);
    fclose($fp);

    echo "投稿を保存しました";
}
?>

</body>
</html>