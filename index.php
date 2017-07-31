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
      <a class="btn btn-secondary btn-lg" href="school_login.php" target="_blank">Go To My School</a>
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
              <button class="btn btn-primary" id="client-btn">Client Login</button>
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
                              <p class="card-text">Facile is designed with the concept of mobile first, which means Facile scales well on different screen sizes.</p>
                            </div>
                          </div>
                </div>

                <div class="col-md-6">
                <div class="card">
                            
                            <div class="card-block">
                              <h4 class="card-title excite">Great And Flexible Pricing</h4>
                              <p class="card-text">Facile offers flexible pricing schemes that meet your needs whatever your budget.</p>
                            </div>
                          </div>
                </div>

                <div class="col-md-6">
                <div class="card">
                            
                            <div class="card-block">
                              <h4 class="card-title excite">Secure And Reliable</h4>
                              <p class="card-text">Facile store its data in a secure environment and is developed based on industry best web security standards.</p>
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
        <p class="lead text-xs-center">ScoreSheet is engineered to ease institutional management by Staff, Students and Admministors. The App is made up of modules that help you manage your school needs stargting from admission to examination reporting. Please register for a free account and start enjoying the benefits of Facile<br>
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
                    <img src="images/sky.jpg" height="80" width="80" class="headerImage">
                </div>

                <!--Content-->
                <h4 class="testimonial-name">Akpah, Yimam</h4>
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
     <!-- Modal begins here -->


<div id="register" class="modal fade">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info text-xs-center text-white">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Register for account</h4>
      </div>
      <div class="modal-body">

       <!-- Registration form goes here -->
       <div class="alert alert-warning alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <strong>Early Bird Reg</strong> You should check in on some of those fields below.
        </div>

              <form>
              <h5 class="mb-2">Basic Info</h5>
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email">
              </div>

              <div class="form-group">
              <label for="role">Role</label>
                <select class="custom-select form-control" id="role" name="user_role">
                  
                  <option value="full stack js developer">Full Stack JavaScript Developer</option>
                    <option value="front end developer">Front End Developer</option>
                    <option value="back end developer">Back End Developer</option>
                    <option value="designer">Designer</option>          
                    <option value="student">Student</option> 
                </select>
              </div>
              <hr class="my-2">
              <h5 class="mb-2">which topic interest you most</h5>
              <div class="form-group mb-0">
                
                <label class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input">
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description"></span>Javascript frameworks
                  </label>
                  </div>

                  <div class="form-group mb-0">

                  <label class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input">
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description"></span>Javascript Libraries
                  </label>
                  </div>

                  <div class="form-group mb-0">

                  <label class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input">
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description"></span>Node.js
                  </label>
                  </div>
                  <div class="form-group mb-0">

                  <label class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input">
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description">Build Tools</span>
                  </label>
                  </div>

                  <hr class="my-2">
              <h5 class="mb-2">Payment Info</h5>


                <div class="row">

                  <div class="col-lg-6 form-group">
                    <label for="cc-num">Card Number:</label>
                    <input class="form-control" id="cc-num" type="text">
                  </div>

                  <div class="col-lg-3 form-group">
                    <label for="zip">Zip Code:</label>
                    <input class="form-control" id="zip" type="text">
                  </div>

                  <div class="col-lg-3 form-group">
                    <label for="cvv">CVV:</label>
                    <input class="form-control" id="cvv" type="text">
                  </div>
                </div>

                <div class="row">
                  <label class="col-lg-12">Expiration Date</label>

                  <div class="col-lg-8 form-group">
                    
                    <select class="custom-select form-control" id="exp-month">
                      <option value="1">1 - January</option>
                      <option value="2">2 - February</option>
                      <option value="3">3 - March</option>
                      <option value="4">4 - April</option>
                      <option value="5">5 - May</option>
                      <option value="6">6 - June</option>
                      <option value="7">7 - July</option>
                      <option value="8">8 - August</option>
                      <option value="9">9 - September</option>
                      <option value="10">10 - October</option>
                      <option value="11">11 - November</option> 
                      <option value="12">12 - December</option>                           
                    </select> 

                  </div>

                  <div class="col-lg-4 form-group">
                    <select class="custom-select form-control" id="exp-year">
                      <option value="2016">2016</option>
                      <option value="2017">2017</option>
                      <option value="2018">2018</option>
                      <option value="2019">2019</option>
                      <option value="2020">2020</option>                          
                    </select>  
                  </div>
                </div>

                <hr class="mb-2">
                <button type="submit" class="btn btn-primary btn-lg">Register</button>

            </form>
              </div>
          
       <!-- Registration form ends here -->

      </div>
      <!-- this is where modal footer is -->
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>  -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->

    <?php include'app/inc/mainFooter.php';?>