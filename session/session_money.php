<?php
@session_start();

$user_type_a = explode(" ", $_SESSION['user_type']);

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
			$_SESSION["UserID_BN"] != "" && $user_type_a['0'] != "money" && $user_type_a['1'] != "money"	&& $user_type_a['2'] != "money"
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
					echo "ท่านไม่มีสิทธิใช้งานหน้านี้ เฉพาะเจ้าหน้าที่งานการเงินเท่านั้น";
					header('Refresh: 2; URL=index.php');
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
