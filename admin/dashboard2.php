<?php
session_start();
if (!isset($_SESSION['type'])){
	header("Location: ../index.php");
	exit();
}
//$_SESSION['type'] = 'admin';
#
include '../includes/connect.inc.php';
		# connection(DB_NAME); retunes connection object
# States , Cities
	$conn = connection('world_db');
	$q = 'SELECT stateID,stateName FROM states s, countries c WHERE c.countryID = s.countryID AND c.countryID LIKE "IND" ORDER BY stateName';
	$result = mysqli_query($conn,$q);
	mysqli_close($conn) or die('can not close connection to worldDb');
#--------------------------------------------------------

# connect and fetch to TutionManagementSystem
	 //$_SESSION['tutionId'] = 'T0000001';
	$conn = connection('tms');
	
	$q = "SELECT * FROM tbl_tution WHERE tutionId LIKE '".$_SESSION['tutionId']."'";
	$tution = mysqli_fetch_array(mysqli_query($conn, $q));

	$q = "SELECT * FROM tbl_branch WHERE tutionId LIKE '".$_SESSION['tutionId']."'";
	$branches = mysqli_query($conn, $q);

	$q = "SELECT *, COUNT(*) as totStudents FROM tbl_students WHERE tutionId LIKE '".$_SESSION['tutionId']."';";
	$students = mysqli_query($conn, $q);

	if ($_SESSION['type'] == 'staff') {
		$q = "SELECT * FROM tbl_staff WHERE tutionId LIKE '".$_SESSION['tutionId']."' AND staffId LIKE '".$_SESSION['staffId']."'";
		$staff = mysqli_query($conn, $q);
		$staff = mysqli_fetch_array($staff);
	}

	$q = "SELECT COUNT(*) AS totBranch FROM tbl_branch WHERE tutionId LIKE '".$_SESSION['tutionId']."'";
	$totbranches = mysqli_fetch_array(mysqli_query($conn, $q));
	
	$q = "SELECT COUNT(*) AS totStaff FROM tbl_staff WHERE tutionId LIKE '".$_SESSION['tutionId']."'";
	$totstaffs = mysqli_fetch_array(mysqli_query($conn, $q));
	
	$q = "SELECT COUNT(*) AS totStudent FROM tbl_student WHERE tutionId LIKE '".$_SESSION['tutionId']."'";
	$totstudents = mysqli_fetch_array(mysqli_query($conn, $q));

	mysqli_close($conn) or die('can not close connection to tms');
#------------------------------------------------------------------------------------------------------
	$courses = preg_split("/:/",$tution['course']);
	$in = "IN (";
	foreach ($courses as $course) {
		if ($in == 'IN ('){
			$in .= "'$course'";
		}
		else{
			$in .= ",'$course'";
		}
	}
	$in .= ")";
	
	$q = "SELECT * FROM tbl_course WHERE short_name ".$in;
	$conn = connection('tms');
	$courses = mysqli_query($conn, $q);
	mysqli_close($conn);

	$course_array = '{';
	foreach ($courses as $course){
		if ($course_array == "{") {
			$course_array .= '"'.$course['short_name'].'" : "'.$course['name'].'"';
		}
		else{
			$course_array .= ',"'.$course['short_name'].'" : "'.$course['name'].'"';
		}
		$course_array .= "";
	}
	$course_array .= '}';


	$branch_array = "{";
	foreach ($branches as $branch){
		if ($branch_array == "{") {
			$branch_array .= "'".$branch['branchId']."' : '".$branch['address']."'";
		}
		else{
			$branch_array .= ",'".$branch['branchId']."' : '".$branch['address']."'";
		}
	}
	$branch_array .= "}";
?>

<!-- DASHBOARD ==> ADMIN LOGIN -->
<?php 
if ($_SESSION['type'] == 'admin') {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Dashbord | TMS</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<link href="../bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
	<!-- <link rel="stylesheet" type="text/css" href="../font-awesome-5/css/fontawesome-all.min.css"> -->
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
	<!-- FONTAWESOME CDN FILE -->


	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.min.js"></script> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.0.0/cropper.js"></script>

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">

	<!-- DATATABLE PLUGIN -->
	<!-- G:\wamp64\www\TYproject\js\DataTables\datatables.min.js -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

	<!-- Datepicked ui -->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript" src="../bootstrap/jquery/jquery2.2.4.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />

	<!-- CALENDER -->
	<link href='../fullcalendar/assets/css/fullcalendar.css' rel='stylesheet' />
	<link href='../fullcalendar/assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
	<script src='../fullcalendar/assets/js/jquery-1.10.2.js' type="text/javascript"></script>
	<script src='../fullcalendar/assets/js/jquery-ui.custom.min.js' type="text/javascript"></script>
	<script src='../fullcalendar/assets/js/fullcalendar.js' type="text/javascript"></script>
	<!-- /CALENDER -->

	<?php
			// Script added by PHP
	echo '<script type="text/javascript">tution = "'.$_SESSION['tutionId'].'";</script>';
	echo '<script type="text/javascript">userType = "'.$_SESSION['type'].'";</script>';
	/*echo '<script type="text/javascript">admin = "'.$_SESSION['adminId'].'";</script>';*/
	echo'<script type="text/javascript"> branch_array = '.$branch_array.';</script>';
	echo'<script type="text/javascript"> course_array = '.$course_array.';</script>';
	?>

	<link rel="stylesheet" type="text/css" href="../css/dashbord.css">
	<script type="text/javascript" src="../js/add_tab.js"></script>
	<script type="text/javascript" src="../js/fetch_tms.js"></script>
	<script type="text/javascript" src="../js/fetch_location.js"></script>
	<script type="text/javascript" src="../js/sweetalert.min.js"></script>
	
	<link rel="stylesheet" href="../student/css/flaticon.css">
	<!-- <a class="navbar-brand" href="#" style="width: 149px;"><?php //echo $tution['name'];?></a> -->
	<style type="text/css">
		/* CALENDAR */
			#calendar-body {
				margin-top: 40px;
				text-align: center;
				font-size: 14px;
				font-family: "Helvetica Nueue",Arial,Verdana,sans-serif;
				background-color: #fff;
				}

			#wrap {
				width: 1100px;
				margin: 0 auto;
				}

			#external-events {
				float: left;
				width: 150px;
				padding: 0 10px;
				text-align: left;
				}

			#external-events h4 {
				font-size: 16px;
				margin-top: 0;
				padding-top: 1em;
				}

			.external-event { /* try to mimick the look of a real event */
				margin: 10px 0;
				padding: 2px 4px;
				background: #3366CC;
				color: #fff;
				font-size: .85em;
				cursor: pointer;
				}

			#external-events p {
				margin: 1.5em 0;
				font-size: 11px;
				color: #666;
				}

			#external-events p input {
				margin: 0;
				vertical-align: middle;
				}

			#calendar {
		/* 		float: right; */
		        margin: 0 auto;
				width: 900px;
				background-color: #FFFFFF;
				border-radius: 6px;
		        box-shadow: 0 1px 2px #C3C3C3;
			}


	</style>
	<script type="text/javascript">
		$(document).ready(function(){

				// NOTICE
			$('#btn_notice').click(function(){
				var data = $('#notice_form .input').serializeArray();
				
				var date = new Date();

				if (date.getMonth() < 10) {month = '0'+date.getMonth();}else{month = date.getMonth();}
				if (date.getDate() < 10) {day = '0'+date.getDate();}else{day = date.getDate();}
				var currentDate = date.getFullYear()+'-'+month+'-'+day;
				var currentTime = date.getHours()+':'+date.getMinutes()+':'+date.getSeconds();

				data.push({name:'func',value:'ins_notice'},{name:'tutionId',value:tution},{name:'date',value:currentDate},{name:'time',value:currentTime});
				console.log(data);
				$('#notice').html();
				$.ajax({
					url:'../processes/notice.process.php',
					method:'POST',
					data:data,
					success:function(data){
						//alert(data);
						if (data == 1){
							swal("Done","Notice Posted successfuly","success");
						}
						else if(data == 'empty'){
							swal("Hmm!","Notice Body is Empty!","warning");
						}
						else{
							swal("Error!","Message not sent. \n"+data,"error");
						}
					}
				});
			});

			// show Branch, Student and Staff pane
			$('.card').click(function(){
				var id = $(this).attr('rel');
				$('#'+id).click();
			});

			// Calendar--------------------------------------------------------------------------------------------
		    var date = new Date();
			var d = date.getDate();
			var m = date.getMonth();
			var y = date.getFullYear();

			/*  className colors
			className: default(transparent), important(red), chill(pink), success(green), info(blue)
			*/
			/* initialize the external events
			-----------------------------------------------------------------*/
			$('#external-events div.external-event').each(function() {

				// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
				// it doesn't need to have a start or end
				var eventObject = {
					title: $.trim($(this).text()) // use the element's text as the event title
				};

				// store the Event Object in the DOM element so we can get to it later
				$(this).data('eventObject', eventObject);

				// make the event draggable using jQuery UI
				$(this).draggable({
					zIndex: 999,
					revert: true,      // will cause the event to go back to its
					revertDuration: 0  //  original position after the drag
				});

			});

			/* initialize the calendar
			-----------------------------------------------------------------*/
			var calendar =  $('#calendar').fullCalendar({
				header: {
					left: 'title',
					center: 'agendaDay,agendaWeek,month',
					right: 'prev,next today'
				},
				editable: true,
				firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
				selectable: true,
				defaultView: 'month',

				axisFormat: 'h:mm',
				columnFormat: {
	                month: 'ddd',    // Mon
	                week: 'ddd d', // Mon 7
	                day: 'dddd M/d',  // Monday 9/7
	                agendaDay: 'dddd d'
	            },
	            titleFormat: {
	                month: 'MMMM yyyy', // September 2009
	                week: "MMMM yyyy", // September 2009
	                day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
	            },
				allDaySlot: false,
				selectHelper: true,
				select: function(start, end, allDay) {
					var title = prompt('Event Title:');
					if (title) {
						calendar.fullCalendar('renderEvent',
							{
								title: title,
								start: start,
								end: end,
								allDay: allDay
							},
							true // make the event "stick"
						);
					}
					calendar.fullCalendar('unselect');
				},
				droppable: true, // this allows things to be dropped onto the calendar !!!
				drop: function(date, allDay) { // this function is called when something is dropped

					// retrieve the dropped element's stored Event Object
					var originalEventObject = $(this).data('eventObject');

					// we need to copy it, so that multiple events don't have a reference to the same object
					var copiedEventObject = $.extend({}, originalEventObject);

					// assign it the date that was reported
					copiedEventObject.start = date;
					copiedEventObject.allDay = allDay;

					// render the event on the calendar
					// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
					$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

					// is the "remove after drop" checkbox checked?
					if ($('#drop-remove').is(':checked')) {
						// if so, remove the element from the "Draggable Events" list
						$(this).remove();
					}

				},

				events: [
					{
						title: 'Salary Calculation',
						start: new Date(y, m, 1)
					},
					/*{
						id: 999,
						title: 'Sci Test',
						start: new Date(y, m, d+3, 16, 0),
						allDay: false,
						className: 'info'
					},
					{
						id: 999,
						title: 'Final exam STD 8',
						start: new Date(21, 16, 0),
						allDay: false,
						className: 'important'
					},
					{
						id: 999,
						title: 'Repeating Event',
						start: new Date(y, m, d+4, 16, 0),
						allDay: false,
						className: 'info'
					},
					{
						title: 'Meeting',
						start: new Date(y, m, d, 10, 30),
						allDay: false,
						className: 'important'
					},
					{
						title: 'Lunch',
						start: new Date(y, m, d, 12, 0),
						end: new Date(y, m, d, 14, 0),
						allDay: false,
						className: 'important'
					},
					{
						title: 'Birthday Party',
						start: new Date(y, m, d+1, 19, 0),
						end: new Date(y, m, d+1, 22, 30),
						allDay: false,
					},
					{
						title: 'Click for Google',
						start: new Date(y, m, 28),
						end: new Date(y, m, 29),
						url: 'http://google.com/',
						className: 'success'
					}*/
				],
			});
			// \Calender--------------------------------------------------------------------------------------------


		});
	</script>
