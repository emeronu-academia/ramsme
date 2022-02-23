<?php

// Include config file
define('__ROOT__', dirname(dirname(__FILE__),2));
require_once(__ROOT__.'/config.php');
require_once(__ROOT__.'/headfoot/header_class.php');
require_once(__ROOT__.'/headfoot/footer_class.php');


// Define variables and initialize with empty values
$entry = $mobile_no = $phone = $amount= $remark = $pay_date = $name_value = "";


// Check existence of entryparameter before processing further
    if(isset($_GET["entry"]) && !empty(trim($_GET["entry"]))){
        // Get URL parameter
        $entry=  trim($_GET["entry"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM pay_sec_update WHERE entry = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_entry);
            
            // Set parameters
            $param_entry= $entry;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                                     
                    $pay_date = $row["pay_date"];
                    $name_value = $row["name_value"];
                    $mobile_no = $row["mobile_no"];
                    $amount = $row["amount"];
                    $remark = $row["remark"];
                                     
                    
                   
                } else{
                    // URL doesn't contain valentryid. Redirect to error page
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
      //  mysqli_close($link);
    }  
 
// Processing form data when form is submitted
if(isset($_POST["entry"]) && !empty($_POST["entry"]))
{
    // Get hidden input value
    $entry= $_POST["entry"];
   
    
    // Validate phone
    $input_phone = trim($_POST["mobile_no"]);
    if(empty($input_phone)){
        $phone_err = "Please enter the Phone Number.";     
    } elseif(!ctype_digit($input_phone)){
        $phone_err = "Please enter a Number.";
    } else{
        $mobile_no = $input_phone;
    }
    
    // Validate Date
    $input_pay_date = trim($_POST["pay_date"]);
    $pay_date = $input_pay_date;
    
           
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
    $input_amount = trim($_POST["amount"]);
    if(empty($input_amount)){
        $amount_err = "Please enter an Value for Amount Paid.";     
    } else{
        $amount = $input_amount;
    }
       
    // Validate Street
   $input_remark = trim($_POST["remark"]);
    if(empty($input_remark)){
        $remark_err = "Please enter an Value for Street.";     
    } else{
        $remark = $input_remark;
    }
    
    
    
    // Check input errors before inserting in database
    
        // Prepare an update statement
        $sql = "UPDATE pay_sec_update SET mobile_no=?, name_value=?, pay_date=?, amount=?, remark=? WHERE entry = ?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssi", $param_mobile_no, $param_name, $param_pay_date, $param_amount, $param_remark, $param_entry);
            
            // Set parameters
            $param_mobile_no = $mobile_no;
            $param_name = $name_value;
            $param_pay_date = $pay_date;
            $param_amount= $amount;
            $param_remark= $remark;
            $param_entry = $entry;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: sec_pay_update.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    
    
    // Close connection
    mysqli_close($link);
} 
?>
<!DOCTYPE html>
<html lang="en">

 <?php
 include 'adminHF/sec_header.php';
 ?>

      <div id="main-wrapper" class="container">
    <div class="row justify-content-center">
        
        <div class="col-xl-10">
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="row no-gutters">

                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update Payment history</p>
                    
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  enctype="multipart/form-data">
                        
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
                            <label><b>Date</b></label>
                            <input type="date" name="pay_date" class="form-control <?php echo (!empty($pay_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $pay_date; ?>">
                            <span class="invalid-feedback"><?php echo $pay_date_err;?></span>
                        </div>
                        
                                               
                        <div class="form-group">
                            <label><b>Amount Paid</b></label>
                            <input type="text" name="amount" class="form-control <?php echo (!empty($amount_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $amount; ?>">
                            <span class="invalid-feedback"><?php echo $amount_err;?></span>
                        </div>
                        <div class="form-group">
                            <label><b>Remark</b></label>
                            <input type="text" name="remark" class="form-control <?php echo (!empty($remark_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $remark; ?>">
                            <span class="invalid-feedback"><?php echo $remark_err;?></span>
                        </div>
                        
                                                
                        <div class="form-group">
                            <p><label><b> Submit | Navigate</b> </label></p>
                        <input type="hidden" name="entry" value="<?php echo $entry; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="sec_pay_update.php" class="btn btn-primary">Back</a>
                        </div>
                    </form>
                    
        </div><!-- comment -->
        </div>
        </div></div></div></div>        

     
   
 
<?php

 include "adminHF/sec_footer.php"

 
 ?>
    
</html>