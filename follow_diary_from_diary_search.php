<?php
session_start();   
error_reporting(E_PARSE);
if($_SESSION['logged_in']==1)
{
$con=mysql_connect("localhost","root","");
    if(! $con)
    die("couldn't connect to database");
    mysql_select_db("diary",$con) or die ("cannot select db");

    if($_GET['rec_follow']!=1)
    {
    $r="select username from user where user.d_id='".$_GET[follow_id]."'";
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
    
    }
    
    $del1="delete from recommend_final where username='".$_SESSION[uid]."' and follow_name='".$r2[username]."'";
    mysql_query($del1);
    
    header('Location:myspace.php?opt=7');
    }
    
    else 
    {
    $i="insert into followed (username,followed_username,follow_date) values ('$_SESSION[uid]','$_GET[follow_id]',CURDATE())";
    mysql_query($i);
    
    $u1="update user set num_people_following=num_people_following+1 where username='".$_GET[follow_id]."'";
    mysql_query($u1);
    
    $u2="update pages set num_of_people_following=num_of_people_following+1 where username='".$_GET[follow_id]."'";
    mysql_query($u2);
    
    
    $del1="delete from recommend_final where username='".$_SESSION[uid]."' and follow_name='".$_GET[follow_id]."'";
    mysql_query($del1);
    
    header('Location:myspace.php?opt=8');
    }
    
}
?>
