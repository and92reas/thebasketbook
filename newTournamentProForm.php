<?php

require("head.php");

if(isset($_GET['err'])) {
        $err= $_GET['err'];
        if($err==0) {
            print("<b> ERROR: You need to choose a type of tournament... </b> \n ");
        }
        else if($err==1) {
            print("<b> ERROR: You need to choose a number of teams... </b>");
        }
        else if($err==2) {
            print("<b> ERROR: You have not added all of the teams... </b>");
        }
        else if($err==3) {
            print("<b> ERROR: You need to add a title to the tournament... </b>");
        }
        else if($err==4) {
            print("<b> ERROR: Unfortunately the tournament was not inserted successfully... </b>");
        }
        else if($err==5) {
            print("<b> ERROR: At least one of the teams you added do not exist in the database... </b>");
        }
        else if($err==6) {
            print("<b> ERROR: The tournament was not inserted successfully, please delete it manually... </b>");
        }
        
}

    print("<form id = \"newTournamentProForm\" method = \"post\" action = \"./newTournamentForm.php\" > <br/><br/> \n");
    print("What kind of tournament do you want to create?<br/><br/>\n");
    print("<input type=\"radio\" name=\"tournament\" value=\"knockOut\"  > Knock Out <br/>\n");
    print("<input type=\"radio\" name=\"tournament\" value=\"championship\" > Championship <br/><br/>\n");
    print("Number of Teams: <br/> \n ");
    print("<input type=\"radio\" name=\"numberOfTeams\" value=\"2\"  > 2 <br/>\n");
    print("<input type=\"radio\" name=\"numberOfTeams\" value=\"4\" > 4 <br/>\n");
    print("<input type=\"radio\" name=\"numberOfTeams\" value=\"8\"  > 8 <br/>\n");
    print("<input type=\"radio\" name=\"numberOfTeams\" value=\"16\" > 16 <br/>\n");
    print("<button type = \"submit\" name = \"submitButton\"> Continue </button>");
    print("</form> \n");
    require ("lowerTournament.php");



?>

