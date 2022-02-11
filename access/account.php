<?php

// Include config file
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/config.php');

// Define variables and initialize with empty values
$name = $mobile_no = $phone = $avenue = $street = $location = $email = $role = $occupancy = $addinfo = "";
$name_err = $phone_err = $avenue_err = $location_err= $street_err = $email_err = $role_err = $occupancy_err = $addinfo_err = "";
 
// Display Exist Content
session_start(); // Initialize the session

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)// Check if the user is logged in, if not then redirect him to login page
{
    header("location: /access/login.php");
    exit();
}

// Display Previous Record Content
 // Prepare a select statement


    $sql = "SELECT * FROM users WHERE mobile_no = ?";

             
      if($stmt = mysqli_prepare($link, $sql))
      {
              // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_mobile_no);
        
        // Set parameters
        $param_mobile_no = trim(  $_SESSION["mobile_no"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                // Retrieve individual field value
                  
                    $name_value = $row["name_value"];
                    $mobile_no = $row["mobile_no"];
                    $location = $row["location"];
                    $avenue = $row["avenue"];
                    $street = $row["street"];
                    $email = $row["email"];
                    $occupancy = $row["occupancy"];
                    $addinfo = $row["addinfo"];
                    // Capture current iamge name as $prev_location
                    $prev_location = $location;
                    
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
   // mysqli_close($link);

    
                  
// Processing form data when form is submitted
if(isset($_POST["mobile_no"]) && !empty($_POST["mobile_no"]))
{        
    // Validate phone
    $input_phone = trim($_POST["mobile_no"]);
    if(empty($input_phone)){
        $phone_err = "Please enter the Phone Number.";     
    } elseif(!ctype_digit($input_phone)){
        $phone_err = "Please enter a Number.";
    } else{
        $mobile_no = $input_phone;
    }
           
    // Validate name
    $input_name = trim($_POST["name_value"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name_value = $input_name;
    }
    
  
    
    //// Image File Processing Begin

    // Process Updated Image -start
        
        $imgFile = $_FILES['v_user_image']['name'];
        $tmp_dir = $_FILES['v_user_image']['tmp_name'];
        $imgSize = $_FILES['v_user_image']['size'];
                 
        if(empty($imgFile) || !isset($imgFile))
         {
         //Image File not selected, use exiting one saved as $prev_location
            $location = $prev_location;
         }
         else
        {
        //Image File selected, obtain new Image file 
        //Extract File Extension
         $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
          // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        //$imgFilename =  "img". $mobile_no ."." . $imgExt;
        $imgFilename =  $mobile_no ."-" . $_FILES['v_user_image']['name'];
        
         // allow valid image file formats
        if(in_array($imgExt, $valid_extensions))
        {   
        // Check file size '5MB'
        if($imgSize < 5000000)   
            {
            // Update New Image and Delete Previous Image 
            // Update New Image and assign to Database 
             move_uploaded_file($tmp_dir,"../upload/img/" . $imgFilename);			
	     $location = $imgFilename;
              //
             
            }
            else
            {
            $errMSG = "Sorry, your file is too large.";
            }
                }
        else{
           $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";  
            }
        }
        
   
     // Validate Avenue
    $input_avenue = trim($_POST["avenue"]);
    if(empty($input_avenue)){
        $avenue_err = "Please enter an Value for Avenue.";     
    } else{
        $avenue = $input_avenue;
    }
       
    // Validate Street
   $input_street = trim($_POST["street"]);
    if(empty($input_street)){
        $street_err = "Please enter an Value for Street.";     
    } else{
        $street = $input_street;
    }
    
    // Validate Email
   $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter an Value for Email.";     
    } else{
        $email = $input_email;
    }
    
    // Validate Occupancy
   $input_occupancy = trim($_POST["occupancy"]);
    if(empty($input_occupancy)){
        $occupancy_err = "Please enter an Value for Occupancy.";     
    } else{
        $occupancy = $input_occupancy;
    }
    
       
    // Validate Additiional Information
   $input_addinfo = trim($_POST["addinfo"]);
    if(empty($input_addinfo)){
        $addinfo_err = "Please enter an Value for Additional Information.";     
    } else{
        $addinfo = $input_addinfo;
    }
    
    // Check input errors before inserting in database
     if(empty($name_err) && empty($phone_err) && empty($avenue_err) && empty($street_err)&& empty($email_err)&& empty($occupancy_err) && empty($addinfo_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET  name_value=?, location=?, avenue=?,street=?, email=?, occupancy=?, addinfo=? WHERE mobile_no=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssss",  $param_name, $param_location, $param_avenue, $param_street,$param_email, $param_occupancy, $param_addinfo, $param_mobile_no);
            
            // Set parameters
            $param_mobile_no = $mobile_no;
            $param_name = $name_value;
            $param_location = $location;
            $param_avenue= $avenue;
            $param_street= $street;
            $param_email =$email;
            $param_occupancy = $occupancy;
            $param_addinfo= $addinfo;
           
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: account.php");
                exit();
            } else{
                header("location: error.php");
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
 } 

 
        

?>

 <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>RAMSME | My Account</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/White-Footer.css">
    
     <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>  
       
</head>
<body id="page-top">
    
    <div id="main-wrapper" class="container">
    <div class="row justify-content-center">
        
        <div class="col-xl-10">
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="row no-gutters">
    
    <div class="rf-register-form">
            
    <nav class="navbar navbar-light navbar-expand-lg navigation-clean-button">
        <div class="container"><a class="navbar-brand" href="#">RAMSME</a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="about_us.php" target="_self">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="/paystack/initialize.php" target="_self">Pay</a></li>
                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">Register</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="../activity/register_payment.php">Payment</a>
                            <a class="dropdown-item" href="../activity/register_complain.php">Complain</a>
                        </div>
                    </li>
                </ul><span class="navbar-text actions"> <a class="login" href="/access/logout.php" target="_self">Log Out</a><a class="btn btn-light action-button" role="button" href="../index.php" target="_self">Home</a></span>
            </div>
        </div>
    </nav>
           <div class="row">
                <div class="col-md-10">
                    <h2 class="mt-5">My Account</h2>
                    <p>You May Update Your Details</p>
                    
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" enctype="multipart/form-data" method="post">
                        
                        <div class="form-group">
                            <label><b>Mobile Number</b></label>
                            <input type="text" name="mobile_no" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mobile_no; ?>" readonly>
                            <span class="invalid-feedback"><?php echo $phone_err;?></span>
                        </div><!-- comment -->
                        
                        <div class="form-group">
                            <label><b>Name</b></label>
                            <input type="text" name="name_value" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name_value; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        
                      <div class="form-group">
                            <label><b>Passport</b></label>
                          
                            <?php if($location != ""): ?>
                            <p><img id="blah" src="../upload/img/<?php echo $location ; ?>" width="100px" height="100px" style="border:1px solid #333333;"></p>
			    <?php else: ?>
                             <p><img id="blah" src="../images/default.png" width="100px" height="100px"></p
			    <?php endif; ?>
                            
                            <p> <input id="imgInp"  type="file" name="v_user_image" accept="image/*"/></p>
                                                     
                        </div>
                        
                        <div class="form-group">
                            <label><b>Avenue</b></label>
                            <input type="text" name="avenue" class="form-control <?php echo (!empty($avenue_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $avenue; ?>">
                            <span class="invalid-feedback"><?php echo $avenue_err;?></span>
                        </div>
                        <div class="form-group">
                            <label><b>Street</b></label>
                            <input type="text" name="street" class="form-control <?php echo (!empty($street_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $street; ?>">
                            <span class="invalid-feedback"><?php echo $street_err;?></span>
                        </div>
                        
                        <div class="form-group">
                            <label><b>Email</b></label>
                            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        
                        <div class="form-group">
                            <label><b>Occupancy</b></label>
                             <select name="occupancy"  class="form-select" aria-label="Default select example" >
                             <option selected = "<?php echo $occupancy; ?>" > <?php echo $occupancy; ?> </option>
                             <option value="landlord">Landlord</option>
                             <option value="tenant">Tenant</option>
                             <option value="tenant-special">Special Tenant</option>
                            </select>
                             <span class="invalid-feedback"><?php echo $occupancy_err; ?></span>
                        </div>
                        
                                                 
                         <div class="form-group">
                            <label><b>Additional Information</b></label>
                            <input type="text" name="addinfo" class="form-control <?php echo (!empty($addinfo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $addinfo; ?>">
                            <span class="invalid-feedback"><?php echo $addinfo_err;?></span>
                        </div>
                        
                        <div class="form-group">
                            <p><label> <b>Submit | Navigate</b> </label></p>
                         <input type="submit" class="btn btn-primary" value="Submit"> |
                         <a href="/access/reset-password.php" class="btn btn-warning">Reset Your Password</a> |
                          <a href="../access/logout.php" class="btn btn-danger">Close</a>
                        </div>
                        
                      <!--  <div class="form-group">
                             <p> </p>
                         <a href="/activity/register_payment.php" class="btn btn-danger">Update Records</a> |
                         <a href="/activity/register_complain.php" class="btn btn-info">Complain</a> |
                         <a href="/activity/make_payment.php" class="btn btn-secondary">Payment</a>
                        </div> -->
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
            
    
    
    
    <script>
            imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                        blah.src = URL.createObjectURL(file)
                        
                        }
              
            }
            </script>
            <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
</body>
       
   
        <!-- comment -->
    
    
    
</html>

