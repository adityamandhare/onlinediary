<?php
session_start();   
error_reporting(E_PARSE);
if($_SESSION['logged_in']==1)
{

$con=mysql_connect("localhost","root","");
    if(! $con)
    die("couldn't connect to database");
    mysql_select_db("diary",$con) or die ("cannot select db");

    if($_GET['index_num']>0)
    {
  
?>
<html>
<head>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<title>
Read Followed Diary
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
<a href="myspace.php">Myspace</a>&nbsp;|&nbsp;<a href="myspace.php?opt=10">Read Other Diaries</a>&nbsp;|&nbsp;<a href="logout.php">Logout</a>
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



if($_SESSION['obtained']==0)
{
$r5="select page_num from pages where username='".$_SESSION['rfd']."' and pub=1";
//$r5="select page_id from pages where username='aditya@gmail.com' and pub=1";
$r6=mysql_query($r5);

$_SESSION['pg']=array();

$inc=1;
while($r7=mysql_fetch_array($r6))
{
$_SESSION['pg'][$inc]=$r7['page_num'];
++$inc;	
}	
$_SESSION[obtained]=1;
}

$pn=$_GET['index_num'];
$ppn=$_GET['index_num']-1;
$npn=$_GET['index_num']+1;


//////////////////////////////////////////////// photo part begins /////////////////////////

$r10="select page_date, content from pages where username='".$_SESSION['rfd']."' and page_num='".$_SESSION['pg'][$pn]."'";
$r11=mysql_query($r10);
$r12=mysql_fetch_array($r11);


$r="select photo_id, photo_link,photo_info from photos where page_num='".$_SESSION['pg'][$_GET['index_num']]."' and username='".$_SESSION['rfd']."'";
$r1=mysql_query($r);

$r2=mysql_fetch_array($r1);
$photo_id1=$r2['photo_id'];
$photo_link1=$r2['photo_link'];
$photo_info1=$r2['photo_info'];

$r2=mysql_fetch_array($r1);
$photo_id2=$r2['photo_id'];
$photo_link2=$r2['photo_link'];
$photo_info2=$r2['photo_info'];

////////////////////////////////////////////////photo part ends//////////////////////////


//header('Location:test1.php');
echo("<td width=\"50%\"><div align=\"left\"><font color=\"#808080\"><b>Page Date&nbsp;:&nbsp;".$r12['page_date']."</b></font></div></td>");
echo("<td width=\"50%\">");

if($_SESSION['pg'][$pn]==0)
header('Location:myspace.php?opt=10');

if(($pn-1)>0)
{
if($_SESSION['pg'][$pn+1]>0)
{
echo("<div align=\"right\"><b><a href=\"read_followed_diary.php?index_num=".$ppn."\"><font color=\"#808080\"><<<--previous shared page</font></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
echo("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"read_followed_diary.php?index_num=".$npn."\"><font color=\"#808080\">next shared page-->>></font></a></b></td></div>");
}
else 
{
echo("<div align=\"right\"><b><a href=\"read_followed_diary.php?index_num=".$ppn."\"><font color=\"#808080\"><<<--previous shared page</font></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
echo("</b></td></div>");
}
}
else
if($_SESSION['pg'][$pn+1]>0) 
{
echo("<div align=\"right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><a href=\"read_followed_diary.php?index_num=".$npn."\"><font color=\"#808080\">next shared page-->>></font></a></b></div></td>");	
}	
?>


</tr>
</table>
</td>

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

echo("<td width=\"25%\">");
if($photo_link1!="")
{
echo("<img src=\"".$photo_link1."\" width=\"150\" height=\"150\">");
echo("</td><td width=\"25%\"><font color=\"#008000\">");
$str=$photo_info1;
echo wordwrap($str,30,"<br>\n");
}


echo("<td width=\"25%\">");
if($photo_link2!="")
{
echo("<img src=\"".$photo_link2."\" width=\"150\" height=\"150\">");
echo("</td><td width=\"25%\"><font color=\"#008000\">");
$str=$photo_info2;
echo wordwrap($str,30,"<br>\n");
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
$str=$r12['content'];
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
    }
    else {header('Location:myspace.php?opt=10');}

}// ensure access control
else 
header('Location:index.php');
?>