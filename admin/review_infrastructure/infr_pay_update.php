<?php
  ob_start();
?>

<?php

// Include config file
define('__ROOT__', dirname(dirname(__FILE__,2)));
require_once(__ROOT__.'/config.php');

?>

<?php
session_start();   // Initialize the session
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)   // Check if the user is logged in, if not then redirect him to login page
{
    header("location: /client/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

 <?php
 include '../adminHF/header_admin.php';
 ?>
    
     <?php
     //Pagination - 1
		$condition	=	'';
		if(isset($_REQUEST['mobile_no']) AND ($_REQUEST['mobile_no']!="") AND isset($_REQUEST['start_date']) AND $_REQUEST['start_date']!="" AND isset($_REQUEST['end_date']) and $_REQUEST['end_date']!="")
                {
			 $condition .= ' AND mobile_no LIKE "%'.$_REQUEST['mobile_no'].'%" '. ' AND pay_date between '. "'" . $_REQUEST['start_date']. "'" . ' AND '. "'" .$_REQUEST['end_date']. "'";
                        //echo $conditionx;
		}

     //Pagination - 2
		$conditionx	=	'';
		if(isset($_REQUEST['mobile_nox']) AND ($_REQUEST['mobile_nox']!="") AND isset($_REQUEST['start_datex']) AND $_REQUEST['start_datex']!="" AND isset($_REQUEST['end_datex']) and $_REQUEST['end_datex']!="")
                {
			//$conditionx .= ' AND mobile_no LIKE "%'.$_REQUEST['mobile_nox'].'%" AND pay_date between "%'.$_REQUEST['start_datex'].'%" AND "%'.$_REQUEST['end_datex'].'%" ';
                        $conditionx .= ' AND mobile_no LIKE "%'.$_REQUEST['mobile_nox'].'%" '. ' AND pay_date between '. "'" . $_REQUEST['start_datex']. "'" . ' AND '. "'" .$_REQUEST['end_datex']. "'";
                        //echo $conditionx;
                        //exit();
                       
		}
		
	?>
    
<div id="main-wrapper" class="container">
    <div class="row justify-content-center">
        
        <div class="col-xl-10">
            <div class="card border-0">
                <div class="card-body p-0">
                    <h1> Update Infrastructure Records </h1>
                    <div class="row no-gutters">
                        
                 <h2 class="my-5"> Residents Record </h2>
     
            <div class="row">
                
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
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                        <label>Start Date</label>
					<input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo isset($_REQUEST['start_date'])?$_REQUEST['start_date']:''?>" placeholder="Start Date">
					</div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                        <label>End Date</label>
					<input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo isset($_REQUEST['end_date'])?$_REQUEST['end_date']:''?>" placeholder="End Date">
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
                
                <div class="col-md-12">
                    
                    <?php
                    
                    // Include config file
                    // Check if there is data on the page URL
                    $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
                    $limit = 5; // Amount of data per page
                    // Create a query to display how many data will be displayed in the tables in the database
                    $limit_start = ($page - 1) * $limit;
                                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM payments where service = 'infrastructure' " . $condition . "LIMIT ". $limit_start . "," . $limit;
                    $no = $limit_start + 1;
                    //
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                      //  echo "<th>#</th>";
                                        echo "<th>Date of Payment</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Phone</th>";
                                        echo "<th>Amount Paid</th>";
                                        echo "<th>Service</th>";
                                         echo "<th>Remark</th>";
                                         echo "<th>Attachment</th>";
                                         echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr readonly>";
                                      // echo "<td>" . $row['entry'] . "</td>";
                                        echo "<td>" . $row['pay_date'] . "</td>";
                                        echo "<td>" . $row['name_value'] . "</td>";
                                        echo "<td>" . $row['mobile_no'] . "</td>";
                                        echo "<td>" . $row['amount'] . "</td>";
                                        echo "<td>" . $row['service'] . "</td>";
                                        echo "<td>" . $row['remark'] . "</td>";
                                        echo "<td>";
                                        echo '<a href=" '.'/client/activity/upload/doc/' . $row['attachment'] .'" target="_blank" class="mr-3" title="View Attachment" data-toggle="tooltip"><span class="fa fa-file"></span></a>';
                                        echo "</td>";                                     
                                        echo "<td>";
                                        echo '<a href="infr-add.php?entry='. $row['entry'] .'" class="mr-3" title="Transfer Record" data-toggle="tooltip"><span class="fa fa-plus"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
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
                    //mysqli_close($link);
                    ?>
                    <div>
              <!-- Pagination -1  -->
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
            $sqlx = "SELECT * FROM payments where service = 'infrastructure' " . $condition . "LIMIT ". $limit_start . "," . $limit;;
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
            
              //mysqli_close($link);
            ?>
        </ul>
         </div>
                    
                </div>
            </div> 
            
             
        </div>
    </div>
                 </div> 
        </div> 
    </div> 
    <div class="row justify-content-center">
        
        <div class="col-xl-10">
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="row no-gutters">
                        
                 <h2 class="my-5"> Admin Update Platform </h2>
     
            <div class="row">
                 <div class="card-body">
			<div class="col-sm-12">
				<h5 class="card-title"><i class="fa fa-fw fa-search"></i> Find User</h5>
				<form method="get">
				  <div class="row">
				    <div class="col-sm-2">
					<div class="form-group">
					<label>Mobile Number</label>
					<input type="text" name="mobile_nox" id="username" class="form-control" value="<?php echo isset($_REQUEST['mobile_nox'])?$_REQUEST['mobile_nox']:''?>" placeholder="Enter user mobile number">
                                        </div><!-- comment -->
                                        </div>
                                    <div class="col-sm-2">
					<div class="form-group">	
                                        <label>Start Date</label>
					<input type="date" name="start_datex" id="start_date" class="form-control" value="<?php echo isset($_REQUEST['start_datex'])?$_REQUEST['start_datex']:''?>" placeholder="Start Date">
					</div>
                                        </div>
                                     <div class="col-sm-2">
                                        <div class="form-group">
                                        <label>End Date</label>
					<input type="date" name="end_datex" id="end_date" class="form-control" value="<?php echo isset($_REQUEST['end_datex'])?$_REQUEST['end_datex']:''?>" placeholder="End Date">
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
                <div class="col-md-12">
                    
                    <?php
                    // Include config file
                        // Include config file
                    // Check if there is data on the page URL
                    $pagex = (isset($_GET['pagex'])) ? $_GET['pagex'] : 1;
                    $limitx = 5; // Amount of data per page
                    // Create a query to display how many data will be displayed in the tables in the database
                    $limit_startx = ($pagex - 1) * $limitx;
                                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM pay_sec_update where service = 'infrastructure' " . $conditionx . "LIMIT ". $limit_startx . "," . $limitx;
                    $nox = $limit_startx + 1;
                   
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                       // echo "<th>#</th>";
                                        echo "<th>Date of Payment</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Phone</th>";
                                        echo "<th>Amount Paid</th>";
                                        echo "<th>Service</th>";
                                         echo "<th>Remark</th>";
                                         echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                       //echo "<td>" . $row['entry'] . "</td>";
                                       echo "<td>" . $row['pay_date'] . "</td>";
                                        echo "<td>" . $row['name_value'] . "</td>";
                                        echo "<td>" . $row['mobile_no'] . "</td>";
                                        echo "<td>" . $row['amount'] . "</td>";
                                        echo "<td>" . $row['service'] . "</td>";
                                        echo "<td>" . $row['remark'] . "</td>";
                                        echo "<td>";
                                            
                                            echo '<a href="infr-update.php?entry='. $row['entry'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="infr-delete.php?entry='. $row['entry'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                    $nox++;
                                }
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
                    //mysqli_close($link);
                    ?>
                </div>
            </div> 
             <p>
                <a href="/client/account.php" class="btn btn-danger ml-3">Back to My Account</a>
         </p>
         <div>
              <!--Pagination -2 -->
        <ul class="pagination">
            <!-- LINK FIRST AND PREV -->
            <?php
            if ($pagex == 1) { // If the page is the 1st use, then disable the PREV link
            ?>
            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                
            <?php
            } else { // If you open page 1
                $link_prevx = ($pagex > 1) ? $pagex - 1 : 1;
            ?>
                <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'];?>?pagex=1">First</a></li>
                <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'];?>?pagex=<?php echo $link_prevx; ?>">&laquo;</a></li>
               
            <?php
            }
            ?>

            <!-- LINK NUMBER -->
            <?php
            // Buat query untuk menghitung semua jumlah/total data
            $sqlxx = "SELECT * FROM pay_sec_update where service = 'infrastructure' " . $conditionx . "LIMIT ". $limit_startx . "," . $limitx;;
            mysqli_query($link, $sqlxx);
            $get_jumlahx = mysqli_affected_rows($link);
            $jumlah_pagex = ceil($get_jumlahx / $limitx); // Count the number of pages
            $jumlah_numberx = 3; // Specify the number of link numbers before and after the active page
            $start_numberx = ($pagex > $jumlah_numberx) ? $pagex - $jumlah_numberx : 1; // Untuk awal link member
            $end_numberx = ($pagex < ($jumlah_pagex - $jumlah_numberx)) ? $pagex + $jumlah_numberx : $jumlah_pagex; // Untuk akhir link number

            for ($i = $start_numberx; $i <= $end_numberx; $i++) {
                $link_activex = ($pagex == $i) ? 'class="active"' : '';
            ?>
            
            <li  class="page-item" ><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'];?>?pagex=<?php echo $i; ?>"><?php echo $i; ?></a></li>
              
            <?php
            }
            ?>

            <!-- LINK NEXT AND LAST -->
            <?php
            // If the page is equal to the number of pages, then disable the NEXT link
            // This means that the page is the last page 
            if ($pagex == $jumlah_pagex) { // If the last page
            ?>
                <li class="page-item disabled"><a class="page-link" href="#">&raquo;</a></li>
                <li class="page-item disabled"><a class="page-link" href="#">Last</a></li>
                
            <?php
            } else { // If not the last page
                $link_nextx = ($pagex < $jumlah_pagex) ? $pagex + 1 : $jumlah_pagex;
            ?>
                <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'];?>?pagex=<?php echo $link_nextx; ?>">&raquo;</a></li>
                <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['PHP_SELF'];?>?pagex=<?php echo $jumlah_pagex; ?>">Last</a></li>
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
 include '../adminHF/footer_admin.php';
 ?>
    
</html>

<?php
  ob_end_flush();
?>
