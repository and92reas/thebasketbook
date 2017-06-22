<?php

require("head.php");

    if(isset($_GET['err'])) {
        $err= $_GET['err'];
        
        if($err==0) {
            print("<b> ERROR: You need to add the name of an event or part of the name of an event... </b> \n ");
        }
        else if($err==1) {
            print("<b> ERROR: No event was found... </b> \n ");
        }
        else if($err==2) {
            print("<b> ERROR: Something went wrong... </b> \n ");
        }
        else if($err==3) {
            print("<b> ERROR: You do not have the permission to change this event's status... </b> \n ");
        }
        else if($err==4) {
            print("<b> The event's status was changed successfully... </b> \n ");
        }
        else if($err==5) {
            print("<b> Your request was granted... </b> \n ");
        }
        else if($err==6) {
            print("<b> The event was deleted successfully... </b> \n ");
        }
    }

    print("<form id = \"eventSearchForm\" method = \"post\" action = \"./eventSearch.php\" > <br/><br/> \n");
    print("Type the event that you want to find...<br/><br/>\n");
    print("<input type=\"text\" name=\"event\" id = \"event\" > <br/><br/>\n");
    print("<button type = \"submit\" name = \"submitButton\"> Search Event </button>");
    print("</form> \n");
    print("<div class = \"eurindexContainer\">\n");
    print("<nav class = \"eurindex\">\n");
    print("<a href='eventSearchForm.php?flet=A'>A</a>\n");
    print("<a href='eventSearchForm.php?flet=B'>B</a>\n");
    print("<a href='eventSearchForm.php?flet=C'>C</a>\n");
    print("<a href='eventSearchForm.php?flet=D'>D</a>\n");
    print("<a href='eventSearchForm.php?flet=E'>E</a>\n");
    print("<a href='eventSearchForm.php?flet=F'>F</a>\n");
    print("<a href='eventSearchForm.php?flet=G'>G</a>\n");
    print("<a href='eventSearchForm.php?flet=H'>H</a>\n");
    print("<a href='eventSearchForm.php?flet=I'>I</a>\n");
    print("<a href='eventSearchForm.php?flet=J'>J</a>\n");
    print("<a href='eventSearchForm.php?flet=K'>K</a>\n");
    print("<a href='eventSearchForm.php?flet=L'>L</a>\n");
    print("<a href='eventSearchForm.php?flet=M'>M</a>\n");
    print("<a href='eventSearchForm.php?flet=N'>N</a>\n");
    print("<a href='eventSearchForm.php?flet=O'>O</a>\n");
    print("<a href='eventSearchForm.php?flet=P'>P</a>\n");
    print("<a href='eventSearchForm.php?flet=Q'>Q</a>\n");
    print("<a href='eventSearchForm.php?flet=R'>R</a>\n");
    print("<a href='eventSearchForm.php?flet=S'>S</a>\n");
    print("<a href='eventSearchForm.php?flet=T'>T</a>\n");
    print("<a href='eventSearchForm.php?flet=U'>U</a>\n");
    print("<a href='eventSearchForm.php?flet=V'>V</a>\n");
    print("<a href='eventSearchForm.php?flet=W'>W</a>\n");
    print("<a href='eventSearchForm.php?flet=X'>X</a>\n");
    print("<a href='eventSearchForm.php?flet=Y'>Y</a>\n");
    print("<a href='eventSearchForm.php?flet=Z'>Z</a>\n");
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
        
        $query = "SELECT `description`,`eventID` FROM `events` "
            . "WHERE `description` LIKE '" . $flet . "%'";
     $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows!=0) {
     
     $events = array();
     $IDs = array();
     
     while($row = $result->fetch_array()) {
          $events[] = $row['description'];
          $IDs[] = $row['eventID'];
     }
     
     print("<div class = 'eurlist'>\n");
     for($i=0; $i<count($events); $i++) {
         print("<li><a href = 'presentEvent.php?eID=" . $IDs[$i] . "'> ". $events[$i] ." </a></li><br/><br/>\n");
     }
     print("</div>\n");
    }
    }
    require ("lowerEvent.php");
    
    
        

?>



