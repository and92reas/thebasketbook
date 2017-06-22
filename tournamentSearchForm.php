<?php

require("head.php");

    if(isset($_GET['err'])) {
        $err= $_GET['err'];
        
        if($err==0) {
            print("<b> ERROR: You need to add the name of a tournament or part of the name of a tournament... </b> \n ");
        }
        else if($err==1) {
            print("<b> ERROR: No tournament was found... </b> \n ");
        }
        else if($err==2) {
            print("<b> ERROR: Something went wrong... </b> \n ");
        }
        else if($err==3) {
            print("<b> ERROR: You do not have the permission to change this tournament's status... </b> \n ");
        }
        else if($err==4) {
            print("<b> The tournament's status was changed successfully... </b> \n ");
        }
        else if($err==5) {
            print("<b> Your request was granted... </b> \n ");
        }
        else if($err==6) {
            print("<b> ERROR: You need to add a message... </b> \n ");
        }
        else if($err==7) {
            print("<b> Your message was added... </b> \n ");
        }
        else if($err==8) {
            print("<b> The tournament was deleted successfully... </b> \n ");
        }
        else if($err==9) {
            print("<b> ERROR: The match has not been formed yet... </b> \n ");
        }
        else if($err==10) {
            print("<b> ERROR: The result has already been added... </b> \n ");
        }
        else if($err==11) {
            print("<b> ERROR: The cup's former round has not been completed... </b> \n ");
        }
        else if($err==12) {
            print("<b> ERROR: You should add the points of both the teams participating... </b> \n ");
        }
        else if($err==13) {
            print("<b> ERROR: There was a mistake when the players' stats were typed... </b> \n ");
        }
        else if($err==14) {
            print("<b> ERROR: Please delete manually the scores... </b> \n ");
        }
        else if($err==15) {
            print("<b> The result was inserted successfully... </b> \n ");
        }
        else if($err==16) {
            print("<b> ERROR: The sum of the scored points of the first team's players are more than the first team's points... </b> \n ");
        }
        else if($err==17) {
            print("<b> ERROR: The sum of the scored points of the second team's players are more than the second team's points... </b> \n ");
        }
    }

    print("<form id = \"tournamentSearchForm\" method = \"post\" action = \"./tournamentSearch.php\" > <br/><br/> \n");
    print("Type the tournament that you want to find...<br/><br/>\n");
    print("<input type=\"text\" name=\"tournament\" id = \"tournament\" > <br/><br/>\n");
    print("<button type = \"submit\" name = \"submitButton\"> Search Tournament </button>");
    print("</form> \n");
    print("<div class = \"eurindexContainer\">\n");
    print("<nav class = \"eurindex\">\n");
    print("<a href='tournamentSearchForm.php?flet=A'>A</a>\n");
    print("<a href='tournamentSearchForm.php?flet=B'>B</a>\n");
    print("<a href='tournamentSearchForm.php?flet=C'>C</a>\n");
    print("<a href='tournamentSearchForm.php?flet=D'>D</a>\n");
    print("<a href='tournamentSearchForm.php?flet=E'>E</a>\n");
    print("<a href='tournamentSearchForm.php?flet=F'>F</a>\n");
    print("<a href='tournamentSearchForm.php?flet=G'>G</a>\n");
    print("<a href='tournamentSearchForm.php?flet=H'>H</a>\n");
    print("<a href='tournamentSearchForm.php?flet=I'>I</a>\n");
    print("<a href='tournamentSearchForm.php?flet=J'>J</a>\n");
    print("<a href='tournamentSearchForm.php?flet=K'>K</a>\n");
    print("<a href='tournamentSearchForm.php?flet=L'>L</a>\n");
    print("<a href='tournamentSearchForm.php?flet=M'>M</a>\n");
    print("<a href='tournamentSearchForm.php?flet=N'>N</a>\n");
    print("<a href='tournamentSearchForm.php?flet=O'>O</a>\n");
    print("<a href='tournamentSearchForm.php?flet=P'>P</a>\n");
    print("<a href='tournamentSearchForm.php?flet=Q'>Q</a>\n");
    print("<a href='tournamentSearchForm.php?flet=R'>R</a>\n");
    print("<a href='tournamentSearchForm.php?flet=S'>S</a>\n");
    print("<a href='tournamentSearchForm.php?flet=T'>T</a>\n");
    print("<a href='tournamentSearchForm.php?flet=U'>U</a>\n");
    print("<a href='tournamentSearchForm.php?flet=V'>V</a>\n");
    print("<a href='tournamentSearchForm.php?flet=W'>W</a>\n");
    print("<a href='tournamentSearchForm.php?flet=X'>X</a>\n");
    print("<a href='tournamentSearchForm.php?flet=Y'>Y</a>\n");
    print("<a href='tournamentSearchForm.php?flet=Z'>Z</a>\n");
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
        
       $query = "SELECT `tournamentID`,`title` FROM `tournaments` "
            . "WHERE `title` LIKE '" . $flet . "%'";
     $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows!=0) {
         
     $tournaments = array();
     $IDs = array();
     
     while($row = $result->fetch_array()) {
          $tournaments[] = $row['title'];
          $IDs[] = $row['tournamentID'];
     }
     print("<div class = 'eurlist'>\n");
     for ($i=0; $i<count($tournaments); $i++) {
         print("<li><a href = 'presentTournament.php?tID=" . $IDs[$i] ."'> ". $tournaments[$i] ." </a></li><br/>\n");
     }
     print("</div>\n");
     }
    }
    require ("lowerTournament.php");
?>
