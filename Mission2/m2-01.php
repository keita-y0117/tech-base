<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>m2-1</title>
</head>
<body>

<form action="" method="post">
    <input type="text" name="comment" value="コメント">
    <input type="submit" name="submit" value="送信">
</form>

<?php
if (isset($_POST["comment"])) {
    $comment = $_POST["comment"];
    echo $comment . "を受け付けました";
}
?>

</body>
</html>