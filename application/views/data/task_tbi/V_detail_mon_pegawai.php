<style>
    #mon tr {
        border-top: hidden;
    }

    #gmbr{
        width: 200px;
        height: 125px;
        cursor: pointer;
    }
</style>

<div class="modal-body">
    <div class="col-md-12 table-responsive">
        <table id="mon" class="table table-hover">
            <tr>
                <th>Judul Tasklist</th>
                <td>:</td>
                <td><?= $data_hsl_mon['tasklist'] ?></td>
                <td><?php if($data_hsl_mon['penerima_tugas'] == $this->session->userdata('id_karyawan')){ ?> <img class="brand-img" src="<?= base_url() ?>assets/bg_your_task_listt.png" width="100" alt="brand"/><?php } ?></td>
            </tr>
            <tr>
                <th>Expire Date</th>
                <td>:</td>
                <td><?= tgl_indo($data_hsl_mon['expire_date']) ?></td>
            </tr>
            <tr>
                <th>Pemberi Tugas</th>
                <td>:</td>
                <td><?= $data_hsl_mon['pemberi_tugas'] ?></td>
            </tr>
            <tr>
                <th>Penerima Tugas</th>
                <td>:</td>
                <td><?= $data_hsl_mon['penerima_tugas'] ?></td>
            </tr>
            <tr>
                <th>Keterangan</th>
                <td>:</td>
                <td><?= $data_hsl_mon['keterangan'] ?></td>
            </tr>
        </table>
        <br/>
        <?php if($data_hsl_mon['penerima_tugas'] == $this->session->userdata('id_karyawan')){ ?><button class="btn btn-primary btn-wth-icon btn-rounded icon-right mr-10" type="button" data-toggle="modal" data-target="#input_hasil"><span class="btn-text">Input Hasil</span> <span class="icon-label"><span class="feather-icon"><i data-feather="plus"></i></span> </span></button><?php } ?>
        <br/>
        <br/>
        <table id="tabel_mon_pegawai" class="table table-bordered table-hover w-100 display pb-30">
                <thead class="thead-info">
                    <?php if($data_hsl_mon['penerima_tugas'] == $this->session->userdata('id_karyawan')){?>
                    <tr>
                        <th>No</th>
                        <th>Tugas</th>
                        <th width=20%;>Aksi</th>
                    </tr>
                    <?php } else {?>
                    <tr>
                        <th>No</th>
                        <th>Tugas</th>
                    </tr>
                    <?php } ?>
                </thead>
            <tbody>
                <?php $no = 1; foreach($data_hsl_task as $row){?>
                    <tr>
                    <?php if($data_hsl_mon['penerima_tugas'] == $this->session->userdata('id_karyawan')){?>
                        <td><?= $no; ?></td>
                        <td><?= $row['keterangan']; ?></td>
                        <td width="250">
                            <a href="<?php echo site_url('data/setujuiHasil/'.$row["id_hasil_task"]) ?>"
                                class="btn btn-info">Setujui</a>
                            <a onclick="<?php echo site_url('data/tolakHasil/'.$row["id_hasil_task"]) ?>"
                                href="#!" class="btn btn-danger">Tolak</a>
                        </td>
                    <?php } else {?>
                        <td><?= $no; ?></td>
                        <td><?= $row['keterangan']; ?></td>
                    <?php } ?>
                    </tr>
                <?php $no++; } ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal tambah data tasklist-->
<div id="input_hasil" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tambah_task" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-info">
                <h5 class="modal-title text-white" id="my-modal-title"><i class="fa fa-plus-circle"></i><?= nbs(2) ?>Tambah Tasklist</h5>
                <button class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="form_tambah_tasklist">
                <div class="form-group">
                    <label for="nama">Pegawai</label>
                    <select class="form-control" id="penerima_tugas">
                    <?php foreach($l_karyawan as $row){?>
                        <option value="<?= $row['id_karyawan'];?>"><?= $row['nama_karyawan'];?></option>
                    <?php }?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tasklist">Tugas</label>
                    <input class="form-control" id="tasklist" placeholder="Masukkan tugas" type="text" required>
                </div>

                <div class="form-group">
                    <label for="no_telp">Expire Date</label>
                    <input class="form-control" id="expire_date" placeholder="Masukkan Expire Date" type="date" required>
                </div>

                <div class="form-group">
                    <label for="alamat">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" required></textarea>
                </div>

                <input type="hidden" id="pemberi_tugas" value="<?= $this->session->userdata('id_karyawan') ;?>"/>
                <input type="hidden" id="jenis_task" value="1"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-wth-icon btn-rounded icon-right"  data-dismiss="modal"><span class="btn-text">Tutup</span> <span class="icon-label"><span class="fa fa-close"></span> </span></button>
                <button type="submit" class="btn btn-success btn-wth-icon btn-rounded icon-right"><span class="btn-text">Tambah Data Karyawan</span> <span class="icon-label"><span class="fa fa-check"></span> </span></button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal tambah data tasklist-->         
<!-- Photoviewer -->
<link rel="stylesheet" href="<?= base_url() ?>assets/viewer/css/viewer.css">
<!-- jQuery 3 -->
<script src="<?= base_url() ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Photoviewer -->
<script src="<?= base_url() ?>assets/viewer/js/viewer.js"></script>

<script type="text/javascript">
	$('.gambar').viewer();
</script>
