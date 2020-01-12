<?php

	$state=$_GET['state'];  # Getting State from form_location.js --> function fetchCities()
	#$state="Maharastra";


	# Passing Cities as per $State to form_location.js---------------------------------------------- 

		#-------- Connecting to DB-------------------------------------------------------------------
		$conn=mysqli_connect('localhost','root');
		mysqli_select_db($conn,'world_db');
		#---------------------------------------------------------------------------------------------------------
		

		# Query to fetch Cities--------------------------------------------------------------------------------
		$q="SELECT cityID, cityName FROM cities c , states s
			WHERE s.stateID=c.stateID
			AND s.stateID='$state'
			ORDER BY c.cityName;";
		$result=mysqli_query($conn,$q);
		
		echo "<option value='0' disabled selected>City</option>";

		foreach ($result as $r)
		{
			echo '<option value="'.$r['cityName'].'" style="color:#111;">'.$r['cityName'].'</option>';
		}

		mysqli_close($conn);

?>