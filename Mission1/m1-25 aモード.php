<?php
  $str = "Hello Taro ";
  $str = "法政大学 ";
  $str = "よろしくね ";
  $filename = "m_1-25.txt";


  $fp = fopen($filename,"a");
  fwrite($fp,"Hello Taro " .PHP_EOL);
  fwrite($fp,"法政大学 " .PHP_EOL);
  fwrite($fp,"よろしくね " .PHP_EOL);
  fclose($fp);


  echo "書き込み成功！";
?>