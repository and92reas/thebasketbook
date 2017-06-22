/*$(document).on('click','#deletePlayer',function(e) {
e.preventDefault();
e.stopImmediatePropagation();

return false;
} 
);*/
    
function safeDelete(type,ID) {
    if (type ==0) {
    document.getElementById("deletePlayerForm").onsubmit = function() {
        if(!confirm("Are you sure you want to delete this player?")) {
        location.assign("presentPlayer.php?pID=" + ID);
        return false;
    }
        }
}
    else if (type ==1) {
    document.getElementById("deleteTeamForm").onsubmit = function() {
    if(!confirm("Are you sure you want to delete this team?")) {
        location.assign("presentTeam.php?tID=" + ID);
        return false;
    }
    }
    }
    else if (type ==2) {
    document.getElementById("deleteTournamentForm").onsubmit = function() {
    if(!confirm("Are you sure you want to delete this tournament?")) {
        location.assign("presentTournament.php?tID=" + ID);
        return false;
    }
    }
    }
    else if (type ==3) {
    document.getElementById("deleteEventForm").onsubmit = function() {
    if(!confirm("Are you sure you want to delete this event?")) {
        location.assign("presentEvent.php?eID=" + ID);
        return false;
    }
    }
    }
}
    
function safeStatusChange(type,ID) {
    if (type ==0) {
        document.getElementById("PlayerForm").onsubmit = function() {
        if(!confirm("Are you sure you want to change the status of this player?")) {
        location.assign("changePlayerStatusForm.php?pID=" + ID);
        return false;
    }
    }
}
    else if (type ==1) {
        document.getElementById("TeamForm").onsubmit = function() {
    if(!confirm("Are you sure you want to change the status of this team?")) {
        location.assign("changeTeamStatusForm.php?tID=" + ID);
        return false;
    }
    }
    }
    else if (type ==2) {
        document.getElementById("TournamentForm").onsubmit = function() {
       if(!confirm("Are you sure you want to change the status of this tournament?")) {
        location.assign("changeTournamentStatusForm.php?tID=" + ID);
        return false;
    }
    }
    }
    else if (type ==3) {
        document.getElementById("EventForm").onsubmit = function() {
    if(!confirm("Are you sure you want to change the status of this event?")) {
        location.assign("changeEventStatusForm.php?eID=" + ID);
        return false;
    }
    }
    }
    }


function safeResultInsertion(ID) {
     document.getElementById("addResultForm").onsubmit = function() {
     if(!confirm("Are you sure you want to add this result? You will not be able to undo your action...")) {
     location.assign("addResultForm.php?mID=" + ID);
     return false;
 }
 }
}

function DropDownTextToBox(objDropdown, strTextboxId) {
        document.getElementById(strTextboxId).value = objDropdown.options[objDropdown.selectedIndex].value;
        DropDownIndexClear(objDropdown.id);
        document.getElementById(strTextboxId).focus();
    }

function DropDownIndexClear(strDropdownId) {
        if (document.getElementById(strDropdownId) != null) {
            document.getElementById(strDropdownId).selectedIndex = -1;
        }
    }
