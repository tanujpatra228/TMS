<?php
$staffId = '';
if (isset($_GET['staffId'])) {
	$staffId = str_replace("-", "#", $_GET['staffId']);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Staff Login | TMS</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/floating-labels/">

    <!-- Bootstrap core CSS -->
    <link href="Floating_lables/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="Floating_lables/floating-labels.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">

    <script type="text/javascript" src="js/sweetalert.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(){
			<?php
				if (isset($_GET['invalid'])) {
				$invalid = $_GET['invalid'];
				echo'swal("Error!", "Invalid Id or Password.","error");';
				}
			?>
		});
    </script>
  </head>
  <style> 
	:root {
	--input-padding-x: .75rem;
	--input-padding-y: .75rem;
	}

	html,
	body {
	height: 100%;
	background-image: linear-gradient(to right,teal, powderblue 100%);
	}

	body {
	-ms-flex-align: center;
	-ms-flex-pack: center;
	-webkit-box-align: center;
	align-items: center;
	-webkit-box-pack: center;
	justify-content: center;
	padding-top: 40px;
	padding-bottom: 40px;
	background-color: #f5f5f5;
	}

	.form-signin {
	width: 100%;
	max-width: 420px;
	padding: 15px;
	margin: 140px auto;
	}

	.form-label-group {
	position: relative;
	margin-bottom: 1rem;
	}

	.form-label-group > input,
	.form-label-group > label {
	padding: var(--input-padding-y) var(--input-padding-x);
	}

	.form-label-group > label {
	position: absolute;
	top: 0;
	left: 0;
	display: block;
	width: 100%;
	margin-bottom: 0; /* Override default `<label>` margin */
	line-height: 1.5;
	color: #495057;
	border: 1px solid transparent;
	border-radius: .25rem;
	transition: all .1s ease-in-out;
	}

	.form-label-group input::-webkit-input-placeholder {
	color: transparent;
	}

	.form-label-group input:-ms-input-placeholder {
	color: transparent;
	}

	.form-label-group input::-ms-input-placeholder {
	color: transparent;
	}

	.form-label-group input::-moz-placeholder {
	color: transparent;
	}

	.form-label-group input::placeholder {
	color: transparent;
	}

	.form-label-group input:not(:placeholder-shown) {
	padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
	padding-bottom: calc(var(--input-padding-y) / 3);
	}

	.form-label-group input:not(:placeholder-shown) ~ label {
	padding-top: calc(var(--input-padding-y) / 3);
	padding-bottom: calc(var(--input-padding-y) / 3);
	font-size: 12px;
	color: #777;
	}
  </style>

  <body>
  	<header>
		<?php
      		include'navbar.php';
   		 ?>
	</header>
    <form class="form-signin" action="processes/staff_login.process.php" method="POST">
      <div class="text-center mb-4">
       <img class="mb-4 rounded-circle" src="images/staff.png" alt="" width="90" height="75"> 
        <!-- <h1 class="h4 mb-3 font-weight-normal">Admin Login</h1> -->
        </p> 
      </div>

      <div class="form-label-group">
        <?php 
        	if (isset($_GET['staffId'])) {
        		echo'<input type="text" id="inputEmail" class="form-control" name="email" placeholder="Email address" value="'.$staffId.'" required>';
        	}
        	else{
        		echo'<input type="text" id="inputEmail" class="form-control" name="email" placeholder="Email address" required autofocus>';
        	}
        ?>
        <!-- <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email address" required autofocus> -->
        <label for="inputEmail">Email address</label>
      </div>

      <div class="form-label-group">
        <input type="password" id="inputPassword" class="form-control" name="pwd" placeholder="Password" required autofocus>
        <label for="inputPassword">Password</label>
      </div>

      <div class="checkbox mb-3">
      </div>
      <button class="btn btn-lg btn-outline-light btn-block" type="submit">Login</button>
    </form>
    <!-- FOOTER -->
    <?php
    	include'footer.php';
    ?>
  </body>
</html>


