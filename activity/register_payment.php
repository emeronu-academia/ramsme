<?php

// Include config file
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/config.php');

// Define variables and initialize with empty values
$name = $mobile_no = $remark = $attachment = $pay_date = $amount="";
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


    $sql = "SELECT * FROM users WHERE mobile_no = ?";

             
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
                  
                    $name_value = $row["name_value"];
                    $mobile_no = $row["mobile_no"];
                                        
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
     
    // Validate amount
    $input_amount = trim($_POST["amount"]);
    if(empty($input_amount)){
        $amount_err = "Please enter the amount paid.";
    }  else{
        $amount = $input_amount;
    }
    
    // Validate name
    $input_remark = trim($_POST["remark"]);
    if(empty($input_remark)){
        $remark_err = "Please enter your Remark.";
    } elseif(!filter_var($input_remark, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $remark_err = "Please enter a valid Remark.";
    } else{
        $remark = $input_remark;
    }
    
    //// Immage File Processing Begin
        $docFile = $_FILES['user_doc']['name'];
        $tmp_dir = $_FILES['user_doc']['tmp_name'];
        $docSize = $_FILES['user_doc']['size'];
        
                             
        if(empty($docFile))
         {
            $errMSG = "Please Select Document File.";
         }
         else
        {
      
         // echo $upload_dir;
         $docExt = strtolower(pathinfo($docFile,PATHINFO_EXTENSION)); // get image extension
  
        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'pdf','doc', 'docx', 'rtf', 'txt'); // valid extensions
        
        $docFilename =  "doc" . $mobile_no . $docFile;
           
        // allow valid image file formats
        if(in_array($docExt, $valid_extensions))
        {   
        // Check file size '5MB'
        if($docSize < 5000000)   
            {
             move_uploaded_file($tmp_dir,"upload/doc/" . $docFilename);			
	     $attachment = $docFilename;
            }
            else
            {
            $errMSG = "Sorry, your file is too large.";
            }
                }
        else{
           $errMSG = "Sorry, only JPG, JPEG, PNG , GIF 'PDF',DOC & DOCX files are allowed.";  
            }
        }
                                                        
        //
   
     // Validate Date
    $input_date = trim($_POST["pay_date"]);
    if(empty($input_date)){
        $date_err = "Please enter an Value for the Date.";     
    } else{
        $pay_date = $input_date;
    }
    
    
                   
         $sql = "INSERT INTO payments (mobile_no,name_value, pay_date, amount, attachment,remark) VALUES (?,?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_mobile_no,$param_name_value, $param_date, $param_amount, $param_attachment,$param_remark );
            
            // Set parameters
            $param_mobile_no = $mobile_no;
            $param_name_value = $name_value;
            $param_date = $pay_date;
            $param_amount = $amount;
            $param_attachment = $attachment;
           $param_remark = $remark;
            //
      
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: ../index.php");
            } 
            else
            {
                // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    echo "Oops! Something went wrong. Please try again later.";
                    exit();
               
            }

            // Close statement
            mysqli_stmt_close($stmt);
            // Close connection
            mysqli_close($link);
        }
    
  
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
                            <a class="dropdown-item" href="/activity/register_payment.php">Payment</a>
                            <a class="dropdown-item" href="/activity/register_complain.php">Complain</a>
                        </div>
                    </li>
                </ul><span class="navbar-text actions"> <a class="login" href="/access/logout.php" target="_self">Log Out</a><a class="btn btn-light action-button" role="button" href="../index.php" target="_self">Home</a></span>
            </div>
        </div>
    </nav>
           <div class="row">
                <div class="col-md-10">
                    <h2 class="mt-5">My Account</h2>
                    <p>Any Complains? ...Forward your complain via this platform</p>
                    
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" enctype="multipart/form-data" method="post">
                        
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
                            <label><b>Amount Paid</b></label>
                            <input type="text" name="amount" class="form-control" required>
                            <span class="invalid-feedback"><?php echo $amount_err;?></span>
                        </div>
                        
                        <!-- comment -->
                        <div class="form-group">
                            <label><b>Date</b></label>
                            <input id="complaindate" type="date" name="pay_date" class="form-control" required="">
                            <span class="invalid-feedback"><?php echo $date_err;?></span>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1" class="form-label"><b>Additional Information: Remarks/Comments </b> </label>
                          <textarea class="form-control" id="exampleFormControlTextarea1" name = "remark" rows="4" required></textarea>
                            
                        </div>
                        
                      <div class="form-group">
                            <label><b>Attachment: Support Document </b></label>
                            <p><a id="blah" href="" target ="_blank">view uploaded file</a></p>                                                       
                            <p> <input id="imgInp"  type="file" name="user_doc" /></p>
                      </div>
                        
                    <div class="form-group">
                            <p><label> <b>Submit | Navigate</b> </label></p>
                         <input type="submit" class="btn btn-primary" value="Submit"> |
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
                        blah.href = URL.createObjectURL(file)
         
                        }
              
            }
            </script>
            <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
</body>
       
   
        <!-- comment -->
    
    
    
</html>

