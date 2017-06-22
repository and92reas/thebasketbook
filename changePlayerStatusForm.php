<?php

require("head.php");

    if(isset($_GET['pID'])) {
        $playerID= $_GET['pID'];
        }
    else {
        
        header("Location: playerSearchForm.php?err=2");
        exit;
    }
    
    $memberID = isLoggedIn($mysqli);
    
    
    $query = "SELECT * FROM `admin_players` "
            . "WHERE `memberID` = " . $memberID . " AND `playerID` = " . $playerID . " ";
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows!=1) {
     header("Location: playerSearchForm.php?err=3");
     exit;
     }
    
    $query = "SELECT players.name as pname, teams.name as tname, `present_team`, `position`, `birthdate`, `loaned_by`  FROM `players`,`teams` "
            . "WHERE `playerID` = " . $playerID . " AND teamID = present_team LIMIT 1";
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows==0) {
         
     header("Location: playerSearchForm.php?err=2");
     exit;
     }
     
     $row = mysqli_fetch_assoc($result);
     $player_name = $row['pname'];
     $team_name = $row['tname'];
     $present_teamID = $row['present_team'];
     $position = $row['position'];
     $birthdate = $row['birthdate'];
     $loaned_by = $row['loaned_by'];
     
     $query = "SELECT `team_name` FROM `past_teams` "
            . "WHERE `playerID` = " . $playerID . " LIMIT 3";
    $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
         
     header("Location: playerSearchForm.php?err=2");
     exit;
     }
     
     $past_teams = array();
     
     while($row = $result->fetch_array()) {
         $past_teams[] = $row['team_name'];
     }
     
    $query = "SELECT `name` FROM `teams` "
            . "WHERE `name` <> 'unknown' ORDER BY name";
    $result = mysqli_query($mysqli,$query);
    $row = mysqli_fetch_assoc($result);
    
    $teams = array();
    
    while($row = $result->fetch_array()) {
        $teams[] = $row['name']; 
    }
    
    if($birthdate!="unknown") {
        $info = explode("/",$birthdate);
        $day = $info[0];
        $month = $info[1];
        $year = $info[2];
    }
    else {
        $day = "";
        $month = "";
        $year = "";
    }
    
    if ($team_name== "unknown") {
        $team_name = "";
    }
    if ($position == "unknown") {
        $position = "";
    }
            

    print("<form id = \"PlayerForm\" method = \"post\" action = \"./changePlayerStatus.php\" > <br/><br/> \n");
    print("<input type= \"hidden\" name = \"pID\" id = \"pID\" value = \"" . $playerID . "\"  > \n");
    print("<b>Name: ". $player_name . "</b> <br/><br/> \n ");
    print("<label for = \"presentTeam\"> (if the player does not play for a team that exists in the site, leave the box blank) </label> <br/> \n");
    print("Present Team:   <input name='presentTeam' type=\"text\" maxlength=\"50\" id='presentTeam' value = '" . $team_name ."' 
    onclick=\"DropDownIndexClear('presentTeamMenu');\" readonly = \"readonly\"/>
    <select name=\"DropDownExTextboxExample\" id='presentTeamMenu'  
    onchange=\"DropDownTextToBox(this,'presentTeam');\""
    . "<option value=\"\">No Team Selected</option>"
    . "<option value=\"\">Free</option>");
            
    for ($i=0; $i<count($teams); $i++) {
       print("<option value=\"" . $teams[$i] . "\">" . $teams[$i] . "</option>");
    }
     
    print("</select><br/><br/>\n");
    print("Position:       <input name='position' type=\"text\" maxlength=\"50\" id='position' value = '" . $position . "' 
    onclick=\"DropDownIndexClear('positionMenu');\" readonly = \"readonly\"/>
    <select name=\"DropDownExTextboxExample\" id='positionMenu'  
    onchange=\"DropDownTextToBox(this,'position');\""
    . "<option value=\"\">No Position Selected</option>"
    . "<option value=\"\">No Position Selected</option>"
    . "<option value=\"Play Maker\">Play Maker</option>"
    . "<option value=\"Guard\">Guard</option>"
    . "<option value=\"Small Forward\">Small Forward</option>"
    . "<option value=\"Power Forward\">Power Forward</option>"
    . "<option value=\"Center\">Center</option>\n");        
    print("</select><br/><br/>\n");
     print("Birthdate:    (if you do not want to add a birthdate leave all of the three following boxes empty) <br/>\n");
    print("<label for = \"day\"> day </label> <br/> \n");
    print("<input type = \"text\" name = \"day\" id = \"day\" value = \"" . $day . "\"> <br/><br/> \n ");
    print("<label for = \"month\"> month </label> <br/> \n");
    print("<input type = \"text\" name = \"month\" id = \"month\" value = \"" . $month . "\"> <br/><br/> \n ");
    print("<label for = \"year\"> year </label> <br/> \n");
    print("<input type = \"text\" name = \"year\" id = \"year\" value = \"" . $year . "\"> <br/><br/> \n ");
    print("<label for = \"loanedBy\"> (If the player is not loaned by some other team leave the box blank) </label> <br/> \n");
    print("Loaned By:     <input type = \"text\" name = \"loanedBy\" id = \"loanedBy\" value = \"" . $loaned_by . "\" > <br/><br/> \n ");
    print("Past Teams: <br/> \n");
    if(count($past_teams) == 0) {
    print("<input type = \"text\" name = \"pastTeam1\" id = \"pastTeam1\" > <br/> \n ");
    print("<input type = \"text\" name = \"pastTeam2\" id = \"pastTeam2\" > <br/> \n ");
    print("<input type = \"text\" name = \"pastTeam3\" id = \"pastTeam3\" > <br/><br/> \n ");
    }
    else if(count($past_teams) == 1) { 
    print("<input type = \"text\" name = \"pastTeam1\" id = \"pastTeam1\" value = \"" . $past_teams[0] . "\" > <br/> \n ");
    print("<input type = \"text\" name = \"pastTeam2\" id = \"pastTeam2\" > <br/> \n ");
    print("<input type = \"text\" name = \"pastTeam3\" id = \"pastTeam3\" > <br/><br/> \n ");
    }
    else if(count($past_teams) == 2) { 
    print("<input type = \"text\" name = \"pastTeam1\" id = \"pastTeam1\" value = \"" . $past_teams[0] . "\" > <br/> \n ");
    print("<input type = \"text\" name = \"pastTeam2\" id = \"pastTeam2\" value = \"" . $past_teams[1] . "\" > <br/> \n ");
    print("<input type = \"text\" name = \"pastTeam3\" id = \"pastTeam3\" > <br/><br/> \n ");
    }
    else if(count($past_teams) == 3) { 
    print("<input type = \"text\" name = \"pastTeam1\" id = \"pastTeam1\" value = \"" . $past_teams[0] . "\" > <br/> \n ");
    print("<input type = \"text\" name = \"pastTeam2\" id = \"pastTeam2\" value = \"" . $past_teams[1] . "\" > <br/> \n ");
    print("<input type = \"text\" name = \"pastTeam3\" id = \"pastTeam3\" value = \"" . $past_teams[2] . "\" > <br/><br/> \n ");
    }
    print("<button type = \"submit\" name = \"submitButton\"  onClick='safeStatusChange(0," . $playerID . ")'> Change Player Status </button>");
    print("</form> \n");
    require ("lowerPlayer.php");

?>

