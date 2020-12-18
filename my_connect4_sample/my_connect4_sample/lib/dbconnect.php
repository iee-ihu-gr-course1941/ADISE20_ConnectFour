<?php

$host = 'localhost:3000';
$db = 'connect4';
$user=$DB_USER;
$pass=$DB_PASS;

require_once 'config.php';


if(gethostname()=='users.iee.ihu.gr'){
    $mysqli = new mysqli($host,$user,$db,null,'/home/student/it/2018/it185289/mysql/run/mysql.sock');
} else {
    $mysqli = new mysqli($host,$user,$pass,$db);
}

if($mysqli->connect_errno){
    echo "Failed to connect to MySQL: (" . 
    $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

?>


