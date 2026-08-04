<?php

  $filename = ("m_1-25.txt");


  if (file_exists($filename)) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES);


    foreach ($lines as $line) {
        echo $line . "<br / >";
        
    }
  }
?>