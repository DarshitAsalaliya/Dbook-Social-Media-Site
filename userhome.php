<?php
	session_start();
	
	if(!isset($_SESSION['phonenumber']))
		header("location:http://localhost/dbook/dbookhome.php");
		
	
	include("connectionwithdbook.php");
	$uid = $_SESSION['uid'];
	if(isset($_POST['submit']))
	{
		$ptitle = $_POST['posttitle'];
		$pimage = $_FILES['myfile'];
		$postdescription = $_POST['postdescription'];
		$posttopic = $_POST['topic'];
		$uid = $_SESSION['uid'];
		$pname = uniqid().$_FILES['myfile']['name'];
		$ptype = $_FILES['myfile']['type'];
	
		if($pimage['type']=="image/jpeg")
		{

			if($pimage['size']>50000)
			{
			
			
					move_uploaded_file($pimage['tmp_name'],"postimage/".$pname);
				
					$ans = mysql_query("insert into userpost (posttitle , postimage , postdescription , posttopic , post_time , post_like, post_dislike , userid , posttype) value ('$ptitle','$pname','$postdescription','$posttopic',now(),0,0,$uid,'$ptype')");
				
					if($ans==1)
					{
						echo "<script>alert('Post Uploaded..')</script>";
						header("location:http://localhost/dbook/postuploadsuccess.php");
					}
			}
			else
			{
					echo "<script>alert('Please Select High Quality Image')</script>";
			}
			

		}
		else
		{
				echo "<script>alert('Please Select JPG Image')</script>";
			
		}
		
		
	
	}
	
	
	
?>
<!DOCTYPE html>
<html>
<head>

	<title>DBOOK</title>
		
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<script src="bootstrap/js/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		
	<meta name="viewposrt" content="width=device-width,initial-scale=1.0">
</head>
<body>

<!-- part 1 -->

<div class="container-fluid well">
	<div class="col-md-1">
		<center><h4 style="color:green">WELCOME</h4></center>
	</div>
	<div class="col-md-3">

	<h5><center><?php echo strtoupper($_SESSION['firstname'])."    ".strtoupper($_SESSION['surname']);?></center></h5>
		
	</div>
<form action="searchfriendresult.php" method="post">	
	<div class="col-md-6 text-left">

		<input type="search" style="margin-top:2px;"class="form-control"placeholder="Search Friend" name="friendname"/>
	</div>
	<div class="col-md-1 ">
		<center><button type="submit" class="btn btn-primary " name="submit"style="height:38px;"><i class="glyphicon glyphicon-search"></i></button></center>

	</div>
</form> 
</div>

<!-- part 2 -->

