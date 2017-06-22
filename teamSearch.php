<?php

require("head.php");

if (isset($_POST['submitButton'])) {
    
    if(!isset($_POST['team']) || $_POST['team']==NULL) {
        header("Location: teamSearchForm.php?err=0");
        exit;
    }

    
    $team = $_POST['team'];
    
     $query = "SELECT `name`,`teamID` FROM `teams` "
            . "WHERE `name` LIKE '%" . $team . "%'";
     $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows==0) {
     header("Location: teamSearchForm.php?err=1");
     exit;
     }
     $teams = array();
     $IDs = array();
     
     while($row = $result->fetch_array()) {
          $teams[] = $row['name'];
          $IDs[] = $row['teamID'];
     }
     
     print("<h3>Teams</h3><br/><br/><ul> ");
     for($i=0; $i<count($teams); $i++) {
         if($teams[$i]!='unknown') {
         print("<li><a href = 'presentTeam.php?tID=" . $IDs[$i] . "'> ". $teams[$i] ." </a></li><br/>\n");
         }
         
     }
     print("</ul>");
     require ("lowerTeam.php");
     
}     
    
           
    
    
        

?>

