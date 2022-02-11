<?php
// TASK
// 1. Delete selected records
// 2. Delete the image file linked to the sucessfully deleted record
// Include config file
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/config.php');
require_once(__ROOT__.'/headfoot/header_class.php');
require_once(__ROOT__.'/headfoot/footer_class.php');

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)// Check if the user is logged in, if not then redirect him to login page
{
    header("location: /access/login.php");
    exit();
}
  
// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"]))
{  
        $id =  trim($_POST["id"]);
        
      $sql = "SELECT * FROM users WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            //Bind variables to the prepared statement as parameters
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
                     $location  = $row['location'];
                    //echo $location;
                    //exit();
                 
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
       //mysqli_close($link);  
        
          
    
    // Prepare a delete statement
    $sql = "DELETE FROM users WHERE id = ?";
    
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = $id;
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            //Delete Corresponding file 
                if (unlink('../upload/img/'.$location)) 
                {
                echo 'The file ' . $location . ' was deleted successfully!';
                  header("location: admin_home.php");
                  exit();
                } else {
                echo 'There was a error deleting the file ' . $location;
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
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
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
                    <h2 class="mt-5 mb-3">Delete Record</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Are you sure you want to delete this employee record?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="/admin/admin_home.php" class="btn btn-secondary">No</a>
                            </p>
                        </div>
                    </form>
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