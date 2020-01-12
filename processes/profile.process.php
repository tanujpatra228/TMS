<?php 

include'../includes/connect.inc.php';
$conn = connection('tms');

# FILL PROFILE FORM IN "dashboard.php" -> PANE_PROFILE ---------
function fetchData($conn){
	$tutionId = $_POST['tutionId'];;
	# TUTION DATA----------------------------------------------------------
	$q = "SELECT * FROM tbl_tution WHERE tutionId LIKE '$tutionId'";
	$tution_data = mysqli_query($conn, $q);

	if (!$tution_data) {
		echo mysqli_error($conn);
		die();
	}

	$tution = mysqli_fetch_array($tution_data);

	$tutionPhoto = $tution['logo'];
	$tutionWebsite = $tution['url'];
	$tutionName = $tution['name'];
	$tutionTagline = $tution['tag_line'];
	$tutionPhn = $tution['phone'];
	$tutionEmail = $tution['email'];
	$tutionAddress = $tution['address'];

	$totalStudents = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_student WHERE tutionId LIKE '".$tutionId."'"));
	$totalStaff = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_staff WHERE tutionId LIKE '".$tutionId."'"));
	$totalBrnch = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_branch WHERE tutionId LIKE '".$tutionId."'"));

	# \TUTION DATA----------------------------------------------------------

	# ADMIN DATA------------------------------------------------------------
	$adminFname = '';
	$adminLname = '';
	$adminPhn = '';
	$adminEmail = '';
	$adminAddress = '';

	if ($_POST['userType'] == 'admin') {
		$q = "SELECT * FROM tbl_admin WHERE tutionId LIKE '$tutionId'";
		$admin_data = mysqli_query($conn, $q);
		if (!$admin_data) {
			echo mysqli_error($conn);
			die();
		}
		$admin = mysqli_fetch_array($admin_data);

		$adminFname = $admin['fname'];
		$adminLname = $admin['lname'];
		$adminPhn = $admin['phone'];
		$adminEmail = $admin['email'];
		$adminAddress = $admin['address'];
	}
	else {
		$q = "SELECT * FROM tbl_staff WHERE tutionId LIKE '$tutionId' AND staffId LIKE '".$_POST['userType']."'";
		$admin_data = mysqli_query($conn, $q);
		if (!$admin_data) {
			echo mysqli_error($conn);
			die();
		}
		$admin = mysqli_fetch_array($admin_data);

		$name = explode(" ", $admin['name']);
		$adminFname = $name[0];
		$adminLname = $name[1];
		$adminPhn = $admin['phone'];
		$adminEmail = $admin['email'];
		$adminAddress = $admin['address'];
	}

	/*$admin_data = mysqli_query($conn, $q);

	if (!$admin_data) {
		echo mysqli_error($conn);
		die();
	}

	$admin = mysqli_fetch_array($admin_data);*/

	# \ADMIN DATA------------------------------------------------------------

	?>
		<!-- ADDED BY AJAX -->
		<div class="row" style="padding-top: 10px;"> 
			<div class="col-sm-3">
				<!--left col--> 
				<div class="text-center"> 
					<img src="../images/tution/<?php echo$tutionPhoto;?>" class="avatar img-circle img-thumbnail" alt="Logo" id="img_logo" onclick="$('#tution_logo').click();" /> 
					<input type="file" name="tution_logo" id="tution_logo" class="text-center center-block file-upload input" onchange="updateLogo(this);" style="display: none;" accept="image/*" /> 
					<h6>Logo</h6> 
				</div>
			</hr>
			<br/> 
			<div class="panel panel-default"> 
				<div class="panel-heading">
					Website <i class="fa fa-link fa-1x"></i> 
				</div> 
				<div class="panel-body"> 
					<input type="text" name="tution_link" class="form-control input" value="<?php echo$tutionWebsite;?>" style="width: 100%;" /> 
				</div> 
			</div> 
			<div class="panel-body" style="margin-top: 50px;"> 
				<ul class="list-group"> 
					<li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i>
					</li> 
					<li class="list-group-item text-right">
						<span class="pull-left"><strong>Students</strong></span> <?php echo$totalStudents['total']; ?>
					</li> 
					<li class="list-group-item text-right">
						<span class="pull-left">
							<strong>Staff</strong>
						</span><?php echo $totalStaff['total']; ?>
					</li> 
					<li class="list-group-item text-right">
						<span class="pull-left"><strong>Branch</strong></span> <?php echo$totalBrnch['total']; ?>
					</li> 
				</ul> 
				</div> 
			</div><!--/col-3--> 
			<div class="col-sm-9"> 
				<span class="display-4">Tution Info.</span> 
				<div class="form-group"> 
					<div class="col-xs-6"> 
						<label for="tution_name">
							<h4>Tution name</h4>
						</label> 
						<input type="text" class="form-control input" name="tution_name" id="tution_name" placeholder="first name" title="Tution Name" value="<?php echo$tutionName; ?>" />
					</div> 
				</div> 
				<div class="form-group"> 
					<div class="col-xs-6"> 
						<label for="tag_line">
							<h4>Tagline</h4>
						</label> 
						<input type="text" class="form-control input" name="tag_line" id="tag_line" placeholder="Tagline" title="Tagline" value="<?php echo$tutionTagline;?>" /> 
					</div> 
				</div> 
				<div class="form-group"> 
					<div class="col-xs-6"> 
						<label for="tutionPhn">
							<h4>Mobile</h4>
						</label> 
						<input type="text" class="form-control input" name="tution_phn" id="tutionPhn" placeholder="enter Phone number" title="Phone number" value="<?php echo$tutionPhn;?>" /> 
					</div> 
				</div> 
				<div class="form-group"> 
					<div class="col-xs-6"> 
						<label for="tution_email">
							<h4>Email</h4>
						</label> 
						<input type="email" class="form-control input" name="tution_email" id="tution_email" placeholder="you@email.com" title="Email-ID" value="<?php echo$tutionEmail;?>" /> 
					</div> 
				</div> 
				<div class="form-group"> 
					<div class="col-xs-6"> 
						<label for="tution_address">
							<h4>Address</h4>
						</label> 
						<input type="text" class="form-control input" id="tution_address" name="tution_address" placeholder="Address" title="Address" value="<?php echo$tutionAddress;?>" /> 
					</div> 
				</div> 
				<br/>
				<br/> 
				<span class="display-4">Profile Info.</span> 
				<div class="form-group">
					<div class="col-xs-6"> 
						<label for="first_name">
							<h4>First Name</h4>
						</label> 
						<input type="text" class="form-control input" name="first_name" id="first_name" placeholder="first name" title="enter your first name if any." value="<?php echo$adminFname;?>" />
					</div> 
				</div> 
				<div class="form-group"> 
					<div class="col-xs-6"> 
						<label for="last_name">
							<h4>Last Name</h4>
						</label> 
						<input type="text" class="form-control input" name="last_name" id="last_name" placeholder="last name" title="enter your last name if any." value="<?php echo$adminLname;?>" />
					</div> 
				</div> 
				<div class="form-group"> 
					<div class="form-group"> 
						<div class="col-xs-6"> 
							<label for="mobile">
								<h4>Mobile</h4>
							</label> 
							<input type="tel" class="form-control input" name="mobile" id="mobile" placeholder="enter mobile number" title="enter your mobile number if any." value="<?php echo$adminPhn;?>"> 
						</div> 
					</div> 
					<div class="form-group"> 
						<div class="col-xs-6"> 
							<label for="email">
								<h4>Email</h4>
							</label> 
							<input type="email" class="form-control input" name="email" id="email" placeholder="you@email.com" title="Enter your Email-ID." value="<?php echo$adminEmail;?>" />
						</div> 
					</div> 
					<div class="form-group"> 
						<div class="col-xs-6"> 
							<label for="address">
								<h4>Address</h4>
							</label> 
							<input type="text" class="form-control input" id="location" placeholder="somewhere" title="enter a location" name="address" value="<?php echo$adminAddress;?>" /> 
						</div> 
					</div> 
					<div class="form-group"> 
						<div class="col-xs-12"> 
							<br> 
							<button class="btn btn-lg btn-outline-success" type="button" id="btn_tution_save" onclick="updateData();">
								<i class="glyphicon glyphicon-ok-sign"></i> Save</button> 
							</div> 
						</div>
					</div>
					<!-- <script type="text/javascript" src="../js/tms_profile.js"></script> -->
			</div><!--/col-9-->  
		</div>
	<?php
}
#---------------------------------------------------------------

