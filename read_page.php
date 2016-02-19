<?php
session_start();   
error_reporting(E_PARSE);
if($_SESSION['logged_in']==1)
{
if($_GET['page_num']>0)
{
$con=mysql_connect("localhost","root","");
    if(! $con)
    die("couldn't connect to database");
    mysql_select_db("diary",$con) or die ("cannot select db");

    
   /*$s="select pub from pages where pages.username='".$_SESSION['uid']."' and pages.page_num='".$_GET['page_num']."'";
   $s1=mysql_query($s);
   $s2=mysql_fetch_array($s1);
   
   $public_info=$s2['pub'];
    */
  /*  
  if($_GET['share']==1)
  {
  	$up="update pages set pub=1 where page_num='".$_GET[page_num]."' and username='".$_SESSION[uid]."'";
  mysql_query($up);
  }
  */
  
if(isset($_POST['select_category']))
{
  $category=stripslashes(trim($_POST['category']));
  $up="update pages set pub=1, seen=1, category='".$category."' where page_num='".$_GET[page_num]."' and username='".$_SESSION[uid]."'";
  mysql_query($up);


$sel1="select page_id from pages where page_num='".$_GET[page_num]."' and username='".$_SESSION[uid]."'";
$sel3=mysql_query($sel1) or die(mysql_error());
$sel2=mysql_fetch_array($sel3);


$sel5="select username from notification where from_username='".$_SESSION[uid]."' and page_id='".$sel2[page_id]."'";
$sel6=mysql_query($sel5) or die(mysql_error());
$sel7=mysql_num_rows($sel6);


if($sel7==0)
{
$rt="select username from followed where followed_username='".$_SESSION[uid]."'";
$rt1=mysql_query($rt);
while($rt2=mysql_fetch_array($rt1))
{
$ins1="insert into notification(username,from_username,page_id,notify_date)values('$rt2[username]','$_SESSION[uid]','$sel2[page_id]',CURDATE())";
mysql_query($ins1)or die(mysql_error());
}
}  
  
  header('Location:read_page.php?page_num='.$_GET['page_num'].'');
}
    
if($_GET['remove_share']==1)
{
  	$up="update pages set pub=0 where page_num='".$_GET[page_num]."' and username='".$_SESSION[uid]."'";
  mysql_query($up);
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
<a href="myspace.php">Myspace</a>&nbsp;|&nbsp;<a href="internal_search.php">View Other Pages</a>&nbsp;|&nbsp;<a href="myspace.php?opt=6">Alter Search</a>&nbsp;|&nbsp;<a href="logout.php">Logout</a>
</font>
</div>
</td>
</tr>

<tr>
<td width="100%">
<br><br>
<table width="100%" border="0">
<tr>
<td width="100%">
<table width="100%" border="0">
<tr>
<?php 

$r="select photo_id, photo_link,photo_info from photos where page_num='".$_GET['page_num']."' and username='".$_SESSION[uid]."'";
$r1=mysql_query($r);

$r2=mysql_fetch_array($r1);
$photo_id1=$r2['photo_id'];
$photo_link1=$r2['photo_link'];
$photo_info1=$r2['photo_info'];

$r2=mysql_fetch_array($r1);
$photo_id2=$r2['photo_id'];
$photo_link2=$r2['photo_link'];
$photo_info2=$r2['photo_info'];


$r5="select content, likes, page_date, pub from pages where page_num='".$_GET['page_num']."' and username='".$_SESSION[uid]."'";
$r6=mysql_query($r5);
$r7=mysql_fetch_array($r6);

$pn=$_GET['page_num'];
$npn=$_GET['page_num']+1;
$ppn=$_GET['page_num']-1;

echo("<td width=\"50%\"><div align=\"left\"><font color=\"#808080\"><b>Page Number&nbsp;:&nbsp;".$_GET['page_num']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Page Date&nbsp;:&nbsp;".$r7['page_date']."");

if($r7['pub']==1)
echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Likes&nbsp;:&nbsp;".$r7['likes']."");

echo("</b></font></div></td>");

echo("<td width=\"50%\">");

/////////////////////////////////// change is made from here
if($npn<=$_SESSION['logged_in_user_num_pages'])
{
////////////////////////////////////

if(($pn-1)>0)
{
echo("<div align=\"right\"><b><a href=\"read_page.php?page_num=".$ppn."\"><font color=\"#808080\"><<<--previous page</font></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
echo("<a href=\"edit_diary_page.php?photo_id1=".$photo_id1."&photo_id2=".$photo_id2."&page_num=".$_GET['page_num']."&page_date=".$r7['page_date']."&content=".$r7['content']."\">
<img src=\"images/edit_pencil.jpg\" width=\"25\" height=\"25\" title=\"edit\"></a>");


//if($_GET['pub']==0 && $_GET['share']!=1)
if($r7['pub']==0)
echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"read_page.php?share=1&page_num=".$pn."\"><img src=\"images/share1.png\" width=\"25\" height=\"25\" title=\"share this page\"></a>");
else 
echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"read_page.php?remove_share=1&page_num=".$pn."\"><img src=\"images/private1.gif\" width=\"25\" height=\"25\" title=\"make this page private\"></a>");

echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"read_page.php?page_num=".$npn."\"><font color=\"#808080\">next page-->>></font></a></b></td></div>");
}
else 
{
echo("<div align=\"right\"><a href=\"edit_diary_page.php?page_num=".$_GET['page_num']."&page_date=".$r7['page_date']."&content=".$r7['content']."\">
<img src=\"images/edit_pencil.jpg\" width=\"25\" height=\"25\" title=\"edit\"></a>");
//if($_GET['pub']==0 && $_GET['share']!=1)
if($r7['pub']==0)
echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"read_page.php?share=1&page_num=".$pn."\"><img src=\"images/share1.png\" width=\"25\" height=\"25\" title=\"share this page\"></a>");
else 
echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"read_page.php?remove_share=1&page_num=".$pn."\"><img src=\"images/private1.gif\" width=\"25\" height=\"25\" title=\"make this page private\"></a>");

echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><a href=\"read_page.php?page_num=".$npn."\"><font color=\"#808080\">next page-->>></font></a></b></td></div>");	
}	

