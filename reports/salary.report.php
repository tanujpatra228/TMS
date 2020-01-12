<?php
session_start();
$tutionId = $_SESSION['tutionId'];
include'../includes/connect.inc.php';
$conn = connection('tms');

/*$q = "SELECT * FROM tbl_branch WHERE tutionId LIKE '$tutionId'";
$branches = mysqli_query($conn, $q) or die(mysqli_error($conn));*/

# TOTAL PRESENT AND NET SALARY
/*$q = "SELECT date,name,tbl_branch.address, SUM(attendence) AS Present,totalSalary, totalSalary*SUM(attendence)/30 AS Amt
FROM `tbl_attendence`, `tbl_staff`, `tbl_branch`
WHERE `tbl_attendence`.`Id` = `tbl_staff`.`staffId`
AND `tbl_branch`.`branchId` = `tbl_staff`.`branchId`
AND `tbl_attendence`.type LIKE 'staff'
AND `tbl_attendence`.`tutionId` LIKE '$tutionId'
AND `tbl_attendence`.`date` BETWEEN '2019-04-01' AND '2019-04-30'
GROUP BY Id";*/
# \TOTAL PRESENT AND NET SALARY

# STAFF TOTAL SALARY REMAINING TO PAY
$q_unpaid = "SELECT name,tbl_branch.address, SUM(attendence) AS Present,totalSalary, FORMAT((totalSalary*SUM(attendence)/30),2) AS Amt 
	FROM `tbl_attendence`, `tbl_staff`, `tbl_branch` 
	WHERE `tbl_attendence`.`Id` = `tbl_staff`.`staffId` 
	AND `tbl_branch`.`branchId` = `tbl_staff`.`branchId` 
	AND `tbl_attendence`.`tutionId` LIKE '$tutionId' 
	AND `tbl_attendence`.`date` BETWEEN '2019-03-01' AND '2019-04-30' 
	AND tbl_staff.staffId NOT IN(SELECT staffId FROM tbl_salary WHERE tutionId LIKE 'T9324742' AND date BETWEEN '2019-04-01' and '2019-04-30') GROUP BY Id";
# \STAFF TOTAL SALARY REMAINING TO PAY

# STAFF TOTAL SALARY PAID
$q_paid = "SELECT `tbl_salary`.`date` AS `date`,tbl_branch.address ,name , totalSalary,SUM(tbl_attendence.attendence) AS Present, amt 
	FROM tbl_staff, tbl_salary, tbl_attendence, tbl_branch 
	WHERE tbl_staff.staffId = tbl_salary.staffId 
	AND tbl_staff.staffId = tbl_attendence.Id 
	AND tbl_staff.branchId = tbl_branch.branchId
	AND tbl_salary.tutionId LIKE '$tutionId'
    AND tbl_salary.date BETWEEN '2019-04-01' AND '2019-04-30'
    GROUP BY tbl_salary.staffId";
# \STAFF TOTAL SALARY PAID

$result_paid = mysqli_query($conn, $q_paid) or die(mysqli_error($conn));
$result_unpaid = mysqli_query($conn, $q_unpaid) or die(mysqli_error($conn));

mysqli_close($conn);
?>

<!-- last salary paid -->
<!-- SELECT date,tbl_branch.address,name,amt FROM tbl_salary, tbl_staff,tbl_branch WHERE tbl_staff.staffId = tbl_salary.staffId AND tbl_branch.branchId = tbl_staff.branchId AND tbl_salary.tutionId LIKE 'T9324742'  -->

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

	<script type="text/javascript" src="salary.report.js"></script>
	<!-- <script type="text/javascript" src="../js/tms_salary.js"></script> -->
	<style type="text/css">
		body{
			font-size: 15px;
			background-color: #ededed;
		}
		.table{
			width: 100% !important;
		}
		.container{
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
				<p class="display-4" style="font-size: 3.5rem;">Salary Report</p>
			</div>
		</div>
		<form id="salary_report_form">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-1">
							Branch:
						</div>
						<div class="col-md-4">
							<select id="form_branch-salary" name="branchId" class="input form-group">
								<option disabled selected value="%">Select Barnch</option>
							</select>
						</div>

						<div class="col-md-1">
							Staff:
						</div>
						<div class="col-md-4">
							<select id="form_staff-salary" name="staffId" class="input form-group">
								<option disabled selected value="%">Select Branch First</option>
							</select>
						</div>
						<div class="col-md-2">
							<button type="button" class="form-group btn btn-primary" name="btn_search" id="btn_search" value="Search" style="width: 100%;">Search</button>
						</div>
					</div>

					<div class="row">
						<div class="col-md-1">
							From Date: 
						</div>
						<div class="col-md-4">
							<input type="text" class="input form-group" name="from_date" id="from_date" />
						</div>

						<div class="col-md-1">
							To Date: 
						</div>
						<div class="col-md-4">
							<input type="text" class="input form-group" name="to_date" id="to_date" />
						</div>
						<div class="col-md-2">
							<button type="button" class="form-group btn btn-danger" id="btn_reset" onclick="self.close();" style="width: 100%;">Close</button>
						</div>
					</div>
				</div>
			</div>
		</form>

		<div id="default_table">
			<div class="row" style="margin-top: 10px;">
				<div class="col-md-12">
					<button class="btn btn-secondary" id="btn_toggle">Paid / Unpaid</button>
				</div>
			</div>

			<!-- Table -->
			<!-- Salary Paid to -->
			<div class="row" id="paid" style="display: none;">
				<div class="col-md-12">
					<span class="display-4">Paid Salary</span>
				</div>
				<div class="col-md-12">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>No</th>
								<th>Date</th>
								<th>Branch</th>
								<th>Name</th>
								<th>Present</th>
								<th>Salary</th>
								<th>Amount Paid</th>
							</tr>
							<tr>
								<th>No</th>
								<th>Date</th>
								<th>Branch</th>
								<th>Name</th>
								<th>Present</th>
								<th>Salary</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i = 1;
								foreach ($result_paid as $row) {
									echo'<tr>';
									echo'<td>'.$i.'</td>';
									echo'<td>'.$row['date'].'</td>';
									echo'<td>'.$row['address'].'</td>';
									echo'<td>'.$row['name'].'</td>';
									echo'<td>'.$row['Present'].'</td>';
									echo'<td>'.$row['totalSalary'].'</td>';
									echo'<td>'.$row['amt'].'</td>';
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
					<span class="display-4">Outstanding</span>
				</div>
				<div class="col-md-12">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>No</th>
								<th>Branch</th>
								<th>Name</th>
								<th>Present</th>
								<th>Salary</th>
								<th>Amount</th>
							</tr>
							<tr>
								<th>No</th>
								<th>Branch</th>
								<th>Name</th>
								<th>Present</th>
								<th>Salary</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i = 1;
								foreach ($result_unpaid as $row) {
									echo'<tr>';
									echo'<td>'.$i.'</td>';
									echo'<td>'.$row['address'].'</td>';
									echo'<td>'.$row['name'].'</td>';
									echo'<td>'.$row['Present'].'</td>';
									echo'<td>'.$row['totalSalary'].'</td>';
									echo'<td>'.$row['Amt'].'</td>';
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