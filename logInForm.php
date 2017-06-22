<?php
require("config.php");

require ("upper.php");

if(isset($_GET['err'])) {
        $err= $_GET['err'];
        if($err==0) {
            print("<b> ERROR: The login was not successful... </b> \n ");
            print("<b> If you are not a member, you are welcome to sign in</b>");
        }
        else if($err==1) {
            print("<b> You logged out successfully... </b>");
        }
        else if($err==2) {
            print("<b> Please (re)log in... </b>");
        }
        else if($err==3) {
            print("<b> ERROR: Database connection error... </b>");
        }
        
}

    print("<form id = \"loginForm\" method = \"post\" action = \"./logIn.php?start=0\" > <br/><br/> \n");
    print("Username:           <input type = \"text\" name = \"username\" > (*) <br/><br/> \n ");
    print("Password:           <input type = \"password\" name = \"password\" > (*) <br/><br/> \n");
    print("<button type = \"submit\" name = \"submitButton\"> Log In </button>");
    print("</form> \n");
    require ("lowerHome.php");
?>
