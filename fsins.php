<?php

	/* CALL */
//sendMail('tanujpatra228@gmail.com', 'Tanuj Patra', 'STONE', 'origamigifts9@gmail.com', 'Testing email function 1','Testing email function 1');

function sendMail($ToEmail,$ToName,$FromName,$bcc,$subject,$messageBody){
	require "class.phpmailer.php";
	$mail = new PHPMailer;
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->SMTPDebug = 2;
	$mail->Host = 'smtp.gmail.com';  	// Specify main and backup server
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'aaranstone22@gmail.com';      // SMTP username suratrealestate2015@gmail.com       noreplaybuyerfox@gmail.com
	$mail->Password = 'aaranstone2';                           // SMTP password suratrealestate                      admin@123*
	$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
	$mail->Port = '465';						//Port Number

	$mail->From = 'aaranstone2208@gmail.com';			//From Email Id
	$mail->FromName = $FromName;		//From Email Id Display Name        Surat Real Esate(Real Estate)
	//$mail->addAddress('josh@example.net', 'Josh Adams');  // Add a recipient
	$mail->addAddress($ToEmail,$ToName);               // Name is optional
	//$mail->addReplyTo('info@example.com', 'Information');
	//$mail->addCC('cc@example.com');
	//$mail->addBCC($bcc);

	$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
	//$mail->addAttachment('');         // Add attachments
	//$mail->addAttachment('','');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = $subject;
	$mail->Body    = $messageBody;	

	if(!$mail->send()){
	//header("location:thanks.php");
		echo 0;
	}
	else{
		echo 1;
	}
}
?>
