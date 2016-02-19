<?php
session_start();   
error_reporting(E_PARSE);
if($_SESSION['logged_in']==1)
{
$con=mysql_connect("localhost","root","");
    if(! $con)
    die("couldn't connect to database");
    mysql_select_db("diary",$con) or die ("cannot select db");

    
/*  echo("KEYWORDS = ".$_SESSION['search_key_word']);
	echo("PHOTO KEYWORDS = ".$_SESSION['photo_key_word']);
	echo("SEARCH EVENT DATE = ".$_SESSION['search_event_date']);
	echo("SEARCH PAGE NUMBER = ".$_SESSION['search_page_num']); */

    $search_key_word=",".$_SESSION['search_key_word'].",";
    $key=array();
    
    $photo_key_word=",".$_SESSION['photo_key_word'].",";
    $pkey=array();
       
    $length=strlen($search_key_word);
    $length1=strlen($photo_key_word);
     
    $temp1=0;
    $temp2;
    $temp_length=0;
    $inc=0;
    for($i=1;$i<$length;++$i)
    {
    	if(substr($search_key_word,$i,1)==",")
    	{
    		
    		$temp2=$i;
    	    $temp_length=$temp2-$temp1-1;
    		$temp3=$temp1+1;
    	    $key[$inc++]=substr($search_key_word,$temp3,$temp_length);
    	    $temp1=$temp2;
    	    
    	}
    	
    }
    


    $temp1=0;
    $temp2;
    $temp_length=0;
    $inc1=0;
    for($i=1;$i<$length1;++$i)
    {
    	if(substr($photo_key_word,$i,1)==",")
    	{
    		
    		$temp2=$i;
    	    $temp_length=$temp2-$temp1-1;
    		$temp3=$temp1+1;
    	    $pkey[$inc1++]=substr($photo_key_word,$temp3,$temp_length);
    	    $temp1=$temp2;
    	    
    	}
    	
    }
    
    //for($i=0;$i<$inc;++$i)
    //{
    	//echo($pkey[$i]." ");
    //}
    
    
    
    
    
    
    
 ?>

<html>
<head>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<title>
Internal Search Results
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
<a href="myspace.php">Myspace</a>&nbsp;|&nbsp;<a href="myspace.php?opt=6">Alter Search</a>&nbsp;|&nbsp;<a href="logout.php">Logout</a>
</font>
</div>
</td>
</tr>
<tr>
<td width="100%">

<table width="100%"> <!-- start of inner table -->
<tr>
<td width="100%">
<br>
<font color="#FFA500"><h2>Search Results</h2></font>
<?php 
//echo("Hello");
$display=array();
$incr=0;
if($_SESSION[search_page_num]!="")
{
$r="select page_id, page_date, page_num, content, pub from pages where username='".$_SESSION[uid]."' and page_num='".$_SESSION[search_page_num]."'";
$r1=mysql_query($r) or die(mysql_error());

$row=mysql_num_rows($r1);
$r2=mysql_fetch_array($r1);

echo("<a href=\"read_page.php?page_id=".$r2['page_id']."&page_date=".$r2['page_date']."&page_num=".$r2['page_num']."&pub=".$r2['pub']."\"><font color=\"#008000\">*&nbsp;&nbsp;Page number:&nbsp;&nbsp;");
echo($r2['page_num']);
echo("&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;");
echo($r2['page_date']);
echo("<br>".substr($r2['content'],0,100)."");
echo("......<br><br></font></a>");

$display[$incr++]=$r2['page_id'];
}

if($_SESSION[search_event_date]!="")
{
$r="select page_id, page_date, page_num, content from pages where username='".$_SESSION[uid]."' and page_date='".$_SESSION[search_event_date]."'";
$r1=mysql_query($r) or die(mysql_error());
//$r2=mysql_fetch_array($r1);

while($r2=mysql_fetch_array($r1))
{
$flag2=0;
for($i=0;$i<$incr;++$i)
{

	if($display[$i]==$r2['page_id'])
	{
		$flag2=1;
		break;
	}
	
}

if($flag2==0)
{

echo("<a href=\"read_page.php?page_id=".$r2['page_id']."&page_date=".$r2['page_date']."&page_num=".$r2['page_num']."&pub=".$r2['pub']."\"><font color=\"#008000\">*&nbsp;&nbsp;Page number:&nbsp;&nbsp;");
echo($r2['page_num']);
echo("&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;");
echo($r2['page_date']);
echo("<br>".substr($r2['content'],0,100)."");
echo("......<br><br></font></a>");

$display[$incr++]=$r2['page_id'];
}

}// end of while

}// end of if





if($_SESSION['search_key_word']!="")
{

$r="select page_id, page_date, page_num, content from pages where username='".$_SESSION[uid]."'";
$r1=mysql_query($r) or die(mysql_error());

while($r2=mysql_fetch_array($r1))
{	
for($i=0;$i<$inc;++$i)
{
$hold=stripos($r2['content'],$key[$i],0);
if($hold !== false)
{
	$flag2=0;
for($j=0;$j<$incr;++$j)
{

	if($display[$j]==$r2['page_id'])
	{
		$flag2=1;
		break;
	}
}	
if($flag2==0)
{
$display[$incr++]=$r2['page_id'];	
echo("<a href=\"read_page.php?page_id=".$r2['page_id']."&page_date=".$r2['page_date']."&page_num=".$r2['page_num']."&pub=".$r2['pub']."\"><font color=\"#008000\">*&nbsp;&nbsp;Page number:&nbsp;&nbsp;");
echo($r2['page_num']);
echo("&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;");
echo($r2['page_date']);
echo("<br>".substr($r2['content'],0,100)."");
echo("......<br><br></font></a>");
}

}

}//end for loop
}//end while loop

}// end of if


/////////////// work for photo info starts


if($_SESSION['photo_key_word']!="")
{

$r="select photo_id, photos.page_id, photos.page_num, photo_date, photo_info, pub from photos inner join pages where photos.page_id=pages.page_id and photos.username='".$_SESSION[uid]."'";
$r1=mysql_query($r) or die(mysql_error());

while($r2=mysql_fetch_array($r1))
{
	
for($i=0;$i<$inc1;++$i)
{
$hold=stripos($r2['photo_info'],$pkey[$i],0);
if($hold !== false)
{
$flag2=0;
for($j=0;$j<$incr;++$j)
{

	if($display[$j]==$r2['page_id'])
	{
		$flag2=1;
		break;
	}
}	
if($flag2==0)
{
	//echo("I am in Photos");
$display[$incr++]=$r2['page_id'];	
echo("<a href=\"read_page.php?page_id=".$r2['page_id']."&page_date=".$r2['photo_date']."&page_num=".$r2['page_num']."&pub=".$r2['pub']."\"><font color=\"#008000\">*&nbsp;&nbsp;Page number:&nbsp;&nbsp;");
echo($r2['page_num']);
echo("&nbsp;&nbsp;&nbsp;&nbsp;Date:&nbsp;&nbsp;");
echo($r2['photo_date']);
echo("<br>".substr($r2['photo_info'],0,100)."");
echo("......<br><br></font></a>");

}

}

}//end for loop
}//end while loop
}// end of if


?>


</td>
</tr>
</table> <!-- This is end of inner table  -->

<!-- This is big table of page -->
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