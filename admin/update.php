<?php

// Include config file
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/config.php');
require_once(__ROOT__.'/headfoot/header_class.php');
require_once(__ROOT__.'/headfoot/footer_class.php');




// Define variables and initialize with empty values
$name = $mobile_no = $phone = $avenue = $street = $email = $role =  $occupancy = $addinfo = "";
$name_err = $phone_err = $avenue_err = $street_err = $email_err = $role_err = $occupancy_err = $addinfo_err = $location_err= "";

// Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
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
                    $avenue = $row["avenue"];
                    $street = $row["street"];
                    $email = $row["email"];
                    $occupancy = $row["occupancy"];
                    $role = $row["role"];
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
    }  
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
   
    
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
    
    // Validate Role
   $input_role = trim($_POST["role"]);
    if(empty($input_role)){
        $role_err = "Please enter an Value for Role.";     
    } else{
        $role = $input_role;
    }
    
    // Validate Additiional Information
   $input_addinfo = trim($_POST["addinfo"]);
    if(empty($input_addinfo)){
        $addinfo_err = "Please enter an Value for Additional Information.";     
    } else{
        $addinfo = $input_addinfo;
    }
    
    // Check input errors before inserting in database
     if(empty($name_err) && empty($phone_err) && empty($avenue_err) && empty($street_err)&& empty($email_err)&& empty($occupancy_err)&& empty($role_err)&& empty($addinfo_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET mobile_no=?, name_value=?, avenue=?,street=?, email=?, occupancy=?, role=?, addinfo=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssssi", $param_mobile_no, $param_name, $param_avenue, $param_street,$param_email, $param_occupancy, $param_role, $param_addinfo, $param_id);
            
            // Set parameters
            $param_mobile_no = $mobile_no;
            $param_name = $name_value;
            $param_avenue= $avenue;
            $param_street= $street;
            $param_email =$email;
            $param_occupancy = $occupancy;
            $param_role = $role;
            $param_addinfo= $addinfo;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: admin_home.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} 
?>
<!DOCTYPE html>
<html lang="en">

 <?php
 $nheader = new header_class();
 $nheader->head_admin_home();
 ?>

      <div id="main-wrapper" class="container">
    <div class="row justify-content-center">
        
        <div class="col-xl-10">
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="row no-gutters">

                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  enctype="multipart/form-data">
                        
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
                            <label><b>Role</b></label>
                             <select name="role"  class="form-select" aria-label="Default select example" >
                             <option selected = "<?php echo $role; ?>" > <?php echo $role; ?> </option>
                             <option value="client">Client</option>
                             <option value="admin">Admin</option>
                            </select>
                             <span class="invalid-feedback"><?php echo $role_err; ?></span>
                        </div>
                        
                        
                        
                         <div class="form-group">
                            <label><b>Additional Information</b></label>
                            <input type="text" name="addinfo" class="form-control <?php echo (!empty($addinfo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $addinfo; ?>">
                            <span class="invalid-feedback"><?php echo $addinfo_err;?></span>
                        </div>
                        
                        <div class="form-group">
                            <p><label><b> Submit | Navigate</b> </label></p>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="/admin/admin_home.php" class="btn btn-primary">Back</a>
                        </div>
                    </form>
                    
        </div><!-- comment -->
        </div>
        </div></div></div></div>        
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