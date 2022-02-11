
<?php

// Include config file
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/config.php');
require_once(__ROOT__.'/headfoot/header_class.php');
require_once(__ROOT__.'/headfoot/footer_class.php');

// Define variables and initialize with empty values
$mobile_no = $name_value= $occupancy = $location = $email= $avenue = $street = $password = $confirm_password = "";
$mobile_no_err = $name_err = $location_err = $email_err= $avenue_err = $street_err = $password_err = $confirm_password_err = "";

?>


<?php
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")

{    
    // Validate Mobile Number
    if(empty(trim($_POST["mobile_no"]))){
        $mobile_no_err  = "Please enter a mobile number.";
    } elseif (!ctype_digit(trim($_POST["mobile_no"])))
    {
        $mobile_no_err = "Mobile Number can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE mobile_no = ?";
        
        if($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_mobile_no);
            
            // Set parameters
            $param_mobile_no = trim($_POST["mobile_no"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $mobile_no_err = "This mobile number is already taken.";
                } else{
                    $mobile_no = trim($_POST["mobile_no"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
      // Validate name
    if(empty(trim($_POST["name_value"]))){
        $name_err = "Please enter your Name.";
    } elseif(!filter_var(trim($_POST["name_value"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))))
    {
        $name_err = "Name can only contain letters, numbers, and underscores.";
    } else{
        $name_value = trim($_POST["name_value"]);
    }
    
     // Validate occupancy
    if(empty(trim($_POST["occupancy"]))){
        $occupancy_err = "Please select the occupancy that applies";
    } elseif(!filter_var(trim($_POST["occupancy"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))))
    {
        $occupancy_err = "Occupancy should either be Landload, Tenant or Tenant [Special]";
    } else{
        $occupancy = trim($_POST["occupancy"]);
         }
       
    
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL))
    {
        $email_err = "Email can only contain letters, numbers, and underscores.";
    } else{
        $email = trim($_POST["email"]);
    }
    // Validate Avenue
    if(empty(trim($_POST["avenue"]))){
        $avenue_err = "Please enter an Avenue Address.";
    } elseif(!filter_var(trim($_POST["avenue"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9\s]+$/"))))
    {
        $avenue_err = "Avenue can only contain letters, numbers, and underscores.";
    } else{
        $avenue = trim($_POST["avenue"]);
    }
    // Validate Street
    if(empty(trim($_POST["street"]))){
        $street_err = "Please enter  Street Address.";
    } elseif(!filter_var(trim($_POST["street"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9\s]+$/"))))
    {
        $street_err = "Street can only contain letters, numbers, and underscores.";
    } else{
        $street = trim($_POST["street"]);
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
        $imgFilename =  $mobile_no ."-" . $_FILES['v_user_image']['name'];;
        // allow valid image file formats
        if(in_array($imgExt, $valid_extensions))
        {   
        // Check file size '5MB'
        if($imgSize < 5000000)   
            {
             move_uploaded_file($tmp_dir,"../upload/img/" . $imgFilename);			
	     $location = $imgFilename;
            
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
 
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else
    {
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password))
        {
            $confirm_password_err = "Password did not match.";
        }
    }
    
    
    // Check input errors before inserting in database
            
        // Prepare an insert statement
        $sql = "INSERT INTO users (mobile_no, name_value, location, occupancy, email, avenue, street, password) VALUES (?,?,?,?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssss", $param_mobile_no, $param_name, $param_location, $param_occupancy, $param_email, $param_avenue, $param_street, $param_password);
            
            // Set parameters
            $param_mobile_no = $mobile_no;
            $param_name = $name_value;
            $param_location = $location;
            $param_occupancy = $occupancy;
            $param_email = $email;
            $param_avenue = $avenue;
            $param_street = $street;               
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
          //
      
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } 
            else
            {
                
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    
   
    // Close connection
    mysqli_close($link);

}
// Function defnition
function function_alert($message) {
      
    // Display the alert box 
    echo "<script>alert('$message');</script>";
}
?>
 
<!DOCTYPE html>
<html lang="en">
    
 <?php
 $nheader = new header_class();
 $nheader->head_register();

 ?>
        
    <div id="main-wrapper" class="container">
    <div class="row justify-content-center">
        
        <div class="col-xl-10">
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="row no-gutters">
    
    <div class="rf-register-form">
        <form class="rg-form"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" method="post">
            <h2>Register a New Account</h2>
            <p>Please fill this form to create an account.</p>
            
             <div class="rf-input-container"><i class="fa fa-mobile-phone rf-icon"></i>
                <input class="form-control rf-input-field" type="text" name="mobile_no" class="form-control <?php echo (!empty($mobile_no_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mobile_no; ?>" placeholder="Mobile Number" required>
                <span class="invalid-feedback"><?php echo $mobile_no_err; ?></span>
             </div>
                                      
            
            <div class="rf-input-container"><i class="fa fa-user rf-icon"></i>
                <input class="form-control rf-input-field" type="text" name="name_value" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name_value; ?>" placeholder="Name" required>
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>
            
            <div class="form-group">
                            <label><b>Passport</b></label>
                            <p><img id="blah" src="../images/default.png" width="100px" height="100px" style="border:1px solid #333333;"><p>
                            <p><input id="imgInp"  type="file" name="v_user_image" accept="image/*" required /></p>
                                       
             </div>
                     
            
            <div class="rf-input-container"><i class="fa  fa-home rf-icon"></i>   
                              
                 <select name="occupancy"  class="form-select" aria-label="Default select example">
                    <option selected ="select">Select Occupancy Type</option>
                    <option value="landlord">Occupancy - Landlord</option>
                    <option value="tenant">Occupancy - Tenant</option>
                    <option value="tenant-special">Occupancy - Special Tenant</option>
                </select>
                <span class="invalid-feedback"><?php echo $occupancy_err; ?></span>
         
             </div>     
           
            <div class="rf-input-container"><i class="fa fa-envelope rf-icon"></i>
                <input class="form-control rf-input-field" type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder="Email" required>
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="rf-input-container"><i class="fa fa-address-book rf-icon"></i>
                <input class="form-control rf-input-field" type="text" name="avenue" class="form-control <?php echo (!empty($avenue_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $avenue; ?>" placeholder="Avenue" required>
                <span class="invalid-feedback"><?php echo $avenue_err; ?></span>
            </div>
            <div class="rf-input-container"><i class="fa fa-street-view rf-icon"></i>
                <input class="form-control rf-input-field" type="text" name="street" class="form-control <?php echo (!empty($street_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $street; ?>" placeholder="Street" required>
                <span class="invalid-feedback"><?php echo $street_err; ?></span>
            </div>
            <div class="rf-input-container"><i class="fa fa-key rf-icon">
                </i><input class="form-control rf-input-field" type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" placeholder="Password" required>
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
             <div class="rf-input-container"><i class="fa fa-key rf-icon">
                </i><input class="form-control rf-input-field" type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" placeholder="Confirm Password" required>
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            
            <div class="form-group" >
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                 <a href="../index.php" class="btn btn-primary">Cancel</a>
            </div>
        </form>
    </div>
                        
                        
        </div>  
        </div> 
           
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
