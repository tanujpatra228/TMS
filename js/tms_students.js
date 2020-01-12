/* FILL DROP DOWN OPTION TO SELECT BRANCH IN "dashbord.php" -> PANE STUDENT*/
	function fillBranchSelector(){
		$form_branch_selector = $('#form_branch_selector'); 
		args = {'tutionId':tution,'func':'fillBranchSelector'};
		//console.log(args);
		$.ajax({
			url:'../processes/student.process.php',
			method:'POST',
			data:args,
			success:function(data){
				$form_branch_selector.html(data);
			}
		});
	}
/* \.FILL DROP DOWN OPTION TO SELECT BRANCH IN "dashbord.php" -> PANE STUDENT */

/* FILL DROP DOWN OPTION TO SELECT COURSE IN "dashbord.php" -> PANE STUDENT */
	function fillStdSelector(){
		$form_std_selector = $('#form_std_selector'); 
		args = {'tutionId':tution,'func':'fillStdSelector'};
		//console.log(args);
		$.ajax({
			url:'../processes/student.process.php',
			method:'POST',
			data:args,
			success:function(data){
				$form_std_selector.html(data);
			}
		});
	}
/* \.FILL DROP DOWN OPTION TO SELECT COURSE IN "dashbord.php" -> PANE STUDENT */

/* FILL DROP DOWN OPTION TO SELECT COURSE IN "dashbord.php" -> PANE STUDENT */
	function fillStdSelector_ins(){
		$form_std_selector = $('#form_std_selector'); 
		args = {'tutionId':tution,'func':'fillStdSelector','calling_func':'fillStdSelector_ins'};
		//console.log(args);
		$.ajax({
			url:'../processes/student.process.php',
			method:'POST',
			data:args,
			success:function(data){
				$form_std_selector.html(data);
			}
		});
	}
/* \.FILL DROP DOWN OPTION TO SELECT COURSE IN "dashbord.php" -> PANE STUDENT */

/* FILL TABLE BODY WITH STUDENT DATA IN "dashbord.php" -> PANE STUDENT*/
	function filterStudData(){
		//alert('filterStudData');
		var $data = $('#form_branch_selector').serializeArray();
		var $data2 = ($('#form_std_selector').serializeArray());
		var $data  = $data.concat($data2);
		//console.log($data);
		$data.push({name:'search_filter',value:$('#search_filter_textbox').val()},{name:'func', value:'displayStudents'},{name:'tutionId',value:tution});
		//console.log($data);
		//console.log($data2);
		$.ajax({
			url:'../processes/student.process.php',
			method:'POST',
			data:$data,
			success:function(data){
				//alert(data);
				$('#student_data').html(data);
			}
		});
	}
/* \.FILL TABLE BODY WITH STUDENT DATA IN "dashbord.php" -> PANE STUDENT*/

