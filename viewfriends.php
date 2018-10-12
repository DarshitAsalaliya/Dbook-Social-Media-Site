<?php
	session_start();
	
	if(!isset($_SESSION['phonenumber']))
		header("location:localhost/dbookhome.php");
		
	include("connectionwithdbook.php");
	
	$uid = $_SESSION['uid'];
	$friendname = $_POST['friendname'];

	$result = mysql_query("select * from user where userid in(select userid from friend where frienduserid=$uid)");

	
	if(isset($_POST['blockfriend']))
	{
		$fid = $_POST['friendid'];
		
		$ans = mysql_query("delete from friend where frienduserid = $uid and userid = $fid");
		
		if($ans==1)
		{
			echo "<script>alert('Follower Remove')";
			echo "location.reload()</script>";
		}
	}
	
	
	
?>
<html>
<head>
	<title>Followers</title>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<script src="bootstrap/js/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container ">



<?php
					$result5 = mysql_query("select * from friend where frienduserid = $uid");
					$totalfriend = mysql_num_rows($result5);
					if(empty($totalfriend))
					{
						$totalfriend = 0;
					}
?>
			
			<center><h2><?php echo $totalfriend."  ";?>Followers</h2></center><div style="float:right;margin-right:-100px;"><h4><a href="userhome.php">Back..</a></h4></div>
</div>
<div class="container-fluid">
	<table class="table table-hover">
	<tr style="font-size:13px;">
		<th>IMAGE</th>
		<th>SUGGESTED FRIEND</th>
		<th>SEND MASSAGE</th>
		<th >REMOVE</th>
		<th>VIEW</th>
	</tr>
<?php

	
	$num = mysql_num_rows($result);
	
	if(empty($num))
	{
			echo "<center>No Friends</center>";
	}
	else
	{
			for($i=1;$i<=$num;$i++)
			{
				$row = mysql_fetch_array($result);
				$row7 = mysql_fetch_array($result5);
?>	
	
	
			
		
	
	
	<tr>
		<td><img src="userprofileimage/<?php echo $row['userimage'];?>" style="width:50px;height:50px;" class="img-circle"></td>
		<td style="width:10px;"><?php echo strtoupper($row['firstname'])."   ".strtoupper($row['surname'])?></td>
	<form action="sendmassage.php" method="post">
	
	<?php
		
		
	?>
	
	
	
		
			<td>
			
			<div style="float:left;width:70%;">
				<input type="hidden" value="<?php echo $row7[2];?>" name="friendid">
		
				
				<input type="text" placeholder="Send Massage.." class="form-control" style="width:100%;margin-top:3px;" name="msg">
			</div>
					
					<button type="submit"class="btn btn-primary" style="width:40px;height:40px;"><i class="glyphicon glyphicon-send"></i></button></td>
	</form>
	
		<td>
	<form action="#" method="post">
		<input type="hidden" value="<?php echo $row7[2];?>" name="friendid">
		<button class="btn btn-danger" style="width:40px;height:40px;margin-left:16px;" value="<?php echo $row['userid']?>" name="blockfriend"><i class="glyphicon glyphicon-trash"></i></button>
	</form>
		</td>
		<td>
		<form action="viewfriendsdetail.php" method="post">
		<input type="hidden" value="<?php echo $row7[2];?>" name="friendid">
		<button class="btn btn-warning" style="width:40px;height:40px;margin-left:-3px;"><i class="glyphicon glyphicon-user"></i></button>
		</form>
		</td>
		<?php } ?>
		
	</tr>
<?php  }  ?>
	</table>
</div>
<script>
function followfriend(fid)
{
	ans = confirm('Are You Sure Unfollow This Friend?');
	if(ans==1)
	{
		var req = new XMLHttpRequest();
		
		req.open("get","http://localhost/dbook/unfollowfriend.php?fid="+fid,true);
		
		req.send();
		alert('Friend Unfollow');
	}
	refresh();
		
}
function refresh()
{
	location.reload();
}


</script>
</body>



</html>