/* FILL DROP DOWN OPTION TO SELECT BRANCH IN "dashbord.php" -> PANE STAFF*/
	function fillBranchSelector(){
		$form_branch_selector_staff = $('#form_branch_selector_staff'); 
		args = {'tutionId':tution,'func':'fillBranchSelector'};
		//console.log(args);
		$.ajax({
			url:'../processes/staff.process.php',
			method:'POST',
			data:args,
			success:function(data){
				$form_branch_selector_staff.html(data);
			}
		});
	}
/* \.FILL DROP DOWN OPTION TO SELECT BRANCH IN "dashbord.php" -> PANE STAFF */

/* FILL DROP DOWN OPTION TO SELECT COURSE IN "dashbord.php" -> PANE STAFF */
	/*function fillStdSelector(){
		$form_std_selector_staff = $('#form_std_selector_staff'); 
		args = {'tutionId':tution,'func':'fillStdSelector'};
		//console.log(args);
		$.ajax({
			url:'../processes/staff.process.php',
			method:'POST',
			data:args,
			success:function(data){
				$form_std_selector_staff.html(data);
			}
		});
	}*/
/* \.FILL DROP DOWN OPTION TO SELECT COURSE IN "dashbord.php" -> PANE STAFF */

/* FILL TABLE BODY WITH STAFF DATA IN "dashbord.php" -> PANE STAFF*/
	function filterStaffData(){
		//alert('filterStudData');
		var $data = $('#form_branch_selector_staff').serializeArray();
		var $data2 = $('#form_std_selector_staff').serializeArray();
		var $data  = $data.concat($data2);
		//console.log($data);
		$data.push({name:'search_filter',value:$('#search_filter_textbox_staff').val()},{name:'func', value:'displayStaff'},{name:'tutionId',value:tution});
		//console.log($data);
		//console.log($data2);
		$.ajax({
			url:'../processes/staff.process.php',
			method:'POST',
			data:$data,
			success:function(data){
				//alert(data);
				$('#staff_data').html(data);
			}
		});
	}
/* \.FILL TABLE BODY WITH STAFF DATA IN "dashbord.php" -> PANE STAFF*/

/* INSERT STAFF DATA IN DATABASE from "dashboard.php" -> PANE STAFF */
	function insertStudent(){
		var counter = 1;
		var result = 0;
		var regexp_email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		var regexp_phn = /^[0-9]{10}$/;
		var regexp_num = /\d/;
		n=0;
		$('#staff_form .input').each(function(){
			//console.log($(this).attr('class')+' - '+$(this).val());

			// Branch selector
			if ( $(this).attr('class') == 'staff_branch input' && $(this).val() == null){
				$(this).next().html('Please Select!');
				counter = 0;
				//result = result - 1;
			}

			// name textbox
			if($(this).attr('class') == 'staff_name input'){
				console.log($(this).val().length);

				if( $(this).val().length <= 1){
					//console.log($(this).next().attr('class'));
					// $(this).next().html('Can\'t be empty!');
					$(this).next().html("Can't be empty!");
				}
				else{
					if (regexp_num.test($(this).val())) {
						$(this).next().html('Only alphabets are allowed!');
						counter = 0;  //result = result - 1;
					}
					else if ($(this).val().length <= 2) {
						$(this).next().html('Name is too Short!');
						counter = 0;
						//result = result - 1;
					}
				}
			}

			// middle name textbox
			if ( $(this).attr('class') == 'staff_middle_name input'){
				if( $(this).val() == ''){
					$(this).next().html('Can\'t be Empty!');
				}
				else{
					if (regexp_num.test($(this).val())) {
						$(this).next().html('Only alphabets are allowed!');
						counter = 0;//result = result - 1;
					}
					/*else if ($(this).val().length <= 2) {
						$(this).next().html('Name is too Short!');
						counter = 0;
						//result = result - 1;
					}*/
				}
			}

			// Gender selector
			if ( $(this).attr('class') == 'staff_sex input' && $(this).val() == null){
				$(this).next().html('Please Select!');
				counter = 0;
				//result = result - 1;
			}

			// phone textbox
			if ($(this).attr('class') == 'staff_phn input') {
				//console.log('class - s_phn input '+$(this).attr('class')+' '+ regexp_phn.test($(this).val()));
				if (!regexp_phn.test($(this).val())) {
					//$(this).next().html('Only numbers are allowed!');
					$(this).next().html('Invalid Phone No.!');
					counter = 0;
				}
				if( $(this).val().length != 10 && regexp_phn.test($(this).val())){
					$(this).next().html('Invalid Phone No.!');
					counter = 0;
				}
			}

			// email textbox
			if ($(this).attr('class') == 'staff_email input' ){
				//console.log('class - s_total_fees input '+ regexp_num.test($(this).val()));
				if (!regexp_email.test($(this).val())) {
					$(this).next().html('Invalid Email-Id !');
					counter = 0;
					//result = result - 1;
				}
			}

			// total fees textbox
			if ($(this).attr('class') == 'staff_total_salary input' ){
				//console.log('class - s_total_fees input '+ regexp_num.test($(this).val()));
				if ( !regexp_num.test($(this).val())) {
					$(this).next().html('Only numbers are allowed!');
					counter = 0;
					//result = result - 1;
				}
			}

			// fees paid textbox
			if ($(this).attr('class') == 'staff_salary_paid input' ){
				//console.log('class - s_fees_paid input '+ regexp_num.test($(this).val()));
				if (!regexp_num.test($(this).val())) {
					$(this).next().html('Only numbers are allowed!');
					counter = 0;
					//result = result - 1;
				}
			}

			if ($(this).attr('class') == 'staff_doj input'){
				var selectedDate = new Date($(this).val());	// User Selected date
				var currentDate = new Date();	// System current date

					// if date is not selected current date will be selected
				if (selectedDate == 'Invalid Date') {
					var date = currentDate.getFullYear()+'-'+currentDate.getMonth()+'-'+currentDate.getDate();
					$(this).attr('value',date);
					//alert($(this).attr('value'));
				}
			}

			if (counter){
				$(this).next().html('');
				result = result + 1;
			}
			counter = 1;
			//console.log(regexp_num.test($(this).val()));
		});
		//console.log('result - '+result+' ; length - '+ $('#student_form .input').length);
		
		if (result == ($('#staff_form .input').length)){
			$('#staff_form .input').each(function(){
				$(this).next().html('');
			});
			var date = new Date();
			staff_doj = date.getFullYear()+'-'+date.getMonth()+'-'+date.getDate();
			
			$data = $('#staff_form').serializeArray();
			$data.push({name:'staff_doj',value:staff_doj},{name:'tutionId',value:tution},{name:'func',value:'insert_staff'});
			console.log($data);
			
			$.ajax({
				url:'../processes/staff.process.php',
				method:'POST',
				data:$data,
				success:function(data){
					//console.log(data);
					swal({
						title: "Done!",
						text: data,
						icon: "success",
					});
					//$('#resetbtn_staff_form').click();
					$('#display_ins_tbl').click();
					filterStaffData();
				}
			});
		}
	}
