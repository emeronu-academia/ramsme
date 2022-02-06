<?php

// Include config file
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/config.php');
require_once(__ROOT__.'/headfoot/header_class.php');
require_once(__ROOT__.'/headfoot/footer_class.php');

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
    
    //// Immage File Processing Begin
        $imgFile = $_FILES['v_user_image']['name'];
        $tmp_dir = $_FILES['v_user_image']['tmp_name'];
        $imgSize = $_FILES['v_user_image']['size'];
                        
        if(empty($imgFile))
         {
            $errMSG = "Please Select Image File.";
         }
         else
        {
      
         // echo $upload_dir;
         $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
  
        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
  
           
        // allow valid image file formats
        if(in_array($imgExt, $valid_extensions))
        {   
        // Check file size '5MB'
        if($imgSize < 5000000)   
            {
             move_uploaded_file($tmp_dir,"upload/" . $imgFile);			
	     $location = $imgFile;
            
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
                                                        
        //
   
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
                header("location: logout.php");
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



//
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
        

?>
//
 
<!DOCTYPE html>
<html lang="en">
    
<?php
 $nheader = new header_class();
 $nheader->head_account();
 ?>
    
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10">
                    <h2 class="mt-5">My Account</h2>
                    <p>You May Update Your Details</p>
                    
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" enctype="multipart/form-data" method="post">
                        
                        <div class="form-group">
                            <label><b>Mobile Number</b></label>
                            <input type="text" name="mobile_no" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mobile_no; ?>">
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
                            <p><img id="blah" src="upload/<?php echo $location ; ?>" width="100px" height="100px" style="border:1px solid #333333;"></p>
			    <?php else: ?>
                            <p><img id="blah" src="../images/default.png" width="100px" height="100px"></p>
			    <?php endif; ?>
                            
                             <input id="imgInp"  type="file" name="v_user_image" accept="image/*"/>
                                                    
                                                      
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
                             <option selected ="landlord">Landlord</option>
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
                         <input type="submit" class="btn btn-primary" value="Submit">
                         <a href="/access/reset-password.php" class="btn btn-warning">Reset Your Password</a> 
                        </div>
                        
                        <div class="form-group">
                             <p> </p>
                         <a href="/activity/register_payment.php" class="btn btn-danger">Update Records</a> |
                         <a href="/activity/register_complain.php" class="btn btn-info">Complain</a> |
                         <a href="/activity/make_payment.php" class="btn btn-secondary">Payment</a>
                        </div><!-- comment -->
                    </form>
                </div>
                
            </div>        
        </div>
    </div>
    
    <script>
            imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                        blah.src = URL.createObjectURL(file)
                        
                        }
              
            }
            </script>

    
    <?php
 
 $nfooter = new footer_class();
 $nfooter->foot_main();
 
 ?>
    
</html>

