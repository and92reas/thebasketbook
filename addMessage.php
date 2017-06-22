<?php

require ("head.php");

if (isset($_POST['submitButton'])) {
    
    
    if (isset($_POST['mID'])) {
        $matchID = $_POST['mID'];
    } 
    else {
        
        header("Location: tournamentSearchForm.php?err=2");
    }
    
    if (isset($_POST['topic'])) {
        $topic = $_POST['topic'];
    } 
    else {
        $topic = "(unknown)";
    }
    
    if (isset($_POST['message'])) {
        $content = $_POST['message'];
    } 
    else {
        header("Location: tournamentSearchForm.php?err=6");
    }
    
    
    
    $memberID = isLoggedIn($mysqli);
    
    $query = "INSERT INTO `messages`(`matchID`,`topic`,`content`,`time_stamp`,`memberID`) "
            . "VALUES(" . $matchID . ",'" . $topic . "','" . $content . "'," . time() . "," . $memberID . ")";
    $result = mysqli_query($mysqli,$query);
        
    if(!$result) {
        
    header("Location: tournamentSearchForm.php?err=2");
    exit;
    }
    
    $query = "SELECT `home_team`,`guest_team`,`tournamentID` FROM `matches` "
            . " WHERE `matchID` = " . $matchID . " LIMIT 1" ;
    $result = mysqli_query($mysqli,$query);
        
    if(!$result) {
        
    header("Location: tournamentSearchForm.php?err=2");
    exit;
    }
    
    $row = mysqli_fetch_assoc($result);
    $home_team = $row['home_team'];
    $guest_team = $row['guest_team'];
    $tournamentID = $row['tournamentID'];
    
    if($home_team != 1) {
        $query = "INSERT INTO `teams_notifications`(`teamID`,`topic`,`time_stamp`) "
            . "VALUES(" . $home_team . ",3," . time() . ")";
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            
        header("Location: tournamentSearchForm.php?err=2");
        exit;
        }
    }
    
    if($guest_team != 1) {
        $query = "INSERT INTO `teams_notifications`(`teamID`,`topic`,`time_stamp`) "
            . "VALUES(" . $guest_team . ",3," . time() . ")";
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            
        header("Location: tournamentSearchForm.php?err=2");
        exit;
        }
    }
    
    $query = "INSERT INTO `tournaments_notifications`(`tournamentID`,`topic`,`time_stamp`) "
            . "VALUES(" . $tournamentID . ",3," . time() . ")";
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            
        header("Location: tournamentSearchForm.php?err=2");
        exit;
        }
    
       
    
     
    header("Location: tournamentSearchForm.php?err=7");
    

    
    
    }    

?>

