<?php
	include 'includes/connect.inc.php';
# connection(DB_NAME); retunes connection object
	$conn_world = connection('world_db');
	$q = 'SELECT stateID,stateName FROM states s, countries c WHERE c.countryID = s.countryID AND c.countryID LIKE "IND" ORDER BY stateName';
	$result = mysqli_query($conn_world,$q);
	mysqli_close($conn_world) or die('can not close connection!!');
#------------------------------------------------------------------------------------------------------

# connecting to tms
	$conn_tms = connection('tms');
	$q = "SELECT * FROM tbl_course;";
	$courses = mysqli_query($conn_tms, $q) or die("can't fetch Courses!!");
	mysqli_close($conn_tms);
#------------------------------------------------------------------------------------------------------
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>

	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
	<script type="text/javascript" src="bootstrap/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

	
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/fetch_location.js"></script>

	<script type="text/javascript" src="js/sweetalert.min.js"></script>
	<script type="text/javascript">
			// remove_ele() REMOVE one branch at a time from regi_form
		n=0;
		function remove_ele(ele){
			var div = '#'+ele;
			//alert('removing '+div);
			$(div).remove();
			n=n-1;
			console.log(n);
			$('#hidden_Input_branch').attr('value',n);
			update_num();
		}
			// update_num() updates serise no. , Name & Id of form filds in Branch Details Pane from regi_form
		function update_num(){
			i=1;
			$('.badge').each(function(){
				$(this).html(i);
				i=i+1;
			});

			i=1;
			$('.b_address').each(function(){
				value = 'b'+i+'_address';
				$(this).attr({'name':value,'id':value});
				i=i+1;
			});

			i=1;
			$('.b_address_error').each(function(){
				value = 'error-b'+i+'_address';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.b_state_selector').each(function(){
				value = 'b'+i+'_state';
				$(this).attr({'name':value,'id':value,'onchange':'fetchCities(this.value,\'b'+i+'_city\');'});
				i=i+1;
			});

			i=1;
			$('.b_state_error').each(function(){
				value = 'error-b'+i+'_state';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.b_city_selector').each(function(){
				value = 'b'+i+'_city';
				$(this).attr({'name':value,'id':value});
				i=i+1;
			});

			i=1;
			$('.b_city_error').each(function(){
				value = 'error-b'+i+'_city';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.b_phn').each(function(){
				value = 'b'+i+'_phn';
				$(this).attr({'name':value,'id':value});
				i=i+1;
			});

			i=1;
			$('.b_phn_error').each(function(){
				value = 'error-b'+i+'_phn';
				$(this).attr('id',value);
				i=i+1;
			});
		}

		$(document).ready(function(){
			/*$('.course').click(function(){
				$('.course').each(function(){
					if ($(this).attr('value') != 'undefined'){
						alert($(this).attr('value'));
					}
				});
			});*/
			$('.course-item').click(function(){
				var value = '';
				$('.course-item:checked').each(function(){
					value += $(this).attr('rel')+', ';
				});
				value = value.substring(0,value.length-1);
				$('#btn_course_seloctor').html(value);
			});
		});
	</script>

