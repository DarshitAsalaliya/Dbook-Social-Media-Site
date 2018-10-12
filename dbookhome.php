<?php 
session_start();

session_regenerate_id( true );

	include("connectionwithdbook.php");
	
	if(isset($_POST['submit']))
	{
				$fname = mysql_real_escape_string($_POST['firstname']);
			
				$surname = mysql_real_escape_string($_POST['surname']);
				
				$day = mysql_real_escape_string($_POST['day']);
				
				$month = mysql_real_escape_string($_POST['month']);
				
				$year = mysql_real_escape_string($_POST['year']);
				
				$gender = mysql_real_escape_string($_POST['gender']);
				
				$password = mysql_real_escape_string($_POST['password']);
		
				$phone = mysql_real_escape_string($_POST['userphonenumber']);
			
				
				
				
			
				if(empty($fname))
				{
					echo "<script>alert('Firstname Field Is Empty')</script>";
				}
				elseif(strlen($fname)<3)
				{
					echo "<script>alert('Enter At Least 3 Number In firstname')</script>";
				}
				else if(empty($surname))
				{
					echo "<script>alert('Surname Field Is Empty')</script>";
				}
				elseif(strlen($surname)<3)
				{
					echo "<script>alert('Enter At Least 3 Number In surname')</script>";
				}
				else if(empty($phone))
				{
					echo "<script>alert('Phone Number Field Empty')</script>";
				}	
				elseif(strlen($phone)<10 || strlen($phone)>10)
				{
					echo "<script>alert('Phone Number Is Wrong')</script>";
				}
				elseif(empty($password))
				{
					echo "<script>alert('Password Field Empty')</script>";
				}
				elseif(strlen($password)<6)
				{
					echo "<script>alert('Please Enter Password More Than 6 character')</script>";
				}
				else
				{
					
					$result = mysql_query("select * from user where phonenumber = $phone");
				
							if(mysql_num_rows($result)>0)
							{
									echo "<script>";
									echo "alert('Phone Already Exists')";
									echo "</script>";
							}
							else
							{
								$ans = mysql_query("insert into user (firstname , surname , phonenumber , gender , birthday , birthmonth , birthyear , password , open_ac_date , userimage ) value ('$fname','$surname',$phone,'$gender','$day','$month',$year,'$password',now(),'1.jpg')");	
						
									if($ans==1)
									{	
										echo "<script>";
										echo "alert('Sign Up Successesfully')";
										echo "</script>";
									}
								
							}
				}
		
	
	}
	
	if(isset($_POST['signin']))
	{	
				$phone1 = mysql_real_escape_string($_POST['phone']);
				$password1 = mysql_real_escape_string($_POST['pass']);
				
				
			if(empty($phone1))
			{
				echo "<script>alert('Phone Number Is Wrong')</script>";
			}
			elseif(empty($password1))
			{
				echo "<script>alert('Password Is Wrong')</script>";
			}
			else
			{	
				$result1 = mysql_query("select * from user where phonenumber = $phone1 and password = '$password1'");
				
				if(mysql_num_rows($result1)>0)
				{
					$username = mysql_query("select * from user where phonenumber = $phone1");
					
					$row2 = mysql_fetch_array($username);
					
					$_SESSION['uid'] = $row2['userid'];
					$_SESSION['firstname'] = $row2['firstname'];
					$_SESSION['surname'] = $row2['surname'];
					$_SESSION['phonenumber'] = $phone1;
					
					header("location:http://localhost/dbook/userhome.php");
				}
				else
				{
					echo "<script>";
					echo "alert('Phone Or Password Wrong')";
					echo "</script>";
				}
			}	
				
			
	}
	
	
	
	/*if(isset($_POST['change']))
	{
		$phone = $_POST['phone1'];
		$oldpass = $_POST['oldpass1'];
		
		$result1 = mysql_query("select*from user where phonenumber = $phone and password = '$oldpass'");
		$num1 = mysql_num_rows($result1);
		
		
		if($num1==0)
		{
				echo "<script>alert('Phone Or Password Wrong.')</script>";
		}
		else
		{
			$newpass = $_POST['newpass1'];
			
			$ans2 = mysql_query("update user set password = '$newpass' where phonenumber = $phone");
			if($ans2 == 1)
			{
				echo "<script>alert('Password Changed.')</script>";
			}
			
		}
		
	}*/
	
	if(isset($_POST['sendcode']))
	{	$phone1 = mysql_real_escape_string($_POST['phone1']);
		$resultuid = mysql_query("select*from user where phonenumber = $phone1");
		
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
				echo "<script>alert('Code Sent')</script>";
			}
			
		}
		
	}
	if(isset($_POST['change']))
	{
			
			$usercode = $_POST['verificationcode'];
			$userphone = $_POST['userphone'];
			$newpass = $_POST['newpass1'];
			$resultuid = mysql_query("select*from user where phonenumber = $phone1");
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

?>

<html>
<head>
	<meta name="viewposrt" content="width=device-width,initial-scale=1.0">
<title>
		DBOOK
</title>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

<style>
	
	.slidbox
	{
		position:relative;
		width:2900px;
		height:440px;
		animation:my 8s infinite;
	}
	.slidbox img{
		float:left;
		width:786px;
		height:440px;
	}
	.contain
	{
		width:800px;
		overflow:hidden;
		border-radius:30px;
		
	}
	@keyframes my
	{
		0%
		{
			left:0px;
		}
		20%
		{
			left:0px;
		}
		25%
		{
			left:-800px;
		}
		45%
		{
			left:-800px;
		}
		50%
		{
			left:-1600px;
		}
		
		70%
		{
			left:-1600px;
		}
		75%
		{
			left:-2400px;
		}
		
	}
	
	
	
	
	
	
</style>

</head>
<body>
<div class="container-fluid well text-left">
<div class="row">
	<div class="col-md-6 text-center">
	
		<h3>D b O o K</h3>
		
	</div>
	
	<div class="col-md-6 text-center" style="margin-top:15px;" >
	
		
			
				<form class="form-inline"  action="#" method="post">
				
					<input type="text" class="form-control" placeholder="Enter Phone Number" value="<?php if(isset($phone)){echo $phone1;}?>" required name="phone"pattern="^[0-9]+$" title="Please Enter Right Number"/>
					<input type="password" class="form-control"placeholder="Enter Password" required name="pass" pattern="^[^ ]+$" title="Not Allow Space"/>
				
					<input type="submit" value="Sign In" name="signin" class="btn btn-success" style="margin-left:10px;" />
			
				</form>
			<div class="col-md-6"><a href="forgotpassword.php" d>Forgotten Password</a></div>
			
			
	</div>
</div>
</div>
<div class="container-fluid">
	
<div class="row">
<div class="col-md-8">

<!--<div>
	<div class="contain">
	
		<div class="slidbox">
			<img src="dbookimage/1 copy.jpg" >
			<img src="dbookimage/2 copy.jpg" >
			<img src="dbookimage/4 copy.jpg">
		</div>
	</div>
	
</div>-->
</div>
	<div class="col-md-4 col-xs-12">
		<div class="panel-group">
			<div class="panel panel-info">
				<div class="panel-heading text-center">
					<h4>Sign Up</h4>
				</div>
				<div class="panel-body">
<form action="dbookhome.php"  method="post">
						<div class="row">
							<div class="col-md-6">
								<input type="text" placeholder="FIrst Name" class="form-control" id="fname" name="firstname" value="<?php if(isset($fname)){echo $fname;}?>" required pattern="^[A-Za-z]+$" title="Please Enter Only Alphabet" id="firstname"/>
							</div>
							<div class="col-md-6">
								<input type="text" placeholder="Surname" class="form-control" id="sname" name="surname" value="<?php if(isset($surname)){echo $surname;}?>" required  pattern="^[A-Za-z]+$" title="Please Enter Only Alphabet"/>
							</div>
						</div>
						
						<input type="text" placeholder="Phone Number" class="form-control" style="margin-top:10px;" id="phone" name="userphonenumber" value="<?php if(isset($phone)){echo $phone;}?>" required pattern="^[0-9]+$" title="Please Enter Right Number"/>
				
						<div class="row text-center" style="margin-top:10px;">
							<div class="col-md-4" style="margin-top:5px;">
								<lable>Birth Date :</lable>
							</div>
							<div class="col-md-8">
								
								<select class="form-control" id="day" name="day">
					<?php for($day=1;$day<=31;$day++){ ?>
								<option><?php echo $day;?></option>
					<?php } ?>
								</select>
								<select class="form-control" id="month" name="month">
									<option>Jan</option>
									<option>Feb</option>
									<option>Mar</option>
									<option>Apr</option>
									<option>May</option>
									<option>Jun</option>
									<option>Jul</option>
									<option>Aug</option>
									<option>Sep</option>
									<option>Oct</option>
									<option>Nev</option>
									<option>Dec</option>					
								</select>
								<select class="form-control" id="year" name="year">
				<?php 
				
						$year=date(Y);
						for($y=1;$y<=110;$y++)
						{
				?>
									<option><?php echo $year;?></option>
						
				<?php 
				
						$year--;  
						}
				?>
								</select>
							</div>
						<div>
					<div class="row text-center">
							<div class="col-md-4" style="margin-top:15px;" >
									<lable>Gender : </lable>
							</div>
							<div class="col-md-7">
								<select style="margin-top:15px;width:100px;border-radius:5px;" id="gender" name="gender">
									<option>Male</option>
									<option>Female</option>
								</select>
							</div>
					</div>
					<div class="col-md-12">
					<input type="password" class="form-control" placeholder="Create Password" style="margin-top:20px;" name="password"  required pattern="^[^ ]+$" title="Not Allow Space">
					</div>
					<input type="submit" value="Sign Up" name="submit"class="btn btn-success form-control" style="margin-top:20px;">
</form>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
</div>


<div class="modal fade" id="modal1">
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<div class="modal-title">
				Forgotten password
				<button class="close" data-dismiss="modal">&times;</button>
				
			</div>
	
			<div class="modal-body">
	<form action="#" method="post">
				<input type="text" class="form-control" name="phone1" style="margin-top:10px;font-size:10px;"placeholder="Enter Reference DboOk A/C Phone Number" />
				<input type="submit" value="Send Code" name="sendcode"class="btn btn-success form-control" style="margin-top:20px;">
	</form>
	<form action="#" method="post">
				<input type="text" class="form-control" name="userphone" style="margin-top:10px;font-size:10px;"placeholder="Enter Your Phone Number" />
				<input type="password" class="form-control" name="verificationcode"  style="margin-top:10px;" placeholder="Enter Verification Number" />
				<input type="password" class="form-control" name="newpass1" style="margin-top:10px;" placeholder="Enter New Password" />
				<input type="submit" value="Change" name="change"class="btn btn-success form-control" style="margin-top:20px;">
			</div>
	</form>
		</div>
	</div>
</div>


<script>

	function imageslider()
	{
		var x = document.getElementById('image');
		
		var images = ('dbookimage/1.jpg','dbookimage/2.jpg','dbookimage/3.jpg');
		
		var i =0;
		
		var x.src=images[0];
		
		if(i>3)
		{
			i=0;
		}
		
		i++;
		
	}
	
	function formvalidation()
	{
		var firstname = document.getElementById('firstname').length;
		if(firstname<3)
		{
			alert('Enter At least 3 character in firstname');
			return false;
		}
	}
	
	

</script>




<!--<input type="password" class="form-control" name="oldpass1"  style="margin-top:10px;" placeholder="Enter Verification Number" />
				<input type="password" class="form-control" name="newpass1" style="margin-top:10px;" placeholder="Enter New Password" />
				<input type="submit" value="Change" name="sendcode"class="btn btn-success form-control" style="margin-top:20px;">-->
</body>
</html>