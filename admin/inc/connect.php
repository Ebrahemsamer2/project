<?php
$dbusername = "root";
$dbpassword = "";
$dbname = "project";
$host = "localhost";
 
try {
    $con = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $e) {
    echo "Connection Error: " . $e->getMessage(). '\n' ;
}