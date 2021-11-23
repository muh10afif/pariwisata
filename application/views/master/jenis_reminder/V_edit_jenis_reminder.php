<div class="card bg-light mb-30" id="edit_jenis_reminder">
    <div class="card-header" style="color: black">Ubah Jenis Reminder</div>
    <form id="form_ubah_jenis_reminder">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" align="">Level</label>
                    <div class="col-sm-8">
                        <input type="text" value="<?= $d_jenis_reminder['level'] ?>" class="normal_2 level" step="1" />
                        <input type="hidden" class="form-control id_jenis_tasklist" value="<?= $d_jenis_reminder['id_jenis_tasklist'] ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" align="">Jenis Tasklist</label>
                    <div class="col-sm-8">
                        <input type="text" value="<?= $d_jenis_reminder['jenis_tasklist'] ?>" class="normal_2 jenis_tasklist" step="1" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="col-md-12 col-md-offset-6" align="right">

            <button type="button" class="btn btn-light btn-wth-icon btn-rounded icon-right" id="cancel"><span class="btn-text">Cancel</span> <span class="icon-label"><span class="fa fa-close"></span> </span></button>
            <button type="submit" class="btn btn-success btn-wth-icon btn-rounded icon-right"><span class="btn-text">Ubah Data Pengguna</span> <span class="icon-label"><span class="fa fa-pencil"></span> </span></button>
        
        </div>
    </div>
    </form>
</div>

<!-- Bootstrap Input spinner JavaScript -->
<script src="<?= base_url() ?>assets/vendors/bootstrap-input-spinner/src/bootstrap-input-spinner.js"></script>
<script>
    $("input.normal_2").inputSpinner({buttonsClass: "btn-outline-light"});
</script>