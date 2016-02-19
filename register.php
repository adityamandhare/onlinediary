<?php
session_start(); 
error_reporting(E_PARSE);
if($_SESSION['logged_in']!=1)
{  
	$con=mysql_connect("localhost","root","");
    if(! $con)
    die("couldn't connect to database");
    else 
    mysql_select_db("diary",$con) or die ("cannot select db");
	
    
 ?>
<html>
<head>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<title>
Register Yourself
</title>
<link rel="stylesheet" href="pattern.css">
<script type="text/javascript" language="javascript">
function check_input()
{
	var error=0;
if(f2.username.value=="" || f2.password.value=="" || f2.repassword.value=="" || f2.uname.value=="" || f2.bdate.value=="" || f2.contact.value=="" )
{
	alert("Please fill the form completely");
	error=1;

}
else
{

var v2=f2.contact.value.length;

var v3=f2.password.value.length;
var v4=f2.repassword.value.length;
if(v3!=v4)
{
	alert("The passwords you entered do not match!");	
    error=1;
}
else
{
for( var i=0;i<v3;++i)
	if(f2.password.value.charAt(i)!=f2.repassword.value.charAt(i))
		{
		alert("The passwords you entered do not match.");
        error=1;
        break;
	    }
}
if(v2<10)
{
alert("Incorrect contact number");
error=1;
}

}
if(error==1)
return false
else
return true
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
<a href="index.php">Home</a>&nbsp;|&nbsp;<a href="register.php">Register</a>&nbsp;|&nbsp;<a href="index.php">Login</a>&nbsp;|&nbsp;<a href="about_us.php">About us</a>
</font>
</div>
</td>
</tr>

<tr>
<td width="100%">
<br><br>
<table width="100%" border="0">
<tr>
<td width="50%">
<img src="images/register.png" width="400" height="500">
</td>
<td width="40%">
<?php 

if(isset($_POST['submit']))
	{
	    
    $username=addslashes(trim($_POST['username']));
    $password=sha1(addslashes(trim($_POST['password'])));
    $repassword=sha1(addslashes(trim($_POST['repassword'])));
    $uname=addslashes(trim($_POST['uname']));
    $bdate=addslashes(trim($_POST['bdate']));
    $contact=addslashes(trim($_POST['contact']));
    
    
    
    $sel1="select username from user where username='".$username."'";
    $sel2=mysql_query($sel1);
    $sel3=mysql_fetch_array($sel2);
    
    if($sel3==0)
    {
    $_SESSION['new_user']=$username;
    $_SESSION['new_password']=$password;
    $_SESSION['new_uname']=$uname;
    $_SESSION['new_bdate']=$bdate;
    $_SESSION['new_contact']=$contact;
    
    //$r="insert into user(username,password,p_name,p_dob,p_contact)values('$username','$password','$uname','$bdate','$contact')";
    //mysql_query($r);
    header('Location:selectdiary.php');
    }
    else 
    {

   echo("<div align=\"right\"><font color=\"#800000\"><b>Please select another username.</b></font></div><br>");
    }
	
}   	


?>



<form id="f2" action="register.php" method="post">
<div align="right">
<?php 
echo("
Username&nbsp;:&nbsp;<input name=\"username\" type=\"text\" value=\"".$username."\">
<br><br>
Password&nbsp;:&nbsp;<input name=\"password\" type=\"password\">
<br><br>
Confirm password&nbsp;:&nbsp;<input name=\"repassword\" type=\"password\">
<br><br>
Name&nbsp;:&nbsp;<input name=\"uname\" type=\"text\" value=\"".$uname."\">
<br><br>
Date of Birth&nbsp;:&nbsp;<input name=\"bdate\" type=\"date\" value=\"".$bdate."\">
<br><br>
Contact number&nbsp;:&nbsp;<input name=\"contact\" type=\"text\" value=\"".$contact."\">
");?>
<br><br>
</div>
<center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;<input type="submit" value="Save and Proceed" name="submit" onclick=return(check_input())></center>
</form>
</td>

<td width="10%">

</td>

</tr>
</table>


</td>
<td width="50%">
</td>
</tr>



</table>
</center>
</body>
</html>
<?php 
}
else 
header('Location:myspace.php');
?>