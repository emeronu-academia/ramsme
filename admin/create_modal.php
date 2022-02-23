<?php


// Define variables and initialize with empty values
$mobile_no = $name_value= $addinfo = $occupancy = $role = $email= $avenue = $street = $password = $confirm_password = $effective_date = $contr_dec21 = "";
$mobile_no_err = $name_err = $role_err = $addinfo_err = $email_err= $avenue_err = $street_err = $password_err = $confirm_password_err = "";
?>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary align-items-lg-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
 Add New Record 
</button>
<!-- Modal -->
<div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Register a New Account.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          
          <form class="rg-form" method="post" action="create.php"  enctype="multipart/form-data">
                        
             <div class="rf-input-container"><i class="fa fa-mobile-phone rf-icon"></i>
                <input class="form-control rf-input-field" type="text" name="mobile_no" class="form-control <?php echo (!empty($mobile_no_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mobile_no; ?>" placeholder="Mobile Number" required>
                <span class="invalid-feedback"><?php echo $mobile_no_err; ?></span>
             </div>
            
            <div class="rf-input-container"><i class="fa fa-user rf-icon"></i>
                <input class="form-control rf-input-field" type="text" name="name_value" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name_value; ?>" placeholder="Name" required>
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>
              
               <div class="rf-input-container"><i class="fa fa-key rf-icon">
                </i><input class="form-control rf-input-field" type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" placeholder="Password" required>
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
             <div class="rf-input-container"><i class="fa fa-key rf-icon">
                </i><input class="form-control rf-input-field" type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" placeholder="Confirm Password" required>
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            
            <div class="rf-input-container"><i class="fa fa-user rf-icon"></i>
                <img id="blah" src="../images/default.png"  width="100px" height="100px"/>
                <p> <input id="imgInp"  type="file" name="v_user_image" accept="image/*" required/></p>
              
            </div>
            
            <div class="rf-input-container"><i class="fa  fa-home rf-icon"></i>   
                              
                 <select name="occupancy"  class="form-select" aria-label="Default select example"  >
                    <option selected ="landlord">Occupancy - Landlord</option>
                    <option value="tenant">Occupancy - Tenant</option>
                    <option value="tenant-special">Occupancy - Special Tenant</option>
                </select>
                <span class="invalid-feedback"><?php echo $occupancy_err; ?></span>
         
             </div>    
           <div class="rf-input-container"><i class="fa  fa-home rf-icon"></i>   
                              
                 <select name="role"  class="form-select" aria-label="Default select example" >
                    <option selected ="client">Role - Client</option>
                    <option value="admin">Role - Admin</option>
                 </select>
                <span class="invalid-feedback"><?php echo $role_err; ?></span>
         
             </div>  
            <div class="rf-input-container"><i class="fa fa-envelope rf-icon"></i>
                <input class="form-control rf-input-field" type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder="Email" required>
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="rf-input-container"><i class="fa fa-address-book rf-icon"></i>
                <input class="form-control rf-input-field" type="text" name="avenue" class="form-control <?php echo (!empty($avenue_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $avenue; ?>" placeholder="Avenue" required>
                <span class="invalid-feedback"><?php echo $avenue_err; ?></span>
            </div>
            <div class="rf-input-container"><i class="fa fa-street-view rf-icon"></i>
                <input class="form-control rf-input-field" type="text" name="street" class="form-control <?php echo (!empty($street_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $street; ?>" placeholder="Street" required>
                <span class="invalid-feedback"><?php echo $street_err; ?></span>
            </div>
             <div class="rf-input-container"><i class="fa fa-street-view rf-icon"></i>
                 
              <label><b>Date</b></label>
              <input type="date" name="effective_date" class="form-control <?php echo (!empty($effective_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $effective_date; ?>">
              <span class="invalid-feedback"><?php echo $effective_date_err;?></span>
            </div>
              
            <div class="rf-input-container"><i class="fa fa-street-view rf-icon"></i>
                <input class="form-control rf-input-field" type="text" name="contr_dec21" class="form-control <?php echo (!empty($contr_dec21_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $contr_dec21; ?>" placeholder="Total Contribution Made as at December 2021" required>
                <span class="invalid-feedback"><?php echo $contr_dec21_err; ?></span>
            </div>
            
            <div class="rf-input-container"><i class="fa fa-street-view rf-icon"></i>
                <input class="form-control rf-input-field" type="text" name="addinfo" class="form-control <?php echo (!empty($addinfo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $addinfo; ?>" placeholder="Additional Information" required>
                <span class="invalid-feedback"><?php echo $addinfo_err; ?></span>
            </div>
            
                        
            <div class="rf-input-container"><i class="fa fa-street-view rf-icon"></i>
                <p></p>
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                <a href="/admin/admin_home.php" class="btn btn-primary">Back</a>
            </div>       
          
          </form>  
          
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      <!--  <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<script>
            imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                        blah.src = URL.createObjectURL(file)
                        }
            }
            </script>
