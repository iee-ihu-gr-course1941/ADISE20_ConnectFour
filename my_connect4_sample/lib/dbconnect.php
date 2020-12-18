<?php

$host = 'localhost:3000';
$db = 'connect4';
$user='root';
$pass='';
$mysqli = mysqli_connect($host,$user,$pass,$db);
require_once 'C:\xampp\phpMyAdmin\setup\config.php';


if($coon->connect_errno){
    echo "Failed to connect to MySQL :(" .
    $mysqli->connect_errno . ")" . $coon->connect_error;
}

?>


