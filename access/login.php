<?php

// Include config file
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/config.php');
require_once(__ROOT__.'/headfoot/header_class.php');
require_once(__ROOT__.'/headfoot/footer_class.php');

?>

<?php
session_start(); // Initialize the session

     
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)  // Check if the user is already logged in
{ 
    header("location: /access/account.php");
    exit();
}



// Define variables and initialize with empty values
$mobile_no = $id= $name_value = $role = $password = "";
$mobile_no_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["mobile_no"]))){
        $mobile_no_err = "Please enter Mobile Number.";
    } else{
        $mobile_no = trim($_POST["mobile_no"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($mobile_no_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, mobile_no, name_value, role, password FROM users WHERE mobile_no = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_mobile_no);
            
            // Set parameters
            $param_mobile_no = $mobile_no;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $mobile_no, $name_value, $role, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["registeration"] = false;
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["mobile_no"] = $mobile_no; 
                            $_SESSION["name_value"] = $name_value;
                            $_SESSION["role"] = $role;
                            
                            if ($role==="admin")
                            {
                            // Redirect user to welcome page
                            //header("location: /crud/crud_index.php");
                             header("location: /admin/admin_home.php");   
                            }
                            else 
                            {
                                header("location: /access/account.php");
                                
                            }
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid mobile_no or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid Mobile number or password.";
                }
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
 $nheader->head_login();

 ?>

    <div class="wrapper">
        <div class="container-fluid">
        
        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
        
      
       <div id="main-wrapper" class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="row no-gutters">
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="mb-5">
                                    <h3 class="h4 font-weight-bold text-theme">Login</h3>
                                </div>
                                <h6 class="h5 mb-0">Welcome back!</h6>
                                <p class="text-muted mt-2 mb-5">Enter your email address and password to access admin panel.</p>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <div class="form-group mb-3">
                                        <label class="form-label text-secondary">Mobile Number</label><input class="form-control <?php echo (!empty($mobile_no_err)) ? 'is-invalid' : ''; ?>" type="text" required="" name="mobile_no" value="<?php echo $mobile_no; ?>">
                                        <span class="invalid-feedback"><?php echo $mobile_no_err; ?></span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label text-secondary">Password</label><input class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" type="password" name="password" required="">
                                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                                    </div>
                        <button class="btn btn-info mt-2" type="submit">Log In</button>
                    </form>
                   
                      <p>Don't have an account? <a href="/access/register.php">Sign up now</a></p>
                            </div>
                        </div>
                        <div class="col-lg-6 d-none d-lg-inline-block">
                            <div class="account-block rounded-right">
                                <div class="overlay rounded-right"></div>
                                <div class="account-testimonial">
                                    <h4 class="text-white mb-4">This beautiful theme yours!</h4>
                                    <p class="lead text-white">&quot;Best investment i made for a long time. Can only recommend it for other users.&quot;</p>
                                    <p>- Admin User</p>
                                </div>
                            </div>
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
 
 $nfooter = new footer_class();
 $nfooter->foot_main();
 
 ?>
</html>


