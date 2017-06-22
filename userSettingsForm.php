<?php

require ("head.php");

if(isset($_GET['err'])) {
        $err= $_GET['err'];
        if($err==0) {
            print("<b> You need to add a username... (above 2 characters) </b>");
        }
        else if($err==1) {
            print("<b> You need to add a new password... (above 4 characters) </b>");
        }
        else if($err==2) {
            print("<b> You need to retype the new password correctly... </b>");
        }
        else if($err==3) {
            print("<b> You need to add the old password... </b>");
        }
        else if($err==4) {
            print("<b> You haven't typed the old password correctly... </b>");
        }
        else if($err==5) {
            print("<b> There is already a member with the particular username... </b>");
        }
        else if($err==6) {
            print("<b> Something went wrong... </b>");
        }
                 
    }

$memberID = isLoggedIn($mysqli);

if($memberID) {

$query = "SELECT `name`, `password`, `mail`, `fav_player`, `fav_team`, `fav_position` "
        . "FROM `members` WHERE `memberID` = " . $memberID . "  LIMIT 1";              
$result = mysqli_query($mysqli,$query);
    
    if($result->num_rows>0) {
    $row = mysqli_fetch_assoc($result);
    }

    
$name = $row['name'];
$password = $row['password'];
$mail = $row['mail'];
$fav_player = $row['fav_player'];
$fav_team = $row['fav_team'];
$fav_position = $row['fav_position'];


    print("<form id = \"userSettingsForm\" method = \"post\" action = \"./changeUserSettings.php\"  > <br/><br/> \n");
    print("Username:           <input type = \"text\" name = \"username\" value=\"". $name . "\" > (*) <br/><br/> \n ");
    print("Old Password:       <input type = \"password\" name = \"password0\"  > (*) <br/><br/> \n");
    print("New Password:       <input type = \"password\" name = \"password\" > (*) <br/><br/> \n");
    print("Retype New Password:<input type = \"password\" name = \"password2\" > (*) <br/><br/> \n");
    print("Mail:               <input type = \"text\" name = \"email\" value=\"". $mail . "\" > <br/><br/> \n");
    print("Favourite Player:   <input type = \"text\" name = \"fav_player\" value=\"". $fav_player . "\" > <br/><br/> \n");
    print("Favourite Team:     <input type = \"text\" name = \"fav_team\" value=\"". $fav_team . "\" > <br/><br/> \n");
    print("Favourite Position: <input type = \"text\" name = \"fav_position\" value=\"". $fav_position . "\" > <br/><br/> \n");
    print("<button type = \"submit\" name = \"submitButton\"> Save Changes </button>");
    print("</form> \n");
    require ("lowerHome.php");
}

else {
    header("Location: logInForm.php?err=2");
    exit;
}

?>