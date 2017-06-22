<?php

require ("head.php");

if (isset($_POST['submitButton'])) {
    if(!isset($_POST['teamName']) || $_POST['teamName']==NULL) {
        header("Location: newTeamForm.php?err=0");
        exit;
    }
    
    $team_name = mysqli_real_escape_string($mysqli,$_POST['teamName']);
    
    if(isset($_POST['area']) && $_POST['area']!=NULL) {
    $area = mysqli_real_escape_string($mysqli,$_POST['area']);
    }
    else {
    $area = "unknown";    
    }
    
    if(isset($_POST['court']) && $_POST['court']!=NULL) {
    $court = mysqli_real_escape_string($mysqli,$_POST['court']);
    }
    else {
    $court = "unknown";    
    }
    
    if(isset($_POST['foundationYear']) && $_POST['foundationYear']!=NULL) {
    $foundation_year = mysqli_real_escape_string($mysqli,$_POST['foundationYear']);
    }
    else {
    $foundation_year = "????";    
    }
    
    if(isset($_POST['coach']) && $_POST['coach']!=NULL) {
    $coach = mysqli_real_escape_string($mysqli,$_POST['coach']);
    }
    else {
    $coach = "unknown";    
    }

    $successes_number = 0;
    
    if(isset($_POST['success1']) && $_POST['success1']!=NULL) {
    $success1 = mysqli_real_escape_string($mysqli,$_POST['success1']);
    $successes_number = $successes_number +1;
    }
    
    if(isset($_POST['success2']) && $_POST['success2']!=NULL) {
    $success2 = mysqli_real_escape_string($mysqli,$_POST['success2']);
    $successes_number = $successes_number +1;
    }
    
    if(isset($_POST['success3']) && $_POST['success3']!=NULL) {
    $success3 = mysqli_real_escape_string($mysqli,$_POST['success3']);
    $successes_number = $successes_number +1;
    }
    
    $query = "SELECT `name` FROM `teams` "
            . "WHERE `name` = '". $team_name . "' LIMIT 1";
    $result = mysqli_query($mysqli,$query);
            
        if($result->num_rows>0) {
           header("Location: newTeamForm.php?err=1");
           exit;
        }
        else {
            
        $mysqli->autocommit(false);    
            
        $query = "INSERT INTO `teams`(`name`,`area`,`court`,`foundation_year`,`coach`)"
            . "VALUES('". $team_name . "','" . $area . "','" . $court . "','" . $foundation_year . "','" . $coach . "')";
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            
            header("Location: newTeamForm.php?err=2");
            exit;
        }
        
        $query = "SELECT `teamID` FROM `teams` "
                . " WHERE `name` = '" . $team_name . "' ORDER BY `teamID` LIMIT 1";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows==0) {
            header("Location: newTeamForm.php?err=2");
            exit;
        }
        else {
            $row = mysqli_fetch_assoc($result);
            $teamID = (INT) $row['teamID'];
        }
         
        if($successes_number==1) {
        
        $query = "INSERT INTO `teams_successes`(`teamID`,`success`)"
            . "VALUES(". $teamID . ",'" . $success1 . "')";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteTeam($teamID,$mysqli);
                header("Location: newTeamForm.php?err=2");
                exit;
            }
        }
        
        else if($successes_number==2) {
           $query = "INSERT INTO `teams_successes`(`teamID`,`success`)"
            . "VALUES(". $teamID . ",'" . $success1 . "'),"
                  . "(". $teamID . ",'" . $success2 . "')";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteTeam($teamID,$mysqli);
                header("Location: newTeamForm.php?err=2");
                exit;
            } 
        }
        
        else if($successes_number==3) {
           $query = "INSERT INTO `teams_successes`(`teamID`,`success`)"
            . "VALUES(". $teamID . ",'" . $success1 . "'),"
                  . "(". $teamID . ",'" . $success2 . "'),"
                  . "(". $teamID . ",'" . $success3 . "')";
            $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteTeam($teamID,$mysqli);
                header("Location: newTeamForm.php?err=2");
                exit;
            } 
        }
        
        $memberID =  isLoggedIn($mysqli);
                
        $query = "INSERT INTO `followed_teams`(`memberID`,`teamID`)"
               . "VALUES(". $memberID . "," . $teamID . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteTeam($teamID,$mysqli);
                header("Location: newTeamForm.php?err=2");
                exit;
            }
        
        $query = "INSERT INTO `admin_teams`(`memberID`,`teamID`)"
               . "VALUES(". $memberID . "," . $teamID . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteTeam($teamID,$mysqli);
                header("Location: newTeamForm.php?err=2");
                exit;
            }
                
                $mysqli->commit();
                $mysqli->autocommit(true);
                header("Location: home.php?err=6");
                exit;
              
            
            
        }
    
}

function deleteTeam($teamID,$mysqli) {
        $mysqli->rollback();
    }

?>