<?php
session_start();   
error_reporting(E_PARSE);
if($_SESSION['logged_in']==1)
{
$con=mysql_connect("localhost","root","");
    if(! $con)
    die("couldn't connect to database");
    mysql_select_db("diary",$con) or die ("cannot select db");
$changed_cover_id=$_GET['cover_id'];



?>
<html>
<head>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<title>
Account Settings
</title>
<link rel="stylesheet" href="pattern.css">
<style>
a.color{color:#008000}
</style>

<script type="text/javascript" language="javascript">
function check_contact()
{
	var error1=0;
	//alert("Hello");
	var v2=f4.ccontact.value.length;
	if(v2<10)
	{
		error1=1;
	alert("Incorrect contact number");
	}
	if(error1==0)
		declare_success();
}
function declare_success()
{
alert("Account Information Successfully Updated.");
}
function check_input()
{
var error=0;

if(f4.cname.value=="" || f4.cdob.value=="" || f4.ccontact.value=="" || f4.cd_name.value=="" )
{
	error=1;
	alert("Please fill the form completely");
	
}
if(error==0)
check_contact();

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
<a href="myspace.php">My Space</a>&nbsp;|&nbsp;<a href="password_setting.php">Change Pasword</a>&nbsp;|&nbsp;<a href="delete_account.php">Deactivate Account</a>&nbsp;|&nbsp;<a href="logout.php">Logout</a>
</font>
</div>
</td>
</tr>

<tr>
<td width="100%">

<form id="f4" method="post" action="account_setting.php">
<br><br>
<table width="100%" border="0">
<tr>
<td width="50%">
<center><font color="#808080" face="Elephant"><h4>Edit Your Information</h4></font></center>
<br><br>
<div align="center">
<?php 
$r="select * from user where username='".$_SESSION['uid']."'";
$r1=mysql_query($r);
$r2=mysql_fetch_array($r1);
if($_GET['change_done']==1)
{
	$r="update user set d_cover='".$changed_cover_id."' where username='".$_SESSION['uid']."' ";
	mysql_query($r);	

$r4="select cover_path from covers,user where user.username='".$_SESSION[uid]."' and user.d_cover=covers.cover_id";
	$r5=mysql_query($r4);
	$r6=mysql_fetch_array($r5);
	$_SESSION['new_user_cover']=$r6['cover_path'];
}

if(isset($_POST['submit']))
{
	$up_uname=addslashes(trim($_POST['cname']));
	$up_dob=addslashes(trim($_POST['cdob']));
	$up_contact=addslashes(trim($_POST['ccontact']));
    $up_dname=addslashes(trim($_POST['cdname']));
    
    $r4="update user set p_name='".$up_uname."', p_dob='".$up_dob."', p_contact='".$up_contact."', d_name='".$up_dname."'  where username='".$_SESSION['uid']."'";
    mysql_query($r4) or die(mysql_error());
header('Location:myspace.php');

}
echo("Change Name&nbsp;:&nbsp;<input type=\"text\" name=\"cname\" value=\"".$r2['p_name']."\">
<br><br>
&nbsp;Change DOB&nbsp;:&nbsp;<input type=\"date\" name=\"cdob\" value=\"".$r2['p_dob']."\">
<br><br>
Change Contact&nbsp;:&nbsp;<input type=\"text\" name=\"ccontact\" value=\"".$r2['p_contact']."\">&nbsp;&nbsp;&nbsp;&nbsp;
");
?>
</div>
</td>

<td width="50%">
<img src="images/as1.jpg" width="300" height="280">
</td>
</tr>

<tr>
<td width="50%">
<br><br>
<center><img src="images/as2.png" width="110" height="110"></center>
</td>
<td width="50%">
<center><font color="#808080" face="Elephant"><h4>Edit Diary Information</h4></font></center>
<center>Change Diary Name&nbsp;:&nbsp;
<?php echo("<input type=\"text\" name=\"cdname\" value=\"".$r2['d_name']."\"></center>");
?>
<br><br>
<center>
<input type="submit" name="submit" value="update acoount information" onclick=return(check_input())>
<br>
<?php echo("<a href=\"cover.php?change=1\" class=\"color\"><h2><b><i>Change Your Diary Cover</i></b></h2></a> ");?>
</center>
</td>
</tr>
</table>
</form>
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