<?php 
session_start();   
error_reporting(E_PARSE);
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
<style>
a.color{color:#008000}
</style>
</head>
<body>
<center>
<table width="60%" border="0" class="color">


<tr>
<td width="100%">
<img src="images/pad1.png" width="1000" height="1000">

</td>
</tr>

<tr>
<td width="100%">
<div align="center">
<font color="#008000">
<a href="index.php" class="color">Home</a>&nbsp;|&nbsp;<a href="register.php" class="color">Register</a>
</font>
</div>
</td>
</tr>

</table>
</center>
</body>
</html>