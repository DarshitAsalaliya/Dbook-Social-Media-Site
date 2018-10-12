<?php
	
	session_start();
	
	if(!isset($_SESSION['phonenumber']))
		header("location:http://localhost/dbook/dbookhome.php");
		
	
	include("connectionwithdbook.php");
	
	$uid = $_SESSION['uid'];
	
	if(isset($_GET['mid']))
	{
		$mid = $_GET['mid'];
		mysql_query("delete from sendmassage where mid = $mid");
	}
	
	if(isset($_GET['mid1']))
	{
		$mid = $_GET['mid1'];
		mysql_query("delete from receivemassage where mid = $mid");
	}
	
	
	
	
	
	
?>