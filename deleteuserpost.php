<?php

	session_start();
	
	if(!isset($_SESSION['phonenumber']))
		header("location:http://localhost/dbook/dbookhome.php");
		
	include("connectionwithdbook.php");
	
	$pid = $_GET['pid'];
	
	$uid = $_SESSION['uid'];
	
	mysql_query("delete from postlikeduser where postid = $pid and userid = $uid");
	
	mysql_query("delete from postdislikeduser where postid = $pid and userid = $uid");
	
	mysql_query("delete from userpost where postid = $pid");


?>
