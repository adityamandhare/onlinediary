<?php 
session_start();
error_reporting(E_PARSE);   
if($_SESSION['logged_in']==1)
header('Location:myspace.php');
else 
{
	$con=mysql_connect("localhost","root","");
    if(! $con)
    die("couldn't connect to database");
    mysql_select_db("diary",$con) or die ("cannot select db");
?>
<html>
<head>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<title>
Express..life your way
</title>
<link rel="stylesheet" href="pattern.css">
<script type="text/javascript">
function check_password()
{
if(f1.username.value=="" && f1.password.value=="")
	alert("Enter Username and Password");
else
if(f1.username.value=="" && f1.password.value!="")
	alert("You need to Enter Username ");
else
if(f1.password.value=="" && f1.username.value!="")
	alert("You need to Enter Password");		
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
</td>
</tr>

<tr>
<td width="100%">
<table width="100%">
<tr>
<td width="50%">
<br><br>
<img src="images/pencil_char.jpg" width="330" height="290">
</td>

<td width="50%" background="images/page.png">
<br><br><br>
<center>

<form id="f1" action="index.php" method="post">
<?php
if(isset($_POST['submit']))
{
$u=addslashes(trim($_POST['username']));
$p=sha1(addslashes(trim($_POST['password1'])));
//echo $u;
//echo $p;
$r="select password from user where username='".$u."'";
$r1=mysql_query($r) or die(mysql_error());
$r2=mysql_fetch_array($r1);
$check=strcmp($p,$r2['password']);
}    
 
if(isset($_POST['submit']))
{
if($check!=0)
{
	echo("<font color=\"#008000\"><b>Incorrect username/password!<br></b></font>");	
}
else
{
	
	$r="select user.d_id, user.d_name, cover_path, num_pages, num_people_following from covers,user where user.username='".$u."' and user.d_cover=covers.cover_id";
	$r1=mysql_query($r);
	$r2=mysql_fetch_array($r1);
	$_SESSION['new_user_cover']=$r2['cover_path'];
//echo("Path is".$_SESSION['new_user_cover']);
$_SESSION['logged_in']=1;
$_SESSION['uid']=$u;	
$_SESSION['logged_in_user_did']=$r2['d_id'];
$_SESSION['logged_in_user_dname']=$r2['d_name'];
$_SESSION['logged_in_user_num_pages']=$r2['num_pages'];
$_SESSION['following_logged_in_user']=$r2['num_of_people_following'];
header('Location:myspace.php');
}
}
?>
<br>
Username&nbsp;:&nbsp;<input name="username" type="text">
<br><br>
Password&nbsp;:&nbsp;<input name="password1" type="password">
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" name="submit" value="Login" onclick="check_password()">
</form>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="register.php"><font color="#4CC417">Register</font></a>

</center>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td width="100%">
<table width="100%"  border="0">
<tr>
<td width="50%">
<center><a href="register.php"><img src="images/page2.png" width="250" height="230" title="register here"></a></center>
</td>
<td>
<img src="images/img2.jpg" width="400" height="250">
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
?>