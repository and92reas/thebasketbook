<?php

require("head.php");

if (isset($_POST['submitButton'])) {
    
    $teamIDs = array();
    $number_of_teams = $_POST['numberOfTeams'];
    $tournament = $_POST['tournament'];
    
        
        if($_POST['tournament']== "knockOut") {
            $type = 0;
            }
            else {
            $type = 1;    
            }    
        
    
    for($i=1;$i<=$number_of_teams;$i++) {
        if(!isset($_POST['team'. $i]) || $_POST['team'. $i]==NULL) {
            header("Location: newTournamentProForm.php?err=2");
        }
        
        $query = "SELECT `name` FROM `teams` "
                . "WHERE `name` = '" . $_POST['team'. $i] . "' LIMIT 1";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows==0) {
           header("Location: newTournamentProForm.php?err=5");
           
           exit;
        }
        
        $query = "SELECT `teamID` FROM `teams` "
                . "WHERE `name` = '" . $_POST['team'. $i] . "' LIMIT 1";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows==0) {
            
            header("Location: newTournamentProForm.php?err=4");
            exit;
        }
        
        $row = mysqli_fetch_assoc($result);
        $teamIDs[$i-1] = (INT) $row['teamID'];
    }
        
        if(!isset($_POST['title']) || $_POST['title']== NULL) {
            header("Location: newTournamentProForm.php?err=3");
        }
        else {
            $title = $_POST['title'];
        }
        
        if(!isset($_POST['startDate']) || $_POST['startDate']==NULL) {
        $start_date = "unknown";
        }
        else {
        $start_date = $_POST['startDate'];    
        }
        
        if(!isset($_POST['endDate']) || $_POST['endDate']==NULL) {
        $end_date = "unknown";
        }
        else {
        $end_date = $_POST['endDate'];    
        }
        
        $query = "SELECT `title` FROM `tournaments` "
            . "WHERE `title` = '". $title . "' LIMIT 1";
        $result = mysqli_query($mysqli,$query);
            
        if($result->num_rows>0) {
            
           header("Location: newTournamentProForm.php?err=4");
           exit;
        }
        
        $mysqli->autocommit(false);
        
        $query = "INSERT INTO `tournaments`(`title`,`start_date`,`end_date`,`type`)"
                    . "VALUES('". $title . "','" . $start_date . "','" . $end_date . "'," . $type .")";
                    $result = mysqli_query($mysqli,$query);
        
          if(!$result) {
              header("Location: newTournamentProForm.php?err=4");
          exit;
              }
              
        $query = "SELECT `tournamentID` FROM `tournaments` "
                . "WHERE `title` = '" . $title . "' ORDER BY `tournamentID` DESC LIMIT 1";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows==0) {
            
            header("Location: newTournamentProForm.php?err=4");
            exit;
        }  
        
        $row = mysqli_fetch_assoc($result);
        $tournamentID = (INT) $row['tournamentID'];
                 
    
        //knock out
        if ($tournament == 'knockOut') {
            
            for ($i=1; $i<=$number_of_teams; $i++) {
                
                if($i%2==1) {
                    
                    insertMatch($teamIDs[$i-1],1, 1,$i,$tournamentID,$mysqli,$type);
                    
                    }
                    
                else {
                    
                    $row = intval(($i-1)/2)+1;
                    $query = "UPDATE `matches` SET `guest_team` = " . $teamIDs[$i-1] 
                            . " WHERE `round`=1 AND `row` = " . $row;
                    $result = mysqli_query($mysqli,$query);
        
                    if(!$result) {
                       
                    deleteTournament($tournamentID,$mysqli);
                    
                    header("Location: newTournamentProForm.php?err=4");
                    exit;
                }
                
                
                
            }
        }    
        
        for ($i=1; $i<=$number_of_teams/4; $i++) {
                   
                    insertMatch(1,1, 2,$i,$tournamentID,$mysqli,$type);
         }
         
         for ($i=1; $i<=$number_of_teams/8; $i++) {
                   
                    insertMatch(1,1, 3,$i,$tournamentID,$mysqli,$type);
         }
         for ($i=1; $i<=$number_of_teams/16; $i++) {
                   
                    insertMatch(1,1, 4,$i,$tournamentID,$mysqli,$type);
         }
        
        }
        
        //championship
        else {
            
            $home_teams = array();
            $away_teams = array();
            $matches = array();
            
            if($number_of_teams==2) {
              
              $matches[0]['home'][0] = $teamIDs[0];
              $matches[0]['away'][0] = $teamIDs[1]; 
              $matches[1]['home'][0] = $teamIDs[1]; 
              $matches[1]['away'][0] = $teamIDs[0];
              insertMatch($teamIDs[0], $teamIDs[1], 1, 1, $tournamentID, $mysqli, $type);
              insertMatch($teamIDs[1], $teamIDs[0], 2, 1, $tournamentID, $mysqli, $type);

              
                
            } 
            else {
            
                                    
             for ($i=1; $i<=$number_of_teams; $i++) {
                 
                 if($i<=$number_of_teams/2) {
                     $home_teams[$i-1] = $teamIDs[$i-1];
                 }
                 else {
                     $away_teams[$i - $number_of_teams/2 -1] = $teamIDs[$i-1];
                 }
             }
             
             
             
             for ($i=0; $i<$number_of_teams/2; $i++) {
                 $matches[0]['home'][$i] = $home_teams[$i];
                 $matches[0]['away'][$i] = $away_teams[$i];
             }
             
             for($i=1; $i<$number_of_teams-1; $i++) {
                 $temp = array();
                 $matches[$i]['home'][0] = $matches[$i-1]['home'][0];
                 for($j=0; $j<$number_of_teams-2; $j++) {
                     if($j==0) {
                         $temp[] = $matches[$i-1]['away'][$j];
                         
                     }
                     else if($j==$number_of_teams/2-1 ) {
                         $temp[] = $matches[$i-1]['home'][$j]; 
                         $temp[] = $matches[$i-1]['away'][$j];
                         
                    }
                     else if($j<$number_of_teams/2-1){
                        $temp[] = $matches[$i-1]['home'][$j];
                    }
                    else if($number_of_teams>2) {
                        $temp[] = $matches[$i-1]['away'][$j-2*($j-($number_of_teams/2-1))];
                    }
                 }
                 
                 
                 $elem = array_shift($temp);
                 array_push($temp, $elem);
                 
                 
                 for($j=0; $j<$number_of_teams-2; $j++) {
                     
                     if($j==0) {
                         $matches[$i]['away'][$j] = $temp[$j];
                     }
                     else if($j==$number_of_teams/2-1) {
                         $matches[$i]['home'][$j] = $temp[$j]; 
                         $matches[$i]['away'][$j] = $temp[$j+1];
                    }
                     else if($j<$number_of_teams/2-1){
                        $matches[$i]['home'][$j] = $temp[$j];
                    }
                    else if($number_of_teams>2) {
                        $matches[$i]['away'][$j-2*($j-($number_of_teams/2-1))] = $temp[$j+1];;
                    }
                 }
                 
             }
             
             for($i=0; $i<$number_of_teams-1; $i++) {
                 if($i%2==1) {
                     $temp = $matches[$i]['home'][0];
                     $matches[$i]['home'][0] = $matches[$i]['away'][0];
                     $matches[$i]['away'][0] = $temp;
                 }
             }
             
             for($i=0; $i<$number_of_teams-1; $i++) {
                 for ($j=0; $j<$number_of_teams/2;$j++) {
                     $matches[$i+$number_of_teams-1]['home'][$j] = $matches[$i]['away'][$j];
                     $matches[$i+$number_of_teams-1]['away'][$j] = $matches[$i]['home'][$j];
                 }
             }
             
             for($i=0; $i<2*($number_of_teams-1); $i++) {
                 for ($j=0; $j<$number_of_teams/2;$j++) {
                     insertMatch($matches[$i]['home'][$j],$matches[$i]['away'][$j],$i+1,$j+1,$tournamentID,$mysqli,$type);
                 }
             }
             
             
             
             
             
             
             
            }
            
        }
        
        
        for($i=1; $i<=$number_of_teams; $i++) {
            $query = "INSERT INTO `teams_tournaments`(`teamID`,`tournamentID`)"
                    . "VALUES(". $teamIDs[$i-1] . "," . $tournamentID . ")";
                    $result = mysqli_query($mysqli,$query);
        
                    if(!$result) {
                        
                    deleteTournament($tournamentID,$mysqli);
                    header("Location: newTournamentProForm.php?err=4");
                    exit;
                    }
                    
            $query = "INSERT INTO `teams_notifications`(`teamID`,`topic`,`time_stamp`)"
                    . "VALUES(". $teamIDs[$i-1] . ",6," . time() . ")";
                    $result = mysqli_query($mysqli,$query);
        
                    if(!$result) {
                        
                    deleteTournament($tournamentID,$mysqli);
                    header("Location: newTournamentProForm.php?err=4");
                    exit;
                    }        
        }
        
        $memberID =  isLoggedIn($mysqli);
            
         $query = "INSERT INTO `admin_tournaments`(`memberID`,`tournamentID`)"
                    . "VALUES(". $memberID . "," . $tournamentID . ")";
                    $result = mysqli_query($mysqli,$query);
        
                    if(!$result) {
                    deleteTournament($tournamentID,$mysqli);
                    header("Location: newTournamentProForm.php?err=4");
                    exit;
                    }  
            
        $query = "INSERT INTO `followed_tournaments`(`memberID`,`tournamentID`)"
                    . "VALUES(". $memberID . "," . $tournamentID . ")";
                    $result = mysqli_query($mysqli,$query);
        
                    if(!$result) {
                    deleteTournament($tournamentID,$mysqli);
                    header("Location: newTournamentProForm.php?err=4");
                    exit;
                    }  
            
                    
            $mysqli->commit();
            $mysqli->autocommit(true);
            header("Location: home.php?err=5");
            exit;
}
     
    function deleteTournament($tournamentID,$mysqli) {
       
        $mysqli->rollback();
    
    }
    
    function insertMatch($teamID1,$teamID2,$round,$i,$tournamentID,$mysqli,$type) {
        if ($type == 0 && $round==1) {
        $row = intval(($i-1)/2)+1;
        }
        else {
            $row = $i;
        }
        
        $query = "INSERT INTO `matches`(`home_team`,`guest_team`,`tournamentID`,`round`,`row`)"
                    . "VALUES(". $teamID1 . "," . $teamID2 . "," . $tournamentID . "," . $round . "," . $row . ")";
                    $result = mysqli_query($mysqli,$query);
                  
                    if(!$result) {
                        
                    deleteTournament($tournamentID,$mysqli);
                    header("Location: newTournamentProForm.php?err=4");
                    exit;
                    }
    }
    
        

        
?>

