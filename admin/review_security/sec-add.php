<?php

// Include config file
define('__ROOT__', dirname(dirname(__FILE__),2));
require_once(__ROOT__.'/config.php');

// Define variables and initialize with empty values
$entry = $mobile_no = $phone = $amount= $remark = $pay_date = $attachment = $name_value= "";


// Check existence of entry parameter before processing further
    if(isset($_GET["entry"]) && !empty(trim($_GET["entry"])))
    {
        
        // Get URL parameter
        $entry = trim($_GET["entry"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM payments WHERE entry = ?";
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
                    $mobile_no = $row["mobile_no"];
                    $name_value = $row["name_value"];
                    $pay_date = $row["pay_date"];
                    $amount = $row["amount"];
                    $attachment = $row["attachment"];
                    $remark = $row["remark"];
                    
                    //echo $mobile_no;
                    //echo $name_value;
                    //echo $pay_date;
                    //echo $amount;
                    //echo $attachment;
                    //echo $remark;
                    
                    //exit();
                    
                   
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
  
    }  
    
    $sql = "INSERT INTO pay_sec_update (mobile_no, pay_date, name_value, amount, attachment,remark) VALUES (?,?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_mobile_no, $param_date,$param_name, $param_amount, $param_attachment,$param_remark );
            
            // Set parameters
            $param_mobile_no = $mobile_no;
            $param_name = $name_value;
            $param_date = $pay_date;
            $param_amount = $amount;
            $param_attachment = $attachment;
           $param_remark = $remark;
            //
      
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: sec_pay_update.php");
            } 
            else
            {
                // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    echo "Oops! Something went wrong. Please try again later.";
                    exit();
               
            }

            // Close statement
            mysqli_stmt_close($stmt);
            // Close connection
            mysqli_close($link);
        }
    
  


 

