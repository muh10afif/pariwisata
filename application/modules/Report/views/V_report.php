<div class="card">
    <div class="card-header card-header-tabs card-header-rose">
        <div class="nav-tabs-navigation">
            <div class="nav-tabs-wrapper">
            <h3 class="float-left" style="margin-top: -1px;">Report</h3>
            </div>
        </div>
    </div>

    <form action="<?= base_url('Report/report') ?>" target="_blank" id="form_report" method="POST">
    
    <div class="card-body">
        <div class="d-flex justify-content-center">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <span class="font-weight-bold">Jenis Report</span>
                        </div>
                        <div class="col-md-9">
                            <select class="form-control" id="jenis" name="jenis_report" required>
                                <option value="">-- Pilih Jenis Report --</option>
                                <option value="dtw">DTW</option>
                                <option value="hotel">Hotel</option>
                                <option value="all">Keseluruhan</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <span class="font-weight-bold">Periode</span>
                        </div>
                        <div class="col-md-9">
                            <div class="input-daterange input-group">
                                <input type="text" class="form-control datepicker11 text-center" name="start" id="start" placeholder="Awal Periode" readonly required>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-secondary b-0 text-white">s / d</span>
                                </div>
                                <input type="text" class="form-control datepicker11 text-center" name="end" id="end" placeholder="Akhir Periode" readonly required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">

        <div class="col-md-12" align="right">
            <button type="submit" class="btn btn-success" name="cari" id="cari">Tampilkan</button><?= nbs(3) ?>
            <button class="btn btn-dark" id="reset" type="reset">Reset</button>
        </div>

    </div>

    </form>
</div>