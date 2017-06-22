<?php

require("head.php");

if (isset($_POST['submitButton'])) {
    if(!isset($_POST['tournament']) || $_POST['tournament']==NULL) {
        header("Location: newTournamentProForm.php?err=0");
        exit;
    }
    else if(!isset($_POST['numberOfTeams'])|| $_POST['numberOfTeams']==NULL) {
        header("Location: newTournamentProForm.php?err=1");
        exit;
    }
    
    $number_of_teams = $_POST['numberOfTeams'];
    $tournament = $_POST['tournament'];
    
           
            print("<form id = \"newTournamentForm\" method = \"post\" action = \"./addNewTournament.php\" > <br/><br/> \n");
            print("Tournament Title: <input type = \"text\" name = \"title\" id = \"title\" > (*) <br/> \n ");
            print("Beginning Date: <input type = \"text\" name = \"startDate\" id = \"startDate\" > (dd/mm/yyyy) <br/> \n ");
            print("Ending Date:       <input type = \"text\" name = \"endDate\" id = \"endDate\" > (dd/mm/yyyy) <br/> \n");
            print("<input type= \"hidden\" name = \"numberOfTeams\" id = \"numberOfTeams\" value = \"" . $number_of_teams . "\"  > \n");
            print("<input type = \"hidden\" name = \"tournament\" id = \"tournament\" value = \"" . $tournament . "\" > \n");
            
                        
            for($i=1; $i<=$number_of_teams; $i++) {
            print("<label for = \"team". $i . "\"> team". $i . " </label> \n ");
            print("<input type = \"text\" name = \"team". $i . "\" id = \"team". $i . "\" > (*) <br/> \n ");
            }
            
            print("<button type = \"submit\" name = \"submitButton\"> Insert Tournament </button>");
            print("</form>\n");
            require ("lowerTournament.php");
    
    
    
    
}


   
?>
