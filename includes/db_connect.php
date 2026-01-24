<?php
$host = "localhost";
$user = "u574344867_wepsach";
$pass = "H1=abGHw5M|w";
$db   = "u574344867_thuviensach";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");
?>
