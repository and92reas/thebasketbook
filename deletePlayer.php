<?php

require ("head.php");

if(isset($_GET['pID'])) {
    $playerID = mysqli_real_escape_string($mysqli,$_GET['pID']);
    }
    else {
        
        header("Location: playerSearchForm.php?err=2");
        exit;
    }
    
    $memberID = isLoggedIn($mysqli);
    
    
    $query = "SELECT * FROM `admin_players` "
            . "WHERE `memberID` = " . $memberID . " AND `playerID` = " . $playerID . " ";
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows!=1) {
     header("Location: playerSearchForm.php?err=3");
     exit;
     }
     
     $query = "SELECT `present_team` FROM `players` "
            . "WHERE `playerID` = " . $playerID;
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
         
     header("Location: playerSearchForm.php?err=2");
     exit;
     }
     
     $row = mysqli_fetch_assoc($result);
     $present_team = $row['present_team'];

    $query = "SELECT `eventID` FROM `events_players` "
            . "WHERE `playerID` = " . $playerID;
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
         
     header("Location: playerSearchForm.php?err=2");
     exit;
     }
     
     $events = array();
     
     while($row = $result->fetch_array()) {
        $events[] = $row['eventID']; 
     }
     
     if(count($events)>0) {
     
    $query = "INSERT INTO `events_notifications`(`eventID`,`topic`,`time_stamp`) "
            . "VALUES(" . $events[0] . ",3," . time() . ")";
             
            
     for($i=1; $i<count($events); $i++) {
     $query = $query . ",(" . $events[$i] . ",3," . time() . ")";    
     }       
           
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
        
     header("Location: playerSearchForm.php?err=2");
     exit;
     }
     
     }
     
     if($present_team!=1) {
     
     $query = "INSERT INTO `teams_notifications`(`teamID`,`topic`,`time_stamp`) "
            . "VALUES(" . $present_team . ",4," . time() . ")";
     $result = mysqli_query($mysqli,$query);
     
     if(!$result) {
        
     header("Location: playerSearchForm.php?err=2");
     exit;
     }
     }

        $query =  "DELETE FROM `players` WHERE `playerID` = " . $playerID;
        $query2 = "DELETE FROM `past_teams` WHERE `playerID` = " . $playerID;
        $query3 = "DELETE FROM `admin_players` WHERE `playerID` = " . $playerID;
        $query4 = "DELETE FROM `followed_players` WHERE `playerID` = " . $playerID;
        $query5 = "DELETE FROM `events_players` WHERE `playerID` = " . $playerID;
        $query6 = "DELETE FROM `players_matches` WHERE `playerID` = " . $playerID;
        $query7 =  "DELETE FROM `players_notifications` WHERE `playerID` = " . $playerID;
        
        $result2 = mysqli_query($mysqli,$query2);
        $result3 = mysqli_query($mysqli,$query3);
        $result4 = mysqli_query($mysqli,$query4);
        $result5 = mysqli_query($mysqli,$query5);
        $result6 = mysqli_query($mysqli,$query6);
        $result7 = mysqli_query($mysqli,$query7);
        $result = mysqli_query($mysqli,$query);
                          
            
        if(!$result || !$result2 || !$result3 || !$result4 || !$result5 || !$result6 ) {
        header("Location: newPlayerForm.php?err=5");
        exit;
        }    

        header("Location: playerSearchForm.php?err=6");
        exit;
