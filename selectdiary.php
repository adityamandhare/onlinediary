<?php
session_start();   
error_reporting(E_PARSE);
	
if($_SESSION['logged_in']!=1)
{
$con=mysql_connect("localhost","root","");
    if(! $con)
    die("couldn't connect to database");
    mysql_select_db("diary",$con) or die ("cannot select db");
$cover_id=$_GET['cover_id'];

if($_GET['cover_selected']==1)
{
$_SESSION['cover_id']=$_GET['cover_id'];
//echo $_SESSION['cover_id'];
}
if(isset($_POST['submit']))
{
 $username=$_SESSION['new_user'];
 $password=$_SESSION['new_password'];
 $uname=$_SESSION['new_uname'];
 $bdate=$_SESSION['new_bdate'];
 $contact=$_SESSION['new_contact'];	
$dname=addslashes(trim($_POST['dname']));
$cover=$_SESSION['cover_id'];

if($cover==0)
$cover=1;

$r="insert into user(username,password,d_cover,d_name,p_name,p_dob,p_contact)values('$username','$password','$cover','$dname','$uname','$bdate','$contact')";
mysql_query($r) or die(mysql_error());

$r1="insert into publish_info(username,total_pages,total_public,public_1,public_2,public_3,public_4,public_5,public_6,public_7,public_8,public_9,public_10,public_11,
public_12,public_13,public_14)values('$username','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0')";
mysql_query($r1);

$r2="insert into follow_info(username,total_follow,follow_1,follow_2,follow_3,follow_4,follow_5,follow_6,follow_7,follow_8,follow_9,follow_10,follow_11,follow_12,
follow_13,follow_14)
values('$username','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0')";
mysql_query($r2);

$r3="insert into likes (username,like_pages)values('$username',',')";
mysql_query($r3) or die(mysql_error());

header('Location:index.php');
}
?>
<html>
<head>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<title>
Diary info...
</title>
<link rel="stylesheet" href="pattern.css">
<style>
a.color{color:#008000}
</style>

<script type="text/javascript" language="javascript">
function check_input()
{
	var error=0;
	
if(f3.dname.value=="")
	{
	alert("Enter a diary name.");
error=1;
	}
	if(error==0)
		alert("You can now Login and start Expressing Yourself !!")

		if(error==1)
			return false
			else
				return true
}
</script>
</head>
<body>

<center>
<table width="60%" border="0" class="green">
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
<a href="index.php">Home</a>&nbsp;|&nbsp;<a href="register.php">Register</a>&nbsp;|&nbsp;<a href="about_us.php">About us</a>
</font>
</div>
</td>
</tr>

<tr>
<td width="100%">
<table width="100%" border="0">
<tr>
<td width="50%">
<br><br><br><br>
<center><img src="images/select1.jpg" width="250" height="300"></center>
</td>

<td width="40%">
<div align="right">

<center><a href="cover.php" class="color"><b><i>Select A Diary Cover</i></b></a></center>
<br>
<form id="f3" action="selectdiary.php" method="post">
<font color="">
<b>
Diary Name&nbsp;:&nbsp;<input type="text" name="dname">
<br><br>
</b>
</font>
<br>
<center><input type="submit" name="submit" value="Done" onclick="check_input()"></center>
</form>
<br>

</div>

</td>

<td width="10%">
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