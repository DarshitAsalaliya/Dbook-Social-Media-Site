<?php


	session_start();
	
	if(!isset($_SESSION['phonenumber']))
		header("location:http://localhost/dbook/dbookhome.php");
		
	
	include("connectionwithdbook.php");
	
	$pid = $_GET['pid'];

		$ptitle = $_GET['posttitle'];
		$pdesc = $_GET['postdescription'];
		$ptopic = $_GET['posttopic'];
		
		$ans = mysql_query("update userpost set posttitle = '$ptitle'  where postid = $pid");
		$ans = mysql_query("update userpost set postdescription = '$pdesc'  where postid = $pid");
		$ans = mysql_query("update userpost set posttopic = '$ptopic'  where postid = $pid");
		
		if($ans == 1)
		{
			echo "<script>alert('Post Updated')</script>";
		}
		
	
?>
	