//////////////////////////////////////////////////////////////////////
}
else 
{
if(($pn-1)>0)
{
echo("<div align=\"right\"><b><a href=\"read_page.php?page_num=".$ppn."\"><font color=\"#808080\"><<<--previous page</font></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
echo("<a href=\"edit_diary_page.php?photo_id1=".$photo_id1."&photo_id2=".$photo_id2."&page_num=".$_GET['page_num']."&page_date=".$r7['page_date']."&content=".$r7['content']."\">
<img src=\"images/edit_pencil.jpg\" width=\"25\" height=\"25\" title=\"edit\"></a>");


//if($_GET['pub']==0 && $_GET['share']!=1)
if($r7['pub']==0)
echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"read_page.php?share=1&page_num=".$pn."\"><img src=\"images/share1.png\" width=\"25\" height=\"25\" title=\"share this page\"></a>");
else 
echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"read_page.php?remove_share=1&page_num=".$pn."\"><img src=\"images/private1.gif\" width=\"25\" height=\"25\" title=\"make this page private\"></a>");

//echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"read_page.php?page_num=".$npn."\"><font color=\"#808080\">next page-->>></font></a></b></td></div>");
}
else 
{
echo("<div align=\"right\"><a href=\"edit_diary_page.php?page_num=".$_GET['page_num']."&page_date=".$r7['page_date']."&content=".$r7['content']."\">
<img src=\"images/edit_pencil.jpg\" width=\"25\" height=\"25\" title=\"edit\"></a>");
//if($_GET['pub']==0 && $_GET['share']!=1)
if($r7['pub']==0)
echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"read_page.php?share=1&page_num=".$pn."\"><img src=\"images/share1.png\" width=\"25\" height=\"25\" title=\"share this page\"></a>");
else 
echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"read_page.php?remove_share=1&page_num=".$pn."\"><img src=\"images/private1.gif\" width=\"25\" height=\"25\" title=\"make this page private\"></a>");

//echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><a href=\"read_page.php?page_num=".$npn."\"><font color=\"#808080\">next page-->>></font></a></b></td></div>");	
}	
}
///////////////////////////////////////////////////////////////////// change ends here

?>


</tr>
</table>
</td>

</tr>
<!--  Here change starts -->
<?php 
if($_GET['share']==1)
{
?>	
<tr>
<td width="100%">
<table width="100%" border="0">
<tr>
<td width="100%">
<br>
<center>
<?php 
echo("<form id=\"f2\" action=\"read_page.php?page_num=".$_GET['page_num']."\" method=\"post\"> ");
?>

<font color="#008000"><b>
Select category of public page&nbsp;:&nbsp;
<select name="category" style="background-color: #FAF8CC;">
<option value="0">----select category----</option>
<option value="1">arts and literature</option>
<option value="2">culture and religion</option>
<option value="3">entertainment</option>
<option value="4">finance and marketing</option>
<option value="5">health</option>
<option value="6">humour</option>
<option value="7">lifestyle</option>
<option value="8">politics</option>
<option value="9">religion</option>
<option value="10">science and tech</option>
<option value="11">sports</option>
<option value="12">travel</option>
<option value="13">adult</option>
<option value="14">other</option>
</select>
<br><br>
<input type="submit" name="select_category" value="share my page">
</b>
</font>
</form>
</center>
</td>
</tr>
</table>
</td>
</tr>
<?php 	

}
?>
<!--  here change ends -->

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

echo("</font></td><td width=\"10%\"><br><br><br><br><br><br>
<div align=\"left\">
<a href=\"myspace.php?opt=5&edit_photo=1&edit_photo_id=".$photo_id1."\">
<img src=\"images/edit_pencil.jpg\" width=\"15\" height=\"15\" title=\"edit photo\">
</a></div></td>");
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

echo("</font></td><td width=\"10%\"><br><br><br><br><br><br>
<div align=\"left\">
<a href=\"myspace.php?opt=5&edit_photo=1&edit_photo_id=".$photo_id2."\">
<img src=\"images/edit_pencil.jpg\" width=\"15\" height=\"15\" title=\"edit photo\">
</a></div></td>");
}
?>

</tr>
</table>
</td>
</tr>


<tr>
<td width="100%">
<br><br>
<?php 
$str=$r7['content'];
?>
<font color="#6E6A6B" face="Georgia" >
<?php 
//echo wordwrap($str,300,"<br>\n");
echo("<textarea style=\"text-align:justify; resize:none;line-height:160%; border:none ; font-size:18px ; font-family:Georgia; color:#6E6A6B\" rows=\"20\" cols=\"96\" readonly=\"readonly\">$str</textarea>");

?>
</font>
</td>
</tr>



</table>
</center>
</body>
</html>
<?php 
//$_SESSION['shared_page_number123']=$_GET['page_num'];
}// to ensure page number>0
else 
header('Location:myspace.php');
}// ensure access control
else 
header('Location:index.php');
?>