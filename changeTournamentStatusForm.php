<?php

require("head.php");

if(isset($_GET['tID'])) {
        $tournamentID= $_GET['tID'];
        }
    else {
        header("Location: tournamentSearchForm.php?err=2");
        exit;
    }
    
    $memberID = isLoggedIn($mysqli);
    
    
    $query = "SELECT * FROM `admin_tournaments` "
            . "WHERE `memberID` = " . $memberID . " AND `tournamentID` = " . $tournamentID . " ";
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows!=1) {
     header("Location: tournamentSearchForm.php?err=3");
     exit;
     }
    
    $query = "SELECT * FROM `tournaments` "
            . "WHERE `tournamentID` = " . $tournamentID . " LIMIT 1";
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows==0) {
     header("Location: tournamentSearchForm.php?err=2");
     exit;
     }
     
     $row = mysqli_fetch_assoc($result);
     $title = $row['title'];
     $start_date = $row['start_date'];
     $end_date = $row['end_date'];
     
     print("<form id = \"tournamentForm\" method = \"post\" action = \"./changeTournamentStatus.php\" > <br/><br/> \n");
     print("<input type= \"hidden\" name = \"tID\" id = \"tID\" value = \"" . $tournamentID . "\"  > \n");
     print("Tournament Title: " . $title . " <br/> \n ");
     print("Beginning Date:  <input type = \"text\" name = \"startDate\" id = \"startDate\" value = \"" . $start_date . "\" > (dd/mm/yyyy) <br/> \n ");
     print("Ending Date:     <input type = \"text\" name = \"endDate\" id = \"endDate\" value = \"" . $end_date . "\" > (dd/mm/yyyy) <br/> \n");
     print("<button type = \"submit\" name = \"submitButton\" onClick='safeStatusChange(2)'> Change Tournament Status </button>");
     print("</form>\n");
     require ("lowerTournament.php");
     ?>

