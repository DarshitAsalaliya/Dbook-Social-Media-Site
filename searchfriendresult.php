<?php
	session_start();
	
	if(!isset($_SESSION['phonenumber']))
		header("location:localhost/dbookhome.php");
		
	include("connectionwithdbook.php");
	
	
	$uid = $_SESSION['uid'];
	
	
	if(isset($_POST['addfriend']))
	{
	
		$fid = $_POST['fid'];

		$check = mysql_query("select * from friend where frienduserid = $fid and userid = $uid");
		
		
		if($fid==$uid)
		{
			echo "<script>alert('You Can Not Follow Own')</script>";
			
			//header("location:http://localhost/dbook/searchfriendresult.php");
		}
		elseif(mysql_num_rows($check)>0)
		{
			echo "<script>alert('You Are Alredy Follow')</script>";
		}
		else
		{
			if($fid!=$uid)
			{	
				$ans = mysql_query("insert into friend (frienduserid,userid) value ($fid,$uid)");
					
					if($ans==1)
					{
						echo "<script>alert('Now You Are Following')</script>";
					}
				
			}
		}
	}
	
	$friendname = $_POST['friendname'];

	
	$result = mysql_query("select * from user where firstname like '$friendname%'");

	
	
	
?>

<html>
<head>
	<title>Friend</title>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<script src="bootstrap/js/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container ">

<center><h2>Friend</h2></center>
</div>
<div class="container">
	<table class="table table-hover">
	<tr>
		<th>SUGGESTED FRIEND</th>
		<th >FOLLOW</th>
		<th>VIEW</th>
	</tr>
<?php

	
	$num = mysql_num_rows($result);
	
	if(empty($num))
	{
			echo "<center>No Result Found</center>";
	}
	else
	{
			for($i=1;$i<=$num;$i++)
			{
				$row = mysql_fetch_array($result);

?>	
<form action="#" method="post">
	<tr>
		<td><?php echo strtoupper($row['firstname'])."   ".strtoupper($row['surname'])?></td>
		
		
		<td>
	
			<input type="hidden" value="<?php echo $row['userid']?>" name="fid">
			<button class="btn btn-primary" style="width:40px;height:40px;margin-left:15px;" name="addfriend" value="<?php echo $row['userid']?>">
	
					<i class="glyphicon glyphicon-plus"></i>
			</button>
		
			</td>
	</form>	
		<td><form method="post" action="viewfriendsdetail.php">
			<input type="hidden" value="<?php echo $row['userid'];?>" name="friendid">
			<button class="btn btn-warning" style="width:40px;height:40px;" >
					<i class="glyphicon glyphicon-user"></i>
			</button>
			</form>
		</td>
		
		
	</tr>
<?php  } } ?>
	</table>
</div>
<script>
function followfriend(fid)
{
	
	var req = new XMLHttpRequest();
	
	req.open("get","http://localhost/dbook/followfriend.php?fid="+fid,true);
	
	req.send();
	alert('Now You Are Following');
		
}


</script>
</body>



</html>