<?php

session_start();
require("config.php");


$delay = 60 * 15;

if(!isset($_GET['start']) ||  $_GET['start']==NULL) {
    $memberID = isLoggedIn($mysqli);
    if(!$memberID) {
        
        header("Location: logInForm.php?err=2");
        exit;
    }
    else {
        
        $expiration = time() + $delay;
        
        $query = "UPDATE `logged_members` SET `expiration` = " . $expiration
                                  . "WHERE memberID = " . $memberID ;
        $result = mysqli_query($mysqli,$query);
    }
    
    $query = "DELETE FROM `logged_members` WHERE `expiration` < " . (time() - 5 * $delay) ;
    $result = mysqli_query($mysqli,$query);
    
    $query = "DELETE FROM `players_notifications` WHERE `time_stamp` < " . (time() - 100 * $delay) ;
    $result = mysqli_query($mysqli,$query);
    
    $query = "DELETE FROM `teams_notifications` WHERE `time_stamp` < " . (time() - 500 * $delay) ;
    $result = mysqli_query($mysqli,$query);
    
    $query = "DELETE FROM `events_notifications` WHERE `time_stamp` < " . (time() - 500 * $delay) ;
    $result = mysqli_query($mysqli,$query);
    
    $query = "DELETE FROM `tournaments_notifications` WHERE `time_stamp` < " . (time() - 500 * $delay) ;
    $result = mysqli_query($mysqli,$query);
    
}
require ("upper.php");

function isLoggedIn($mysqli) {
    $sessionID = mysqli_real_escape_string($mysqli,session_id());
    $hash = mysqli_real_escape_string($mysqli,hash("sha512",$sessionID.$_SERVER['HTTP_USER_AGENT']));
    
    
    $query = "SELECT `memberID` FROM `logged_members`"
                              . "WHERE `sessionID` = '" . $sessionID . "' AND `hash` = '" . $hash . "'"
            . " AND `expiration` > " . time() . " ORDER BY `log_memberID` DESC LIMIT 1";
    
    $result = mysqli_query($mysqli,$query);
    
    if($result->num_rows>0) {
       $row = mysqli_fetch_assoc($result);
       return (INT) $row['memberID']; 
    }
    else {
        
        return false;
    }
}

function getUser($mysqli) {
    $memberID = isLoggedIn($mysqli);
    if(!$memberID) {
        
        header("Location: logInForm.php?err=2");
        exit;
    }
    
    $query = "SELECT `name` FROM `members`"
            . "WHERE `memberID` = " . $memberID . " LIMIT 1";
    
    $result = mysqli_query($mysqli,$query);
    
    if($result->num_rows>0) {
    $row = mysqli_fetch_assoc($result);
    return $row['name'];
    }
    
    else {
        return false;
    }
    
}



?>