/* \.INSERT STAFF DATA IN DATABASE from "dashboard.php" -> PANE STAFF */

/* DELETE STAFF FROM DATABASE */
	function deleteStaff(stafftId){
		data = {'staffId':stafftId, 'func':'delete_staff'};
		swal({
			title: "Are you sure?",
			text: "Once deleted, you will not be able to recover it again!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					url:'../processes/staff.process.php',
					method:'POST',
					data:data,
					success:function(data){
						//alert(data);
						swal("Record has been deleted!", {
							icon: "success",
						});
						filterStaffData();
					}
				});	
			}
			/*else{
				swal("Your data file is safe!");
			}*/
		});
	}
/* \.DELETE STAFF FROM DATABASE */

/* Edit Window */
	function editWindow(id,str){
		id = id.replace(/#/g,"-");
		// window.open('URl','_blank','features','replace')
		if (str == 'staff'){
			window.open('staff.edit.php?profile='+id+'','_blank','height=650,width=1100,toolbar=no');
		}
		if (str == 'student'){
			window.open('student.edit.php?profile='+id+'','_blank','height=650,width=1000,toolbar=no,location=no,left=10px');
		}
	}
/* \.Edit Window */


$('#pane_staff').ready(function(){
	
	fillBranchSelector();
	//fillStdSelector();
	filterStaffData();

	$('body').click(function(e){
		if ($(e.target).attr('id') == 'btn_branch_selector_staff' || $(e.target).attr('id') == 'btn_std_selector_staff' || $(e.target).attr('class') == 'label' || $(e.target).attr('class') == 'checkbox' || $(e.target).attr('class') == undefined && $(e.target).attr('id') == undefined) {
			return;
		}else{
			$('#branch_selector_staff').slideUp();
			$('#std_selector_staff').slideUp();
		}
	});

	$('#btn_branch_selector_staff').click(function(){
		$('#branch_selector_staff').slideToggle();
	});
	$('#btn_std_selector_staff').click(function(){
		$('#std_selector_staff').slideToggle();
	});

	$('#display_ins_tbl_staff').click(function(){
		$('#ins_staff_div').slideToggle();
		scrollToggle();
		$('#staff1_std').focus();
	});

	temp = true;	// Flag for function scrollToggle()
	add_sutd_flag = true;
	function scrollToggle(){
		if(temp){
			$('#staff_form_container').css({'overflow-x':'scroll'});
			temp = false;
			if(add_sutd_flag){
				add_staff();
				add_sutd_flag = false;
			}
		}
		else{
			$('#staff_form_container').css({'overflow-x':'hidden'});
			temp = true;
		}
	}

});