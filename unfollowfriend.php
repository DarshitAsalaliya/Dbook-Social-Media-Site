<?php
	session_start();
	
	if(!isset($_SESSION['phonenumber']))
		header("location:localhost/dbookhome.php");
		
	include("connectionwithdbook.php");
	
	$uid = $_SESSION['uid'];
	$fid = $_GET['fid'];

	$check = mysql_query("select * from friend where frienduserid = $fid and userid = $uid");
	
	if(mysql_num_rows($check)>0)
	{
		mysql_query("delete from friend where frienduserid = $fid and userid = $uid");
	}
?>