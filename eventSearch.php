<?php

require("head.php");

if (isset($_POST['submitButton'])) {
    
    if(!isset($_POST['event']) || $_POST['event']==NULL) {
        header("Location: eventSearchForm.php?err=0");
        exit;
    }
    
     $event = $_POST['event'];
    
     $query = "SELECT `description`,`eventID` FROM `events` "
            . "WHERE `description` LIKE '%" . $event . "%'";
     $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows==0) {
     header("Location: eventSearchForm.php?err=1");
     exit;
     }
     
     $events = array();
     $IDs = array();
     
     while($row = $result->fetch_array()) {
          $events[] = $row['description'];
          $IDs[] = $row['eventID'];
     }
     print("<h3> Events</h3><br/><br/><ul> ");
     for($i=0; $i<count($events); $i++) {
         print("<li><a href = 'presentEvent.php?eID=" . $IDs[$i] . "'> ". $events[$i] ." </a></li><br/><br/>\n");
     }
     print("</ul>");
     require ("lowerEvent.php");
}

?>