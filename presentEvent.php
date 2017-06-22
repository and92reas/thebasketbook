<?php

require("head.php");

if(isset($_GET['eID'])) {
        $event= $_GET['eID'];
        
        }
else {
        
        header("Location: eventSearchForm.php?err=2");
        exit;
}
    
    $query = "SELECT * FROM `events` "
            . "WHERE `eventID` = '" . $event . "' LIMIT 1";
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows==0) {
        
     header("Location: eventSearchForm.php?err=2");
     exit;
     }
     
     $row = mysqli_fetch_assoc($result);
     $eventID = $event;
     $description = $row['description'];
     $area = $row['area'];
     $date = $row['date'];
     
     $query = "SELECT players.playerID AS pID,`name` FROM `players`,`events_players` "
            . "WHERE players.playerID = events_players.playerID AND eventID = " . $eventID;
     $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
         
     header("Location: eventSearchForm.php?err=2");
     exit;
     }
     
     $playerIDs = array();
     $player_names = array();
     
     while($row = $result->fetch_array()) {
         $playerIDs[] = $row['pID'];
         $player_names[] = $row['name'];
     }
     
              
    $query = "SELECT teams.teamID AS tID,`name` FROM `teams`,`events_teams` "
            . "WHERE teams.teamID = events_teams.teamID AND eventID = " . $eventID;
     $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
         
     header("Location: eventSearchForm.php?err=2");
     exit;
     }
     
     $teamIDs = array();
     $team_names = array();
     
     while($row = $result->fetch_array()) {
         $teamIDs[] = $row['tID'];
         $team_names[] = $row['name'];
     }
     
        $memberID = isLoggedIn($mysqli);
        $follow = 0;
        
        $query = "SELECT * FROM `followed_events` "
            . "WHERE `eventID` = " . $eventID . " AND `memberID` = " . $memberID;
        $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            
            header("Location: eventSearchForm.php?err=2");
            exit;
        }
        else if($result->num_rows>0) {
            $follow = 1;
        }
     
     print("<h3>Event Profile</h3><br/><br/>");
     print("<b> Description: " . $description . " </b><br/>\n");
     print("<b> Area: " . $area . " </b><br/>\n");
     print("<b> Date: " . $date . " </b><br/><br/><br/>\n");
     
        if(count($teamIDs)>0) {
           print("<b> Teams participating: </b><br/><br/>\n");
           for ($i=0;$i<count($teamIDs); $i++) {
              
               print("<b> Team" . ($i+1) . ": <a href = 'presentTeam.php?tID=" . $teamIDs[$i] ."'> " . $team_names[$i] ."</a> </b><br/>\n");
           }
           print("<br/><br/><br/>");
        }
        
        if(count($playerIDs)>0) {
           print("<b> Players participating: </b><br/><br/>\n");
           for ($i=0;$i<count($playerIDs); $i++) {
               
               print("<b> Player" . ($i+1) . ": <a href = 'presentPlayer.php?pID=" . $playerIDs[$i] . "'> " . $player_names[$i] ." </a></b><br/>\n");
           }
           print("<br/><br/><br/>");
        }
        
        
        print("<b> <a href = 'changeEventStatusForm.php?eID=" . $eventID . "'> Change Event Status </a> </b><br/>\n");
        print("<form id = \"deleteEventForm\" method = \"post\" action = \"./deleteEvent.php?eID=" . $eventID . "\" > <br/><br/> \n");
        print("<button type = \"submit\" name = \"submitButton\" onClick='safeDelete(3," . $eventID . ")' > Delete Event </button>");
        print("</form> \n");
        print("<form id = \"followForm\" method = \"post\" action = \"./followEvent.php\" > <br/><br/> \n");
        print("<input type= \"hidden\" name = \"memberID\" id = \"memberID\" value = \"" . $memberID . "\"  > \n");
        print("<input type= \"hidden\" name = \"eventID\" id = \"eventID\" value = \"" . $eventID . "\"  > \n");
        print("<input type= \"hidden\" name = \"follow\" id = \"follow\" value = \"" . $follow . "\"  > \n");
        if($follow ==1) {
        print("<button type = \"submit\" name = \"followButton\"> Unpick </button>");
        }
        else {
        print("<button type = \"submit\" name = \"followButton\"> Pick </button>");    
        }
        print("</form> \n");
              
        require ("lowerEvent.php");
        
        
?>

