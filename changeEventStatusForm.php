<?php

require("head.php");

if(isset($_GET['eID'])) {
        $eventID= $_GET['eID'];
        }
    else {
        header("Location: eventSearchForm.php?err=2");
        exit;
    }
    
    $memberID = isLoggedIn($mysqli);
        
    
    $query = "SELECT * FROM `admin_events` "
            . "WHERE `memberID` = " . $memberID . " AND `eventID` = '" . $eventID . "' LIMIT 1 ";
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows!=1) {
     header("Location: eventSearchForm.php?err=3");
     exit;
     }
    
    $query = "SELECT * FROM `events` "
            . "WHERE `eventID` = " . $eventID . " LIMIT 1";
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows==0) {
     header("Location: eventSearchForm.php?err=2");
     exit;
     }
     
     $row = mysqli_fetch_assoc($result);
     $description = $row['description'];
     $date = $row['date'];
     $area = $row['area'];
         
     $query = "SELECT `name` FROM `events_players`,`players` "
            . "WHERE `eventID` = " . $eventID . " AND events_players.playerID = players.playerID LIMIT 3";
     $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
     header("Location: eventSearchForm.php?err=2");
     exit;
     }
     
     $pnames = array();
     
     while($row = $result->fetch_array()) {
         $pnames[] = $row['name'];
     }
     
     $query = "SELECT `name` FROM `events_teams`,`teams` "
            . "WHERE `eventID` = " . $eventID . " AND events_teams.teamID = teams.teamID LIMIT 3";
     $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
     header("Location: eventSearchForm.php?err=2");
     exit;
     }
     
     $tnames = array();
     
     while($row = $result->fetch_array()) {
         $tnames[] = $row['name'];
     }
     
     print("<form id = \"eventForm\" method = \"post\" action = \"./changeEventStatus.php\" > <br/><br/> \n");
     print("<input type= \"hidden\" name = \"eID\" id = \"eID\" value = \"" . $eventID . "\"  > \n");
    print("Description:       " . $description . " <br/><br/> \n ");
    print("Area:              <input type = \"text\" name = \"area\" value = \"" . $area . "\" >  <br/><br/> \n");
    print("Date:              <input type = \"text\" name = \"date\" id = \"date\" value = \"" . $date . "\" > <br/><br/> \n ");
    print("Teams: <br/> \n");
    if (count($tnames)==0) {
    print("<input type = \"text\" name = \"team1\" id = \"team1\" > <br/> \n ");
    print("<input type = \"text\" name = \"team2\" id = \"team2\" > <br/> \n ");
    print("<input type = \"text\" name = \"team3\" id = \"team3\" > <br/><br/> \n ");
    }
    else if (count($tnames)==1) {
    print("<input type = \"text\" name = \"team1\" id = \"team1\" value = \"" . $tnames[0] . "\" > <br/> \n ");
    print("<input type = \"text\" name = \"team2\" id = \"team2\" > <br/> \n ");
    print("<input type = \"text\" name = \"team3\" id = \"team3\" > <br/><br/> \n ");
    }
    else if (count($tnames)==2) {
    print("<input type = \"text\" name = \"team1\" id = \"team1\" value = \"" . $tnames[0] . "\" > <br/> \n ");
    print("<input type = \"text\" name = \"team2\" id = \"team2\" value = \"" . $tnames[1] . "\" > <br/> \n ");
    print("<input type = \"text\" name = \"team3\" id = \"team3\" > <br/><br/> \n ");
    }
    else if (count($tnames)==3) {
    print("<input type = \"text\" name = \"team1\" id = \"team1\" value = \"" . $tnames[0] . "\" > <br/> \n ");
    print("<input type = \"text\" name = \"team2\" id = \"team2\" value = \"" . $tnames[1] . "\" > <br/> \n ");
    print("<input type = \"text\" name = \"team3\" id = \"team3\" value = \"" . $tnames[2] . "\" > <br/><br/> \n ");
    }
    print("Players: <br/> \n");
    if(count($pnames)==0) {
    print("<input type = \"text\" name = \"player1\" id = \"player1\" > <br/> \n ");
    print("<input type = \"text\" name = \"player2\" id = \"player2\" > <br/> \n ");
    print("<input type = \"text\" name = \"player3\" id = \"player3\" > <br/><br/> \n ");
    }
    else if(count($pnames)==1) {
    print("<input type = \"text\" name = \"player1\" id = \"player1\" value = \"" . $pnames[0] . "\" > <br/> \n ");
    print("<input type = \"text\" name = \"player2\" id = \"player2\" > <br/> \n ");
    print("<input type = \"text\" name = \"player3\" id = \"player3\" > <br/><br/> \n ");
    }
    else if(count($pnames)==2) {
    print("<input type = \"text\" name = \"player1\" id = \"player1\" value = \"" . $pnames[0] . "\" > <br/> \n ");
    print("<input type = \"text\" name = \"player2\" id = \"player2\" value = \"" . $pnames[1] . "\" > <br/> \n ");
    print("<input type = \"text\" name = \"player3\" id = \"player3\" > <br/><br/> \n ");
    }
    else if(count($pnames)==3) {
    print("<input type = \"text\" name = \"player1\" id = \"player1\" value = \"" . $pnames[0] . "\" > <br/> \n ");
    print("<input type = \"text\" name = \"player2\" id = \"player2\" value = \"" . $pnames[1] . "\" > <br/> \n ");
    print("<input type = \"text\" name = \"player3\" id = \"player3\" value = \"" . $pnames[2] . "\" > <br/><br/> \n ");
    }
    print("<button type = \"submit\" name = \"submitButton\" onClick='safeStatusChange(3)'> Change Event Status </button>");
    print("</form> \n");
    require ("lowerEvent.php");

?>

