<?php
	
	session_start();
	
	if(!isset($_SESSION['phonenumber']))
		header("location:http://localhost/dbook/dbookhome.php");
		
	
	include("connectionwithdbook.php");
	
	$uid = $_SESSION['uid'];
	mysql_query("update countreceivemsg set totalreceivemsg = 0 where userid = $uid");

	
	if(isset($_POST['deletesmsg']))
	{
		echo"<script>ans2=confirm('Are You Sure Delete All Sent Massage?')</script>";
		echo"<script>if(ans2==1){";
				
		$ans = mysql_query("delete from sendmassage where userid = $uid");
		
		if($ans==1)
		{
			echo"alert('All Sent Massage Deleted')";
			
			
			
		}
		echo "location.reload()";
		echo"}</script>";
		
		
	}
	
	
	if(isset($_POST['deletermsg']))
	{
		
		echo"<script>ans=confirm('Are You Sure Delete All Receive Massage?')</script>";
		echo"<script>if(ans==1){";
				
		$ans1 = mysql_query("delete from receivemassage where friendid = $uid");
		
		if($ans1==1)
		{
			echo"alert('All Received Massage Deleted')";
            echo "location.reload()";
		//	header("location:http://localhost/dbook/usermassagehistroy.php");
		
		}
			
		echo"}</script>";
		
		
	}
	
	
?>
<html>
<head>
	<title>Massage Histroy</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<script src="bootstrap/js/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
	
</head>
<body>

<div class="container-fluid well text-center">
	<h4>Massage History</h4><a href="userhome.php">Back..</a>
</div>

<div class="container-fliud">


<?php

				$result = mysql_query("select * from sendmassage where userid = $uid order by mid desc");
				
				$num = mysql_num_rows($result);



?>
	<div class="col-md-6">
	
	<form actio="#" method="post"><button type="submit" name="deletesmsg"class="btn btn-danger"style="width:100%;margin-bottom:10px;">Delete All Sent Massage</button></form>	
	
	
		<div class="panel panel-info" >
		
			<div class="panel-heading">
			
					Sent Massages<h3 class="badge" style="margin-left:10px;"><?php echo $num;?></h3>
			
			</div>
			
			<div class="panel-body">
			
		<?php
		
				
				
				for($i=1;$i<=$num;$i++)
				{
				
					$row = mysql_fetch_array($result);
					$fid = $row['friendid'];
					$result1 = mysql_query("select * from user where userid = $fid");
					$row1 = mysql_fetch_array($result1);
					
					
					
					
		?>
				<div class="well">
					<?php echo $row['massage']."<br><br>"?>
					<div ><?php echo "To : <b>".strtoupper($row1['firstname'])."</b>  ".$row['sendtime']?>
					<button value="<?php echo $row['mid']?>" class="btn" style="float:right;"onclick="deletesendmassage(this.value)"><i class="glyphicon glyphicon-trash"></i></button></div>
					
				</div>
			
		<?php  } ?>
			</div>
		
		</div>
	
	
	</div>
		
<?php 

		$result3 = mysql_query("select * from receivemassage where friendid = $uid order by mid desc");
				
		$num3 = mysql_num_rows($result3);


?>
	<div class="col-md-6">
	
	<form actio="#" method="post"><button type="submit" name="deletermsg"class="btn btn-danger"style="width:100%;margin-bottom:10px;">Delete All Received Massage</button></form>	
		<div class="panel panel-warning">
		
			<div class="panel-heading">
			
					Received Massages<h3 class="badge" style="margin-left:10px;"><?php echo $num3;?></h3>
			
			</div>
			
			<div class="panel-body">
			
		<?php
		
			
				
				$resultforcode = mysql_query("select*from codemassage where userid=$uid order by mid desc limit 1");
				
				$numcodemassage = mysql_num_rows($resultforcode);
				
				$rowforcode = mysql_fetch_array($resultforcode);
				
				if($numcodemassage!=0)
				{
		?>
				<div class="well">
					<?php echo "Code For Change Password : ".$rowforcode['massage']."<br><br>"?>
					<div ><?php echo "From : DboOk"?>
					<button value="<?php echo $row3['mid']?>" class="btn" style="float:right;"><i class="glyphicon glyphicon-trash"></i></button></div>
					
					
				</div>
			
		<?php	
				}
				for($j=1;$j<=$num3;$j++)
				{
				
					$row3 = mysql_fetch_array($result3);
					$userid = $row3['userid'];
					$result4 = mysql_query("select * from user where userid = $userid");
					$row4 = mysql_fetch_array($result4);
					
					
					
					
		?>
				<div class="well">
					<?php echo $row3['massage']."<br><br>"?>
					<div><?php echo "From : <b>".strtoupper($row4['firstname'])."</b>  ".$row3['sendtime']?>
					<button value="<?php echo $row3['mid']?>" class="btn" style="float:right;" onclick="deletereceivemassage(this.value)"><i class="glyphicon glyphicon-trash"></i></button></div>
					
					
				</div>
			
		<?php  } ?>
			</div>
		
		</div>
	
	
	</div>
		
	

</div>
<script>

	function deletesendmassage(mid)
	{
		var req = new XMLHttpRequest();
		
		req.open("get","http://localhost/dbook/deletemassage.php?mid="+mid,true);
	
		req.send();
		
		refresh();
	}
	function deletereceivemassage(mid)
	{
		
		var req = new XMLHttpRequest();
		
		req.open("get","http://localhost/dbook/deletemassage.php?mid1="+mid,true);
	
		req.send();
		
		refresh();
	}

	function refresh()
	{
		location.reload();
	}








</script>
</body>
</html>