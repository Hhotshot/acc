<?php
	#include 'database.php';
	include("../connect/connect.php");
	session_start();
	/*
	if($_POST['type']==1){
		$name=$_POST['name'];
		$email=$_POST['email'];
		$phone=$_POST['phone'];
		$city=$_POST['city'];
		$password=$_POST['password'];
		
		$duplicate=mysqli_query($conn,"select * from crud where email='$email'");
		if (mysqli_num_rows($duplicate)>0)
		{
			echo json_encode(array("statusCode"=>201));
		}
		else{
			$sql = "INSERT INTO `crud`( `name`, `email`, `phone`, `city`, `password`) 
			VALUES ('$name','$email','$phone','$city', '$password')";
			if (mysqli_query($conn, $sql)) {
				echo json_encode(array("statusCode"=>200));
			} 
			else {
				echo json_encode(array("statusCode"=>201));
			}
		}
		mysqli_close($conn);
	}
	*/
	if($_POST['type']==2){
		echo $username=$_POST['username'];
		echo $password=md5($_POST['password']);
		# $database_ii = ตารางโปรแกรม
		#echo $check=mysqli_query($con_hos,"	SELECT o.loginname, u.user_id, GROUP_CONCAT(u.user_type SEPARATOR ' ')user_type FROM opduser o 
		#								LEFT OUTER JOIN $database_ii.user u ON o.loginname=u.user_id 
		#								WHERE o.loginname = '$username' AND o.passweb = '$password' 
		#								AND u.user_id IS NOT NULL LIMIT 5");

		echo $s_check=" SELECT o.loginname, u.user_id, GROUP_CONCAT(u.user_type SEPARATOR ' ')user_type FROM opduser o 
										LEFT OUTER JOIN $database_ii.user u ON o.loginname=u.user_id 
										WHERE o.loginname = '$username' AND o.passweb = '$password' 
										AND u.user_id IS NOT NULL LIMIT 5";
		$q_check = mysqli_query($con_hos, $s_check) or die(mysqli_error($con_hos));

		$r_check = mysqli_fetch_array($q_check);


		if ($r_check["loginname"]!="")
		{
			if($r_check["user_type"]!=""){

				$_SESSION['UserID_BN']=$username;
				$_SESSION['user_type']=$r_check["user_type"];
				echo json_encode(array("statusCode"=>200));

				echo $s_opduser="SELECT d.name FROM opduser o LEFT OUTER JOIN doctor d ON o.doctorcode=d.code WHERE o.loginname='$username' LIMIT 1";
			    $q_opduser = mysqli_query($con_hos, $s_opduser) or die(mysqli_error($con_hos));
			    $r_opduser = mysqli_fetch_array($q_opduser);
			    $_SESSION['opduser'] = $r_opduser["name"];

			}elseif($r_check["user_type"]==""){

				echo json_encode(array("statusCode"=>202));

			}
		}
		else{

			echo json_encode(array("statusCode"=>201));
			
		}
		mysqli_close($con_hos);
	}
?>