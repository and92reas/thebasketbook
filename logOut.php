<?php

require("head.php");

$memberID = isLoggedIn($mysqli);

$query = "DELETE FROM `logged_members` WHERE `memberID` = " . $memberID;
$result = mysqli_query($mysqli,$query);

if (!$result) {
    print("<b> The logout failed... </b>");
}
else {
    header("Location: logInForm.php?err=1");
}
?>

