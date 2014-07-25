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

  $msg_name=$myusername . " " . $tousername;
  $msg_name1=$myusername . " " . $tousername;
  $msg_name2=$tousername . " " . $myusername;

  if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$msg_name1."'"))==1)
  {
     $msg_name=$msg_name1;
  }
  else
  {
      if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$msg_name2."'"))==1)
      {
         $msg_name=$msg_name2;
      }
      else
      {
         $sqlC = "CREATE TABLE `$msg_name1`( ".
                "msg TEXT NOT NULL, date TEXT NOT NULL, seen TEXT NOT NULL, ip TEXT NOT NULL, sender TEXT NOT NULL); ";
         $retvalC = mysql_query( $sqlC);
         if(! $retvalC )
         {
           die('500');
         }       
         $msg_name=$msg_name1;
      }
  }

  $result = mysql_query("SELECT * FROM `$msg_name`");

  while($row = mysql_fetch_array($result))
  {
    $msg = $row['msg'];
    $sql4 = "UPDATE `$msg_name`
          SET seen='1'
          WHERE sender='$tousername'";
    $result4=mysql_query($sql4);
    $count4=mysql_num_rows($result4);
    echo $row['sender'] . "\n";
    echo $row['msg'] . "\n";
    echo $row['date'] . "\n";
    echo $row['seen'] . "\n";
  }
}
else {
  echo "401";
}
?>
