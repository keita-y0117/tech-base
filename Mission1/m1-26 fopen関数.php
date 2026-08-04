<?php

$filename = "m_1-25.txt";

$fp = fopen($filename, "r");

if ($fp) {
    while ($line = fgets($fp)) {
        echo $line . "<br />";
    }

    fclose($fp);
}

?>