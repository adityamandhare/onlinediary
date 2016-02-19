<?php
session_start();   
error_reporting(E_PARSE);
if($_SESSION['logged_in']==1)
{
$con=mysql_connect("localhost","root","");
    if(! $con)
    die("couldn't connect to database");
    mysql_select_db("diary",$con) or die ("cannot select db");
$opt=$_GET['opt'];

if(!isset($_POST['edit_photo']))
$_SESSION['check_ref']=$_SERVER['HTTP_REFERER'];

if(isset($_POST['search_shared_page']))
{
	
	$_SESSION['select_category']=addslashes(trim($_POST['select_category']));
	$_SESSION['search_diary_name123']=addslashes(trim($_POST['search_diary_name']));
	$_SESSION['search_user_id123']=addslashes(trim($_POST['search_user_id']));
	
	header('Location:shared_page_search_result.php');
}

if(isset($_POST['submit_private']))
{
	$image1_info=addslashes(trim($_POST['image1_info']));
	$image2_info=addslashes(trim($_POST['image2_info']));
	
	
		
$image1="";
    if($_FILES["file"]["error"]>0)
	echo"";
	else 
	{
		if(file_exists("images/user_images/".$_FILES["file"]["name"]))
		{
	

			
$new=$_FILES["file"]["name"];
$l=strlen($new);
$name=substr($new,0,$l-4);
$pos1=strlen($name);
$ext=substr($new,$pos1,4);
//echo("Name= ".$name);
//echo("Extension= ".$ext);


$inc=1;
while(file_exists("images/user_images/".$new))
{

$tname=$name."(".$inc.")";
$new=$tname."".$ext;

++$inc;
}
			
$image1=$new;
move_uploaded_file($_FILES["file"]["tmp_name"],"images/user_images/".$new);
			
			
			
	}
		else 
		{
			$image1=addslashes(trim($_FILES["file"]["name"]));
			move_uploaded_file($_FILES["file"]["tmp_name"],"images/user_images/".$_FILES["file"]["name"]);
			
		}
	}
	
	

$image2="";
    if($_FILES["file1"]["error"]>0)
	echo"";
	else 
	{
		if(file_exists("images/user_images/".$_FILES["file1"]["name"]))
		{
		
			
$new=$_FILES["file1"]["name"];
$l=strlen($new);
$name=substr($new,0,$l-4);
$pos1=strlen($name);
$ext=substr($new,$pos1,4);
//echo("Name= ".$name);
//echo("Extension= ".$ext);


$inc=1;
while(file_exists("images/user_images/".$new))
{

$tname=$name."(".$inc.")";
$new=$tname."".$ext;

++$inc;
}
			
$image2=$new;
move_uploaded_file($_FILES["file1"]["tmp_name"],"images/user_images/".$new);
			
			
			
		}
		else 
		{
			$image2=addslashes(trim($_FILES["file1"]["name"]));
			move_uploaded_file($_FILES["file1"]["tmp_name"],"images/user_images/".$_FILES["file1"]["name"]);
		
		}
	}
	
	
	$content=addslashes(trim($_POST['page_content']));
	$category=addslashes(trim($_POST['select_category']));
	if($category==0)
	$category="14";
	
	$_SESSION['logged_in_user_num_pages']=$_SESSION['logged_in_user_num_pages']+1;
	
	
	if(strcmp($content,"start writing here...")!=0 && $content!="")
	{
	$insert1="insert into pages(d_id,username,page_num,page_date,content,category,pub,num_of_people_following)values
	('$_SESSION[logged_in_user_did]','$_SESSION[uid]','$_SESSION[logged_in_user_num_pages]',CURDATE(),'$content','$category','0','$_SESSION[following_logged_in_user]')";
	mysql_query($insert1) or die(mysql_error());

	$up1="update user set num_pages='".$_SESSION['logged_in_user_num_pages']."' where username='".$_SESSION[uid]."'";
	mysql_query($up1);

	$sel="select page_id from pages where username='".$_SESSION[uid]."' and page_num='".$_SESSION[logged_in_user_num_pages]."'";
	$sel1=mysql_query($sel);
	$sel2=mysql_fetch_array($sel1);
	
	
	
	
	if($image1!="")
	{
	$image1="images/user_images/".$image1;
	$insert2="insert into photos(username,d_id,page_id,page_num,photo_link,photo_date,photo_info)
	values('$_SESSION[uid]','$_SESSION[logged_in_user_did]','$sel2[page_id]','$_SESSION[logged_in_user_num_pages]','$image1',CURDATE(),'$image1_info')";
	mysql_query($insert2)or die(mysql_error());
	}
	
	if($image2!="")
	{
	$image2="images/user_images/".$image2;
	$insert3="insert into photos(username,d_id,page_id,page_num,photo_link,photo_date,photo_info)
	values('$_SESSION[uid]','$_SESSION[logged_in_user_did]','$sel2[page_id]','$_SESSION[logged_in_user_num_pages]','$image2',CURDATE(),'$image2_info')";
	mysql_query($insert3) or die(mysql_error());
	}
	
	}

	header('Location:myspace.php?opt=2');
}
if(isset($_POST['submit_public']))
{
	$image1_info=addslashes(trim($_POST['image1_info']));
	$image2_info=addslashes(trim($_POST['image2_info']));
	
	//$image1="images/user_images/".addslashes(trim($_POST['image1']));
	//$image2="images/user_images/".addslashes(trim($_POST['image2']));
	
	
	
	$image1="";
    if($_FILES["file"]["error"]>0)
	echo"";
	else 
	{
		if(file_exists("images/user_images/".$_FILES["file"]["name"]))
		{
	
			
$new=$_FILES["file"]["name"];
$l=strlen($new);
$name=substr($new,0,$l-4);
$pos1=strlen($name);
$ext=substr($new,$pos1,4);
//echo("Name= ".$name);
//echo("Extension= ".$ext);


$inc=1;
while(file_exists("images/user_images/".$new))
{

$tname=$name."(".$inc.")";
$new=$tname."".$ext;

++$inc;
}
			
$image1=$new;
move_uploaded_file($_FILES["file"]["tmp_name"],"images/user_images/".$new);
			
			
		   
		}
		else 
		{
			$image1=addslashes(trim($_FILES["file"]["name"]));
			move_uploaded_file($_FILES["file"]["tmp_name"],"images/user_images/".$_FILES["file"]["name"]);
			
		}
	}
	
	

$image2="";
    if($_FILES["file1"]["error"]>0)
	echo"";
	else 
	{
		if(file_exists("images/user_images/".$_FILES["file1"]["name"]))
		{
		
			
			
$new=$_FILES["file1"]["name"];
$l=strlen($new);
$name=substr($new,0,$l-4);
$pos1=strlen($name);
$ext=substr($new,$pos1,4);
//echo("Name= ".$name);
//echo("Extension= ".$ext);


$inc=1;
while(file_exists("images/user_images/".$new))
{

$tname=$name."(".$inc.")";
$new=$tname."".$ext;

++$inc;
}
			
$image2=$new;
move_uploaded_file($_FILES["file1"]["tmp_name"],"images/user_images/".$new);
			
			
			
		}
		else 
		{
			$image2=addslashes(trim($_FILES["file1"]["name"]));
			move_uploaded_file($_FILES["file1"]["tmp_name"],"images/user_images/".$_FILES["file1"]["name"]);
		
		}
	}
	
	
	
	
	$content=addslashes(trim($_POST['page_content']));
	$category=addslashes(trim($_POST['select_category']));
	if($category==0)
	$category="14";
	
	$_SESSION['logged_in_user_num_pages']=$_SESSION['logged_in_user_num_pages']+1;
	
	
	if(strcmp($content,"start writing here...")!=0 && $content!="")
	{

	$insert1="insert into pages(d_id,username,page_num,page_date,content,category,pub,num_of_people_following)values
	('$_SESSION[logged_in_user_did]','$_SESSION[uid]','$_SESSION[logged_in_user_num_pages]',CURDATE(),'$content','$category','1','$_SESSION[following_logged_in_user]')";
	mysql_query($insert1) or die(mysql_error());
	
	
	$up1="update user set num_pages='".$_SESSION['logged_in_user_num_pages']."' where username='".$_SESSION[uid]."'";
	mysql_query($up1);

	$sel="select page_id from pages where username='".$_SESSION[uid]."' and page_num='".$_SESSION[logged_in_user_num_pages]."'";
	$sel1=mysql_query($sel);
	$sel2=mysql_fetch_array($sel1);
	
    if($image1!="")
	{
	$image1="images/user_images/".$image1;
	$insert2="insert into photos(username,d_id,page_id,page_num,photo_link,photo_date,photo_info)
	values('$_SESSION[uid]','$_SESSION[logged_in_user_did]','$sel2[page_id]','$_SESSION[logged_in_user_num_pages]','$image1',CURDATE(),'$image1_info')";
	mysql_query($insert2)or die(mysql_error());
	}
	
	if($image2!="")
	{
	$image2="images/user_images/".$image2;
	$insert3="insert into photos(username,d_id,page_id,page_num,photo_link,photo_date,photo_info)
	values('$_SESSION[uid]','$_SESSION[logged_in_user_did]','$sel2[page_id]','$_SESSION[logged_in_user_num_pages]','$image2',CURDATE(),'$image2_info')";
	mysql_query($insert3) or die(mysql_error());
	}
	}
	

////////////////////////////////////////////////////////////////

$rt="select username from followed where followed_username='".$_SESSION[uid]."'";
$rt1=mysql_query($rt);

while($rt2=mysql_fetch_array($rt1))
{
$ins1="insert into notification(username,from_username,page_id,notify_date)values('$rt2[username]','$_SESSION[uid]','$sel2[page_id]',CURDATE())";
mysql_query($ins1)or die(mysql_error());
}
	
/////////////////////////////////////////////////////////////////

header('Location:myspace.php?opt=2');
	
}

if(isset($_POST['search_diary1']))
{
	$_SESSION['search_diary_name123']=addslashes(trim($_POST['search_diary_name']));
	$_SESSION['search_user_id123']=addslashes(trim($_POST['search_user_id']));
	
	if($_SESSION['search_diary_name123']!="" || $_SESSION['search_user_id123']!="" )
	header('Location:diary_search_result.php');
	else 
	header('Location:myspace.php?opt=7');
}

if(isset($_POST['search_page']))
{
	$_SESSION['search_key_word']=addslashes(trim($_POST['key_word']));
	$_SESSION['photo_key_word']=addslashes(trim($_POST['photo_key_word']));
	$_SESSION['search_event_date']=addslashes(trim($_POST['search_event_date']));
	$_SESSION['search_page_num']=addslashes(trim($_POST['search_page_num']));
	
	if($_SESSION['search_key_word']=="" && $_SESSION['photo_key_word']=="" && $_SESSION['search_event_date']=="" && $_SESSION['search_page_num']=="")
	header('Location:myspace.php?opt=6');
	else 
	header('Location:internal_search.php');	

}

if(isset($_POST['new_note']))
{
	
	$note_date=addslashes(trim($_POST['note_date']));
	$note_content=addslashes(trim($_POST['note_content']));
	if($note_content!="" && $note_date!="")
	{
	$r="insert into sticky_notes(username,note_date,note_content)values('$_SESSION[uid]','$note_date','$note_content')";
	mysql_query($r);
	}
	header('Location:myspace.php?opt=3');
}
if(isset($_POST['new_schedule']))
{
	
	$schedule_event=addslashes(trim($_POST['schedule_event']));
	$schedule_start_date=addslashes(trim($_POST['schedule_start_date']));
	$schedule_end_date=addslashes(trim($_POST['schedule_end_date']));
	
$d1=strtotime($schedule_start_date);
$d2=strtotime($schedule_end_date);
$diff1=$d2-$d1;
$diff1=$diff1/86400;
	
	
	//echo $schedule_event;
	//echo $schedule_start_date;
	//echo $schedule_end_date;
	if($schedule_event!="" && $schedule_start_date!="" && $schedule_end_date!="" && $diff1>=0)
	{
	$r="insert into schedule(username,schedule_event,schedule_start_date,schedule_end_date)values('$_SESSION[uid]','$schedule_event','$schedule_start_date','$schedule_end_date')";
	mysql_query($r) or die(mysql_error());
	}
header('Location:myspace.php?opt=4');	
}

if(isset($_POST['update_note']))
{
	
    $update_note_date=addslashes(trim($_POST['update_note_date']));
	$update_note_content=addslashes(trim($_POST['update_note_content']));
	if($update_note_content!="" && $update_note_date!="")
	{
	$r="update sticky_notes set username='".$_SESSION[uid]."',note_date='".$update_note_date."',note_content='".$update_note_content."' where note_id='".$_SESSION[update_note_id]."'";
	mysql_query($r);}
header('Location:myspace.php?opt=3');
}


if(isset($_POST['edit_photo']))
{
	//$pic=addslashes(trim($_POST['pic']));
    $update_info=addslashes(trim($_POST['update_info']));
	//move_uploaded_file($_FILES["file"]["tmp_name"],"images/user_images/".$_FILES["file"]["name"]);


$image="";
    if($_FILES["file"]["error"]>0)
	echo"";
	else 
	{
		if(file_exists("images/user_images/".$_FILES["file"]["name"]))
		{
	
$new=$_FILES["file"]["name"];
$l=strlen($new);
$name=substr($new,0,$l-4);
$pos1=strlen($name);
$ext=substr($new,$pos1,4);

$inc=1;
while(file_exists("images/user_images/".$new))
{

$tname=$name."(".$inc.")";
$new=$tname."".$ext;

++$inc;
}
echo $new;			
$image=$new;
move_uploaded_file($_FILES["file"]["tmp_name"],"images/user_images/".$new);
			
			
		   
		}
		else 
		{
			$image=addslashes(trim($_FILES["file"]["name"]));
			move_uploaded_file($_FILES["file"]["tmp_name"],"images/user_images/".$_FILES["file"]["name"]);
			
		}
	}
    
if($image=="")
$image=$_SESSION['edit_photo_image_name'];

$image="images/user_images/".$image;    
$r="update photos set photo_info='".$update_info."', photo_link='".$image."' where photo_id='".$_SESSION[edit_photo_session_id]."'";
mysql_query($r); 	

header('Location:'.$_SESSION['check_ref'].'');
}

if($_GET['delete_follow_diary']==1)
{
	$r10="delete from followed where followed_username='".$_GET['follow_d_id']."' and username='".$_SESSION[uid]."' "; // here 'follow_d_id' actually refers to username
    mysql_query($r10)or die(mysql_error());
  
    $r11="delete from bookmark where bookmark.username='".$_SESSION[uid]."' and bookmark.bookmark_pid 
    in(select page_id from pages where pages.username='".$_GET['follow_d_id']."')";
    mysql_query($r11);

    $r12="delete from notification where username='".$_SESSION[uid]."' and from_username='".$_GET['follow_d_id']."'";
    mysql_query($r12);
    
    $u1="update user set num_people_following=num_people_following-1 where username='".$_GET['follow_d_id']."'";
    mysql_query($u1);
    
    $u2="update pages set num_of_people_following=num_of_people_following-1 where username='".$_GET['follow_d_id']."'";
    mysql_query($u2);
    
    
    header('Location:myspace.php?opt=10&sub=1');
}

if($_GET['read_followed_diary']==1)
{
	$_SESSION['obtained']=0;
	$_SESSION['rfd']=$_GET['d_id'];
	//echo($_SESSION['rfd']);
	header('Location:read_followed_diary.php?index_num=1');
}


if($_GET['delete_bookmark']==1)
{
	$r="delete from bookmark where username='".$_SESSION['uid']."' and bookmark_pid='".$_GET['page_id']."'";
 mysql_query($r);
header('Location:myspace.php?opt=10&sub=2');
}

if($_GET['read_bookmark']==1)
{
	header('Location:read_shared_page.php?readbookmark=1&page_id='.$_GET[page_id].'&d_id='.$_GET[d_id].'');	
}


if($_GET['delete_note']==1)
{
	$r="delete from sticky_notes where note_id='".$_GET['delete_note_id']."' and username='".$_SESSION[uid]."' ";
	mysql_query($r);
}
if($_GET['delete_schedule']==1)
{
	$r="delete from schedule where schedule_id='".$_GET['delete_schedule_id']."' and username='".$_SESSION[uid]."' ";
	mysql_query($r);
}
if($_GET['delete_photo']==1)
{
	$r="delete from photos where photo_id='".$_GET['delete_photo_id']."' and username='".$_SESSION[uid]."' ";
	mysql_query($r);
}


if($_GET['add_bm_from_n']==1)
{
	$sel="select bookmark_name from bookmark where username='".$_SESSION[uid]."' and bookmark_pid='".$_GET[page_id]."'";
	$sel1=mysql_query($sel) or die(mysql_error());
	
	if(mysql_num_rows($sel1)==0)
	{
	$su="select d_id from pages where page_id='".$_GET[page_id]."'";
	$su1=mysql_fetch_array(mysql_query($su));
	
	$_SESSION['come_from_notify']=1;
	$_SESSION['bookmarked_d_id']=$su1[d_id];
	$_SESSION['bookmarked_page_id']=$_GET[page_id]; 
	header('Location:add_bookmark.php');
	}
}

if($_GET['read_notify_page']==1)
{
	
$su="select d_id from pages where page_id='".$_GET[page_id]."'";
$su1=mysql_fetch_array(mysql_query($su));

$_SESSION['come_from_notify']=1;	
$_SESSION['bookmarked_d_id']=$su1[d_id];
$_SESSION['bookmarked_page_id']=$_GET[page_id]; 

header('Location:read_shared_page.php?page_id='.$_SESSION[bookmarked_page_id].'&d_id='.$_SESSION[bookmarked_d_id].'');

}

echo("
<html>
<head>
<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/x-icon\">
<title>
My Space
</title>
<link rel=\"stylesheet\" href=\"pattern2.css\">
</head>
<body background=\"images/wood.jpg\">
<table width=\"100%\" border=\"0\" cellspacing=\"0\">
<tr>
<td width=\"100%\">
<table width=\"100%\" border=\"0\" cellspacing=\"0\">
<tr>
<td width=\"10%\">
<center><img src=\"".$_SESSION[new_user_cover]."\" width=\"100\" height=\"120\"></center>
</td>
<td width=\"11%\">
<center><a href=\"myspace.php?opt=1\"><img src=\"images/wall4.jpg\" width=\"80\" height=\"80\" title=\"wall\"></a></center>
</td>
<td width=\"11%\">
<center><a href=\"myspace.php?opt=2\"><img src=\"images/write3.png\" width=\"75\" height=\"80\" title=\"create new page\"></a></center>
</td>
<td width=\"11%\">
<center><a href=\"myspace.php?opt=3\"><img src=\"images/sn1.png\" width=\"75\" height=\"75\" title=\"sticky notes\"></a></center>
</td>
<td width=\"11%\">
<center><a href=\"myspace.php?opt=4&sub=2\"><img src=\"images/schedule1.png\" width=\"80\" height=\"80\" title=\"scheduler\"></a></center>
</td>
<td width=\"11%\">
<center><a href=\"myspace.php?opt=5\"><img src=\"images/camera2.png\" width=\"80\" height=\"80\" title=\"images\"></a></center>
</td>
<td width=\"11%\">
<center><a href=\"myspace.php?opt=6\"><img src=\"images/search2.png\" width=\"80\" height=\"80\" title=\"search and read your diary pages\"></a></center>
</td>
<td width=\"11%\">
<center><a href=\"account_setting.php\"><img src=\"images/setting2.png\" width=\"70\" height=\"70\" title=\"account settings\"></a></center>
</td>
<td width=\"11%\">
<center><a href=\"logout.php\"><img src=\"images/logout2.png\" width=\"80\" height=\"80\" title=\"logout\"></a></center>
</td>
</tr>
</table>
</td>
</tr>

<tr>
<td width=\"100%\">
<table width=\"100%\" border=\"0\" cellspacing=\"0\">
<tr>
<td width=\"10%\" valign=\"top\">
<table width=\"100%\" border=\"0\" cellspacing=\"0\">

<tr>
<td width=\"100%\">
<br>
<center><a href=\"myspace.php?opt=7\"><img src=\"images/search1.png\" width=\"80\" height=\"80\" title=\"search other diaries and shared pages\"></a></center>
</td>
</tr>

<tr>
<td width=\"100%\">
<br><br>
<center><a href=\"myspace.php?opt=8\"><img src=\"images/recommend12.png\" width=\"80\" height=\"80\" title=\"view recommendations\"></a></center>
<br>
</td>
</tr>

<tr>
<td width=\"100%\">
<br><br>
<center><a href=\"myspace.php?opt=9\"><img src=\"images/notify7.png\" width=\"80\" height=\"80\" title=\"read new shared pages\"></a></center>
<br>
</td>
</tr>

<tr>
<td width=\"100%\">
<br><br>
<center><a href=\"myspace.php?opt=10\"><img src=\"images/manage2.png\" width=\"80\" height=\"80\" title=\"manage followed diaries and bookmarks\"></a></center>
<br>
</td>
</tr>

</table>
</td>
");

if($opt==1 || $opt==0)
{
echo("
<td width=\"90%\" background=\"images/bd2.png\">");
?>
<!-- change starts -->
<table width="100%" border="0">
<tr>
<td width="70%">
<!--<div align="left"> -->
<table width="100%" border="0" cellspacing="50">
<tr> 

<!-- change ends -->
<?php 
$r="select * from sticky_notes where username='".$_SESSION['uid']."' order by note_date DESC";
$r1=mysql_query($r);
$i=1;
while($r2=mysql_fetch_array($r1))
{

//echo($r2['note_date']);

if($i%4==1)
echo("<td width=\"25%\" bgcolor=\"#FFE87C\"><img src=\"images/pin1.png\" width=\"20\" height=\"20\"><br><center><hr color=\"#FFA500\"></hr>");
else 
if($i%4==2)
echo("<td width=\"25%\" bgcolor=\"#00FFFF\"><img src=\"images/pin1.png\" width=\"20\" height=\"20\"><br><center><hr color=\"##357EC7\"></hr>");
else if($i%4==3)
echo("<td width=\"25%\" bgcolor=\"#C0C0C0\"><img src=\"images/pin1.png\" width=\"20\" height=\"20\"><br><center><hr color=\"#808080\"></hr>");
else 
echo("<td width=\"25%\" bgcolor=\"#FAAFBE\"><img src=\"images/pin1.png\" width=\"20\" height=\"20\"><br><center><hr color=\"#F660AB\"></hr>");

echo wordwrap($r2['note_content'],20,"<br>\n");
//echo $r2['note_content'];
echo("</center>
</td>");
if($i%4==0)
echo("</tr><tr>");
++$i;
}
if($i==2)
{
echo("<td width=\"25%\"></td><td width=\"25%\"></td><td width=\"25%\"></td>");
}
else 
if($i==3)
{
echo("<td width=\"25%\"></td><td width=\"25%\"></td>");
}
else 
if($i==4)
{
echo("<td width=\"25%\"></td>");
}
?>
</tr>
</table>
<!-- </div> -->
</td>


<!-- change starts -->
<td width="30%">

<?php 
$r="select * from schedule where username='".$_SESSION['uid']."' order by schedule_start_date";
$r1=mysql_query($r);
$i=1;
echo("<table width=\"100%\" border=\"0\" cellspacing=\"50\">
<tr>
");

$today=date('Y-m-d');

while($r2=mysql_fetch_array($r1))
{

$d1=strtotime($r2['schedule_start_date']);
$d2=strtotime($today);
$diff1=$d1-$d2;
$diff1=$diff1/86400;
	
$d3=strtotime($r2['schedule_end_date']);
$diff2=$d3-$d2;
$diff2=$diff2/86400;

if($diff2>=0)
{

if($diff1>0)
{
echo("<td width=\"100%\" bgcolor=\"#FFE87C\">");
echo("<img src=\"images/s1.png\" height=\"30\" width=\"30\"><center><font color=\"#008000\"><b>".$r2['schedule_event']."");
echo("<br><hr color=\"#FFA500\"><br>");
echo ("<font color=\"#FFA500\">start date&nbsp;:&nbsp;</font>".$r2['schedule_start_date']);
echo ("<br><br><font color=\"#FFA500\">&nbsp;&nbsp;due date&nbsp;:&nbsp;</font>".$r2['schedule_end_date']);
echo("</b></font></center></td>");
}
else 
if($diff1<=0 && $diff2>=0)
{
echo("<td width=\"100%\" bgcolor=\"#FFE87C\">");
echo("<img src=\"images/s1.png\" height=\"30\" width=\"30\"><center><font color=\"#F6358A\"><b>".$r2['schedule_event']."");
echo("<br><hr color=\"#FFA500\"><br>");
echo ("<font color=\"#FFA500\">start date&nbsp;:&nbsp;</font>".$r2['schedule_start_date']);
echo ("<br><br><font color=\"#FFA500\">&nbsp;&nbsp;due date&nbsp;:&nbsp;</font>".$r2['schedule_end_date']);
echo("</b></font></center></td>");
}

echo("</tr><tr>");
++$i;
if($i==3)
break;

}


}
echo("</tr></table>");
?>
</td>
<!-- change ends -->


</tr>
</table>
<?php 
echo("</td>");
}
else 
if($opt==2)
{
echo
("
<td width=\"90%\">");
?>

<form id="create_diary_page" action="myspace.php" method="post" enctype="multipart/form-data">
<table width="100%" border="0">
<tr>
<td width="100%">
<table width="100%" border="0">
<tr>
<td width="26%">
<center>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<font color="#008000"><b>
<input type="file" name="file" id="file">
</b>
</font>
<br>
<textarea style="resize: none; background-color: #FAF8CC;" rows="2" cols="20"  name="image1_info" placeholder="info about photo1..."></textarea>
</center>
</td>
<td width="26%">
<center>
<font color="#008000"><b>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="file" name="file1" id="file1">
</b></font><br>
<textarea style="resize: none; background-color: #FAF8CC;" rows="2" cols="20" name="image2_info"  placeholder="info about photo2..."></textarea>
</center>
</td>
<td width="24%">
<center>
<font color="#008000">
Select Page Category
<br><i>(for shared page)</i><br>
<select name="select_category" style="background-color: #FAF8CC;">
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
</font>
</center>
</td>
<td width="24%">
<!-- <center> -->
<input type="submit" name="submit_private" value="save page">
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" name="submit_public" value="save page and share">
<!--</center>-->
</td>
</tr>
</table>
</td>
</tr>

<tr>
<td width="100%">
<table width="100%">
<tr>
<td width="100%">
<center>
<textarea style="resize: none; background-color: #FAF8CC; line-height:160% ; font-size:18px ; font-family:Georgia; text-align:justify;" 
name="page_content" rows="15" cols="138" maxlength="10000" placeholder="start writing here..."></textarea>
</center>
</td>
</tr>
</table>
</td>
</tr>
</table>
</form>
<?
echo("
</td>");
}
else 
if($opt==3)
{
echo("<td width=\"90%\">");?>
<?php 
echo("<table width=\"100%\" border=\"0\"><tr>");
echo("<td width=\"90%\"><table width=\"100%\" border=\"0\"><tr>");
?>
<td width="100%">
<?php 
$sub=$_GET['sub'];
if($sub==1 || $sub==0)
{
?>
<div align="center">
<form id="new" action="myspace.php" method="post">
<font color="#008000" face="Times New Roman"><b>
Date&nbsp;:&nbsp;<input type="date" name="note_date">
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Content&nbsp;:&nbsp;<textarea rows="5" cols="25" name="note_content" style="resize: none;"></textarea>
</b></font>
<br><br>
<input type="submit" name="new_note" value="make note">
</form>
</div>
<?php 	
}
else 
if($sub==3 || $sub==2)
{
$r="select * from sticky_notes where username='".$_SESSION['uid']."' order by note_date DESC";
$r1=mysql_query($r);
$i=1;
?>
<table width="100%" border="0">
<tr>
<td width="91%">
<table width="100%" border="0" cellspacing="50">
<tr>
<?php 

if($_GET['edit_note']!=1)//
{//
if($sub==2)
echo("<center><h3><font color=\"#008000\">select note to be edited</font></h3></center>");
if($sub==3)
echo("<center><h3><font color=\"#008000\">select note to be removed</font></h3></center>");
while($r2=mysql_fetch_array($r1))
{
echo("<td width=\"25%\" bgcolor=\"#FFE87C\"><center><br>");
if($sub==3)
//echo ("<a href=\"myspace.php?opt=3&delete_note=1&delete_note_id=".$r2['note_id']."\">".$r2['note_content']."</a>");
echo ("<a href=\"myspace.php?opt=3&delete_note=1&delete_note_id=".$r2['note_id']."\">".wordwrap($r2['note_content'],20,"<br>\n")."</a>");

if($sub==2)
//echo ("<a href=\"myspace.php?edit_note=1&edit_note_id=".$r2['note_id']."&opt=3&sub=2\">".$r2['note_content']."</a>");;
echo ("<a href=\"myspace.php?edit_note=1&edit_note_id=".$r2['note_id']."&opt=3&sub=2\">".wordwrap($r2['note_content'],20,"<br>\n")."</a>");
echo("</center>
</td>");
if($i%4==0)
echo("</tr><tr>");
++$i;
}
}//
else 
{
	$r="select * from sticky_notes where note_id='".$_GET['edit_note_id']."'";
	$r1=mysql_query($r);
	$r2=mysql_fetch_array($r1);
	$_SESSION['update_note_id']=$r2['note_id'];
	echo("
<div align=\"center\">
<form id=\"upnote\" action=\"myspace.php\" method=\"post\">
<font color=\"#008000\" face=\"Times New Roman\"><b>
Edit Date&nbsp;:&nbsp;<input type=\"date\" name=\"update_note_date\" value=\"".$r2['note_date']."\">
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Edit Content&nbsp;:&nbsp;<textarea rows=\"5\" cols=\"25\" name=\"update_note_content\">".$r2['note_content']."</textarea>
</b></font>
<br><br>
<input type=\"submit\" name=\"update_note\" value=\"update note\">
</form>
</div>
");	
}


if($i==2)
{
echo("<td width=\"25%\"></td><td width=\"25%\"></td><td width=\"25%\"></td>");
}
else 
if($i==3)
{
echo("<td width=\"25%\"></td><td width=\"25%\"></td>");
}
else 
if($i==4)
{
echo("<td width=\"25%\"></td>");
}

	
}
?>
</tr>
</table>
</td>




<td width="10%">
<table width="100%" border="0">
<tr>
<td width="100%">
<br>
<center><a href="myspace.php?opt=3&sub=1"><img src="images/create1.png" width="50" height="50" title="create new note"></a></center>
<br>
</td>
</tr>
<tr>
<td width="100%"><br>
<center><a href="myspace.php?opt=3&sub=2"><img src="images/edit.png" width="55" height="55" title="edit sticky note"></a></center>
<br>
</td>
</tr>
<tr>
<td width="100%">
<br>
<center><a href="myspace.php?opt=3&sub=3"><img src="images/cancel.png" width="50" height="50" title="remove sticky note"></a></center>
<br>
</td>
</tr>

</table>
</td>

</tr>
</table>
<?php 
echo("</td>");
}



else 
if($opt==4)
{
echo("
<td width=\"90%\">");
?>
<?php // start of entire table of scheduler?>

<table width="100%" border="0">
<tr>
<?php // this 90% is for display of scheduler?>
<td width="90%">
<table width="100%" border="0">
<tr>
<td width="100%">

<?php if($_GET['sub']==1){//start of new schedule?>
<center>
<form id="schedule1" action="myspace.php" method="post">
<font color="#008000" face="Times New Roman"><b>
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Event to be Scheduled&nbsp;:&nbsp;<textarea rows="5" cols="25" name="schedule_event" style="resize: none;" ></textarea>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<br><br><br>
Event Start Date&nbsp;:&nbsp;<input type="date" name="schedule_start_date">
<br><br>
&nbsp;Event Due Date&nbsp;:&nbsp;<input type="date" name="schedule_end_date">
<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" name="new_schedule" value="create schedule">
</b></font>
</form>
</center>
<?php }//end of new schedule?>

<?php if($_GET['sub']==2 || $_GET['sub']==0 || $_GET['sub']==3)
{// start of view schedule 

$r="select * from schedule where username='".$_SESSION['uid']."' order by schedule_start_date DESC";
$r1=mysql_query($r);
$i=1;
?>

<table width="100%" border="0" cellspacing="50">
<tr>
<?php 

if($_GET['sub']==0 || $_GET['sub']==2)
{
	//echo($_GET['sub']);
//echo("Hey there");
$today=date("Y-m-d");
//echo($today);
while($r2=mysql_fetch_array($r1))
{
//echo("Hello there");

//$date1=date_create("2013/03/15");
//echo $date1;
//$date2=date_create("2013-12-12");

//echo $r2['schedule_start_date'];
//$diff=date_Diff($r2['schedule_start_date'],$today);
//echo strtotime($r2['schedule_start_date']);
//$diff1=-5;
//$diff2=10;

$d1=strtotime($r2['schedule_start_date']);
$d2=strtotime($today);
$diff1=$d1-$d2;
$diff1=$diff1/86400;

//echo $diff1;

$d3=strtotime($r2['schedule_end_date']);
$diff2=$d3-$d2;
$diff2=$diff2/86400;

//echo $diff2;
//echo("Val of difference = ".$diff1);
if($diff1>0)
{
echo("<td width=\"25%\" bgcolor=\"#FFE87C\">");
echo("<img src=\"images/s1.png\" height=\"30\" width=\"30\"><center><font color=\"#008000\"><b>".$r2['schedule_event']."");
echo("<br><hr color=\"#FFA500\"><br>");
echo ("<font color=\"#FFA500\">start date&nbsp;:&nbsp;</font>".$r2['schedule_start_date']);
echo ("<br><br><font color=\"#FFA500\">&nbsp;&nbsp;due date&nbsp;:&nbsp;</font>".$r2['schedule_end_date']);
echo("</b></font></center></td>");
}
else 
if($diff1<=0 && $diff2>=0)
{
echo("<td width=\"25%\" bgcolor=\"#FFE87C\">");
echo("<img src=\"images/s1.png\" height=\"30\" width=\"30\"><center><font color=\"#F6358A\"><b>".$r2['schedule_event']."");
echo("<br><hr color=\"#FFA500\"><br>");
echo ("<font color=\"#FFA500\">start date&nbsp;:&nbsp;</font>".$r2['schedule_start_date']);
echo ("<br><br><font color=\"#FFA500\">&nbsp;&nbsp;due date&nbsp;:&nbsp;</font>".$r2['schedule_end_date']);
echo("</b></font></center></td>");
}
else 
{
echo("<td width=\"25%\" bgcolor=\"#FFE87C\">");
echo("<img src=\"images/s1.png\" height=\"30\" width=\"30\"><center><font color=\"#FF0000\"><b>".$r2['schedule_event']."");
echo("<br><hr color=\"#FFA500\"><br>");
echo ("<font color=\"#FFA500\">start date&nbsp;:&nbsp;</font>".$r2['schedule_start_date']);
echo ("<br><br><font color=\"#FFA500\">&nbsp;&nbsp;due date&nbsp;:&nbsp;</font>".$r2['schedule_end_date']);
echo("</b></font></center></td>");
}	

if($i%4==0)
echo("</tr><tr>");
++$i;
}
/////////////////////////////////////

if($i==2)
{
echo("<td width=\"25%\"></td><td width=\"25%\"></td><td width=\"25%\"></td>");
}
else 
if($i==3)
{
echo("<td width=\"25%\"></td><td width=\"25%\"></td>");
}
else 
if($i==4)
{
echo("<td width=\"25%\"></td>");
}

///////////////////////////////////////
}
else 
{
while($r2=mysql_fetch_array($r1))
{
echo("<td width=\"25%\" bgcolor=\"#FFE87C\">");
echo ("<a href=\"myspace.php?opt=4&delete_schedule=1&delete_schedule_id=".$r2['schedule_id']."\"><img src=\"images/xs2.png\" width=\"30\" height=\"30\"><br><center>".$r2['schedule_event']."</a>");
echo("<br><hr color=\"#FFA500\"><br>");
echo ("<font color=\"#800000\">start date&nbsp;:&nbsp;".$r2['schedule_start_date']);
echo ("<br><br>due date&nbsp;:&nbsp;".$r2['schedule_end_date']."</font>");
echo("</center></td>");
if($i%4==0)
echo("</tr><tr>");
++$i;
}

///////////////////////////////////
if($i==2)
{
echo("<td width=\"25%\"></td><td width=\"25%\"></td><td width=\"25%\"></td>");
}
else 
if($i==3)
{
echo("<td width=\"25%\"></td><td width=\"25%\"></td>");
}
else 
if($i==4)
{
echo("<td width=\"25%\"></td>");
}

////////////////////////////////////////
}//end of else for sub=3


?>
</tr>

</table>
<?php }//End of view schedule?>















</td> 
</tr>
</table>
</td>
<?php // this is end of 90% for display of scheduler?>


<td width="10%">
<table width="100%">
<tr>
<td width="100%">
<br><center><a href="myspace.php?opt=4&sub=1"><img src="images/create1.png" width="50" height="50" title="create new schedule"></a></center><br>
</td>
</tr>
<tr>
<td width="100%">
<br><center><a href="myspace.php?opt=4&sub=2"><img src="images/eye1.png" width="55" height="55" title="view schedules"></a></center><br>
</td>
</tr>
<tr>
<td width="100%">
<br><center><a href="myspace.php?opt=4&sub=3"><img src="images/cancel.png" width="50" height="50" title="remove schedule"></a></center><br>
</td>
</tr>

</table>
</td>
</tr>
</table>
<?php // This is entire table for scheduler?>



<?php ///////////////////////////////////////////////////////////////////////// ?>



<?php echo("
</td>");
}
else 
if($opt==5)
{
echo("
<td width=\"90%\" valign=\"top\">
");
// This is start of entire photos section
?>

<table width="100%"><!-- Here the entire table for diaplay starts -->
<tr><!-- Here entire row for display starts -->


<td width="90%" valign="top"><!-- Here column for display starts -->
<table width="100%">
<tr>
<td width="100%" valign="top"><!-- This is end of column of width 100% provided for display of photos -->
<br>
<?php 
$r="select * from photos where username='".$_SESSION['uid']."' order by photo_date DESC";
$r1=mysql_query($r);
?>
<table width="100%" cellspacing="60"><!-- This is start of table for display -->
<tr>
<?php

if($_GET['edit_photo']!=1)
{
$i=1;
if($_GET['sub']==1 || $_GET['sub']==0)
{
while($r2=mysql_fetch_array($r1))
{
echo("<td width=\"10%\" valign=\"top\"><center><font color=\"#008000\"><b>");
//echo($r2['photo_link']);
echo("<img src=\"".$r2['photo_link']."\" width=\"100\" height=\"100\"><br>
date&nbsp;:&nbsp;".$r2['photo_date']."<br>page num&nbsp;:&nbsp;".$r2['page_num']."<br>
<a href=\"myspace.php?opt=5&edit_photo=1&edit_photo_id=".$r2['photo_id']."\"><img src=\"images/pe1.png\" width=\"35\" height=\"35\" title=\"edit information\"></a>
&nbsp;&nbsp;
<a href=\"myspace.php?opt=5&delete_photo=1&delete_photo_id=".$r2['photo_id']."\"><img src=\"images/del1.png\" width=\"25\" height=\"25\" title=\"delete image\"></a>
</b></font></center>
");

echo("</td>");
if($i%4==0)
echo("</tr><tr>");
++$i;	
}
}
else
{
echo("<center><b><font color=\"#008000\">select image to be viewed and updated</font></b></center>");
while($r2=mysql_fetch_array($r1))
{
	
echo("<td width=\"10%\" valign=\"top\"><center><font color=\"#008000\"><b>");
echo("<a href=\"myspace.php?opt=5&edit_photo=1&edit_photo_id=".$r2['photo_id']."\"><img src=\"".$r2['photo_link']."\" width=\"100\" height=\"100\"></a><br>
date&nbsp;:&nbsp;".$r2['photo_date']."<br>page num&nbsp;:&nbsp;".$r2['page_num']."<br>
</b></font></center>
");

echo("</td>");
if($i%4==0)
echo("</tr><tr>");
++$i;	
}
}
}//////////////
if($_GET['edit_photo']==1)
{
$r="select * from photos where username='".$_SESSION['uid']."' and photo_id='".$_GET['edit_photo_id']."'";
$r1=mysql_query($r);	
$r2=mysql_fetch_array($r1);
$_SESSION['edit_photo_session_id']=$_GET['edit_photo_id'];
echo("<td width=\"100%\">

<table width=\"100%\" border=\"0\">
<tr>
<td width=\"50%\">

<center>
<img src=\"".$r2['photo_link']."\" width=\"100\" height=\"100\"><br><br>
<font color=\"#008000\"><b>date&nbsp;:&nbsp;".$r2['photo_date']."<br><br>page num&nbsp;:&nbsp;".$r2['page_num']."<br>
</b></font>
</center>



</td>

<td width=\"50%\">
<br><br>

");
$name=$r2['photo_link'];
$l=strlen($name);

$pos=strrpos($name,"/");
$nl=$l-$pos;
$image_name=substr($name,$pos+1,$nl);
//echo $image_name;
$_SESSION['edit_photo_image_name']=$image_name;
echo("<form id=\"edit_info\" action=\"myspace.php\" method=\"post\" enctype=\"multipart/form-data\">
<font color=\"#008000\">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b>Change Photo&nbsp;:&nbsp;</b>
<input type=\"file\" name=\"file\" id=\"file\" value=\"".$image_name."\" title=\"Select a new photo.By default Existing photo is selected.\">
<br><br>
<b>Update photo information&nbsp;:&nbsp;</b>
<textarea rows=\"5\" cols=\"28\" name=\"update_info\">".$r2['photo_info']."</textarea>
<br><br>
</font>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type=\"submit\" name=\"edit_photo\" value=\"update information\">
</form>
</td>

</tr>
</table>

</td>
");

}

?>
</tr>
</table><!-- This is start of table for display  -->

</td><!-- This is end of column of width 100% provided for display of photos -->
</tr>
</table>
</td> <!-- Here column for display ends -->


<!-- Now we go towards Menu -->


<td width="10%" valign="top"> <!-- Here column for RHS starts -->
<br><br><br><br><br><br><br>
<table width="100%" cellspacing="50">
<tr>
<td width="100%">
<a href="myspace.php?opt=5&sub=1"><img src="images/c1.png" width="55" height="55" title="view images"></a>
</td>
</tr>
<tr>
<td width="100%">
<a href="myspace.php?opt=5&sub=2"><img src="images/pe1.png" width="60" height="60" title="edit images"></a>
</td>
</tr>
</table>
</td> <!-- Here column for RHS ends -->


</tr><!-- Here entire row for display ends -->
</table><!-- Here the entire table for diaplay ends -->

<?php 
// This is END of entire section of Photos
echo("
</td>");
}







else 
if($opt==6)
{
echo("
<td width=\"90%\">
");
?>


<table width="100%" border="0">
<tr>
<td width=\"100%\">
<center><font color="#008000"><h1><b>Enter the details you can</b></h1></font></center>

</td>
</tr>

<tr>
<td width="100%">

<table width="100%" border="0">
<tr>
<td width="30%">
<center><img src="images/search5.png" width="180" height="180"></center>
</td>
<td width="50%">

<div align="left">
<form id="search_page" action="myspace.php" method="post"><font color="#008000"><b>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo("keywords&nbsp;:&nbsp;<textarea name=\"key_word\" rows=\"5\" cols=\"30\" style=\"resize: none;\" title=\"enter keyword seperated by comma.ex: key1,key2\">".$_SESSION['search_key_word']."</textarea>
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
date&nbsp;:&nbsp;<input type=\"date\" name=\"search_event_date\" value=\"".$_SESSION['search_event_date']."\">
<br><br>
photo information&nbsp;:&nbsp;<textarea name=\"photo_key_word\" rows=\"5\" cols=\"30\" style=\"resize: none;\" title=\"enter keyword seperated by comma.ex: key1,key2\">".$_SESSION['photo_key_word']."</textarea> 
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
page number&nbsp;:&nbsp;<input type=\"text\" name=\"search_page_num\" value=\"".$_SESSION['search_page_num']."\">");?>
<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" name="search_page" value="search content">
</b></font>
</form>
<br><br>
</div>
</td>

<td width="20%">
<div align="left"><img src="images/eye2.png" width="100" height="100"></div>
</td>
</tr>
</table>


</td>
</tr>
</table>

<?php 
echo("
</td>");
}
else 
if($opt==7)
{
?>
<!--  This is start of diary search -->
<td width="90%">
<table width="100%" border="0">

<!-- First Row Starts -->
<tr>
<td width="100%">
<table width="100%">
<tr>
<td width="100%">
<center><font color="#008000"><h1><b>Search for Diary and Shared Pages</b></h1></font></center>
</td>
</tr>
</table>
</td>
</tr>
<!-- First Row Ends -->


<tr>
<td width="100%">
<table width="100%" border="0">
<tr>


<td width="40%">
<table width="100%">
<tr>
<td width="100%">
<div align="right">
<font color="#808080"><h2><b>Diary Search</b></h2></font>
<br><br>

<form id="search_d" action="myspace.php" method="post">
<b><font color="#008000">
Diary Name&nbsp;:&nbsp;<input type="text" name="search_diary_name">
<br><br>
Express User id&nbsp;:&nbsp;<input type="text" name="search_user_id">
<br><br>
<!-- <a href=""><img src="images/bn3.png" width="50" height="50"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
<input type="submit" name="search_diary1" value="find this diary">&nbsp;
</font>
</b>
</form>
</div>
</td>
</tr>
</table>
<br><br><br><br>
</td>

<td width="5%">

</td>


<td width="30%">
<table width="100%">
<tr>
<td width="100%">
<br>
<div align="right">
<font color="#808080"><h2><b>Page Search</b></h2></font>
<br><br>

<form id="search_p" action="myspace.php" method="post">
<b><font color="#008000">
Select Page Category&nbsp;:&nbsp;
<select name="select_category">
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
Diary Name&nbsp;:&nbsp;&nbsp;<input type="text" name="search_diary_name">
<br><br>
<!-- <a href=""><img src="images/bn3.png" width="50" height="50"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
<input type="submit" name="search_shared_page" value="find this page">&nbsp;
</font>
</b>
</form>
</div>
</td>
</tr>
</table>
<br><br><br><br><br><br>
</td>

<td width="25">
<div align="right"><img src="images/bn3.png" width="150" height="150"></div>
</td>




</tr>
</table>
</td>
</tr>














</table>
</td>
<!--  This is the END of diary search -->
<?php 
}

else 
if($opt==8)
{
echo("
<td width=\"90%\">");
?>
<table width="100%">
<tr>
<td width="100%">
<br><br><br><br><br><br>
<table width="100%" cellspacing="30">
<tr>

<!-- Here display all recommendation using a while loop -->

<?php 

$sel="select follow_name, total_strength from recommend_final where username='".$_SESSION[uid]."'";
$sel1=mysql_query($sel) or die(mysql_error());

$inc=1;

$rec_list=array();
$index=1;

if(mysql_num_rows($sel1)==0)
{

$select_top="select username, num_people_following from user order by num_people_following DESC";
$select_top1=mysql_query($select_top) or die(mysql_error());

while($select_top2=mysql_fetch_array($select_top1))
{
	
if($_SESSION[uid]!=$select_top2['username'])
{	
$rec_list[1][$index]=$select_top2['username'];	
$rec_list[2][$index]=$select_top2['num_people_following'];
	
$index++;
if($index==6)
break;
}

}
/////////////////////////////////////////////
for($i=1;$i<$index;++$i)
{
for($j=$i+1;$j<$index;++$j)
{
	if($rec_list[2][$i]<$rec_list[2][$j])
	{
		$temp1=$rec_list[1][$i];
		$temp2=$rec_list[2][$i];
		
		$rec_list[1][$i]=$rec_list[1][$j];
		$rec_list[2][$i]=$rec_list[2][$j];
		
		$rec_list[1][$j]=$temp1;
		$rec_list[2][$j]=$temp2;
	}
}	
}

for($i=1;$i<$index;++$i)
{

	
$sel3="select d_name, cover_path from user, covers where user.username='".$rec_list[1][$i]."' and user.d_cover=covers.cover_id";
$sel4=mysql_query($sel3);
$sel5=mysql_fetch_array($sel4);
	

echo("<td width=\"20%\"><center>");	

echo("<img src=\"$sel5[cover_path]\" width=\"60\" height=\"60\"><br>");
echo("<font color=\"#008000\"><b>".$sel5['d_name']."</b></font>");
echo("<br><a href=\"follow_diary_from_diary_search.php?rec_follow=1&follow_id=".$rec_list[1][$i]."\"><font color=\"#808080\"><b>follow</b></font></a>");

echo("</center><br><br><br><br><br><br></td>");


if($inc%5==0)
echo("</tr><tr>");

}
//////////////////////////////////////////////

}
else 
{
$sel="select follow_name, total_strength from recommend_final where username='".$_SESSION[uid]."' and level='T' ";
$sel1=mysql_query($sel) or die(mysql_error());


while($sel2=mysql_fetch_array($sel1))
{

$rec_list[1][$index]=$sel2['follow_name'];	
$rec_list[2][$index]=$sel2['total_strength'];

$index++;
}
//    } change made by adding // to the else part


// sorting according to strength

for($i=1;$i<$index;++$i)
{
for($j=$i+1;$j<$index;++$j)
{
	if($rec_list[2][$i]<$rec_list[2][$j])
	{
		$temp1=$rec_list[1][$i];
		$temp2=$rec_list[2][$i];
		
		$rec_list[1][$i]=$rec_list[1][$j];
		$rec_list[2][$i]=$rec_list[2][$j];
		
		$rec_list[1][$j]=$temp1;
		$rec_list[2][$j]=$temp2;
	}
}	
}


for($i=1;$i<$index;++$i)
{

	
$sel3="select d_name, cover_path from user, covers where user.username='".$rec_list[1][$i]."' and user.d_cover=covers.cover_id";
$sel4=mysql_query($sel3);
$sel5=mysql_fetch_array($sel4);
	

echo("<td width=\"20%\"><center>");	

echo("<img src=\"$sel5[cover_path]\" width=\"60\" height=\"60\"><br>");
echo("<font color=\"#008000\"><b>".$sel5['d_name']."</b></font>");
echo("<br><a href=\"follow_diary_from_diary_search.php?rec_follow=1&follow_id=".$rec_list[1][$i]."\"><font color=\"#808080\"><b>follow</b></font></a>");

echo("</center></td>");


if($inc%5==0)
echo("</tr><tr>");

++$inc;
/////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////

if($inc==11)
break;
}

if($inc<11)
{
$sel="select follow_name, total_strength from recommend_final where username='".$_SESSION[uid]."' and level='M' ";
$sel1=mysql_query($sel) or die(mysql_error());

//$inc=1; I have commented this statement now bcoz it resets value of inc to 1

$rec_list=array();
$index=1;

while($sel2=mysql_fetch_array($sel1))
{

$rec_list[1][$index]=$sel2['follow_name'];	
$rec_list[2][$index]=$sel2['total_strength'];

$index++;
}

// sorting according to strength
for($i=1;$i<$index;++$i)
{
for($j=$i+1;$j<$index;++$j)
{
	if($rec_list[2][$i]<$rec_list[2][$j])
	{
		$temp1=$rec_list[1][$i];
		$temp2=$rec_list[2][$i];
		
		$rec_list[1][$i]=$rec_list[1][$j];
		$rec_list[2][$i]=$rec_list[2][$j];
		
		$rec_list[1][$j]=$temp1;
		$rec_list[2][$j]=$temp2;
	}
}	
}


for($i=1;$i<$index;++$i)
{
$sel3="select d_name, cover_path from user, covers where user.username='".$rec_list[1][$i]."' and user.d_cover=covers.cover_id";
$sel4=mysql_query($sel3);
$sel5=mysql_fetch_array($sel4);
	

echo("<td width=\"20%\"><center>");	

echo("<img src=\"$sel5[cover_path]\" width=\"60\" height=\"60\"><br>");
echo("<font color=\"#008000\"><b>".$sel5['d_name']."</b></font>");
echo("<br><a href=\"follow_diary_from_diary_search.php?rec_follow=1&follow_id=".$rec_list[1][$i]."\"><font color=\"#808080\"><b>follow</b></font></a>");

echo("</center></td>");

if($inc%5==0)
echo("</tr><tr>");

++$inc;

if($inc==11)
break;
}
	
}

if($inc<11)
{
$sel="select follow_name, total_strength from recommend_final where username='".$_SESSION[uid]."' and level='L' ";
$sel1=mysql_query($sel) or die(mysql_error());

//$inc=1;

$rec_list=array();
$index=1;

while($sel2=mysql_fetch_array($sel1))
{

$rec_list[1][$index]=$sel2['follow_name'];	
$rec_list[2][$index]=$sel2['total_strength'];

$index++;
}

// sorting according to strength
for($i=1;$i<$index;++$i)
{
for($j=$i+1;$j<$index;++$j)
{
	if($rec_list[2][$i]<$rec_list[2][$j])
	{
		$temp1=$rec_list[1][$i];
		$temp2=$rec_list[2][$i];
		
		$rec_list[1][$i]=$rec_list[1][$j];
		$rec_list[2][$i]=$rec_list[2][$j];
		
		$rec_list[1][$j]=$temp1;
		$rec_list[2][$j]=$temp2;
	}
}	
}


for($i=1;$i<$index;++$i)
{
$sel3="select d_name, cover_path from user, covers where user.username='".$rec_list[1][$i]."' and user.d_cover=covers.cover_id";
$sel4=mysql_query($sel3);
$sel5=mysql_fetch_array($sel4);
	

echo("<td width=\"20%\"><center>");	

echo("<img src=\"$sel5[cover_path]\" width=\"60\" height=\"60\"><br>");
echo("<font color=\"#008000\"><b>".$sel5['d_name']."</b></font>");
echo("<br><a href=\"follow_diary_from_diary_search.php?rec_follow=1&follow_id=".$rec_list[1][$i]."\"><font color=\"#808080\"><b>follow</b></font></a>");

echo("</center></td>");

if($inc%5==0)
echo("</tr><tr>");

++$inc;

if($inc==11)
break;
}
	
}

}
?>

<!-- Here end the display all recommendation using a while loop -->

</tr>
</table>
<br><br><br><br><br>
</td>
</tr>
</table>

<?php 
echo("</td>");
}
else 
if($opt==9)
{
echo("
<td width=\"90%\">");
?>
<table width="100%">
<tr>
<td width="100%">



<table width="100%">
<tr>
<?php 
$sn="select from_username, page_id, notify_date from notification where username='".$_SESSION[uid]."' order by notify_date DESC";
$sn1=mysql_query($sn) or die(mysql_error());

$inc=1;
while($sn2=mysql_fetch_array($sn1))
{
$sel1="select d_name from user where username='".$sn2['from_username']."'";	
$sel2=mysql_fetch_array(mysql_query($sel1)) or die(mysql_error());	

echo("

<td width=\"20%\"><center><br>
<img src=\"images/pg1.png\" width=\"60\" height=\"60\"><br><font color=\"#008000\"><b>".$sel2[d_name]."<br>

<a href=\"myspace.php?read_notify_page=1&page_id=".$sn2[page_id]."\">
<img src=\"images/rd12.png\" width=\"25\" height=\"25\" title=\"read page\"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<a href=\"myspace.php?add_bm_from_n=1&page_id=".$sn2[page_id]."\">
<img src=\"images/bm6.png\" width=\"20\" height=\"20\" title=\"bookmark this page\"></a>

</b></font></center><br></td>

");
	

if($inc%5==0)
echo("</tr><tr>");

++$inc;
}

?>
</tr>
</table>







</td>
</tr>
</table>
<?php 
echo("
</td>");
}
else 
if($opt==10)
{
echo("
<td width=\"90%\">");
?>

<table width="100%" border="0">
<tr>

<td width="90%">
<br><br>
<table width="100%" border="0">
<tr>

<?php 

if($_GET['sub']==0 || $_GET['sub']==1)
{
	$q="select d_name, username, cover_path from user inner join covers where user.d_cover=covers.cover_id and user.d_id in
	(select d_id from user where user.username in (select followed_username from followed where followed.username='".$_SESSION[uid]."' ))";
	
	$q1=mysql_query($q);
	$inc=0;
	while($q2=mysql_fetch_array($q1))
	{
	echo("<td width=\"20%\"><center>
	<br>
	<img src=\"".$q2['cover_path']."\" width=\"60\" height=\"60\"><br><font color=\"#008000\">
	<b>".$q2['d_name']."</b></font>
	
	<br>
	<a href=\"myspace.php?read_followed_diary=1&d_id=".$q2['username']."\">
    <img src=\"images/rd12.png\" width=\"25\" height=\"25\" title=\"read shared pages of diary\"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=\"myspace.php?opt=10&delete_follow_diary=1&follow_d_id=".$q2['username']."\"><img src=\"images/del1.png\" width=\"20\" height=\"20\" title=\"stop following diary\"></a>
	</center><br><br></td>");	
	++$inc;
	if($inc%5==0)
	echo("</tr><tr>");
	}
	
}
else
if($_GET['sub']==2)
{


//else 
//{
$q="select page_id, d_id, page_date, bookmark_name from bookmark inner join pages where bookmark.bookmark_pid=pages.page_id and  pages.page_id in
 ( select bookmark_pid from bookmark where bookmark.username='".$_SESSION[uid]."') and bookmark.username='".$_SESSION[uid]."'";
$q1=mysql_query($q);
//$q2=mysql_fetch_array($q1);
while($q2=mysql_fetch_array($q1))
{
echo("<td width=\"20%\"><center><img src=\"images/bm3.png\" width=\"60\" height=\"60\"><br><font color=\"#008000\"><b>".$q2['bookmark_name']."<br>
<a href=\"myspace.php?opt=10&sub=2&read_bookmark=1&page_id=".$q2['page_id']."&d_id=".$q2['d_id']."&page_date=".$q2['page_date']."\">
<img src=\"images/rd12.png\" width=\"25\" height=\"25\" title=\"read page\"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href=\"myspace.php?opt=10&sub=2&delete_bookmark=1&page_id=".$q2['page_id']."&d_id=".$q2['d_id']."\">
<img src=\"images/del1.png\" width=\"20\" height=\"20\" title=\"remove bookmark\"></a>
</b></font></center><br><br><br><br><br><br></td>");	
	++$inc;
	if($inc%5==0)
	echo("</tr><tr>");
}
//}


}	



?>

</tr>
</table>
</td>


<td width="10%"> 
<table width="100%" cellspacing="50">

<tr>
<td width="100%">
<center><a href="myspace.php?opt=10&sub=1"><img src="images/d46.jpg" width="60" height="60" title="view followed diaries"></a></center>
</td>
</tr>
<tr>
<td width="100%">
<center><a href="myspace.php?opt=10&sub=2"><img src="images/bm6.png" width="40" height="40" title="view bookmarked pages"></a></center>
</td>
</tr>

</table>
</td>

</tr>
</table>

<?php 
echo("
</td>");
}









echo("
</tr>
</table>

</td>
</tr>
</table>
</body>
</html>
");
}
else 
header('Location:index.php');
?>