</head>
<body style="background-color: #ededed;">
	<header>
		<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
			<a class="navbar-brand text-center" href="#"><?php echo $tution['name'] ?></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
			</button>
			
	 		<div class="collapse navbar-collapse" id="navbarSupportedContent">
	 			<ul class="navbar-nav mr-auto">
	 			  <li class="nav-item">
	 				<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Welcome <?php echo$_SESSION['fname'].' '.$_SESSION['lname']; ?></a>
	 			  </li>
	 			</ul>
	 		</div>
	  	</nav> -->
	  	
	</header>

			  <section id="section">
			  	<div id="wrapper">

			  		<!-- SIDEBAR -->
			  		<div id="sidebar-wrapper" style="position: fixed;">
	  						
						<div class="row">
							<div class="col-md-12 text-center" id="brand" style="margin-top: 15px;">
								<img src="../images/tution/<?php echo $tution['logo'];?>" class="img-fluid rounded" alt=" "/>
								<?php echo $tution['name'];?>
							</div>
							<!-- <div class="col-md-12 text-center" id="brand-name">
							</div> -->
						</div>
	  						<hr style="border-color: #222; width: 90%;" />
	  					<ul class="sidebar-nav">
	  						<li><span rel="tab_home"><i class="fas fa-tachometer-alt"></i> Dashboard</span></li>
	  						<li><span rel="tab_branch" id="b"><i class="fa fa-building"></i> Manage Branch</span></li>
	  						<li><span rel="tab_stud" id="s"><i class="fa fa-graduation-cap"></i> Manage Students</span></li>
	  						<li><span rel="tab_staff" id="st"><i class="fa fa-users"></i> Manage Staff</span></li>
	  						<li><span rel="tab_expenses"><i class="fa fa-calculator"></i> Manage Expenses</span></li>
	  						<li><span rel="tab_attendence"><i class="fa fa-calendar"></i> Attendence</span></li>
	  						<li><span rel="tab_fees"><i class="fas fa-money-check"></i> Fees</span></li>
	  						<li><span rel="tab_salary"><i class="fas fa-money-check"></i> Salary</span></li>
	  						<li><span rel="tab_marks"><i class="flaticon-exam"></i> Marks</span></li>
	  						<li><span rel="tab_report"><i class=""></i> Report</span></li>
	  						<li><span rel="tab_profile"><i class="fa fa-user"></i> Profile</span></li>
	  						<li><span rel="tab_logout"><i class="fa fa-power-off"></i> Logout</span></li>
	  					</ul>
	  				</div>	
			  		<!-- SIDEBAR CLOSE -->
					
					

			  		<!-- PAGE CONTENT -->
			  		<div id="page-content-wrapper">
			  			<div class="container-fluid">
			  				
			  				<div class="row">
			  					<div class="col-md-5 offset-md-7 text-right" style="color: #ccc;font-size: 16px; position: relative;">
			  						<p style="margin: 0px;margin-bottom: 0px; /*position: absolute*/;">Welcome <?php echo $_SESSION['fname'].' '.$_SESSION['lname']; ?> (Admin)</p>
			  					</div>
			  				</div>

			  				 <!-- Tab Name -->
			  				<ul class="nav nav-tabs" id="tab-name-area" style="margin-top: 5px;">
			  					<li class="nav-item active" id="tab_home" rel="pane_home" onclick="activate_tab(this.id,this.rel);"><a class="nav-link"> Dashboard </a></li>
			  				</ul>
			  				<!-- /Tab Name -->

			  				<div class="tab-content" style="margin-top: 0px;">

			  					<!-- PANE_HOME -->
			  					<div class="tab-pane active" id="pane_home">
			  						<div class="panel panel-default" style="border-top: 0px; padding: 5px;">

			  							<!-- PANEL-BODY -->
			  							<div class="panel-body">
			  								<br/>
			  								<div class="row">
			  									<div class="col-md-4 col-sm-12 col-xs-12">
			  										<div class="card alert-primary" rel="b" style="overflow: hidden;height: 103px;">
			  											<div class="card-title">
			  												<small>Total</small><br/>Branch
			  											</div>
				  										<div class="card-body">
				  											<?php echo $totbranches['totBranch']; ?>
				  										</div>
			  										</div>
			  									</div>
			  									<div class="col-md-4 col-sm-12 col-xs-12">
			  										<div class="card alert-success" rel="st" style="overflow: hidden;height: 103px;">
			  											<div class="card-title">
			  												<small>Total</small><br/>Staff
			  											</div>
				  										<div class="card-body">
				  											<?php echo $totstaffs['totStaff']; ?>
				  										</div>
			  										</div>
			  									</div>
			  									<div class="col-md-4 col-sm-12 col-xs-12">
			  										<div class="card alert-info" rel="s" style="overflow: hidden;height: 103px;">
			  											<div class="card-title">
			  												<small>Total</small><br/>Students
			  											</div>
				  										<div class="card-body">
				  											<?php echo $totstudents['totStudent']; ?>
				  										</div>
			  										</div>
			  									</div>
			  								</div>
			  									<br/>
												<br/>
												<hr>
												<br/>
			  								<div class="row" style="margin-top: 50px;">
			  									<div class="col-md-12">
			  										<div id="yearly_income_container">
			  											<canvas id="yearly_income" style="height: 300px;width: 100%"></canvas>
			  										</div>
			  										<span class="lead text-center d-block" style="margin: 10px;">Income Vs. Expense</span>
			  									</div>
			  								</div>
												<br/>
												<br/>
												<hr>
												<br/>
			  								<div class="row">
				  								<div class="col-md-12">
				  									<div class="lead d-block text-center" style="margin: 10px;">
				  										Notice Board
				  									</div>
			  										<form name="notice_form" id="notice_form" method="POST">
			  											<div class="row">
			  												<div class="col-md-12">
			  													<input type="text" name="notice_head" id="notice_head" class="input form-control" style="width: 100%;height: 50px;border: 1px solid #ccc; font-size: 1.5rem;padding: 10px;" placeholder="Notice Title" />
			  													<textarea id="notice_body" style="width: 100%;height: 200px; border: 1px solid #ccc;border-top: 0; border-radius: 0 0 5px 5px;padding: 10px;box-shadow: 0px 1px 8px 1px #cde;" class="input" name="notice_body" placeholder="Notice Body"></textarea>
			  												</div>
			  											</div>
				  										<div class="row">
				  											<div class="col-md-4">
				  												<label><input type="radio" class="input" name="recepient" value="staff" /> To staff</label>
				  											</div>
				  											<div class="col-md-4">
				  												<label><input type="radio" class="input" name="recepient" value="student" /> To Students</label>
				  											</div>
				  											<div class="col-md-4">
				  												<label><input type="radio" class="input" name="recepient" value="all" checked /> To All</label>
				  											</div>
				  										</div>
				  										<div class="row">
				  											<div class="col-md-12 text-right col-sm-12 col-xs-12">
				  												<button id="btn_reset" class="btn btn-outline-danger" type="reset">Clear</button>
				  												<button id="btn_notice" class="btn btn-outline-primary" type="button">Send</button>
				  											</div>
				  										</div>
				  									</form>
				  								</div>
			  								</div>
											<br/>
											<br/>
											<hr>
											<br/>
			  								<div class="row" id="calendar-body">
			  									<div class="col-md-12">
			  										<div id='calendar'></div>
			  									</div>
			  								</div>

			  							</div>	<!-- PANEL-BODY CLOSE -->

			  						</div>
			  					</div>	<!-- TAB-PAN-HOME CLOSE-->


			  					<!-- DYNAMIC TAB -->
									<!-- <div class="tab-pane active" id="pane_fees">
										<div class="panel panel-default" style="border-top: 0px; padding: 5px;">
									
											PANEL-BODY
											<div class="panel-body">
									
												<div class="row">
													<div class="col-md-12">
														<p class="display-4">Add Fees</p>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<form id="fees_form">
															<table class="table">
																<thead>
																	<tr>
																		<th>Branch</th>
																		<th>Student</th>
																		<th>Date</th>
																		<th>Remaining Fees</th>
																		<th>Amount</th>
																		<th>Save</th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td>
																			Branch selector
																			<select id="form_branch-fees" name="branchId" class="input" tabindex="1" autofocus></select>
																		</td>
																		<td>
																			Student selector
																			<select id="form_student-fees" name="studentId" class="input" tabindex="2">
																				<option disabled selected>Select Branch First</option>
																			</select>
																		</td>
																		<td><input type="text" id="fees_date" class="input" name="fees_date" tabindex="3" /></td>
																		<td><input type="text" name="totFees" id="totFees" disabled tabindex="-1" style="background-color: #fff;"></td>
																		<td><input type="text" id="fees_amount" class="input" name="fees_amount" tabindex="4"></td>
																		<td><button type="button" name="save_fees" id="save_fees" class="btn btn-sm btn-outline-primary" style="height: 20px;width: 37px; position: relative;"><span class="fa fa-check" style="position: absolute;top: 2px;left: 10px;"></span></button></td>
																	</tr>
																</tbody>
															</table>
														</form>
													</div>
												</div>
									
												<div class="row">
													<div class="col-md-12">
														<h1 class="display-4" style="margin-top: 25px; border-top: 1px solid #ccc;">Last 5 Fees</h1>
														<table class="table table-bodered" id="table">
															<thead>
																<tr>
																	<th>Date</th>
																	<th>Name</th>
																	<th>Branch</th>
																	<th>Amount Paid</th>
																	<th>Total Fees</th>
																</tr>
															</thead>
															<tbody id="fees_data_field"></tbody>
														</table>
													</div>
												</div>
									
												<div class="row"> <div class="col-md-12"> <button type="button" class="btn btn-secondary" onclick="window.open('../reports/fees.report.php','_blank','height=650,width=1300,toolbar=no,left=0');">View Report &#8680;</button> </div> </div>
											</div>
											<span><script type="text/javascript" src="../js/tms_fees.js"></script></span>
										</div>
									</div> -->
			  					<!-- DYNAMIC TAB CLOSE -->


			  				</div>	<!-- TAB-CONTENT CLOSE -->
							
							<!-- FOOTER -->
							<hr>
							<br/>
							<br/>
							<br/>
							<div id="footer-wrapper">
								<div class="row">
									<div class="col-md-3 mr-auto" style="padding-left: 75px;">
										<h3>Promote With TMS</h3>
										<p>Promote your tution classes on our Home Page.</p>
										<p><a href="promote.php" class="btn btn-outline-info">Promote</a></p>
									</div>
									<div class="col-md-3" style="padding-left: 75px;">
										<h3>Quick Links</h3>
										<ul>
											<li><a href="../index.php" target="_blank">Home</a></li>
											<li><a href="../aboutus.php" target="_blank">About Us</a></li>
											<li><a href="../contact.php" target="_blank">Contact us</a></li>
											<li><a href="../contact.php" target="_blank">Help</a></li>
										</ul>
									</div>
									<div class="col-md-3" style="padding-left: 75px;">
										<h3>Have a Question?</h3>
										<ul>
											<li class="contact-info"><i class="fa fa-map-marker"></i>Surat | Gujarat</li>
											<li class="contact-info"><i class="fa fa-phone"></i>+91 704-305-6077</li>
											<li class="contact-info"><i class="fa fa-envelope"></i>tms@gmail.com</li>
										</ul>
									</div>
									<div class="col-md-3 float-right" style="padding-left: 75px;">
										<p><span class="fas fa-arrow-up" style="font-size: 16px; color: darkgray;"></span><a href="#" style="color: darkgray; font-size: 15px;"> Back to top</a></p>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<ul class="social-media-list">
											<li class="bg-info">
												<a class="contact-icon" href="#"><i class="fab fa-facebook-f"></i></a>
											</li>
											<li class="bg-info">
												<a class="contact-icon" href="#"><i class="fab fa-twitter"></i></a>
											</li>
											<li class="bg-info">
												<a class="contact-icon" href="#"><i class="fab fa-instagram"></i></a>
											</li>
											<li class="bg-info">
												<a class="contact-icon" href="#"><i class="fab fa-google-plus-g"></i></a>
											</li>
										</ul>
									</div>
								</div>
								<div class="row">
									<div class="col-md-2 offset-md-5 text-center">
										<p>
											<small class="block" style="color: darkgray;">&copy;2019 | All Rights Reserved</small>
											<small class="block" style="color: darkgray;">Powered by TMS.com</small>
										</p>
									</div>
								</div>
							</div>
							<!-- \FOOTER -->

			  			</div>	<!-- CONTAINER-FLUID CLOSE -->
			  		</div>	<!-- PAGE CONTENT CLOSE-->
			  	</div>
			  </section>

			  <!--footer-->

			<!-- <div >
			<footer id="fh5co-footer" class="fh5co-bg" role="contentinfo" style="margin-top: 1500px;">
			  <div class="overlay"></div>
			  <div class="container">
			    <div class="row row-pb-md">
			      <div class="col-md-4 fh5co-widget">
			        <h3>TMS </h3>
			        <p style="color: darkgrey;">Join TMS to manage the details profesionally</p>
			        <p><a class="btn btn-info" href="regi_form.php">Sign Up</a></p>
			      </div>
			      <div class="col-md-8">
			        <div class="row" >
			          <div class="col-md-4 col-sm-4 col-xs-6">
			            <h3>Quick Links</h3>
			            <ul class="fh5co-footer-links">
			              <li><a href="index.php">Home</a></li>
			              <li><a href="aboutus.php">About Us</a></li>
			              <li><a href="contact.php">Contact Us</a></li>
			              <li><a href="#">Help</a></li>
			            </ul>
			          </div>


			          <div class="col-md-4 col-sm-4 col-xs-6">
			            <h3>Have A Question?</h3>
			            <ul class="fh5co-footer-links">
			              <li>
			                <a href="#"><span class="fa fa-map-marker fa-1x"></span>
			                  <span class="text">  &nbsp; &nbsp; Surat | Gujarat</span>
			                </a>
			              </li>
			              <li>
			                <a href="#"><span class="fa fa-phone fa-1x"></span>
			                  <span class="text">&nbsp; &nbsp;+91 704-305-6077</span>
			                </a>
			              </li>
			              <li>
			                <a href="#">
			                  <span class="fa fa-envelope fa-1x"></span>
			                  <span class="text">&nbsp; &nbsp;tms@gmail.com</span>
			                </a>
			              </li>
			            </ul>
			          </div>

			          <div class="col-md-4 col-sm-4 col-xs-6">
			            <p class="float-right" ><span class=" fas fa-arrow-up" style="font-size: 20px; color: darkgrey;"></span><a href="#" style="color: darkgrey; font-size: 20px; ">&nbsp; Back to top</a></p>
			          </div>  
			        </div>
			      </div>
			    </div>

			    <div class="row">
			      <div class="col-md-12 text-center">
			        <p>
			          <ul class="social-media-list">
			            <li class="bg-info">
			              <a href="#" target="_blank" class="contact-icon">
			                <i class="fab fa-facebook-f" aria-hidden="true"></i>
			              </a>
			            </li>
			            <li class="bg-info">
			              <a href="#" target="_blank" class="contact-icon">
			                <i class="fab fa-twitter" aria-hidden="true"></i>
			              </a>
			            </li>
			            <li class="bg-info">
			              <a href="#" target="_blank" class="contact-icon">
			                <i class="fab fa-instagram" aria-hidden="true"></i>
			              </a>
			            </li>
			            <li class="bg-info">  
			              <a href="#" target="_blank" class="contact-icon">
			                <i class="fab fa-google-plus-g" aria-hidden="true"></i>
			              </a>
			            </li>
			          </ul>
			        </p>
			      </div>
			    </div>

			    <div class="row copyright">
			      <div class="col-md-12 text-center">
			        <p>
			          <small class="block" style="color: darkgrey;">&copy; 2019 | All Rights Reserved.</small> 
			          <small class="block" style="color: darkgrey;">Powered by  TMS.com</small>
			        </p>
			      </div>
			    </div>
			  </div>
			</footer>
			</div> -->
			<!--/footer--> 
			  

			  <!-- <script type="text/javascript" src="../js/jquery_ui/jquery-ui.min.js"></script> -->
			  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
			  <!-- <script type="text/javascript" src="../js/Chart_js/dist/Chart.min.js"></script> -->
			  <script type="text/javascript" src="../js/reports.js"></script>
			  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

			  <!-- <link rel="stylesheet" type="text/css" href="../js/jquery-ui.css"> -->
			  <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

			  <script type="text/javascript">
		var removed_li; //	"id" of nav-item which is removed
		var n=1; // count number of branch increment | decrement "id"
		/* function to add New Branch in pane_branch */
		function add_branch(){
			n=n+1;
			bid ='branch'+n;
			data = '<tr id="newbranch'+n+'"><td><span class="badge" id="cont'+n+'" style="margin-top: 0px; margin-left: 0px; background: transparent; color:#000; font-size: 15px;">'+n+'.</span></td><td><input type="text" name="b_address[]" class="b_address input" id="b'+n+'_address" placeholder="Shop no. / Area" value=" "><span class="text-danger b_address_error" id="error-b'+n+'_address"></span></td><td><select name="b_state[]" id="b'+n+'_state" class="b_state input" onchange="fetchCities(this.value,\'b'+n+'_city\');"><option disabled selected value="0">State</option><?php foreach ($result as $r){echo '<option value="'.$r['stateID'].'" style="color:#111;">'.$r['stateName'].'</option>';}?></select><span class="text-danger" id="error-b'+n+'_state"></span></td><td><select id="b'+n+'_city" name="b_city[]" class="b_city input" style="border: 1px solid #ddd; width: 200px;"><option disabled selected>City</option></select><span class="text-danger" id="error-b'+n+'_city"></span></td><td><input type="text" name="b_phn[]" class="b_phn input" placeholder="Phone No." value=" "><span class="text-danger b_phn_error" id="error-b'+n+'_phn"> </span></td><td><button type="button" class="btn btn-danger btn-xs remove" onclick="remove_tr(\'newbranch'+n+'\');"><span class="glyphicon glyphicon-remove"></span></button></td></tr>';
			//alert(data);
			$('#new_branch_data').append(data);
			$('#'+n+'cont').html(n);
		}
		//---------------------------------------------------------

		// FUNCTION to Activate Tabs by cliking on them	: tab_branch, tab_stud, tab_staff, tab_report, tab_settings, tab_logout
		function activate_tab(tab_id,tab_rel){

				if (tab_id == removed_li){return;}	// If the TAB is ALREADY REMOVED

					// INACTIVE CURRENT "active" TAB ; "active" CLICKED TAB
					$('.nav-item.active').removeClass('active');
					$('#'+tab_id).addClass('active');

					// INACTIVE CURRENT "active" PANE ; "active" PANE OF CLICKED TAB
					$('.tab-pane.active').removeClass('active');
					
					$tab_pane = $('.nav-item.active').attr('rel');
					$('#'+$tab_pane).addClass('active');
				}
		//----------------------------------------------------------

		// FUNCTION to Remove Tab and Pane
		function tab_remove(rel){
				$nav_li = $('#'+rel);	// (Object)Tab to remove
				$pane = $('#'+$nav_li.attr('rel'));	// (Object)Pane to remove

				removed_li = rel;

					// if the "removed" pane is not currently "active"
					if (rel != $('.nav-item.active').attr('id')){
						$nav_li.remove();
						$pane.remove();
					}
				else 	// if the "removed" pane is currently "active"
				{
					$nav_li.prev().addClass('active');
					$nav_li.remove();

					$pane.prev().addClass('active');
					$pane.remove();
				}

				return;
			}
		//----------------------------------------------------------

		// FUNCTION to Remove new added tr
		function remove_tr(ele,pane){
			var tr = '#'+ele;
				//alert('removing '+tr);
				console.log(tr);
				$(tr).remove();

				if (pane == 'branch') {
					//alert('remove branch');
					n=n-1;
					$('#cont').attr('value',n);
					update_cont();
				}
				else if(pane == 'student'){
					//alert('remove student');
					sn=sn-1;
					update_cont_student();
				}
				else if(pane == 'staff'){
					//alert('remove staff');
					staff_n=staff_n-1;
					update_cont_staff();
				}
			}
		//----------------------------------------------------------

		// function to update tr number in PANE_BRANCH
		function update_cont(){
			i=1;
			$('.badge').each(function(){
				$(this).html(i);
				i=i+1;
			});

			i=1;
			$('.b_address').each(function(){
				value = 'b'+i+'_address';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.b_address_error').each(function(){
				value = 'error-b'+i+'_address';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.b_state').each(function(){
				value = 'b'+i+'_state';
				city = 'b'+i+'_city';
				$(this).attr({'id':value,'onchange':'fetchCities(this.value,\''+city+'\');'});
				i=i+1;
			});

			i=1;
			$('.b_state_error').each(function(){
				value = 'error-b'+i+'_state';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.b_city').each(function(){
				value = 'b'+i+'_city';
				$(this).attr('id',value);
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
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.b_phn_error').each(function(){
				value = 'error-b'+i+'_phn';
				$(this).attr('id',value);
				i=i+1;
			});
		}
		//----------------------------------------------------------

		// function to add New Student in PANE_STUDENT
		var sn = 0;
		function add_student(){
				//alert('add_student()');
				sn=sn+1;
				data = '<tr id="newstudent'+sn+'"><td><span class="s_badge" id="s_cont'+sn+'" style="margin-top: 0px; margin-left: 0px; background: transparent; color:#000; font-size: 15px;">'+sn+'.</span></td><td><select class="input s_std" id="s'+sn+'_std" name="s_std[]"><option selected disabled value="0">STD</option><?php $courses = preg_split("/:/",$tution['course']);$in = "IN (";foreach ($courses as $course) {if ($in == 'IN ('){$in .= "'$course'";}else{$in .= ",'$course'";}}$in .= ")";$q = "SELECT * FROM tbl_course WHERE short_name ".$in;$conn = connection('tms');$courses = mysqli_query($conn, $q);mysqli_close($conn);foreach ($courses as $course){echo'<option value="'.$course['short_name'].'"> '.$course['name'].'</option>';}?></select><span class="text-danger s_std_error" id="error-s'+sn+'_std"></span></td><td><select name="s_branch[]" id="s'+sn+'_branch " class="s_branch input"><option disabled selected value="0">Branch</option><?php foreach ($branches as $branch){echo '<option value="'.$branch['branchId'].'" style="color:#111;">'.$branch['address'].'</option>';}?></select><span class="text-danger" id="error-s'+sn+'_branch"></span></td><td><input type="text" name="s_name[]" class="input s_name" id="s'+sn+'_name" /><span class="text-danger s_name_error" id="error-s'+sn+'_name"></span></td><td><input type="text" name="s_father_name[]" class="s_father_name input" id="s'+sn+'_father_name"><span class="text-danger s_father_name_error" id="error-s'+sn+'_father_name"></span></td><td><select name="s_sex[]" id="s'+sn+'_sex" class="s_sex input"><option disabled selected>Gender</option><option value="male">Male</option><option value="female">Female</option></select><span class="text-danger s_sex_error" id="error-s'+sn+'_sex"></span></td><td><input type="text" name="s_phn[]" class="s_phn input" id="s'+sn+'_phn"/><span class="text-danger s_phn_error" id="error-s'+sn+'_phn"></span></td><td><input type="text" name="s_email[]" class="s_email input" id="s'+sn+'_email" /><span class="text-danger s_email_error" id="error-s'+sn+'_email"></span></td><td><input type="text" name="s_total_fees[]" class="s_total_fees input" id="s'+sn+'_total_fees" /><span class="text-danger s_total_fees_error" id="error-s'+sn+'_total_fees"> </span></td><td><input type="text" name="s_fees_paid[]" class="s_fees_paid input" id="s'+sn+'_fees_paid" value="00.00"/><span class="text-danger s_fees_paid_error" id="error-s'+sn+'_fees_paid"> </span></td><td><button type="button" class="btn btn-outline-danger  remove" onclick="remove_tr(\'newstudent'+sn+'\',\'student\');"><span class="glyphicon glyphicon-remove"></span></button></td></tr>';
					//alert(data);
					$('#tbl_ins_student_data').append(data);
					$('#s_cont'+sn).html(sn);
					$('#s'+sn+'_std').focus();
					console.log('#s'+sn+'_std');
				}
		//---------------------------------------------------------

		// function to update "id" of newly created input elements in PANE_STUDENT
		function update_cont_student(){
			i=1;
			$('.s_badge').each(function(){
				$(this).html(i);
				i=i+1;
			});

			i=1;
			$('.s_std').each(function(){
				value = 's'+i+'_std';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_std_error').each(function(){
				value = 'error-s'+i+'_std';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_branch').each(function(){
				value = 's'+i+'_branch';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_branch_error').each(function(){
				value = 'error-s'+i+'_branch';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_name').each(function(){
				value = 's'+i+'_name';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_name_error').each(function(){
				value = 'error-s'+i+'_name';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_father_name').each(function(){
				value = 's'+i+'_father_name';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_father_name_error').each(function(){
				value = 'error-s'+i+'_father_name';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_sex').each(function(){
				value = 's'+i+'_sex';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_sex_error').each(function(){
				value = 'error-s'+i+'_sex';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_phn').each(function(){
				value = 's'+i+'_phn';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_phn_error').each(function(){
				value = 'error-s'+i+'_phn';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_email').each(function(){
				value = 's'+i+'_email';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_email_error').each(function(){
				value = 'error-s'+i+'_email';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_total_fees').each(function(){
				value = 's'+i+'_total_fees';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_total_fees_error').each(function(){
				value = 'error-s'+i+'_total_fees';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_fees_paid').each(function(){
				value = 's'+i+'_fees_paid';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_fees_paid_error').each(function(){
				value = 'error-s'+i+'_fees_paid';
				$(this).attr('id',value);
				i=i+1;
			});
		}
		//---------------------------------------------------------

		// function to add New Student in PANE_STUDENT
		var expn = 0;
		function add_expenses(){
				//alert('add_expenses()');
				expn=expn+1;
				data = '<tr id="newexpenses'+expn+'"> <td> <span class="exp_badge" id="exp_cont'+expn+'" style="margin-top: 0px; margin-left: 0px; background: transparent; color:#000; font-size: 15px;">'+expn+'.</span> </td> <td> <select name="exp_branch[]" id="exp'+expn+'_branch " class="exp_branch input"> <option disabled selected value="0">Branch</option> <?php foreach ($branches as $branch){echo '<option value="'.$branch['branchId'].'" style="color:#111;">'.$branch['address'].'</option>';}?> </select> <span class="text-danger" id="error-exp'+expn+'_branch"></span> </td> <td> <input type="text" name="exp_name[]" class="input exp_name" id="exp'+expn+'_name" required /> <span class="text-danger exp_name_error" id="error-exp'+expn+'_name"></span> </td> <td> <input type="text" name="exp_amt[]" class="exp_amt input" id="exp'+expn+'_amt" placeholder="00.00" required/> <span class="text-danger exp_amt_error" id="error-exp'+expn+'_amt"></span> </td> <td> <input type="text" name="exp_remark[]" class="exp_remark input" id="exp'+expn+'_remark" /> <span class="text-danger exp_remark_error" id="error-exp'+expn+'_remark"></span> </td> <td> <button type="button" class="btn btn-outline-danger remove" onclick="remove_tr(\'newexpenses'+expn+'\',\'expenses\');"> <span class="glyphicon glyphicon-remove"></span></button> </td> </tr>'; 
				//alert(data);
					$('#tbl_ins_expenses_data').append(data);
					$('#exp_cont'+expn).html(expn);
					$('#exp'+expn+'_std').focus();
					console.log('#exp'+expn+'_branch');
				}
		//---------------------------------------------------------

		// function to update "id" of newly created input elements in PANE_STUDENT
		function update_cont_expenses(){
			i=1;
			$('.exp_badge').each(function(){
				$(this).html(i);
				i=i+1;
			});

			i=1;
			$('.exp_branch').each(function(){
				value = 'exp'+i+'_branch';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.exp_branch_error').each(function(){
				value = 'error-exp'+i+'_branch';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.exp_name').each(function(){
				value = 'exp'+i+'_name';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.exp_name_error').each(function(){
				value = 'error-exp'+i+'_name';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.exp_amt').each(function(){
				value = 'exp'+i+'_amt';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.exp_amt_error').each(function(){
				value = 'error-exp'+i+'_amt';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.exp_remark').each(function(){
				value = 'exp'+i+'_remark';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.exp_remark_error').each(function(){
				value = 'error-exp'+i+'_remark';
				$(this).attr('id',value);
				i=i+1;
			});
		}
		//---------------------------------------------------------

		// function to add new Staff in PANE_STAFF
		var staff_n = 0;
		function add_staff(){
				//alert('add_staff()');
				staff_n=staff_n+1;
				data = '<tr id="newstaff'+staff_n+'"><td><span class="staff_badge" id="staff_cont'+staff_n+'" style="margin-top: 0px; margin-left: 0px; background: transparent; color:#000; font-size: 15px;">'+staff_n+'.</span></td><td><select name="staff_type[]" id="staff'+staff_n+'_type" class="staff_type input"> <option selected value="Normal">Normal</option> <option value="Head">Head</option> </select></td><td><select name="staff_branch[]" id="staff'+staff_n+'_branch" class="staff_branch input"><option disabled selected value="0">Branch</option><?php foreach ($branches as $branch){echo '<option value="'.$branch['branchId'].'" style="color:#111;">'.$branch['address'].'</option>';}?></select><span class="text-danger" id="error-staff'+staff_n+'_branch"></span></td><td><input type="text" name="staff_name[]" class="staff_name input" id="staff'+staff_n+'_name" /><span class="text-danger staff_name_error" id="error-staff'+staff_n+'_name"></span></td><td><input type="text" name="staff_middle_name[]" class="staff_middle_name input" id="staff'+staff_n+'_middle_name"><span class="text-danger staff_middle_name_error" id="error-staff'+staff_n+'_middle_name"></span></td><td><select name="staff_sex[]" id="staff'+staff_n+'_sex" class="staff_sex input"><option disabled selected>Gender</option><option value="male">Male</option><option value="female">Female</option></select><span class="text-danger staff_sex_error" id="error-staff'+staff_n+'_sex"></span></td><td><input type="text" name="staff_phn[]" class="staff_phn input" id="staff'+staff_n+'_phn"/><span class="text-danger staff_phn_error" id="error-staff'+staff_n+'_phn"></span></td><td><input type="text" name="staff_email[]" class="staff_email input" id="staff'+staff_n+'_email" /><span class="text-danger staff_email_error" id="error-staff'+staff_n+'_email"></span></td><td><input type="text" name="staff_qualification[]" class="input staff_qualification" id="staff'+staff_n+'_qualification" placeholder="eg. BCA,MCA,..." /><span class="text-danger staff_qualification_error" id="error-staff'+staff_n+'_qualification"></span> </td><td><input type="text" name="staff_total_salary[]" class="staff_total_salary input" id="staff'+staff_n+'_total_salary" /><span class="text-danger staff_total_salary_error" id="error-staff'+staff_n+'_total_salary"></span></td><td><input type="text" name="staff_salary_paid[]" class="staff_salary_paid input" id="staff'+staff_n+'_salary_paid" value="00.00"/><span class="text-danger staff_salary_paid_error" id="error-staff'+staff_n+'_salary_paid"> </span></td><td><input type="date" name="staff_doj[]" class="staff_doj input" id="staff'+staff_n+'_doj"/><span class="text-danger staff_doj" id="error-staff'+staff_n+'_doj"> </span></td><td><button type="button" class="btn btn-outline-danger  remove" onclick="remove_tr(\'newstaff'+staff_n+'\',\'staff\');"><span class="glyphicon glyphicon-remove"></span></button></td></tr>'; //alert(data);

				$('#tbl_ins_staff_data').append(data);
				$('#staff_cont'+staff_n).html(staff_n);
				// console.log('#staff'+staff_n+'_branch');

					$('#staff'+staff_n+'_branch').focus();	// Focus on branch
				}
		//---------------------------------------------------------

		// function to update "id" of newly created input elements in PANE_STAFF
		function update_cont_staff(){
			i=1;
			$('.staff_badge').each(function(){
				$(this).html(i);
				i=i+1;
			});

			i=1;
			$('.staff_std').each(function(){
				value = 'staff'+i+'_std';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_std_error').each(function(){
				value = 'error-staff'+i+'_std';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_branch').each(function(){
				value = 'staff'+i+'_branch';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_branch_error').each(function(){
				value = 'error-staff'+i+'_branch';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_name').each(function(){
				value = 'staff'+i+'_name';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_name_error').each(function(){
				value = 'error-staff'+i+'_name';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_middle_name').each(function(){
				value = 'staff'+i+'_middle_name';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_middle_name_error').each(function(){
				value = 'error-staff'+i+'_middle_name';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_sex').each(function(){
				value = 'staff'+i+'_sex';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_sex_error').each(function(){
				value = 'error-staff'+i+'_sex';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_phn').each(function(){
				value = 'staff'+i+'_phn';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_phn_error').each(function(){
				value = 'error-staff'+i+'_phn';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_email').each(function(){
				value = 'staff'+i+'_email';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_email_error').each(function(){
				value = 'error-staff'+i+'_email';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_total_salary').each(function(){
				value = 'staff'+i+'_total_salary';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_total_salary_error').each(function(){
				value = 'error-staff'+i+'_total_salary';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_salary_paid').each(function(){
				value = 'staff'+i+'_salary_paid';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_salary_paid_error').each(function(){
				value = 'error-staff'+i+'_salary_paid';
				$(this).attr('id',value);
				i=i+1;
			});
		}
		//---------------------------------------------------------

	</script>
</body>
</html>





<!-- ============================================================================================================ -->
<!-- ============================================================================================================ -->
<!-- ============================================================================================================ -->
<!-- ============================================================================================================ -->
<!-- ============================================================================================================ -->




<!-- DASHBOARD ==> STAFF LOGIN -->
<?php
} 
elseif ($_SESSION['type'] == 'staff') {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Staff | TMS</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<link href="../bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
	<!-- <link rel="stylesheet" type="text/css" href="../font-awesome-5/css/fontawesome-all.min.css"> -->
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"><!-- FONTAWESOME CDN FILE -->


	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.min.js"></script> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.0.0/cropper.js"></script>

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">

	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript" src="../bootstrap/jquery/jquery2.2.4.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />

	<!-- CALENDER -->
	<link href='../fullcalendar/assets/css/fullcalendar.css' rel='stylesheet' />
	<link href='../fullcalendar/assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
	<script src='../fullcalendar/assets/js/jquery-1.10.2.js' type="text/javascript"></script>
	<script src='../fullcalendar/assets/js/jquery-ui.custom.min.js' type="text/javascript"></script>
	<script src='../fullcalendar/assets/js/fullcalendar.js' type="text/javascript"></script>
	<!-- /CALENDER -->

	<link rel="stylesheet" href="../student/css/flaticon.css">
	<?php
			// Script added by PHP
	echo '<script type="text/javascript">tution = "'.$_SESSION['tutionId'].'";</script>';
	echo '<script type="text/javascript">userType = "'.$_SESSION['staffId'].'";</script>';
	/*echo '<script type="text/javascript">admin = "'.$_SESSION['adminId'].'";</script>';*/
	echo'<script type="text/javascript"> branch_array = '.$branch_array.';</script>';
	echo'<script type="text/javascript"> course_array = '.$course_array.';</script>';

		$date = date("m");
		$conn = connection('tms');
		$q = "SELECT COUNT(*) AS totPresent FROM `tbl_attendence` WHERE Id LIKE '".$_SESSION['staffId']."' AND `date` LIKE '%-".$date."-%'";
		$totPresent = mysqli_fetch_array(mysqli_query($conn, $q));
		mysqli_close($conn);
	
	?>

	<link rel="stylesheet" type="text/css" href="../css/dashbord.css">
	<script type="text/javascript" src="../js/add_tab.js"></script>
	<script type="text/javascript" src="../js/fetch_tms.js"></script>
	<script type="text/javascript" src="../js/fetch_location.js"></script>
	<script type="text/javascript" src="../js/sweetalert.min.js"></script>
	<script type="text/javascript" src="../js/Chart_js/dist/Chart.min.js"></script>
	<!-- <script type="text/javascript" src="../js/reports.js"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
	<!-- <a class="navbar-brand" href="#" style="width: 149px;"><?php //echo $tution['name'];?></a> -->
	<style type="text/css">
		#btn_branch_selector-att{
			display: none !important;
		}
		#pane_attendence #student_data #data_row .col-md-2.text-left,#pane_marks #student_data #data_row .col-md-2.text-left{
			display: none;
		}
		.btn-group{
			display: none;
		}
	</style>
	<script type="text/javascript">
		function fetchNotice(){
			var data = ({'func':'fetch_notice','tutionId':tution,'type':'staff'});
			console.log(data);
			$.ajax({
				url:'../processes/notice.process.php',
				method:'POST',
				data:data,
				success:function(data){
					if (data != 0){
						$('#notice_board').html(data);
					}
					else{
						$('#notice_board').html('<h4 class="alert-heading">Nothing!</h4> <p>No message yet.</p>');
					}
				}
			});
		}
		$(document).ready(function(){
			
			$('#notice_board').ready(function(){
				fetchNotice();
			});

			setInterval(fetchNotice,5000);


		// Calendar--------------------------------------------------------------------------------------------
		    var date = new Date();
			var d = date.getDate();
			var m = date.getMonth();
			var y = date.getFullYear();

			/*  className colors
			className: default(transparent), important(red), chill(pink), success(green), info(blue)
			*/
			/* initialize the external events
			-----------------------------------------------------------------*/
			$('#external-events div.external-event').each(function() {

				// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
				// it doesn't need to have a start or end
				var eventObject = {
					title: $.trim($(this).text()) // use the element's text as the event title
				};

				// store the Event Object in the DOM element so we can get to it later
				$(this).data('eventObject', eventObject);

				// make the event draggable using jQuery UI
				$(this).draggable({
					zIndex: 999,
					revert: true,      // will cause the event to go back to its
					revertDuration: 0  //  original position after the drag
				});

			});

			/* initialize the calendar
			-----------------------------------------------------------------*/
			var calendar =  $('#calendar').fullCalendar({
				header: {
					left: 'title',
					center: 'agendaDay,agendaWeek,month',
					right: 'prev,next today'
				},
				editable: true,
				firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
				selectable: true,
				defaultView: 'month',

				axisFormat: 'h:mm',
				columnFormat: {
	                month: 'ddd',    // Mon
	                week: 'ddd d', // Mon 7
	                day: 'dddd M/d',  // Monday 9/7
	                agendaDay: 'dddd d'
	            },
	            titleFormat: {
	                month: 'MMMM yyyy', // September 2009
	                week: "MMMM yyyy", // September 2009
	                day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
	            },
				allDaySlot: false,
				selectHelper: true,
				select: function(start, end, allDay) {
					var title = prompt('Event Title:');
					if (title) {
						calendar.fullCalendar('renderEvent',
							{
								title: title,
								start: start,
								end: end,
								allDay: allDay
							},
							true // make the event "stick"
						);
					}
					calendar.fullCalendar('unselect');
				},
				droppable: true, // this allows things to be dropped onto the calendar !!!
				drop: function(date, allDay) { // this function is called when something is dropped

					// retrieve the dropped element's stored Event Object
					var originalEventObject = $(this).data('eventObject');

					// we need to copy it, so that multiple events don't have a reference to the same object
					var copiedEventObject = $.extend({}, originalEventObject);

					// assign it the date that was reported
					copiedEventObject.start = date;
					copiedEventObject.allDay = allDay;

					// render the event on the calendar
					// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
					$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

					// is the "remove after drop" checkbox checked?
					if ($('#drop-remove').is(':checked')) {
						// if so, remove the element from the "Draggable Events" list
						$(this).remove();
					}

				},

				events: [
					/*{
						title: 'Salary Calculation',
						start: new Date(y, m, 1)
					},
					{
						id: 999,
						title: 'Sci Test',
						start: new Date(y, m, d+3, 16, 0),
						allDay: false,
						className: 'info'
					},
					{
						id: 999,
						title: 'Final exam STD 8',
						start: new Date(21, 16, 0),
						allDay: false,
						className: 'important'
					},
					{
						id: 999,
						title: 'Repeating Event',
						start: new Date(y, m, d+4, 16, 0),
						allDay: false,
						className: 'info'
					},
					{
						title: 'Meeting',
						start: new Date(y, m, d, 10, 30),
						allDay: false,
						className: 'important'
					},
					{
						title: 'Lunch',
						start: new Date(y, m, d, 12, 0),
						end: new Date(y, m, d, 14, 0),
						allDay: false,
						className: 'important'
					},
					{
						title: 'Birthday Party',
						start: new Date(y, m, d+1, 19, 0),
						end: new Date(y, m, d+1, 22, 30),
						allDay: false,
					},
					{
						title: 'Click for Google',
						start: new Date(y, m, 28),
						end: new Date(y, m, 29),
						url: 'http://google.com/',
						className: 'success'
					}*/
				],
			});
			// \Calender--------------------------------------------------------------------------------------------
		});
	</script>
