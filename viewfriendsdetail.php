<?php

	session_start();
	
	if(!isset($_SESSION['phonenumber']))
		header("location:localhost/dbook/userprofile.php");
		
	include("connectionwithdbook.php");
	
	$uid = $_SESSION['uid'];

	$fid = $_POST['friendid'];


?>
<html>
<head>
	<title>Profile</title>
	
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<script src="bootstrap/js/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		
		
	<style>
		
			.profileimageanimation
			{
					animation : moveimg 1s ease-in-out 5;
			}
			@keyframes moveimg
			{
					0%{transform:scale(1)}
					50%{transform:scale(0.8);}
					100%{transform:scale(1);}
					
			}
			
			
		
	</style>
	
<script>
	
	function refresh()
	{
		location.reload();
	}
	
</script>
</head>

<body>

<!--part 1-->


<div class="container-fluid">
	<div class="col-md-2 profileimageanimation" >
	
<?php 
		
		$result = mysql_query("select*from user where userid = $fid");
		
		$num = mysql_num_rows($result);
		
		$row = mysql_fetch_array($result);

?>
	
	
		<center><img src="userprofileimage/<?php echo $row['userimage']?>" class="img-circle" style="width:150px;height:150px;border:1px solid grey"></center>
	</div>
		<div style="margin-top:40px;">
			<div class="col-md-1">
			<?php
				$result = mysql_query("select sum(post_like) from userpost where userid = $fid");
				
				$row = mysql_fetch_array($result);
				
				$totallike = $row[0];
				if(empty($totallike))
				{
					$totallike = 0;
				}
				echo "<center>Total Likes</center><br>";
				echo "<center>".$totallike."</center>";
				
			?>
				</div>
				<div class="col-md-2">
			<?php
					$result1 = mysql_query("select sum(post_dislike) from userpost where userid = $fid");
					$row1 = mysql_fetch_array($result1);
					$totaldislike = $row1[0];
					if(empty($totaldislike))
					{
						$totaldislike = 0;
					}
					echo "<center>Total Dislikes</center><br>";
					echo "<center>".$totaldislike."</center>";
					
			?>
				</div>
				<div class="col-md-1">
				
			<?php
					$result3 = mysql_query("select * from userpost where userid = $fid");
					$totalpost = mysql_num_rows($result3);
					echo "<center>Total Post</center><br>";
					echo "<center>".$totalpost."</center>";
			?>

				</div>
			
				<div class="col-md-2">
				
			<?php
					$result5 = mysql_query("select * from friend where userid = $fid");
					$totalfriend = mysql_num_rows($result5);
					if(empty($totalfriend))
					{
						$totalfriend = 0;
					}
					echo "<center>Total Following</center><br>";
					echo "<center>".$totalfriend."</center>";
			?>

				</div>
				<div class="col-md-2">
				
			<?php
					$result6 = mysql_query("select * from friend where frienduserid = $fid ");
					$totalfollowers = mysql_num_rows($result6);
					if(empty($totalfollowers))
					{
						$totalfollowers = 0;
					}
					echo "<center>Total Followers</center><br>";
					echo "<center>".$totalfollowers."</center>";
			?>

				</div>
				<div class="col-md-2">
				
			<?php
					$result4 = mysql_query("select * from user where userid = $fid");
					$opendate = mysql_fetch_array($result4);
					echo "<center>Since</center><br>";
					echo "<center>".$opendate['open_ac_date']."</center>";
			?>

				</div>
			
			</div>		
				
</div>
	
	<div class=" well text-center " style="clear:both;">
			
			<?php echo strtoupper($opendate['firstname'])."  ".strtoupper($opendate['surname']);?>
	</div>
</div>
<!--part 2-->



	
		



<div class="well text-center" style="margin-top:10px;"><b>Details</div></b>
<div class="container" style="width:60%;margin-top:10px;">
	
	<table class="table table-hover text-center">
		
	
		<tr>
					<td>Firstname : </td>
					<td><?php echo $opendate['firstname'];?></td>
		</tr>
		<tr>
					<td>Surname :</td>
					<td><?php echo $opendate['surname'];?></td>
		
		</tr>
		<tr>
					<td>Phone Number :</td>
					<td><?php echo $opendate['phonenumber'];?></td>
		
		</tr>
		<tr>
					<td>Birth Day :</td>
					<td><?php echo $opendate['birthday'];?></td>
		
		</tr>
		<tr>
					<td>Birth month :</td>
					<td><?php echo $opendate['birthmonth'];?></td>
		</tr>
		<tr>
		
					<td>Birth Year :</td>
					<td><?php echo $opendate['birthyear'];?></td>
		</tr>
		<tr>
					<td>Gender :</td>
					<td><?php echo $opendate['gender'];?></td>
		
		</tr>

	</table>





</div>

</body>
</html>
