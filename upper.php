<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
  include 'config.php';
  include 'siteHead.php';
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Basketbook</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="http://fonts.googleapis.com/css?family=Chivo:400,900" rel="stylesheet" />
<link href="default.css" rel="stylesheet" type="text/css" media="all" />
<link href="fonts.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="script.js"></script>

</head>
<body>
<div id="wrapper">
	<div id="header-wrapper">
		<div id="header" class="container">
			<div id="logo">
				<h1><a href="home.php?err=0">Basketbook</a></h1>
				
			</div>
		</div>
	</div>
	<div id="menu-wrapper">
		<nav>
	<ul>
		<li><a href="home.php?err=0">Home</a></li>
                <li><a href="playerSearchForm.php">Players</a></li>
		<li><a href="teamSearchForm.php">Teams</a></li>
		<li><a href="tournamentSearchForm.php">Tournaments</a></li>
		<li><a href="eventSearchForm.php">Events</a></li>
                <?php
                if(!isSiteLoggedIn($mysqli)) {
		print("<li><a href=\"logInForm.php\">Login</a></li>\n");
                print("<li><a href=\"signInForm.php\">Sign In</a></li>\n");
                }
                else {
                 print("<li><a href=\"logOut.php\">Logout</a></li>");   
                }
                ?>
		
		
	</ul>
</nav>
		<!-- end #menu --> 
	</div>
	<div id="banner"></div>
	<div id="page" class="container">
		<div id="content">
			<div class="title">
				<h2>PICK N ROLL</h2>
				<span class="byline"></span> </div>
			<p>
