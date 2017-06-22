<?php

require ("head.php");

if (isset($_POST['submitButton'])) {
    
    
    if(isset($_POST['tID']) && $_POST['tID']!=NULL) {
    $tournamentID = mysqli_real_escape_string($mysqli,$_POST['tID']);
        }
    else {
        header("Location: tournamentSearchForm.php?err=2");
        exit;
    }

    $memberID = isLoggedIn($mysqli);
    
    
    $query = "SELECT * FROM `admin_tournaments` "
            . "WHERE `memberID` = " . $memberID . " AND `tournamentID` = " . $tournamentID . " ";
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows!=1) {
     header("Location: tournamentSearchForm.php?err=3");
     exit;
     }
    
    if(isset($_POST['startDate']) && $_POST['startDate']!=NULL) {
    $start_date = mysqli_real_escape_string($mysqli,$_POST['startDate']);
    }
    else {
    $start_date = "unknown";
    }
    
    if(isset($_POST['endDate']) && $_POST['endDate']!=NULL) {
    $end_date = mysqli_real_escape_string($mysqli,$_POST['endDate']);
    }
    else {
    $end_date = "unknown";    
    }
    
    if(isset($_POST['endDate']) && $_POST['endDate']!=NULL) {
    $area = mysqli_real_escape_string($mysqli,$_POST['endDate']);
    }
    else {
    $area = "unknown";    
    }
    
    $mysqli->autocommit(false); 
    
    $query = "UPDATE `tournaments` "
            . " SET `start_date` = '" . $start_date . "', `end_date` = '" . $end_date . "'"
             .   "WHERE `tournamentID` = " . $tournamentID ;
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            deleteUpdates();
            header("Location: eventSearchForm.php?err=2");
            exit;
        }
    
    
    $query = "INSERT INTO `tournaments_notifications`(`tournamentID`,`topic`,`time_stamp`)"
               . "VALUES(". $tournamentID . ",2," . time() . ")";
        $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                deleteUpdates();
                header("Location: tournamentSearchForm.php?err=2");
                exit;
            }
         
            
         $mysqli->commit();
        $mysqli->autocommit(true); 
         header("Location: tournamentSearchForm.php?err=4");
         exit;   
        
    
    
    
    function deleteUpdates() {
        $mysqli->rollback();
    }
    
    
}
?>

