<?php
session_start();

include('../connect/connect.php');

$username=$_REQUEST['username'];
$password=md5($_REQUEST['password']);

if($username!=''){

	$s_check=" SELECT o.loginname, u.user_id, GROUP_CONCAT(u.user_type SEPARATOR ' ')user_type FROM opduser o 
										LEFT OUTER JOIN $database_ii.user u ON o.loginname=u.user_id 
										WHERE o.loginname = '$username' AND o.passweb = '$password' 
										AND u.user_id IS NOT NULL LIMIT 5";
	$q_check = mysqli_query($con_hos, $s_check) or die(mysqli_error($con_hos));

	$r_check = mysqli_fetch_array($q_check);
		
	if ($r_check["loginname"]!=""){
			#if($r_check["user_type"]!=""){

				$_SESSION['UserID_BN']=$username;
				$_SESSION['user_type']=$r_check["user_type"];
				#echo json_encode(array("statusCode"=>200));location.href = "../index.php";	

				echo $s_opduser="SELECT d.name FROM opduser o LEFT OUTER JOIN doctor d ON o.doctorcode=d.code WHERE o.loginname='$username' LIMIT 1";
			    $q_opduser = mysqli_query($con_hos, $s_opduser) or die(mysqli_error($con_hos));
			    $r_opduser = mysqli_fetch_array($q_opduser);
			    $_SESSION['opduser'] = $r_opduser["name"];

			    //$status = 'ok';

			#}elseif($r_check["user_type"]==""){

				#echo json_encode(array("statusCode"=>202));ท่านไม่มีสิทธิเข้าใช้งาน
				#$status = 'sit';
				//echo ""
				header("location:../index_main.php");
			#}
	}else{

			header("location:login.php?up=f");

			#echo json_encode(array("statusCode"=>201));Username หรือ Password ไม่ถูกต้อง !
			
	}	
		#session_write_close();
	
	//if($query_update_user_status){	
		
	//}
	//echo $status;die;	
}	
	
mysqli_close($con_hos);
?>