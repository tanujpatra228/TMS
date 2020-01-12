/* FILL DROP DOWN OPTION TO SELECT BRANCH IN "dashbord.php" -> PANE ATTENDENCE*/
	function fillBranchSelector_att(){
		$form_branch_selector = $('#form_branch_selector-att'); 
		args = {'tutionId':tution,'func':'fillBranchSelector'};
		//console.log(args);
		$.ajax({
			url:'../processes/attendence.process.php',
			method:'POST',
			data:args,
			success:function(data){
				//console.log(data);
				$form_branch_selector.html(data);
			}
		});
	}
/* \.FILL DROP DOWN OPTION TO SELECT BRANCH IN "dashbord.php" -> PANE ATTENDENCE */

/* FILL DROP DOWN OPTION TO SELECT COURSE IN "dashbord.php" -> PANE ATTENDENCE */
	function fillStdSelector_att(){
		$form_std_selector = $('#form_std_selector-att'); 
		args = {'tutionId':tution,'func':'fillStdSelector'};
		//console.log(args);
		$.ajax({
			url:'../processes/attendence.process.php',
			method:'POST',
			data:args,
			success:function(data){
				$form_std_selector.html(data);
			}
		});
	}
/* \.FILL DROP DOWN OPTION TO SELECT COURSE IN "dashbord.php" -> PANE ATTENDENCE */

/* FILL TABLE BODY WITH STUDENT DATA IN "dashbord.php" -> PANE STUDENT*/
	function filterData(){
		//alert('filterStudData');
		var $data = $('#form_branch_selector-att').serializeArray();
		var $data2 = ($('#form_std_selector-att').serializeArray());
		$data = $data.concat($data2);
		//console.log($data);

		var currentDate = new Date();	// System current date
			// if date is not selected current date will be selected
		var month = currentDate.getMonth() + 1;
		if (month < 10) {month = '0'+month;}
		var date = currentDate.getFullYear()+'-'+month+'-'+currentDate.getDate();
		if ($('#date').val() == '' || $('#date').val() == date) {
			$('#date').attr('value',date);
			$data.push({name:'period',value:'today'},{name:'date',value:date},{name:'func', value:'displayStudents'},{name:'tutionId',value:tution});
		}
		else{
			$data.push({name:'period',value:'nottoday'},{name:'date',value:$('#date').val()},{name:'func', value:'displayStudents'},{name:'tutionId',value:tution});
		}

		//console.log($data);
		$.ajax({
			url:'../processes/attendence.process.php',
			method:'POST',
			data:$data,
			success:function(data){
				//alert(data);
				$('#student_attendence_data').html(data);
			}
		});
	}
/* \.FILL TABLE BODY WITH STUDENT DATA IN "dashbord.php" -> PANE ATTENDENCE*/



/* FILL DROP DOWN OPTION TO SELECT BRANCH IN "dashbord.php" -> PANE ATTENDENCE*/
	function fillBranchSelector_attStaff(){
		$form_branch_selector = $('#staff_form_branch_selector-att'); 
		args = {'tutionId':tution,'func':'fillBranchSelector_staff'};
		console.log(args);
		$.ajax({
			url:'../processes/attendence.process.php',
			method:'POST',
			data:args,
			success:function(data){
				//console.log(data);
				$form_branch_selector.html(data);
			}
		});
	}
/* \.FILL DROP DOWN OPTION TO SELECT BRANCH IN "dashbord.php" -> PANE ATTENDENCE */

/* FILL TABLE BODY WITH STAFF DATA IN "dashbord.php" -> PANE STUDENT*/
	function filterData_staff(){
		//alert('filterStudData');
		var $data = $('#staff_form_branch_selector-att').serializeArray();
		console.log($data);

		var currentDate = new Date();	// System current date
			// if date is not selected current date will be selected
		var month = currentDate.getMonth() + 1;
		if (month < 10) {month = '0'+month;}
		var date = currentDate.getFullYear()+'-'+month+'-'+currentDate.getDate();

		if ($('#staff_date').val() == "" || $('#staff_date').val() == date) {
			
			$('#staff_date').attr('value',date);
			$data.push({name:'period',value:'today'},{name:'date',value:date},{name:'func', value:'displayStaff'},{name:'tutionId',value:tution});
		}
		else{
			$data.push({name:'period',value:'nottoday'},{name:'date',value:$('#date').val()},{name:'func', value:'displayStaff'},{name:'tutionId',value:tution});
		}

		console.log($data);
		$.ajax({
			url:'../processes/attendence.process.php',
			method:'POST',
			data:$data,
			success:function(data){
				//alert(data);
				$('#staff_attendence_data').html(data);
			}
		});
	}
