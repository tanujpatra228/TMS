<style type="text/css">
  .social-media-list {
    position: relative;
    font-size: 1.3rem;
    text-align: center;
    width: 100%;
    }

    .social-media-list li a {
      position: relative; 
      top: -10px;
      color: #fff
    }

    .social-media-list li {
    position: relative; 
    top: 0;
    left: -20px;
    display: inline-block;
    height: 50px;
    width: 50px;
    vertical-align: middle;
    margin: 10px 3px;
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
    width: 50px;
    height: 50px;
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

    .fh5co-bg {
      background-size: cover;
      background-position: center center;
      background-repeat: no-repeat;
      position: relative;
    }

    .fh5co-bg {
      background-size: cover;
      background-position: center center;
      position: relative;
      width: 100%;
      float: left;
    }
    .fh5co-bg .overlay {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.5);
      -webkit-transition: 0.5s;
      -o-transition: 0.5s;
      transition: 0.5s;
    }

    .fh5co-bg-section {
      background: rgba(0, 0, 0, 0.05);
    }

    #fh5co-footer {
      padding: 7em 0;
      clear: both;
    }
    @media screen and (max-width: 768px) {
      #fh5co-footer {
        padding: 3em 0;
      }
    }

    #fh5co-footer {
      position: relative;
    }
    #fh5co-footer .overlay {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.9);
      -webkit-transition: 0.5s;
      -o-transition: 0.5s;
      transition: 0.5s;
    }
    #fh5co-footer h3 {
      margin-bottom: 15px;
      font-weight: bold;
      font-size: 15px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: rgba(255, 255, 255, 0.8);
    }
    #fh5co-footer .fh5co-footer-links {
      padding: 0;
      margin: 0;
    }
    #fh5co-footer .fh5co-footer-links li {
      padding: 0;
      margin: 0;
      list-style: none;
    }
    #fh5co-footer .fh5co-footer-links li a {
      color: rgba(255, 255, 255, 0.5);
      text-decoration: none;
    }
    #fh5co-footer .fh5co-footer-links li a:hover {
      color:white;
    }
    #fh5co-footer .fh5co-widget {
      margin-bottom: 30px;
    }
    @media screen and (max-width: 768px) {
      #fh5co-footer .fh5co-widget {
        text-align: left;
      }
    }
    #fh5co-footer .fh5co-widget h3 {
      margin-bottom: 15px;
      font-weight: bold;
      font-size: 15px;
      letter-spacing: 2px;
      text-transform: uppercase;
    }
    #fh5co-footer .copyright .block {
      display: block;
    }
    .btn-primary {
      background: #F85A16;
      color: #fff;
      border: 2px solid #F85A16;
    }
    .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
      background: #f96c2f !important;
      border-color: #f96c2f !important;
    }
    .btn-primary.btn-outline {
      background: transparent;
      color: #F85A16;
      border: 1px solid #F85A16;
    }
    .btn-primary.btn-outline:hover, .btn-primary.btn-outline:focus, .btn-primary.btn-outline:active {
      background: #F85A16;
      color: #fff;
    }
</style>

<footer id="fh5co-footer" class="fh5co-bg" role="contentinfo">
  <div class="overlay"></div>
  <div class="container">
    <div class="row row-pb-md">
      <div class="col-md-4 fh5co-widget">
        <h3>TMS </h3>
        <p style="color: darkgrey;">Join TMS to manage the details profesionally</p>
        <p><a class="btn btn-info" href="regi_form.php">Sign Up</a></p>
      </div>
      <div class="col-md-8">
        <div class="row" >
          <div class="col-md-4 col-sm-4 col-xs-6">
            <h3>Quick Links</h3>
            <ul class="fh5co-footer-links">
              <li><a href="index.php">Home</a></li>
              <li><a href="aboutus.php">About Us</a></li>
              <li><a href="contact.php">Contact Us</a></li>
              <li><a href="#">Help</a></li>
            </ul>
          </div>


          <div class="col-md-4 col-sm-4 col-xs-6">
            <h3>Have A Question?</h3>
            <ul class="fh5co-footer-links">
              <li>
                <a href="#"><span class="fa fa-map-marker fa-1x"></span>
                  <span class="text">  &nbsp; &nbsp; Surat | Gujarat</span>
                </a>
              </li>
              <li>
                <a href="#"><span class="fa fa-phone fa-1x"></span>
                  <span class="text">&nbsp; &nbsp;+91 704-305-6077</span>
                </a>
              </li>
              <li>
                <a href="#">
                  <span class="fa fa-envelope fa-1x"></span>
                  <span class="text">&nbsp; &nbsp;tms@gmail.com</span>
                </a>
              </li>
            </ul>
          </div>

          <div class="col-md-4 col-sm-4 col-xs-6">
            <p class="float-right" ><span class=" fas fa-arrow-up" style="font-size: 20px; color: darkgrey;"></span><a href="#" style="color: darkgrey; font-size: 20px; ">&nbsp; Back to top</a></p>
          </div>  
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 text-center">
        <p>
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
        </p>
      </div>
    </div>

    <div class="row copyright">
      <div class="col-md-12 text-center">
        <p>
          <small class="block" style="color: darkgrey;">&copy; 2019 | All Rights Reserved.</small> 
          <small class="block" style="color: darkgrey;">Powered by  TMS.com</small>
        </p>
      </div>
    </div>
  </div>
</footer>