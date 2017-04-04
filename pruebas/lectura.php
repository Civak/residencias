<?php
$file = fopen("grupofundamentos.csv","r");

while(!feof($file) && ($line = fgetcsv($file)) !== FALSE)
  {
  echo $line[1].'<br>';
  }

fclose($file);
?>
