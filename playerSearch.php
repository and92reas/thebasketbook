<?php

require("head.php");

if (isset($_POST['submitButton'])) {
    
    if(!isset($_POST['player']) || $_POST['player']==NULL) {
        header("Location: playerSearchForm.php?err=0");
        exit;
    }
    
    $player = $_POST['player'];
    
    $query = "SELECT `name`,`present_team`,`playerID` FROM `players` "
            . "WHERE `name` LIKE '%" . $player . "%'";
     $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows==0) {
     header("Location: playerSearchForm.php?err=1");
     exit;
     }
     $players = array();
     $teamIDs = array();
     $playerIDs = array();
     
     while($row = $result->fetch_array()) {
          $players[] = $row['name'];
          $teamIDs[] = $row['present_team'];
          $playerIDs[] = $row['playerID'];
     }
     
     print("<h3> Players</h3><br/><br/><ul> ");
     for($i=0; $i<count($players);$i++) {
         
         if( $teamIDs[$i] != 1) {
         $query = "SELECT `name` FROM `teams` "
                . "WHERE `teamID` = " . $teamIDs[$i] . " LIMIT 1";
         $result = mysqli_query($mysqli,$query);
         
         if($result->num_rows==0) {
            header("Location: playerSearchForm.php?err=2");
            exit;
         }
         
         $row = mysqli_fetch_assoc($result);
         $team = $row['name'];
                 
            print("<li><a href = 'presentPlayer.php?pID=" . $playerIDs[$i] . "'> ". $players[$i] .""
                 . " </a> &nbsp&nbsp (<a href = 'presentTeam.php?tID=" . $teamIDs[$i] . "'> ". $team ." </a>)</li><br/>");
         }
         
         else {
             print("<li><a href = 'presentPlayer.php?pID=" . $playerIDs[$i] . "'> ". $players[$i] . "</a></li><br/>");
         }
         
         
     }
     print("</ul>");
     
     
     
    
           
    
    
    }    
    require ("lowerPlayer.php");
?>

