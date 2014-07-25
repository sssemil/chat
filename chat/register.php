<?php
$host="localhost"; // Host name 
$username="root"; // Mysql username 
$password="*"; // Mysql password 
$db_name="regs"; // Database name 
$tbl_name="members"; // Table name 

// Connect to server and select databse.
$con=mysql_connect("$host", "$username", "$password")or die("500"); 
mysql_select_db("$db_name")or die("500");


// username and password sent from form 
$myusername=$_GET['id'];
$mypassword=$_GET['pass'];
$myemail=$_GET['email'];
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myemail = stripslashes($myemail);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$myemail = mysql_real_escape_string($myemail);

$sql="SELECT * FROM $tbl_name WHERE username='$myusername'";
$result=mysql_query($sql);

$count=mysql_num_rows($result);

if($count==1){
  echo "409";
  exit(0);
}
mysql_close($con);

if(!filter_var($myemail, FILTER_VALIDATE_EMAIL))
{
  echo "412";
  exit(0);
}

$con=mysqli_connect("$host", "$username", "$password",$db_name);
// Check connection
if (mysqli_connect_errno()) {
  echo "500";
}
$date=date('Y/m/d H:i:s');
$ip=$_SERVER['REMOTE_ADDR'];
$result=mysqli_query($con,"INSERT INTO members (username, password, email, reg_date, last_date, reg_ip, last_ip)
VALUES ('$myusername', '$mypassword', '$myemail', '$date', '$date', '$ip', '$ip')");

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count!=1){
  echo "200";
}
else {
  echo "400";
}
?>
