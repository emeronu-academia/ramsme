<?php

if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' ) || !array_key_exists('HTTP_X_PAYSTACK_SIGNATURE', $_SERVER) ) {
    // only a post with paystack signature header gets our attention
    exit();
}

// Retrieve the request's body
$input = @file_get_contents("php://input");
define('PAYSTACK_SECRET_KEY','sk_test_bfe3932f08913c5bc1c4000e1cf2b503383c3bc0');

if(!$_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] || ($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $input, PAYSTACK_SECRET_KEY))){
  // silently forget this ever happened
  exit();
}


http_response_code(200);

// parse event (which is json string) as object
// Do something - that will not take long - with $event
$event = json_decode($input);
switch($event->event){
    // subscription.create
    case 'subscription.create':
        break;

    // charge.success
    case 'charge.success':
        $ref = $event->data->reference;
        $email = $event->data->customer->email;
        $amount = $event->data->amount;
        
        break;

    // subscription.disable
    case 'subscription.disable':
        break;

    // invoice.create and invoice.update
    case 'invoice.create':
    case 'invoice.update':
        break;

}

exit();

 // Check input errors before inserting in database

// Include config file
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/config.php');
    
        // Prepare an insert statement
        $sql = "INSERT INTO sitewebhook (ref, email_val, amount) VALUES (?,?, ? )";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_ref, $param_email,  $param_amount);
            
            // Set parameters
            $param_ref = $ref;
            $param_email = $email;
            $param_amount = $amount;
                        
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                //header("location: crud_index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    
    
    // Close connection
    mysqli_close($link);