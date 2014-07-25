<?php
$lastDate='2014/07/24 10:48:23';
$pieces = explode(" ", $lastDate);
$pieces2 = explode(":", $pieces[1]);
$pieces3 = explode("/", $pieces[0]);

$pieces_ = explode(" ", date('Y/m/d H:i:s'));
$pieces_2 = explode(":", $pieces_[1]);
$pieces_3 = explode("/", $pieces_[0]);

$timeFirst  = strtotime($lastDate);
$timeSecond = strtotime(date('Y/m/d H:i:s'));
$differenceInSeconds = $timeSecond - $timeFirst;

if($differenceInSeconds<200) {
  $last_date = "NOW";
} elseif($pieces[0]==$pieces_[0] && $pieces2[0]==$pieces_2[0] && $pieces2[1]!==$pieces_2[1]) {
  $last_date = $pieces_2[1] - $pieces2[1] . "MIN AGO";
} elseif($pieces[0]==$pieces_[0] && $pieces2[0]!==$pieces_2[0]) {
  if($pieces_2[0] - $pieces2[0]>1) {
    $last_date = $pieces_2[0] - $pieces2[0] . "HRS AGO";
  } elseif($pieces_2[0] - $pieces2[0]==1) {
    $last_date = $pieces_2[0] - $pieces2[0] . "HR AGO";
  }
} elseif($pieces3[0]==$pieces_3[0] && $pieces3[1]==$pieces_3[1] && $pieces3[2]==($pieces_3[2]-1)) {
  $last_date = "YESTERDAY";
} elseif($pieces3[0]==$pieces_3[0] && $pieces3[1]==$pieces_3[1] && $pieces3[2]<($pieces_3[2]-1)) {
  $last_date = $pieces_3[2] - $pieces3[2] . "DAYS AGO";
} elseif($pieces3[0]==$pieces_3[0] && $pieces3[1]<$pieces_3[1]) {
  if($pieces_3[1] - $pieces3[1]>1) {
    $last_date = $pieces_3[1] - $pieces3[1] . "MONTHS AGO";
  } elseif($pieces_3[1] - $pieces3[1]==1) {
    $last_date = $pieces_3[1] - $pieces3[1] . "MONTH AGO";
  }
} elseif($pieces3[0]<$pieces_3[0]) {
  if($pieces_3[0] - $pieces3[0]>1) {
    $last_date = $pieces_3[0] - $pieces3[0] . "YRS AGO";
  } elseif($pieces_3[0] - $pieces3[0]==1) {
    $last_date = $pieces_3[0] - $pieces3[0] . "YR AGO";
  }
} else {
  $last_date = $lastDate;
}
echo $last_date;
?>
