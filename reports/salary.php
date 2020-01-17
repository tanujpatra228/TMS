<?php
include'../includes/connect.inc.php';
include'../fsins.php';

$conn = connection('tms');


# Fill branch_selector in dashboard.php -> PANE STUDENT
	function fillBranchSelector($conn){
		$q = "SELECT branchId, address FROM tbl_branch WHERE tutionId LIKE '".$_POST['tutionId']."' ORDER BY branchId";
		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
		echo'<option disabled value="0" selected>Select Branch</option>';
		foreach ($result as $branch) {
			//echo'<span class="options"><label class="label"><input type="checkbox" class="checkbox" name="branch" value="'.$branch['branchId'].'"/> '.$branch['address'].'</label></span>';
			echo'<option value="'.$branch['branchId'].'">'.$branch['address'].'</option>';
		}
	}
#------------------------------------------------------

# FETCH STAFF OF SELECTED BRANCH
	function fillStaffSelector($conn){
		$tutionId = $_POST['tutionId'];
		$branchId = $_POST['branchId'];

		$q = "SELECT * FROM tbl_staff
		WHERE tbl_staff.branchId LIKE '$branchId'
		AND tbl_staff.tutionId LIKE '$tutionId'";
		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
		echo '<option disabled selected value="0">Select Staff</option>';
		foreach ($result as $row) {
			echo '<option value="'.$row['staffId'].'">'.$row['name'].'</option>';
		}
	}
#------------------------------------------------------

# SEARCH SALARY
	function searchData($conn){
		$i = 1;
		$tutionId = $_POST['tutionId'];
		$from_date = $_POST['from_date'];
		$to_date = $_POST['to_date'];

		if (isset($_POST['staffId'])) {
			$staffId = $_POST['staffId'];
		}
		else{
			$staffId = '%';
		}
		if (isset($_POST['branchId'])) {
			$branchId = $_POST['branchId'];
		}
		else{
			$branchId = '%';
		}

		$q = "SELECT tbl_salary.date,tbl_staff.name, tbl_staff.totalSalary, tbl_salary.amt ,tbl_branch.address as baddress FROM tbl_staff, tbl_salary, tbl_branch
		WHERE tbl_salary.staffId = tbl_staff.staffId
		AND tbl_staff.branchId = tbl_branch.branchId
		AND tbl_salary.tutionId LIKE '$tutionId'
        AND tbl_staff.staffId LIKE '$staffId'
        AND tbl_staff.branchId LIKE '$branchId'
        AND tbl_salary.date BETWEEN '$from_date' AND '$to_date'
        ORDER BY tbl_salary.Id DESC";

		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));

		echo'<div class="row">';
			if (isset($_POST['staffId'])) {
				$q_unpaid = "SELECT name,tbl_branch.address, SUM(attendence) AS Present,totalSalary, FORMAT((totalSalary*SUM(attendence)/30),2) AS Amt 
					FROM tbl_attendence, tbl_staff, tbl_branch 
					WHERE tbl_attendence.Id = tbl_staff.staffId 
					AND tbl_branch.branchId = tbl_staff.branchId 
					AND tbl_attendence.tutionId LIKE '$tutionId' 
					AND tbl_staff.staffId LIKE '$staffId'
					AND tbl_attendence.date BETWEEN '2019-03-01' AND '2019-04-30' 
					GROUP BY Id";
					$result_os = mysqli_query($conn, $q_unpaid) or die(mysqli_error($conn));
					$result_os = mysqli_fetch_array($result_os);
				echo'<div class="col-md-12">';
					echo'<p style="font-size:19px;margin-bottom:7px;">Current Month Calculation</p>';
					echo'<p style="margin-bottom:7px;">Name: '.$result_os['name'].'</p>';
					echo'<p style="margin-bottom:7px;">Branch: '.$result_os['address'].'</p>';
					echo'<p style="margin-bottom:7px;">Present Days: '.$result_os['Present'].'</p>';
					echo'<p style="margin-bottom:7px;">Total Salary: '.$result_os['totalSalary'].'</p>';
					echo'<p style="margin-bottom:7px;">Net Salary: '.$result_os['Amt'].'</p>';
				echo'</div>';
			}
		echo'<div class="col-md-12">';
			echo'<p style="font-size:21px;margin-bottom:7px;margin-top:17px;">Last Paid</p>';
		echo'</div>';
		echo'<div class="col-md-12">';
		echo'<table class="table table-bordered" style="width:100%">';
			echo'<thead>';
				echo'<tr>';
					echo'<th>#</th>';
					echo'<th>Date</th>';
					echo'<th>Name</th>';
					echo'<th>Branch</th>';
					echo'<th>Amount</th>';
					echo'<th>Total</th>';
				echo'</tr>';
			echo'</thead>';

			echo'<tbody>';
			$num = mysqli_num_rows($result);
			if ($num > 0) {
				foreach ($result as $row) {
					echo '<tr>';
						echo'<td>'.$i.'</td>';
						echo'<td>'.$row['date'].'</td>';
						echo'<td>'.$row['name'].'</td>';
						echo'<td>'.$row['baddress'].'</td>';
						echo'<td>'.$row['amt'].'</td>';
						echo'<td>'.$row['totalSalary'].'</td>';
					echo '</tr>';
					$i += 1;
				}
			}
			else{
				echo'<tr>';
				echo'<td colspan="6" class="text-center">No Records Found</td>';
				echo'</tr>';
			}
			echo'</tbody>';

		echo'</table>';
		echo'</div>';
		echo'</div>';

		/*echo"<scritp>
			$(document).ready(function(){
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
				});
		</script>";*/
		
	}
