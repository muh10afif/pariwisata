
    
    <div class="container">
      <div class="row">
          
        <div class="col-md-3 col-lg-3">
        </div>
        <div class="col-md-6 col-lg-6">
                   <div class="card bg-default">
           <div class="card-body">
            <?php echo $this->session->flashdata('message'); ?>
             <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
          <form method="POST" action="<?php echo base_url('Auth/register_proses') ?>">
            <div class="form-row">
              <div class="col-md-12 ">
                <label for="validationServer01">Nama Lengkap</label>
              <input type="text" class="form-control" name="name" placeholder="Nama Lengkap">
              </div>
              <div class="col-md-12 ">
                <label for="validationServer01">Username</label>
                <input type="text" class="form-control " id="validationServer01" name="username" placeholder="Username" value="" required>
                
              </div>
                <div class="col-md-12 ">
                <label for="validationServerUsername">Password</label>
                <div class="input-group">
                  <input type="Password" class="form-control " id="validationServerUsername" name="password" placeholder="Password" aria-describedby="inputGroupPrepend3" required> 
                </div>
              </div>
               <div class="col-md-12">
                <label for="validationServerUsername">Confirm Password</label>
                <div class="input-group">
                  <input type="Password" class="form-control " id="validationServerUsername" name="confirm_password" placeholder="Confirm Password" aria-describedby="inputGroupPrepend3" required>
                </div>
              </div>

                      <div class="col-md-12 ">
                <label for="validationServer01">Level</label>
                <select name="id_level" id="input" class="form-control slct2" required="required" >
                  <option value="2">Account Officer</option>
                  <option value="3">Nasabah</option>
                </select>
                
              </div>
             <div class="col-md-12 ">
                <label for="validationServer01">Status</label>
                <select name="id_level" id="input" class="form-control slct2" required="required" >
                  <option value="2">Active</option>
                  <option value="3">Non Active</option>
                </select>
                
              </div>
            </div>
      
         <!--    <div class="form-row">
              <div class="col-md-12 mb-12">
                <label for="validationServer03">City</label>
                <input type="text" class="form-control " id="validationServer03" placeholder="City" required>
                <div class="invalid-feedback">
                  Please provide a valid city.
                </div>
              </div>
              <div class="col-md-12 mb-12">
                <label for="validationServer04">State</label>
                <input type="text" class="form-control " id="validationServer04" placeholder="State" required>
                <div class="invalid-feedback">
                  Please provide a valid state.
                </div>
              </div>
            </div> -->
            <button class="btn btn-primary mt-2" type="submit">Register</button>
          </form>
        </div>
      </div>
        </div>
        <div class="col-md-3 col-lg-3">
        </div>

      </div>
     
<center>
<div class="middle">
      
      </div>
      
      </div>
</center>
    </div>

</div>