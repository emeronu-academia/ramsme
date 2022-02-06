<?php
$curl = curl_init();

$mobile = '08033927733';
$email = "majieronu2007@hotmail.com";
$amount = 60000;  //the amount in kobo. This value is actually NGN 300

// url to go to after payment
$callback_url = 'callback.php';  


// Setup request to send json via POST
$posted_data = array(
         'amount'=>$amount,
          'email'=>$email);
$payload = json_encode( $posted_data);

// Attach encoded JSON string to the POST fields
//curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

curl_setopt_array($curl, [CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $payload,
  CURLOPT_HTTPHEADER => [
    "authorization: Bearer sk_test_bfe3932f08913c5bc1c4000e1cf2b503383c3bc0", //replace this with your own test key
    "content-type: application/json",
    "cache-control: no-cache"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
  // there was an error contacting the Paystack API
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response, true);

if(!$tranx['status']){
  // there was an error from the API
  print_r('API returned error: ' . $tranx['message']);
}

// comment out this line if you want to redirect the user to the payment page
print_r($tranx);
// redirect to page so User can pay
// uncomment this line to allow the user redirect to the payment page
header('Location: ' . $tranx['data']['authorization_url']);
