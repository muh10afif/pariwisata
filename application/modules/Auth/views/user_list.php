<div class="container">
<button type="button" class="btn btn-outline-info mb-2" data-toggle="modal" data-target="#modal-add"><i class="fa fa-plus"></i> Tambah
</button>
	<table class="table table-bordered" id="pengguna" style="width:100%;">
		<thead style="text-align: center;">
      <th style="width:40px;">No</th>
			<th>username</th>
			<th>Jabatan</th>
			<th>Aksi</th>
		</thead>
		<tbody id="show_data"></tbody>		
	</table>
</div>

<!-- Modal Tambah User-->
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable|modal-dialog-centered modal-sm|modal-lg|modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-user-plus"></i> Tambah User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
              <div class="form-group ">
              <input type="text" class="form-control" name="username" id="username" placeholder="Username">
              </div>
              <div class="form-group ">
                <select class="form-control" id="guru">
                  <?php foreach ($data_guru as $var): ?>
                   <option value="<?php echo $var->id ?>"><?php echo $var->nama_guru?></option> 
                  <?php endforeach ?>
                </select>
              </div>
               <!--  <div class="form-group ">
             
                  <input type="Password" class="form-control " id="password" name="password" placeholder="Password" required> 
              </div> -->
                <div class="form-group ">
                <select name="jab" id="jab" class="form-control" required="required" >
                  <option value="Kepala Sekolah">Kepala Sekolah</option>
                  <option value="Guru">Guru</option>
                  <option value="Operator">Operator</option>
                </select>
              </div>
           
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-primary mt-2" id="btn-simpan">Register</button>
      </div>
      </form>
    </div>
  </div>
</div>


 <!--MODAL HAPUS-->
          <div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content panel-warning">
                    <form class="form-horizontal">
                    <div class="modal-body text-center">
                                           
                            <input type="hidden" name="id_pengguna" id="id" value="">
                            <img class="img-responsive" src="<?php echo base_url()?>assets/img/warning.png"  style="width:100px; height:100px;margin-bottom: 30px; ">
                            <h5>Yakin Ingin Menghapus Data Ini?</h5>
                            <button type="button" class="btn btn-danger  btn-lg" data-dismiss="modal">Tutup</button>
                            <button class="btn_hapus btn btn-info btn-lg flo ml-2" id="btn-hapus">Hapus</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!--END MODAL HAPUS-->

        <!-- Modal Edit User-->
		<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-scrollable|modal-dialog-centered " role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-edit"></i> Edit User</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <form>
		        	<input type="hidden" name="id_edit" id="id2">
		            <div class="form-group ">
              <input type="text" class="form-control" name="username_edit" id="username2" placeholder="Username">
              </div>
               <!--  <div class="form-group ">
             
                  <input type="Password" class="form-control " id="password2" name="password_edit" placeholder="Password" required> 
              </div> -->
                <div class="form-group ">
                <select name="jab_edit" id="jab2" class="form-control" required="required" >
                  <option value="Kepala Sekolah">Kepala Sekolah</option>
                  <option value="Guru">Guru</option>
                  <option value="Operator">Operator</option>
                </select>
              </div>
		      </div>
		      <div class="modal-footer">
		         <button class="btn btn-primary mt-2" id="btn_update" type="submit">Update</button>
		          </form>
		      </div>
		    </div>
		  </div>
		</div>
