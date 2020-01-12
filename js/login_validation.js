$(document).ready(function(){
	$('#btn_login').click(function(){
		var email = $('#email');
		var error_email = $('#error-email');
		var pwd = $('#pwd');
		var error_pwd = $('#error-pwd');


		
		/*$.ajax({
			url:"processes/login.process.php",
			method:"POST",
			data:$('#login-form').serializeArray(),
			success:function(data){
				alert(data);
				$('#login-form')[0].reset();
			}
		});*/
	});
});