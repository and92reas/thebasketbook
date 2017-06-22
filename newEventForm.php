<?php

require ("head.php");

if(isset($_GET['err'])) {
        $err= $_GET['err'];
        if($err==0) {
            print("<b> ERROR: You need to add an event's description... </b>");
        }
        else if($err==1) {
            print("<b> ERROR: The date is imcomplete, wrong or passed... if you do not want to add a date, "
                    . "leave ALL the boxes empty... </b>");
        }
        else if($err==2) {
            print("<b> ERROR: An event with the description you inserted already exists... </b>");
        }
        else if($err==3) {
            print("<b> ERROR: Unfortunately the event was not inserted successfully... </b>");
        }
         else if($err==4) {
            print("<b> ERROR: A team you added does not exist in the database... </b>");
        }
         else if($err==5) {
            print("<b> ERROR: A player you added does not exist in the database... </b>");
        }
        else if($err==6) {
            print("<b> ERROR: The event was not inserted successfully, please delete it manually... </b>");
        }
        
}

    print("<form id = \"newEventForm\" method = \"post\" action = \"./addNewEvent.php\" > <br/><br/> \n");
    print("Description:       <input type = \"text\" name = \"eventDescription\" > (*) <br/><br/> \n ");
    print("Area:              <input type = \"text\" name = \"area\" >  <br/><br/> \n");
    print("Date:    (if you do not want to add a date leave the all of the three following boxes empty) <br/>\n");
    print("<label for = \"day\"> day </label> <br/> \n");
    print("<input type = \"text\" name = \"day\" id = \"day\" > <br/><br/> \n ");
    print("<label for = \"month\"> month </label> <br/> \n");
    print("<input type = \"text\" name = \"month\" id = \"month\" > <br/><br/> \n ");
    print("<label for = \"year\"> year </label> <br/> \n");
    print("<input type = \"text\" name = \"year\" id = \"year\" > <br/><br/> \n ");
    print("Teams: <br/> \n");
    print("<input type = \"text\" name = \"team1\" id = \"team1\" > <br/> \n ");
    print("<input type = \"text\" name = \"team2\" id = \"team2\" > <br/> \n ");
    print("<input type = \"text\" name = \"team3\" id = \"team3\" > <br/><br/> \n ");
    print("Players: <br/> \n");
    print("<input type = \"text\" name = \"player1\" id = \"player1\" > <br/> \n ");
    print("<input type = \"text\" name = \"player2\" id = \"player2\" > <br/> \n ");
    print("<input type = \"text\" name = \"player3\" id = \"player3\" > <br/><br/> \n ");
    print("<button type = \"submit\" name = \"submitButton\"> Insert Event </button>");
    print("</form> \n");
    require ("lowerEvent.php");

?>
