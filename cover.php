<?php
session_start();   
error_reporting(E_PARSE);

if($_SESSION['logged_in']!=1 || $_GET['change'])
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
Select a diary cover
</title>
<link rel="stylesheet" href="pattern.css">
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
<br>
<font color="#C0C0C0" face="Elephant"><b>
<h2>Select cover image for your diary</h2>
</b></font>
</td>
</tr>

</table>
</center>

<center>
<form>
<table width="60%" border="0">
<tr>
<td width="100%">
<?php 
$p="select * from covers";
$p1=mysql_query($p) or die(mysql_error());

$rows=mysql_num_rows($p1);
?>

<table width="100%" border="0" cellspacing="10">
<?php 
echo("<tr>");
for ($i = 1; $i <= 42; $i++)
{
$r=mysql_fetch_array($p1);
$r1=$r['cover_path'];
if($_GET['change']==1 && $_SESSION['logged_in']==1)
echo("<td width=\"17%\"><center><a href=\"account_setting.php?cover_id=".$i."&change_done=1\"><img src=\"$r1\" width=\"100\" height=\"100\"></a></center></td>");
else
echo("<td width=\"17%\"><center><a href=\"selectdiary.php?cover_id=".$i."&cover_selected=1\"><img src=\"$r1\" width=\"100\" height=\"100\"></a></center></td>");
if($i%4==0)
echo("</tr><tr>");
}
echo("</tr>");

?>
</table>

</td>
</tr>

</table>
</form>
</center>
</body>
</html>
<?php 
}
else 
header('Location:index.php');
?>