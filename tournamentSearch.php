<?php

require("head.php");

if (isset($_POST['submitButton'])) {
    
    if(!isset($_POST['tournament']) || $_POST['tournament']==NULL) {
        header("Location: tournamentSearchForm.php?err=0");
        exit;
    }
    
     $tournament = $_POST['tournament'];
    
     $query = "SELECT `tournamentID`,`title` FROM `tournaments` "
            . "WHERE `title` LIKE '%" . $tournament . "%'";
     $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows==0) {
     header("Location: tournamentSearchForm.php?err=1");
     exit;
     }
     
     $tournaments = array();
     $IDs = array();
     
     while($row = $result->fetch_array()) {
          $tournaments[] = $row['title'];
          $IDs[] = $row['tournamentID'];
     }
     
     print("<h3>Tournaments</h3><br/><br/><ul> ");
     for ($i=0; $i<count($tournaments); $i++) {
         print("<li><a href = 'presentTournament.php?tID=" . $IDs[$i] ."'> ". $tournaments[$i] ." </a></li><br/>\n");
     }
}
print("</ul>");
require ("lowerTournament.php");


?>

