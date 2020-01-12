<?php

	$country=$_GET['country'];		# Getting Country from form_location.js --> function fetchStates()
	
	#-------- Connecting to DB----------------------------------------------------------------------------------------
	$conn=mysqli_connect('localhost','root');
	mysqli_select_db($conn,'world_db');
	#------------------------------------------------------------------------------------------------------------

	# Query to fetch States-----------------------------------------------------------------------------
	$q="SELECT stateID,stateName FROM states s, countries c
		WHERE c.countryID = s.countryID
		AND c.countryID LIKE '$country'
		ORDER BY s.stateID";

	$result=mysqli_query($conn,$q);
	
	foreach ($result as $r)
	{
		echo '<option value="'.$r['stateID'].'" style="color:#111;">'.$r['stateName'].'</option>';
	}

	mysqli_close($conn);
?>