<?php

	session_start();
	
	if(!isset($_SESSION['phonenumber']))
		header("location:localhost/dbook/userprofile.php");
		
	include("connectionwithdbook.php");

	$uid = $_SESSION['uid'];
	
?>
<html>
<head>
	<title>Profile</title>
	
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<script src="bootstrap/js/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
</head>

<body>

<!--part 1-->


<div class="container-fluid">
	<div class="col-md-2">
			<center><img src="dbookimage/1.jpg" class="img-circle" style="width:150px;height:150px;border:1px solid grey"></center>
	</div>
		<div style="margin-top:40px;">
			<div class="col-md-1">
			<?php
				$result = mysql_query("select sum(post_like) from userpost where userid = $uid");
				
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
					$result1 = mysql_query("select sum(post_dislike) from userpost where userid = $uid");
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
					$result3 = mysql_query("select * from userpost where userid = $uid");
					$totalpost = mysql_num_rows($result3);
					echo "<center>Total Post</center><br>";
					echo "<center>".$totalpost."</center>";
			?>

				</div>
			
				<div class="col-md-2">
				
			<?php
					$result5 = mysql_query("select * from friend where userid = $uid");
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
					$result6 = mysql_query("select * from friend where frienduserid = $uid ");
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
					$result4 = mysql_query("select * from user where userid = $uid");
					$opendate = mysql_fetch_array($result4);
					echo "<center>Since</center><br>";
					echo "<center>".$opendate['open_ac_date']."</center>";
			?>

				</div>
			
			</div>		
				
</div>
	
	<div class=" well text-center" style="clear:both;">
			
			<?php echo strtoupper($_SESSION['firstname'])."  ".strtoupper($_SESSION['surname']);?>
	</div>
</div>
<!--part 2-->



</body>
</html>
<div class="col-md-2">
					Select Your Image :
			</div>
	<div class="col-md-1">
		<form action="#" method="post" enctype="multipart/form-data">
				 <input type="file" >
		</form>
	</div>