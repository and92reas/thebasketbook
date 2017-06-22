<?php

require ("head.php");

if (isset($_POST['submitButton'])) {
    if(!isset($_POST['homeStats']) || ($_POST['homeStats']) == NULL || !isset($_POST['guestStats']) || ($_POST['guestStats']) == NULL) {
        header("Location: tournamentSearchForm.php?err=12");
        exit;
    }
    else if(!isset($_POST['tournamentID']) || !isset($_POST['mID']) || !isset($_POST['homeTeam']) || !isset($_POST['guestTeam'])) {
        
        header("Location: tournamentSearchForm.php?err=2");
        exit;
    }
    
    $home_team_points = (INT) mysqli_real_escape_string($mysqli,$_POST['homeStats']);
    $guest_team_points = (INT) mysqli_real_escape_string($mysqli,$_POST['guestStats']);       
    $tournamentID = mysqli_real_escape_string($mysqli,$_POST['tournamentID']);
    $matchID = mysqli_real_escape_string($mysqli,$_POST['mID']);
    $home_teamID = (INT) mysqli_real_escape_string($mysqli,$_POST['homeTeam']);
    $guest_teamID = (INT) mysqli_real_escape_string($mysqli,$_POST['guestTeam']);
    $type = (INT) mysqli_real_escape_string($mysqli,$_POST['type']);
    $rw = (INT) mysqli_real_escape_string($mysqli,$_POST['rw']);
    $round = (INT) mysqli_real_escape_string($mysqli,$_POST['round']);
    
    $home_player_names = array();
    $guest_player_names = array();
    $home_player_points = array();
    $guest_player_points = array();
    
    for ($i=0; $i<12; $i++) {
        if(isset($_POST['homePlayer' . ($i+1)]) && $_POST['homePlayer' . ($i+1)] != NULL) {
            $home_player_names[] = $_POST['homePlayer' . ($i+1)];
        }
        
         if(isset($_POST['guestPlayer' . ($i+1)]) && $_POST['guestPlayer' . ($i+1)] != NULL) {
            $guest_player_names[] = $_POST['guestPlayer' . ($i+1)];
        }
    }
    $hplayers_points = 0;
    for ($j=0; $j<count($home_player_names); $j++) {
            if(isset($_POST['homePoints' . ($j+1)]) && $_POST['homePoints' . ($j+1)]!= NULL) {
                $home_player_points[] = $_POST['homePoints' . ($j+1)];
                $hplayers_points = $hplayers_points + $_POST['homePoints' . ($j+1)];
            }
            else {
                header("Location: tournamentSearchForm.php?err=13");
                exit; 
            }
        }
    if ($hplayers_points > $home_team_points) {
        header("Location: tournamentSearchForm.php?err=16");
        exit;
    }   
    
    $gplayers_points = 0;
    for ($j=0; $j<count($guest_player_names); $j++) {
            if(isset($_POST['guestPoints' . ($j+1)]) && $_POST['guestPoints' . ($j+1)]!= NULL) {
                $guest_player_points[] = $_POST['guestPoints' . ($j+1)];
                $gplayers_points = $gplayers_points + $_POST['guestPoints' . ($j+1)];
            }
            else {
                header("Location: tournamentSearchForm.php?err=13");
                exit; 
            }
        }
        
     if ($gplayers_points > $guest_team_points) {
        header("Location: tournamentSearchForm.php?err=17");
        exit;
    }
    
     $mysqli->autocommit(false);   
        
     $query = "UPDATE `matches` SET `home_points` = " . $home_team_points . ", `guest_points` = " . $guest_team_points  
            . " WHERE `matchID` = " . $matchID;
     $result = mysqli_query($mysqli,$query);
     
     if(!$result) {
         
     header("Location: tournamentSearchForm.php?err=2");
     exit;
     }
     
     if($type==1) {
     
        if($home_team_points>$guest_team_points) {
            $hp = 2;
            $gp = 1;
        }
        else if($home_team_points<$guest_team_points)   {
            $hp = 1;
            $gp = 2;
        }
        else {
            deleteMatchUpdates($matchID, $mysqli);
            
            header("Location: tournamentSearchForm.php?err=2");
            exit;
        }
         
        $query = "UPDATE `teams_tournaments` SET `points_for` = `points_for` + " . $home_team_points . ""
                . ", `points_against` =  `points_against` + ". $guest_team_points . ", `league_points` = `league_points` + " . $hp . " "
                . "WHERE `tournamentID` = " . $tournamentID . " AND `teamID` = " . $home_teamID;
        $result = mysqli_query($mysqli,$query);
     
        if(!$result) {
            
        deleteMatchUpdates($matchID, $mysqli);
        
        header("Location: tournamentSearchForm.php?err=2");
        exit;
        }
        
        $query = "UPDATE `teams_tournaments` SET `points_for` = `points_for` + " . $guest_team_points . ""
                . ", `points_against` =  `points_against` + ". $home_team_points . ", `league_points` = `league_points` + " . $gp . " "
                . "WHERE `tournamentID` = " . $tournamentID . " AND `teamID` = " . $guest_teamID;
        $result = mysqli_query($mysqli,$query);
     
        if(!$result) {
        deleteMatchUpdates($matchID, $mysqli);
        
        header("Location: tournamentSearchForm.php?err=2");
        exit;
        }
        
        
    }
    
    else {
        $query = "UPDATE `teams_tournaments` SET `points_for` = `points_for` + " . $home_team_points . ""
                . ", `points_against` =  `points_against` + ". $guest_team_points
                . " WHERE `tournamentID` = " . $tournamentID . " AND `teamID` = " . $home_teamID;
        $result = mysqli_query($mysqli,$query);
     
        if(!$result) {
        deleteMatchUpdates($matchID, $mysqli);
        header("Location: tournamentSearchForm.php?err=2");
        exit;
        }
        
        $query = "UPDATE `teams_tournaments` SET `points_for` = `points_for` + " . $guest_team_points . ""
                . ", `points_against` =  `points_against` + ". $home_team_points
                . " WHERE `tournamentID` = " . $tournamentID . " AND `teamID` = " . $guest_teamID;
        $result = mysqli_query($mysqli,$query);
     
        if(!$result) {
        deleteMatchUpdates($matchID, $mysqli);
        
        header("Location: tournamentSearchForm.php?err=2");
        exit;
    }
    if($home_team_points>$guest_team_points) {
        $winner = $home_teamID;
    }
    else if ($home_team_points<$guest_team_points) {
        $winner = $guest_teamID;
    }
    else {
        deleteMatchUpdates($matchID, $mysqli);
        
        header("Location: tournamentSearchForm.php?err=2");
        exit;
    }
    
        if($rw % 2 ==0) {
            $query = "UPDATE `matches` SET guest_team = " . $winner . "" 
                . " WHERE `tournamentID` = " . $tournamentID . " AND `round` = " . ($round + 1) . " AND `row` = " . ($rw/2) . "";
            $result = mysqli_query($mysqli,$query);
     
            if(!$result) {
                
            deleteMatchUpdates($matchID, $mysqli);
            
            header("Location: tournamentSearchForm.php?err=2");
            exit;
            }
        }
        
        else {
            $query = "UPDATE `matches` SET home_team = " . $winner . "" 
                . " WHERE `tournamentID` = " . $tournamentID . " AND `round` = " . ($round + 1) . " AND `row` = " . ($rw/2 + 0.5) . "";
            $result = mysqli_query($mysqli,$query);
     
            if(!$result) {
            deleteMatchUpdates($matchID, $mysqli);
            
            header("Location: tournamentSearchForm.php?err=2");
            exit;
            }
        }
    }
        
        for ($i=0; $i<count($home_player_names); $i++) {
            $query = "SELECT `playerID` FROM `players`" 
                . " WHERE `name` = '" . $home_player_names[$i] . "' AND `present_team` = " . $home_teamID . " LIMIT 1  ";
            $result = mysqli_query($mysqli,$query);
            
            if($result->num_rows!=1) {
            deleteMatchUpdates($matchID, $mysqli);
            
            header("Location: tournamentSearchForm.php?err=2");
            exit;
            }
            
            $row = mysqli_fetch_assoc($result);
            $playerID = $row['playerID'];
            
            $query = "INSERT INTO `players_matches`(`playerID`,`matchID`,`points`)" 
                . "  VALUES(" . $playerID . "," . $matchID . "," . $home_player_points[$i] . ")";
            $result = mysqli_query($mysqli,$query);
            
            if(!$result) {
            deleteMatchUpdates($matchID, $mysqli);
            
            header("Location: tournamentSearchForm.php?err=2");
            exit;
            }
            
            $query = "INSERT INTO `players_notifications`(`playerID`,`topic`,`time_stamp`)" 
                . "  VALUES(" . $playerID . ",1," . time() . ")";
            $result = mysqli_query($mysqli,$query);
            
            if(!$result) {
            deleteMatchUpdates($matchID, $mysqli);
            
            header("Location: tournamentSearchForm.php?err=2");
            exit;
            }
        }
        
        for ($i=0; $i<count($guest_player_names); $i++) {
            $query = "SELECT `playerID` FROM `players`" 
                . " WHERE `name` = '" . $guest_player_names[$i] . "' AND `present_team` = " . $guest_teamID . " LIMIT 1  ";
            $result = mysqli_query($mysqli,$query);
            
            if($result->num_rows!=1) {
            deleteMatchUpdates($matchID, $mysqli);
            
            header("Location: tournamentSearchForm.php?err=2");
            exit;
            }
            
            $row = mysqli_fetch_assoc($result);
            $playerID = $row['playerID'];
            
            $query = "INSERT INTO `players_matches`(`playerID`,`matchID`,`points`)" 
                . "  VALUES(" . $playerID . "," . $matchID . "," . $guest_player_points[$i] . ")";
            $result = mysqli_query($mysqli,$query);
            
            if(!$result) {
            deleteMatchUpdates($matchID, $mysqli);
            
            header("Location: tournamentSearchForm.php?err=2");
            exit;
            }
            
            $query = "INSERT INTO `players_notifications`(`playerID`,`topic`,`time_stamp`)" 
                . "  VALUES(" . $playerID . ",1," . time() . ")";
            $result = mysqli_query($mysqli,$query);
            
            if(!$result) {
            deleteMatchUpdates($matchID, $mysqli);
            
            header("Location: tournamentSearchForm.php?err=2");
            exit;
            }
        }
        
        $query = "INSERT INTO `teams_notifications`(`teamID`,`topic`,`time_stamp`)" 
                . "  VALUES(" . $home_teamID . ",1," . time() . "),"
                .         "(" . $guest_teamID . ",1," . time() . ")";
            $result = mysqli_query($mysqli,$query);
            
            if(!$result) {
            deleteMatchUpdates($matchID, $mysqli);
            
            header("Location: tournamentSearchForm.php?err=2");
            exit;
            }
            
            
         $query = "INSERT INTO `tournaments_notifications`(`tournamentID`,`topic`,`time_stamp`)" 
                . "  VALUES(" . $tournamentID . ",1," . time() . ")";
            $result = mysqli_query($mysqli,$query);
            
            if(!$result) {
            deleteMatchUpdates($matchID, $mysqli);
            
            header("Location: tournamentSearchForm.php?err=2");
            exit;
            }   
        
        $mysqli->commit();
        $mysqli->autocommit(true);
        header("Location: tournamentSearchForm.php?err=15");
        exit;
        
     }
    
    


function deleteMatchUpdates($matchID,$mysqli) {
    $mysqli->rollback();
     
}



?>