<div class="container-fluid">
<div class="row">
	<div class="col-md-3">
						<div class="panel panel-info">
										<div class="panel-heading text-center">
												Settings
										</div>
										<div class="panel-body">
											<a href="userprofile.php">Your Profile</a>
										</div>
										<div class="panel-body">
											<a href="userpost.php">Manage Your Post</a>
										</div>
										<div class="panel-body">
											<a href="viewfollowing.php">Your Following</a>
										</div>
										<div class="panel-body">
											<a href="viewfriends.php">Your Followers</a>
										</div>
										<div class="panel-body">
											<a href="usermassagehistroy.php">Your Massages <?php 
											
																					$msgresult = mysql_query("select*from countreceivemsg where userid = $uid");
																					$msgnum = mysql_num_rows($msgresult);
																					$total = mysql_fetch_array($msgresult);
																					
																					if($total[1]!=0)
																					{
																					
																					?>
																			<h3 class="badge" style="font-size:15px;margin-left:10px;"><?php echo $total[1]?></h2>
																				<?php  } ?>
														
																		</a>
										</div>
										<div class="panel-body">
											<a href="#" data-toggle="modal" data-target="#modal1">Add New Post</a>
										</div>
										<div class="panel-body">
											<a href="dbooklogout.php">Log Out</a>
										</div>
										
							</div>
	</div>
	<div class="col-md-9 row">
	
						
										
											<div class="page-header text-center">	Your Friend's Latest Post  </div>
									
							
																			
														
									<?php 
										$userid = $_SESSION['uid'];
									
										$postresult = mysql_query("select * from userpost where userid in(select frienduserid from friend where userid=$userid) or userid=$userid order by postid desc");
										
										
										$totalpost = mysql_num_rows($postresult);
										
										for($i=1;$i<=$totalpost;$i++)
										{
											$row = mysql_fetch_array($postresult);
											$userid = $row['userid'];
											$postid= $row['postid'];
											$uname = mysql_query("select*from user where userid = $userid");
											$row1 = mysql_fetch_array($uname);
											$imagepath = $row['postimage'];
									?>
										<div class="panel" style="width:90%;margin-left:5%;margin-top:10px;">

											<div class="panel panel-heading" >
										
															<input type="hidden" value="<?php echo $row['postid']?>" id="postid">
															<h6 class="text-left well" style="width:100%" >BY : <?php echo strtoupper($row1['firstname'])." ".strtoupper($row1[2]);?></h6>
															<h6 class="text-left" >POST TITLE : <?php echo strtoupper($row['posttitle']);?></h6>
															<h6 class="text-left">POST DESCRIPTION : <?php echo $row['postdescription'];?></h6>
															<h6 class="text-left">POST DATE : <?php echo $row['post_time'];?></h6>
															<h6 class="text-left">POST TOPIC : <?php echo $row['posttopic'];?></h6>
													
											
										
										
											<?php  if($row['posttype']=="image/jpeg")
													{
													
												
											?>
												<div class="row">	<img src="postimage/<?php echo $imagepath;?>" class="img-thumbnail col-12"style="width:100%;height:380px;"/></div>
											
											
											
												
											<?php  }
												   else
												   {
											?>
													
												<div class="row">
												<video  controls="controls" width="400" src="postvideo/<?php echo $imagepath;?>">
														<source  ></source>
												</video></div>	

												
											<?php } ?>
											</div>
									<div class="panel-footer">
							<div>

			<?php 
			
				$checklike = mysql_query("select*from postlikeduser where postid = $postid and userid=$uid");
				$numcheck = mysql_num_rows($checklike);
				
				if($numcheck==0)
				{
			
			?>
							<button class="btn" style="width:40px;height:40px;background:none;border-radius:30px;" id="<?php echo $row['postid']?>" onclick="addlike(this.value)" value="<?php echo $row['postid']?>"><i class="glyphicon glyphicon-thumbs-up"></i></button>
							
			<?php } 
				else
				{
			?>
							<button class="btn btn-primary" style="width:40px;height:40px;border-radius:30px;" id="<?php echo $row['postid']?>" onclick="addlike(this.value)" value="<?php echo $row['postid']?>"><i class="glyphicon glyphicon-thumbs-up"></i></button>
							
			<?php } ?>
							
						<font style="margin-left:10px;" id="postid"><?php echo $row['post_like'];?></font>
						
						
			<?php 
			
				$checklike = mysql_query("select*from postdislikeduser where postid = $postid and userid=$uid");
				$numcheck = mysql_num_rows($checklike);
				
				if($numcheck==0)
				{
			
			?>			

					<button class="btn" style="width:40px;height:40px;margin-left:10px;background:none;border-radius:30px;"  onclick="dislike(this.value)" value="<?php echo $row['postid']?>"><i class="glyphicon glyphicon-thumbs-down"></i></button>
			<?php } 
				else
				{
			?>
					<button class="btn btn-danger" style="width:40px;height:40px;margin-left:10px;border-radius:30px;"  onclick="dislike(this.value)" value="<?php echo $row['postid']?>"><i class="glyphicon glyphicon-thumbs-down"></i></button>
			<?php } ?>		
					
							
											<font style="margin-left:10px;" id="pid"><?php echo $row['post_dislike'];?></font>
							</div>
								
							
											
									</div>	
						
									</div>
							<form action="addcomment.php" method="post">
								
									<textarea class="form-control" placeholder="Write Comment.." cols="25" rows="2" name="comment" style="width:90%;margin-left:5%;"></textarea>
								
									<input type="hidden" value="<?php echo $row['postid']?>" name="postid">
								<button type="submit" class="btn btn-success"  style="float:right;margin-right:45px;height:40px;"><i class="glyphicon glyphicon-plus"></i></button>
							</form>	
					<?php
							$postid = $row['postid'];
							
							$result6 = mysql_query("select*from comment where postid = $postid order by commentid desc");
							
							
							$num6 = mysql_num_rows($result6);
							
							
							if($num6>0)
							{?>
									<center><b>Comment : <?php echo $num6;?></b></center>
									<div style="width:80%;height:120px;;margin-left:10%;overflow:scroll">
							<?php	
							
									
									for($j=1;$j<=$num6;$j++)
									{
											$row6 = mysql_fetch_array($result6);
											$user = $row6['userid'];
											$result7 = mysql_query("select*from user where userid = $user");
											$row7 = mysql_fetch_array($result7);
									?>			
		<div class="well" style="height:100px;overflow:scroll;"><h5 style="margin-top:-8px;"><?php echo $row6['comment']; ?></h5><h6 style="float:right;margin-top:-24px;"><?php echo strtoupper($row7['firstname'])."  ".$row6['commenttime']?></h6></div>
					<?php							

						} ?>
						</div>
					
						
						<?php	}
								
					?>
							
						
							<?php } ?>
								
									
									
						</div>		
										
						</div>
	</div>
	
