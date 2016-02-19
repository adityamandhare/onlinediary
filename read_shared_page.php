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
    
 if($_GET['bookmark_page']==1)
 {

    $_SESSION['bookmarked_page_id']=$_GET['page_id'];
    $_SESSION['bookmarked_d_id']=$_GET['d_id'];
 	
 $r="select * from bookmark where username='".$_SESSION[uid]."' and bookmark_pid='".$_GET[page_id]."'";
 $r1=mysql_query($r);
 $r2=mysql_fetch_array($r1);

 if($r2==0)
 {
 	//echo("Hello");
   header('Location:add_bookmark.php?page_id='.$_GET[page_id].'&d_id='.$_GET[d_id].'');
 }
 
}

/////////////////////////////////////

 if($_GET['delete_bookmark_page']==1)
 {

    $_SESSION['bookmarked_page_id']=$_GET['page_id'];
    $_SESSION['bookmarked_d_id']=$_GET['d_id'];
 	
 $r="delete from bookmark where username='".$_SESSION[uid]."' and bookmark_pid='".$_GET[page_id]."'";
 mysql_query($r);

 	//echo("Hello");
   //header('Location:add_bookmark.php?page_id='.$_GET[page_id].'&d_id='.$_GET[d_id].'');
 
}

////////////////////////////////////


if($_GET['like_page']==1)
{
	$sel1="select like_pages from likes where username='".$_SESSION[uid]."'";
	$sel2=mysql_query($sel1);
    $sel3=mysql_fetch_array($sel2);
    
	$old=$sel3['like_pages'];
	//echo("The string is ".$old);
	$newstr=$old."".$_GET['page_id'].",";
	
	$up_like="update likes set like_pages='".$newstr."' where username='".$_SESSION[uid]."' ";
	//$up_like="update likes set like_pages='"."hello"."' where username='".$_SESSION[uid]."'";
	mysql_query($up_like) or die(mysql_error());
     
	$up_like_count="update pages set likes=likes+1 where page_id='".$_GET[page_id]."'";
    mysql_query($up_like_count);

}

if($_GET['dislike_page']==1)
{
	
	$sel1="select like_pages from likes where username='".$_SESSION[uid]."'";
	$sel2=mysql_fetch_array(mysql_query($sel1));
	
	$del=$_GET['page_id'].",";
	$new_str=str_replace($del,"",$sel2['like_pages']);
	
	$up_like="update likes set like_pages='".$new_str."' where username='".$_SESSION[uid]."' ";
	mysql_query($up_like);
     
	$up_like_count="update pages set likes=likes-1 where page_id='".$_GET[page_id]."'";
    mysql_query($up_like_count);

}
    
?>
<html>
<head>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<title>
Read Shared Page
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
<?php 
if($_SESSION['come_from_notify']==1)
{
$_SESSION['come_from_notify']=0;
echo("<a href=\"myspace.php\">Myspace</a>&nbsp;|&nbsp;<a href=\"myspace.php?opt=9\">View Other Notifications</a>&nbsp;|&nbsp;<a href=\"logout.php\">Logout</a>");
}
else 
{
if($_GET['readbookmark']==1)
echo("<a href=\"myspace.php\">Myspace</a>&nbsp;|&nbsp;<a href=\"myspace.php?opt=10&sub=2\">View other bookmarks</a>&nbsp;|&nbsp;<a href=\"logout.php\">Logout</a>");
else 
echo("<a href=\"myspace.php\">Myspace</a>&nbsp;|&nbsp;<a href=\"shared_page_search_result.php\">View Other Pages</a>&nbsp;|&nbsp;<a href=\"myspace.php?opt=7\">Alter Search</a>&nbsp;|&nbsp;<a href=\"logout.php\">Logout</a>");
}
?>
</font>
</div>
</td>
</tr>

<tr>
<td width="100%">
<br><br>
<table width="100%" border="0">
<tr>

<?php 

$r5="select content, likes, page_date from pages where page_id='".$_GET['page_id']."' and d_id='".$_GET['d_id']."' and pub=1";
$r6=mysql_query($r5);
$r7=mysql_fetch_array($r6);

