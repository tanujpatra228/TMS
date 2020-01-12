/* FILL DROP DOWN OPTION TO SELECT BRANCH IN "dashbord.php" -> PANE SALARY*/
	function fillBranchSelector(){
		$form_branch_salary = $('#form_branch-salary');
		args = {'tutionId':tution,'func':'fillBranchSelector'};
		console.log(args);
		$.ajax({
			url:'../processes/salary.process.php',
			method:'POST',
			data:args,
			success:function(data){
				$form_branch_salary.html(data);
				$form_branch_salary.focus();
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
			url:'../processes/salary.process.php',
			method:'POST',
			data:args,
			success:function(data){
				//alert(data);
				$form_staff_salary.html(data);
			}
		});
	}
/* \.FILL DROP DOWN OPTION TO SELECT STAFF IN "dashbord.php" -> PANE SALARY */

function lastSalary(){
	var $salary_data_field = $('#salary_data_field');
	var args = {'tutionId':tution,'func':'lastSalary'};
	$.ajax({
		url:'../processes/salary.process.php',
		method:'POST',
		data:args,
		success:function(data){
			//alert(data);
			$salary_data_field.html(data);
		}
	});
}

/* FILL DROP DOWN OPTION TO SELECT COURSE IN "dashbord.php" -> PANE STUDENT */
	/*function fillStdSelector(){
		$form_std_salary = $('#form_std-salary'); 
		args = {'tutionId':tution,'func':'fillStdSelector'};
		//console.log(args);
		$.ajax({
			url:'../processes/salary.process.php',
			method:'POST',
			data:args,
			success:function(data){
				$form_std_salary.html(data);
			}
		});
	}*/
/* \.FILL DROP DOWN OPTION TO SELECT COURSE IN "dashbord.php" -> PANE STUDENT */


$('#pane_salary').ready(function(){
	
	fillBranchSelector();
	lastSalary();
	// datepicker
	var currentDate = new Date();
	if (currentDate.getDate() < 10) {day = '0'+currentDate.getDate();}else{day = currentDate.getDate();}
	if (currentDate.getMonth() < 10) {month = '0'+(currentDate.getMonth()+1);}else{month = (currentDate.getMonth()+1);}
	$('#salary_date').attr('value',currentDate.getFullYear()+'-'+month+'-'+day);
	$('#salary_date').datepicker({
		dateFormat:'yy-mm-dd',
	});

	// $('#table').dataTable();
	$('#salary_data_field').ready(function(){
		lastSalary();
	});

	$('#form_staff-salary').on('change',function(){
		 var args = ({'func':'fetchTotalSalary','staffId':$(this).val()});
		 //console.log(args);
		 $.ajax({
		 	url:'../processes/salary.process.php',
		 	method:'POST',
		 	data:args,
		 	success:function(data){
		 		console.log(data);
		 		$('#totSalary').attr('value',data);
		 	}
		 });
	});

	$('#save_salary').click(function(){
		//$salary_data_field = $('#salary_data_field');
		var data = $('#salary_form .input').serializeArray();
		data.push({name:'func',value:'saveSalary'},{name:'tutionId',value:tution});
		console.log(data);
		$.ajax({
			url:'../processes/salary.process.php',
			method:'POST',
			data:data,
			success:function(data){
				console.log(data);
				lastSalary();
			}
		});
		$('#form_branch-salary').focus();
	});

	$('#form_branch-salary').on('change', function(){
		fillStaffSelector();
	});

});