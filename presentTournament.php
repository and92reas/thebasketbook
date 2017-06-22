<?php

require("head.php");

if(isset($_GET['tID'])) {
        $tournament= $_GET['tID'];
        
        }
else {
        
        header("Location: tournamentSearchForm.php?err=2");
        exit;
}
    
    $query = "SELECT * FROM `tournaments` "
            . "WHERE `tournamentID` = '" . $tournament . "' LIMIT 1";
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows==0) {
         
     header("Location: tournamentSearchForm.php?err=2");
     exit;
     }
     
     $row = mysqli_fetch_assoc($result);
     $tournamentID = $tournament;
     $title = $row['title'];
     $start_date = $row['start_date'];
     $end_date = $row['end_date'];
     $type = $row['type'];
     
     $query = "SELECT `matchID`,`home_team`,`home_points`,`round`,`row`,`name` FROM `matches`,`teams` "
    . "WHERE `home_team` = `teamID`  AND `tournamentID` = " . $tournamentID . " ORDER BY `matchID`";
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
         
     header("Location: tournamentSearchForm.php?err=2");
     exit;
     }
         
     $matchIDs = array();
     $home_teamsID = array();
     $home_teams_names = array();
     $home_points = array();
     $rounds = array();
     $rows = array();
     
     
     while($row = $result->fetch_array()) {
        $matchIDs[] = $row['matchID'];
        $home_teamsID[] = $row['home_team'];
        $home_teams_names[] = $row['name'];
        $home_points[] = $row['home_points'];
        $rounds[] = $row['round'];
        $rows[] = $row['row'];
     }
     
     $query = "SELECT `guest_team`,`guest_points`,`name` FROM `matches`,`teams` "
    . "WHERE `guest_team` = `teamID`  AND `tournamentID` = " . $tournamentID . " ORDER BY `matchID`";
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
         
     header("Location: tournamentSearchForm.php?err=2");
     exit;
     }
         
     $guest_teamsID = array();
     $guest_teams_names = array();
     $guest_points = array();
          
     
     while($row = $result->fetch_array()) {
        $guest_teamsID[] = $row['guest_team'];
        $guest_teams_names[] = $row['name'];
        $guest_points[] = $row['guest_points'];
       
     }
     
        $memberID = isLoggedIn($mysqli);
        $follow = 0;
        
        $query = "SELECT * FROM `followed_tournaments` "
            . "WHERE `tournamentID` = " . $tournamentID . " AND `memberID` = " . $memberID;
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            
            header("Location: tournamentSearchForm.php?err=2");
            exit;
        }
        else if($result->num_rows>0) {
            $follow = 1;
        }
     
     print("<h3>Tournament Profile</h3><br/><br/>");
     print("<b> Title: " . $title . " </b><br/>\n");
     print("<b> Starting Date: " . $start_date . " </b><br/>\n");
     print("<b> Ending Date: " . $end_date . " </b><br/>\n");
     
     if($type == 0) {
         print("<b> Type of Tournament: Cup </b><br/><br/><br/>\n");
     }
     else {
         print("<b> Type of Tournament: Championship </b><br/><br/><br/>\n");
     }
     
     if ($type == 0 ) {
            
            print("<h4>Cup Schedule</h4><br/><br/>");
            for ($j=0;$j<end($rounds);$j++) {
                print("<b> Round ". ($j+1) .": </b><br/>\n");
                
                
                for($z=0;$z<count($matchIDs);$z++) {
                    if($rounds[$z] == $j+1) { //if the match is in the particular round
                        
                        
                        if($home_points[$z]==NULL) {
                            print("<b> Match ". ($z+1) .": " . $home_teams_names[$z] . " - " . $guest_teams_names[$z] . ""
                                . "  0:0 </b> "
                                . "<a href = 'presentMatch.php?mID=" . $matchIDs[$z] . "'> More... </a> "
                                . "<a href = 'addResultForm.php?mID=" . $matchIDs[$z] . "'> Add the result... </a> <br/>\n");
                        }
                        else {
                            print("<b> Match ". ($z+1) .": " . $home_teams_names[$z] . " - " . $guest_teams_names[$z] . ""
                                . " " . $home_points[$z] . ":" . $guest_points[$z] . " </b> "
                                . "<a href = 'presentMatch.php?mID=" . $matchIDs[$z] . "'> More... </a> "
                                . "<a href = 'addResultForm.php?mID=" . $matchIDs[$z] . "'> Add the result... </a> <br/>\n");    
                        }
                    }
                }
                print("<br/><br/>");    
            }  
            
     }
     else {
         
         $query = "SELECT teams.teamID as tmID,`name`,`points_for`,`points_against`,`league_points` FROM `teams_tournaments`,`teams`"
            . "WHERE `tournamentID` = " . $tournamentID . " AND teams.teamID = teams_tournaments.teamID "
                 . "ORDER BY `league_points` DESC,`points_for`-`points_against` DESC,`name` ASC";
            $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                
            header("Location: teamSearchForm.php?err=2");
            exit;
            }
            $teamIDs = array();
            $team_names = array();
            $points_for = array();
            $points_against = array();
            $league_points = array();
            
            
            while($row = $result->fetch_array()) {
                $teamIDs[] = $row['tmID'];
                $team_names[] = $row['name'];
                $points_for[] = $row['points_for'];
                $points_against[] = $row['points_against'];
                $league_points[] = $row['league_points'];
            }
            
            print("<h4>League status</h4> <br/><br/>");
            print("<table id=\"league\">"
                    . "<tr>"
                    . "<td><h5>Position</h5></td>"
                    . "<td colspan=3><h5>Team</h5></td>"
                    . "<td><h5>For-Against</h5></td>"
                    . "<td><h5>Points</h5></td>"
                    . "</tr>");
            for ($i=0; $i<count($teamIDs); $i++) {
                print("<tr>"
                        . "<td>" .($i+1) .") </td>"
                        . "<th colspan=3 > <a href = 'presentTeam.php?tID=" . $teamIDs[$i] . "'> " . $team_names[$i] . " </a> </th>"
                        . "<td> ". ($points_for[$i] - $points_against[$i]) ."</td>"
                        . "<th> " . $league_points[$i] . "</th>"
                        . "</tr>"
                     );
                
             }
            print("</table>");
            print("<br/><br/>");
            
            print("<h4>League Schedule</h4><br/><br/>");
            
            for ($i=0; $i<end($rounds); $i++) {
                print("<b> Round ". ($i+1) .": </b><br/>\n");
                
                
                for($z=0; $z<count($matchIDs); $z++) {
                    if($rounds[$z] == $i+1) { //if the match is in the particular round
                        $mID = $matchIDs[$z];
                        
                        if($home_points[$z]==NULL) {
                            print("<b> Match ". ($z+1) .": " . $home_teams_names[$z] . " - " . $guest_teams_names[$z] . ""
                                . "  0:0 </b> "
                                . "<a href = 'presentMatch.php?mID=" . $matchIDs[$z] . "'> More... </a> "
                                . "<a href = 'addResultForm.php?mID=" . $matchIDs[$z] . "'> Add the result... </a> <br/>\n");
                        }
                        else {
                            print("<b> Match ". ($z+1) .": " . $home_teams_names[$z] . " - " . $guest_teams_names[$z] . ""
                                . " " . $home_points[$z] . ":" . $guest_points[$z] . " </b> "
                                . "<a href = 'presentMatch.php?mID=" . $matchIDs[$z] . "'> More... </a> "
                                . "<a href = 'addResultForm.php?mID=" . $matchIDs[$z] . "'> Add the result... </a> <br/>\n");    
                        }
                    }
                }
                print("<br/><br/>");
            }
            
            
     }
        
     
     print("<b> <a href = 'changeTournamentStatusForm.php?tID=" . $tournamentID . "'> Change Tournament Status </a> </b><br/>\n");
     print("<form id = \"deleteTournamentForm\" method = \"post\" action = \"./deleteTournament.php?tID=" . $tournamentID . "\" > <br/><br/> \n");
        print("<button type = \"submit\" name = \"submitButton\" onClick='safeDelete(2," . $tournamentID . ")' > Delete Tournament </button>");
        print("</form> \n");   
     print("<form id = \"followForm\" method = \"post\" action = \"./followTournament.php\" > <br/><br/> \n");
     print("<input type= \"hidden\" name = \"memberID\" id = \"memberID\" value = \"" . $memberID . "\"  > \n");
     print("<input type= \"hidden\" name = \"tournamentID\" id = \"tournamentID\" value = \"" . $tournamentID . "\"  > \n");
     print("<input type= \"hidden\" name = \"follow\" id = \"follow\" value = \"" . $follow . "\"  > \n");
     if($follow ==1) {
     print("<button type = \"submit\" name = \"followButton\"> Unpick </button>");
     }
     else {
     print("<button type = \"submit\" name = \"followButton\"> Pick </button>");    
     }
     print("</form> \n");
     
     require ("lowerTournament.php");
?>

