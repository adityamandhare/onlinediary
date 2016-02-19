<?php
session_start();   
error_reporting(E_PARSE);
if($_SESSION['logged_in']==1)
{
$con=mysql_connect("localhost","root","");
    if(! $con)
    die("couldn't connect to database");
    mysql_select_db("diary",$con) or die ("cannot select db");

 if($_GET['follow_diary']==1)
 {
 	
 	header('Location:follow_diary_from_diary_search.php?follow_id='.$_GET[follow_id].'');
 	
 }   
    
?>

<html>
<head>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<title>
Diary Search Results
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
<a href="myspace.php">Myspace</a>&nbsp;|&nbsp;<a href="myspace.php?opt=7">Alter Search</a>&nbsp;|&nbsp;<a href="logout.php">Logout</a>
</font>
</div>
</td>
</tr>
<?php 

//$r2=mysql_fetch_array($r1);
?>
<tr>
<td width="100%">
<br><br>
<h1><font color="#008000">Search Results for Diary</font></h1>
<br>
<table width="100%" border="0">

<?php 
/*
if($_SESSION['search_user_id123']=="" && $_SESSION['search_diary_name123']=="")
header('Location:account_setting.php');
*/
if($_SESSION['search_user_id123']=="")
{
$r="select d_id, d_name, cover_path from user inner join covers where user.d_name='".$_SESSION['search_diary_name123']."' and user.d_cover=covers.cover_id";
$r1=mysql_query($r);

while($r2=mysql_fetch_array($r1))
{
///////////////
if($r2['d_id']!=$_SESSION['logged_in_user_did'])
{
$p="select username from user where user.d_id='".$r2['d_id']."'";
$p1=mysql_query($p);
$p2=mysql_fetch_array($p1);

$q="select follow_date from followed where followed.followed_username='".$p2['username']."' and followed.username='".$_SESSION[uid]."'";
$q1=mysql_query($q);
$q2=mysql_num_rows($q1);


if($q2==0)
{
echo("<tr><td width=\"30%\"><br><center><img src=\"".$r2['cover_path']."\" width=\"100\" height=\"100\"><br><font color=\"#FFA500\">".$r2['d_name']."</font></center><br></td>");
echo("<td width=\"70%\"><center><a href=\"diary_search_result.php?follow_id=".$r2['d_id']."&follow_diary=1\"><font color=\"#FFA500\"><b><i>Follow This Diary</i></b></font></a></center></td></tr>");
}
else 
{
echo("<tr><td width=\"30%\"><br><center><img src=\"".$r2['cover_path']."\" width=\"100\" height=\"100\"><br><font color=\"#FFA500\">".$r2['d_name']."</font></center><br></td>");
echo("<td width=\"70%\"><center><font color=\"#008000\"><b><i>You already follow this Diary</i></b></font></center></td></tr>");	
}
}
else 
{
	echo("<tr><td width=\"30%\"><br><center><img src=\"".$r2['cover_path']."\" width=\"100\" height=\"100\"><br><font color=\"#FFA500\">".$r2['d_name']."</font></center><br></td>");
echo("<td width=\"70%\"><center><font color=\"#008000\"><b><i>Your Diary</i></b></font></center></td></tr>");	
}
///////////

}
}
else 
{
$r="select d_id, d_name, cover_path from user inner join covers where (user.username='".$_SESSION['search_user_id123']."' or user.d_name='".$_SESSION['search_diary_name123']."')
and user.d_cover=covers.cover_id";
$r1=mysql_query($r);

while($r2=mysql_fetch_array($r1))
{
	
/////////
if($r2['d_id']!=$_SESSION['logged_in_user_did'])
{	
$p="select username from user where user.d_id='".$r2['d_id']."'";
$p1=mysql_query($p);
$p2=mysql_fetch_array($p1);

$q="select follow_date from followed where followed.followed_username='".$p2['username']."' and followed.username='".$_SESSION[uid]."'";
$q1=mysql_query($q);
$q2=mysql_num_rows($q1);

if($q2==0)
{
echo("<tr><td width=\"30%\"><br><center><img src=\"".$r2['cover_path']."\" width=\"100\" height=\"100\"><br><font color=\"#FFA500\">".$r2['d_name']."</font></center><br></td>");
echo("<td width=\"70%\"><center><a href=\"diary_search_result.php?follow_id=".$r2['d_id']."&follow_diary=1\"><font color=\"#FFA500\"><b><i>Follow This Diary</i></b></font></a></center></td></tr>");
}
else 
{
echo("<tr><td width=\"30%\"><br><center><img src=\"".$r2['cover_path']."\" width=\"100\" height=\"100\"><br><font color=\"#FFA500\">".$r2['d_name']."</font></center><br></td>");
echo("<td width=\"70%\"><center><font color=\"#008000\"><b><i>You already follow this Diary</i></b></font></center></td></tr>");	
}

}
else 
{
echo("<tr><td width=\"30%\"><br><center><img src=\"".$r2['cover_path']."\" width=\"100\" height=\"100\"><br><font color=\"#FFA500\">".$r2['d_name']."</font></center><br></td>");
echo("<td width=\"70%\"><center><font color=\"#008000\"><b><i>Your Diary</i></b></font></center></td></tr>");		
}
//////////////
}
}

?>

</table>
</td>
</tr>



</table>
</center>
</body>
</html>

   
<?php    
}//end of if to ensure access control
else header('Location:index.php');
?>