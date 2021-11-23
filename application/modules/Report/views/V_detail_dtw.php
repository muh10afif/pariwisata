<div class="card">
    <input type="hidden" id="base_url" value="<?= base_url() ?>">
    <div class="card-header card-header-tabs card-header-rose">
        <!-- tab -->
        <div class="nav-tabs-navigation">
            <div class="nav-tabs-wrapper">
                <h3 class="float-left" style="margin-top: -1px;">Detail kota</h3>
                <ul class="nav nav-tabs float-right mb-3" data-tabs="tabs">
                    <li class="nav-item">
                        <a class="nav-link active show" id="wisnus" href="#link1" data-toggle="tab">
                            <i class="material-icons">arrow_downward</i> WISNUS
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="wisman" href="#link2" data-toggle="tab">
                            <i class="material-icons">arrow_upward</i> WISMAN
                            <div class="ripple-container"></div>
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card" style="margin-top:50px;opacity:0.8">
            <div class="card-body">
                <div class="row" style="margin: 5px;">
                    <div class="col-md-4 offset-md-2">
                        <div class="row">
                            <label class="col-sm-4 text-dark mt-1">Kota/Kabupaten</label>
                            <div class="col-sm-8">
                                <h5 class="font-weight-bold mt-1">: <?= ucwords($nama_kota) ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <label class="col-sm-4 text-dark mt-1">Periode Bulan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control datepicker12" id="periode" data="1" name="periode" style="margin-top: -6px;" placeholder="Pilih Bulan" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <a href="<?= base_url('report/dtw') ?>" class="btn btn-warning btn-fab btn-round ml-5" style="margin-top:-20px;z-index:9" rel="tooltip" data-original-title="Kembali"><i class="material-icons text-white">chevron_left</i></a>
    <div class="card-body">
        <div class="tab-content tab-space">
            <div class="tab-pane active" id="link1">
                <div class="container-fluid mt-3">
                    <table id="tbl_wisnus" class="table table-bordered table-hover table-striped" width="100%">
                        <thead class="thead-light">
                            <th class="text-center" width="30px;">No</th>
                            <th class="text-center" width="250px;">Provinsi</th>
                            <th class="text-center" width="200px;">Pria</th>
                            <th class="text-center" width="200px;">Wanita</th>
                            <th class="text-center" width="100px">Jumlah</th>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="link2">
                <div class="container-fluid mt-3">
                    <table id="tbl_wisman" class="table table-bordered table-hover table-striped" width="100%">
                        <thead class="thead-light">
                            <th class="text-center" width="30px;">No</th>
                            <th class="text-center" width="250px;">Negara / Kebangsaan</th>
                            <th class="text-center" width="200px;">Pria</th>
                            <th class="text-center" width="200px;">Wanita</th>
                            <th class="text-center" width="100px">Jumlah</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/js/') ?>ajax/report/dtw.js"></script>