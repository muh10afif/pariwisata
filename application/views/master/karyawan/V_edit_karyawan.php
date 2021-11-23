<form id="form_ubah_karyawan" method="post">
        <div class="form-group">
            <label for="nama">Nama</label>
            <input class="form-control nama" id="nama" value="<?= $data_per_karyawan['nama_karyawan'] ?>" type="text" required>
            <input type="hidden" class="id_karyawan" id="id_karyawan" name="id_karyawan" value="<?= $data_per_karyawan['id_karyawan'] ?>" >
        </div>

        <div class="form-group">
            <label for="nik">NIK</label>
            <input class="form-control nik" id="nik" value="<?= $data_per_karyawan['nik'] ?>" type="number" required>
        </div>

        <div class="form-group">
            <label for="no_telp">No Telepon</label>
            <input class="form-control no_telp" id="no_telp" value="<?= $data_per_karyawan['no_telp'] ?>" type="number" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control alamat"><?= $data_per_karyawan['alamat'] ?></textarea>
        </div>
    </div>
    <div class="modal-footer">

        <button type="button" class="btn btn-light btn-wth-icon btn-rounded icon-right"  data-dismiss="modal"><span class="btn-text">Tutup</span> <span class="icon-label"><span class="fa fa-close"></span> </span></button>
        <button type="submit" class="btn btn-success btn-wth-icon btn-rounded icon-right"><span class="btn-text">Ubah Data Karyawan</span> <span class="icon-label"><span class="fa fa-pencil"></span> </span></button>
        
    </div>
</form>