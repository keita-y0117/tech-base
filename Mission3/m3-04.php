<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>m3-04</title>
</head>
<body>

<!-- 名前とコメントを入力するフォーム -->
<form action="" method="post">
    <input type="text" name="name" placeholder="名前">
    <input type="text" name="comment" placeholder="コメント">
    <input type="submit" name="submit" value="送信">
</form>

<?php
// 投稿内容を保存するCSVファイル名を決める
$filename = "mission_3.csv";


// -------------------------
// ① フォームから送信された内容をCSVに保存する処理
// -------------------------

// 名前とコメントの両方が入力されている時だけ処理する
// どちらかが空の場合は保存しない
if (!empty($_POST["name"]) && !empty($_POST["comment"])) {

    // フォームから送られてきた名前を変数に入れる
    $name = $_POST["name"];

    // フォームから送られてきたコメントを変数に入れる
    $comment = $_POST["comment"];

    // 現在の日時を取得する
    $date = date("Y/m/d H:i:s");


    // 投稿番号を決める
    // すでにCSVファイルがある場合は、行数を数えて「次の番号」にする
    if (file_exists($filename)) {
        $lines = file($filename);
        $num = count($lines) + 1;
    } else {
        // CSVファイルがまだない場合は、最初の投稿なので1番にする
        $num = 1;
    }


    // CSVに保存する1行分のデータを配列にまとめる
    // 保存形式：投稿番号,名前,コメント,投稿日時
    $data = [$num, $name, $comment, $date];


    // CSVファイルを追記モードで開く
    // "a" は、前の内容を消さずに後ろへ追加するモード
    $fp = fopen($filename, "a");

    // 配列のデータをCSV形式で1行書き込む
    fputcsv($fp, $data);

    // 開いたファイルを閉じる
    fclose($fp);
}


// -------------------------
// ② CSVファイルを読み込んで、投稿一覧を表示する処理
// -------------------------

// CSVファイルが存在する場合だけ表示処理を行う
// まだ1件も投稿がない場合は、ファイルがないので何も表示しない
if (file_exists($filename)) {

    // CSVファイルを読み込みモードで開く
    // "r" は読み込み専用
    $fp = fopen($filename, "r");

    // 投稿一覧の見出しを表示
    echo "<h2>投稿一覧</h2>";

    // 表の開始
    echo '<table border="1">
            <tr>
                <th>投稿番号</th>
                <th>名前</th>
                <th>コメント</th>
                <th>投稿日時</th>
            </tr>';


    // CSVファイルを1行ずつ読み込む
    // fgetcsvは、1行を読み込んでカンマごとに分けて配列にしてくれる
    while ($data = fgetcsv($fp)) {

        // 1投稿分を表の1行として表示する
        echo "<tr>";

        // $data[0] には投稿番号が入っている
        echo "<td>" . $data[0] . "</td>";

        // $data[1] には名前が入っている
        echo "<td>" . $data[1] . "</td>";

        // $data[2] にはコメントが入っている
        echo "<td>" . $data[2] . "</td>";

        // $data[3] には投稿日時が入っている
        echo "<td>" . $data[3] . "</td>";

        echo "</tr>";
    }

    // 表の終了
    echo "</table>";

    // 開いたファイルを閉じる
    fclose($fp);
}
?>

</body>
</html>