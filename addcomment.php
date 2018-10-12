<?php
	session_start();
	
	if(!isset($_SESSION['phonenumber']))
		header("location:http://localhost/dbook/dbookhome.php");
		
	
	include("connectionwithdbook.php");
	
	$uid = $_SESSION['uid'];
	$pid = $_POST['postid'];
	$comment = $_POST['comment'];
	
	$ans = mysql_query("insert into comment (comment , postid , userid , commenttime) value ('$comment',$pid,$uid,now())");

	if($ans==1)
	{
		header("location:http://localhost/dbook/userhome.php");
	}
	
?>