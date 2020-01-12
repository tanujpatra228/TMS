<?php
session_start();
$tutionId = $_SESSION['tutionId'];
include'../includes/connect.inc.php';
$conn = connection('tms');

# Date wise Present STAFF
$q_staff = "SELECT tbl_attendence.date,tbl_branch.address, tbl_staff.name 
FROM `tbl_attendence`, tbl_staff, tbl_branch
WHERE tbl_staff.staffId = tbl_attendence.Id
AND tbl_staff.branchId = tbl_branch.branchId
AND tbl_attendence.tutionId LIKE '$tutionId'
AND tbl_attendence.date BETWEEN '2019-04-14' AND '2019-04-31'
ORDER BY tbl_attendence.date DESC";

# Date wise attendence STUDENT 
$q_student = "SELECT tbl_attendence.date,tbl_branch.address, tbl_student.name 
FROM `tbl_attendence`, tbl_student, tbl_branch
WHERE tbl_student.studentId = tbl_attendence.Id
AND tbl_student.branchId = tbl_branch.branchId
AND tbl_attendence.tutionId LIKE '$tutionId'
AND tbl_attendence.date BETWEEN '2019-04-14' AND '2019-04-31'
ORDER BY tbl_attendence.date DESC";

$result_staff = mysqli_query($conn, $q_staff) or die(mysqli_error($conn));
$result_student = mysqli_query($conn, $q_student) or die(mysqli_error($conn));


mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Salary Report | TMS</title>
	<!-- jQuery -->
	<script src="http://code.jquery.com/jquery-3.3.1.js"></script>

	<script type="text/javascript"> tution = '<?php echo $tutionId; ?>';</script>
	
	<!-- Boostrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<!-- DataTable -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

	<!-- Datepicker -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	<script type="text/javascript" src="attendence.report.js"></script>
	<!-- <script type="text/javascript" src="../js/tms_attendence.js"></script> -->
	<style type="text/css">
		body{
			font-size: 14px;
			background-color: #ededed;
		}
		.table{
			width: 100% !important;
		}
		.container{
		}
		#from_date,#to_date,.input{
			width: 150px;
		}
		#default_table{
			border-radius: 10px;
			padding: 10px;
			background-color: #fff;
			box-shadow: -1px 0 8px 0 #bbb;
		}
	</style>
</head>
<body>
	<div class="container mb-3 mt-3">
		<div class="row">
			<div class="col-md-12">
				<p class="display-4" style="font-size: 3.5rem;">Attendence Report</p>
			</div>
		</div>
		<form id="attendence_report_form">
			<div class="row">
				<div class="col-md-12" style="margin-left: 80px;">
					<div class="row">
						
						<div class="col-md-3">
							Branch :
							<select id="form_branch-attendence" name="branchId" class="input form-group">
								<option disabled selected value="%">Select Barnch</option>
							</select>
						</div>

						<div class="col-md-3">
							Staff :
							<select id="form_staff-attendence" name="staffId" class="input form-group">
								<option disabled selected value="%">Select Branch First</option>
							</select>
						</div>

						<div class="col-md-3">
							Student :
							<select id="form_student-attendence" name="studentId" class="input form-group">
								<option disabled selected value="%">Select Branch First</option>
							</select>
						</div>

					</div>

					<div class="row">
						<div class="col-md-3">
							From : &nbsp;&nbsp;
							<input type="text" class="input form-group" name="from_date" id="from_date" />
						</div>

						<div class="col-md-3">
							To : &nbsp;&nbsp;&nbsp;
							<input type="text" class="input form-group" name="to_date" id="to_date" />
						</div>
						<div class="col-md-2">
							<button type="button" class="form-group btn btn-primary" name="btn_search" id="btn_search" value="Search" style="width: 100%;">Search</button>&nbsp;&nbsp;&nbsp;&nbsp;
						</div>
						<div class="col-md-2 text-right">
							<button type="button" class="form-group btn btn-danger" id="btn_reset" onclick="self.close();" style=";">Close</button>
						</div>
					</div>
				</div>
			</div>
		</form>

		<div id="default_table">
			<div class="row" style="margin-top: 10px;">
				<div class="col-md-12">
					<button class="btn btn-secondary" id="btn_toggle">Student / Staff</button>
				</div>
			</div>

			<!-- Table -->
			<!-- Salary Paid to -->
			<div class="row" id="paid" style="display: none;">
				<div class="col-md-12">
					<span class="display-4">Staff Attendence</span>
				</div>
				<div class="col-md-12">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>No</th>
								<th>Date</th>
								<th>Branch</th>
								<th>Name</th>
							</tr>
							<tr>
								<th>No</th>
								<th>Date</th>
								<th>Branch</th>
								<th>Name</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i = 1;
								foreach ($result_staff as $row) {
									echo'<tr>';
									echo'<td>'.$i.'</td>';
									echo'<td>'.$row['date'].'</td>';
									echo'<td>'.$row['address'].'</td>';
									echo'<td>'.$row['name'].'</td>';
									echo'</tr>';
									$i += 1;
								}
							?>
						</tbody>
					</table>
				</div>
			</div>

			<!-- Salary Unpaid to -->
			<div class="row" id="outstanding">
				<div class="col-md-12">
					<span class="display-4">Student</span>
				</div>
				<div class="col-md-12">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>No</th>
								<th>Date</th>
								<th>Branch</th>
								<th>Name</th>
							</tr>
							<tr>
								<th>No</th>
								<th>Date</th>
								<th>Branch</th>
								<th>Name</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i = 1;
								foreach ($result_student as $row) {
									echo'<tr>';
									echo'<td>'.$i.'</td>';
									echo'<td>'.$row['date'].'</td>';
									echo'<td>'.$row['address'].'</td>';
									echo'<td>'.$row['name'].'</td>';
									echo'</tr>';
									$i += 1;
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<!-- Datepicked ui -->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
	<script type="text/javascript">

		$('#btn_toggle').click(function(){
			$('#outstanding').slideToggle();
			$('#paid').slideToggle();
		});

		$('.table').DataTable({
			initComplete: function(){
				this.api().columns().every(function(){
					var column = this;
					var select = $('<select><option value=""></option></select>')
						.appendTo($(column.header()).empty())
						.on('change', function(){
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);

							column
								.search(val ? '^'+val+'$' : '', true, false).draw();
						});
					column.data().unique().sort().each(function(d, j){
						select.append('<option value="'+d+'">'+d+'</option>')
					});
				});
			}
		});
	</script>
</body>
</html>