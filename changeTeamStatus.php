<?php

require ("head.php");

if (isset($_POST['submitButton'])) {
        
    if(isset($_POST['tID']) && $_POST['tID']!=NULL) {
        $teamID= mysqli_real_escape_string($mysqli,$_POST['tID']);
        }
    else {
        
        header("Location: teamSearchForm.php?err=2");
        exit;
    }

    $memberID = isLoggedIn($mysqli);
    
    
    
    $query = "SELECT * FROM `admin_teams` "
            . "WHERE `memberID` = " . $memberID . " AND `teamID` = '" . $teamID . "' LIMIT 1 ";
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows!=1) {
     header("Location: teamSearchForm.php?err=3");
     exit;
     }
       
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
    
        $mysqli->autocommit(false);
    
       $query = "UPDATE `teams` "
            . " SET `area` = '" . $area . "', `court` = '" . $court . "'"
                . ", `foundation_year` = '" . $foundation_year . "', `coach` = '" . $coach . "' "
                . "WHERE `teamID` = " . $teamID ;
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            deleteUpdates();
            header("Location: teamSearchForm.php?err=2");
            exit;
        }
        
        $query = "DELETE FROM `teams_successes` WHERE `teamID` = " . $teamID;
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            deleteUpdates();
                header("Location: teamSearchForm.php?err=2");
                exit;
            }
        
        if($successes_number==1) {
        
        $query = "INSERT INTO `teams_successes`(`teamID`,`success`)"
            . "VALUES(". $teamID . ",'" . $success1 . "')";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
                header("Location: teamSearchForm.php?err=2");
                exit;
            }
        }
        
        else if($successes_number==2) {
           $query = "INSERT INTO `teams_successes`(`teamID`,`success`)"
            . "VALUES(". $teamID . ",'" . $success1 . "'),"
                  . "(". $teamID . ",'" . $success2 . "')";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
                header("Location: teamSearchForm.php?err=2");
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
                deleteUpdates();
                header("Location: teamSearchForm.php?err=2");
                exit;
            } 
        }
        
        $query = "INSERT INTO `teams_notifications`(`teamID`,`topic`,`time_stamp`)"
               . "VALUES(". $teamID . ",2," . time() . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
                header("Location: teamSearchForm.php?err=2");
                exit;
            }
        
         $mysqli->commit();   
         $mysqli->autocommit(true);
         
         header("Location: teamSearchForm.php?err=4");
         exit;   
        }

        function deleteUpdates() {
        $mysqli->rollback();
    }   




?>

