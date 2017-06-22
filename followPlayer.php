<?php

require ("head.php");

if (isset($_POST['followButton'])) {
    
    if (isset($_POST['follow'])) {
        $follow = $_POST['follow'];
    } 
    else {
        
        header("Location: playerSearchForm.php?err=2");
    }
    
    if (isset($_POST['memberID'])) {
        $memberID = $_POST['memberID'];
    }
    else {
        
        header("Location: playerSearchForm.php?err=2");
    }
    
    if (isset($_POST['playerID'])) {
        $playerID = $_POST['playerID'];
    }
    else {
        
        header("Location: playerSearchForm.php?err=2");
    }
    
    if($follow == 1) {
        
        $query = "DELETE FROM `followed_players` WHERE `playerID` = " . $playerID . " AND `memberID` = " . $memberID;
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            
            header("Location: playerSearchForm.php?err=2");
            exit;
        }
        
        header("Location: playerSearchForm.php?err=5");
        
    }
    else {
        
        $query = "INSERT INTO `followed_players`(`memberID`,`playerID`) "
            . "VALUES(" . $memberID . "," . $playerID . ")";
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
        header("Location: playerSearchForm.php?err=3");
        exit;
        }
        
        header("Location: playerSearchForm.php?err=5");
        
    }
    
}