</div>
</div>

<!-- part 3 -->


<div class="modal fade" id="modal1">
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<div class="modal-title text-center">
				Add New Post<button class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
<form action="#" method="post" enctype="multipart/form-data">
					<input type="text" name="posttitle" class="form-control" placeholder="Enter Post Title" required pattern="^[a-zA-Z]+[_0-9\sa-zA-Z\.-]*$" title="First Char Alpha Then Use only _  Alpha  -  .  Space 0-9"> 
		

					<div style="margin-top:20px;">Post Image :<input type="file" name="myfile" style="margin-top:10px;" required></div>
					
					<textarea class="form-control" cols="20" rows="5" placeholder="Enter Post Description"style="margin-top:20px;" name="postdescription" required pattern="^[a-zA-Z]+[_0-9\sa-zA-Z\.-]*$" title="First Char Alpha Or 0-9 Then Use only _  Alpha  -  .  Space 0-9"></textarea>
					
				<div style="margin-top:10px;">Select Post Topic :</div>
					<div style="margin-top:20px;"> <select class="form-control" name="topic">
										
										<option>Education</option>
										<option>Entartainment</option>
										<option>Sport</option>
										<option>Recipy</option>
										<option>Bussiness</option>
										<option>Other</option>
								</select>
					</div>
					<div>
						<input type="submit" value="Submit" name="submit" class="form-control btn btn-success"style="width:100%;margin-top:20px;">
</form>
					</div>
			</div>
		</div>
	</div>
</div>
</div>
<script>
	function addlike(p)
	{	
		var req  = new XMLHttpRequest();
		
		req.open("get","http://localhost/dbook/addpostlike.php?pid="+p,true);
		req.send();
		refresh();
	}
	function dislike(p)
	{	
		var req  = new XMLHttpRequest();
		
		req.open("get","http://localhost/dbook/addpostdislike.php?pid="+p,true);
		req.send();
		refresh();
	}
	function deletepost(p)
	{
		var ans = confirm('Are You Sure Delete This Post ?');
		
		if(ans == 1)
		{
			var req  = new XMLHttpRequest();
			
			req.open("get","http://localhost/dbook/deleteuserpost.php?pid="+p,true);
			req.send();
		}
		
	}
	function refresh()
	{
			location.reload();
	}

</script>
</body>
</html>