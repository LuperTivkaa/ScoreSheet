<?php 
include 'app/inc/mainHeader.php';
//include'inc/autoload.php';
//$new_signup = new signUp();
?>
<!-- jumbotron for key markup begins here -->
<div class="jumbotron jumbotron-fluid jumb text-white">
  <div class="container text-xs-center pt-3">
  <!-- jumbo row -->
  <div class="row">
  	<div class="col-md-8">
  		<h4 class="display-3 welcome">ScoreSheet - School Management Software</h4>
    <p class="lead">...let your staff focus on delivering quality education to your students/pupils and allow ScoreSheet to handle the tedious task of computing and producing academic reports.</p>
    <h4 class="display-3 welcome">Sign Up Now! Its Free</h4>
      <div class="btn-group mt-2" role="group" aria-label="Basic example">
      <a class="btn btn-secondary btn-lg" href="app/public/school_login.php" target="_blank">Go To My School</a>
      </div>
  	</div>
  	<div class="col-md-4">


    <h4 class="display-3 welcome">Client Login</h4>
      
      <div class="row">

              <div class="form-group col-md-12 margin-bottom-sm">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email"> 
              </div>

              <div class="form-group col-md-12 margin-bottom-sm">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password"> 
              </div>

         </div>
              <button class="btn btn-primary" id="client-btn"> Client Login</button>
              <div id="client-login"></div>              

    <hr class="underlineHr">
  	<h4 class="display-3 welcome" id="client">Sign up for a free account</h4>
  		
  		<div class="row">

  			       <div class="form-group col-md-12 margin-bottom-sm">
                <input type="text" class="form-control" id="username" name="username" placeholder="User name"> 
               </div>

              <div class="form-group col-md-12 margin-bottom-sm">
                <input type="email" class="form-control" id="signup-email" name="signup-email" placeholder="Email"> 
              </div>

              <div class="form-group col-md-12 margin-bottom-sm">
                <input type="password" class="form-control" id="signup-pass" name="signup-pass" placeholder="Password"> 
              </div>

         </div>
              <button class="btn btn-primary" id="new-signup-btn">Sign Up!</button>
              <div id="client-signup"></div>              
  		</div>

  	</div>
  </div>
    
  </div>
</div>
<!-- end of jumbotron -->



<!-- About container begins here -->
        <div class="container pt-2">
        <!-- about content begins here -->
        <!-- Why Choose Us -->
      <h1 id="features" class="dispaly-4 text-xs-center  my-3 leadText">Why Choose ScoreSheet</h1>
      <p>ScoreSheet is a great tool for managing your school through the web. It is fast, reliable and stores data in a secure manner. ScoreSheet is used both on computers, smart phones and tablets, increase the productivity of your staff by using ScoreSheet today!</p>
      
              <div class="row">
                <div class="col-md-6">
                            
                            <div class="card">

                            <div class="card-block">
                              <h4 class="card-title excite">Easy Customization</h4>
                              <p class="card-text">ScoreSheet is engineered with you in mind and adapt easily to customized institutional profile.</p>
                            </div>
                          </div>
                </div>

                <div class="col-md-6">

                <div class="card">
                            
                            <div class="card-block">
                              <h4 class="card-title excite">Responsive Design</h4>
                              <p class="card-text">ScoreSheet is designed with the concept of mobile first, which means the web app scales well on different screen sizes.</p>
                            </div>
                          </div>
                </div>

                <div class="col-md-6">
                <div class="card">
                            
                            <div class="card-block">
                              <h4 class="card-title excite">Great And Flexible Pricing</h4>
                              <p class="card-text">ScoreSheet offers flexible pricing schemes that meet your needs whatever your budget.</p>
                            </div>
                          </div>
                </div>

                <div class="col-md-6">
                <div class="card">
                            
                            <div class="card-block">
                              <h4 class="card-title excite">Secure And Reliable</h4>
                              <p class="card-text">ScoreSheet store its data in a secure environment and is developed based on industry best web security standards.</p>
                            </div>
                          </div>
                </div>

                <div class="col-md-6">
                <div class="card">
                            
                            <div class="card-block">
                              <h4 class="card-title excite">Friendly Support</h4>
                              <p class="card-text">Our team of dedicated staff are always available to attend to your needs.</p>
                            </div>
                          </div>
                </div>

                <div class="col-md-6">
                <div class="card">
                            
                            <div class="card-block">
                              <h4 class="card-title excite">Great Features</h4>
                              <p class="card-text">Facile boost of amazing features that make managing your school fun.</p>
                            </div>
                          </div>
                </div>
              </div>
              <P>
              <button type="button" class="btn btn-outline-info btn-lg d-block mx-auto my-3" id="#client">Sign Up! Its Free</button></P>

      <!-- Pricing -->
      <h1 id="pricing" class="dispaly-4 text-xs-center my-3 leadText">Flexible Pricing</h1>
      <p class="lead text-xs-center">A smart school management App with easy to use features with unbeatable price of <span>  N 53/Month/Student</span></p>
      

        <h1 id="modules" class="dispaly-4 text-xs-center my-3 leadText">ScoreSheet Modules</h1>
        <p class="lead text-xs-center">ScoreSheet is engineered to ease institutional management by Staff, Students and Admministors. The App is made up of modules that help you manage your school needs stargting from admission to examination reporting. Please register for a free account and start enjoying the benefits of ScoreSheet<br>
        <button type="button" class="btn btn-outline-info btn-lg d-block mx-auto my-3" id="signup">Register for free</button></p>
        
         


        <!-- testimonials -->
        <hr>
    <h1 id="testimonials" class="display-4 text-xs-center leadText">Testimonials</h1>
    <!--Section sescription-->
    <p class="lead text-xs-center">Hear what people are saying about ScoreSheet</p>

    
      <!--First row-->
    <div class="row text-xs-center">

        <!--First column-->
        <div class="col-md-4 mb-r">
            
            <div class="testimonial">
                   
            </div>
        </div>
        <!--/First column-->

        <!--Second column-->
        <div class="col-md-4 mb-r">
            <div class="testimonial">
                <!--Avatar-->
                <div class="avatar">
                    <img src="./app/images/sky.jpg" height="80" width="80" class="headerImage">
                </div>

                <!--Content-->
                <h4 class="testimonial-name">Akpah, Yiman</h4>
                <h6 class="testimonial-note">Principal, SKY GIfted Academy, Gboko</h6>
                <p class="testimonial-text"><i class="fa fa-quote-left"></i> Since we started using ScoreSheet to manage our school, we have seen enhanced productivity and the ease of preparing academic reports has got easier and fascinating. Its a great tool indeed.</p>
            </div>
        </div>
        <!--/Second column-->

        <!--Third column-->
        <div class="col-md-4 mb-r">
            <div class="testimonial">
             
            </div>
        </div>
        <!--/Third column-->
        
    </div>
    <!--/First row-->
  </div>
    <!-- About container ends here -->

    <?php include'app/inc/mainFooter.php';?>