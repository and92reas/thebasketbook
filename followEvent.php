<?php

require ("head.php");

if (isset($_POST['followButton'])) {
    
    if (isset($_POST['follow'])) {
        $follow = $_POST['follow'];
    } 
    else {
        header("Location: eventSearchForm.php?err=2");
    }
    
    if (isset($_POST['memberID'])) {
        $memberID = $_POST['memberID'];
    }
    else {
        header("Location: eventSearchForm.php?err=2");
    }
    
    if (isset($_POST['eventID'])) {
        $teamID = $_POST['eventID'];
    }
    else {
        header("Location: eventSearchForm.php?err=2");
    }
    
    if($follow == 1) {
        
        $query = "DELETE FROM `followed_events` WHERE `eventID` = " . $eventID . " AND `memberID` = " . $memberID;
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            header("Location: eventSearchForm.php?err=2");
            exit;
        }
        
        header("Location: eventSearchForm.php?err=5");
        
    }
    else {
        
        $query = "INSERT INTO `followed_events`(`memberID`,`eventID`) "
            . "VALUES(" . $memberID . "," . $eventID . ")";
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
        header("Location: eventSearchForm.php?err=3");
        exit;
        }
        
        header("Location: eventSearchForm.php?err=5");
        
    }
}