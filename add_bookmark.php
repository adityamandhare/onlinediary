<?php
session_start();   
error_reporting(E_PARSE);
if($_SESSION['logged_in']==1)
{
//if($_GET['page_num']>0)
//{
$con=mysql_connect("localhost","root","");
    if(! $con)
    die("couldn't connect to database");
    mysql_select_db("diary",$con) or die ("cannot select db");

  
    
    if(isset($_POST['submit']))
    {
    	$info=stripslashes(trim($_POST['bookmark_info']));	
    	$i="insert into bookmark(username,bookmark_pid,bookmark_name)values('$_SESSION[uid]','$_SESSION[bookmarked_page_id]','$info')";
 	        mysql_query($i) or die(mysql_error());
    	
 	    if($_SESSION['come_from_notify']==1)
    	{
 	    $del1="delete from notification where username='".$_SESSION[uid]."' and page_id='".$_SESSION[bookmarked_page_id]."'";
 	    mysql_query($del1);
    	header('Location:myspace.php?opt=9');
    	}
    	else
    	header('Location:read_shared_page.php?page_id='.$_SESSION[bookmarked_page_id].'&d_id='.$_SESSION[bookmarked_d_id].'');
    }
?>
<html>
<head>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<title>
add bookmark
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
<a href="myspace.php">Myspace</a>
</font>
</div>
</td>
</tr>

<tr>
<td width="100%">
<br><br><br><br>
<table width="100%">
<tr>
<td width="50%">
<center><img src="images/bm3.png" width="150" height="150"></center>
</td>

<td width="50%">
<form id="1" action="add_bookmark.php" method="post">
<div align="left">
<font color="#FFA500"><b>Bookmark page as&nbsp;:&nbsp;<input type="text" name="bookmark_info"></b></font>
<br><br>
</div>
<center><input type="submit" name="submit" value="add bookmark"></center>
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