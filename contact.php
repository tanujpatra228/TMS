<?php
if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $phn = $_POST['phn'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $msgBody = '<!DOCTYPE html> <html> <head> <title>Contact us Form</title> </head> <body style="background-color: #ccc;"> <div class="row"> <div class="col-md-12"> Name: '.$name.'</div> </div> <div class="row"> <div class="col-md-12"> Phone no: '.$phn.'</div> </div> <div class="row"> <div class="col-md-12"> Email: '.$email.'</div> </div> <div class="row"> <div class="col-md-12"> Message: '.$message.'</div> </div> </body> </html>';
    
    require "class.phpmailer.php";

    $mail = new PHPMailer;
            
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->SMTPDebug = 2;
    $mail->Host = 'smtp.gmail.com';     // Specify main and backup server
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'aaranstone22@gmail.com';      // SMTP username suratrealestate2015@gmail.com       noreplaybuyerfox@gmail.com
    $mail->Password = 'aaranstone2';                           // SMTP password suratrealestate                      admin@123*
    $mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
    $mail->Port = '465';                        //Port Number

    $mail->From = $email;         //From Email Id
    $mail->FromName = $name;       //From Email Id Display Name        Surat Real Esate(Real Estate)
    //$mail->addAddress('josh@example.net', 'Josh Adams');  // Add a recipient
    $mail->addAddress('tms@gmail.com','TMS');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    $mail->addBCC('tanujpatra228@gmail.com');

    $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
    //$mail->addAttachment('');         // Add attachments
    //$mail->addAttachment('','');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Contact us';
    $mail->Body    = $msgBody;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Sahil Kumar">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Contact Us | TMS</title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/sweetalert.min.js"></script>

<?php 

if(isset($_POST['submit']) && $mail->send()){
     //header("location:thanks.php");
   
   echo'<script type="text/javascript" src="js/sweetalert.min.js"></script> <script type="text/javascript"> $(document).ready(function(){swal("Thanks", "We got your message.","success"); }); </script>'; 
}
/*else{
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}*/

?>

    <style type="text/css" rel="stylesheet">

        body {
        margin: 0px;
        padding: 0px;
        }

        #contact {
        width: 100%;
        height: 100vh;
        background-color: #111;
        overflow: hidden;
        padding-bottom: 200px;
        }
        /* Begin Left Contact Page */
        .form-horizontal {
        float: left;
        max-width: 400px;
        font-family: 'Lato';
        font-weight: 400;
        }

        .form-control, textarea {
        max-width: 400px;
        background-color: #fff;
        color: #111;
        letter-spacing: 1px;
        }

        .send-button {
        margin-top: 15px;
        height: 35px;
        width: 445px;
        overflow: hidden;
        transition: all .2s ease-in-out;
        }

        .button {
        width: 400px;
        height: 34px;
        transition: all .2s ease-in-out;
        }

        .send-text {
        display: block;
        margin-top: 10px;
        font: 300 14px 'Lato', sans-serif;
        letter-spacing: 2px;
        }

        .button:hover {
        transform: translate3d(0px, -29px, 0px);
        }

        /* Begin Right Contact Page */
        .direct-contact-container {
            font-size: 14px;
            max-width: 400px;
            float: left;
            margin-top: 70px;
            margin-left: 150px;
        }

        /* Location, Phone, Email Section */
        .contact-list {
            margin-top: 20px;
            list-style-type: none;
            margin-left: -30px;
            padding-right: 20px;
        }

        .list-item {
            line-height: 75px;
            color: #aaa;
        }

        .contact-text {
        font: 300 18px 'Lato', sans-serif;
        letter-spacing: 1.9px;
        color: #bbb;
        }

        .place {
        margin-left: 62px;
        }

        .phone {
        margin-left: 56px;
        }

        .gmail {
        margin-left: 53px;
        }

        .contact-text a {
        color: #bbb;
        text-decoration: none;
        transition-duration: 0.2s;
        }

        .contact-text a:hover {
        color: #000;
        text-decoration: none;
        }

        hr {
        border-color: rgba(255,255,255,.8); ;
        }

        /* Begin Media Queries*/
        @media screen and (max-width: 760px) 
        {
            #contact {
            height: 1000px;
            }
            .section-header {
            font-size: 65px;
            }
            .direct-contact-container, .form-horizontal {
            float: none;
            margin: 10px auto;
            }  
            .direct-contact-container {
            margin-top: 60px;
            max-width: 300px;
            }    
            .direct-contact-container .fa{
                font-size: 20px;
            }
        }
		/* Social Media Icons */
		
		.social-media-list {
		position: relative;
		font-size: 2.3rem;
		text-align: center;
		width: 100%;
		}

		.social-media-list li a {
		color: #fff;
		}

		.social-media-list li {
		position: relative; 
		top: 0;
		left: -20px;
		display: inline-block;
		height: 70px;
		width: 70px;
		margin: 10px auto;
		line-height: 70px;
		border-radius: 50%;
		color: #fff;
		background-color: rgb(27,27,27);
		cursor: pointer; 
		transition: all .2s ease-in-out;
		}

		.social-media-list li:after {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		width: 70px;
		height: 70px;
		line-height: 70px;
		border-radius: 50%;
		opacity: 0;
		box-shadow: 0 0 0 1px #fff;
		transition: all .2s ease-in-out;
		}

		.social-media-list li:hover {
		background-color: #fff; 
		}

		.social-media-list li:hover:after {
		opacity: 1;  
		transform: scale(1.12);
		transition-timing-function: cubic-bezier(0.37,0.74,0.15,1.65);
		}

		.social-media-list li:hover a {
		color: #111;
		}

        @media screen and (max-width: 569px) 
        {
            #contact {
            height: 1200px;
            }
            .section-header{
            font-size: 50px;
            }
            .direct-contact-container, .form-wrapper {
            float: none;
            margin: 0 auto;
            }  
            .form-control, textarea {
            max-width: 340px;
            margin: 0 auto;
            }

            .name, .email, textarea {
            width: 280px;
            } 
            .direct-contact-container {
            margin-top: 60px;
            max-width: 280px;
            }  
        }
        @media screen and (max-width: 410px) 
        {
            .send-button 
            {
                width: 99%;
            }
        }
        .input-group-text{
            padding-top: 20px;
            width: 42px;
        }
        #basic-addons4{
            padding-top: 20px;
        }
		.container{ margin-top:80px; 
            margin-bottom: 100px; }

    </style>
