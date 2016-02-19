<?php
session_start();   
error_reporting(E_PARSE);
if($_SESSION['logged_in']==1)
{
	$con=mysql_connect("localhost","root","");
    if(! $con)
    die("couldn't connect to database");
    mysql_select_db("diary",$con) or die ("cannot select db");

   //if(isset($_POST['submit']))
   //{
   	//header('Location:logout.php');
   //}
   
?>
<html>
<head>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<title>
Delete Account
</title>
<link rel="stylesheet" href="pattern.css">
<style>
a.color{color:#008000}
</style>

<script type="text/javascript" language="javascript">

function notify_del()
{
alert("Your account has been deactivated.");	
}
</script>

</head>
<body>
<center>
<table width="60%" border="0">
<tr>
<td width="100%" height="60" bgcolor="#4CC417">
<font color="#FFFFFF" size="95" face="Elephant">
&nbsp;&nbsp;
Express</font>
<font color="#FFFFFF" face="Elephant">
<sub>.&nbsp;.&nbsp;.&nbsp;life your way</sub>
</font>
<br>
<div align="right">
<font color="#FFFFFF">
<a href="myspace.php">My Space</a>&nbsp;|&nbsp;<a href="account_setting.php">Account Settings</a>&nbsp;|&nbsp;<a href="logout.php">Logout</a>
</font>
</div>
</td>
</tr>

<tr>
<td width="100%">
<br><br><br>
<table width="100%" border="0">
<tr>
<td width="50%">
<img src="images/delete.jpg" width="300" height="300">
</td>

<td width="50%">
<center>
<?php 
if(isset($_POST['submit']))
{

$r1="delete from schedule where username='".$_SESSION[uid]."'";	
mysql_query($r1);

$r2="delete from sticky_notes where username='".$_SESSION[uid]."'";	
mysql_query($r2);	
	
$r3="delete from bookmark where username='".$_SESSION[uid]."'";
mysql_query($r3);

$r4="delete from photos where username='".$_SESSION[uid]."'";
mysql_query($r4);

$r5="delete from pages where username='".$_SESSION[uid]."'";
mysql_query($r5);

$r6="delete from followed where followed.username='".$_SESSION[uid]."' or followed.followed_username='".$_SESSION[uid]."'";
mysql_query($r6);

$r8="delete from follow_info where username='".$_SESSION[uid]."'";
mysql_query($r8);

$r9="delete from publish_info where username='".$_SESSION[uid]."'";
mysql_query($r9);


$r7="delete from user where username='".$_SESSION['uid']."'";
mysql_query($r7);	


header('Location:logout.php');
}
?>
<form id="f5" action="delete_account.php" method="post">
<font color="#808080" face="Times New Roman"><h3><b>Are you sure you want to deactivate your account?</b></h3></font>
<br>
<input type="submit" name="submit" value="confirm" onclick="notify_del()">
</form>
</center>
</td>
</tr>
</table>
</td>
</tr>


</table>
</center>

</body>
</html>
<?php 
}
else 
header('Location:index.php');
?>