</head>
<body>
	<header>
		<?php
			include('navbar.php');
		?>
	</header>

	<section>
		<div class="container">
			<div class="row">
				<!-- RIGHT SECTION -->
                    <div class="col-md-3 register-left">
                        <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
                        <h3>Welcome</h3>
                        <p>Manage your tuition details with us and save your precious time.</p>
                        <a class="btn btn-lg btn-outline-light" href="login_admin.php">Login</a><br/>
                    </div>
				<!-- FORM SECTION -->
				<div class="col-md-7" id="form_section">
					<form method="POST" action="processes/register.process.php" id="register-form">
						<div class="row" style="background: rgba(0,0,0,0.8);padding: 15px; border-bottom: 1px solid #fff; margin-bottom: 20px;">
							<div class="col-md-10" style="padding-top: 10px;">
								<h4 class="text-left">Registration Form</h4>
							</div>
							<div class="col-md-2">
								<span class="glyphicon glyphicon-pencil"></span>
							</div>
						</div>

						<ul class="nav nav-tabs">
							<li class="nav-item active" id="link_step1"><a class="nav-link">Step 1</a></li>
							<li class="nav-item inactive" id="link_step2"><a class="nav-link">Step 2</a></li>
							<!-- <li class="nav-item inactive" id="link_step3"><a class="nav-link">Step 3</a></li> -->
						</ul>


						<div class="tab-content">
								<!-- OWNER DETAIL -->
							<div class="tab-pane active" id="pane_owner_detail">
								<div class="panel panel-default" style="background: transparent; border: 0px;">
									<div class="panel-heading" style="background: transparent;  color: #444; font-size: 20px; border: 0px; padding-left: 0px;">Owner Detail</div>

									<div class="panel-body">
										<div class="row">
											<div class="col-md-6 form-group">
												<input type="text" name="fname" id="fname" class="form-control input" placeholder="First Name">
												<span class="text-danger" id="error-fname"></span>
											</div>

											<div class="col-md-6 form-group">
												<input type="text" name="lname" id="lname" class="form-control input" placeholder="Last Name">
												<span class="text-danger" id="error-lname"></span>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6 form-group">
												<input type="email" name="email" id="email" class="form-control input" placeholder="Email Id">
												<span class="text-danger" id="error-email"></span>
											</div>

											<div class="col-md-6 form-group">
												<input type="text" name="mobile" id="mobile" class="form-control input" placeholder="Mobile no. (without country code)">
												<span class="text-danger" id="error-mobile"></span>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6 form-group">
												<input type="password" name="pwd" id="pwd" class="form-control input" placeholder="Password">
												<span class="text-danger" id="error-pwd"></span>
											</div>

											<div class="col-md-6 form-group">
												<input type="password" name="re-pwd" id="repwd" class="form-control input" placeholder="Re-Enter Password">
												<span class="text-danger" id="error-repwd"></span>
											</div>
										</div>

										<div class="row">
											<div class="col-md-12 form-group text-right">
												<button type="button" class="btn btn-outline-info btn-lg" id="btn_step1_next">Next</button>
											</div>
										</div>

									</div>
								</div>
							</div>	<!-- pane_owner_detail CLOSE -->

								<!-- TUITION DETAILS -->
							<div class="tab-pane" id="pane_classes_detail">

								<div class="panel panel-default" style="background: transparent; border: 0px;">
									<div class="panel-heading" style="background: transparent;  color: #fff; font-size: 20px; border: 0px; padding-left: 0px;"> Classes Detail</div>

									<div class="panel-body">

										<div class="row">	<!-- Class NAME -->
											<div class="col-md-12 form-group">
												<input type="text" name="class_name" class="form-control input" id="class_name" placeholder="Classes Name">
												<span class="text-danger" id="error-cname"></span>
											</div>
										</div>

										<div class="row">	
											<div class="col-md-7 form-group">
												<input type="text" name="class_tagline" id="class_tagline" class="form-control input" placeholder="Tagline">
												<span class="text-danger" id="error-tagline"></span>
											</div>
											<div class="col-md">
												<button type="button" id="btn_course_seloctor" class="btn form-control text-left input">Select Courses</button>
												<div id="course_selector_box" style="display: none;">
													<?php
														foreach ($courses as $course) {
															echo'<span class="course"><label><input type="checkbox" name="course[]" class="course-item input" rel="'.$course['name'].'" value="'.$course['short_name'].'" style="margin: 5px;">'.$course['name'].'</label></span>';
														}
													?>
												</div>
											</div>
										</div>

										<div class="row">	<!-- CLASS LOCATION -->
											<div class="col-md-5 form-group">
												<input type="text" name="class_address" class="form-control input" id="class_address" placeholder="Address">
												<span class="text-danger" id="error-caddress"></span>
											</div>

											<!-- <div class="col-md-3 form-group">
												<select name="class_country" class="form-control" id="class_country" onchange="fetchStates(this.value);fetchCities(this.value);">
													<option disabled selected value="0">Country</option>
													<?php /*foreach ($result as $row) {echo '<option value="'.$row['countryID'].'" style="color:#000;">'.$row['countryName'].'</option>';}*/
													?>
												</select>
												<span class="text-danger" id="error-ccountry"></span>
											</div> -->

											<div class="col-md-4 form-group">
												<select name="class_state" class="form-control input" id="class_state" onchange="fetchCities(this.value,'class_city');">
													<option disabled selected value="0">State</option>
													<?php 
															foreach ($result as $r){
																echo '<option value="'.$r['stateID'].'" style="color:#111;">'.$r['stateName'].'</option>';
															}
													?>
												</select>
												<span class="text-danger" id="error-cstate"></span>
											</div>

											<div class="col-md-3 form-group">
												<select name="class_city" class="form-control class_city input" id="class_city">
													<option disabled selected value="0">City</option>
												</select>
												<span class="text-danger" id="error-ccity"></span>
											</div>
										</div>

										<div class="row">	<!-- CLASS CONTACT DETAIL -->
											<div class="col-md-4 form-group">
												<input type="text" name="class_email" class="form-control input" id="class_email" placeholder="Email ID">
												<span class="text-danger" id="error-cemail"></span>
											</div>

											<div class="col-md-4 form-group">
												<input type="text" name="class_phn" class="form-control input" id="class_phn" placeholder="Phone No.">
												<span class="text-danger" id="error-cphn"></span>
											</div>

											<div class="col-md-4 form-group">
												<input type="text" name="class_website" class="form-control input" id="class_website" placeholder="URL of your Website">
												<span class="text-danger" id="error-cwebsite"></span>
											</div>
										</div>

										<div class="row">	<!-- BUTTONS -->
											<div class="col-md-6 form-group text-left">
												<button type="button" class="btn btn-outline-default btn-lg input" id="btn_step2_prev" style="margin-left: 20px;border-radius: 0px 0px 0px 15px; padding: auto;">Prev</button>
											</div>
											<div class="col-md-6 form-group text-right">
												<button type="button" class="btn btn-outline-success btn-lg input" id="btn_step2_regi">Submit</button>
											</div>
										</div>
									</div>
								</div>
							</div>	<!-- pane_classes_detail CLOSE -->

							<!-- <div class="tab-pane" id="pane_branch_detail">
											
									<div class="panel panel-default" style="background: transparent; border: 0px;">
										
										<div class="panel-heading" style="background: transparent;  color: white; font-size: 20px; border: 0px; padding-left: 0px;">Branch Detail</div>
										<span class="text-info">You can Add / Remove branch details any time from your Dashbord!</span>
								
										<div class="panel-body">
											
											<div id="branch_fields">
								
												<input type="hidden" name="hidden_Input_branch" id="hidden_Input_branch" class="input" value="0" />  HIDDEN INPUT FIELD POSSOBLE VALUES NUMBER OF BRANCH
								
													BRANCH 1
												<div class="row" id="branch1" style="padding-left: 0px;">
													<div class="col-md-1 form-group">
														<span class="badge" id="1" style="margin-top: 20px; margin-left: 0px; background: transparent; font-size: 15px;">1.</span>
													</div>
													<div class="col-md-3 form-group">
														<input type="text" name="b1_address" class="form-control b_address input" id="b1_address" placeholder="Shop no. / Area">
														<span class="text-danger" id="error-b1_address" class=" b_address_error"></span>
													</div>
													<div class="col-md-2 form-group">
														<select class="form-control input" name="b'+n+'_state" id="b'+n+'_state" class="b_state" onchange="fetchCities(this.value,'b'+n+'_city');">
															<option disabled selected value="0">State</option>
															<?php /*
																	foreach ($result as $r){
																		echo '<option value="'.$r['stateID'].'" style="color:#111;">'.$r['stateName'].'</option>';
																	}
																	*/
															?>
														</select>
														<span class="text-danger" id="error-b'+n+'_state"></span>
													</div>
													<div class="col-md-2 form-group">
														<select class="form-control" id="b1_city" name="b1_city" class="b_city">
															<option disabled selected>City</option>
														</select>
														<span class="text-danger" id="error-b'+n+'_city"></span>
													</div>
													<div class="col-md-3 form-group">
														<input type="text" name="b1_phn" class="form-control b_phn" placeholder="Phone No.">
														<span class="text-danger b_phn_error" id="error-b1_phn"> </span>
													</div>
													<div class="col-md-1 form-group" style="margin-top: 15px;">
														<button type="button" class="btn btn-danger btn-xs remove" id="remove_branch" onclick="remove_ele('branch1');">
															<span class="glyphicon glyphicon-remove"></span>
														</button>
													</div>
												</div>
								
											</div>
											<div class="row">
												<button type="button" class="btn btn-outline-primary btn-sm" id="add_branch">
													<span class="glyphicon glyphicon-plus"></span>
												</button>
											</div>
											
											<div class="row">
												<div class="col-md-12 form-group" align="center">
													<button type="button" class="btn btn-outline-default btn-lg" id="btn_step3_prev">Prev</button>
													<button type="button" class="btn btn-outline-success btn-lg" id="btn_step3_regi">Register</button>
												</div>
											</div>
								
										</div>
									</div>
								</div> -->	<!-- pane_branch_detail CLOSE -->					
						</div>

					</form>
				</div>
					
			</div>	
		</div>	<!-- CONTAINER CLOSE -->
	</section>

	<!-- FOOTER -->
      	<?php
      		include('footer.php');
      	?>

