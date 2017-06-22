<?php

require ("head.php");

if (isset($_POST['submitButton'])) {
    
    
    if(isset($_POST['eID']) && $_POST['eID']!=NULL) {
    $eventID = mysqli_real_escape_string($mysqli,$_POST['eID']);
        }
    else {
        header("Location: eventSearchForm.php?err=2");
        exit;
    }

    $memberID = isLoggedIn($mysqli);
    
    
    $query = "SELECT * FROM `admin_events` "
            . "WHERE `memberID` = " . $memberID . " AND `eventID` = '" . $eventID . "' ";
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows!=1) {
     header("Location: eventSearchForm.php?err=3");
     exit;
     }
    
    if(isset($_POST['birthdate']) && $_POST['birthdate']!=NULL) {
    $date = mysqli_real_escape_string($mysqli,$_POST['date']);
    }
    else {
    $date = "unknown";
    }
    
    if(isset($_POST['area']) && $_POST['area']!=NULL) {
    $area = mysqli_real_escape_string($mysqli,$_POST['area']);
    }
    else {
    $area = "unknown";    
    }

    $players_number = 0;
    
    if(isset($_POST['player1']) && $_POST['player1']!=NULL) {
    $player1 = mysqli_real_escape_string($mysqli,$_POST['player1']);
    $players_number = $players_number +1;
    }
    
    if(isset($_POST['player2']) && $_POST['player2']!=NULL) {
    $player2 = mysqli_real_escape_string($mysqli,$_POST['player2']);
    $players_number = $players_number +1;
    }
    
    if(isset($_POST['player3']) && $_POST['player3']!=NULL) {
    $player3 = mysqli_real_escape_string($mysqli,$_POST['player3']);
    $players_number = $players_number +1;
    }
    
    $teams_number = 0;
    
    if(isset($_POST['team1']) && $_POST['team1']!=NULL) {
    $team1 = mysqli_real_escape_string($mysqli,$_POST['team1']);
    $teams_number = $teams_number +1;
    }
    
    if(isset($_POST['team2']) && $_POST['team2']!=NULL) {
    $team2 = mysqli_real_escape_string($mysqli,$_POST['team2']);
    $teams_number = $teams_number +1;
    }
    
    if(isset($_POST['team3']) && $_POST['team3']!=NULL) {
    $team3 = mysqli_real_escape_string($mysqli,$_POST['team3']);
    $teams_number = $teams_number +1;
    }
    
    $mysqli->autocommit(false);
    
          $query = "UPDATE `events` "
            . " SET `date` = '" . $date . "', `area` = '" . $area . "'"
             .   "WHERE `eventID` = " . $eventID ;
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            deleteUpdates();
            header("Location: eventSearchForm.php?err=2");
            exit;
        }
        
        $query = "DELETE FROM `events_players` WHERE `eventID` = " . $eventID;
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            deleteUpdates();
                header("Location: eventSearchForm.php?err=2");
                exit;
            }
        
        if($players_number==1) {
        
        $query = "SELECT `playerID` FROM `players` "
                . "WHERE `name` = '" . $player1 . "' LIMIT 1";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows==0) {
            deleteUpdates();
            header("Location: eventSearchForm.php?err=2");
            exit;
        }
        else {
            $row = mysqli_fetch_assoc($result);
            $playerID1 = (INT) $row['playerID'];
        }
        
        $query = "INSERT INTO `events_players`(`eventID`,`playerID`)"
            . "VALUES(". $eventID . "," . $playerID1 . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
                header("Location: newEventForm.php?err=2");
                exit;
            }
        
        $query = "INSERT INTO `players_notifications`(`playerID`,`topic`,`time_stamp`)"
            .    "VALUES(". $playerID1 . ",4," . time() . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
                header("Location: newEventForm.php?err=2");
                exit;
            }
        }
            
        else if($players_number==2) {
        
        $query = "SELECT `playerID` FROM `players` "
                . "WHERE `name` = '" . $player1 . "' OR `name` = '" . $player2 . "' LIMIT 2";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows<2) {
            deleteUpdates();
            header("Location: eventSearchForm.php?err=2");
            exit;
        }
        else {
            $row = mysqli_fetch_assoc($result);
            $playerID1 = (INT) $row['playerID'];
            $row = mysqli_fetch_assoc($result);
            $playerID2 = (INT) $row['playerID'];
        }
        
        $query = "INSERT INTO `events_players`(`eventID`,`playerID`)"
            . "VALUES(". $eventID . "," . $playerID1 . "),"
                  . "(". $eventID . "," . $playerID2 . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
                header("Location: eventSearchForm.php?err=2");
                exit;
            }
        
        $query = "INSERT INTO `players_notifications`(`playerID`,`topic`,`time_stamp`)"
            .    "VALUES(". $playerID1 . ",4," . time() . "),"
                     . "(" . $playerID2 . ",4," . time() . ")";
                         
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
                header("Location: eventSearchForm.php?err=2");
                exit;
            }    
        
            
        }
        
        else if($players_number==3) {
        
        $query = "SELECT `playerID` FROM `players` "
                . "WHERE `name` = '" . $player1 . "' OR `name` = '" . $player2 . "' "
                . " OR `name` = '" . $player3 . "' LIMIT 3";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows<3) {
            deleteUpdates();
            header("Location: eventSearchForm.php?err=2");
            exit;
        }
        else {
            $row = mysqli_fetch_assoc($result);
            $playerID1 = (INT) $row['playerID'];
            $row = mysqli_fetch_assoc($result);
            $playerID2 = (INT) $row['playerID'];
            $row = mysqli_fetch_assoc($result);
            $playerID3 = (INT) $row['playerID'];
        }
        
        $query = "INSERT INTO `events_players`(`eventID`,`playerID`)"
            . "VALUES(". $eventID . "," . $playerID1 . "),"
                  . "(". $eventID . "," . $playerID2 . "),"
                  . "(". $eventID . "," . $playerID3 . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
               header("Location: eventSearchForm.php?err=2");
                exit;
            }
        
        $query = "INSERT INTO `players_notifications`(`playerID`,`topic`,`time_stamp`)"
            .    "VALUES(". $playerID1 . ",4," . time() . "),"
                     . "(" . $playerID2 . ",4," . time() . "),"
                     . "(" . $playerID3 . ",4," . time() . ")";
                         
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
                header("Location: eventSearchForm.php?err=2");
                exit;
            }    
        
            
        }
        
        
        $query = "DELETE FROM `events_teams` WHERE `eventID` = " . $eventID;
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            deleteUpdates();
                header("Location: eventSearchForm.php?err=2");
                exit;
            }
        
        //teams
        if($teams_number==1) {
            
        
        $query = "SELECT `teamID` FROM `teams` "
                . "WHERE `name` = '" . $team1 . "' LIMIT 1";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows==0) {
            deleteUpdates();
            header("Location: eventSearchForm.php?err=2");
            exit;
        }
        else {
            $row = mysqli_fetch_assoc($result);
            $teamID1 = (INT) $row['teamID'];
        }
        
        $query = "INSERT INTO `events_teams`(`eventID`,`teamID`)"
            . "VALUES(". $eventID . "," . $teamID1 . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
                header("Location: eventSearchForm.php?err=2");
                exit;
            }
        
        $query = "INSERT INTO `teams_notifications`(`teamID`,`topic`,`time_stamp`)"
            .    "VALUES(". $teamID1 . ",8," . time() . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
                header("Location: eventSearchForm.php?err=2");
                exit;
            }
        }
            
        else if($teams_number==2) {
        
        $query = "SELECT `teamID` FROM `teams` "
                . "WHERE `name` = '" . $team1 . "' OR `name` = '" . $team2 . "' LIMIT 2";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows<2) {
            deleteUpdates();
            header("Location: eventSearchForm.php?err=2");
            exit;
        }
        else {
            $row = mysqli_fetch_assoc($result);
            $teamID1 = (INT) $row['teamID'];
            $row = mysqli_fetch_assoc($result);
            $teamID2 = (INT) $row['teamID'];
        }
        
        $query = "INSERT INTO `events_teams`(`eventID`,`teamID`)"
            . "VALUES(". $eventID . "," . $teamID1 . "),"
                  . "(". $eventID . "," . $teamID2 . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
                header("Location: eventSearchForm.php?err=2");
                exit;
            }
        
        $query = "INSERT INTO `teams_notifications`(`teamID`,`topic`,`time_stamp`)"
            .    "VALUES(". $teamID1 . ",8," . time() . "),"
                     . "(" . $teamID2 . ",8," . time() . ")";
                         
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
                header("Location: eventSearchForm.php?err=2");
                exit;
            }    
        
            
        }
        
        else if($teams_number==3) {
        
        $query = "SELECT `teamID` FROM `teams` "
                . "WHERE `name` = '" . $team1 . "' OR `name` = '" . $team2 . "' "
                . " OR `name` = '" . $team3 . "' LIMIT 3";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows<3) {
            deleteUpdates();
            header("Location: eventSearchForm.php?err=2");
            exit;
        }
        else {
            $row = mysqli_fetch_assoc($result);
            $teamID1 = (INT) $row['teamID'];
            $row = mysqli_fetch_assoc($result);
            $teamID2 = (INT) $row['teamID'];
            $row = mysqli_fetch_assoc($result);
            $teamID3 = (INT) $row['teamID'];
        }
        
        $query = "INSERT INTO `events_teams`(`eventID`,`teamID`)"
            . "VALUES(". $eventID . "," . $teamID1 . "),"
                  . "(". $eventID . "," . $teamID2 . "),"
                  . "(". $eventID . "," . $teamID3 . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
                header("Location: eventSearchForm.php?err=2");
                exit;
            }
        
        $query = "INSERT INTO `teams_notifications`(`teamID`,`topic`,`time_stamp`)"
            .    "VALUES(". $teamID1 . ",8," . time() . "),"
                     . "(" . $teamID2 . ",8," . time() . "),"
                     . "(" . $teamID3 . ",8," . time() . ")";
                         
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
                header("Location: eventSearchForm.php?err=2");
                exit;
            }    
        
            
        }
        
        
        $query = "INSERT INTO `events_notifications`(`eventID`,`topic`,`time_stamp`)"
               . "VALUES(". $eventID . ",1," . time() . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
                header("Location: eventSearchForm.php?err=2");
                exit;
            }
         $mysqli->commit();
         $mysqli->autocommit(true);   
            
         header("Location: eventSearchForm.php?err=4");
         exit;   
        }
        
        
        function deleteUpdates() {
        $mysqli->rollback();
    }    
        
    
    
    

?>