</head>
<body style="background-color:  #ededed;">
	<header>
		<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
			<a class="navbar-brand text-center" href="#"><?php echo $tution['name'] ?></a> -->
			 <!--  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			 			<span class="navbar-toggler-icon"></span>
			 </button>

	  		<div class="collapse navbar-collapse" id="navbarSupportedContent">
	  			<ul class="navbar-nav mr-auto">
	  			  <li class="nav-item active">
	  				<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
	  			  </li>
	  			  <li class="nav-item">
	  				<a class="nav-link" href="#">Link</a>
	  			  </li>
	  			  <li class="nav-item dropdown">
	  				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	  				  Dropdown
	  				</a>
	  				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
	  				  <a class="dropdown-item" href="#">Action</a>
	  				  <a class="dropdown-item" href="#">Another action</a>
	  				  <div class="dropdown-divider"></div>
	  				  <a class="dropdown-item" href="#">Something else here</a>
	  				</div>
	  			  </li>
	  			  <li class="nav-item">
	  				<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
	  			  </li>
	  			</ul>
	  		</div> 
	  	</nav> -->
	</header>

	<section id="section">
		<div id="wrapper">

			<!-- SIDEBAR -->
			<div id="sidebar-wrapper" style="position: fixed;">
				<div class="row">
					<div class="col-md-12 text-center" id="brand" style="margin-top: 15px;">
						<img src="../images/tution/<?php echo $tution['logo'];?>" class="img-fluid rounded" />
						<?php echo $tution['name'];?>
					</div>
					<!-- <div class="col-md-12 text-center" id="brand-name">
					</div> -->
				</div>
				<hr style="border-color: #222; width: 90%;" />
				<ul class="sidebar-nav">
					<!-- <li><span rel="tab_branch">Manage Branch</span></li> -->
					<!-- <li><span rel="tab_stud">Manage Students</span></li> -->
					<!-- <li><span rel="tab_staff">Manage Staff</span></li> -->
					<!-- <li><span rel="tab_report">Reports</span></li> -->
					<!-- <li><span rel="tab_attendence">Attendence</span></li>
					<li><span rel="tab_marks">Marks</span></li>
					<li><span rel="tab_profile">Profile</span></li>
					<li><span rel="tab_logout">Logout</span></li> -->

					<li><span rel="tab_home"><i class="fas fa-tachometer-alt"></i> Dashboard</span></li>
					<li><span rel="tab_expenses"><i class="fa fa-calculator"></i> Manage Expenses</span></li>
					<li><span rel="tab_attendence"><i class="fa fa-calendar"></i> Attendence</span></li>
					<li><span rel="tab_marks"><i class="flaticon-exam"></i> Marks</span></li>
					<li><span rel="tab_profile"><i class="fa fa-user"></i> Profile</span></li>
					<li><span rel="tab_logout"><i class="fa fa-power-off"></i> Logout</span></li>
				</ul>
			</div>	
			<!-- SIDEBAR CLOSE -->


			<!-- PAGE CONTENT -->
			<div id="page-content-wrapper">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-5 offset-md-7 text-right" style="color: #ccc;font-size: 16px; position: relative;">
							<p style="margin: 0px;margin-bottom: 0px; /*position: absolute*/;">Welcome <?php echo $_SESSION['name']; ?> (Staff)</p>
						</div>
					</div>
					<ul class="nav nav-tabs" id="tab-name-area" style="margin-top: 5px;">
						<li class="nav-item active" id="tab_home" rel="pane_home" onclick="activate_tab(this.id,this.rel);"><a class="nav-link"> Dashboard </a></li>
					</ul>

					<div class="tab-content" style="margin-top: 0px;">

						<!-- PANE_HOME -->
						<div class="tab-pane active" id="pane_home">
							<div class="panel panel-default" style="border-top: 0px;">

								<!-- PANEL-BODY -->
								<div class="panel-body">
									<div class="row">
										<div class="col-md-4">
											<div class="alert alert-primary" role="alert" id="notice_board">
												<h4 class="alert-heading">Well done!</h4>
												<p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
												<hr>
												<p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
											</div>
										</div>
										<div class="col-md-4">
											<div class="alert alert-primary" role="alert" id="notice_board">
												<h4 class="alert-heading">Working days</h4>
												<h6>Attended</h6>
												<p><?php echo $totPresent['totPresent']; ?>/09</p>
											</div>
										</div>
									</div>
									<br/>
									<br/>
									<hr>
									<br/>
									<div class="row">
										<div class="col-md-6">
											<div id="salary_chart_container">
												<canvas id="salary_pi" height="350" width="350"></canvas>
											</div>
										</div>
										<div class="col-md-6">
											<div id="attendence_chart_container">
												<canvas id="attendence_pi" height="350" width="350"></canvas>
											</div>
										</div>
									</div>
									<br/>
									<br/>
									<hr>
									<br/>
	  								<div class="row" id="calendar-body">
	  									<div class="col-md-12">
	  										<div id='calendar'></div>
	  									</div>
	  								</div>

								</div>	<!-- PANEL-BODY CLOSE -->

							</div>
						</div>	<!-- TAB-PAN-HOME CLOSE-->


						<!-- DYNAMIC TAB -->

						<!-- DYNAMIC TAB CLOSE -->


					</div>	<!-- TAB-CONTENT CLOSE -->


					<!-- FOOTER -->
					<hr>
					<div id="footer-wrapper">
						<div class="row">
							<div class="col-md-3 mr-auto" style="padding-left: 75px;">
								<h3>Promote With TMS</h3>
								<p>Promote your tution classes on our Home Page.</p>
								<p><a href="promote.php" class="btn btn-outline-info">Promote</a></p>
							</div>
							<div class="col-md-3" style="padding-left: 75px;">
								<h3>Quick Links</h3>
								<ul>
									<li><a href="../index.php" target="_blank">Home</a></li>
									<li><a href="../aboutus.php" target="_blank">About Us</a></li>
									<li><a href="../contact.php" target="_blank">Contact us</a></li>
									<li><a href="../contact.php" target="_blank">Help</a></li>
								</ul>
							</div>
							<div class="col-md-3" style="padding-left: 75px;">
								<h3>Have a Question?</h3>
								<ul>
									<li class="contact-info"><i class="fa fa-map-marker"></i>Surat | Gujarat</li>
									<li class="contact-info"><i class="fa fa-phone"></i>+91 704-305-6077</li>
									<li class="contact-info"><i class="fa fa-envelope"></i>tms@gmail.com</li>
								</ul>
							</div>
							<div class="col-md-3 float-right" style="padding-left: 75px;">
								<p><span class="fas fa-arrow-up" style="font-size: 16px; color: darkgray;"></span><a href="#" style="color: darkgray; font-size: 15px;"> Back to top</a></p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<ul class="social-media-list">
									<li class="bg-info">
										<a class="contact-icon" href="#"><i class="fab fa-facebook-f"></i></a>
									</li>
									<li class="bg-info">
										<a class="contact-icon" href="#"><i class="fab fa-twitter"></i></a>
									</li>
									<li class="bg-info">
										<a class="contact-icon" href="#"><i class="fab fa-instagram"></i></a>
									</li>
									<li class="bg-info">
										<a class="contact-icon" href="#"><i class="fab fa-google-plus-g"></i></a>
									</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 offset-md-5 text-center">
								<p>
									<small class="block" style="color: darkgray;">&copy;2019 | All Rights Reserved</small>
									<small class="block" style="color: darkgray;">Powered by TMS.com</small>
								</p>
							</div>
						</div>
					</div>
					<!-- \FOOTER -->
				</div>	<!-- CONTAINER-FLUID CLOSE -->
			</div>	<!-- PAGE CONTENT CLOSE-->

		</div>
	</section>

	<footer>

	</footer>

	<!-- <script type="text/javascript" src="../js/jquery_ui/jquery-ui.min.js"></script> -->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

	<!-- <link rel="stylesheet" type="text/css" href="../js/jquery-ui.css"> -->
	<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


	<script type="text/javascript">
		var removed_li; //	"id" of nav-item which is removed
		var n=1; // count number of branch increment | decrement "id"
		/* function to add New Branch in pane_branch */
		function add_branch(){
			n=n+1;
			bid ='branch'+n;
			data = '<tr id="newbranch'+n+'"><td><span class="badge" id="cont'+n+'" style="margin-top: 0px; margin-left: 0px; background: transparent; color:#000; font-size: 15px;">'+n+'.</span></td><td><input type="text" name="b_address[]" class="b_address input" id="b'+n+'_address" placeholder="Shop no. / Area" value=" "><span class="text-danger b_address_error" id="error-b'+n+'_address"></span></td><td><select name="b_state[]" id="b'+n+'_state" class="b_state input" onchange="fetchCities(this.value,\'b'+n+'_city\');"><option disabled selected value="0">State</option><?php foreach ($result as $r){echo '<option value="'.$r['stateID'].'" style="color:#111;">'.$r['stateName'].'</option>';}?></select><span class="text-danger" id="error-b'+n+'_state"></span></td><td><select id="b'+n+'_city" name="b_city[]" class="b_city input" style="border: 1px solid #ddd; width: 200px;"><option disabled selected>City</option></select><span class="text-danger" id="error-b'+n+'_city"></span></td><td><input type="text" name="b_phn[]" class="b_phn input" placeholder="Phone No." value=" "><span class="text-danger b_phn_error" id="error-b'+n+'_phn"> </span></td><td><button type="button" class="btn btn-danger btn-xs remove" onclick="remove_tr(\'newbranch'+n+'\');"><span class="glyphicon glyphicon-remove"></span></button></td></tr>';
			//alert(data);
			$('#new_branch_data').append(data);
			$('#'+n+'cont').html(n);
		}
		//---------------------------------------------------------

		// FUNCTION to Activate Tabs by cliking on them	: tab_branch, tab_stud, tab_staff, tab_report, tab_settings, tab_logout
		function activate_tab(tab_id,tab_rel){

				if (tab_id == removed_li){return;}	// If the TAB is ALREADY REMOVED

					// INACTIVE CURRENT "active" TAB ; "active" CLICKED TAB
					$('.nav-item.active').removeClass('active');
					$('#'+tab_id).addClass('active');

					// INACTIVE CURRENT "active" PANE ; "active" PANE OF CLICKED TAB
					$('.tab-pane.active').removeClass('active');
					
					$tab_pane = $('.nav-item.active').attr('rel');
					$('#'+$tab_pane).addClass('active');
				}
		//----------------------------------------------------------

		// FUNCTION to Remove Tab and Pane
		function tab_remove(rel){
				$nav_li = $('#'+rel);	// (Object)Tab to remove
				$pane = $('#'+$nav_li.attr('rel'));	// (Object)Pane to remove

				removed_li = rel;

					// if the "removed" pane is not currently "active"
					if (rel != $('.nav-item.active').attr('id')){
						$nav_li.remove();
						$pane.remove();
					}
				else 	// if the "removed" pane is currently "active"
				{
					$nav_li.prev().addClass('active');
					$nav_li.remove();

					$pane.prev().addClass('active');
					$pane.remove();
				}

				return;
			}
		//----------------------------------------------------------

		// FUNCTION to Remove new added tr
		function remove_tr(ele,pane){
			var tr = '#'+ele;
				//alert('removing '+tr);
				console.log(tr);
				$(tr).remove();

				if (pane == 'branch') {
					//alert('remove branch');
					n=n-1;
					$('#cont').attr('value',n);
					update_cont();
				}
				else if(pane == 'student'){
					//alert('remove student');
					sn=sn-1;
					update_cont_student();
				}
				else if(pane == 'staff'){
					//alert('remove staff');
					staff_n=staff_n-1;
					update_cont_staff();
				}
			}
		//----------------------------------------------------------

		// function to update tr number in PANE_BRANCH
		function update_cont(){
			i=1;
			$('.badge').each(function(){
				$(this).html(i);
				i=i+1;
			});

			i=1;
			$('.b_address').each(function(){
				value = 'b'+i+'_address';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.b_address_error').each(function(){
				value = 'error-b'+i+'_address';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.b_state').each(function(){
				value = 'b'+i+'_state';
				city = 'b'+i+'_city';
				$(this).attr({'id':value,'onchange':'fetchCities(this.value,\''+city+'\');'});
				i=i+1;
			});

			i=1;
			$('.b_state_error').each(function(){
				value = 'error-b'+i+'_state';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.b_city').each(function(){
				value = 'b'+i+'_city';
				$(this).attr('id',value);
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
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.b_phn_error').each(function(){
				value = 'error-b'+i+'_phn';
				$(this).attr('id',value);
				i=i+1;
			});
		}
		//----------------------------------------------------------

		// function to add New Student in PANE_STUDENT
		var sn = 0;
		function add_student(){
				//alert('add_student()');
				sn=sn+1;
				data = '<tr id="newstudent'+sn+'"><td><span class="s_badge" id="s_cont'+sn+'" style="margin-top: 0px; margin-left: 0px; background: transparent; color:#000; font-size: 15px;">'+sn+'.</span></td><td><select class="input s_std" id="s'+sn+'_std" name="s_std[]"><option selected disabled value="0">STD</option><?php $courses = preg_split("/:/",$tution['course']);$in = "IN (";foreach ($courses as $course) {if ($in == 'IN ('){$in .= "'$course'";}else{$in .= ",'$course'";}}$in .= ")";$q = "SELECT * FROM tbl_course WHERE short_name ".$in;$conn = connection('tms');$courses = mysqli_query($conn, $q);mysqli_close($conn);foreach ($courses as $course){echo'<option value="'.$course['short_name'].'"> '.$course['name'].'</option>';}?></select><span class="text-danger s_std_error" id="error-s'+sn+'_std"></span></td><td><select name="s_branch[]" id="s'+sn+'_branch " class="s_branch input"><option disabled selected value="0">Branch</option><?php foreach ($branches as $branch){echo '<option value="'.$branch['branchId'].'" style="color:#111;">'.$branch['address'].'</option>';}?></select><span class="text-danger" id="error-s'+sn+'_branch"></span></td><td><input type="text" name="s_name[]" class="input s_name" id="s'+sn+'_name" /><span class="text-danger s_name_error" id="error-s'+sn+'_name"></span></td><td><input type="text" name="s_father_name[]" class="s_father_name input" id="s'+sn+'_father_name"><span class="text-danger s_father_name_error" id="error-s'+sn+'_father_name"></span></td><td><select name="s_sex[]" id="s'+sn+'_sex" class="s_sex input"><option disabled selected>Gender</option><option value="male">Male</option><option value="female">Female</option></select><span class="text-danger s_sex_error" id="error-s'+sn+'_sex"></span></td><td><input type="text" name="s_phn[]" class="s_phn input" id="s'+sn+'_phn"/><span class="text-danger s_phn_error" id="error-s'+sn+'_phn"></span></td><td><input type="text" name="s_email[]" class="s_email input" id="s'+sn+'_email" /><span class="text-danger s_email_error" id="error-s'+sn+'_email"></span></td><td><input type="text" name="s_total_fees[]" class="s_total_fees input" id="s'+sn+'_total_fees" /><span class="text-danger s_total_fees_error" id="error-s'+sn+'_total_fees"> </span></td><td><input type="text" name="s_fees_paid[]" class="s_fees_paid input" id="s'+sn+'_fees_paid" value="00.00"/><span class="text-danger s_fees_paid_error" id="error-s'+sn+'_fees_paid"> </span></td><td><button type="button" class="btn btn-outline-danger  remove" onclick="remove_tr(\'newstudent'+sn+'\',\'student\');"><span class="glyphicon glyphicon-remove"></span></button></td></tr>';
					//alert(data);
					$('#tbl_ins_student_data').append(data);
					$('#s_cont'+sn).html(sn);
					$('#s'+sn+'_std').focus();
					console.log('#s'+sn+'_std');
				}
		//---------------------------------------------------------

		// function to update "id" of newly created input elements in PANE_STUDENT
		function update_cont_student(){
			i=1;
			$('.s_badge').each(function(){
				$(this).html(i);
				i=i+1;
			});

			i=1;
			$('.s_std').each(function(){
				value = 's'+i+'_std';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_std_error').each(function(){
				value = 'error-s'+i+'_std';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_branch').each(function(){
				value = 's'+i+'_branch';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_branch_error').each(function(){
				value = 'error-s'+i+'_branch';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_name').each(function(){
				value = 's'+i+'_name';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_name_error').each(function(){
				value = 'error-s'+i+'_name';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_father_name').each(function(){
				value = 's'+i+'_father_name';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_father_name_error').each(function(){
				value = 'error-s'+i+'_father_name';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_sex').each(function(){
				value = 's'+i+'_sex';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_sex_error').each(function(){
				value = 'error-s'+i+'_sex';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_phn').each(function(){
				value = 's'+i+'_phn';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_phn_error').each(function(){
				value = 'error-s'+i+'_phn';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_email').each(function(){
				value = 's'+i+'_email';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_email_error').each(function(){
				value = 'error-s'+i+'_email';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_total_fees').each(function(){
				value = 's'+i+'_total_fees';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_total_fees_error').each(function(){
				value = 'error-s'+i+'_total_fees';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_fees_paid').each(function(){
				value = 's'+i+'_fees_paid';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_fees_paid_error').each(function(){
				value = 'error-s'+i+'_fees_paid';
				$(this).attr('id',value);
				i=i+1;
			});
		}
		//---------------------------------------------------------

		// function to add new Staff in PANE_STAFF
		var staff_n = 0;
		function add_staff(){
				//alert('add_staff()');
				staff_n=staff_n+1;
				data = '<tr id="newstaff'+staff_n+'"><td><span class="staff_badge" id="staff_cont'+staff_n+'" style="margin-top: 0px; margin-left: 0px; background: transparent; color:#000; font-size: 15px;">'+staff_n+'.</span></td><td><select name="staff_type[]" id="staff'+staff_n+'_type" class="staff_type input"> <option selected value="Normal">Normal</option> <option value="Head">Head</option> </select></td><td><select name="staff_branch[]" id="staff'+staff_n+'_branch" class="staff_branch input"><option disabled selected value="0">Branch</option><?php foreach ($branches as $branch){echo '<option value="'.$branch['branchId'].'" style="color:#111;">'.$branch['address'].'</option>';}?></select><span class="text-danger" id="error-staff'+staff_n+'_branch"></span></td><td><input type="text" name="staff_name[]" class="staff_name input" id="staff'+staff_n+'_name" /><span class="text-danger staff_name_error" id="error-staff'+staff_n+'_name"></span></td><td><input type="text" name="staff_middle_name[]" class="staff_middle_name input" id="staff'+staff_n+'_middle_name"><span class="text-danger staff_middle_name_error" id="error-staff'+staff_n+'_middle_name"></span></td><td><select name="staff_sex[]" id="staff'+staff_n+'_sex" class="staff_sex input"><option disabled selected>Gender</option><option value="male">Male</option><option value="female">Female</option></select><span class="text-danger staff_sex_error" id="error-staff'+staff_n+'_sex"></span></td><td><input type="text" name="staff_phn[]" class="staff_phn input" id="staff'+staff_n+'_phn"/><span class="text-danger staff_phn_error" id="error-staff'+staff_n+'_phn"></span></td><td><input type="text" name="staff_email[]" class="staff_email input" id="staff'+staff_n+'_email" /><span class="text-danger staff_email_error" id="error-staff'+staff_n+'_email"></span></td><td><input type="text" name="staff_qualification[]" class="input staff_qualification" id="staff'+staff_n+'_qualification" placeholder="eg. BCA,MCA,..." /><span class="text-danger staff_qualification_error" id="error-staff'+staff_n+'_qualification"></span> </td><td><input type="text" name="staff_total_salary[]" class="staff_total_salary input" id="staff'+staff_n+'_total_salary" /><span class="text-danger staff_total_salary_error" id="error-staff'+staff_n+'_total_salary"></span></td><td><input type="text" name="staff_salary_paid[]" class="staff_salary_paid input" id="staff'+staff_n+'_salary_paid" value="00.00"/><span class="text-danger staff_salary_paid_error" id="error-staff'+staff_n+'_salary_paid"> </span></td><td><input type="date" name="staff_doj[]" class="staff_doj input" id="staff'+staff_n+'_doj"/><span class="text-danger staff_doj" id="error-staff'+staff_n+'_doj"> </span></td><td><button type="button" class="btn btn-outline-danger  remove" onclick="remove_tr(\'newstaff'+staff_n+'\',\'staff\');"><span class="glyphicon glyphicon-remove"></span></button></td></tr>'; //alert(data);

				$('#tbl_ins_staff_data').append(data);
				$('#staff_cont'+staff_n).html(staff_n);
				// console.log('#staff'+staff_n+'_branch');

					$('#staff'+staff_n+'_branch').focus();	// Focus on branch
				}
		//---------------------------------------------------------

		// function to update "id" of newly created input elements in PANE_STAFF
		function update_cont_staff(){
			i=1;
			$('.staff_badge').each(function(){
				$(this).html(i);
				i=i+1;
			});

			i=1;
			$('.staff_std').each(function(){
				value = 'staff'+i+'_std';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_std_error').each(function(){
				value = 'error-staff'+i+'_std';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_branch').each(function(){
				value = 'staff'+i+'_branch';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_branch_error').each(function(){
				value = 'error-staff'+i+'_branch';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_name').each(function(){
				value = 'staff'+i+'_name';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_name_error').each(function(){
				value = 'error-staff'+i+'_name';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_middle_name').each(function(){
				value = 'staff'+i+'_middle_name';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_middle_name_error').each(function(){
				value = 'error-staff'+i+'_middle_name';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_sex').each(function(){
				value = 'staff'+i+'_sex';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_sex_error').each(function(){
				value = 'error-staff'+i+'_sex';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_phn').each(function(){
				value = 'staff'+i+'_phn';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_phn_error').each(function(){
				value = 'error-staff'+i+'_phn';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_email').each(function(){
				value = 'staff'+i+'_email';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_email_error').each(function(){
				value = 'error-staff'+i+'_email';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_total_salary').each(function(){
				value = 'staff'+i+'_total_salary';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.s_total_salary_error').each(function(){
				value = 'error-staff'+i+'_total_salary';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_salary_paid').each(function(){
				value = 'staff'+i+'_salary_paid';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.staff_salary_paid_error').each(function(){
				value = 'error-staff'+i+'_salary_paid';
				$(this).attr('id',value);
				i=i+1;
			});
		}
		//---------------------------------------------------------


		var expn = 0;
		function add_expenses(){
				//alert('add_expenses()');
				expn=expn+1;
				data = '<tr id="newexpenses'+expn+'"> <td> <span class="exp_badge" id="exp_cont'+expn+'" style="margin-top: 0px; margin-left: 0px; background: transparent; color:#000; font-size: 15px;">'+expn+'.</span> </td> <td> <select name="exp_branch[]" id="exp'+expn+'_branch " class="exp_branch input"> <option disabled selected value="0">Branch</option> <?php foreach ($branches as $branch){echo '<option value="'.$branch['branchId'].'" style="color:#111;">'.$branch['address'].'</option>';}?> </select> <span class="text-danger" id="error-exp'+expn+'_branch"></span> </td> <td> <input type="text" name="exp_name[]" class="input exp_name" id="exp'+expn+'_name" required /> <span class="text-danger exp_name_error" id="error-exp'+expn+'_name"></span> </td> <td> <input type="text" name="exp_amt[]" class="exp_amt input" id="exp'+expn+'_amt" placeholder="00.00" required/> <span class="text-danger exp_amt_error" id="error-exp'+expn+'_amt"></span> </td> <td> <input type="text" name="exp_remark[]" class="exp_remark input" id="exp'+expn+'_remark" /> <span class="text-danger exp_remark_error" id="error-exp'+expn+'_remark"></span> </td> <td> <button type="button" class="btn btn-outline-danger remove" onclick="remove_tr(\'newexpenses'+expn+'\',\'expenses\');"> <span class="glyphicon glyphicon-remove"></span></button> </td> </tr>'; 
				//alert(data);
					$('#tbl_ins_expenses_data').append(data);
					$('#exp_cont'+expn).html(expn);
					$('#exp'+expn+'_std').focus();
					console.log('#exp'+expn+'_branch');
				}
		//---------------------------------------------------------

		// function to update "id" of newly created input elements in PANE_STUDENT
		function update_cont_expenses(){
			i=1;
			$('.exp_badge').each(function(){
				$(this).html(i);
				i=i+1;
			});

			i=1;
			$('.exp_branch').each(function(){
				value = 'exp'+i+'_branch';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.exp_branch_error').each(function(){
				value = 'error-exp'+i+'_branch';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.exp_name').each(function(){
				value = 'exp'+i+'_name';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.exp_name_error').each(function(){
				value = 'error-exp'+i+'_name';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.exp_amt').each(function(){
				value = 'exp'+i+'_amt';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.exp_amt_error').each(function(){
				value = 'error-exp'+i+'_amt';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.exp_remark').each(function(){
				value = 'exp'+i+'_remark';
				$(this).attr('id',value);
				i=i+1;
			});

			i=1;
			$('.exp_remark_error').each(function(){
				value = 'error-exp'+i+'_remark';
				$(this).attr('id',value);
				i=i+1;
			});
		}
		//---------------------------------------------------------



		$(document).ready(function(){
			Chart.defaults.global.responsive = false;
			var ctx = document.getElementById('salary_pi');
			var salary_pi = new Chart(ctx,{
				type:'doughnut',
				data:{
					labels:["Paid Salary", "Remaining Salary"],
					datasets:[{
						label: "Salary",
						backgroundColor:['#f1c40f','#2980b9'],
						data:[<?php echo $staff['paidSalary']; ?>,<?php echo $staff['totalSalary'] - $staff['paidSalary']; ?>]
					}]
				},
			});

			var ctx = document.getElementById('attendence_pi');
			var salary_pi = new Chart(ctx,{
				type:'doughnut',
				data:{
					labels:["Present", "Absent"],
					datasets:[{
						label: "Attendence",
						backgroundColor:['#23EE74','#F3600B'],
						data:[<?php echo $totPresent['totPresent']; ?>,<?php echo 30; ?>]
					}]
				},
			});
		});

	</script>
</body>
</html>

<?php
}
?>