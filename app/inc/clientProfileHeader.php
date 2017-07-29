<?php

?>
<script type="text/javascript" src="Jquery/jquery.js"></script>

<script type="text/javascript" src="Jquery/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="Bootstrap/css/bootstrap.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="fonts/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css"
    href="https://fonts.googleapis.com/css?family=Nova+Mono|Baloo+Chettan|Open+Sans+Condensed|Ubuntu|Abel|Marmelad|Oswald|Arsenal">
<link rel="stylesheet" href="customCss/normalize.css">
<link rel="stylesheet" href="customCss/custom.css">
<link rel="stylesheet" href="Bootstrap/css/bootstrap.min.css">
    <!-- Bootstrap CSS -->
<link rel="stylesheet" href="customCss/jquery-ui.css">
  </head>
  <body id="home" data-target=".navbar">

  <!-- nav bar code markup starts here -->
    <nav class="navbar navbar-toggleable-md mb-3 navbar-fixed-top">
<!--
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
-->
      <a class="navbar-brand" href="#">ScoreSheet</a>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
        </ul>

          <ul class="navbar-nav">
          <li> <label for="image-file"><img  class="headerImage mr-3" src="img/newacct.jpg" height="40" width="40"></label> <?php
echo $_SESSION['sess_info'][1];
//var_dump($sess[0]);
?></a></li>
              <!-- <li><a href="logout.php"><i class="fa fa-power-off ml-3" aria-hidden="true"></i></a></li> -->
          </ul>

       <!--  <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Search">
          <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
        </form> -->
      </div>
    </nav>

                <div class="form-group image-upload">

                <input type="file" name="image-file" class="form-control" id="image-file">

                </div>
