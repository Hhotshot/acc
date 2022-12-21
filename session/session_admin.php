<?php
@session_start();

$user_type_a = explode(" ", $_SESSION['user_type']);
$user_id =$_SESSION['user_id'];
$_SESSION['user_type'];
for($i=0; $i<count($user_type_a); $i++){
	
	$user_type_a[$i];

	#$i++;
}

if($_SESSION["UserID_BN"] == ""){
//echo '<br><br><a target="_parent" href="../register/login.php"><p align="center" ><font color="#FF0000" size="7">Please Login!</font></p></a>';
	header('location:session/login.php');
	exit();
}elseif ( 
			$_SESSION["UserID_BN"] != "" && $user_type_a['0'] != "admin" && $user_type_a['1'] != "admin"	&& $user_type_a['2'] != "admin"
		){
?>

<style type="text/css">
.style1 {
	font-size: 36px;
		color: #FF0000
}
</style>
<table width="1000" border="0" align="center">
  <tr>
    	<th width="1000" scope="col">
			<div align="center">
			  <p>&nbsp;		      </p>
			  <p><span class="style1">
		      <?php
					echo "ท่านไม่มีสิทธิใช้งานหน้านี้ เฉพาะสิทธิ Admin";
					header('Refresh: 2; URL=../index_main.php');
				?>
		      </span></p>
			  <p>&nbsp;			      </p>
		  </div></th>
  </tr>
</table>

<?php
exit();
}
?>
