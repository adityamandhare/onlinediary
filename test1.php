<?php
session_start();   
error_reporting(E_PARSE);
if($_SESSION['logged_in']==1)
{

$con=mysql_connect("localhost","root","");
    if(! $con)
    die("couldn't connect to database");
    mysql_select_db("diary",$con) or die ("cannot select db");

    for($i=1;$i<10;++$i)
    {
    echo("page id=".$_SESSION['pg'][$i]);	
    }
}
?>
