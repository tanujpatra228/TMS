<?php

include'../includes/connect.inc.php';
$conn = connection('tms');

function fetchExpense($conn){
	$tutionId = $_POST['tutionId'];

	$q = "SELECT tbl_expense.*,tbl_branch.address AS baddress FROM tbl_expense, tbl_branch
		WHERE tbl_expense.branchId = tbl_branch.branchId
		AND tbl_expense.tutionId LIKE '$tutionId'
		ORDER BY date DESC LIMIT 10";
	$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
	$i = 1;
	foreach ($result as $expense) {
		echo'<tr id="exp'.$i.'">';
		echo'<td><input type="hidden" value="'.$expense['id'].'" name="exp_id" class="input exp_id" />'.$i.'</td>';
		echo'<td><input txpe="text" value="'.$expense['baddress'].'" name="exp_branch" class="input exp_branch" disabled/></td>';
		echo'<td><input type="text" value="'.$expense['expense'].'" name="exp_name" class="input exp_name" disabled/></td>';
		echo'<td><input type="text" value="'.$expense['amt'].'" name="exp_amt" class="input exp_amt" disabled/></td>';
		echo'<td><input type="text" value="'.$expense['remark'].'" name="exp_remark" class="input exp_remark" disabled/></td>';
		echo'<td><button class="btn btn-info btn-sm edit_branch" onclick="makeEditable(\'#exp'.$i.'\');"><span class="glyphicon glyphicon-edit"></span></button>&nbsp;<button class="btn btn-danger btn-sm" onclick="deleteExpense('.$expense['id'].');"><span class="glyphicon glyphicon-trash"></span></button></td>';
		echo'</tr>';
		$i++;
	}
}


function addExpense($conn){
	$tutionId = $_POST['tutionId'];

	$values = '';
	$i = 0;
	foreach ($_POST['exp_name'] as $expense) {
		if ($values == '') {
			$values .= "('".$tutionId."','".$_POST['exp_branch'][$i]."','".$expense."','".$_POST['exp_amt'][$i]."','".$_POST['exp_remark'][$i]."','".$_POST['date']."')";
		}
		else{
			$values .= ",('".$tutionId."','".$_POST['exp_branch'][$i]."','".$expense."','".$_POST['exp_amt'][$i]."','".$_POST['exp_remark'][$i]."','".$_POST['date']."')";
		}
		$i++;
	}
	$q = "INSERT INTO tbl_expense(tutionId,branchId,expense,amt,remark,`date`) VALUES $values";
	$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
	if ($result > 0) {
		echo "record added.";
	}
	else{
		echo 0;
	}
}

# update associated branch 
	function updateExpense($conn){
		$tutionId = $_POST['tutionId'];
		//$branchId = $_POST['branchId'];
		$exp_id = mysqli_real_escape_string($conn, $_POST['exp_id']);
		$branchId = mysqli_real_escape_string($conn, $_POST['exp_branch']);
		$name = mysqli_real_escape_string($conn, $_POST['exp_name']);
		$amt = mysqli_real_escape_string($conn, $_POST['exp_amt']);
		$remark = mysqli_real_escape_string($conn, $_POST['exp_remark']);
		$upd_branch = "UPDATE tbl_expense SET expense = '".$name."', amt = '".$amt."', remark = '".$remark."' WHERE tbl_expense.branchId LIKE '".$branchId."' AND tbl_expense.id LIKE '".$exp_id."'";
		$result = mysqli_query($conn, $upd_branch) or die(mysqli_error($conn));
		if ($result > 0) {
			echo 'Expense data Updated.';
		}
		else{
			echo 0;
		}
	}
# --------------------------------------------------------------------------------------


$func = $_REQUEST['func'];
$func($conn);

mysqli_close($conn);
?>