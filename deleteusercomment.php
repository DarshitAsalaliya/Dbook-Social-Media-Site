<?php

	session_start();
	
	if(!isset($_SESSION['phonenumber']))
		header("location:http://localhost/dbook/dbookhome.php");
		
	include("connectionwithdbook.php");
	
	$cid = $_GET['cid'];
	
	$uid = $_SESSION['uid'];
	
	mysql_query("delete from comment where commentid = $cid");
	
?>
