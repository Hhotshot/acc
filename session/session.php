<?php
@session_start();
if($_SESSION["UserID_BN"] == ""){
//echo '<br><br><a target="_parent" href="../register/login.php"><p align="center" ><font color="#FF0000" size="7">Please Login!</font></p></a>';
	header('location:session/login.php');
	exit();
}

/*
elseif($_SESSION["Status"]!=14 && $_SESSION["Status"]!=11 && $_SESSION["Status"]!=12 && $_SESSION["Status"]!=8 && $_SESSION["Status"]!=20 && $_SESSION["Status"]!=16 && $_SESSION["Status"]!=1 && $_SESSION["Status"]!=6){
	//echo "user ท่านไม่มีสิทธิเข้าใช้งาน";
  	//header('Refresh: 3; URL=../../../index.php');
  	header('location:access_deni.php');
  	exit();
}

*/
?>
