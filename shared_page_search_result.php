<?php
session_start();   
error_reporting(E_PARSE);
if($_SESSION['logged_in']==1)
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
Shared Pages Search Results
</title>
<link rel="stylesheet" href="pattern4.css">
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
<tr>
<td width="100%">
<br><br>
<h1><font color="#008000">Search Results for Diary</font></h1>
<br>
</td>
</tr>

<tr>
<td width="100%">
<?php 

if($_SESSION['search_diary_name123']=="" && $_SESSION['select_category']==0)
header('Location:myspace.php?opt=7');

if($_SESSION['search_diary_name123']=="")
{

$r="select d_id, page_id, page_date, username, num_of_people_following, content, likes from pages where category='".$_SESSION['select_category']."' and pub=1 order by num_of_people_following DESC";
$r1=mysql_query($r) or die(mysql_error());


while($r2=mysql_fetch_array($r1))
{
	$p="select follow_date from followed where followed.followed_username='".$r2['username']."' and followed.username='".$_SESSION[uid]."'";
	$p1=mysql_query($p);
	$p2=mysql_num_rows($p1);

////////////////////	
if($r2['d_id']!=$_SESSION['logged_in_user_did'])
{	

if($p2==0)
{	
echo("<a href=\"follow_diary_from_page_search.php?d_id=".$r2['d_id']."&page_id=".$r2['page_id']."&page_date=".$r2['page_date']."&num_follow=".$r2['num_of_people_following']."\"><font color=\"#FFA500\">*&nbsp;&nbsp;");
echo("&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;");
echo($r2['page_date']);
echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of followers:&nbsp;&nbsp;&nbsp;&nbsp;");
echo($r2['num_of_people_following']);
echo("&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;");
echo("Likes : ".$r2['likes']);

echo("<br>".substr($r2['content'],0,100)."");
echo("......<br></font><font color=\"#008000\"><i>You can follow this Diary to read this page.Click to follow.</i></font><br><br><br></a>");
}
else 
{
echo("<a href=\"read_shared_page.php?d_id=".$r2['d_id']."&page_id=".$r2['page_id']."&page_date=".$r2['page_date']."&num_follow=".$r2['num_of_people_following']."&
content=".$r2['content']."\"><font color=\"#008000\">*&nbsp;&nbsp;");
echo("&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;");
echo($r2['page_date']);
echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of followers:&nbsp;&nbsp;&nbsp;&nbsp;");
echo($r2['num_of_people_following']);
echo("&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;");
echo("Likes : ".$r2['likes']);

echo("<br>".substr($r2['content'],0,100)."");
echo("......<br><br></font></a>");
}
	
}// end of new condition
////////////////////

}
}
else 
if($_SESSION['select_category']==0)
{
$r="select pages.d_id, page_id, page_date, num_of_people_following, content, likes, d_name, user.username from 
pages inner join user where user.d_name='".$_SESSION['search_diary_name123']."' and  pages.d_id=user.d_id  and pub=1 order by pages.page_num";
$r1=mysql_query($r) or die(mysql_error());

while($r2=mysql_fetch_array($r1))
{
	$p="select follow_date from followed where followed.followed_username='".$r2['username']."' and followed.username='".$_SESSION[uid]."'";
	$p1=mysql_query($p);
	$p2=mysql_num_rows($p1);

	//echo("Number of rows= ".$p2);
////////////////////////
if($r2['d_id']!=$_SESSION['logged_in_user_did'])
{	
	
if($p2==0)
{	
echo("<a href=\"follow_diary_from_page_search.php?d_id=".$r2['d_id']."&page_id=".$r2['page_id']."&page_date=".$r2['page_date']."&num_follow=".$r2['num_of_people_following']."\"><font color=\"#FFA500\">*&nbsp;&nbsp;");
echo("&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;");
echo($r2['page_date']);
echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of followers:&nbsp;&nbsp;&nbsp;&nbsp;");
echo($r2['num_of_people_following']);
echo("&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;");
echo("Likes : ".$r2['likes']);

echo("<br>".substr($r2['content'],0,100)."");
echo("......<br></font><font color=\"#008000\"><i>You can follow this Diary to read this page.Click to follow.</i></font><br><br><br></a>");
}
else 
{
echo("<a href=\"read_shared_page.php?d_id=".$r2['d_id']."&page_id=".$r2['page_id']."&page_date=".$r2['page_date']."&num_follow=".$r2['num_of_people_following']."&
content=".$r2['content']."\"><font color=\"#008000\">*&nbsp;&nbsp;");
echo("&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;");
echo($r2['page_date']);
echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of followers:&nbsp;&nbsp;&nbsp;&nbsp;");
echo($r2['num_of_people_following']);
echo("&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;");
echo("Likes : ".$r2['likes']);

echo("<br>".substr($r2['content'],0,100)."");
echo("......<br><br></font></a>");
}	
}	
///////////////////////
}
}
else 
{

$r="select pages.d_id, page_id, page_date, num_of_people_following, content, likes, d_name, user.username from 
pages inner join user where user.d_name='".$_SESSION['search_diary_name123']."' and pages.category='".$_SESSION['select_category']."' and
pages.d_id=user.d_id  and pub=1 order by pages.num_of_people_following DESC";

$r1=mysql_query($r) or die(mysql_error());

while($r2=mysql_fetch_array($r1))
{
	$p="select follow_date from followed where followed.followed_username='".$r2['username']."' and followed.username='".$_SESSION[uid]."'";
	$p1=mysql_query($p);
	$p2=mysql_num_rows($p1);

///////////////////
if($r2['d_id']!=$_SESSION['logged_in_user_did'])
{	
	
if($p2==0)
{	
echo("<a href=\"follow_diary_from_page_search.php?d_id=".$r2['d_id']."&page_id=".$r2['page_id']."&page_date=".$r2['page_date']."&num_follow=".$r2['num_of_people_following']."\"><font color=\"#FFA500\">*&nbsp;&nbsp;");
echo("&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;");
echo($r2['page_date']);
echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of followers:&nbsp;&nbsp;&nbsp;&nbsp;");
echo($r2['num_of_people_following']);
echo("&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;");
echo("Likes : ".$r2['likes']);

echo("<br>".substr($r2['content'],0,100)."");
echo("......<br></font><font color=\"#008000\"><i>You can follow this Diary to read this page.Click to follow and search again.</i></font><br><br><br></a>");
}
else 
{
echo("<a href=\"read_shared_page.php?d_id=".$r2['d_id']."&page_id=".$r2['page_id']."&page_date=".$r2['page_date']."&num_follow=".$r2['num_of_people_following']."&
content=".$r2['content']."\"><font color=\"#008000\">*&nbsp;&nbsp;");
echo("&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;");
echo($r2['page_date']);
echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Number of followers:&nbsp;&nbsp;&nbsp;&nbsp;");
echo($r2['num_of_people_following']);
echo("&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;");
echo("Likes : ".$r2['likes']);

echo("<br>".substr($r2['content'],0,100)."");
echo("......<br><br></font></a>");
}	
}
//////////////////////////

}
}

?>

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