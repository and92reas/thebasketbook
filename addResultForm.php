<?php

require ("head.php");

if(isset($_GET['mID'])) {
    $matchID = $_GET['mID'];
    }
    else {
        header("Location: tournamentSearchForm.php?err=2");
        exit;
    }
       
    
    $query = "SELECT `home_team`,`guest_team`,`home_points`,`guest_points`,tournaments.tournamentID as tourID"
            . ",`row`,`round`,`type`,`name` FROM `matches`,`tournaments`,`teams` "
            . " WHERE `matchID` = " . $matchID . " AND tournaments.tournamentID = matches.tournamentID AND `teamID` = `home_team` ORDER BY `matchID` LIMIT 1" ;
    $result = mysqli_query($mysqli,$query);
        
    if(!$result) {
        
    header("Location: tournamentSearchForm.php?err=2");
    exit;
    }
    
    $row = mysqli_fetch_assoc($result);
    $home_teamID = $row['home_team'];
    $home_name = $row['name'];
    $guest_teamID = $row['guest_team'];
    $home_points = $row['home_points'];
    $guest_points = $row['guest_points'];
    $tournamentID = $row['tourID'];
    $rw = $row['row'];
    $round = $row['round'];
    $type = $row['type'];
    
    $query = "SELECT `name` FROM `matches`,`teams` "
            . " WHERE `matchID` = " . $matchID . " AND `teamID` = `guest_team` ORDER BY `matchID` LIMIT 1" ;
    $result = mysqli_query($mysqli,$query);
        
    if(!$result) {
        
    header("Location: tournamentSearchForm.php?err=2");
    exit;
    }
    $row = mysqli_fetch_assoc($result);
    $guest_name = $row['name'];
    
    $memberID = isLoggedIn($mysqli);
    
    
    $query = "SELECT * FROM `admin_tournaments` "
            . "WHERE `memberID` = " . $memberID . " AND `tournamentID` = " . $tournamentID . " ";
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows!=1) {
     header("Location: tournamentSearchForm.php?err=3");
     exit;
     }
     
     if ($home_teamID ==1 || $guest_teamID == 1) {
        header("Location: tournamentSearchForm.php?err=9");
        exit; 
     }
     
     if($home_points != NULL) {
        header("Location: tournamentSearchForm.php?err=10");
        exit;
     }
     
     if($type == 0 && $round>0) {
     
     $query = "SELECT `home_points` FROM `matches` "
            . "WHERE `round` = " . ($round-1) . " AND `tournamentID` = " . $tournamentID;
     $result = mysqli_query($mysqli,$query);
     
     while($row = $result->fetch_array()) {
        if($row['home_points']==NULL) {
            header("Location: tournamentSearchForm.php?err=11");
            exit;
        }  
     }
     
     }
     $home_players = array();
     
     $query = "SELECT players.name AS pname FROM `players`,`teams` "
            . "WHERE teamID = " . $home_teamID . " AND `present_team` = `teamID` ";
     $result = mysqli_query($mysqli,$query);
     
     while($row = $result->fetch_array()) {
        $home_players[] = $row['pname'];   
     }
     
     $guest_players = array();
     
     $query = "SELECT players.name AS pname FROM `players`,`teams` "
            . "WHERE teamID = " . $guest_teamID . " AND `present_team` = `teamID` ";
     $result = mysqli_query($mysqli,$query);
     
     while($row = $result->fetch_array()) {
        $guest_players[] = $row['pname'];   
     }
     
     /***********************************************
    print("
      <div style=\"position: relative;\">
        <input name=\"TextboxExample\" type=\"text\" maxlength=\"50\" id=\"TextboxExample\" tabindex=\"2\"
        onchange=\"DropDownIndexClear('DropDownExTextboxExample');\" style=\"width: 242px;
        position: absolute; top: 0px; left: 0px; z-index: 2;\" />
    <select name=\"DropDownExTextboxExample\" id=\"DropDownExTextboxExample\" tabindex=\"1000\"
        onchange=\"DropDownTextToBox(this,'TextboxExample');\" style=\"position: absolute;
        top: 0px; left: 0px; z-index: 1; width: 265px;\">");
    
    for ($i=0; $i<count($home_players); $i++) {
    print("<option value=\"" . $home_players[$i] . "\" >" . $home_players[$i] . "</option>");
    }
    print("</select>
    
    </div>");
    
    print("
        <input name='homePlayer". ($i+1) ."' type=\"text\" maxlength=\"50\" id='homePlayer". ($i+1) ."' tabindex=\"2\"
        onchange=\"DropDownIndexClear('homePlayerMenu". ($i+1) ."');\" style=\"width: 242px;
        position: absolute; top: 0px; left: 0px; z-index: 2;\" />
    <select name=\"DropDownExTextboxExample\" id='homePlayerMenu". ($i+1) ."' class='playerMenu' tabindex=\"1000\"
        onchange=\"DropDownTextToBox(this,'homePlayer". ($i+1) ."');\"");
    
    for ($i=0; $i<count($home_players); $i++) {
    print("<option value=\"" . $home_players[$i] . "\" >" . $home_players[$i] . "</option>");
    }
    print("</select>");
   
     /************************************************/
     
    print("<form id = \"addResultForm\" method = \"post\" action = \"./addResult.php\" > <br/><br/> \n");
    print("<input type= \"hidden\" name = \"mID\" id = \"mID\" value = \"" . $matchID . "\"  > \n");
    print("<input type= \"hidden\" name = \"homeTeam\" id = \"homeTeam\" value = \"" . $home_teamID . "\"  > \n");
    print("<input type= \"hidden\" name = \"guestTeam\" id = \"guestTeam\" value = \"" . $guest_teamID . "\"  > \n");
    print("<input type= \"hidden\" name = \"tournamentID\" id = \"tournamentID\" value = \"" . $tournamentID . "\"  > \n");
    print("<input type= \"hidden\" name = \"type\" id = \"type\" value = \"" . $type . "\"  > \n");
    print("<input type= \"hidden\" name = \"round\" id = \"round\" value = \"" . $round . "\"  > \n");
    print("<input type= \"hidden\" name = \"rw\" id = \"rw\" value = \"" . $rw . "\"  > \n");
    
    print($home_name . " points: <input type = \"text\" name = \"homeStats\" > (*)<br/><br/>");
    for ($i=0; $i<12; $i++) {
        print("<label for = \"homePlayer" . ($i+1) . "\"> player name </label> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"
                . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <label for = \"homePoints" . ($i+1) . "\"> points </label> <br/> \n");
        print("<input name='homePlayer". ($i+1) ."' type=\"text\" maxlength=\"50\" id='homePlayer". ($i+1) ."'  "
                . "onclick=\"DropDownIndexClear('homePlayerMenu". ($i+1) ."');\" />
    <select name=\"DropDownExTextboxExample\" id='homePlayerMenu". ($i+1) ."' class='playerMenu'  
        onchange=\"DropDownTextToBox(this,'homePlayer". ($i+1) ."');\""
                . "<option value=\"\">No Player Selected</option>"
                . "<option value=\"\">No Player Selected</option>");
    
        for ($j=0; $j<count($home_players); $j++) {
        print("<option value=\"" . $home_players[$j] . "\" >" . $home_players[$j] . "</option>");
        }
        print("</select> <input type = \"text\" name = \"homePoints" . ($i+1) ."\" id = \"homePoints" . ($i+1) ."\" > <br/>");
    }
    print("<br/><br/><br/>" . $guest_name . " points: <input type = \"text\" name = \"guestStats\" > (*) <br/><br/>");
    for ($i=0; $i<12; $i++) {
        print("<label for = \"guestPlayer" . ($i+1) . "\"> player name </label> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"
                . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <label for = \"guestPoints" . ($i+1) . "\"> points </label> <br/> \n");
        print("<input name='guestPlayer". ($i+1) ."' type=\"text\" maxlength=\"50\" id='guestPlayer". ($i+1) ."' 
        onclick=\"DropDownIndexClear('guestPlayerMenu". ($i+1) ."');\" />
    <select name=\"DropDownExTextboxExample\" id='guestPlayerMenu". ($i+1) ."' class='playerMenu' 
        onchange=\"DropDownTextToBox(this,'guestPlayer". ($i+1) ."');\""
                . "<option value=\"\">No Player Selected</option>"
                . "<option value=\"\">No Player Selected</option>");
        
    
        for ($j=0; $j<count($guest_players); $j++) {
        print("<option value=\"" . $guest_players[$j] . "\" >" . $guest_players[$j] . "</option>");
        }
        print("</select> <input type = \"text\" name = \"guestPoints" . ($i+1) ."\" id = \"guestPoints" . ($i+1) ."\" > <br/>");
    }
    print("<button type = \"submit\" name = \"submitButton\" onClick='safeResultInsertion(" . $matchID . ")'> Insert Match Result </button>");
    print("</form> \n");
    require ("lowerTournament.php");
     

?>

