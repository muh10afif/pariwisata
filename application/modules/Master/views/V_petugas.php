        <div class="card">
          <div class="card-header card-header-tabs card-header-rose">
            <div class="nav-tabs-navigation">
              <div class="nav-tabs-wrapper">
                <h3 class="float-left" style="margin-top: -1px;">Tabel Master Petugas</h3>
              </div>
            </div>
          </div>
          <button href="#link1" class="btn btn-warning btn-fab btn-round ml-5" style="margin-top:-20px;z-index:9" rel="tooltip" data-original-title="Tambah Data" data-toggle="modal" data-target="#modal-add"><i class="material-icons text-white">add</i></button>
          <!--    <div class="card-header card-header-rose">
            
            <button class="btn btn-white  btn-round float-right"><i class="material-icons">add</i>Tambah Data</button>
            <ul class="nav nav-pills nav-pills-warning" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#link1" role="tablist"> User DTW </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#link2" role="tablist"> User Hotel </a>
              </li>
            </ul>
          </div> -->
         
            <div class="card-body">
                  <table id="tbl_petugas" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width: 100%;" role="grid">
                    <thead class="text-primary">
                      <th width="50px;">No</th>
                      <th>Nama Petugas</th>
                      <th>NIK</th>
                      <th>Email</th>
                      <th>No Telfon</th>
                      <th>Alamat</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </thead>
                    <tbody id="data-petugas">
                    </tbody>
                  </table>
            </div>
          </div>

              <!-- Modal -->
              <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable|modal-dialog-centered modal-sm|modal-lg|modal-xl" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="add-title"><i class="fa fa-plus"></i> Tambah Data</h5>
                      <h5 class="modal-title" id="edit-title"><i class="fa fa-edit"></i> Edit Data</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form>
                        <input type="hidden" id="id">
                        <div class="form-group">
                          <input type="text" class="form-control" id="username" placeholder="Username">
                        </div>
                        <div class="form-group">
                          <input type="password" class="form-control" id="password" placeholder="Password">
                        </div>
                         <div class="form-group">
                          <input type="text" class="form-control" id="petugas" placeholder="Nama Petugas">
                        </div>
                         <div class="form-group">
                           <input type="text" class="form-control" id="nik" placeholder="NIK">
                        </div>
                        <div class="form-group">
                        <input type="email" class="form-control" id="email" placeholder="Email">  
                        </div>
                        <div class="form-group">
                        <input type="no_hp" class="form-control" id="no_telp" placeholder="No Telp">  
                        </div>
                         <div class="form-group">
                          <textarea class="form-control" id="alamat" placeholder="Alamat"  ></textarea>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="status">
                                <option value="" disabled selected="selected">-- Pilih Status --</option>
                                <option value="1">active</option>
                            </select>   
                        </div>
                        
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-rose" id="b-update">Update</button>
                      <button type="button" class="btn btn-rose" id="b-simpan">Simpan</button>
                      <!-- <button type="button" class="btn btn-rose" id="u_pegawai">Update</button>
                      <button type="button" class="btn btn-rose" id="u_hotel">Update</button> -->
                    </div>
                  </div>
                </div>
              </div>


              <script src="<?php echo base_url('assets/js/') ?>ajax/master/master_petugas.js"></script>
