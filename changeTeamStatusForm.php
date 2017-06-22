<?php

require("head.php");

if(isset($_GET['tID'])) {
        $teamID= $_GET['tID'];
        }
    else {
        
        header("Location: teamSearchForm.php?err=2");
        exit;
    }
    
    $memberID = isLoggedIn($mysqli);
    
    
    $query = "SELECT * FROM `admin_teams` "
            . "WHERE `memberID` = " . $memberID . " AND `teamID` = '" . $teamID . "' ";
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows!=1) {
         
     header("Location: teamSearchForm.php?err=3");
     exit;
     }
    
    $query = "SELECT * FROM `teams` "
            . "WHERE `teamID` = " . $teamID . " LIMIT 1";
    $result = mysqli_query($mysqli,$query);
        
     if($result->num_rows==0) {
         
     header("Location: teamSearchForm.php?err=2");
     exit;
     }
     
     $row = mysqli_fetch_assoc($result);
     $name = $row['name'];
     $area = $row['area'];
     $court = $row['court'];
     $foundation_year = $row['foundation_year'];
     $coach = $row['coach'];
     
     $query = "SELECT `success` FROM `teams_successes` "
            . "WHERE `teamID` = " . $teamID . " LIMIT 3";
     $result = mysqli_query($mysqli,$query);
        
     if(!$result) {
         
     header("Location: teamSearchForm.php?err=2");
     exit;
     }
     
     $teams_successes = array();
     
     while($row = $result->fetch_array()) {
         $teams_successes[] = $row['success'];
     }
     
    print("<form id = \"teamForm\" method = \"post\" action = \"./changeTeamStatus.php\" > <br/><br/> \n");
    print("<input type= \"hidden\" name = \"tID\" id = \"tID\" value = \"" . $teamID . "\"  > \n");
    print("Team Name:  " . $name . " <br/><br/> \n ");
    print("Area:            <input type = \"text\" name = \"area\" value = \"" . $area . "\" >  <br/><br/> \n");
    print("Court:           <input type = \"text\" name = \"court\" value = \"" . $court . "\" >  <br/><br/> \n");
    print("Foundation Year: <input type = \"text\" name = \"foundationYear\" value = \"" . $foundation_year . "\" >  <br/><br/> \n");
    print("Coach:           <input type = \"text\" name = \"coach\" value = \"" . $coach . "\" >  <br/><br/> \n");
    print("Successes: <br/> \n");
    if(count($teams_successes)==0) {
    print("<input type = \"text\" name = \"success1\" id = \"success1\" > <br/> \n ");
    print("<input type = \"text\" name = \"success2\" id = \"success2\" > <br/> \n ");
    print("<input type = \"text\" name = \"success3\" id = \"success3\" > <br/><br/> \n ");
    }
    else if(count($teams_successes)==1) {
    print("<input type = \"text\" name = \"success1\" id = \"success1\" value = \"" . $teams_successes[0] . "\" > <br/> \n ");
    print("<input type = \"text\" name = \"success2\" id = \"success2\" > <br/> \n ");
    print("<input type = \"text\" name = \"success3\" id = \"success3\" > <br/><br/> \n ");
    }
    else if(count($teams_successes)==2) {
    print("<input type = \"text\" name = \"success1\" id = \"success1\" value = \"" . $teams_successes[0] . "\" > <br/> \n ");
    print("<input type = \"text\" name = \"success2\" id = \"success2\" value = \"" . $teams_successes[1] . "\" > <br/> \n ");
    print("<input type = \"text\" name = \"success3\" id = \"success3\" > <br/><br/> \n ");
    }
    else if(count($teams_successes)==3) {
    print("<input type = \"text\" name = \"success1\" id = \"success1\" value = \"" . $teams_successes[0] . "\" > <br/> \n ");
    print("<input type = \"text\" name = \"success2\" id = \"success2\" value = \"" . $teams_successes[1] . "\" > <br/> \n ");
    print("<input type = \"text\" name = \"success3\" id = \"success3\" value = \"" . $teams_successes[2] . "\" > <br/><br/> \n ");
    }
    print("<button type = \"submit\" name = \"submitButton\"  onClick='safeStatusChange(1)'> Change Team Status </button>");
    print("</form> \n");
    require ("lowerTeam.php");
?>
