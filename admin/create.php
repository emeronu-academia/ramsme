
<?php

// Include config file
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/config.php');

?>

<?php

  
// Define variables and initialize with empty values
$mobile_no = $name_value= $addinfo = $occupancy = $role = $email= $avenue = $street = $password = $confirm_password = "";
$mobile_no_err = $name_err = $role_err = $addinfo_err = $email_err= $avenue_err = $street_err = $password_err = $confirm_password_err = "";
 

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    //
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
    
     // Validate Role
    if(empty(trim($_POST["role"]))){
        $role_err = "Please select the role that applies";
    } elseif(!filter_var(trim($_POST["role"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))))
    {
        $role_err = "Role should either be Admin or Client";
    } else{
        $role = trim($_POST["role"]);
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
    
     // Validate Additional Information
    if(empty(trim($_POST["addinfo"]))){
        $addinfo_err = "Please Enter Additional Information.";
    } elseif(!filter_var(trim($_POST["addinfo"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9\s]+$/"))))
    {
        $addinfo_err = "Addional Informatio  Not Inserted";
    } else{
        $addinfo = trim($_POST["addinfo"]);
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
  
        // rename uploading image
        $userpic = rand(1000,1000000).".".$imgExt;
    
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
            
          
        // Prepare an insert statement
        $sql = "INSERT INTO users (mobile_no,name_value, avenue, street, email, occupancy, role,location,addinfo, password) VALUES (?,?,?,?,?,?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssssss", $param_mobile_no, $param_name,$param_avenue, $param_street,$param_email,$param_occupancy,$param_role, $param_location, $param_addinfo,$param_password);
            
            // Set parameters
            $param_mobile_no = $mobile_no;
            $param_name = $name_value;
            $param_location = $location;
            $param_occupancy = $occupancy;
            $param_role = $role;
            $param_email = $email;
            $param_avenue = $avenue;
            $param_street = $street;
            $param_addinfo = $addinfo;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
          
          //
      
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                // Redirect to login page
                header("location: admin_home.php");
            } 
            else
            {
                echo "Oops! Something went wrong. Please try again later.";
            ?>   
                <div class="container">
                <div class="alert alert-warning">
                <strong>SORRY!</strong> <?php echo "Something went wrong. Please try again later and ensure mobile number has not been used"; ?> 
                </div>
                </div>
            <?php 
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


 