<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>m2-4</title>
</head>
<body>

<form action="" method="post">
    <input type="text" name="comment" placeholder="コメント">
    <input type="submit" name="submit" value="送信">
</form>

<?php
$filename = "mission_2-4.txt";

if (!empty($_POST["comment"])) {
    $comment = $_POST["comment"];

    $fp = fopen($filename, "a");
    fwrite($fp, $comment . PHP_EOL);
    fclose($fp);
}

if (file_exists($filename)) {
    $lines = file($filename);

    foreach ($lines as $line) {
        echo $line . "<br>";
    }
}
?>

</body>
</html>