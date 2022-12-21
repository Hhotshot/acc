<?php
session_start();
unset($_SESSION["UserID_BN"]);
unset($_SESSION["password"]);
unset($_SESSION["user_type"]);


header("Location:login.php");
?>