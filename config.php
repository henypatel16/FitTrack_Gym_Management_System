<?php
$host = "localhost";       
$user = "root";           
$password = "";            
$dbname = "FitTrack_db";  

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>