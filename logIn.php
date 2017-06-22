<?php

require ("head.php");

if (isset($_POST['submitButton'])) {
        
    $name = mysqli_real_escape_string($mysqli,$_POST['username']);
    $password = hash("sha512",mysqli_real_escape_string($mysqli,$_POST['password']));
    
    
    $query = "SELECT `memberID` FROM `members`"
                              . " WHERE  `name` = '" . $name . "' AND `password` = '" . $password . "'" ;
    $result = mysqli_query($mysqli,$query);
    
        if($result->num_rows==0) {
        header("Location: logInForm.php?err=0");
        exit;
    }
        else {
        $row = mysqli_fetch_assoc($result);
        $memberID = (INT) $row['memberID'];
        $sessionID = mysqli_real_escape_string($mysqli,session_id());
        $hash = mysqli_real_escape_string($mysqli,hash("sha512",$sessionID.$_SERVER['HTTP_USER_AGENT']));
        $expiration = time() + $delay;
        
        $query = "INSERT INTO `logged_members`(`memberID`,`sessionID`,`hash`,`expiration`)"
                             ."values(". $memberID . ",'" . $sessionID . "','" . $hash . "','" . $expiration . "')";                    
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            header("Location: logInForm.php?err=3");
            exit;
        }
        
        header("Location: home.php?err=0");
        exit;
    }

}
    
    

?>
