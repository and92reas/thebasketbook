<?php

require("head.php");

if (isset($_POST['submitButton'])) {
    if(!isset($_POST['playerName']) || $_POST['playerName']==NULL) {
        header("Location: newPlayerForm.php?err=0");
        exit;
    }
    else if(!(((isset($_POST['day']) && $_POST['day']!=NULL) && (isset($_POST['month']) && $_POST['month']!=NULL) 
            && (isset($_POST['year']) && $_POST['year']!=NULL)) || ((!isset($_POST['day']) || $_POST['day']==NULL) && (!isset($_POST['month']) 
            || $_POST['month']==NULL) && (!isset($_POST['year']) || $_POST['year']==NULL))) || ((isset($_POST['day']) && $_POST['day']!=NULL) && ($_POST['day'] < 1 || $_POST['day']>31 || ($_POST['month']<1 || $_POST['month']>12) 
            || ($_POST['year'] < 1910 || $_POST['year'] > 2010)))) 
             {
        header("Location: newPlayerForm.php?err=1");
        exit;
    }
    
    $player_name = mysqli_real_escape_string($mysqli,$_POST['playerName']);
    
    if(isset($_POST['day']) && $_POST['day']!=NULL) {
    $birthdate = mysqli_real_escape_string($mysqli,$_POST['day']) . "/" 
            . mysqli_real_escape_string($mysqli,$_POST['month']) . "/" .
            mysqli_real_escape_string($mysqli,$_POST['year']);
    }
    else {
        $birthdate = "unknown";
    }
    if(isset($_POST['presentTeam']) && $_POST['presentTeam']!=NULL) {
    $present_team = mysqli_real_escape_string($mysqli,$_POST['presentTeam']);
    }
    else {
    $present_team = "unknown";    
    }
    if(isset($_POST['position']) && $_POST['position']!=NULL) {
    $position = mysqli_real_escape_string($mysqli,$_POST['position']);
    }
    else {
    $position = "unknown";    
    }
    if(isset($_POST['loanedBy']) && $_POST['loanedBy']!=NULL) {
    $loaned_by = mysqli_real_escape_string($mysqli,$_POST['loanedBy']);
    }
    else {
    $loaned_by = "none";    
    }
    
    $past_teams_number = 0;
    
    if(isset($_POST['pastTeam1']) && $_POST['pastTeam1']!=NULL) {
    $past_team1 = mysqli_real_escape_string($mysqli,$_POST['pastTeam1']);
    $past_teams_number = $past_teams_number +1;
    }
    
    if(isset($_POST['pastTeam2']) && $_POST['pastTeam2']!=NULL) {
    $past_team2 = mysqli_real_escape_string($mysqli,$_POST['pastTeam2']);
    $past_teams_number = $past_teams_number +1;
    }
    
    if(isset($_POST['pastTeam3']) && $_POST['pastTeam3']!=NULL) {
    $past_team3 = mysqli_real_escape_string($mysqli,$_POST['pastTeam3']);
    $past_teams_number = $past_teams_number +1;
    }
    
    $query = "SELECT `teamID` FROM `teams` "
            . "WHERE `name` = '". $present_team . "' LIMIT 1";
        $result = mysqli_query($mysqli,$query);
        $row = mysqli_fetch_assoc($result);
        
        if($result->num_rows==0) {
           header("Location: newPlayerForm.php?err=2");
           exit;
        }
        $present_teamID = $row['teamID'];
        
        $query = "SELECT `playerID` FROM `players` "
            . "WHERE `name` = '". $player_name . "' LIMIT 1";
        $result = mysqli_query($mysqli,$query);
        $row = mysqli_fetch_assoc($result);
        
        if($result->num_rows>0) {
           header("Location: newPlayerForm.php?err=4");
           exit;
        }
        
        $mysqli->autocommit(false);
        
        $query = "INSERT INTO `players`(`name`,`present_team`,`position`,`birthdate`,`loaned_by`)"
            . "VALUES('". $player_name . "','" . $present_teamID . "','" . $position . "','" . $birthdate . "','" . $loaned_by . "')";
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            header("Location: newPlayerForm.php?err=3");
            exit;
        }
        
        $query = "SELECT `playerID` FROM `players` "
                . "WHERE `name` = '" . $player_name . "' ORDER BY `playerID` DESC LIMIT 1";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows==0) {
            deletePlayer($playerID,$mysqli);
            header("Location: newPlayerForm.php?err=3");
            exit;
        }
        else {
            $row = mysqli_fetch_assoc($result);
            $playerID = (INT) $row['playerID'];
        }
        
        if($past_teams_number==1) {
        
        $query = "INSERT INTO `past_teams`(`playerID`,`team_name`)"
            . "VALUES(". $playerID . ",'" . $past_team1 . "')";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deletePlayer($playerID,$mysqli);
                header("Location: newPlayerForm.php?err=3");
                exit;
            }
        }
        
        else if($past_teams_number==2) {
           $query = "INSERT INTO `past_teams`(`playerID`,`team_name`)"
            . "VALUES(". $playerID . ",'" . $past_team1 . "'),"
                  . "(". $playerID . ",'" . $past_team2 . "')";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deletePlayer($playerID,$mysqli);
                header("Location: newPlayerForm.php?err=3");
                exit;
            } 
        }
        
        else if($past_teams_number==3) {
           $query = "INSERT INTO `past_teams`(`playerID`,`team_name`)"
            . "VALUES(". $playerID . ",'" . $past_team1 . "'),"
                  . "(". $playerID . ",'" . $past_team2 . "'),"
                  . "(". $playerID . ",'" . $past_team3 . "')";
            $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deletePlayer($playerID,$mysqli);
                header("Location: newPlayerForm.php?err=3");
                exit;
            } 
        }
        
        if($present_team!="unknown") {
            
        $query = "SELECT `teamID` FROM `teams` "
            . "WHERE `name` = '". $present_team . "'";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows==0) {
            deletePlayer($playerID,$mysqli);
            header("Location: newPlayerForm.php?err=3");
            exit;
        }
        else {
            $row = mysqli_fetch_assoc($result);
            $teamID = (INT) $row['teamID'];
        }
            
        $query = "INSERT INTO `teams_notifications`(`teamID`,`topic`,`time_stamp`)"
               . "VALUES(". $teamID . ",5," . time() . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deletePlayer($playerID,$mysqli);
                header("Location: newPlayerForm.php?err=3");
                exit;
            }
        
        }
        
        $memberID =  isLoggedIn($mysqli);
                
        $query = "INSERT INTO `followed_players`(`memberID`,`playerID`)"
               . "VALUES(". $memberID . "," . $playerID . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deletePlayer($playerID,$mysqli);
                header("Location: newPlayerForm.php?err=3");
                exit;
            }
        
        $query = "INSERT INTO `admin_players`(`memberID`,`playerID`)"
               . "VALUES(". $memberID . "," . $playerID . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deletePlayer($playerID,$mysqli);
                header("Location: newPlayerForm.php?err=3");
                exit;
            }
                $mysqli->commit();
                $mysqli->autocommit(true);
                header("Location: home.php?err=3");
                exit;
            
        
    
        
}

function deletePlayer($playerID,$mysqli) {
        $mysqli->rollback();
    }
        

?>