# UPDATE LOGO in "dashboard.php" -> PANE_PROFILE ---------------
function updateLogo($conn){

	$_GET['tutionId'];
	$_FILES['tution_logo']['name'];
	$extension = explode(".", $_FILES['tution_logo']['name']);

	$valid_extensions = array('jpeg', 'jpg', 'png'); // valid extension
	
	//echo in_array($extension[1], $valid_extensions);
	if(in_array($extension[1], $valid_extensions)){
		$path = '../images/tution/'.$_GET['tutionId'].'.png';

		move_uploaded_file($_FILES['tution_logo']['tmp_name'], $path);

		$q = "UPDATE tbl_tution SET logo = '".$_GET['tutionId'].'.png'."' WHERE tutionId LIKE '".$_GET['tutionId']."';";
		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
		echo $path;
	}
	else{
		echo'0';
	}
}
#---------------------------------------------------------------

# UPDATE DATA in DB---------------------------------------------
function updateData($conn){
	$tutionWebsite = $_POST['tution_link'];
	$tutionName = $_POST['tution_name'];
	$tagLine = $_POST['tag_line'];
	$tutionPhn = $_POST['tution_phn'];
	$tutionEmail = $_POST['tution_email'];
	$tutionAddress = $_POST['tution_address'];

	$adminFname = $_POST['first_name'];
	$adminLname = $_POST['last_name'];
	$adminPhn = $_POST['mobile'];
	$adminEmail = $_POST['email'];
	$adminAddress = $_POST['address'];

	$userType = $_POST['userType'];

	$q = "UPDATE tbl_tution SET url = '$tutionWebsite', name = '$tutionName', tag_line = '$tagLine', address = '$tutionAddress', email = '$tutionEmail', phone = '$tutionPhn' WHERE tutionId LIKE '".$_POST['tutionId']."';";
	$result = mysqli_query($conn, $q) or die(mysqli_error($conn));

	if ($userType != 'admin') {
		$q = "UPDATE tbl_staff SET name = '$adminFname $adminLname', address = '$adminAddress', email = '$adminEmail', phone = '$adminPhn' WHERE tutionId LIKE '".$_POST['tutionId']."' AND staffId LIKE '".$userType."'";
		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
		echo $result;
	}
	else{
		$q = "UPDATE tbl_admin SET fname = '$adminFname', lname = '$adminLname', address = '$adminAddress', email = '$adminEmail', phone = '$adminPhn' WHERE tutionId LIKE '".$_POST['tutionId']."'";
		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
		echo $result;
	}
}
#---------------------------------------------------------------

$func = $_POST['func'];
$func($conn);

mysqli_close($conn);

?>