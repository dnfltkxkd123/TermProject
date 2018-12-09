<?php
  $test = [
    '수학' => 100,
    '국어' => 80
  ];
  $sum = "";
  foreach($test as $row => $val){
  	$sum .=$row;
  }
  echo $sum;
?>