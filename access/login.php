<?php
  ob_start();
?>
<?php

// Include config file
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/config.php');

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
                       // $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["mobile_no"] = $mobile_no; 
                            $_SESSION["name_value"] = $name_value;
                            $_SESSION["role"] = $role;
                            
                            if ($role==="admin")
                            {
                            // Redirect user to welcome page
                            //header("location: /crud/crud_index.php");
                             header("location: ../admin/admin_home.php");   
                            }
                            else 
                            {
                                header("location: ../access/account.php");
                                
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
    
    
 <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>RAMSME | Login</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
     <link rel="stylesheet" href="../assets/css/White-Footer.css">
    <link rel="stylesheet" href="../assets/css/Login-with-overlay-image.css">
     <style>
        .wrapper{
            width: 1500px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>  
</head>
<body id="page-top">
    
    <nav class="navbar navbar-light navbar-expand-lg navigation-clean-button">
        <div class="container"><a class="navbar-brand" href="#">RAMSME</a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="about_us.php" target="_self">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="/paystack/initialize.php" target="_self">Pay</a></li>
                  <!--  <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">Dropdown </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/paystack/initialize.php">Pay</a>
                            <a class="dropdown-item" href="#">Second Item</a>
                            <a class="dropdown-item" href="#">Third Item
                         </a></div>
                    </li> -->
                </ul><span class="navbar-text actions"> <a class="login" href="/access/logout.php" target="_self">Log Out</a><a class="btn btn-light action-button" role="button" href="/access/register.php" target="_self">Sign Up</a></span>
            </div>
        </div>
    </nav>

    <div id="main-wrapper" class="container">
        <div class="row justify-content-center">
        
        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
      
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
              
        </div>
    </div>

   

        
         </div>
    </div>
  



 <footer class="footer_area section_padding_130_0">
      <div class="container" >
        <div class="row">
          <!-- Single Widget-->
          <div class="col-12 col-sm-6 col-lg-4">
            <div class="single-footer-widget section_padding_0_130">
              <!-- Footer Logo-->
              <div class="footer-logo mb-3"></div>
              <p>Residents Association of Ministry of Mines and Steel MidHill Estate Managment Suites.</p>
              
              <div class="copywrite-text mb-5">
                <p class="mb-0">Made with <i class="lni-heart mr-1"></i>by<a class="ml-1" href="https://ejosytechconsult.com"> Ejosy Tech Consult Ltd</a></p>
              </div>
              <!-- Footer Social Area-->
              <div class="footer_social_area"><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Facebook"><i class="fa fa-facebook"></i></a><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Pinterest"><i class="fa fa-pinterest"></i></a><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Skype"><i class="fa fa-skype"></i></a><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Twitter"><i class="fa fa-twitter"></i></a></div>
            </div>
          </div>
          <!-- Single Widget-->
          <div class="col-12 col-sm-6 col-lg">
            <div class="single-footer-widget section_padding_0_130">
              <!-- Widget Title-->
              <h5 class="widget-title">About</h5>
              <!-- Footer Menu-->
              <div class="footer_menu">
                <ul>
                  <li><a href="about_us.php">About Us</a></li>
                  <li><a href="#">Terms &amp; Policy</a></li>
                  <li><a href="#">Community</a></li>
                </ul>
              </div>
            </div>
          </div>
          <!-- Single Widget-->
          <div class="col-12 col-sm-6 col-lg">
            <div class="single-footer-widget section_padding_0_130">
              <!-- Widget Title-->
              <h5 class="widget-title">Support</h5>
              <!-- Footer Menu-->
              <div class="footer_menu">
                <ul>
                  <li><a href="#">Help</a></li>
                  <li><a href="#">Support</a></li>
                  <li><a href="#">Privacy Policy</a></li>
                  </ul>
              </div>
            </div>
          </div>
          <!-- Single Widget-->
          <div class="col-12 col-sm-6 col-lg">
            <div class="single-footer-widget section_padding_0_130">
              <!-- Widget Title-->
              <h5 class="widget-title">Contact</h5>
              <!-- Footer Menu-->
              <div class="footer_menu">
                <ul>
                  <li><a href="#">Contact Us</a></li>
                  
                </ul>
              </div>
            </div>
          </div>
        </div>
          <p>©&nbsp; Ejosy Tech Consult Ltd 2022. All Rights Reserved.</p>
      </div>
    </footer>
   
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    
    </body>
</html>


<?php
  ob_end_flush();
?>