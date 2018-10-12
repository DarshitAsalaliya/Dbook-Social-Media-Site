<?php
	
	session_start();
	
	if(!isset($_SESSION['phonenumber']))
		header("location:http://localhost/dbook/dbookhome.php");
		
	
	include("connectionwithdbook.php");
	
	$pid = $_POST['update'];
	

	
	
	$result1 = mysql_query("select*from user order by userid desc");
	
	$num = mysql_num_rows($result1);
	

?>




<html>
<head>
	<title>
		Update Post
	</title>

		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<script src="bootstrap/js/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid">
	<div class="col-md-6" style="margin-top:20px;;">

	
		<table class="table">
		<tr>
		
			<th colspan="2" class="well"><center>Update Post</center></th>
		
		</tr>
		
		<tr>

<?php
	$r = mysql_query("select*from userpost where postid = $pid");
	
	$row = mysql_fetch_array($r);
	
?>
	
			<td>Post Title</td>
	
			<input type="hidden"  id="0">
			<td><input type="text" value="<?php echo $row[1];?>" required class="form-control" name="posttitle" id="1" pattern="^[a-zA-Z]+[_0-9\sa-zA-Z\.-]*$" title="First Char Alpha Then Use only _  Alpha  -  .  Space 0-9"></td>
		</tr>
		<tr>
			<td>Post Descripption</td>
			<td><textarea  class="form-control" name="postdescription" id="2" required pattern="^[a-zA-Z]+[_0-9\sa-zA-Z\.-]*$" title="First Char Alpha Then Use only _  Alpha  -  .  Space 0-9"><?php echo $row['postdescription'];?></textarea></td>
		</tr>
		<tr>
		<td>Post Topic</td>
		<td><select class="form-control" name="posttopic" id="3">
										<option><?php echo $row['posttopic']?></option	>
										<option>Education</option>
										<option>Entartainment</option>
										<option>Sport</option>
										<option>Recipy</option>
										<option>Bussiness</option>
										<option>Other</option>
								</select></td>
		</tr>
		<tr>
			<td colspan="2"><button type="submit" class="btn btn-success" name="update"style="width:100%;" value="<?php echo $row['postid']?>" onclick="updatepost(this.value)">Update</button></td>

		</tr>
	<tr>
			<td colspan="2"><center><a href="userpost.php">Back..</a></center></td>
	</tr>
		</table>
	
	</div>

<div class="col-md-6" style="margin-top:20px;">
	<table class="table table-hover">
	<tr class="well">
		<th>SUGGESTED FRIEND</th>
		<th >FOLLOW</th>
		<th>VIEW</th>
	</tr>
<?php

	
	if(empty($num))
	{
			echo "<center>No Result Found</center>";
	}
	else
	{
			for($i=1;$i<=$num;$i++)
			{
				$row1 = mysql_fetch_array($result1);

?>	
	<tr>
		<td><?php echo strtoupper($row1['firstname'])."   ".strtoupper($row1['surname'])?></td>
		<td><button class="btn btn-primary" style="width:40px;height:40px;margin-left:15px;" value="<?php echo $row	['userid']?>" onclick="followfriend(this.value)"><i class="glyphicon glyphicon-plus"></button></td>
		<td><button class="btn btn-warning" style="width:40px;height:40px;"><i class="glyphicon glyphicon-user"></button></td>
		
		
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
function updatepost(pid)
{
	
	var pt = document.getElementById('1').value;
	var pd = document.getElementById('2').value;
	var ptopic = document.getElementById('3').value;
	
	
	var updaterequest = new XMLHttpRequest();
	
	updaterequest.open("get","http://localhost/dbook/finalupdatepost.php?pid="+pid+"&posttitle="+pt+"&postdescription="+pd+"&posttopic="+ptopic,true);
	updaterequest.send();
	alert('Post Updated');
	location.reload();
}

</script>
	</div>
</div>
</div>
</body>


</html>