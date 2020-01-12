/* FETCH BRANCH */
	function fetchBranch(){
		var data = ({'func':'fetchBranch','tutionId':tution});
		console.log(data);
		$.ajax({
			url:'attendence.php',
			method:'POST',
			data:data,
			success:function(data){
				//alert(data);
				$('#form_branch-attendence').html(data);
			}
		});
	}
/* \FETCH BRANCH */

/* FETCH STAFF */
	function fetchStaff(){
		var data = ({'func':'fetchStaff','tutionId':tution,'branchId':$('#form_branch-attendence').val()});
		console.log(data);
		$.ajax({
			url:'attendence.php',
			method:'POST',
			data:data,
			success:function(data){
				//alert(data);
				$('#form_staff-attendence').html(data);
			}
		});
	}
/* \FETCH STAFF */

/* FETCH STUDENT */
	function fetchStudent(){
		var data = ({'func':'fetchStudent','tutionId':tution,'branchId':$('#form_branch-attendence').val()});
		console.log(data);
		$.ajax({
			url:'attendence.php',
			method:'POST',
			data:data,
			success:function(data){
				//alert(data);
				$('#form_student-attendence').html(data);
			}
		});
	}
/* \FETCH STUDENT */

$(document).ready(function(){
	fetchBranch();

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

	$('#form_branch-attendence').on('change',function(){
		fetchStaff();
		fetchStudent();
	});

	$('#form_staff-attendence').on('change',function(){
		fetchStudent();
	});
	$('#form_student-attendence').on('change',function(){
		fetchStaff();
	});

	$('#btn_search').click(function(){
		var data = $('#attendence_report_form .input').serializeArray();
		var date = new Date();
		if ($('#form_staff-attendence').val() == null && $('#form_student-attendence').val() == null) {
			alert('Select any [Staff / Student]');
		}
		else{
			data.push({name:'func',value:'searchData'},{name:'tutionId',value:tution},{name:'date',value:date.getDate()});
			console.log(data);
			$.ajax({
				url:'attendence.php',
				method:'POST',
				data:data,
				success:function(data){
					//alert(data);
					$('#default_table').html(data);
				}
			});
		}
	});
});