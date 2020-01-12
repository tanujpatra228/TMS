$(document).ready(function(){

	var regexp_email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	
	function check_email(input_ele,error_span){
		email = $(input_ele);
		spanEmail = $(error_span);
		
		if ($.trim(email.val()).length == 0)
		{
			// alert('if1'+$.trim(email.val()).length);
			error_email = 'Email is required';
			spanEmail.text(error_email);
			email.addClass('error');
		}
		else
		{
			// alert('else1'+$.trim(email.val()).length);
			if (!regexp_email.test(email.val()))
			{
				// alert('if2');
				error_email = 'Invalid Email';
				spanEmail.text(error_email);
				email.addClass('error');
			}
			else
			{
				// alert('else2');
				error_email = '';
				spanEmail.text(error_email);
				email.removeClass('error');
			}
		}
	}

	function check_mobileNo(input_ele,error_span){
		
		mobile = $(input_ele);
		spanMobile = $(error_span);
		//alert('global cm'+$.trim(mobile.val()).length);

		if($.trim(mobile.val()).length == 0)
		{
			//alert('if'+$.trim(mobile.val()).length);
			error_mobile = 'Mobile no. is required';
			spanMobile.text(error_mobile);
			mobile.addClass('error');	
		}
		else
		{
			if($.trim(mobile.val()).length != 10)
			{
				//alert('step1 if2 '+$.trim(mobile.val()).length);
				error_mobile = 'Invalid Mobile no.';
				spanMobile.text(error_mobile);
				mobile.addClass('error');
			}
			else
			{
				error_mobile = '';
				spanMobile.text(error_mobile);
				mobile.removeClass('error');
			}
		}
	}

		//	not complete
	function check_phn(input_ele,error_span){
			//alert('cm'+$.trim(cphn.val()).length);
			cphn = $(input_ele);
			spanCphn = $(error_span);

			if($.trim(cphn.val()).length == 0)
			{
				//alert('if'+$.trim(cphn.val()).length);
				error_cphn = 'Phone/Mobile no. is required';
				spanCphn.text(error_cphn);
				cphn.addClass('error');	
			}
			else
			{
				if($.trim(cphn.val()).length != 10)
				{
					//alert('step1 if2 '+$.trim(cphn.val()).length);
					error_cphn = 'Invalid number';
					spanCphn.text(error_cphn);
					cphn.addClass('error');
				}
				else
				{
					error_cphn = '';
					spanCphn.text(error_cphn);
					cphn.removeClass('error');
				}
			}
	}

	$('#btn_step1_next').click(function(){
		
		var error_fname = '';
		var error_lanme = '';
		var error_email = '';
		var error_mobile = '';
		var error_pwd = '';
		var error_repwd = '';

		var regexp_num = /[0-9]/;
		var regexp_pwd = /[a-zA-Z0-9]/;

		var fname = $('#fname');
		var lname = $('#lname');
		var email = $('#email');
		var mobile = $('#mobile');
		var pwd = $('#pwd');
		var repwd = $('#repwd');

		var spanFname = $('#error-fname');
		var spanLname = $('#error-lname');
		var spanEmail = $('#error-email');
		var spanMobile = $('#error-mobile');
		var spanPwd = $('#error-pwd');
		var spanRepwd = $('#error-repwd');
		
		//alert('fname:'+fname.val()+'; lname:'+lname.val()+'; email:'+email.val()+'; mob:'+mobile.val()+'; pwd:'+pwd.val()+'; repwd:'+repwd.val());

		function check_name(){
			if ($.trim(fname.val()).length == 0)
			{
				error_fname = 'First name is required';
				spanFname.text(error_fname);
				fname.addClass('error');
			}
			else
			{
				if(regexp_num.test(fname.val()))
				{
					error_fname = 'Invalid Name';
					spanFname.text(error_fname);
					fname.addClass('error');
				}
				else
				{
					error_fname = '';
					spanFname.text(error_fname);
					fname.removeClass('error');
				}
			}

				// Validate Last Name
			if ($.trim(lname.val()).length == 0)
			{
				error_lname = 'Last name is required';
				spanLname.text(error_lname);
				lname.addClass('error');
			}
			else
			{
				if(regexp_num.test(lname.val()))
				{
					error_lname = 'Invalid Name';
					spanLname.text(error_lname);
					spanLname.removeClass('label label-warning');
					spanLname.addClass('text-danger');
					lname.addClass('error');
				}
				else
				{
					if(fname.val() == lname.val())
					{
						spanLname.text('Are you sure your First and Last names are same!');
						lname.removeClass('error');
						spanLname.addClass('label label-warning');
						spanLname.css({'font-size':'15px'});
					}
					else
					{
						error_lname = '';
						spanLname.text(error_lname);
						lname.removeClass('error');
						spanLname.removeClass('label label-warning');
						spanLname.removeClass('label label-warning');
						spanLname.addClass('error');
					}
				}
			}
		}

		function check_pwd(){
			if ($.trim(pwd.val()).length == 0)
			{
				error_pwd = 'you must create a Password!';
				spanPwd.text(error_pwd);
				pwd.addClass('error');
			}
			else
			{
				if ($.trim(pwd.val()).length < 8)
				{
					error_pwd = 'Password must be 8 charecters long';
					spanPwd.text(error_pwd);
					pwd.addClass('error');
				}
				else
				{
					if (pwd.val() != repwd.val())
					{
						error_repwd = 'Password must be same!';
						spanRepwd.text(error_repwd);
						pwd.addClass('error');
						repwd.addClass('error');
					}
					else
					{
						error_pwd = '';
						error_repwd ='';
						spanPwd.text(error_pwd);
						spanRepwd.text(error_repwd);
						pwd.removeClass('error');
						repwd.removeClass('error');
					}
				}
			}
		}

		check_name();
		check_email(email,spanEmail);
		check_mobileNo(mobile,spanMobile);
		check_pwd();


		// TAB CHANGE
			if (error_fname !='' || error_lname !='' || error_email !='' || error_mobile !='' || error_pwd !='' || error_repwd !='')
			{
				return false;
			}
			else
			{

				$('#link_step1').removeClass('active');
				$('#link_step1').addClass('inactive');
				$('#link_step2').removeClass('inactive');
				$('#link_step2').addClass('active');

				$('#pane_classes_detail').addClass('active');
				$('#pane_owner_detail').removeClass('active');
			}
	});

	$('#btn_step2_prev').click(function(){
		$('#link_step1').addClass('active');
		$('#link_step1').removeClass('inactive');
		$('#link_step2').addClass('inactive');
		$('#link_step2').removeClass('active');

		$('#pane_classes_detail').removeClass('active');	
		$('#pane_owner_detail').addClass('active');
	});

	$('#btn_step2_regi').click(function(){
		var error_cname = '';
		var error_caddress = '';
		//var error_ccountry = '';
		var error_cstate = '';
		var error_ccity = '';
		var error_cwebsite = '';
		var error_cphn = '';
		var regexp_url = /^([a-zA-Z0-9]{3})+\.(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,4})+$/i;
		var regexp_num = /[0-9]/;
		var regexp_alp = /[a-zA-Z]/;
		var regexp_pwd = /[a-zA-Z0-9]/;

		var cname = $('#class_name');
		var ctagline = $('#class_tagline');
		var caddress = $('#class_address');
		//var ccountry = $('#class_country');
		var cstate = $('#class_state');
		var ccity = $('#class_city');
		var cemail = $('#class_email');
		var cwebsite = $('#class_website');
		var cphn = $('#class_phn');

		var spanCname = $('#error-cname');
		var spanCaddress = $('#error-caddress');
		//var spanCcountry = $('#error-ccountry');
		var spanCstate = $('#error-cstate');
		var spanCcity = $('#error-ccity');
		var spanEmail = $('#error-cemail');
		var spanCwebsite = $('#error-cwebsite');
		var spanCphn = $('#error-cphn');

		//alert('check_address '+caddress.val()+';'+ccountry.val()+';'+cstate.val()+';'+ccity.val()+'<br/>'+'check_name '+cname.val()+'<br/>'+'check_url '+cwebsite.val()+'<br/>'+'check_phn '+cphn.val()+'<br/>'+'check_tag '+ctagline.val());

		function check_cname(){
			//alert('fun cc');
			if($.trim(cname.val()).length == 0)
			{
				error_cname = 'Classes name is required';
				spanCname.text(error_cname);
				cname.addClass('error');
			}
			else
			{
				//alert('else');
				if(!regexp_alp.test(cname.val()))
				{
					//alert('if2');
					error_cname = 'Invalid Name';
					spanCname.text(error_cname);
					cname.addClass('error');
				}
				else
				{
					error_cname = '';
					spanCname.text(error_cname);
					cname.removeClass('error');
				}
			}
		}

		function check_address(){
			if ($.trim(caddress.val()).length == 0)
			{
				error_caddress = 'Please enter Address';
				spanCaddress.text(error_caddress);
				caddress.addClass('error');
			}
			else
			{
				error_caddress = '';
				spanCaddress.text(error_caddress);
				caddress.removeClass('error');	
			}

			/*if (ccountry.val() == null){
				error_ccountry = 'Select Country';
				spanCcountry.text(error_ccountry);
				ccountry.addClass('error'); 
			}
			else{
				error_ccountry = '';
				spanCcountry.text(error_ccountry);
				ccountry.removeClass('error'); 
			}*/

			if (cstate.val() == null){
				error_cstate = 'Select State';
				spanCstate.text(error_cstate);
				cstate.addClass('error');
			}
			else{
				error_cstate = '';
				spanCstate.text(error_cstate);
				cstate.removeClass('error');
			}

			if (ccity.val() == null){
				error_ccity = 'Select City';
				spanCcity.text(error_ccity);
				ccity.addClass('error');
			}
			else{
				error_ccity = '';
				spanCcity.text(error_ccity);
				ccity.removeClass('error');
			}

			error_caddress = error_cstate+error_ccity;
		}

		function check_url(){
			if ($.trim(cwebsite.val()).length != 0)// && !regexp_url.test(cwebsite))
			{
				//alert('check_url() if1');
				if (!regexp_url.test(cwebsite.val()))
				{
					//alert('check_url() if2');
					error_cwebsite = 'Invalid URL';
					spanCwebsite.text(error_cwebsite);
					cwebsite.addClass('error');
				}
				else
				{
					//alert('check_url() else1');
					error_cwebsite = '';
					spanCwebsite.text(error_cwebsite);
					cwebsite.removeClass('error');		
				}
			}
			else
			{
				//alert('check_url() else2');
				error_cwebsite = '';
				spanCwebsite.text(error_cwebsite);
				cwebsite.removeClass('error');
			}
		}

		function check_phn(){
			//alert('cm'+$.trim(cphn.val()).length);
			
			if($.trim(cphn.val()).length == 0)
			{
				//alert('if'+$.trim(cphn.val()).length);
				error_cphn = 'Phone/Mobile no. is required';
				spanCphn.text(error_cphn);
				cphn.addClass('error');	
			}
			else
			{
				if($.trim(cphn.val()).length != 10)
				{
					//alert('step1 if2 '+$.trim(cphn.val()).length);
					error_cphn = 'Invalid number';
					spanCphn.text(error_cphn);
					cphn.addClass('error');
				}
				else
				{
					error_cphn = '';
					spanCphn.text(error_cphn);
					cphn.removeClass('error');
				}
			}
		}

		check_cname();
		check_email('#class_email','#error-cemail');
		check_address();
		check_url();
		check_phn(cphn,spanCphn);

		// TAB CHANGE
		if (error_cname != '' || error_cwebsite != '' || error_cphn != '' || error_caddress != '')
		{
			alert("Error! Can't signup.");
			return false;
		}
		else
		{
			var data = $('.input').serializeArray();
			//console.log(data);
			$.ajax({
				url:"processes/register.process.php",
				method:"POST",
				data:data,
				success:function(data){
					console.log(data == 123);
					console.log(data == 12);
					console.log(data == 1);
					/*var cemail = data.localeCompare("Duplicate entry '"+cwebsite.val()+"' for key 'email");
					console.log(cemail);
					if (cemail) {
						swal("Oops!",cwebsite.val()+' is already used','warning').then((value) => {
						  swal(`The returned value is: ${value}`);
						});
						//console.log('a --> '+a);
					}
					else */if (data == 123) {
						swal("All set!","Now you can start your work.","success").then((value) => {
							  if (value) {
									$('#register-form')[0].reset();
									window.location.replace("login_admin.php");
								}else{
									$('#register-form')[0].reset();
									window.location.replace("login_admin.php");
								}
							});
					}
					else if (data == 12) {
						swal("Hmm..!","Something is wrong!","warning").then((value) => {
								window.location.replace("regi_form.php");
							});
						
					}
					else if (data == 1) {
						swal("Oops!","You should try again!","Error").then((value) => {
								$('#register-form')[0].reset();
								window.location.replace("regi_form.php");
							});
					}
					else {
						swal("Hey!","Seems like you are already Registered!","warning").then((value) => {
								$('#register-form')[0].reset();
								window.location.replace("login_admin.php");
							});
					}
					//$('#register-form')[0].reset();
					//window.location.replace("login_admin.php");
				}
			});
			/*$('#register-form')[0].reset();
			window.location.replace("login_admin.html");*/
		}
	});

	$('#btn_step3_prev').click(function(){
		$('#link_step2').addClass('active');
		$('#link_step2').removeClass('inactive');
		$('#link_step3').addClass('inactive');
		$('#link_step3').removeClass('active');

		$('#pane_classes_detail').addClass('active');
		$('#pane_branch_detail').removeClass('active');
	});




	$('#btn_step3_regi').click(function(){
		function check_address(baddress,spanbaddress,bstate,spanbstate,bcity,spanbcity,bphn,spanbphn){
			
			if ($.trim(baddress.val()).length == 0){
				var error_baddress = 'Please enter Address';
				spanbaddress.text(error_baddress);
				baddress.addClass('error');
			}
			else
			{
				var error_baddress = '';
				spanbaddress.text(error_baddress);
				baddress.removeClass('error');	
			}
			
			if (bstate.val() == null){
				var error_bstate = 'Select State';
				spanbstate.text(error_bstate);
				bstate.addClass('error');
			}
			else{
				var error_bstate = '';
				spanbstate.text(error_bstate);
				bstate.removeClass('error');
			}
			
			if (bcity.val() == null){
				var error_bcity = 'Select City';
				spanbcity.text(error_bcity);
				bcity.addClass('error');
			}
			else{
				var error_bcity = '';
				spanbcity.text(error_bcity);
				bcity.removeClass('error');
			}

			if($.trim(bphn.val()).length == 0)
			{
				var error_bphn = 'Enter Phone no.';
				spanbphn.text(error_bphn);
				bphn.addClass('error');
			}
			else{
				if ($.trim(bphn.val()).length != 10){
					var error_bphn = 'Invalid Phone no.';
					spanbphn.text(error_bphn);
					bphn.addClass('error');
				}
				else{
					var regexp_num = /[0-9]/;
					if (!regexp_num.test(bphn.val()))
					{
						var error_bphn = 'Invalid Phone no.';
						spanbphn.text(error_bphn);
						bphn.addClass('error');
					}
					else{
						var error_bphn = '';
						spanbphn.text(error_bphn);
						bphn.removeClass('error');
					}
				}
			}

			error_baddress = error_baddress+error_bstate+error_bcity+error_bphn;
			if (error_baddress.length > 0)
			{
				return 0;
			}
			else{
				return result+1;
			}
		}

		var num_branch = $('#hidden_Input_branch').val(); // NUMBER OF BRANCHES
		var result = 0;
		if (num_branch >= 1)
		{
			for (var i = 1; i <= num_branch; i++) {
				
				var baddress = $('#b'+i+'_address');
				var spanbaddress = $('#error-b'+i+'_address');
				var bstate = $('#b'+i+'_state');
				var spanbstate = $('#error-b'+i+'_state');
				var bcity = $('#b'+i+'_city');
				var spanbcity = $('#error-b'+i+'_city');
				var bphn = $('#b'+i+'_phn');
				var spanbphn = $('#error-b'+i+'_phn');

				result = check_address(baddress,spanbaddress,bstate,spanbstate,bcity,spanbcity,bphn,spanbphn);
			}
		}

		if (result){
			$('#btn_step3_regi').attr('disabled','disabled');
			$(document).css('cursor','progress');
			//$('#register-form').submit();

			var data = $('.input').serializeArray();
			console.log(data);
			$.ajax({
				url:"processes/register.process.php",
				method:"POST",
				data:data,
				success:function(data){
					console.log(data);
					$('#register-form')[0].reset();
					window.location.replace("../login_admin.html");
				}
			});
		}
	});
});

/*$('#btn_step1_next').click(function(){
	var data = $('.input').serializeArray();
	console.log(data);
	$.ajax({
		url:"processes/register.process.php",
		method:"POST",
		data:data,
		success:function(data){
			alert(data);
			//$('#register-form')[0].reset();
		}
	});
	//$('#btn_step3_regi').attr('disabled','disabled');
	//$(document).css('cursor','progress');
	//$('#register-form').submit();
	//alert('alert run');
});*/