</head>

<body>
    <header>
       <?php
        include'navbar.php';
        ?> 
    </header>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-5 bg-default">
                <h1 class="text-center text-dark">Contact Us</h1>
                <hr class="bg-light">
                <h5 class="text-center text-success"></h5>
                <form class="form-horizontal" action="#" method="POST" id="form-box" class="p-2" style="padding-left: 50px;">
                    
                    <div class="form-group input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text fa fa-user-circle" id="basic-addon1"></span>
                        </div>
                        <input type="text" class="form-control" name="name" placeholder="Name" aria-label="Username" aria-describedby="basic-addon1">
                    </div>

                    <div class="form-group input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text fa fa-mobile" id="basic-addon2"></span>
                        </div>
                        <input type="text" class="form-control" name="phn" placeholder="Phone No." aria-label="Recipient's username" aria-describedby="basic-addon2">
                    </div>

                    <div class="form-group input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text fa fa-envelope" id="basic-addon3"></span>
                        </div>
                        <input type="text" class="form-control" name="email" placeholder="Email-Id" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    </div>

                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text fa fa-comment" id="basic-addons4" style="padding-top: 25px;"></span>
                        </div>
                        <textarea class="form-control" name="message" placeholder="Write your message" aria-label="With textarea"></textarea>
                    </div>

                    <button class="btn btn-info send-button" id="submit" name="submit" type="submit" value="SEND">
                        <div class="button">
                           <i class="fa fa-paper-plane"></i><span class="send-text">SEND</span>
                       </div>
                   </button>

               </form>
            </div>
            <div class="col-md-6 mt-5 bg-default">
                <div class="direct-contact-container">

                    <ul class="contact-list">
                        <li class="list-item">
                            <i class="fa fa-map-marker fa-2x">
                                <span class="contact-text place">
                                    <a href="" title="Our Location">Surat | Gujarat</a>
                                </span>
                            </i>
                        </li>

                        <li class="list-item">
                            <i class="fa fa-phone fa-2x">
                                <span class="contact-text phone">
                                    <a href="tel:1-91-704-305-6077" title="Give me a call">((+91) 704-305-6077)</a>
                                </span>
                            </i>
                        </li>

                        <li class="list-item">
                            <i class="fa fa-envelope fa-2x">
                                <span class="contact-text gmail">
                                    <a href="mailto:#" title="Send me an email">tms@gmail.com
                                    </a>
                                </span>
                            </i>
                        </li>

                    </ul>
					<hr class="bg-dark">
						<ul class="social-media-list">
							<li class="bg-info">
								<a href="#" target="_blank" class="contact-icon">
									<i class="fab fa-facebook-f" aria-hidden="true"></i>
								</a>
							</li>
							<li class="bg-info">
								<a href="#" target="_blank" class="contact-icon">
									<i class="fab fa-twitter" aria-hidden="true"></i>
								</a>
							</li>
							<li class="bg-info">
								<a href="#" target="_blank" class="contact-icon">
									<i class="fab fa-instagram" aria-hidden="true"></i>
								</a>
							</li>
							<li class="bg-info">	
								<a href="#" target="_blank" class="contact-icon">
									<i class="fab fa-google-plus-g" aria-hidden="true"></i>
								</a>
							</li>
						</ul>
					<hr>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <?php
      include'footer.php';
    ?>

</body>

</html> 