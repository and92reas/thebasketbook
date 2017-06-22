<?php

require("head.php");

    if(isset($_GET['err'])) {
        $err= $_GET['err'];
        
        if($err==0) {
            print("<b> ERROR: You need to add the name of a player or part of the name of a player... </b> \n ");
        }
        else if($err==1) {
            print("<b> ERROR: No player was found... </b> \n ");
        }
        else if($err==2) {
            print("<b> ERROR: Something went wrong... </b> \n ");
        }
        else if($err==3) {
            print("<b> ERROR: You do not have the permission to change this player's status... </b> \n ");
        }
        else if($err==4) {
            print("<b> The player's status was changed successfully... </b> \n ");
        }
        else if($err==5) {
            print("<b> Your request was granted... </b> \n ");
        }
        else if($err==6) {
            print("<b> The player was deleted successfully... </b> \n ");
        }
        
        
        
    }
    
    print("<form id = \"playerSearchForm\" method = \"post\" action = \"./playerSearch.php\" > <br/><br/> \n");
    print("Type the player that you want to find...<br/><br/>\n");
    print("<input type=\"text\" name=\"player\" id = \"player\" > <br/><br/>\n");
    print("<button type = \"submit\" name = \"submitButton\"> Search Player </button>\n");
    print("</form> \n");
    print("<div class = \"eurindexContainer\">\n");
    print("<nav class = \"eurindex\">\n");
    print("<a href='playerSearchForm.php?flet=A'>A</a>\n");
    print("<a href='playerSearchForm.php?flet=B'>B</a>\n");
    print("<a href='playerSearchForm.php?flet=C'>C</a>\n");
    print("<a href='playerSearchForm.php?flet=D'>D</a>\n");
    print("<a href='playerSearchForm.php?flet=E'>E</a>\n");
    print("<a href='playerSearchForm.php?flet=F'>F</a>\n");
    print("<a href='playerSearchForm.php?flet=G'>G</a>\n");
    print("<a href='playerSearchForm.php?flet=H'>H</a>\n");
    print("<a href='playerSearchForm.php?flet=I'>I</a>\n");
    print("<a href='playerSearchForm.php?flet=J'>J</a>\n");
    print("<a href='playerSearchForm.php?flet=K'>K</a>\n");
    print("<a href='playerSearchForm.php?flet=L'>L</a>\n");
    print("<a href='playerSearchForm.php?flet=M'>M</a>\n");
    print("<a href='playerSearchForm.php?flet=N'>N</a>\n");
    print("<a href='playerSearchForm.php?flet=O'>O</a>\n");
    print("<a href='playerSearchForm.php?flet=P'>P</a>\n");
    print("<a href='playerSearchForm.php?flet=Q'>Q</a>\n");
    print("<a href='playerSearchForm.php?flet=R'>R</a>\n");
    print("<a href='playerSearchForm.php?flet=S'>S</a>\n");
    print("<a href='playerSearchForm.php?flet=T'>T</a>\n");
    print("<a href='playerSearchForm.php?flet=U'>U</a>\n");
    print("<a href='playerSearchForm.php?flet=V'>V</a>\n");
    print("<a href='playerSearchForm.php?flet=W'>W</a>\n");
    print("<a href='playerSearchForm.php?flet=X'>X</a>\n");
    print("<a href='playerSearchForm.php?flet=Y'>Y</a>\n");
    print("<a href='playerSearchForm.php?flet=Z'>Z</a>\n");
    print("</nav>\n");
    print("</div>\n");
    print("<style type=\"text/css\">");
    print(".eurindex {
            margin-top: 10px;
        }
        .eurindex a{
            margin-left: 6px;
        }
        .eurlist {
            margin-top: 10px;
            text-align: left;
        }
        ");
    print("</style>\n");
    
    
    if(isset($_GET['flet'])) {
        $flet= $_GET['flet'];
         
        $query = "SELECT `name`,`present_team`,`playerID` FROM `players` "
            . "WHERE `name` LIKE '" . $flet . "%'";
        $result = mysqli_query($mysqli,$query);
        
        if($result->num_rows!=0) {
            $players = array();
            $teamIDs = array();
            $playerIDs = array();
     
            while($row = $result->fetch_array()) {
                $players[] = $row['name'];
                $teamIDs[] = $row['present_team'];
                $playerIDs[] = $row['playerID'];
            }
        print("<div class = 'eurlist'>\n");
        for($i=0; $i<count($players);$i++) {
        
         if( $teamIDs[$i] != 1) {
         $query = "SELECT `name` FROM `teams` "
                . "WHERE `teamID` = " . $teamIDs[$i] . " LIMIT 1";
         $result = mysqli_query($mysqli,$query);
         
            if($result->num_rows!=0) {
            $row = mysqli_fetch_assoc($result);
            $team = $row['name'];
                 
            print("<li><a href = 'presentPlayer.php?pID=" . $playerIDs[$i] . "'> ". $players[$i] .""
                 . " </a> &nbsp&nbsp (<a href = 'presentTeam.php?tID=" . $teamIDs[$i] . "'> ". $team ." </a>)</li><br/>");
            }
         }
         
         else {
             print("<li><a href = 'presentPlayer.php?pID=" . $playerIDs[$i] . "'> ". $players[$i] . "</a>\n");
         }
        }
        print("</div>\n");
        
        
    }
    }
    require ("lowerPlayer.php");
    
        

?>
