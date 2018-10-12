<?php
	session_start();
	
	if(!isset($_SESSION['phonenumber']))
		header("location:http://localhost/dbook/dbookhome.php");
		
	include("connectionwithdbook.php");
	
if(isset($_GET['pid']))
{
	$pid = $_GET['pid'];
	
	$uid = $_SESSION['uid'];
	
	$forcheck = mysql_query("select likedid from postdislikeduser where postid = $pid and userid = $uid");
	
	if(mysql_num_rows($forcheck)>0)
	{
	
		$result1 = mysql_query("select * from userpost where postid = $pid");
		
		$row1 = mysql_fetch_array($result1);
		
		$postlike1 = $row1['post_dislike'];
		
		$postlike1--;
		
		$ans1 = mysql_query("update userpost set post_dislike = $postlike1 where postid = $pid");
		
		$ans2 = mysql_query("delete from postdislikeduser where postid=$pid and userid = $uid");
	}
	else
	{
		$result = mysql_query("select * from userpost where postid = $pid");
		
		$row = mysql_fetch_array($result);
		
		$postlike = $row['post_dislike'];
		
		$postlike++;
		
		$ans3 = mysql_query("update userpost set post_dislike = $postlike where postid = $pid");
		
		$ans3 = mysql_query("insert into postdislikeduser (postid , userid ) value ($pid,$uid)");
	}
}

?>