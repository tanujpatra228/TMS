
/* FILL DROP DOWN OPTION TO SELECT BRANCH IN "dashbord.php" -> PANE SALARY*/
	function fillBranchSelector(){
		$form_branch_salary = $('#form_branch-salary');
		args = {'tutionId':tution,'func':'fillBranchSelector'};
		console.log(args);
		$.ajax({
			url:'salary.php',
			method:'POST',
			data:args,
			success:function(data){
				$form_branch_salary.html(data);
			}
		});
	}
/* \.FILL DROP DOWN OPTION TO SELECT BRANCH IN "dashbord.php" -> PANE SALARY */

/* FILL DROP DOWN OPTION TO SELECT STAFF IN "dashbord.php" -> PANE SALARY*/
	function fillStaffSelector(){
		$form_staff_salary = $('#form_staff-salary');
		args = {'tutionId':tution,'func':'fillStaffSelector','branchId':$('#form_branch-salary').val()};
		//console.log(args);
		$.ajax({
			url:'salary.php',
			method:'POST',
			data:args,
			success:function(data){
				//alert(data);
				$form_staff_salary.html(data);
			}
		});
	}
/* \.FILL DROP DOWN OPTION TO SELECT STAFF IN "dashbord.php" -> PANE SALARY */


$(document).ready(function(){
	fillBranchSelector();
	//lastSalary();
	// datepicker
	var currentDate = new Date();
	if (currentDate.getDate() < 10) {day = '0'+currentDate.getDate();}else{day = currentDate.getDate();}
	if (currentDate.getMonth() < 10) {month = '0'+(currentDate.getMonth()+1);}else{month = (currentDate.getMonth()+1);}

	$('#from_date').attr('value',currentDate.getFullYear()+'-'+month+'-'+'0'+(day-day+1));
	$('#to_date').attr('value',currentDate.getFullYear()+'-'+month+'-'+day);
	
	$('#from_date').datepicker({
		dateFormat:'yy-mm-dd',
	});
	$('#to_date').datepicker({
		dateFormat:'yy-mm-dd',
	});

	// $('#table').dataTable();

	$('#btn_search').click(function(){
		//$salary_data_field = $('#salary_data_field');
		var data = $('#salary_report_form .input').serializeArray();
		data.push({name:'func',value:'searchData'},{name:'tutionId',value:tution});
		console.log(data);
		$.ajax({
			url:'salary.php',
			method:'POST',
			data:data,
			success:function(data){
				console.log(data);
				$('#default_table').html(data);
			}
		});
		//$('#form_branch-salary').focus();
	});

	$('#form_branch-salary').on('change', function(){
		fillStaffSelector();
	});

});