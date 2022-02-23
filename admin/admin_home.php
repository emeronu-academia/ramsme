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
    <?php
		$condition	=	'';
		if(isset($_REQUEST['mobile_no']) and $_REQUEST['mobile_no']!=""){
			$condition	.=	' AND mobile_no LIKE "%'.$_REQUEST['mobile_no'].'%" ';
		}
		
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
                    
                    <div class="card-body">
			<div class="col-sm-12">
				<h5 class="card-title"><i class="fa fa-fw fa-search"></i> Find User</h5>
				<form method="get">
				  <div class="row">
				    <div class="col-sm-2">
					<div class="form-group">
					<label>Mobile Number</label>
					<input type="text" name="mobile_no" id="username" class="form-control" value="<?php echo isset($_REQUEST['mobile_no'])?$_REQUEST['mobile_no']:''?>" placeholder="Enter user mobile number">
					</div>
					</div>
                		          				<div class="col-sm-4">
					<div class="form-group">
					<label>&nbsp;</label>
          				<div>
				<button type="submit" name="submit" value="search" id="submit" class="btn btn-primary"><i class="fa fa-fw fa-search"></i> Search</button>
				<a href="<?php echo $_SERVER['PHP_SELF'];?>" class="btn btn-danger"><i class="fa fa-fw fa-sync"></i> Clear</a>
				</div>
				</div>
			</div>
			</div>
			</form>
		</div> 	</div> 
                
                </div>
           
                    <?php
                    // Include config file
                    // Check if there is data on the page URL
                    $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
                    $limit = 5; // Amount of data per page
                    // Create a query to display how many data will be displayed in the tables in the database
                    $limit_start = ($page - 1) * $limit;
                                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM users where 1 " . $condition . "LIMIT ". $limit_start . "," . $limit;
                    $no = $limit_start + 1;
                   if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        //echo "<th>#</th>";
                                        echo "<th>Passport</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Phone</th>";
                                        echo "<th>Avenue</th>";
                                         echo "<th>Street</th>";
                                         echo "<th>Occupancy</th>";
                                         echo "<th>Effective Date </th>";
                                         echo "<th>Contribution[Dec-2021]</th>";
                                         echo "<th>Additional Info</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                       // echo "<td>" . $row['id'] . "</td>";
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
                                        echo "<td>" . $row['effective_date'] . "</td>";
                                        echo "<td>" . $row['contr_dec21'] . "</td>";
                                        echo "<td>" . $row['addinfo'] ."</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?id='. $row['id'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?id='. $row['id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?id='. $row['id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                    
                                    $no++;
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
                    // mysqli_close($link);
                    ?>
                </div>
            </div> 
             <p>
                <a href="/access/reset-password.php" class="btn btn-warning">Reset Your Password</a>
                <a href="/access/logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
          
             </p>
             <div>

        <!--
        Make the pagination
         With bootstrap, it is easier for us to create pagination buttons with a beautiful design
         good of course -->
        <ul class="pagination">
            <!-- LINK FIRST AND PREV -->
            <?php
            if ($page == 1) { // If the page is the 1st use, then disable the PREV link
            ?>
            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                
            <?php
            } else { // If you open page 1
                $link_prev = ($page > 1) ? $page - 1 : 1;
            ?>
                <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'];?>?page=1">First</a></li>
                <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'];?>?page=<?php echo $link_prev; ?>">&laquo;</a></li>
               
            <?php
            }
            ?>

            <!-- LINK NUMBER -->
            <?php
            // Buat query untuk menghitung semua jumlah/total data
            $sqlx = "SELECT * FROM users";
            mysqli_query($link, $sqlx);
            $get_jumlah = mysqli_affected_rows($link);
            $jumlah_page = ceil($get_jumlah / $limit); // Count the number of pages
            $jumlah_number = 3; // Specify the number of link numbers before and after the active page
            $start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1; // Untuk awal link member
            $end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number

            for ($i = $start_number; $i <= $end_number; $i++) {
                $link_active = ($page == $i) ? 'class="active"' : '';
            ?>
            
            <li  class="page-item" ><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'];?>?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
              
            <?php
            }
            ?>

            <!-- LINK NEXT AND LAST -->
            <?php
            // If the page is equal to the number of pages, then disable the NEXT link
            // This means that the page is the last page 
            if ($page == $jumlah_page) { // If the last page
            ?>
                <li class="page-item disabled"><a class="page-link" href="#">&raquo;</a></li>
                <li class="page-item disabled"><a class="page-link" href="#">Last</a></li>
                
            <?php
            } else { // If not the last page
                $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;
            ?>
                <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'];?>?page=<?php echo $link_next; ?>">&raquo;</a></li>
                <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'];?>?page=<?php echo $jumlah_page; ?>">Last</a></li>
            <?php
            }
            
              mysqli_close($link);
            ?>
        </ul>
    </div>
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