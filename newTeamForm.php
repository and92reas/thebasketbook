<?php

require ("head.php");

if(isset($_GET['err'])) {
        $err= $_GET['err'];
        if($err==0) {
            print("<b> ERROR: You need to add a team's name... </b>");
        }
        else if($err==1) {
            print("<b> ERROR: A team, with the name you inserted, already exists in the database... </b>");
        }
        else if($err==2) {
            print("<b> ERROR: Unfortunately the team was not inserted successfully...... </b>");
        }
        else if($err==3) {
            print("<b> ERROR: The team was not inserted successfully, please delete it manually </b>");
        }
        
}

    print("<form id = \"newTeamForm\" method = \"post\" action = \"./addNewTeam.php\" > <br/><br/> \n");
    print("Team Name:       <input type = \"text\" name = \"teamName\" > (*) <br/><br/> \n ");
    print("Area:            <input type = \"text\" name = \"area\" >  <br/><br/> \n");
    print("Court:           <input type = \"text\" name = \"court\" >  <br/><br/> \n");
    print("Foundation Year: <input type = \"text\" name = \"foundationYear\" >  <br/><br/> \n");
    print("Coach:           <input type = \"text\" name = \"coach\" >  <br/><br/> \n");
    print("Successes: <br/> \n");
    print("<input type = \"text\" name = \"success1\" id = \"success1\" > <br/> \n ");
    print("<input type = \"text\" name = \"success2\" id = \"success2\" > <br/> \n ");
    print("<input type = \"text\" name = \"success3\" id = \"success3\" > <br/><br/> \n ");
    print("<button type = \"submit\" name = \"submitButton\"> Insert Team </button>");
    print("</form> \n");
    require ("lowerTeam.php");

?>