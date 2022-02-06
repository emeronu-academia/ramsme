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


    
   
   

 <?php
 
 $nfooter = new footer_class();
 $nfooter->foot_main();
 
 ?>

</html>