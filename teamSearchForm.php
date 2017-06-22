<?php

require("head.php");

if(isset($_GET['err'])) {
        $err= $_GET['err'];
        
        if($err==0) {
            print("<b> ERROR: You need to add the name of a team or part of the name of a team... </b> \n ");
        }
        else if($err==1) {
            print("<b> ERROR: No team was found... </b> \n ");
        }
        else if($err==2) {
            print("<b> ERROR: Something went wrong... </b> \n ");
        }
        else if($err==3) {
            print("<b> ERROR: You do not have the permission to change this team's status... </b> \n ");
        }
        else if($err==4) {
            print("<b> ERROR: The team's status was changed successfully... </b> \n ");
        }
        else if($err==5) {
            print("<b> Your request was granted... </b> \n ");
        }
        else if($err==6) {
            print("<b> The team was deleted successfully... </b> \n ");
        }
        else if($err==7) {
            print("<b> ERROR: The team cannot be deleted, because it participates in at least one tournament... </b> \n ");
        }
}

    print("<form id = \"teamSearchForm\" method = \"post\" action = \"./teamSearch.php\" > <br/><br/> \n");
    print("Type the team that you want to find...<br/><br/>\n");
    print("<input type=\"text\" name=\"team\" id = \"team\" > <br/><br/>\n");
    print("<button type = \"submit\" name = \"submitButton\"> Search Team </button>");
    print("</form> \n");
    print("<div class = \"eurindexContainer\">\n");
    print("<nav class = \"eurindex\">\n");
    print("<a href='teamSearchForm.php?flet=A'>A</a>\n");
    print("<a href='teamSearchForm.php?flet=B'>B</a>\n");
    print("<a href='teamSearchForm.php?flet=C'>C</a>\n");
    print("<a href='teamSearchForm.php?flet=D'>D</a>\n");
    print("<a href='teamSearchForm.php?flet=E'>E</a>\n");
    print("<a href='teamSearchForm.php?flet=F'>F</a>\n");
    print("<a href='teamSearchForm.php?flet=G'>G</a>\n");
    print("<a href='teamSearchForm.php?flet=H'>H</a>\n");
    print("<a href='teamSearchForm.php?flet=I'>I</a>\n");
    print("<a href='teamSearchForm.php?flet=J'>J</a>\n");
    print("<a href='teamSearchForm.php?flet=K'>K</a>\n");
    print("<a href='teamSearchForm.php?flet=L'>L</a>\n");
    print("<a href='teamSearchForm.php?flet=M'>M</a>\n");
    print("<a href='teamSearchForm.php?flet=N'>N</a>\n");
    print("<a href='teamSearchForm.php?flet=O'>O</a>\n");
    print("<a href='teamSearchForm.php?flet=P'>P</a>\n");
    print("<a href='teamSearchForm.php?flet=Q'>Q</a>\n");
    print("<a href='teamSearchForm.php?flet=R'>R</a>\n");
    print("<a href='teamSearchForm.php?flet=S'>S</a>\n");
    print("<a href='teamSearchForm.php?flet=T'>T</a>\n");
    print("<a href='teamSearchForm.php?flet=U'>U</a>\n");
    print("<a href='teamSearchForm.php?flet=V'>V</a>\n");
    print("<a href='teamSearchForm.php?flet=W'>W</a>\n");
    print("<a href='teamSearchForm.php?flet=X'>X</a>\n");
    print("<a href='teamSearchForm.php?flet=Y'>Y</a>\n");
    print("<a href='teamSearchForm.php?flet=Z'>Z</a>\n");
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
    
     $query = "SELECT `name`,`teamID` FROM `teams` "
            . "WHERE `name` LIKE '" . $flet . "%'";
     $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows!=0) {
         
     $teams = array();
     $IDs = array();
     
     while($row = $result->fetch_array()) {
          $teams[] = $row['name'];
          $IDs[] = $row['teamID'];
     }
     print("<div class = 'eurlist'>\n");
     for($i=0; $i<count($teams); $i++) {
         if($teams[$i]!='unknown') {
         print("<li><a href = 'presentTeam.php?tID=" . $IDs[$i] . "'> ". $teams[$i] ." </a></li><br/>\n");
         }
         
     }
     print("</div>\n");
     }
    }
    require ("lowerTeam.php");
    
        

?>

