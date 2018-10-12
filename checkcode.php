<?php
session_start();

if(!isset($_SESSION['rphone']))
	header("location:http://localhost/dbook/dbookhome.php");


include("connectionwithdbook.php");

	
	
	if(isset($_POST['change']))
	{		
			$rphone =  $_SESSION['rphone'];
			$usercode = $_POST['verificationcode'];
			$userphone = $_POST['userphone'];
			$newpass = $_POST['newpass1'];
			$resultuid = mysql_query("select*from user where phonenumber = $rphone");
			$rowforuid = mysql_fetch_array($resultuid);
			$uid = $rowforuid['userid'];
			$resultcode = mysql_query("select * from codemassage where userid = $uid order by mid desc limit 1");
			$rowcode = mysql_fetch_array($resultcode);
			$code = $rowcode['massage'];
			if($usercode==$code)
			{
				$ans = mysql_query("update user set password = '$newpass' where phonenumber=$userphone");
				
				if($ans==1)
				{
					echo "<script>alert('Password Changed..')</script>";
					mysql_query("delete from codemassage where userid = $uid");
				}
				else
				{
					echo "<script>alert('Password Not Changed Try Again..')</script>";
				
				}
			
			}
			
	
	
	}

	

?>


<html>
<head>
<title>
	Forgot Password
</title>

        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<script src="bootstrap/js/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>

</head>
<div class="container-fluid text-center well">
	Forgotten Password
</div>
<body>

<div id="2" class="container" style="width:60%;">
<table class="table">

<form action="#" method="post">

<tr>
				<input type="text" class="form-control" name="userphone" style="margin-top:10px;"placeholder="Enter Your Phone Number" />
				
							
</tr>
<tr>

				<input type="password" class="form-control" name="verificationcode"  style="margin-top:10px;" placeholder="Enter Verification Code" />
</tr>
<tr>

</tr>
<tr>

		<input type="password" class="form-control" name="newpass1" style="margin-top:10px;" placeholder="Enter New Password" />
	
</tr>
<tr>
		<input type="submit" value="Change" name="change"class="btn btn-success form-control" style="margin-top:20px;">
</tr>
</form>
</div>
</div>



</body>


</html>