<?php
require("head.php");
require_once('notification.php');

$name = getUser($mysqli);

if($name) {
    
    if(isset($_GET['err'])) {
        $err= $_GET['err'];
        if($err==0) {
            print ("<b> Welcome to the home page... </b>");
        }
        else if($err==1) {
            print ("<b> The changes were saved successfully... </b>");
        }
        else if($err==2) {
            print ("<b> ERROR: Unfortunately the changes were not saved successfully... </b>");
        }
        else if($err==3) {
            print("<b> The player was inserted successfully... </b>");
        }
        else if($err==4) {
            print("<b> The event was inserted successfully... </b>");
        }
        else if($err==5) {
            print("<b> The tournament was inserted successfully... </b>");
        }
        else if($err==6) {
            print("<b> The team was inserted successfully... </b>");
        }
    }
    
    $memberID = isLoggedIn($mysqli);    
        
    $query = "SELECT `playerID` FROM `followed_players` "
            . "WHERE `memberID` = " . $memberID;
    $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            
           header("Location: index.php");
           exit;
        }
     
    $playerIDs = array();
    
    while($row = $result->fetch_array()) {
        $playerIDs[] = $row['playerID'];
    }
    
     $query = "SELECT `teamID` FROM `followed_teams` "
            . "WHERE `memberID` = " . $memberID;
    $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
           
           header("Location: index.php");
           exit;
        }
     
    $teamIDs = array();
    
    while($row = $result->fetch_array()) {
        $teamIDs[] = $row['teamID'];
    }
    
    $query = "SELECT `eventID` FROM `followed_events` "
            . "WHERE `memberID` = " . $memberID;
    $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            
           header("Location: index.php");
           exit;
        }
     
    $eventIDs = array();
    
    while($row = $result->fetch_array()) {
        $eventIDs[] = $row['eventID'];
    }
    
    $query = "SELECT `tournamentID` FROM `followed_tournaments` "
            . "WHERE `memberID` = " . $memberID;
    $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            
           header("Location: index.php");
           exit;
        }
     
    $tournamentIDs = array();
    
    while($row = $result->fetch_array()) {
        $tournamentIDs[] = $row['tournamentID'];
    }
    
    $notifications = array();
    
    
    if(count($playerIDs)>0) {
        
    $query = "SELECT players.playerID AS pID,`topic`,`time_stamp`,`name` FROM `players_notifications`,`players` "
            . "WHERE (players_notifications.playerID = " . $playerIDs[0];
    for ($i=1; $i<count($playerIDs); $i++) {
        $query = $query . " OR players_notifications.playerID = " . $playerIDs[$i];
    }
    $query = $query . ") AND players.playerID = players_notifications.playerID ORDER BY `time_stamp` DESC";
    $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
           header("Location: index.php");
           exit;
        }
        
    while($row = $result->fetch_array()) {
        $notifications[] = new notification($row['topic'],$row['pID'],$row['name'],"player",$row['time_stamp']);
        }
    }
    
    if(count($teamIDs)>0) {
        
    $query = "SELECT teams.teamID as tID,`topic`,`time_stamp`,`name` FROM `teams_notifications`,`teams` "
            . "WHERE (teams_notifications.teamID = " . $teamIDs[0];
    for ($i=1; $i<count($teamIDs); $i++) {
        $query = $query . " OR teams_notifications.teamID = " . $teamIDs[$i];
    }
    $query = $query . ") AND teams.teamID = teams_notifications.teamID ORDER BY `time_stamp` DESC";
    $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
           header("Location: index.php");
           exit;
        }
           
    while($row = $result->fetch_array()) {
        $notifications[] = new notification($row['topic'],$row['tID'],$row['name'],"team",$row['time_stamp']);
        }
    }
    
    if(count($eventIDs)>0) {
        
    $query = "SELECT events.eventID as eID,`topic`,`time_stamp`,`description` FROM `events_notifications`,`events` "
            . "WHERE (events_notifications.eventID = " . $eventIDs[0];
    for ($i=1; $i<count($eventIDs); $i++) {
        $query = $query . " OR events_notifications.eventID = " . $eventIDs[$i];
    }
    $query = $query . ") AND events.eventID = events_notifications.eventID ORDER BY `time_stamp` DESC";
    $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            
           header("Location: index.php");
           exit;
        }
            
    while($row = $result->fetch_array()) {
        $notifications[] = new notification($row['topic'],$row['eID'],$row['description'],"event",$row['time_stamp']);
        }
    }
    
    if(count($tournamentIDs)>0) {
        
    $query = "SELECT tournaments.tournamentID as tourID,`topic`,`time_stamp`,`title` FROM `tournaments_notifications`,`tournaments` "
            . "WHERE (tournaments_notifications.tournamentID = " . $tournamentIDs[0];
    for ($i=1; $i<count($tournamentIDs); $i++) {
        $query = $query . " OR tournaments_notifications.tournamentID = " . $tournamentIDs[$i];
    }
    $query = $query . ") AND tournaments.tournamentID = tournaments_notifications.tournamentID ORDER BY `time_stamp` DESC";
    $result = mysqli_query($mysqli,$query);
        
        if(!$result) {
            
           header("Location: index.php");
           exit;
        }
           
    while($row = $result->fetch_array()) {
        $notifications[] = new notification($row['topic'],$row['tourID'],$row['title'],"tournament",$row['time_stamp']);
        }
    }
    
    usort($notifications,"cmp");
       
    print("<br/><br/><br/>");
    
    if(count($notifications)==0) {
        print("<p>There are no notifications</p>\n");
    }
    
    else {
        
    print("<ul>\n");    
    
    for ($i=0; $i<count($notifications); $i++) {
        print("<li>(" . date('d-m-Y H:i:s', $notifications[$i]->time_stamp) . ")\n");
        if($notifications[$i]->type == "player") {
            if($notifications[$i]->nid==1) {
                print("<p> <a href = 'presentPlayer.php?pID= " . $notifications[$i]->sid . "'> " . $notifications[$i]->sname . " </a> participated in a match... </p></li> <br/>");
            }
            else if($notifications[$i]->nid==2) {
                print("<p> <a href = 'presentPlayer.php?pID= " . $notifications[$i]->sid . "'> " . $notifications[$i]->sname . " </a>'s profil changed... </p></li> <br/>");
            }
            else if($notifications[$i]->nid==3) {
                print("<p> <a href = 'presentPlayer.php?pID= " . $notifications[$i]->sid . "'> " .  $notifications[$i]->sname . " </a> moved to a team... </p></li> <br/>");
            }
            else if($notifications[$i]->nid==4) {
                print("<p> <a href = 'presentPlayer.php?pID=" . $notifications[$i]->sid . "'> " .  $notifications[$i]->sname . " </a> will participate in an event... </p></li> <br/>");
            }
            else {
                print("<p> An event where <a href = 'presentPlayer.php?pID= " . $notifications[$i]->sid . "'> " .  $notifications[$i]->sname . " </a> would participate was cancelled...  </p></li> <br/>");
            }
        }
        else if($notifications[$i]->type == "team") {
            if($notifications[$i]->nid==1) {
            print("<p> <a href = 'presentTeam.php?tID=" .  $notifications[$i]->sid . "'> " . $notifications[$i]->sname . " </a> participated in a match... </p></li> <br/>");
            }
            else if($notifications[$i]->nid==2) {
                print("<p> <a href = 'presentTeam.php?tID=" .  $notifications[$i]->sid . "'> " . $notifications[$i]->sname . " </a>'s profil changed... </p></li> <br/>");
            }
            else if($notifications[$i]->nid==3) {
                print("<p> A message referring to a match where <a href = 'presentTeam.php?tID=" .  $notifications[$i]->sid . "'> " . $notifications[$i]->sname . " </a> participated or will participate was inserted... </p></li> <br/>");
            }
            else if($notifications[$i]->nid==4) {
                print("<p> A player left from <a href = 'presentTeam.php?tID=" .  $notifications[$i]->sid . "'> " . $notifications[$i]->sname . " </a>... </p></li> <br/>");
            }
            else if($notifications[$i]->nid==5) {
                print("<p> A player signed for <a href = 'presentTeam.php?tID=" .  $notifications[$i]->sid . "'> " . $notifications[$i]->sname . " </a>...  </p></li> <br/>");
            }
            else if($notifications[$i]->nid==6) {
                print("<p> <a href = 'presentTeam.php?tID=" .  $notifications[$i]->sid . "'> " . $notifications[$i]->sname . " </a> will participate to a tournament...  </p></li> <br/>");
            }
            else if($notifications[$i]->nid==7) {
                print("<p> A tournament where <a href = 'presentTeam.php?tID=" .  $notifications[$i]->sid . "'> " . $notifications[$i]->sname . " </a> would participate or participated was cancelled or deleted...  </p></li> <br/>");
            }
            else if($notifications[$i]->nid==8) {
                print("<p> <a href = 'presentTeam.php?tID=" .  $notifications[$i]->sid . "'> " . $notifications[$i]->sname . " </a> will participate to an event...  </p></li> <br/>");
            }
            else {
                print("<p> An event where <a href = 'presentTeam.php?tID=" .  $notifications[$i]->sid . "'> " . $notifications[$i]->sname . " </a> would participate was cancelled...  </p></li> <br/>");
            }
        }
        else if($notifications[$i]->type == "event") {
            if($notifications[$i]->nid==1) {
                print("<p> <a href = 'presentEvent.php?eID=" . $notifications[$i]->sid . "'> " . $notifications[$i]->sname . " </a>'s profil changed... </p></li> <br/>");
            }
            else if($notifications[$i]->nid==2) {
                print("<p> A player will participate in <a href = 'presentEvent.php?eID=" . $notifications[$i]->sid . "'> " . $notifications[$i]->sname . " </a>... </p></li> <br/>");
            }
            else if($notifications[$i]->nid==3) {
                print("<p> A player will not participate in <a href = 'presentEvent.php?eID=" . $notifications[$i]->sid . "'> " . $notifications[$i]->sname . " </a>... </p></li> <br/>");
            }
            else if($notifications[$i]->nid==4) {
                print("<p> A team will participate in <a href = 'presentEvent.php?eID=" . $notifications[$i]->sid . "'> " . $notifications[$i]->sname . " </a>... </p></li> <br/>");
            }
            else  {
                print("<p> A team, finally, will not participate in <a href = 'presentEvent.php?eID=" . $notifications[$i]->sid . "'> " . $notifications[$i]->sname . " </a>... </p></li> <br/>");
            }
        }
        else {
             if($notifications[$i]->nid==1) {
                print("<p> A match of <a href = 'presentTournament.php?tID=" . $notifications[$i]->sid . "'> " . $notifications[$i]->sname . " </a> took place... </p></li> <br/>");
            }
            else if($notifications[$i]->nid==2) {
                print("<p> <a href = 'presentTournament.php?tID=" . $notifications[$i]->sid . "'> " . $notifications[$i]->sname . " </a>'s profil changed... </p></li> <br/>");
            }
            else  {
                print("<p> A message referring to a <a href = 'presentTournament.php?tID=" . $notifications[$i]->sid . "'> " . $notifications[$i]->sname . " </a>'s match was inserted... </p></li> <br/>");
            }   
        }
        
        
    }
    print("</ul>\n");
        
    }
    require ("lowerHome.php");
    
    

}
else {
    header("Location: logInForm.php?err=2");
    exit;
}

    function cmp($notif1,$notif2) {
        if ($notif1->time_stamp > $notif2->time_stamp) {
            return -1;
        }
        else if ($notif1->time_stamp == $notif2->time_stamp) { 
            return 0;
        }
        else { 
            return 1;
        }
    }
    
    
    