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
		
	}
	else
	{
		if($fid!=$uid)
		{
			mysql_query("insert into friend (fid,frienduserid,userid) values ('',$fid,$uid)");
		}
	}
	
?>