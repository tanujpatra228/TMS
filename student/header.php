  <style type="text/css" rel="stylesheet" >
    .navbar-nav .nav-item .nav-link
    {
      color: #fff;
      font-size: 20px;
    }
    .nav-link:hover
    {
      text-decoration: none;
    }
    .btn-link
    {
      color: #fff;
      font-size: 20px;
    }
    .btn-link:hover
    {
      text-decoration: none;
      color: #ccc;
    }
    .carousel-inner {margin-top: 50px; margin-bottom: 50px;}
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
      background-color: #000000;
    }
    .input-group{width:600px; height:60px;}
    .course_link{color: darkcyan;}
    #dropdownMenuLink
    { 
      background: transparent;
      transition: none;
    }
    #dropdownMenuLink:hover{
      border: 0px;
      transition: none;
      color: #ccc;
    }

    /*  @media screen and (max-width: 768px) {
     .navbar{
       width: 768px;
     } */
    }

  </style>

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <img class="rounded-circle" src="../images/tution/<?php echo $tution['logo'];?>" width="50" height="50" alt="../images/TMS_logo.png">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="teacher.php?branchId=<?php echo $branchId;?>" class="nav-link">Teacher</a></li>
          <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
          <li class="nav-item"><a href="profile.php" class="nav-link">Profile</a></li>
          <li class="nav-item"><a href="../processes/logout.process.php" class="nav-link">Logout</a></li>
        </ul>
      </div>
</nav>
