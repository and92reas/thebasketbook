<?php

    $user = "*******";
    $password = "********";
    $database = "basketbook";
    $host = "localhost";
    
    $mysqli = new mysqli($host, $user, $password, $database);
    
    if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    
    
    
?>
