<?php
session_start();   
error_reporting(E_PARSE);
if($_SESSION['logged_in']==1)
{
$con=mysql_connect("localhost","root","");
    if(! $con)
    die("couldn't connect to database");
    mysql_select_db("diary",$con) or die ("cannot select db");

    $r="select username from user where user.d_id='".$_GET[d_id]."'";
    $r1=mysql_query($r);
    $r2=mysql_fetch_array($r1);
    
    if($r2['username']!=$_SESSION[uid])
    {
    $i="insert into followed (username,followed_username,follow_date) values ('$_SESSION[uid]','$r2[username]',CURDATE())";
    mysql_query($i);
    
    $u1="update user set num_people_following=num_people_following+1 where username='".$r2[username]."'";
    mysql_query($u1);
    
    $u2="update pages set num_of_people_following=num_of_people_following+1 where username='".$r2[username]."'";
    mysql_query($u2);
    
    $del1="delete from recommend_final where username='".$_SESSION[uid]."' and follow_name='".$r2[username]."'";
    mysql_query($del1);
 
    
    }
    
    
    header('Location:read_shared_page.php?d_id='.$_GET['d_id'].'&page_id='.$_GET['page_id'].'&page_date='.$_GET['page_date'].'&num_follow='.$_GET['num_of_people_following'].'&
           content='.$_GET['content'].'');
    //header('Location:myspace.php?opt=7');
}
?>