#------------------------------------------------------

# FETCH TOTAL SALARY
	function fetchTotalSalary($conn){
		$staffId = $_POST['staffId'];
		//echo'alert("'.$staffId.'");';
		$q = "SELECT totalSalary FROM tbl_staff WHERE staffId LIKE '$staffId'";
		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
		$row = mysqli_fetch_array($result);

		echo $row['totalSalary'];
	}
#------------------------------------------------------

# Fill "std_selector" in dashboard.php -> PANE STUDENT
	/*function fillStdSelector($conn){
		$q = "SELECT course FROM tbl_tution WHERE tutionId LIKE '".$_POST['tutionId']."'";
		$result = mysqli_query($conn, $q);
		$r = mysqli_fetch_array($result);
		$courses = preg_split("/:/",$r['course']);
		
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
		$result = mysqli_query($conn, $q);

		if (isset($_REQUEST['calling_func'])){
			foreach ($result as $course) {
				echo '<option value="'.$course['short_name'].'" style="color:#111;">'.$course['name'].'</option>';
			}
		}else{
			foreach ($result as $course) {
				echo'<span class="options"><label><input type="checkbox" class="checkbox" name="course" value="'.$course['short_name'].'" onclick="filterStudData();"> '.$course['name'].'</label></span>';
			}
		}
		
		//echo'<script>console.log("'.$q.'");</script>';
	}*/
#------------------------------------------------------


# FETCH LAST 5 SALARY TRANSACTION
	function lastSalary($conn){
		$tutionId = $_POST['tutionId'];
		$q = "SELECT tbl_staff.*, tbl_salary.*, tbl_branch.address as baddress FROM tbl_staff, tbl_salary, tbl_branch
		WHERE tbl_salary.staffId = tbl_staff.staffId
		AND tbl_staff.branchId = tbl_branch.branchId
		AND tbl_salary.tutionId LIKE'".$tutionId."' ORDER BY Id DESC;";
		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
		$num = mysqli_num_rows($result);
		if ($num > 5 ) {
			for ($i=0; $i <= 5 ; $i++) { 
				$row = mysqli_fetch_array($result);
				echo '<tr>';
				echo'<th>'.$row['date'].'</th>';
				echo'<th>'.$row['name'].'</th>';
				echo'<th>'.$row['baddress'].'</th>';
				echo'<th>'.$row['amt'].'</th>';
				echo'<th>'.$row['totalSalary'].'</th>';	
				echo'<th>'.$row['totpaid'].'</th>';	
				echo '</tr>';
			}
		}
		else{
			foreach ($result as $row) {
				echo '<tr>';
				echo'<th>'.$row['date'].'</th>';
				echo'<th>'.$row['name'].'</th>';
				echo'<th>'.$row['baddress'].'</th>';
				echo'<th>'.$row['amt'].'</th>';
				echo'<th>'.$row['totalSalary'].'</th>';	
				echo'<th>'.$row['totpaid'].'</th>';	
				echo '</tr>';
			}
		}
	}
#------------------------------------------------------


$func = $_REQUEST['func'];
$func($conn);
mysqli_close($conn);
?>