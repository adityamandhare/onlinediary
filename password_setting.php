<?php
session_start();   
if($_SESSION['logged_in']==1)
{
error_reporting(E_PARSE);
	$con=mysql_connect("localhost","root","");
    if(! $con)
    die("couldn't connect to database");
    mysql_select_db("diary",$con) or die ("cannot select db");

    

if(isset($_POST['submit']))
{
$pass=sha1(addslashes(trim($_POST['password'])));
$cpass=sha1(addslashes(trim($_POST['repassword'])));	
$r="update user set password='".$pass."' where username='".$_SESSION[uid]."'";
mysql_query($r);
header('Location:account_setting.php');
}  
    
    
?>
<html>
<head>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<title>
Password Setting
</title>
<link rel="stylesheet" href="pattern.css">
<style>
a.color{color:#008000}
</style>
<script type="text/javascript" language="javascript">
function check_input()
{
	var error=0;
if(f6.password.value=="" || f6.repassword.value=="")
{
	alert("Please fill the form completely");
	error=1;

}
else
{

var v3=f6.password.value.length;
var v4=f6.repassword.value.length;
if(v3!=v4)
{
	alert("The passwords you entered do not match!");	
    error=1;
}
else
{
for( var i=0;i<v3;++i)
	if(f6.password.value.charAt(i)!=f6.repassword.value.charAt(i))
		{
		alert("The passwords you entered do not match.");
        error=1;
        break;
	    }
}

}
if(error==0) 
alert("Your Password has been changed successfully.");

if(error==1)
	return false;
else
	return true;
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
<table width="100%">
<tr>
<td width="50%">
<img src="images/password.png">
</td>
<td width="50%">

<form id="f6" method="post" action="password_setting.php">
<center>
&nbsp;&nbsp;&nbsp;&nbsp;Enter New Password&nbsp;:&nbsp;<input type="password" name="password">
<br><br>
Confirm New Password&nbsp;:&nbsp;<input type="password" name="repassword">
<br><br>
<input type="submit" name="submit" value="change password" onclick=return(check_input())>
</center>
</form>
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