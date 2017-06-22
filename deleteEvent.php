<?php

require ("head.php");

if(isset($_GET['eID'])) {
    $eventID = $_GET['eID'];
    }
    else {
        header("Location: eventSearchForm.php?err=2");
        exit;
    }
    
    $memberID = isLoggedIn($mysqli);
    
    
    $query = "SELECT * FROM `admin_events` "
            . "WHERE `memberID` = " . $memberID . " AND `eventID` = " . $eventID . " ";
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows!=1) {
     header("Location: eventSearchForm.php?err=3");
     exit;
     }
     
    $query = "SELECT `playerID` FROM `events_players` "
            . "WHERE `eventID` = " . $eventID;
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
     header("Location: eventSearchForm.php?err=2");
     exit;
     }
     
     $players = array();
     
     while($row = $result->fetch_array()) {
        $players[] = $row['playerID']; 
     }
     
     if(count($players)>0) {
     
    $query = "INSERT INTO `players_notifications`(`playerID`,`topic`,`time_stamp`) "
            . "VALUES(" . $players[0] . ",5," . time() . ")";
             
            
     for($i=1; $i<count($players); $i++) {
     $query = $query . ",(" . $players[$i] . ",5," . time() . ")";    
     }       
           
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
     header("Location: eventSearchForm.php?err=2");
     exit;
     }
     }
     
     $query = "SELECT `teamID` FROM `events_teams` "
            . "WHERE `eventID` = " . $eventID;
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
     header("Location: eventSearchForm.php?err=2");
     exit;
     }
     
     $teams = array();
     
     while($row = $result->fetch_array()) {
        $teams[] = $row['teamID']; 
     }
     
     if(count($teams)>0) {
     
    $query = "INSERT INTO `teams_notifications`(`teamID`,`topic`,`time_stamp`) "
            . "VALUES(" . $teams[0] . ",9," . time() . ")";
             
            
     for($i=1; $i<count($teams); $i++) {
     $query = $query . ",(" . $teams[$i] . ",9," . time() . ")";    
     }       
           
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
     header("Location: eventSearchForm.php?err=2");
     exit;
     }
     }
     
     
     
        $query2 = "DELETE FROM `events_teams` WHERE `eventID` = " . $eventID;
        $query3 = "DELETE FROM `events_players` WHERE `eventID` = " . $eventID;
        $query4 = "DELETE FROM `admin_events` WHERE `eventID` = " . $eventID;
        $query5 = "DELETE FROM `followed_events` WHERE `eventID` = " . $eventID;
        $query6 = "DELETE FROM `events_notifications` WHERE `eventID` = " . $eventID;
        $query =  "DELETE FROM `events` WHERE `eventID` = " . $eventID;
        $result2 = mysqli_query($mysqli,$query2);
        $result3 = mysqli_query($mysqli,$query3);
        $result4 = mysqli_query($mysqli,$query4);
        $result5 = mysqli_query($mysqli,$query5);
        $result6 = mysqli_query($mysqli,$query6);
        $result = mysqli_query($mysqli,$query);
                                 
            
        if(!$result || !$result2 || !$result3 || !$result4 || !$result5 || !$result6) {
        header("Location: newEventForm.php?err=6");
        }  
        
        header("Location: eventSearchForm.php?err=6");