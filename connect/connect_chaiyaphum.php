<?php
// Deklarasi variable untuk koneksi ke database.
$host     = "192.168.5.195";// Server database
$username = "dbhosx";     // Username database
$password = "Ic2rTc47p68H30";     // Password database
$database = "hos1";     // Nama database

// Koneksi ke database.
$con_hos = new mysqli($host, $username, $password, $database);
mysqli_set_charset($con_hos,"utf8");

$host_ii     = "192.168.5.195";// Server database
$username_ii = "dbhosx";     // Username database
$password_ii = "Ic2rTc47p68H30";     // Password database
$database_ii = "money_bn";     // Nama database

// Koneksi ke database.
$con_money = new mysqli($host_ii, $username_ii, $password_ii, $database_ii);
mysqli_set_charset($con_money,"utf8");


#$host_iii     = "192.168.1.254";// Server database
#$username_iii = "sa";     // Username database
#$password_iii = "sa";     // Password database
#$database_iii = "manager";     // Nama database

// Koneksi ke database.
#$con_manager = new mysqli($host_iii, $username_iii, $password_iii, $database_iii);
#mysqli_set_charset($con_manager,"utf8");

date_default_timezone_set("Asia/Bangkok");
?>