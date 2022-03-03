<<!DOCTYPE html>
<html lang="en">

<?php
include '../mainHF/header_home.php';
 ?>
    
    <div id="main-wrapper" class="container">
    <div class="row justify-content-center">
        
        <div class="col-xl-10">
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="row no-gutters">
    
    <div class="rf-register-form">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Missing Document!</h2>
                
                    <div class="alert alert-danger">Kindly Report your Findings to 08177259069, Please click to  <?php   $url = htmlspecialchars($_SERVER['HTTP_REFERER']);  echo "<a href='$url'>Go Back</a>";  ?> </div>
                </div>
            </div>        
        </div>
    </div>
                    </div>
            </div>
        </div>
    </div>
    </div>
 <?php
include '../mainHF/footer.php'; 
 ?>
    
</html>