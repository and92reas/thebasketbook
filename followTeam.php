<?php

require ("head.php");

if (isset($_POST['followButton'])) {
    
    if (isset($_POST['follow'])) {
        $follow = $_POST['follow'];
    } 
    else {
        header("Location: teamSearchForm.php?err=2");
    }
    
    if (isset($_POST['memberID'])) {
        $memberID = $_POST['memberID'];
    }
    else {
        header("Location: teamSearchForm.php?err=2");
    }
    
    if (isset($_POST['teamID'])) {
        $teamID = $_POST['teamID'];
    }
    else {
        header("Location: teamSearchForm.php?err=2");
    }
    
    if($follow == 1) {
        
        $query = "DELETE FROM `followed_teams` WHERE `teamID` = " . $teamID . " AND `memberID` = " . $memberID;
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            header("Location: teamSearchForm.php?err=2");
            exit;
        }
        header("Location: teamSearchForm.php?err=5");
        
    }
    else {
        
        $query = "INSERT INTO `followed_teams`(`memberID`,`teamID`) "
            . "VALUES(" . $memberID . "," . $teamID . ")";
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
        header("Location: teamSearchForm.php?err=3");
        exit;
        }
        
        header("Location: teamSearchForm.php?err=5");
        
    }
}