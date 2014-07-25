<?php
$host="localhost"; // Host name 
$username="root"; // Mysql username 
$password="*"; // Mysql password 
$db_name="regs"; // Database name 
$tbl_name="members"; // Table name 

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("500"); 
mysql_select_db("$db_name")or die("500");

// username and password sent from form 
$myusername=$_GET['id'];
$tousername=$_GET['to'];
$mypassword=$_GET['pass'];

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$tousername = stripslashes($tousername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$tousername = mysql_real_escape_string($tousername);
$mypassword = mysql_real_escape_string($mypassword);
$sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){
  $date=date('Y/m/d H:i:s');
  $ip=$_SERVER['REMOTE_ADDR'];
  $sql2 = "UPDATE $tbl_name
        SET last_date='$date'
        WHERE username='$myusername'";
  $result2=mysql_query($sql2);
  $count2=mysql_num_rows($result2);

  $sql3 = "UPDATE $tbl_name
        SET last_ip='$ip'
        WHERE username='$myusername'";
  $result2=mysql_query($sql2);
  $count2=mysql_num_rows($result2);

  mysql_connect("$host", "$username", "$password")or die("500"); 
  mysql_select_db("$db_name")or die("500");

  $con=mysqli_connect("$host", "$username", "$password","$db_name");

  $lastDate=$con->query("SELECT last_date FROM $tbl_name WHERE username='$tousername'")->fetch_object()->last_date;  
  $last_date=$lastDate;
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
}
else {
  echo "401";
}
?>
