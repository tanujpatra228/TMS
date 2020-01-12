<?php
session_start();
$tutionId = $_SESSION['tutionId'];
include'../includes/connect.inc.php';
$conn = connection('tms');

$q = "SELECT name, std, date, amt, tbl_branch.address as address, totalFees, (totalFees-SUM(amt)) AS remaining 
	FROM tbl_student, tbl_fees, tbl_branch 
	WHERE tbl_student.studentId = tbl_fees.studentId 
	AND tbl_student.branchId = tbl_branch.branchId 
	AND tbl_student.branchId LIKE '%' 
	AND tbl_student.tutionId LIKE '$tutionId' 
	GROUP BY tbl_fees.studentId DESC";
$result = mysqli_query($conn, $q) or die(mysqli_error($conn));

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Fees Report | TMS</title>
	<!-- jQuery -->
	<script src="http://code.jquery.com/jquery-3.3.1.js"></script>

	<style type="text/css">
		body{
			font-size: 13px !important;
		}
		#content{
			background-color: #fff;
			margin-top: 50px;
			padding: 10px;
			border-radius: 10px;
			box-shadow: -1px 0 8px 0 #bbb;
		}
		#table_wrapper{
			width: 100%;
		}
	</style>

</head>

<body style="background-color: #ededed;">
	<div class="container mt-3 mb-3">
		<div class="row">
			<div class="col-md-12">
				<p class="display-4" style="font-size: 3.5rem;">Fees Report</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div id="form_container">
					<form id="student_form">
						<div class="row pl-5 mt-3">
							<div class="col-md-3">
								<select id="branch_selector" name="branch" class="input form-control">
									<option disabled selected value="0">Select Branch</option>
								</select>
							</div>
							<div class="col-md-3">
								<select id="std_selector" name="std" class="input form-control">
									<option disabled selected value="0">Select STD</option>
								</select>
							</div>
							<div class="col-md-3">
								<select id="student_selector" name="studentId" class="input form-control">
									<option disabled selected>Select Student</option>
								</select>
							</div>
							<div class="col-md-1">
								<button class="btn btn-primary" id="btn_search" type="button">Search</button>
							</div>
						</div>

						<div class="row pl-5 mt-2">
							<div class="col-md-4">
								<label>From Date:
									<input id="from_date" name="from_date" class="input form-control" />
								</label>
							</div>
							<div class="col-md-4">
								<label>To Date:
									<input id="to_date" name="to_date" class="input form-control" />
								</label>
							</div>
							<div class="col-md-3 text-center pl-4 mt-4">
								<button type="button" id="btn_close" class="btn btn-danger" tabindex="-1" onclick="self.close();">Close</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="content">
			<div class="col-md-12">
				<p class="display-4" style="font-size: 3rem;">Recent Fees</p>
			</div>
			<div class="col-md-12" id="table-container">
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>STD</th>
							<th>Name</th>
							<th>Date</th>
							<th>Branch</th>
							<th>Amount</th>
							<th>Paid</th>
							<th>Total</th>
						</tr>
						<tr>
							<th>#</th>
							<th>STD</th>
							<th>Name</th>
							<th>Date</th>
							<th>Branch</th>
							<th>Amount</th>
							<th>Paid</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						foreach ($result as $row) {
							echo'<tr>';
							echo'<td>'.$i.'</td>';
							echo'<td>'.$row['std'].'</td>';
							echo'<td>'.$row['name'].'</td>';
							echo'<td>'.$row['date'].'</td>';
							echo'<td>'.$row['address'].'</td>';
							echo'<td>'.$row['amt'].'</td>';
							echo'<td>'.$row['totalFees'].'</td>';
							echo'<td>'.$row['remaining'].'</td>';
							echo'</tr>';
							$i++;
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>

	<script type="text/javascript"> tution = '<?php echo $tutionId; ?>';</script>
	
	<!-- Boostrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<!-- DataTable -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

	<!-- Datepicker -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">



	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<!-- Datepicked ui -->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<script type="text/javascript" src="fees.report.js"></script>
	
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
</html>