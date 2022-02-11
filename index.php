<?php
include_once 'headfoot/header_class.php';
include_once 'headfoot/footer_class.php';

?>

<!DOCTYPE html>
<html>

 <?php
 $nheader = new header_class();
 $nheader->head_main();

 ?>
    <div id="main-wrapper" class="container">
        <div class="row justify-content-center">

        <img src="../images/ramsme.png" class="img-thumbnail" alt="...">
    
        </div><!-- comment -->
    </div>

 <?php
 
 $nfooter = new footer_class();
 $nfooter->foot_main();
 
 ?>

</html>