/* INSERT STUDENT DATA IN DATABASE from "dashboard.php" -> PANE STUDENT */
	function insertStudent(){
		var counter = 1;
		var result = 0;
		var regexp_email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		var regexp_phn = /^[0-9]{10}$/;
		var regexp_num = /\d/;
		n=0;
		$('#student_form .input').each(function(){
			//console.log($(this).attr('class')+' - '+$(this).val());
				
				//	Std selector
				if ( $(this).attr('class') == 'input s_std' && $(this).val() == null){
					$(this).next().html('Please Select!');
					counter = 0;
				}
				

				// Branch selector
				if ( $(this).attr('class') == 's_branch input' && $(this).val() == null){
					$(this).next().html('Please Select!');
					counter = 0;
					//result = result - 1;
				}
				

				// name textbox
				if ( $(this).attr('class') == 's_name input'){
					
					if( $(this).val() == ''){
						$(this).next().html('Can\'t be Empty!');
					}
					else{
						if (regexp_num.test($(this).val())) {
							$(this).next().html('Only alphabets are allowed!');
							counter = 0;//result = result - 1;
						}
						else if ($(this).val().length <= 2) {
							$(this).next().html('Name is too Short!');
							counter = 0;
							//result = result - 1;
						}
						
					}
				}

				// father name textbox
				if ( $(this).attr('class') == 's_father_name input'){
					if( $(this).val() == ''){
						$(this).next().html('Can\'t be Empty!');
					}
					else{
						if (regexp_num.test($(this).val())) {
							$(this).next().html('Only alphabets are allowed!');
							counter = 0;//result = result - 1;
						}
						else if ($(this).val().length <= 2) {
							$(this).next().html('Name is too Short!');
							counter = 0;
							//result = result - 1;
						}
						
					}
				}

				// Gender selector
				if ( $(this).attr('class') == 's_sex input' && $(this).val() == null){
					$(this).next().html('Please Select!');
					counter = 0;
					//result = result - 1;
				}

				// phone textbox
				if ($(this).attr('class') == 's_phn input') {
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
				if ($(this).attr('class') == 's_email input' ){
					//console.log('class - s_total_fees input '+ regexp_num.test($(this).val()));
					if (!regexp_email.test($(this).val())) {
						$(this).next().html('Invalid Email-Id !');
						counter = 0;
						//result = result - 1;
					}
				}

				// total fees textbox
				if ($(this).attr('class') == 's_total_fees input' ){
					//console.log('class - s_total_fees input '+ regexp_num.test($(this).val()));
					if ( !regexp_num.test($(this).val())) {
						$(this).next().html('Only numbers are allowed!');
						counter = 0;
						//result = result - 1;
					}
				}

				// fees paid textbox
				if ($(this).attr('class') == 's_fees_paid input' ){
					//console.log('class - s_fees_paid input '+ regexp_num.test($(this).val()));
					if (!regexp_num.test($(this).val())) {
						$(this).next().html('Only numbers are allowed!');
						counter = 0;
						//result = result - 1;
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
		
		if (result == ($('#student_form .input').length)){
			$('#student_form .input').each(function(){
				$(this).next().html('');
			});
			$data = $('#student_form').serializeArray();
			$data.push({name:'tutionId',value:tution},{name:'func',value:'insert_student'});
			//console.log($data);
			
			$.ajax({
				url:'../processes/student.process.php',
				method:'POST',
				data:$data,
				success:function(data){
					//console.log(data);
					swal({
						title: "Done!",
						text: data,
						icon: "success",
					});
					$('#resetbtn_student_form').click();
					$('#display_ins_tbl').click();
					filterStudData();
				}
			});
		}
	}
/* \.INSERT STUDENT DATA IN DATABASE from "dashboard.php" -> PANE STUDENT */

/* DELETE STUDENT FROM DATABASE */
	function deleteStudent(studentId){
		data = {'studentId':studentId, 'func':'delete_student'};
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
					url:'../processes/student.process.php',
					method:'POST',
					data:data,
					success:function(data){
						//alert(data);
						swal("Record has been deleted!", {
							icon: "success",
						});
						filterStudData();
					}
				});
				
			}
			/*else{
				swal("Your data file is safe!");
			}*/
		});
	}
/* \.DELETE STUDENT FROM DATABASE */

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

$('#pane_student').ready(function(){
	
	fillBranchSelector();
	fillStdSelector();
	filterStudData();

	$('body').click(function(e){
		if ($(e.target).attr('id') == 'btn_branch_selector' || $(e.target).attr('id') == 'btn_std_selector' || $(e.target).attr('class') == 'label' || $(e.target).attr('class') == 'checkbox' || $(e.target).attr('class') == undefined && $(e.target).attr('id') == undefined) {
			return;
		}else{
			$('#branch_selector').slideUp();
			$('#std_selector').slideUp();
		}
	});

	$('#btn_branch_selector').click(function(){
		$('#branch_selector').slideToggle();
	});
	$('#btn_std_selector').click(function(){
		$('#std_selector').slideToggle();
	});

	$('#display_ins_tbl').click(function(){
		$('#ins_student_div').slideToggle();
		scrollToggle();
		$('#s1_std').focus();
	});

	temp = true;	// Flag for function scrollToggle()
	add_sutd_flag = true;
	function scrollToggle(){
		if(temp){
			$('#student_form_container').css({'overflow-x':'scroll'});
			temp = false;
			if(add_sutd_flag){
				add_student();
				add_sutd_flag = false;
			}
		}
		else{
			$('#student_form_container').css({'overflow-x':'hidden'});
			temp = true;
		}
	}

});