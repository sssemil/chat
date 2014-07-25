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
$mypassword=$_GET['pass'];

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
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

  $con=mysqli_connect("$host", "$username", "$password","regs");
  // Check connection
  if (mysqli_connect_errno()) {
    echo "500";
    exit(0);
  }
  echo "200";
}
else {
  echo "401";
}
?>
