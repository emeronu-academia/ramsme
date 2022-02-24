<?php
  ob_start();
?>


<?php

// Include config file

define('__ROOT__', dirname(dirname(__FILE__),2));
require_once(__ROOT__.'/config.php');
include_once(__ROOT__.'/qrcode/qrlib.php');


// Define variables and initialize with empty values
$name_value = $mobile_no = $due = $paid = $difference = "";
$name_err = $mobile_no_err = $complain_err = $attachment_err= $date_err = "";
 
// Display Exist Content
session_start(); // Initialize the session

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)// Check if the user is logged in, if not then redirect him to login page
{
    header("location: /access/login.php");
    exit();
}


// Display Previous Record Content
 // Prepare a select statement


   // $sql = "SELECT * FROM users WHERE mobile_no = ?";
$sql = "select DISTINCT users.name_value Name, users.mobile_no mobile, amount_due(users.occupancy, users.no_rooms, users.effective_date) due, sum(pay_sec_update.amount) paid, amount_due(users.occupancy, users.no_rooms, users.effective_date)- sum(pay_sec_update.amount) difference from users INNER JOIN pay_sec_update where users.mobile_no = pay_sec_update.mobile_no and users.mobile_no = ?";

             
      if($stmt = mysqli_prepare($link, $sql))
      {
              // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_mobile_no);
        
        // Set parameters
        $param_mobile_no = trim($_SESSION["mobile_no"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                // Retrieve individual field value
                  
                    
                    $mobile_no = $row["mobile"];
                    $name_value = $row["Name"];
                    $due = $row["due"];
                    $paid = $row["paid"];
                    $difference = $row["difference"];
                   
                                        
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
           // Close connection
    mysqli_close($link);
    //
 ?>
    <!DOCTYPE html>
<html lang="en">
   
 <?php   
//HEADER
 include 'adminSCS/sec_header.php';
  ?>
    

     <div id="main-wrapper" class="container">
    <div class="row justify-content-center">
        
        <div class="col-xl-10">
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="row no-gutters">
    
    <div class="rf-register-form">
            
   
           <div class="row">
                <div class="col-md-10">
                    <h2 class="mt-5">My Account</h2>
                    <p>Payment Details</p>
                    
                    <form action="personal_status_prnt.php" method="post">
                        
                        <div class="form-group">
                            <label><b>Mobile Number</b></label>
                            <input type="text" name="mobile_no" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mobile_no; ?>" readonly>
                            <span class="invalid-feedback"><?php echo $phone_err;?></span>
                        </div><!-- comment -->
                        
                        <div class="form-group">
                            <label><b>Name</b></label>
                            <input type="text" name="name_value" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name_value; ?>" readonly>
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                                              
                        <div class="form-group">
                            <label><b>Cumulative Amount Due</b></label>
                            <input type="text" name="due" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $due; ?>" readonly>
                            
                        </div>
                        
                        <div class="form-group">
                            <label><b>Amount Paid so Far </b></label>
                            <input type="text" name="paid" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $paid; ?>" readonly>
                            
                        </div>
                        
                        <div class="form-group">
                            <label><b>Uncleared Balance</b></label>
                            <input type="text" name="difference" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $difference; ?>" readonly>
                            
                        </div>
                        
                        <div class="form-group">
                         <?php
                               $tempDir = "tempdir/";
    
                     // we building raw data
                       $codeContents  = 'BEGIN:VCARD'."\n";
                       $codeContents .= 'FN:'.$name_value."\n";
                       $codeContents .= 'TEL:'.$mobile_no."\n";
                       $codeContents .= 'END:VCARD';
    
                   // generating
                  QRcode::png($codeContents, $tempDir.'025.png', QR_ECLEVEL_L, 3);
   
                    // displaying
                   echo '<img src="'.$tempDir.'025.png" />'; 
                         ?>
                        </div>
                          
                    <div class="form-group">
                            <p><label> <b>Submit | Navigate</b> </label></p>
                         <input type="submit" class="btn btn-primary" value="Print Receipt"> |
                         <a href="../access/logout.php" class="btn btn-danger">Close</a>
                     </div>
                      
                    </form>
                </div>
                
            </div>  
            
                     </div>
    </div>
                </div><!-- comment -->
            </div><!-- comment -->
            </div>
    </div>
    </div>


<?php
 include 'adminSCS/sec_footer.php';
 ?>
    
</html>

<?php
  ob_end_flush();
?>




