<?php
    
    require("upper.php");
    
    if(isset($_GET['err'])) {
        $err= $_GET['err'];
        if($err==0) {
            print("<b> ERROR: You need to add a username... (above 2 characters) </b>");
        }
        else if($err==1) {
            print("<b> ERROR: You need to add a password... (above 4 characters) </b>");
        }
        else if($err==2) {
            print("<b> ERROR: You need to retype the password correctly... </b>");
        }
        else if($err==3) {
            print("<b> ERROR: There is already a member with the particular username... </b>");
        }
        else if($err==4) {
            print("<b> ERROR: Unfortunately the sign in failed... </b>");
        }
          
    }
        
    
    print("<form id = \"signinForm\" method = \"post\" action = \"./signIn.php?start=0\" > <br/><br/> \n");
    print("Username:           <input type = \"text\" name = \"username\" > (*) <br/><br/> \n ");
    print("Password:           <input type = \"password\" name = \"password\" > (*) <br/><br/> \n");
    print("Retype Password:    <input type = \"password\" name = \"password2\" > (*) <br/><br/> \n");
    print("Mail:               <input type = \"text\" name = \"email\" > <br/><br/> \n");
    print("Favourite Player:   <input type = \"text\" name = \"fav_player\" > <br/><br/> \n");
    print("Favourite Team:     <input type = \"text\" name = \"fav_team\" > <br/><br/> \n");
    print("Favourite Position: <input type = \"text\" name = \"fav_position\" > <br/><br/> \n");
    print("<button type = \"submit\" name = \"submitButton\"> Sign In </button>");
    print("</form> \n");    
    require ("lowerHome.php");
?>

