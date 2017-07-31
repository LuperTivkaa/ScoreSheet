<?php
include 'inc/regSession.php';
//load classes
include 'inc/autoload.php';
include 'inc/topHeader.php';
$clientObj = new client();
?>
<title>ScoreSheet|Assessment Centre...</title>
<?php include'inc/userProfileHeader.php'; ?>


<div  class="container mt-3">
<?php
include 'inc/institutionProfile.php';
?>

<div class="row">

<!-- include side menu -->
<?php include'inc/sidemenu.php';?>
<!--end of  side menu include-->

<!--    div for main content-->
<div class="col-md-6">

<!-- end of div to display message -->
<!--  end of output class-->
    <ul class="nav nav-tabs">
        <li class="nav-item tabs">
        <a class="nav-link add-ca" href="createCa.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>
        Add CA </a>
  </li>

  <li class="nav-item tabs">
    <a class="nav-link search-ca" href="searchCa.php"><i class="fa fa-search fa-fw" aria-hidden="true"></i>
Search CA </a>
  </li>

  <li class="nav-item tabs">
    <a class="nav-link search-ca" href="advanceSearchCa.php"><i class="fa fa-search fa-fw" aria-hidden="true"></i>
Advanced Search </a>
  </li>
  <li class="nav-item tabs">
    <a class="nav-link add-exam" href="createExam.php"><i class="fa fa-plus fa-fw" aria-hidden="true"></i>
    Exam</a>
  </li>
  <li class="nav-item tabs">
    <a class="nav-link search-exam" href="searchExam.php"><i class="fa fa-search fa-fw" aria-hidden="true"></i>
    Search Exam</a>
  </li>
</ul>

      <!-- div to display message -->
    <div id="my-info">
    </div>

    <div id="new-content">

    </div>

    <div id="generated-result">

    </div>

</div>
<!--    end of div for main content-->

<!-- right menu side bar -->
<?php
include 'inc/rightMenu.php';
?>
<!-- end of right menu side bar -->

</div>
</div>
  <!-- include footer -->
<?php include 'inc/footer.php'; ?>