</body>
<script type="text/javascript" src="js/regi_validation.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		$("#add_branch").click(function(){
			n=n+1;
			console.log(n);
			var bid = 'branch'+n;
			var data = '<div class="row" id="'+bid+'" style="padding-left: 0px;"><div class="col-md-1 form-group"><span class="badge" id="'+n+'" style="margin-top: 20px; margin-left: 0px; background: transparent; font-size: 15px;">'+n+'.</span></div><div class="col-md-3 form-group"><input type="text" name="b_address[]" class="form-control b_address input" id="b'+n+'_address" placeholder="Shop no. / Area" /><span class="text-danger b_address_error" id="error-b'+n+'_address"></span></div><div class="col-md-2 form-group"><select class="form-control b_state_selector input" name="b_state[]" id="b'+n+'_state" onchange="fetchCities(this.value,\'b'+n+'_city\')";><option disabled selected value="0">State</option><?php foreach ($result as $r){echo '<option value="'.$r['stateID'].'" style="color:#111;">'.$r['stateName'].'</option>';}?></select><span class="text-danger b_state_error" id="error-b'+n+'_state"></span></div><div class="col-md-2 form-group"><select class="form-control b_city_selector input" id="b'+n+'_city" name="b_city[]"><option disabled selected>City</option></select><span class="text-danger b_city_error" id="error-b'+n+'_city"></span></div><div class="col-md-3 form-group"><input type="text" name="b_phn[]" id="b'+n+'_phn" class="form-control b_phn input" placeholder="Phone No." /><span class="text-danger b_phn_error" id="error-b'+n+'_phn"></span></div><div class="col-md-1 form-group" style="margin-top: 15px;"><button type="button" class="btn btn-outline-danger btn-xs" id="remove_branch'+n+'" onclick="remove_ele(\''+bid+'\');"><span class="glyphicon glyphicon-remove"></span></button></div></div>';
			$('#branch_fields').append(data);

			if(n>=0)
			{
				console.log('n>=0');
				$('#hidden_Input_branch').attr('value',n);
			}
		});


		$('#logo_img').click(function(){
			$('#class_logo').click();
			//console.log($('#class_logo').val());
		});

		$('#btn_course_seloctor').click(function(){
			$('#course_selector_box').slideToggle();
		});

		//$('.course')

	});
</script>


<script type="text/javascript">
</script>
</html>