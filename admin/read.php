<?php

// Include config file
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/config.php');
require_once(__ROOT__.'/headfoot/header_class.php');
require_once(__ROOT__.'/headfoot/footer_class.php');

?>


<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
   
        
    // Prepare a select statement
    $sql = "SELECT * FROM users WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $name = $row["name_value"];
                $phone = $row["mobile_no"];
                $location = $row["location"];
                $avenue = $row["avenue"];
                $street = $row["street"];
                $occupancy = $row["occupancy"];
                $addinfo = $row["addinfo"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
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
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
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
                        
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    
                    <div class="form-group">
                        <label><b>Name</b></label>
                        <p><?php echo $row["name_value"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label><b>Phone</b></label>
                        <p><?php echo $row["mobile_no"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label><b>Passport</b></label>
                          
                            <?php if($location != ""): ?>
		           <p> <img id="blah" src="../upload/img/<?php echo $row["location"];  ?>" width="100px" height="100px" style="border:1px solid #333333;"></p>
			    <?php else: ?>
			    <p><img id="blah" src="../images/default.png" width="100px" height="100px"></p>
			    <?php endif; ?>
                            
                    </div>
                    <div class="form-group">
                        <label><b>Avenue</b></label>
                        <p><?php echo $row["avenue"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label><b>Street</b></label>
                        <p><?php echo $row["street"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label><b>Occupancy</b></label>
                        <p><?php echo $row["occupancy"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label><b>Addition Information</b></label>
                        <p><?php echo $row["addinfo"]; ?></p>
                    </div><!-- comment -->
                    <p><a href="/admin/admin_home.php" class="btn btn-primary">Back</a></p>
                  
                </div>
            </div>        
        </div>
    </div>
                </div></div></div></div>

        <?php
 
 $nfooter = new footer_class();
 $nfooter->foot_main();
 
 ?>
</html>