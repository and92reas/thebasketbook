<?php

require("head.php");

if(isset($_GET['pID'])) {
        $player= $_GET['pID'];
        
        }
else {
        
        header("Location: playerSearchForm.php?err=2");
        exit;
}
if(isset($_GET['err'])) {
     print ("<b> There was some error during the change of the player's status... </b>");
}
    
    $query = "SELECT * FROM `players` "
            . "WHERE `playerID` = '" . $player . "' LIMIT 1";
    $result = mysqli_query($mysqli,$query);
        
    if($result->num_rows==0) {
         
     header("Location: playerSearchForm.php?err=2");
     exit;
     }
     
     $row = mysqli_fetch_assoc($result);
     $playerID = $player;
     $name = $row['name'];
     $present_team = $row['present_team'];
     $position = $row['position'];
     $birthdate = $row['birthdate'];
     $loaned_by = $row['loaned_by'];
     
    $query = "SELECT `name` FROM `teams` "
            . "WHERE `teamID` = '" . $present_team . "' LIMIT 1";
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
        
     header("Location: playerSearchForm.php?err=2");
     exit;
     }
     
     $row = mysqli_fetch_assoc($result);
     $tmname = $row['name']; 
     
    $query = "SELECT `team_name` FROM `past_teams` "
            . "WHERE `playerID` = '" . $playerID . "' LIMIT 3";
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
         
     header("Location: playerSearchForm.php?err=2");
     exit;
     }
     
     $past_teams = array();
     
     while($row = $result->fetch_array()) {
         $past_teams[] = $row['team_name'];
     }
         
    $query = "SELECT matches.matchID AS mID,`home_team`,`guest_team`,`points`,tournaments.tournamentID AS tourID,`title`,`name` FROM `players_matches`,`matches`,`tournaments`,`teams` "
            . "WHERE  players_matches.matchID = matches.matchID AND `playerID` = " . $playerID . " AND tournaments.tournamentID = matches.tournamentID AND"
            . "`teamID` = `home_team` ORDER BY matches.matchID";
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
         
        header("Location: playerSearchForm.php?err=2");
        exit;
     }
     
     $matches = array();
     $player_points = array();
     $toursID_matches = array();
     $home_teams = array();
     $guest_teams = array();
     $tour_names_matches = array();
     $home_names = array();
     
     while($row = $result->fetch_array()) {
          $matches[] = $row['mID'];
          $points[] = $row['points'];
          $toursID_matches[] = $row['tourID'];
          $home_teams[] = $row['home_team'];
          $guest_teams[] = $row['guest_team'];
          $tour_names_matches[] = $row['title'];
          $home_names[] = $row['name'];
     }
     
     $query = "SELECT `name` FROM `players_matches`,`matches`,`tournaments`,`teams` "
            . "WHERE  players_matches.matchID = matches.matchID AND `playerID` = " . $playerID . " AND tournaments.tournamentID = matches.tournamentID AND"
            . "`teamID` = `guest_team` ORDER BY matches.matchID ";
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
         
        header("Location: playerSearchForm.php?err=2");
        exit;
     }
     
     $guest_names = array();
     
      while($row = $result->fetch_array()) {
          $guest_names[] = $row['name'];
      }
     
     
     if(count($matches)>0) {
     
      $query = "SELECT tournaments.tournamentID AS tourID,`title`, AVG(`points`) as avpoints,COUNT(matches.tournamentID) as games FROM `matches`,`players_matches`,`tournaments` "
            . "WHERE  players_matches.playerID = " . $playerID . " AND matches.matchID = players_matches.matchID AND tournaments.tournamentID = matches.tournamentID "
              . "AND ( matches.matchID = " . $matches[0] ;
     
     for($i=1; $i<count($matches); $i++) {
        
        $query = $query . " OR matches.matchID = " . $matches[$i];
        
        }
        $query = $query . " ) GROUP BY matches.tournamentID";
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            
            header("Location: playerSearchForm.php?err=2");
            exit;
        }
        $player_stats = array();
        $toursID_stats = array();
        $tours_names_stats = array();
        
        while($row = $result->fetch_array()) {
          if($row['games'] != 0) {
          $player_stats[] = $row['avpoints'];
          }
          else {
              $player_stats[] = 0;
          }
          $toursID_stats[] = $row['tourID'];
          $tours_names_stats[] = $row['title'];
        }
     }
        
        $memberID = isLoggedIn($mysqli);
        $follow = 0;
        
        $query = "SELECT * FROM `followed_players` "
            . "WHERE `playerID` = " . $playerID . " AND `memberID` = " . $memberID;
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            
            header("Location: playerSearchForm.php?err=2");
            exit;
        }
        else if($result->num_rows>0) {
            $follow = 1;
        }
        print("<h3>Player Profile</h3><br/><br/>");
        print("<b> Name: " . $name . " </b><br/>\n");
        if($present_team!=1) {
            
            print("<b> Current Team: <a href = 'presentTeam.php?tID=" . $present_team . "'>" . $tmname . "</a> </b><br/>\n");
        }
        else {
            print("<b> Current Team: (free agent) </b><br/>\n");
        }
        print("<b> Position: " . $position . " </b><br/>\n");
        print("<b> Birthdate: " . $birthdate . " </b><br/>\n");
        print("<b> Loaned By: " . $loaned_by . " </b><br/></br/>\n");
        
        for ($i=0; $i<count($past_teams); $i++) {
                print("<b> Former Team" . ($i+1) . ": " . $past_teams[$i] . " </b><br/>\n");
            }
        print("<br/><br/><br/>"); 
        
        
        if(count($matches)>0) {
        for ($i=0; $i<count($player_stats); $i++) {
            
            
            print("<b> Tournament: <a href = 'presentTournament.php?tID=" . $toursID_stats[$i] . "'> " . $tours_names_stats[$i] . " </a> </b><br/>\n");
            print("<b> Points per Match: " . $player_stats[$i] . " </b><br/><br/>\n");
            
            for ($j=0; $j<count($matches); $j++) {
                if($toursID_matches[$j] == $toursID_stats[$i]) {
                    
                print("<b> Match: <a href = 'presentMatch.php?mID=" . $matches[$j] . "'> " . $home_names[$j] . " - " . $guest_names[$j] . " </a>"
                        . " (" . $points[$j] . " points) </b><br/>\n");
                }
            }
            print("<br/><br/><br/><br/>");            
        }
        }
        print("<br/><br/><body> <a href = 'changePlayerStatusForm.php?pID=" . $playerID . "'> Change Player Status </a> </body><br/>\n");
        print("<form id = \"deletePlayerForm\" method = \"post\" action = \"./deletePlayer.php?pID=" . $playerID . "\" > <br/><br/> \n");
        print("<button type = \"submit\" name = \"submitButton\" onClick='safeDelete(0," . $playerID . ")' > Delete Player </button>");
        print("</form> \n");
        print("<form id = \"followForm\" method = \"post\" action = \"./followPlayer.php\" > <br/><br/> \n");
        print("<input type= \"hidden\" name = \"memberID\" id = \"memberID\" value = \"" . $memberID . "\"  > \n");
        print("<input type= \"hidden\" name = \"playerID\" id = \"playerID\" value = \"" . $playerID . "\"  > \n");
        print("<input type= \"hidden\" name = \"follow\" id = \"follow\" value = \"" . $follow . "\"  > \n");
        if($follow ==1) {
        print("<button type = \"submit\" name = \"followButton\"> Unpick </button>");
        }
        else {
        print("<button type = \"submit\" name = \"followButton\"> Pick </button>");    
        }
        print("</form> \n");
        
        require ("lowerPlayer.php");
     
     
?>

