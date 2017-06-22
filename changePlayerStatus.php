<?php

require("head.php");

if (isset($_POST['submitButton'])) {
    
    if(isset($_POST['pID']) && $_POST['pID']!=NULL) {
    $playerID = mysqli_real_escape_string($mysqli,$_POST['pID']);
    }
    else {
        header("Location: playerSearchForm.php?err=2");
        exit;
    }
    
    if(!(((isset($_POST['day']) && $_POST['day']!=NULL) && (isset($_POST['month']) && $_POST['month']!=NULL) 
            && (isset($_POST['year']) && $_POST['year']!=NULL)) || ((!isset($_POST['day']) || $_POST['day']==NULL) && (!isset($_POST['month']) 
            || $_POST['month']==NULL) && (!isset($_POST['year']) || $_POST['year']==NULL))) || ((isset($_POST['day']) && $_POST['day']!=NULL) && ($_POST['day'] < 1 || $_POST['day']>31 || ($_POST['month']<1 || $_POST['month']>12) 
            || ($_POST['year'] < 1910 || $_POST['year'] > 2010)))) 
             {
        header("Location: playerSearchForm.php?err=2");
        exit;
    }
    
    
    $memberID = isLoggedIn($mysqli);
    
    
    
    $query = "SELECT * FROM `admin_players` "
            . "WHERE `memberID` = " . $memberID . " AND `playerID` = '" . $playerID . "' LIMIT 1 ";
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows!=1) {
     header("Location: playerSearchForm.php?err=3");
     exit;
     }
     
     
    
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
        
        
        $mysqli->autocommit(false);
        
        $query = "UPDATE `players` "
            . " SET `present_team` = " . $present_teamID . ", `position` = '" . $position . "'"
                . ", `birthdate` = '" . $birthdate . "', `loaned_by` = '" . $loaned_by . "' "
                . "WHERE `playerID` = " . $playerID ;
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            deleteUpdates();
            header("Location: playerSearchForm.php?err=2");
            exit;
        }
        
        $query = "DELETE FROM `past_teams` WHERE `playerID` = " . $playerID;
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            deleteUpdates();
                header("Location: playerSearchForm.php?err=2");
                exit;
            }
        
        
        if($past_teams_number==1) {
        
        $query = "INSERT INTO `past_teams`(`playerID`,`team_name`)"
            . "VALUES(". $playerID . ",'" . $past_team1 . "')";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
                header("Location: playerSearchForm.php?err=2");
                exit;
            }
        }
        
        else if($past_teams_number==2) {
           $query = "INSERT INTO `past_teams`(`playerID`,`team_name`)"
            . "VALUES(". $playerID . ",'" . $past_team1 . "'),"
                  . "(". $playerID . ",'" . $past_team2 . "')";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
                header("Location: playerSearchForm.php?err=2");
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
                deleteUpdates();
                header("Location: playerSearchForm.php?err=2");
                exit;
            } 
        }
        
        if($present_team!="unknown") {
            
                   
        $query = "INSERT INTO `teams_notifications`(`teamID`,`topic`,`time_stamp`)"
               . "VALUES(". $present_teamID . ",5," . time() . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
                header("Location: playerSearchForm.php?err=2");
                exit;
            }
        
        }
        
        $query = "INSERT INTO `players_notifications`(`playerID`,`topic`,`time_stamp`)"
               . "VALUES(". $playerID . ",2," . time() . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
                header("Location: playerSearchForm.php?err=2");
                exit;
            }
        
        
        
        
        $mysqli->commit();
        $mysqli->autocommit(true);
        header("Location: playerSearchForm.php?err=4");
                exit;
        
    
}

function deleteUpdates() {
        $mysqli->rollback();
    }   
?>

