<?php

//Database Credentials
$host = "localhost";
$DBuser = "root";
$DBpassword = "";
global $conn;

//Try to establish database connection with PDO
try {
    $conn = new PDO("mysql:host=$host;dbname=socialmediadb", $DBuser, $DBpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Set the PDO error mode to exception
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();//Hide error to user eventually
}

?>