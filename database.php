<?php 
$hostName = "localhost";
$u = "root";
$p = "";
$dbName = "login_register";

$conn = mysqli_connect($hostName, $u, $p, $dbName);

if(!$conn){
    die("Something went wrong!");
}

?>