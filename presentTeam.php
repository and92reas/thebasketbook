<?php

require("head.php");

if(isset($_GET['tID'])) {
        $team= $_GET['tID'];
        
        }
else {
        
        header("Location: teamSearchForm.php?err=2");
        exit;
}
    
    $query = "SELECT * FROM `teams` "
            . "WHERE `teamID` = '" . $team . "' LIMIT 1";
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows==0) {
         
     header("Location: teamSearchForm.php?err=2");
     exit;
     }
     
     $row = mysqli_fetch_assoc($result);
     $teamID = $team;
     $name = $row['name'];
     $area = $row['area'];
     $court = $row['court'];
     $foundation_year = $row['foundation_year'];
     $coach = $row['coach'];
     
     $query = "SELECT `success` FROM `teams_successes` "
            . "WHERE `teamID` = '" . $teamID . "' LIMIT 3";
     $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
         
     header("Location: teamSearchForm.php?err=2");
     exit;
     }
     
     $successes = array();
     
     while($row = $result->fetch_array()) {
         $successes[] = $row['success'];
     }
         
    $query = "SELECT events.eventID AS eID,`description` FROM `events_teams`,`events` "
            . "WHERE  events_teams.eventID = events.eventID AND `teamID` = " . $teamID;
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
         
        header("Location: teamSearchForm.php?err=2");
        exit;
     }
     
     $eventID = array();
     $description = array();
     
     while($row = $result->fetch_array()) {
          $eventID[] = $row['eID'];
          $description[] = $row['description'];
          
     }
     
     $query = "SELECT tournaments.tournamentID as tournID,`title`,`points_for`,`points_against`,`league_points`,`type` "
             . "FROM `tournaments`,`teams_tournaments` WHERE tournaments.tournamentID = teams_tournaments.tournamentID "
             . "AND `teamID` = " . $teamID;
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
         
        header("Location: teamSearchForm.php?err=2");
        exit;
     } 
     
     $tournamentID = array();
     $title = array();
     $points_for = array();
     $points_against = array();
     $league_points = array();
     $type = array();
     
     
     while($row = $result->fetch_array()) {
          $tournamentID[] = $row['tournID'];
          $title[] = $row['title'];
          $points_for[] = $row['points_for'];
          $points_against[] = $row['points_against'];
          $league_points[] = $row['league_points'];
          $type[] = $row['type'];
                   
     }
     $round = array();
     for ($i=0; $i<count($tournamentID); $i++) {
     $query = "SELECT `round` FROM `matches` WHERE tournamentID = " . $tournamentID[$i] . " AND (`home_team` = " . $teamID
             . " OR `guest_team` = " . $teamID . ") ORDER BY matchID DESC LIMIT 1";
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
        
        header("Location: teamSearchForm.php?err=2");
        exit;
     }
     $row = mysqli_fetch_assoc($result);
     $round[] = $row['round'];
     }
     
     
    $query = "SELECT `playerID`,`name` FROM `players` "
            . "WHERE `present_team` = " . $teamID;
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
         
        header("Location: teamSearchForm.php?err=2");
        exit;
     }
     
     $players = array();
     $playerIDs = array();
     
     while($row = $result->fetch_array()) {
          $players[] = $row['name'];
          $playerIDs[] = $row['playerID'];
     }
     
        $memberID = isLoggedIn($mysqli);
        $follow = 0;
        
        $query = "SELECT * FROM `followed_teams` "
            . "WHERE `teamID` = " . $teamID . " AND `memberID` = " . $memberID;
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            
            header("Location: teamSearchForm.php?err=2");
            exit;
        }
        else if($result->num_rows>0) {
            $follow = 1;
        }
        print("<h3>Team Profile</h3><br/><br/>");
        print("<b> Name: " . $name . " </b><br/>\n");
        print("<b> Area: " . $area . " </b><br/>\n");
        print("<b> Court: " . $court . " </b><br/>\n");
        print("<b> Foundation Year: " . $foundation_year . " </b><br/>\n");
        print("<b> Coach: " . $coach . " </b><br/><br/><br/>\n");
        for($i=0; $i<count($successes); $i++) {
            print("<b>Success". ($i+1) .": " . $successes[$i] . "</b><br/>\n");
        }
        print("<br/><br/><br/>");
        
        if(count($players)) {
        print("<b> Roster: </b><br/>");
            for($i=0; $i<count($players); $i++) {
                
                print("<b> Player" . ($i+1) . ": <a href = 'presentPlayer.php?pID=" . $playerIDs[$i] . "'>" . $players[$i] . "</a></b><br/>\n");
            }
        print("<br/><br/><br/>");    
        }
        
        for ($i=0; $i<count($tournamentID); $i++) {
            
            print("<b> Tournament". ($i+1) . ": <a href = 'presentTournament.php?tID=" . $tournamentID[$i] . "'>" . $title[$i] . "</a></b><br/>\n");
            print("<b> Points for: " . $points_for[$i] . " </b><br/>\n");
            print("<b> Points against: " . $points_against[$i] . " </b><br/>\n");
            
            if($type[$i] ==1) {
            
            $query = "SELECT teams.teamID AS tID FROM `teams_tournaments`,`teams` "
            . "WHERE `tournamentID` = " . $tournamentID[$i] . " AND teams.teamID = teams_tournaments.teamID  "
                    . "ORDER BY `league_points`,`points_for`-`points_against` DESC,`name` ";
            $result = mysqli_query($mysqli,$query);
        
            if(!$result) {
                
            header("Location: teamSearchForm.php?err=2");
            exit;
            }
            
            $teams = array();
            
            while($row = $result->fetch_array()) {
                $teams[] = $row['tID'];
            }
            
            for ($j=0;$i<count($teams); $j++) {
                if($teams[$j] == $teamID) {
                    $pos = $j+1;
                    break;
                }
            }
            if($pos==1) {
                print("<b> League Position: 1st </b><br/><br/><br/>\n");
            }
            else if ($pos ==2) {
                print("<b> League Position: 2nd </b><br/><br/><br/>\n");
            }
            else if ($pos ==3) {
                print("<b> League Position: 3rd </b><br/><br/><br/>\n");
            }
            else {
                print("<b> League Position: " . $pos .  "th </b><br/><br/><br/>\n");
            }

        }
        else {
            print("<b> Cup Round: " . $round[$i] . " </b><br/><br/><br/>\n");
        }
        
        }
        
        print("<br/><br/><br/>");
        
        
        
        
        
        for ($i=0; $i<count($eventID); $i++) {
            print("<b> Event". ($i+1) . ": <a href = 'presentEvent.php?eID=" . $eventID[$i] . "'>" . $description[$i] . "</a></b><br/>\n");
        }
        print("<br/><br/><br/>");
        
        print("<b> <a href = 'changeTeamStatusForm.php?tID=" . $teamID . "'> Change Team Status </a> </b><br/>\n");
        print("<form id = \"deleteTeamForm\" method = \"post\" action = \"./deleteTeam.php?tID=" . $teamID . "\" > <br/><br/> \n");
        print("<button type = \"submit\" name = \"submitButton\" onClick='safeDelete(1," . $teamID . ")' > Delete Team </button>");
        print("</form> \n");
        print("<form id = \"followForm\" method = \"post\" action = \"./followTeam.php\" > <br/><br/> \n");
        print("<input type= \"hidden\" name = \"memberID\" id = \"memberID\" value = \"" . $memberID . "\"  > \n");
        print("<input type= \"hidden\" name = \"teamID\" id = \"teamID\" value = \"" . $teamID . "\"  > \n");
        print("<input type= \"hidden\" name = \"follow\" id = \"follow\" value = \"" . $follow . "\"  > \n");
        if($follow ==1) {
        print("<button type = \"submit\" name = \"followButton\"> Unpick </button>");
        }
        else {
        print("<button type = \"submit\" name = \"followButton\"> Pick </button>");    
        }
        print("</form> \n");
        
        require ("lowerTeam.php");
     
     
?>



