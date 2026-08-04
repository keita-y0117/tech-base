<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title> m3-02 </title>
</head>
<body>

<?php
$filename = 'member.csv';

$fp = fopen($filename, 'r');

echo '<table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Mail</th>
            <th>Password</th>
        </tr>';

while ($data = fgetcsv($fp)) {
    echo '<tr>';
    echo '<td>' . $data[0] . '</td>';
    echo '<td>' . $data[1] . '</td>';
    echo '<td>' . $data[2] . '</td>';
    echo '<td>' . $data[3] . '</td>';
    echo '</tr>';
}

echo '</table>';

fclose($fp);
?>

</body>
</html>