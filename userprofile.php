<?php

	session_start();
	
	if(!isset($_SESSION['phonenumber']))
		header("location:localhost/dbook/userprofile.php");
		
	include("connectionwithdbook.php");
	
	$uid = $_SESSION['uid'];

	
	if(isset($_POST['update']))
	{
		$fname = $_POST['firstname'];
		$sname = $_POST['surname'];
		
		$ans = mysql_query("update user set firstname = '$fname' where userid = $uid");
		$ans = mysql_query("update user set surname = '$sname' where userid = $uid");

		
		if($ans==1)
		{
			header("location:http://localhost/dbook/userprofile.php");
			//header("location:http://localhost/dbook/profileupdatesuccess.php");
		}
		else
		{
			echo "<script>alert('Some Problem Try Again..')</script>";
		}
	
	}
	if(isset($_POST['Upload']))
	{
			$file = $_FILES['userimage'];
			$fname = uniqid().$_FILES['userimage']['name'];
			$ftype = $_FILES['userimage']['type'];
			
		if($file['type'] == "image/jpeg")
		{
			move_uploaded_file($file['tmp_name'],"userprofileimage/".$fname);
			
			$ans = mysql_query("update user set userimage='$fname' where userid = $uid");
		
			if($ans==1)
			{
				//header("location:http://localhost/dbook/profilechangesuccess.php");
				header("location:http://localhost/dbook/userprofile.php");
			}
		}
		else
		{
			echo "<script>alert('Please Select jpg image')<script>";
		}
	
	
	}
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
		
		$result = mysql_query("select*from user where userid = $uid");
		
		$num = mysql_num_rows($result);
		
		$row = mysql_fetch_array($result);

?>
	
	
		<center><img src="userprofileimage/<?php echo $row['userimage']?>" class="img-circle" style="width:150px;height:150px;border:1px solid grey"></center>
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
	
	<div class=" well text-center " style="clear:both;">
			
			<?php echo strtoupper($opendate['firstname'])."  ".strtoupper($opendate['surname']);?><center><h4 style="float:right;margin-top:20px;"><a href="userhome.php">Back..</a></h4></center>
	</div>
</div>
<!--part 2-->

<div class="container-fluid">

	<div class="col-md-3" >
			<table class="table text-centertable-responsive">
						<tr>
							<td colspan="2">Select Profile Image :</td>
							
			</tr>
			<tr>
						<td><form action="#" method="post" enctype="multipart/form-data">
							<input type="file" name="userimage" required>
						
						</td>
						<td class="text-left"><input type="submit" value="Upload" name="Upload" class="btn btn-success"></form></td>
						
			</tr>
			<tr>
		

	</div>

	</table>
	<div class="col-md-9">
			
	</div>
	
		
	
</div>
<div>
	
		<td><button class="btn btn-primary" value="<?php echo $uid; ?>" style="width:100%;" data-toggle="modal" data-target="#modal1">Update Profile</button></td>
	
		
<div class="modal fade" id="modal1">
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<div class="modal-title text-center">
				Edit Profile<button class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
			
	<?php
			$result = mysql_query("select*from user where userid = $uid");

			$row1 = mysql_fetch_array($result);
		
	?>	
			
			
			
<form action="#" method="post" enctype="multipart/form-data">
					<div>Firstname :<input type="text" name="firstname" class="form-control" value="<?php echo $row1['firstname'];?>" required pattern="^[a-zA-Z]+" title="Enter Only Alphabet"> </div>
				
					<div style="margin-top:20px;">Surname :<input type="text" name="surname" class="form-control" value="<?php echo $row1['surname'];?>" required  pattern="^[a-zA-Z]+" title="Enter Only Alphabet"></div>
				
						<input type="submit" value="Update" name="update" class="form-control btn btn-success" style="width:100%;margin-top:20px;">
</form>
					</div>
			</div>
		</div>
	</div>
</div>
	
</div>



<div class="well text-center" style="margin-top:10px;"><b>About Me</div></b>
<div class="container" style="width:60%;margin-top:10px;">
<div class="row">
	<table class="table table-hover text-center">
		
	
		<tr>
					<td>Firstname : </td>
					<td><?php echo $row1['firstname'];?></td>
		</tr>
		<tr>
					<td>Surname :</td>
					<td><?php echo $row1['surname'];?></td>
		
		</tr>
		<tr>
					<td>Phone Number :</td>
					<td><?php echo $row1['phonenumber'];?></td>
		
		</tr>
		<tr>
					<td>Birth Day :</td>
					<td><?php echo $row1['birthday'];?></td>
		
		</tr>
		<tr>
					<td>Birth month :</td>
					<td><?php echo $row1['birthmonth'];?></td>
		</tr>
		<tr>
		
					<td>Birth Year :</td>
					<td><?php echo $row1['birthyear'];?></td>
		</tr>
		<tr>
					<td>Gender :</td>
					<td><?php echo $row1['gender'];?></td>
		
		</tr>

	</table>





</div>
</div>
</body>
</html>
