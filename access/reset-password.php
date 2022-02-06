<?php

// Include config file
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/config.php');
require_once(__ROOT__.'/headfoot/header_class.php');
require_once(__ROOT__.'/headfoot/footer_class.php');

?>



<?php
// Initialize the session
session_start();
 
//Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
   header("location: login.php");
   exit;
}
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">

        
 <?php
 $nheader = new header_class();
 $nheader->head_reset_pass();

 ?>
    
    <div id="main-wrapper" class="container">
    <div class="row justify-content-center">
        
        <div class="col-xl-10">
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="row no-gutters">

    
    <div class="wrapper">
        <div class="container-fluid">
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            
            
                        
            <div class="rf-input-container"><i class="fa fa-key rf-icon">
                </i><input class="form-control rf-input-field" type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>" placeholder="New Password">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
            </div>
             <div class="rf-input-container"><i class="fa fa-key rf-icon">
                </i><input class="form-control rf-input-field" type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" placeholder="Confirm Password">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            
           
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link ml-2" href="/access/logout.php">Cancel</a>
            </div>
        </form>
    </div>  
        </div> 
                           </div> 
                       </div> 
                   </div> 
               </div> 
           </div> 
           </div> 
 <?php
 
 $nfooter = new footer_class();
 $nfooter->foot_main();
 
 ?>
    
</html>