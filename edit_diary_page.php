<?php
session_start();   
error_reporting(E_PARSE);
if($_SESSION['logged_in']==1)
{
$con=mysql_connect("localhost","root","");
    if(! $con)
    die("couldn't connect to database");
    mysql_select_db("diary",$con) or die ("cannot select db");

if(isset($_POST['update_content']))
{

	$up_content=stripslashes(trim($_POST['up_content']));
	$r1="update pages set content='".$up_content."' where page_num='".$_SESSION['return_p_num']."' and username='".$_SESSION[uid]."'";
	
	if($r1!="")
	{
	mysql_query($r1) or die(mysql_error());
	header('Location:read_page.php?page_num='.$_SESSION[return_p_num].'&page_date='.$_SESSION[return_p_date].'');
	}

}
    
?>
<html>
<head>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<title>
Read Page
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
<br>
<div align="right">
<font color="#FFFFFF">
<a href="myspace.php">Myspace</a>&nbsp;|&nbsp;<a href="internal_search.php">View Other Pages</a>&nbsp;|&nbsp;<a href="logout.php">Logout</a>
</font>
</div>
</td>
</tr>

<tr>
<td width="100%">
<br><br>
<table width="100%" border="0">
<tr>
<td>
<?php echo("<form id=\"edit page\" action=\"edit_diary_page.php\" method=\"post\">

<input type=\"submit\" name=\"update_content\" value=\"update my page\">
<br><br>
<textarea rows=\"50\" cols=\"100\" name=\"up_content\">
");
echo($_GET['content']);
echo("</textarea></form>");

?>
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
$_SESSION['return_p_date']=$_GET['page_date'];
$_SESSION['return_p_num']=$_GET['page_num'];


//}// to ensure page number>0
//else 
//header('Location:myspace.php');
}// ensure access control
else 
header('Location:index.php');
?>
