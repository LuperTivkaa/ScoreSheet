<?php 
include 'inc/regSession.php';
include 'inc/autoload.php';
$clientObj = new client();
$clientid = $_SESSION['user_info'][4];
//echo $clientObj->loadStaff($clientid);
?>

              <!-- create fee items -->
              <div id="fee-item-container">

              <h4 class="right-menu-header ">Create Fee Items</h4>
              <div class="row">

              <div class="form-group col-md-6">
                 <label for="item">Item</label>
                <input type="text" class="form-control" id="item" name="item" placeholder="Fee Item"> 
              </div>

              <div class="form-group col-md-6">
                 <label for="amount">Amount</label>
                <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount"> 
              </div>

              <div class="form-group col-md-6">
                 <label for="amount-words">Amount in Words</label>
                <input type="text" class="form-control" id="amount-words" name="amount-words" placeholder="Amount in Words"> 
              </div>
              
              <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="term">Term</label>
                <select class="custom-select form-control" id="term">
                <?php 
                $clientObj->loadTerm($clientid);
                  ?>
                </select> 
              </div>
    
            <div class="form-group col-md-6 margin-bottom-sm">
                 <label for="session">Session</label>
                <select class="custom-select form-control" id="session">
                 <?php 
                $clientObj->loadSession($clientid);
                  ?>
                </select> 
              </div>
  
              </div>
               <hr class="mb-2">
              <button class="btn btn-primary btn-lg" id="term-fee-items">Add Fee Item</button>
            </div>