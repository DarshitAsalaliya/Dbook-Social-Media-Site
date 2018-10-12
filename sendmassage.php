<?php
	
	session_start();
	
	if(!isset($_SESSION['phonenumber']))
		header("location:http://localhost/dbook/dbookhome.php");
		
	
	include("connectionwithdbook.php");
	
	
	$friendid = $_POST['friendid'];
	
	
	$userid = $_SESSION['uid'];
	$massage = $_POST['msg'];
	
	$ans = mysql_query("insert into massage (massage , friendid , userid ,sendtime) value ('$massage',$friendid,$userid,now())");
	
	
	if($ans == 1)
	{
		
		header("location:http://localhost/dbook/usermassagehistroy.php");
	}
?>