/////////////////
if(mysql_num_rows($r6)!=0)
{
//////////////
$r="select photo_id, photo_link,photo_info from photos where page_id='".$_GET['page_id']."' and d_id='".$_GET['d_id']."'";
$r1=mysql_query($r);

$r2=mysql_fetch_array($r1);
$photo_id1=$r2['photo_id'];
$photo_link1=$r2['photo_link'];
$photo_info1=$r2['photo_info'];

$r2=mysql_fetch_array($r1);
$photo_id2=$r2['photo_id'];
$photo_link2=$r2['photo_link'];
$photo_info2=$r2['photo_info'];





echo("<td width=\"50%\"><font color=\"#808080\"><div align=\"left\"><b>
&nbsp;&nbsp;Page Date&nbsp;:&nbsp;".$r7['page_date']."
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Likes&nbsp;:&nbsp;".$r7['likes']."</b></font>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");


//if($_GET['readbookmark']!=1)
//{
	
$sel8="select * from bookmark where username='".$_SESSION[uid]."' and bookmark_pid='".$_GET[page_id]."'";
$sel9=mysql_query($sel8);

if(mysql_num_rows($sel9)==0)
echo("<a href=\"read_shared_page.php?bookmark_page=1&page_id=".$_GET['page_id']."&d_id=".$_GET['d_id']."\"><img src=\"images/bm6.png\" width=\"20\" height=\"20\" title=\"bookmark this page\"></a>");
else 
echo("<a href=\"read_shared_page.php?delete_bookmark_page=1&page_id=".$_GET['page_id']."&d_id=".$_GET['d_id']."\"><img src=\"images/bm7.png\" width=\"20\" height=\"20\" title=\"delete bookmark\"></a>");

//}
///////////////////////

$check_liked="select like_pages from likes where username='".$_SESSION[uid]."'";
$check_liked1=mysql_query($check_liked);
$check_liked2=mysql_fetch_array($check_liked1);

$check_this=",".$_GET['page_id'].",";

//echo "value is ".$check_liked2['like_pages'];

$hold=stripos($check_liked2['like_pages'],$check_this,0);
//echo(stripos($check_liked2['like_pages'],$check_this,0));

if($hold!==false)
{
echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href=\"read_shared_page.php?dislike_page=1&page_id=".$_GET['page_id']."&d_id=".$_GET['d_id']."\" title=\"unlike this page\"><font color=\"#808080\">unlike</font></a>");
}
else
{
echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href=\"read_shared_page.php?like_page=1&page_id=".$_GET['page_id']."&d_id=".$_GET['d_id']."\" title=\"like this page\"><font color=\"#808080\">like</font></a>");
}


//////////////////////
echo("
</div></td>");

?>
</tr>
</table>


</td>
</tr>

<tr>
<td width="100%">
<br><br>
<table width="100%" border="0">
<tr>

<?php 

//$r="select photo_id, photo_link,photo_info from photos where page_num='".$_GET['page_num']."' and username='".$_SESSION[uid]."'";
//$r1=mysql_query($r);


//$r2=mysql_fetch_array($r1);

echo("<td width=\"20%\">");
if($photo_link1!="")
{
echo("<img src=\"".$photo_link1."\" width=\"150\" height=\"150\">");
echo("</td><td width=\"20%\"><font color=\"#008000\">");
$str=$photo_info1;
echo wordwrap($str,30,"<br>\n");

echo("</font></td>");
}
//echo wordwrap($str,15,"<br>\n");

//$r2=mysql_fetch_array($r1);
echo("<td width=\"20%\">");
if($photo_link2!="")
{
echo("<img src=\"".$photo_link2."\" width=\"150\" height=\"150\">");
echo("</td><td width=\"20%\"><font color=\"#008000\">");
$str=$photo_info2;
echo wordwrap($str,30,"<br>\n");

echo("</font></td>");
}



?>

</tr>
</table>
</td>
</tr>


<?php 

}// end of changed if
else 
{

echo("This page has been made private by the author.");

}

?>

<tr>
<td width="100%">
<br><br>
<?php 
$str=$r7['content'];
?>
<font color="#6E6A6B" face="Georgia" >
<?php 
//echo wordwrap($str,300,"<br>\n");
echo("<textarea style=\"align-text:justify; resize:none;line-height:160%; border:none ; font-size:18px ; font-family:Georgia; color:#6E6A6B\" rows=\"20\" cols=\"96\" readonly=\"readonly\">$str</textarea>");
?>
</font>
</td>
</tr>



</table>
</center>
</body>
</html>
<?php 
//}// to ensure page number>0
//else 
//header('Location:myspace.php');
}// ensure access control
else 
header('Location:index.php');
?>