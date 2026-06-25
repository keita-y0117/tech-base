<?php

$members = array("Ken", "Alice", "Judy", "BOSS", "Bob");

$count = count($members);

$i = 0;

while ($i < $count) {
    echo $members[$i] . " is at work.<br>";
    $i++;
}

?>