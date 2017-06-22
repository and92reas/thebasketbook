<?php

require("head.php");

if(isset($_GET['err'])) {
        $err= $_GET['err'];
        if($err==0) {
            print("<b> ERROR: You need to add a player's name... </b>");
        }
        else if($err==1) {
            print("<b> ERROR: The birthdate is imcomplete or wrong... if you do not want to add a birthdate, "
                    . "leave ALL the boxes empty... </b>");
        }
        else if($err==2) {
            print("<b> ERROR: The present team you added does not exist in the database, either create it before inserting the player "
                    . "or leave the present team's box empty... </b>");
        }
        else if($err==3) {
            print("<b> ERROR: Unfortunately the player was not inserted successfully... </b>");
        }
        else if($err==4) {
            print("<b> ERROR: There is already a player with that name in the database... </b>");
        }
        else if($err==5) {
            print("<b> ERROR: The player was not inserted successfully, please delete him manually... </b>");
        }
        
        
}

    $query = "SELECT `name` FROM `teams` "
            . "WHERE `name` <> 'unknown' ORDER BY name";
    $result = mysqli_query($mysqli,$query);
    $row = mysqli_fetch_assoc($result);
    
    $teams = array();
    
    while($row = $result->fetch_array()) {
        $teams[] = $row['name']; 
    }
    
    

    print("<form id = \"newPlayerForm\" method = \"post\" action = \"./addNewPlayer.php\" > <br/><br/> \n");
    print("Name:           <input type = \"text\" name = \"playerName\" > (*) <br/><br/> \n ");
    print("<label for = \"presentTeam\"> (if the player does not play for a team that exists in the site, leave the box blank) </label> <br/> \n");
    
    print("Present Team: <input name='presentTeam' type=\"text\" maxlength=\"50\" id='presentTeam' 
    onclick=\"DropDownIndexClear('presentTeamMenu');\" readonly = \"readonly\"/>
    <select name=\"presentTeamMenu\" id='presentTeamMenu'  
    onchange=\"DropDownTextToBox(this,'presentTeam');\""
    . "<option value=\"\">No Team Selected</option>"
    . "<option value=\"\">Free</option>");
            
    for ($i=0; $i<count($teams); $i++) {
       print("<option value=\"" . $teams[$i] . "\">" . $teams[$i] . "</option>");
    }
     
    print("</select><br/><br/>\n");
   
    print("Position:      <input name='position' type=\"text\" maxlength=\"50\" id='position' 
    onclick=\"DropDownIndexClear('positionMenu');\" readonly = \"readonly\"/>
    <select name=\"positionMenu\" id='positionMenu'  
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
    print("<input type = \"text\" name = \"day\" id = \"day\" > <br/><br/> \n ");
    print("<label for = \"month\"> month </label> <br/> \n");
    print("<input type = \"text\" name = \"month\" id = \"month\" > <br/><br/> \n ");
    print("<label for = \"year\"> year </label> <br/> \n");
    print("<input type = \"text\" name = \"year\" id = \"year\" > <br/><br/> \n ");
    print("<label for = \"loanedBy\"> (If the player is not loaned by some other team leave the box blank) </label> <br/> \n");
    print("Loaned By:     <input type = \"text\" name = \"loanedBy\" id = \"loanedBy\" > <br/><br/> \n ");
    print("Past Teams: <br/> \n");
    print("<input type = \"text\" name = \"pastTeam1\" id = \"pastTeam1\" > <br/> \n ");
    print("<input type = \"text\" name = \"pastTeam2\" id = \"pastTeam2\" > <br/> \n ");
    print("<input type = \"text\" name = \"pastTeam3\" id = \"pastTeam3\" > <br/><br/> \n ");
    print("<button type = \"submit\" name = \"submitButton\"> Insert player </button>");
    print("</form> \n");
    require ("lowerPlayer.php");

?>

