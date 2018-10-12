<?php
session_start();
include("connectionwithdbook.php");



	if(isset($_POST['change']))
	{
			
			$receverphone = $_GET['rphone'];
			
			$usercode = $_GET['vcode'];
			$userphone = $_GET['uphone'];
			$newpass = $_GET['npass'];
			$resultcode = mysql_query("select * from codemassage where userid = (select userid from user where phonenumber = $receverphone) order by mid desc limit 1");
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


