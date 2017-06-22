<?php

require("head.php");

if (isset($_POST['submitButton'])) {
        
    if(!isset($_POST['username']) || strlen($_POST['username'])<=2) {
        header("Location: userSettingsForm.php?err=0");
        exit;
    }
    else if(!isset($_POST['password']) || strlen($_POST['password'])<=5) {
        header("Location: userSettingsForm.php?err=1");
        exit;
    }
    else if(!isset($_POST['password2']) || strcmp($_POST['password'],$_POST['password2']) != 0) {
        header("Location: userSettingsForm.php?err=2");
        exit;
    }
    else if(!isset($_POST['password0'])) {
        header("Location: userSettingsForm.php?err=3");
        exit;
    }
    
    $memberID = isLoggedIn($mysqli);
    $old_password = hash("sha512",mysqli_real_escape_string($mysqli,$_POST['password0']));
    $new_name = mysqli_real_escape_string($mysqli,$_POST['username']);
    
    $query = "SELECT `memberID`,`name` FROM `members`"
           . " WHERE  `memberID` = " . $memberID . " AND `password` = '" . $old_password . "'" ;
    $result = mysqli_query($mysqli,$query);
    $row = mysqli_fetch_assoc($result);
    
    if(!$result) {
        header("Location: userSettingsForm.php?err=6");
        exit;
    }
    
    if($result->num_rows==0) {
        header("Location: userSettingsForm.php?err=4");
        exit;
    }
    if(strcmp($row['name'],$new_name)!=0) {
        
        $query = "SELECT `memberID` FROM `members`"
           . " WHERE  `name` = '" . $new_name . "'";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows>0) {
            header("Location: userSettingsForm.php?err=5");
            exit;
        }
    }
        
        $new_password = hash("sha512",mysqli_real_escape_string($mysqli,$_POST['password']));
        $new_mail = mysqli_real_escape_string($mysqli,$_POST['email']);
        $new_fav_player = mysqli_real_escape_string($mysqli,$_POST['fav_player']);
        $new_fav_team = mysqli_real_escape_string($mysqli,$_POST['fav_team']);
        $new_fav_position = mysqli_real_escape_string($mysqli,$_POST['fav_position']);
                
        $query = "UPDATE `members`"
           . " SET `name` = '" . $new_name . "' , `password` = '" . $new_password . "' , `mail` = '" . $new_mail . "'"
           . " , `fav_player` = '" . $new_fav_player . "' , `fav_team` = '" . $new_fav_team . "' , `fav_position` = '" 
           . $new_fav_position . "' WHERE  `memberID` = '" . $memberID . "'";
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            header("Location: home.php?err=2");
            exit;
        }
        
            header("Location: home.php?err=1");
            exit;
        
       }
        
    
        
      
    
        
    
    
        
    
    
    
    
    
    
    
    
    
    


?>

