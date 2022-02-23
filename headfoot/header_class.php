<?php


class header_class 
{
    //public $personalize_table_name = "friends";
    
     //
     public function head_main() 
     {
         ?>
        
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>RAMSME | Home</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/White-Footer.css">
    
     <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>  
       
</head>
<body id="page-top">
    
    <nav class="navbar navbar-light navbar-expand-lg navigation-clean-button">
        <div class="container"><a class="navbar-brand" href="#">RAMSME</a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="about_us.php" target="_self">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="/print/index.php" target="_self">Print</a></li>
                  <!--    <li class="nav-item"><a class="nav-link" href="/paystack/initialize.php" target="_self">Pay</a></li>
                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">Dropdown </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/paystack/initialize.php">Pay</a>
                            <a class="dropdown-item" href="#">Second Item</a>
                            <a class="dropdown-item" href="#">Third Item
                         </a></div>
                    </li> -->
                </ul><span class="navbar-text actions"> <a class="login" href="/access/login.php" target="_self">Log In</a><a class="btn btn-light action-button" role="button" href="/access/register.php" target="_self">Sign Up</a></span>
            </div>
        </div>
    </nav>
    
           <?php
         
     }
     //
     public function head_admin_home() 
     {
         ?>
        
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>RAMSME | Home | Admin </title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/White-Footer.css">
  
    <style>
        .wrapper{
            width: 800px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>   
   
    
       
</head>
<body id="page-top">
    
    <nav class="navbar navbar-light navbar-expand-lg navigation-clean-button">
        <div class="container"><a class="navbar-brand" href="#">RAMSME</a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="about_us.php" target="_self">About Us</a></li>
                    
                    <li class="nav-item"><a class="nav-link" href="/paystack/initialize.php" target="_self">Pay</a></li>
                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">Update Records</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="../admin/review_security/sec_pay_update.php">Security</a>
                             <a class="dropdown-item" href="../review_infrac/infras_pay_update.php">Infrastructure</a>
                             <a class="dropdown-item" href="../admin/review_complains/complain_view.php">Complain</a>
                         </a></div>
                    </li> 
                </ul><span class="navbar-text actions"> <a class="login" href="/access/logout.php" target="_self">Log Out</a><a class="btn btn-light action-button" role="button" href="../index.php" target="_self">Home</a></span>
            </div>
        </div>
    </nav>
    
           <?php
         
     }
     //
     public function head_account() 
     {
         ?>
        
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>RAMSME | My Account</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/White-Footer.css">
    
     <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>  
       
</head>
<body id="page-top">
    
    <nav class="navbar navbar-light navbar-expand-lg navigation-clean-button">
        <div class="container"><a class="navbar-brand" href="#">RAMSME</a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="about_us.php" target="_self">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="/paystack/initialize.php" target="_self">Pay</a></li>
                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">Register</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/access/register_payment.php">Payment</a>
                            <a class="dropdown-item" href="/access/register_complain.php">Complain</a>
                        </div>
                    </li>
                </ul><span class="navbar-text actions"> <a class="login" href="/access/logout.php" target="_self">Log Out</a><a class="btn btn-light action-button" role="button" href="../index.php" target="_self">Home</a></span>
            </div>
        </div>
    </nav>
    
    
    
    
           <?php
         
     }
     
     //
     public function head_login() 
     {
         ?>
    

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>RAMSME | Login</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
     <link rel="stylesheet" href="../assets/css/White-Footer.css">
    <link rel="stylesheet" href="../assets/css/Login-with-overlay-image.css">
     <style>
        .wrapper{
            width: 1500px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>  
</head>
<body id="page-top">
    
    <nav class="navbar navbar-light navbar-expand-lg navigation-clean-button">
        <div class="container"><a class="navbar-brand" href="#">RAMSME</a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="about_us.php" target="_self">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="/paystack/initialize.php" target="_self">Pay</a></li>
                  <!--  <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">Dropdown </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/paystack/initialize.php">Pay</a>
                            <a class="dropdown-item" href="#">Second Item</a>
                            <a class="dropdown-item" href="#">Third Item
                         </a></div>
                    </li> -->
                </ul><span class="navbar-text actions"> <a class="login" href="/access/logout.php" target="_self">Log Out</a><a class="btn btn-light action-button" role="button" href="/access/register.php" target="_self">Sign Up</a></span>
            </div>
        </div>
    </nav>
          <?php
         
     }
     
      //
     public function head_register() 
     {
         ?>
    

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>RAMSME | Register</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
     <link rel="stylesheet" href="../assets/css/White-Footer.css">
    <link rel="stylesheet" href="../assets/css/Login-with-overlay-image.css">
    <link rel="stylesheet" href="../assets/css/Register-form.css">
    
     <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>  
    
</head>
<body id="page-top">
    
    <nav class="navbar navbar-light navbar-expand-lg navigation-clean-button">
        <div class="container"><a class="navbar-brand" href="#">RAMSME</a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="about_us.php" target="_self">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="/paystack/initialize.php" target="_self">Pay</a></li>
                  <!--  <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">Dropdown </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/paystack/initialize.php">Pay</a>
                            <a class="dropdown-item" href="#">Second Item</a>
                            <a class="dropdown-item" href="#">Third Item
                         </a></div>
                    </li> -->
                </ul><span class="navbar-text actions"> <a class="login" href="/access/login.php" target="_self">Log in</a><a class="btn btn-light action-button" role="button" href="../index.php" target="_self">Home</a></span>
            </div>
        </div>
    </nav>
          <?php
         
     }
     
     //
     public function head_reset_pass() 
     {
         ?>
    

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>RAMSME | Reset Password</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
     <link rel="stylesheet" href="../assets/css/White-Footer.css">
    <link rel="stylesheet" href="../assets/css/Login-with-overlay-image.css">
    <link rel="stylesheet" href="../assets/css/Register-form.css">
    
     <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>  
    
</head>
<body id="page-top">
    
    <nav class="navbar navbar-light navbar-expand-lg navigation-clean-button">
        <div class="container"><a class="navbar-brand" href="#">RAMSME</a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="about_us.php" target="_self">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="/paystack/initialize.php" target="_self">Pay</a></li>
                  <!--  <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">Dropdown </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/paystack/initialize.php">Pay</a>
                            <a class="dropdown-item" href="#">Second Item</a>
                            <a class="dropdown-item" href="#">Third Item
                         </a></div>
                    </li> -->
                </ul><span class="navbar-text actions"> <a class="login" href="/access/login.php" target="_self">Log in</a><a class="btn btn-light action-button" role="button" href="../index.php" target="_self">Home</a></span>
            </div>
        </div>
    </nav>
          <?php
         
     }
     
     
}

