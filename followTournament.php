<?php

require ("head.php");

if (isset($_POST['followButton'])) {
    
    if (isset($_POST['follow'])) {
        $follow = $_POST['follow'];
    } 
    else {
        header("Location: tournamentSearchForm.php?err=2");
    }
    
    if (isset($_POST['memberID'])) {
        $memberID = $_POST['memberID'];
    }
    else {
        header("Location: tournamentSearchForm.php?err=2");
    }
    
    if (isset($_POST['tournamentID'])) {
        $tournamentID = $_POST['tournamentID'];
    }
    else {
        header("Location: tournamentSearchForm.php?err=2");
    }
    
    if($follow == 1) {
        
        $query = "DELETE FROM `followed_tournaments` WHERE `tournamentID` = " . $tournamentID . " AND `memberID` = " . $memberID;
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            header("Location: tournamentSearchForm.php?err=2");
            exit;
        }
        
        header("Location: tournamentSearchForm.php?err=5");
        
    }
    else {
        
        $query = "INSERT INTO `followed_tournaments`(`memberID`,`tournamentID`) "
            . "VALUES(" . $memberID . "," . $tournamentID . ")";
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
        header("Location: tournamentSearchForm.php?err=3");
        exit;
        }
        
        header("Location: tournamentSearchForm.php?err=5");
        
    }
}