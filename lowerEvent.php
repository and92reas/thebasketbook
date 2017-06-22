</p>
			
		</div>
		<div id="sidebar">
			<div class="box2">
				<div class="title">
					<h2><?php 
                                    if(isSiteLoggedIn($mysqli)) {
                                    print(getSiteUser($mysqli));
                                    }
                                    else {
                                    print("OTHER");    
                                    }
                                    ?></h2>
				</div>
				<ul class="style2">
                                    <li><a href="newEventForm.php">Create new Event</a></li>
                                    <li><a href="playerSearchForm.php">Search Player</a></li>
                                    <li><a href="teamSearchForm.php">Search Team</a></li>
                                    <li><a href="tournamentSearchForm.php">Search Tournament</a></li>
                                    <li><a href="eventSearchForm.php">Search Event</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
	

<div id="footer-wrapper">
	
		
</div>

</body>
</html>

