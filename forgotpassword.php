<?php
session_start();

include("connectionwithdbook.php");


	if(isset($_POST['change']))
	{		echo $phone1;
			echo "<script>alert('Code Sent')</script>";

			$usercode = $_POST['verificationcode'];
			$userphone = $_POST['userphone'];
			$newpass = $_POST['newpass1'];
			$resultuid = mysql_query("select*from user where phonenumber = $phone");
			$rowforuid = mysql_fetch_array($resultuid);
			$uid = $rowforuid['userid'];
			$resultcode = mysql_query("select * from codemassage where userid = $uid order by mid desc limit 1");
			$rowcode = mysql_fetch_array($resultcode);
			$code = $rowcode['massage'];
			if($code==$usercode)
			{
				$ans = mysql_query("update user set password = '$newpass' where phonenumber=$userphone");
				
				if($ans==1)
				{
					echo "<script>alert('Password Changed..')</script>";
				}
			
			}
			
	
	
	}

	if(isset($_POST['sendcode']))
	{	$phone1 = mysql_real_escape_string($_POST['phone1']);
		$resultuid = mysql_query("select*from user where phonenumber = $phone1");
		$_SESSION['rphone'] = $phone1;
		
		if(mysql_num_rows($resultuid)==0)
		{
			echo "<script>alert('Phone is Wrong.')</script>";
		}
		else
		{
		
			$rowforuid = mysql_fetch_array($resultuid);
			$uid = $rowforuid['userid'];
			$code = mt_rand();
			
			$ans = mysql_query("insert into codemassage (massage , userid , codetime) value ('$code',$uid,now())");
			
			if($ans==1)
			{
				
				echo "<script>alert('Code Sent..')</script>";
				header("location:http://localhost/dbook/checkcode.php");
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
<div class="container" style="width:60%;" id="1">
<table class="table">
<form action="#" method="post" >
<tr>
				<input type="text" class="form-control" name="phone1" id="recevephone" style="margin-top:10px;font-size:10px;"placeholder="Enter Reference DboOk A/C Phone Number" />
				
</tr>
<tr>
				<input type="submit" value="Send Code" name="sendcode"class="btn btn-success form-control" style="margin-top:20px;" onclick="disp1()">

</tr>
</form>

</table>
</div>
<div id="2" class="container" style="width:60%;display:none;">
<table class="table">
<form action="#" method="post">
<tr>
				<input type="text" class="form-control" name="userphone" style="margin-top:10px;font-size:10px;"placeholder="Enter Your Phone Number" id="6"/>
				
							
</tr>
<tr>

				<input type="password" class="form-control" name="verificationcode"  style="margin-top:10px;" placeholder="Enter Verification Code" id="7"/>
</tr>
<tr>

</tr>
<tr>

		<input type="password" class="form-control" name="newpass1" style="margin-top:10px;" placeholder="Enter New Password" id="8"/>
	
</tr>
<tr>
		<input type="submit" value="Change" name="change"class="btn btn-success form-control" style="margin-top:20px;" onclick="disp2()">
</tr>
</form>
</div>
</div>


<script>

	function disp1()
	{
	
		var rphone = document.getElementById('recevephone').value;
		
		var req = new XMLHttpRequest();
		
		req.open("get","http://localhost/dbook/sendcode.php?phone1="+rphone,true);
	
		req.send();
		
		
		
	}
</script>

</body>


</html>