/* \.FILL TABLE BODY WITH STUDENT DATA IN "dashbord.php" -> PANE ATTENDENCE*/




$('#pane_attendence').ready(function(){
	fillBranchSelector_att();
	fillStdSelector_att();
	filterData();

	$('#btn_student').click(function(){
		$(this).addClass('active');
		$('#btn_staff').removeClass('active');

		$('#student_data').addClass('visible');
		$('#student_data').removeClass('invisible');
		$('#staff_data').removeClass('visible');
		$('#staff_data').addClass('invisible');
	});
		// dusplay satff section
	$('#btn_staff').click(function(){
		$(this).addClass('active');
		$('#btn_student').removeClass('active');

		$('#staff_data').addClass('visible');
		$('#staff_data').removeClass('invisible');
		$('#student_data').removeClass('visible');
		$('#student_data').addClass('invisible');

		fillBranchSelector_attStaff();
		filterData_staff();
	});

	$('body').click(function(e){
		if ($(e.target).attr('id') == 'btn_branch_selector-att' || $(e.target).attr('id') == 'btn_std_selector-att' || $(e.target).attr('class') == 'label' || $(e.target).attr('class') == 'checkbox' || $(e.target).attr('class') == undefined && $(e.target).attr('id') == undefined) {
			return;
		}else{
			$('#branch_selector-att').slideUp();
			$('#std_selector-att').slideUp();
		}
	});

	$('#btn_branch_selector-att').click(function(){
		$('#branch_selector-att').slideToggle();
	})
	;
	$('#btn_std_selector-att').click(function(){
		$('#std_selector-att').slideToggle();
	});


	$('#btn_staff_branch_selector-att').click(function(){
		$('#staff_branch_selector-att').slideToggle();
	});


	$('#save_stud_att').click(function(){
		var currentDate = new Date();	// System current date
			// if date is not selected current date will be selected
		var month = currentDate.getMonth() + 1;
		if (month < 10) {month = '0'+month;}
		if ($('#date').val() == '') {
			date = currentDate.getFullYear()+'-'+month+'-'+currentDate.getDate();
		}
		else{
			date = $('#date').val();
		}
		var data = $('#attendence_form_stud .input').serializeArray();
		data.push({name:'date',value:date},{name:'func', value:'takeAttendence'},{name:'tutionId',value:tution});
		console.log(data);
		$.ajax({
			url:'../processes/attendence.process.php',
			method:'POST',
			data:data,
			success:function(data){
				console.log(data);
				swal('Done','Attendence taken','success');
			}
		});
	});


	$('#save_staff_att').click(function(){
		var currentDate = new Date();	// System current date
			// if date is not selected current date will be selected
		var month = currentDate.getMonth() + 1;
		if (month < 10) {month = '0'+month;}
		if ($('#date').val() == '') {
			date = currentDate.getFullYear()+'-'+month+'-'+currentDate.getDate();
		}
		else{
			date = $('#date').val();
		}
		var data = $('#attendence_form_staff .input').serializeArray();
		data.push({name:'date',value:date},{name:'func', value:'takeAttendenceStaff'},{name:'tutionId',value:tution});
		console.log(data);
		$.ajax({
			url:'../processes/attendence.process.php',
			method:'POST',
			data:data,
			success:function(data){
				console.log(data);
				swal('Done','Staff Attendence taken','success');
			}
		});
	});


	var date = new Date();
	$("#date").datepicker({
		dateFormat: 'yy-mm-dd',
	        autoclose: true, 
	        todayHighlight: true,
	        minDate: date,
	        maxDate:date
	  });
	$("#staff_date").datepicker({
		dateFormat: 'yy-mm-dd',
	        autoclose: true, 
	        todayHighlight: true,
	        minDate: date,
	        maxDate:date
	  });
});