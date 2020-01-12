<?php
session_start();
$tutionId = $_SESSION['tutionId'];
include'../includes/connect.inc.php';
$conn = connection('tms');


$from_date = '2019-04-01';
$to_date = '2019-04-30';

if (isset($_POST['btn_search'])) {
	// $from_date = '2019-04-01';
	// $to_date = '2019-04-30';

		$from_date = $_POST['from_date'];
		$to_date = $_POST['to_date'];
	/*if (isset($_POST['from_date'])) {
	}
	if (isset($_POST['to_date'])) {
	}*/
}
# Date range -> tbl_salary.amt + tbl_expense.amt = actual Expense (till date)
# Date range -> SUM tbl_fees.amt = actual Income (till date)
	$q_ae = "SELECT 
				(SELECT SUM(amt) FROM tbl_salary WHERE tutionId LIKE '$tutionId' AND date BETWEEN '2019-04-01' AND '2019-04-30') 
				+ 
				(SELECT SUM(amt) FROM tbl_expense WHERE tutionId LIKE '$tutionId' AND date BETWEEN '2019-04-01' AND '2019-04-30') 
				AS total
			FROM tbl_salary
			GROUP BY total";
	$actual_expense = mysqli_fetch_array(mysqli_query($conn, $q_ae)) or die(mysqli_error($conn));

	$q_i = "SELECT SUM(amt) AS income
			FROM tbl_fees 
			WHERE tutionId LIKE '$tutionId'
			AND date BETWEEN '2019-04-01' AND '2019-04-30'";
	$actual_income = mysqli_fetch_array(mysqli_query($conn, $q_i)) or die(mysqli_error($conn));


# ALL EXPENSEXS
	$q = "SELECT tbl_salary.date,tbl_salary.amt,tbl_staff.name,tbl_branch.address as baddress 
			FROM tbl_salary, tbl_staff, tbl_branch
			WHERE tbl_staff.staffId = tbl_salary.staffId 
			AND tbl_staff.tutionId LIKE '$tutionId'
			AND date BETWEEN '$from_date' AND '$to_date'
			GROUP BY tbl_salary.Id";
	$salary = mysqli_query($conn, $q) or die(mysqli_error($conn));

	$q = "SELECT tbl_expense.*,tbl_branch.address FROM tbl_expense, tbl_branch
		WHERE tbl_expense.branchId = tbl_branch.branchId
		AND tbl_expense.tutionId LIKE '$tutionId'
		AND date BETWEEN '$from_date' AND '$to_date'";
	$expense = mysqli_query($conn, $q) or die(mysqli_error($conn));

#ALL INCOME
	$q = "SELECT tbl_fees.date, tbl_fees.amt,tbl_branch.address,tbl_student.std,tbl_student.name
		FROM tbl_fees, tbl_student,tbl_branch
		WHERE tbl_fees.studentId = tbl_student.studentId
		AND tbl_student.branchId = tbl_branch.branchId
		AND tbl_fees.tutionId LIKE '$tutionId'
		AND tbl_fees.date BETWEEN '$from_date' AND '$to_date'
		ORDER BY tbl_fees.date DESC";

	$income = mysqli_query($conn, $q) or die(mysqli_error($conn));

