<?php


require("head.php");

if (isset($_POST['submitButton'])) {
    if(!isset($_POST['username']) || strlen($_POST['username'])<=2) {
        header("Location: signInForm.php?err=0");
        exit;
    }
    else if(!isset($_POST['password']) || strlen($_POST['password'])<=5) {
        header("Location: signInForm.php?err=1");
        exit;
    }
    else if(!isset($_POST['password2']) || strcmp($_POST['password'],$_POST['password2']) != 0) {
        header("Location: signInForm.php?err=2");
        exit;
    }
    
    $name = mysqli_real_escape_string($mysqli,$_POST['username']);
        
    $query = "SELECT `name` FROM `members`"
            . "WHERE  `name` = '" . $name . "' LIMIT 1";
    $result = mysqli_query($mysqli,$query);   
    
       
    if($result->num_rows>0) {
        header("Location: signInForm.php?err=3");
        exit;
    }
    
    $password = hash("sha512",mysqli_real_escape_string($mysqli,$_POST['password']));
    
    if(!isset($_POST['email'])) {
        $mail = "unknown";
    }
    else {
        $mail = mysqli_real_escape_string($mysqli,$_POST['email']);
    }
    
    if(!isset($_POST['fav_player'])) {
        $fav_player = "unknown";
    }
    else {
        $fav_player = mysqli_real_escape_string($mysqli,$_POST['fav_player']);
    }
    
    if(!isset($_POST['fav_team'])) {
        $fav_team = "unknown";
    }
    else {
        $fav_team = mysqli_real_escape_string($mysqli,$_POST['fav_team']);
    }
    
    if(!isset($_POST['fav_position'])) {
        $fav_position = "unknown";
    }
    else {
        $fav_position = mysqli_real_escape_string($mysqli,$_POST['fav_position']);
    }
    
    $mysqli->autocommit(false);
    
    $query = "INSERT INTO `members`(`name`,`password`,`mail`,`fav_player`,`fav_team`,`fav_position`)"
                             ."values('" . $name . "','" . $password . "','" . $mail . "','" . $fav_player . "','" . 
                                        $fav_team . "','" . $fav_position . "')";                     
    
    $result = mysqli_query($mysqli,$query);
    
    if(!$result) {
        deleteMember();
        header("Location: signInForm.php?err=4");
        exit;
    }
    
    
    $query = "SELECT `memberID` FROM `members` WHERE `name` = '" . $name . "' LIMIT 1";                     
    $result = mysqli_query($mysqli,$query);
    
    $row = mysqli_fetch_assoc($result);
    $memberID = (INT) $row['memberID'];
    $sessionID = mysqli_real_escape_string($mysqli,session_id());
    $hash = mysqli_real_escape_string($mysqli,hash("sha512",$sessionID.$_SERVER['HTTP_USER_AGENT']));
    $expiration = time() + $delay;
    
    $query = "INSERT INTO `logged_members`(`memberID`,`sessionID`,`hash`,`expiration`)"
                             ."values(". $memberID . ",'" . $sessionID . "','" . $hash . "','" . $expiration . "')";                    
    $result = mysqli_query($mysqli,$query);
    
    if(!$result) {
        deleteMember();
        header("Location: signInForm.php?err=4");
        exit;
    }
    
    
    $mysqli->commit();
    $mysqli->autocommit(true);
    
    header("Location: home.php?err=0&start=0");
    exit;
    
    
    
}
    function deleteMember() {
        
        $mysqli->rollback();
    }


?>