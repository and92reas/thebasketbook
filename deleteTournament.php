<?php

require ("head.php");

if(isset($_GET['tID'])) {
    $tournamentID = $_GET['tID'];
    }
    else {
        header("Location: tournamentSearchForm.php?err=2");
        exit;
    }
    
    $memberID = isLoggedIn($mysqli);
    
    
    $query = "SELECT * FROM `admin_tournaments` "
            . " WHERE `memberID` = " . $memberID . " AND `tournamentID` = " . $tournamentID ;
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows!=1) {
     header("Location: tournamentSearchForm.php?err=3");
     exit;
     }
     
    
     
     $query = "SELECT `teamID` FROM `teams_tournaments` "
            . "WHERE `tournamentID` = " . $tournamentID;
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
     header("Location: tournamentSearchForm.php?err=2");
     exit;
     }
     
     $teams = array();
     
     while($row = $result->fetch_array()) {
        $teams[] = $row['teamID']; 
     }
     
     if(count($teams)>0) {
     
    $query = "INSERT INTO `teams_notifications`(`teamID`,`topic`,`time_stamp`) "
            . "VALUES(" . $teams[0] . ",7," . time() . ")";
             
            
     for($i=1; $i<count($teams); $i++) {
     $query = $query . ",(" . $teams[$i] . ",7," . time() . ")";    
     }       
           
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
     header("Location: tournamentSearchForm.php?err=2");
     exit;
     }
     }
     
     $query = "SELECT `matchID` FROM `matches` "
            . "WHERE `tournamentID` = " . $tournamentID;
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
     header("Location: tournamentSearchForm.php?err=2");
     exit;
     }
     
     $matches = array();
     
     while($row = $result->fetch_array()) {
        $matches[] = $row['matchID']; 
     }
     
     for ($i=0; $i<count($matches); $i++) {
         $query =  "DELETE FROM `messages` WHERE `matchID` = " . $matches[$i];
         $query2 =  "DELETE FROM `players_matches` WHERE `matchID` = " . $matches[$i];
         $result = mysqli_query($mysqli,$query);
         $result2 = mysqli_query($mysqli,$query2);
         
         if(!$result || !$result2) {
         header("Location: newTournamentProForm.php?err=6");
         exit;
         }
     }
     
     
        $query =  "DELETE FROM `matches` WHERE `tournamentID` = " . $tournamentID;
        $query2 = "DELETE FROM `tournaments` WHERE `tournamentID` = " . $tournamentID;
        $query3 = "DELETE FROM `teams_tournaments` WHERE `tournamentID` = " . $tournamentID;
        $query4 = "DELETE FROM `tournaments_notifications` WHERE `tournamentID` = " . $tournamentID;
        $query5 = "DELETE FROM `admin_tournaments` WHERE `tournamentID` = " . $tournamentID;
        $query6 = "DELETE FROM `followed_tournaments` WHERE `tournamentID` = " . $tournamentID;
        $result = mysqli_query($mysqli,$query);
        $result3 = mysqli_query($mysqli,$query3);
        $result4 = mysqli_query($mysqli,$query4);
        $result5 = mysqli_query($mysqli,$query5);
        $result6 = mysqli_query($mysqli,$query6);
        $result2 = mysqli_query($mysqli,$query2);
                    
            
        if(!$result || !$result2 || !$result3 || !$result4 || !$result5 || !$result6) {
        header("Location: newTournamentProForm.php?err=6");
        exit;
        }    
        
        header("Location: tournamentSearchForm.php?err=8");
        exit;

?>