# tbl_student.totalFees / 11 = expected Income (per month)
# tbl_staff.totalSalary / 11 = expected Expense (per month)

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

	<script type="text/javascript" src="income_expense.report.js"></script>
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
				<p class="display-4" style="font-size: 2.8rem;">Income/Expence Report</p>
			</div>
		</div>
		<form id="ie_report_form" action="#" method="POST">
			<div class="row">
				<div class="col-md-12" style="margin-left: 80px;">

					<div class="row">
						<div class="col-md-3">
							From : &nbsp;&nbsp;
							<input type="text" class="input form-group" name="from_date" id="from_date" value="<?php echo $from_date;?>" />
						</div>

						<div class="col-md-3">
							To : &nbsp;&nbsp;&nbsp;
							<input type="text" class="input form-group" name="to_date" id="to_date" value="<?php echo $to_date;?>" />
						</div>
						<div class="col-md-2">
							<button type="submit" class="form-group btn btn-primary" name="btn_search" id="btn_search" value="Search" style="width: 100%;">Search</button>&nbsp;&nbsp;&nbsp;&nbsp;
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
					<button class="btn btn-secondary" id="btn_toggle">Income / Expense</button>
				</div>
			</div>

			<!-- Table -->
			<!-- Salary Paid to -->
			<div class="row" id="expense" style="display: none;">
				<div class="col-md-12">
					<span class="display-4">Expense</span>
				</div>
				<div class="col-md-12">
					<table class="table table-striped table-bordered" id="tbl_expense">
						<thead>
							<tr>
								<th>No</th>
								<th>Date</th>
								<th>Branch</th>
								<th>Name</th>
								<th>Type</th>
								<th>Amount</th>
							</tr>
							<tr>
								<th>No</th>
								<th>Date</th>
								<th>Branch</th>
								<th>Name</th>
								<th>Type</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody id="expense_table">
							<?php
							$i = 1;
							foreach ($salary as $row) {
								echo '<tr>';
								echo '<td>'.$i.'</td>';
								echo '<td>'.$row['date'].'</td>';
								echo '<td>'.$row['baddress'].'</td>';
								echo '<td>'.$row['name'].'</td>';
								echo '<td>Salary</td>';
								echo '<td>'.$row['amt'].'</td>';
								echo '</tr>';
								$i++;
							}
							foreach ($expense as $row) {
								echo'<tr>';
								echo '<td>'.$i.'</td>';
								echo '<td>'.$row['date'].'</td>';
								echo '<td>'.$row['address'].'</td>';
								echo '<td>'.$row['expense'].'</td>';
								echo '<td>Expense</td>';
								echo '<td>'.$row['amt'].'</td>';
								echo'</tr>';
								$i++;
							}
							?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="5" class="text-right">Total</td>
								<td colspan="1"></td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>

			<!-- Salary Unpaid to -->
			<div class="row" id="income">
				<div class="col-md-12">
					<span class="display-4">Income</span>
				</div>
				<div class="col-md-12">
					<table class="table table-striped table-bordered" id="tbl_income">
						<thead>
							<tr>
								<th>No</th>
								<th>Date</th>
								<th>Branch</th>
								<th>Name</th>
								<th>STD</th>
								<th>Amount</th>
							</tr>
							<tr>
								<th>No</th>
								<th>Date</th>
								<th>Branch</th>
								<th>Name</th>
								<th>STD</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody id="income_table">
							<?php
							$i = 1;
							foreach ($income as $row) {
								echo'<tr>';
								echo'<td>'.$i.'</td>';
								echo'<td>'.$row['date'].'</td>';
								echo'<td>'.$row['address'].'</td>';
								echo'<td>'.$row['name'].'</td>';
								echo'<td>'.$row['std'].'</td>';
								echo'<td>'.$row['amt'].'</td>';
								echo'</tr>';
								$i++;
							}
							?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="5" class="text-right">Total</td>
								<td colspan="1"></td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>


			<!-- <div id="script">
				<script type="text/javascript">
					$(function(){
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
							},
			
							footerCallback: function ( row, data, start, end, display ) {
							    var api = this.api(), data;
							
							    // Remove the formatting to get integer data for summation
							    var intVal = function ( i ) {
							        return typeof i === 'string' ?
							            i.replace(/[\$,]/g, '')*1 :
							            typeof i === 'number' ?
							                i : 0;
							    };
							
							    // Total over all pages
							    total = api
							        .column( 4 )
							        .data()
							        .reduce( function (a, b) {
							            return intVal(a) + intVal(b);
							        }, 0 );
							
							    // Total over this page
							    pageTotal = api
							        .column( 4, { page: 'current'} )
							        .data()
							        .reduce( function (a, b) {
							            return intVal(a) + intVal(b);
							        }, 0 );
							
							    // Update footer
							    $( api.column( 4 ).footer() ).html(
							        'Rs.'+pageTotal +' ( Rs.'+ total +' total)'
							    );
							}
			
			
						});
					});
				</script>
			</div> -->
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
$(document).ready(function(){
	$('#btn_toggle').click(function(){
		$('#expense').slideToggle();
		$('#income').slideToggle();
	});

	/*$('.table').DataTable({
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
		},

		footerCallback: function ( row, data, start, end, display ) {
		    var api = this.api(), data;
		
		    // Remove the formatting to get integer data for summation
		    var intVal = function ( i ) {
		        return typeof i === 'string' ?
		            i.replace(/[\$,]/g, '')*1 :
		            typeof i === 'number' ?
		                i : 0;
		    };
		
		    // Total over all pages
		    total = api
		        .column( 4 )
		        .data()
		        .reduce( function (a, b) {
		            return intVal(a) + intVal(b);
		        }, 0 );
		
		    // Total over this page
		    pageTotal = api
		        .column( 4, { page: 'current'} )
		        .data()
		        .reduce( function (a, b) {
		            return intVal(a) + intVal(b);
		        }, 0 );
		
		    // Update footer
		    $( api.column( 4 ).footer() ).html(
		        'Rs.'+pageTotal +' ( Rs.'+ total +' total)'
		    );
		}


	});*/


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
		},

		footerCallback: function ( row, data, start, end, display ) {
		    var api = this.api(), data;
		
		    // Remove the formatting to get integer data for summation
		    var intVal = function ( i ) {
		        return typeof i === 'string' ?
		            i.replace(/[\$,]/g, '')*1 :
		            typeof i === 'number' ?
		                i : 0;
		    };
		
		    // Total over all pages
		    total = api
		        .column( 5 )
		        .data()
		        .reduce( function (a, b) {
		            return intVal(a) + intVal(b);
		        }, 0 );
		
		    // Total over this page
		    pageTotal = api
		        .column( 5, { page: 'current'} )
		        .data()
		        .reduce( function (a, b) {
		            return intVal(a) + intVal(b);
		        }, 0 );
		
		    // Update footer
		    $( api.column( 5 ).footer() ).html(
		        'Rs.'+pageTotal +' ( Rs.'+ total +' total)'
		    );
		}


	});
});
	</script>
</body>
</html>