<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Mission1-27</title>
</head>
<body>
  <form action="" method="post">
      <input type="number" name="num" placeholder="数字を入力してくだい">
      <input type="submit" name="submit">
  </form>

<?php
$filename = "m_1-27.txt";

if (isset($_POST["num"])) {
    $num = $_POST["num"];

    $fp = fopen("m_1-27.txt", "a");

    fwrite($fp,$num . PHP_EOL);
    fclose($fp);

    echo "書き込み成功！<br />";
}

if (file_exists($filename)) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES);

    foreach ($lines as $line){
        $num = (int)$line;
    

        if ($num % 3 == 0 && $num % 5 == 0) {
            echo "FizzBuzz<br />";
        } elseif ($num % 3 == 0) {
            echo "Fizz<br />";
        } elseif ($num % 5 == 0) {
            echo "Buzz<br />";
        } else {
            echo $num . "<br />";
        }
    }
}
?> 
