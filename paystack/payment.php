<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/config.php');


session_start(); // Initialize the session
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)// Check if the user is logged in, if not then redirect him to login page
{
    header("location: /access/login.php");
    exit();
}

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
                $mobile_no = $row["mobile_no"];
                $name_value = $row["name_value"];
                $amount = 3000; //$row["amount"];
                $email = "eronu.majiyebo@uniabuja.edu.ng";  //$row["email"];
                $avenue = $row["avenue"];
                $street = $row["street"];
            }      
        }
      }
       // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);


?>


<!DOCTYPE html>
<html>

<head>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css" /> 
</head>

<body>

<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
      <form action="initialize.php" method="post">
                     <div class="form-group">
                      <label for="mobile_no">Mobile Number</label>
                      <input type="text" id="mobile_no" value="<?php echo $mobile_no; ?>" />
                     </div>
                     <div class="form-group">
                      <label for="name_value">Name</label>
                      <input type="text" id="name_value" value="<?php echo $name_value; ?>" />
                     </div>
                     <div class="form-group">
                      <label for="amount">Amount</label>
                      <input type="text" id="amount" value="<?php echo $amount; ?>" />
                     </div>
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" id="email" value="<?php echo $email; ?>" />
                     </div>
                     <div class="form-group">
                      <label for="avenue">Avenue</label>
                      <input type="text" id="avenue" value="<?php echo $avenue; ?>" />
                     </div>
                      <div class="form-group">
                      <label for="stree">Street</label>
                      <input type="text" id="street" value="<?php echo $street; ?>" />
                     </div>
                                 
    
                   <div class="form-submit">
                      <button type="submit" > Pay </button>
                       </div>
               </form>
                   
                </div>
            </div>        
        </div>
    </div>
            <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
            <script src="https://js.paystack.co/v1/inline.js"></script>
           <script src="app.js"></script> 
</body>

</html>
