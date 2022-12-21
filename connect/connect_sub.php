<?php
// Deklarasi variable untuk koneksi ke database.
$host     = "192.168.1.254";// Server database
$username = "sa";     // Username database
$password = "sa";     // Password database
$database = "hos";     // Nama database

// Koneksi ke database.
$con_hos = new mysqli($host, $username, $password, $database);
mysqli_set_charset($con_hos,"utf8");

$host_ii     = "192.168.1.254";// Server database
$username_ii = "sa";     // Username database
$password_ii = "sa";     // Password database
$database_ii = "manager";     // Nama database

// Koneksi ke database.
$con_manager = new mysqli($host_ii, $username_ii, $password_ii, $database_ii);
mysqli_set_charset($con_manager,"utf8");

date_default_timezone_set("Asia/Bangkok");
?>