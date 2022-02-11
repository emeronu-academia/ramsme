<?php
  ob_start();
?>

<?php

// Include config file
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/config.php');
require_once(__ROOT__.'/headfoot/header_class.php');
require_once(__ROOT__.'/headfoot/footer_class.php');

?>



<?php
session_start();   // Initialize the session
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)   // Check if the user is logged in, if not then redirect him to login page
{
    header("location: /access/login.php");
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
                        
                 <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["name_value"]); ?></b>. Welcome to the Admin Portal site.</h1>
     
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                     
                        <span>  <?php include('create_modal.php'); ?> </span>
                         
                        
                    </div>
                    <?php
                    // Include config file
                                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM users";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Passport</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Phone</th>";
                                        echo "<th>Avenue</th>";
                                         echo "<th>Street</th>";
                                         echo "<th>Occupancy</th>";
                                         echo "<th>Additional Info</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                       echo "<td>" . $row['id'] . "</td>";
                                        //
                                       ?> <td style="text-align:center; margin-top:10px; word-break:break-all; width:450px; line-height:100px;"><a href="#<?php echo $row['id'];?>" data-bs-target ="#<?php echo $row['id'];?>" data-bs-toggle="modal">
									<?php if($row['location'] != ""): ?>
									<img src="../upload/img/<?php echo $row['location']; ?>" width="100px" height="100px" style="border:1px solid #333333;">
									<?php else: ?>
									<img src="images/default.png" width="100px" height="100px" style="border:1px solid #333333;">
									<?php endif; ?>
									</a>
								</td>
                                        <?php
                                        //
                                        echo "<td>" . $row['name_value'] . "</td>";
                                        echo "<td>" . $row['mobile_no'] . "</td>";
                                        echo "<td>" . $row['avenue'] . "</td>";
                                        echo "<td>" . $row['street'] . "</td>";
                                        echo "<td>" . $row['occupancy'] . "</td>";
                                        echo "<td>" . $row['addinfo'] ."</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?id='. $row['id'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?id='. $row['id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?id='. $row['id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                //
                               ?> <!-- Modal Bigger Image -->
                              
								<div id="<?php  echo $row['id'];?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-header">

								<h3 id="myModalLabel"><b><?php echo $row['mobile_no']." ".$row['name_value']; ?></b></h3>
								</div>
								<div class="modal-body">
								<?php if($row['location'] != ""): ?>
								<img src="../upload/img/<?php echo $row['location']; ?>" style="width:390px; border-radius:9px; border:5px solid #d0d0d0; margin-left: 63px; height:387px;">
								<?php else: ?>
								<img src="images/default.png" style="width:390px; border-radius:9px; border:5px solid #d0d0d0; margin-left: 63px; height:387px;">
								<?php endif; ?>
								</div>
								<div class="modal-footer">
								<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
								</div>
								</div>
                                <?php
                                
                                //
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div> 
             <p>
                <a href="/access/reset-password.php" class="btn btn-warning">Reset Your Password</a>
                <a href="/access/logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
         </p>
        </div>
    </div>
                 </div> 
        </div> 
    </div> 
</div>
     
    
    
<?php
 
 $nfooter = new footer_class();
 $nfooter->foot_main();
 
 ?>
    
</html>

<?php
  ob_end_flush();
?>