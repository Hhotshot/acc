<?php
// Deklarasi variable untuk koneksi ke database.
$host     = "localhost";// Server database
$username = "sa";     // Username database
$password = "sa";     // Password database Bnhos:BNh@s1#975XP
$database = "hos";     // Nama database

// Koneksi ke database.
$con_hos = new mysqli($host, $username, $password, $database);
mysqli_set_charset($con_hos,"utf8");

$host_ii     = "localhost";// Server database
$username_ii = "sa";     // Username database
$password_ii = "sa";     // Password database
$database_ii = "hchkup";     // Nama database

// Koneksi ke database.
$con_hchkup = new mysqli($host_ii, $username_ii, $password_ii, $database_ii);
mysqli_set_charset($con_hchkup,"utf8");


#$host_iii     = "192.168.1.254";// Server database
#$username_iii = "sa";     // Username database
#$password_iii = "sa";     // Password database
#$database_iii = "manager";     // Nama database

// Koneksi ke database.
#$con_manager = new mysqli($host_iii, $username_iii, $password_iii, $database_iii);
#mysqli_set_charset($con_manager,"utf8");

date_default_timezone_set("Asia/Bangkok");
?>