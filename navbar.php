  <style type="text/css" rel="stylesheet" >
    .nav-item{
      margin-left: 15px;
    }
    .navbar-nav .nav-item .nav-link{
      color: #fff;
      font-size: 16px;
    }
    .nav-link:hover, .dropdown a{
      text-decoration: none;
    }
    .dropdown{
      top: 7px;
    }
    .btn-link
    {
      color: #fff;
      font-size: 16px;
    }
    .btn-link:hover
    {
      text-decoration: none;
      color: #ccc;
    }
    .carousel-inner {
      margin-top: 50px; 
      margin-bottom: 50px;
    }
    .carousel-inner .carousel-item img
    {
      height: 100%;
      width: 100%;
    }
    .carousel-item
    {
      background-color: #fff;
      overflow-x: hidden;
    }
    #btprev: hover, #btnnext: hover
    {
      background: rgba(0,0,0,.5);
    }
    .input-group{
      width:600px; 
      height:60px;
    }
    .course_link{
      color: darkcyan;
    }
    #dropdownMenuLink{ 
      background: transparent;
      transition: none;
      padding: 8px;
    }
    #dropdownMenuLink:hover{
      border: 0px;
      transition: none;
      color: #ccc;
    }

  </style>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
	<img class="rounded-circle" src="images/TMS_logo.png" width="50" height="50" alt="TMS">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<a class="nav-link" href="index.php">Home</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="aboutus.php">About Us</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="contact.php">Contact Us</a>
			</li>
			<li class="nav-item">
				<div class="dropdown">
					<a class="btn-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 16px;">
						Login
					</a>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
						<a class="dropdown-item" href="login_admin.php">Admin Login</a>
						<a class="dropdown-item" href="login_teacher.php">Staff Login</a>
						<a class="dropdown-item" href="login_stud.php">Student Login</a>
					</div>
				</div>
			</li>
		</ul>
		<button class="btn btn-link my-2 my-sm-0" type="button" onclick="window.location.replace('regi_form.php')">Registration</button>
	</div>
</nav>
