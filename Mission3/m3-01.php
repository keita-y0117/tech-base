<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>m3-1</title>
</head>
<body>

<?php
$users =[
    [
        'id' => 1,
        'name' =>'よしださん',
        'email' => 'keita.syuukatu0117@gmail.com',
        'password' => 'Keita117',
    ],
    [
        'id' =>2,
        'name' => '江月さん',
        'gmail'=> 'hana.syuukatu0501@gmail.com',
        'password' => 'Hana3Tomo3'
    ],
];
$filename = 'member.csv';

$fp = fopen($filename,'w');

foreach ($users as $line) {
    fputcsv($fp,$line);
}

fclose($fp);

$user = [
    'id' => 3,
    'name' => 'Cさん',
    'email' => 'ccc@c.com',
    'password' => 'ccccc'
];

$fp = fopen($filename,'a');

fputcsv($fp,$user);

fclose($fp);

echo"csvファイルに書き込みました";
?>

</body>
</html>