<?php

require("head.php");

if(isset($_GET['mID'])) {
        $match= $_GET['mID'];
        
        }
else {  
        
        header("Location: tournamentSearchForm.php?err=2");
        exit;
}
    
    $query = "SELECT `matchID`,`home_team`,`guest_team`,`home_points`,`guest_points`,`title`,`round`,`row`,"
            . "tournaments.tournamentID AS tourID, `name` FROM `matches`,`tournaments`,`teams` "
            . "WHERE `matchID` = " . $match . " AND tournaments.tournamentID = matches.tournamentID "
            . "AND `home_team` = `teamID` ORDER BY `matchID` LIMIT 1";
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows==0) {
         
     header("Location: tournamentSearchForm.php?err=2");
     exit;
     }
     
     $row = mysqli_fetch_assoc($result);
     $matchID = $match;
     $home_team = $row['home_team'];
     $home_team_name = $row['name'];
     $guest_team = $row['guest_team'];
     $home_points = $row['home_points'];
     $guest_points = $row['guest_points'];
     $tournamentID = $row['tourID'];
     $title = $row['title'];
     $round = $row['round'];
     $rw = $row['row'];
     
     $query = "SELECT `name` FROM `matches`,`tournaments`,`teams` "
            . "WHERE `matchID` = " . $match . " AND tournaments.tournamentID = matches.tournamentID"
             . " AND `guest_team` = `teamID` ORDER BY `matchID` LIMIT 1";
    $result = mysqli_query($mysqli,$query);
    
    $row = mysqli_fetch_assoc($result);
    $guest_team_name = $row['name'];
        
     if($result->num_rows==0) {
         
     header("Location: tournamentSearchForm.php?err=2");
     exit;
     }
     
     
    $query = "SELECT `topic`,`content`,`name`,`time_stamp` FROM `messages`,`members`  "
            . "WHERE `matchID` = " . $matchID . " AND messages.memberID = members.memberID"
            . " ORDER BY `time_stamp` ASC";
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
         
     header("Location: tournamentSearchForm.php?err=2");
     exit;
     }
     
     $topics = array();
     $contents = array();
     $members = array();
     $time_stamps = array();
     
     while ($row = $result->fetch_array()) {
         $topics[] = $row['topic'];
         $contents[] = $row['content'];
         $members[] = $row['name'];
         $time_stamps[] = $row['time_stamp'];
     }
     
     print("<h3>Match Profil</h3><br/><br/>");
     if($home_points!= 'NULL') {
     print("<b> Home Team: " . $home_team_name . ": " . $home_points  . " </b><br/>\n");
     print("<b> Guest Team: " . $guest_team_name . ": " . $guest_points  . " </b><br/>\n");
     }
     else {
     print("<b> Home Team: " . $home_team . ": 0 </b><br/>\n");
     print("<b> Guest Team: " . $guest_team . ": 0 </b><br/>\n");    
     }
     
     print("<b> Tournament: <a href = 'presentTournament.php?tID=" . $tournamentID . "'> ". $title ."  </a> </b><br/>\n");
     print("<b> Round: " . $round . " </b><br/>\n");
     print("<b> Match: " . $rw . " </b><br/>\n");
     print("<a href = 'addResultForm.php?mID=" . $matchID . "'> Add the result... </a> <br/><br/><br/>\n");
     
     print("<form id = \"messageForm\" method = \"post\" action = \"./addMessage.php\" > <br/><br/> \n");
     print("<input type= \"hidden\" name = \"mID\" id = \"mID\" value = \"" . $matchID . "\"  > \n");
     print("Add your topic... <br\>\n");
     print("<input type = \"text\" name = \"topic\" id = \"topic\" > <br/> \n ");
     print("Add your message... <br\>\n");
     print("<textarea rows=\"8\" cols=\"50\" name = \"message\"> </textarea> <br/> \n ");
     print("<button type = \"submit\" name = \"submitButton\"> Add Message </button>");
     print("</form> \n");
     
     print("<br/><br/><br/>");
     
     for ($i=0; $i<count($contents); $i++) {
         print("<h6>(" . date('Y-m-d H:i:s', $time_stamps[$i]) . ")by " . $members[$i] . " <br/>" . $topics[$i] . "</h6><br/>");
         print($contents[$i] . "<br/><br/><br/>");
     
     }
     
     require ("lowerTournament.php");
     
     