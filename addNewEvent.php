<?php

require ("head.php");

if (isset($_POST['submitButton'])) {
    if(!isset($_POST['eventDescription']) || $_POST['eventDescription']==NULL) {
        header("Location: newEventForm.php?err=0");
        exit;
    }
    else if(!(((isset($_POST['day']) && $_POST['day']!=NULL) && (isset($_POST['month']) && $_POST['month']!=NULL) 
            && (isset($_POST['year']) && $_POST['year']!=NULL)) || ((!isset($_POST['day']) || $_POST['day']==NULL) && (!isset($_POST['month']) 
            || $_POST['month']==NULL) && (!isset($_POST['year']) || $_POST['year']==NULL))) || (isset($_POST['day']) && $_POST['day']!=NULL)
            && ($_POST['day'] < 1 || $_POST['day']>31 || $_POST['month']<1 || $_POST['month']>12 || (INT) $_POST['year'] > 2040 ))  
             {
        header("Location: newEventForm.php?err=1");
        exit;
    }
    
    $event_desc = mysqli_real_escape_string($mysqli,$_POST['eventDescription']);
    
    if(isset($_POST['area']) && $_POST['area']!=NULL) {
    $area = mysqli_real_escape_string($mysqli,$_POST['area']);
    }
    else {
    $area = "unknown";    
    }

    if(isset($_POST['day']) && $_POST['day']!=NULL) {
    $date = mysqli_real_escape_string($mysqli,$_POST['day']) . "/" 
            . mysqli_real_escape_string($mysqli,$_POST['month']) . "/" .
            mysqli_real_escape_string($mysqli,$_POST['year']);
    }
    else {
    $date = "unknown";
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
    
    $query = "SELECT `description` FROM `events` "
            . "WHERE `description` = '". $event_desc . "' LIMIT 1";
    $result = mysqli_query($mysqli,$query);
            
        if($result->num_rows>0) {
            
           header("Location: newEventForm.php?err=2");
           exit;
        }
    else {
        
        $mysqli->autocommit(false);
        
            $query = "INSERT INTO `events`(`description`,`date`,`area`)"
            . "VALUES('". $event_desc . "','" . $date . "','" . $area . "')";
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            header("Location: newEventForm.php?err=3");
            exit;
        }
        
        $query = "SELECT `eventID` FROM `events` "
                . "WHERE `description` = '" . $event_desc . "' ORDER BY `eventID` DESC LIMIT 1";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows==0) {
            deleteEvent($eventID,$mysqli);
            header("Location: newEventForm.php?err=3");
            exit;
        }
        else {
            $row = mysqli_fetch_assoc($result);
            $eventID = (INT) $row['eventID'];
        }
    
        
        
        
        if($players_number==1) {
        
        $query = "SELECT `playerID` FROM `players` "
                . "WHERE `name` = '" . $player1 . "' LIMIT 1";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows==0) {
            deleteEvent($eventID,$mysqli);
            header("Location: newEventForm.php?err=5");
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
                deleteEvent($eventID,$mysqli);
                header("Location: newEventForm.php?err=3");
                exit;
            }
        
        $query = "INSERT INTO `players_notifications`(`playerID`,`topic`,`time_stamp`)"
            .    "VALUES(". $playerID1 . ",4," . time() . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteEvent($eventID,$mysqli);
                header("Location: newEventForm.php?err=3");
                exit;
            }
        }
            
        else if($players_number==2) {
        
        $query = "SELECT `playerID` FROM `players` "
                . "WHERE `name` = '" . $player1 . "' OR `name` = '" . $player2 . "' LIMIT 2";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows<2) {
            deleteEvent($eventID,$mysqli);
            header("Location: newEventForm.php?err=5");
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
                deleteEvent($eventID,$mysqli);
                header("Location: newEventForm.php?err=3");
                exit;
            }
        
        $query = "INSERT INTO `players_notifications`(`playerID`,`topic`,`time_stamp`)"
            .    "VALUES(". $playerID1 . ",4," . time() . "),"
                     . "(" . $playerID2 . ",4," . time() . ")";
                         
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteEvent($eventID,$mysqli);
                header("Location: newEventForm.php?err=3");
                exit;
            }    
        
            
        }
        
        else if($players_number==3) {
        
        $query = "SELECT `playerID` FROM `players` "
                . "WHERE `name` = '" . $player1 . "' OR `name` = '" . $player2 . "' "
                . " OR `name` = '" . $player3 . "' LIMIT 3";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows<3) {
            
            deleteEvent($eventID,$mysqli);
            header("Location: newEventForm.php?err=5");
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
                deleteEvent($eventID,$mysqli);
                header("Location: newEventForm.php?err=3");
                exit;
            }
        
        $query = "INSERT INTO `players_notifications`(`playerID`,`topic`,`time_stamp`)"
            .    "VALUES(". $playerID1 . ",4," . time() . "),"
                     . "(" . $playerID2 . ",4," . time() . "),"
                     . "(" . $playerID3 . ",4," . time() . ")";
                         
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteEvent($eventID,$mysqli);
                header("Location: newEventForm.php?err=3");
                exit;
            }    
        
            
        }
        
        
        //teams
        if($teams_number==1) {
            
        
        $query = "SELECT `teamID` FROM `teams` "
                . "WHERE `name` = '" . $team1 . "' LIMIT 1";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows==0) {
            deleteEvent($eventID,$mysqli);
            header("Location: newEventForm.php?err=4");
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
                deleteEvent($eventID,$mysqli);
                header("Location: newEventForm.php?err=3");
                exit;
            }
        
        $query = "INSERT INTO `teams_notifications`(`teamID`,`topic`,`time_stamp`)"
            .    "VALUES(". $teamID1 . ",8," . time() . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteEvent($eventID,$mysqli);
                header("Location: newEventForm.php?err=3");
                exit;
            }
        }
            
        else if($teams_number==2) {
        
        $query = "SELECT `teamID` FROM `teams` "
                . "WHERE `name` = '" . $team1 . "' OR `name` = '" . $team2 . "' LIMIT 2";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows<2) {
            deleteEvent($eventID,$mysqli);
            header("Location: newEventForm.php?err=4");
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
                deleteEvent($eventID,$mysqli);
                header("Location: newEventForm.php?err=3");
                exit;
            }
        
        $query = "INSERT INTO `teams_notifications`(`teamID`,`topic`,`time_stamp`)"
            .    "VALUES(". $teamID1 . ",8," . time() . "),"
                     . "(" . $teamID2 . ",8," . time() . ")";
                         
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteEvent($eventID,$mysqli);
                header("Location: newEventForm.php?err=3");
                exit;
            }    
        
            
        }
        
        else if($teams_number==3) {
        
        $query = "SELECT `teamID` FROM `teams` "
                . "WHERE `name` = '" . $team1 . "' OR `name` = '" . $team2 . "' "
                . " OR `name` = '" . $team3 . "' LIMIT 3";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows<3) {
            deleteEvent($eventID,$mysqli);
            header("Location: newEventForm.php?err=4");
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
                deleteEvent($eventID,$mysqli);
                header("Location: newEventForm.php?err=3");
                exit;
            }
        
        $query = "INSERT INTO `teams_notifications`(`teamID`,`topic`,`time_stamp`)"
            .    "VALUES(". $teamID1 . ",8," . time() . "),"
                     . "(" . $teamID2 . ",8," . time() . "),"
                     . "(" . $teamID3 . ",8," . time() . ")";
                         
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteEvent($eventID,$mysqli);
                header("Location: newEventForm.php?err=3");
                exit;
            }    
        
            
        }
        
        $memberID =  isLoggedIn($mysqli);
                
        $query = "INSERT INTO `followed_events`(`memberID`,`eventID`)"
               . "VALUES(". $memberID . "," . $eventID . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteEvent($eventID,$mysqli);
                header("Location: newEventForm.php?err=3");
                exit;
            }
        
        $query = "INSERT INTO `admin_events`(`memberID`,`eventID`)"
               . "VALUES(". $memberID . "," . $eventID . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteEvent($eventID,$mysqli);
                header("Location: home.php?err=4");
                exit;
            }    
         $mysqli->commit();
         $mysqli->autocommit(true);  
          header("Location: home.php?err=4");
                exit;  
        
        }
        
        
        
    }
    
    function deleteEvent($eventID,$mysqli) {
        
        $mysqli->rollback(); 
    }

?>
