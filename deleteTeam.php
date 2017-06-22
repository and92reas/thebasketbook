<?php

require ("head.php");

if(isset($_GET['tID'])) {
    $teamID = $_GET['tID'];
    }
    else {
        
        header("Location: teamSearchForm.php?err=2");
        exit;
    }
    
    $memberID = isLoggedIn($mysqli);
    
    
    $query = "SELECT * FROM `admin_teams` "
            . "WHERE `memberID` = " . $memberID . " AND `teamID` = " . $teamID . " ";
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows!=1) {
     header("Location: teamSearchForm.php?err=3");
     exit;
     }
     
     $query = "SELECT * FROM `teams_tournaments` "
            . "WHERE `teamID` = " . $teamID;
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
         
     header("Location: teamSearchForm.php?err=2");
     exit;
     }
     else if($result->num_rows > 0) {
      header("Location: teamSearchForm.php?err=7");
     exit;   
     }
     
     $query = "SELECT `eventID` FROM `events_teams` "
            . "WHERE `teamID` = " . $teamID;
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
         
     header("Location: teamSearchForm.php?err=2");
     exit;
     }
     
     $events = array();
     
     while($row = $result->fetch_array()) {
        $events[] = $row['eventID']; 
     }
     
     if(count($events)>0) {
     
    $query = "INSERT INTO `events_notifications`(`eventID`,`topic`,`time_stamp`) "
            . "VALUES(" . $events[0] . ",5," . time() . ")";
             
            
     for($i=1; $i<count($events); $i++) {
     $query = $query . ",(" . $events[$i] . ",5," . time() . ")";    
     }       
           
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
         
     header("Location: teamSearchForm.php?err=2");
     exit;
     }
     }
     
    $query = "UPDATE `players`  "
            . "SET `present_team` = 1"
            . " WHERE `present_team` = " . $teamID;
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
        
     header("Location: teamSearchForm.php?err=2");
     exit;
     }

     
     
        $query =  "DELETE FROM `teams` WHERE `teamID` = " . $teamID;
        $query2 = "DELETE FROM `teams_successes` WHERE `teamID` = " . $teamID;
        $query3 = "DELETE FROM `admin_teams` WHERE `teamID` = " . $teamID;
        $query4 = "DELETE FROM `followed_teams` WHERE `teamID` = " . $teamID;
        $query5 = "DELETE FROM `events_teams` WHERE `teamID` = " . $teamID;
        $query6 = "DELETE FROM `teams_notifications` WHERE `teamID` = " . $teamID;
        
        $result2 = mysqli_query($mysqli,$query2);
        $result3 = mysqli_query($mysqli,$query3);
        $result4 = mysqli_query($mysqli,$query4);
        $result5 = mysqli_query($mysqli,$query5);
        $result6 = mysqli_query($mysqli,$query6);
        $result = mysqli_query($mysqli,$query);
                          
            
        if(!$result || !$result2 || !$result3 || !$result4 || !$result5 || !$result6 ) {
        header("Location: newTeamForm.php?err=3");
        exit;
        }    
        
        header("Location: teamSearchForm.php?err=6");
        exit;
?>