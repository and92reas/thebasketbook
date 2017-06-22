<?php

function isSiteLoggedIn($mysqli) {
    $sessionID = mysqli_real_escape_string($mysqli,session_id());
    $hash = mysqli_real_escape_string($mysqli,hash("sha512",$sessionID.$_SERVER['HTTP_USER_AGENT']));
    
    
    $query = "SELECT `memberID` FROM `logged_members`"
                              . "WHERE `sessionID` = '" . $sessionID . "' AND `hash` = '" . $hash . "'"
            . " AND `expiration` > " . time() . " ORDER BY `log_memberID` DESC LIMIT 1";
    
    $result = mysqli_query($mysqli,$query);
    
    if($result->num_rows>0) {
       $row = mysqli_fetch_assoc($result);
       return (INT) $row['memberID']; 
    }
    else {
        
        return false;
    }
}

function getSiteUser($mysqli) {
    $memberID = isLoggedIn($mysqli);
    if(!$memberID) {
        
        header("Location: logInForm.php?err=2");
        exit;
    }
    
    $query = "SELECT `name` FROM `members`"
            . "WHERE `memberID` = " . $memberID . " LIMIT 1";
    
    $result = mysqli_query($mysqli,$query);
    
    if($result->num_rows>0) {
    $row = mysqli_fetch_assoc($result);
    return $row['name'];
    }
    
    else {
        return false;
    }
    
}



?>


