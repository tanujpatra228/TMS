
// Function to fill Tution data in "dashboard.php" --> pane_profile
function fillStudentMarks(){
	var date = new Date();
	var day;
	if (date.getMonth() < 10) {month = '0'+date.getMonth();}
	if (date.getDate() < 10) {day = '0'+date.getDate();}
	if ($('#marks_date').val() == '') {date = date.getFullYear()+'-'+month+'-'+day;}else{date = $('#marks_date').val();}
	//date = $('#marks_date').val();//date.getFullYear()+'-'+month+'-'+date.getDate();
	var data = ({'func':'fetchMarks','tutionId':tution,'date':date});
	console.log(data);
	$.ajax({
		url:'../processes/marks.process.php',
		method:'POST',
		data:data,
		success:function(data){
			//alert(data);
			$('#student_marks_data').html(data); // UNCOMMENT
		}
	});
}
// \.Function to fill Tution data in "dashboard.php" --> pane_profile

function updateMarks(){
	var date = new Date();
	var month = '';
	if (date.getMonth() < 10) {month = '0'+date.getMonth();}else{month = date.getMonth();}
	date = date.getFullYear()+'-'+month+'-'+date.getDate();
	var data = $('#attendence_form_stud .input').serializeArray();
	data.push({name:'func', value:'updateMarks'},{name:'tutionId',value:tution},{name:'date',value:date});
	console.log(data);
	$.ajax({
		url:'../processes/marks.process.php',
		method:'POST',
		data:data,
		success:function(data){
			swal("Done", "records updated", "success");
		}
	});
}

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

$('#pane_prifile').ready(function(){
	
	fillStudentMarks();

	$('#img_logo').click(function(){
		$('#tution_logo').click();
	});

	$('#btn_branch_selector-marks').click(function(){
		$('#branch_selector-marks').slideToggle();
	});

	$('#btn_std_selector-marks').click(function(){
		
	});

	$('#upload_image').on('change',function(){

		alert('onchange');
		var property = document.getElementById('upload_image').files[0];
		var img_name = property.name;
		var img_extension = img_name.split(".").pop().toLowerCase();
		if(jQuery.inArray(img_extension, ['png','jpeg','jpg']) == -1){
			alert('Invalid Image Type!');
		}
		var img_size = property.size;
		if(img_size > 2000000){
			alert('File to Large!');
		}
		else{
			var form_data = new FormData();
			form_data.append('file', property);
			//property.append('func','save_logo');
			console.log(form_data);

			$.ajax({
				url:'../processes/tution.process.php?func=save_logo&tutionId='+tution,
				method:'POST',
				data:form_data,
				contentType:false,
				cache:false,
				processData:false,
				success:function(data){
					console.log(data);
					alert(data);
					$('#uploaded_image').html(data);
				}
				/*error:function(data){
					console.log('error');
					console.log(data);
					alert(data);
				}*/
			});
		}
	});


	var readURL = function(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            $('.avatar').attr('src', e.target.result);
	        }
	
	        reader.readAsDataURL(input.files[0]);
	    }
	}
	
	$(".file-upload").on('change', function(){
	    readURL(this);
	});

	$('#save_stud_marks').click(function(){
		updateMarks();
	});

	$("#marks_date").datepicker({
		dateFormat: 'yy-mm-dd',
	        autoclose: true, 
	        todayHighlight: true
	  });
});

function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$('#uploaded_image').css({'background-image':'url('+e.target.result+')'});
		};

		reader.readAsDataURL(input.files[0]);
	}
}