<?php
include'../includes/connect.inc.php';
include'../fsins.php';

$conn = connection('tms');

# FETCH EXPENSES
	function fetchExpense($conn){
		$tutionId = $_POST['tutionId'];
		$from_date = $_POST['from_date'];
		$to_date = $_POST['to_date'];

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
		$i = 1;
		foreach ($salary as $row) {
			echo '<tr>';
			echo '<td>'.$i.'</td>';
			echo '<td>'.$row['date'].'</td>';
			echo '<td>'.$row['baddress'].'</td>';
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
			echo '<td>Expense</td>';
			echo '<td>'.$row['amt'].'</td>';
			echo'</tr>';
			$i++;
		}
	}
#--------------------------------------------------------------

# FETCH INCOME
	function fetchIncome($conn){
		$tutionId = $_POST['tutionId'];
		$from_date = $_POST['from_date'];
		$to_date = $_POST['to_date'];

		$q = "SELECT tbl_fees.date, tbl_fees.amt,tbl_branch.address,tbl_student.std,tbl_student.name
			FROM tbl_fees, tbl_student,tbl_branch
			WHERE tbl_fees.studentId = tbl_student.studentId
			AND tbl_student.branchId = tbl_branch.branchId
			AND tbl_fees.tutionId LIKE '$tutionId'
			AND tbl_fees.date BETWEEN '$from_date' AND '$to_date'
			ORDER BY tbl_fees.date DESC";

		$income = mysqli_query($conn, $q) or die(mysqli_error($conn));
		$i = 1;
		foreach ($income as $row) {
			echo'<tr>';
			echo'<td>'.$i.'</td>';
			echo'<td>'.$row['date'].'</td>';
			echo'<td>'.$row['address'].'</td>';
			echo'<td>'.$row['std'].'</td>';
			echo'<td>'.$row['amt'].'</td>';
			echo'</tr>';
			$i++;
		}
	}
#--------------------------------------------------------------

$func = $_REQUEST['func'];
$func($conn);
mysqli_close($conn);
?>