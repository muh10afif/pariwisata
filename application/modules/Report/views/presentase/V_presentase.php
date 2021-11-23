<div class="card">
    <input type="hidden" id="base_url" value="<?= base_url() ?>">
    <div class="card-header card-header-tabs card-header-rose">
        <!-- tab -->
        <div class="nav-tabs-navigation">
            <div class="nav-tabs-wrapper">
                <h3 class="float-left judul" style="margin-top: -1px;">Perbandingan Wisatawan Nusantara</h3>
                <ul class="nav nav-tabs float-right mb-3" data-tabs="tabs">
                    <li class="nav-item">
                        <a class="nav-link active show" id="wisnus" href=".link1" data-toggle="tab">
                            <i class="material-icons">arrow_downward</i> WISNUS
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="wisman" href=".link2" data-toggle="tab">
                            <i class="material-icons">arrow_upward</i> WISMAN
                            <div class="ripple-container"></div>
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card" style="margin-top:50px;opacity:0.8">
            <form id="form-filter" action="<?= base_url('Report/Presentase/menampilkan_filter_perbandingan/unduh') ?>" method="POST" autocomplete="off">
                <input type="hidden" name="jns_wisatawan" id="jns_wisatawan" value="wisnus">
                <div class="card-body">
                        <div class="row" style="margin: 10px;">
                            <div class="col-md-6 mb-3">
                                <div class="row">
                                    <label class="col-sm-4 text-dark mt-2">Kota/Kabupaten</label>
                                    <div class="col-sm-8">
                                        <?php if ($this->session->userdata('level') == 'kota') : ?>
                                            <span class="font-weight-bold"> : <?= $nama_kota ?> </span>
                                            <input type="hidden" name="kota" value="<?= $id_kota ?>">
                                        <?php else : ?>
                                            <select class="form-control sel2" name="kota" id="kota">
                                                <option value="-">-- Pilih Kab / Kota --</option>
                                                <?php foreach ($kota as $k): ?>
                                                    <option value="<?= $k['id_kota'] ?>"><?= ucwords(strtolower($k['nama_kota'])) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        <?php endif; ?>
                                    
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="row">
                                    <label class="col-sm-4 text-dark mt-2">Jenis Data</label>
                                    <div class="col-sm-8">
                                        <select class="form-control sel2" name="jenis_data" id="jenis_data">
                                            <option value="-">-- Pilih Jenis Data --</option>
                                            <option value="dtw">Dtw</option>
                                            <option value="hotel">Akomodasi</option>
                                            <!-- <option value="all">Keseluruhan</option> -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="row">
                                    <label class="col-sm-4 text-dark mt-2">Month on Month</label>
                                    <div class="col-sm-8">
                                        <div class="input-daterange input-group">
                                            <input type="text" class="form-control text-center datepicker12" name="bulan_awal" id="bulan_awal" placeholder="Bulan Awal"/>
                                            
                                            <div class="input-group-append sampai" hidden>
                                                <span class="input-group-text bg-info b-0 text-white">s / d</span>
                                            </div>
                                            <input type="text" class="form-control text-center datepicker12" name="bulan_akhir" id="bulan_akhir" placeholder="Bulan Akhir" hidden/>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="row">
                                    <label class="col-sm-4 text-dark mt-2">List <span id="judul_list">Dtw / Akomodasi</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control sel2" name="list" id="list" disabled>
                                            <option value="all">-- Pilih List Dtw / Akomodasi --</option>
                                        </select>

                                        <div id="loading_list" style="margin-top: 10px;" align='center'>
                                            <img src="<?= base_url('assets/img/loading.gif') ?>" width="18"> <small>Loading...</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="card-footer d-flex justify-content-end mb-3">
                    <button class="btn btn-sm btn-primary mt-2 mr-3" id="tampilkan" type="button">Tampilkan</button>
                    <button class="btn btn-sm btn-success mt-2 mr-3" id="unduh" type="submit">Unduh Excel</button>
                    <button class="btn btn-sm btn-dark mt-2 mr-4" id="reset" type="button">Reset</button>
                </div>
            </form>
        </div>

    </div>
    <div class="card-body">
        <div id="data-awal">
            <div class="tab-content tab-space">
                <div class="tab-pane active link1">
                    <div class="container-fluid list_wisnus mt-3">
                        <table id="tbl_wisnus" class="table table-bordered table-hover table-striped" width="100%">
                            <thead class="thead-light">
                                <th>No</th>
                                <th width="25%">Provinsi</th>
                                <th><?= $bln ?></th>
                                <th><?= $bln_skrg ?></th>
                                <th>Jan-Des <?= $thn ?></th>
                                <th>Jan-Des <?= $thn_skrg ?></th>
                                <th>% Perubahan (m on m)</th>
                                <th>% Perubahan (y on y)</th>
                            </thead>
                            <tbody>
                                <?php 
                                $no=1; 
                                $tot_jumlah_bulan_awal  = 0;
                                $tot_jumlah_bulan_akhir = 0;
                                $tot_jumlah_tahun_awal  = 0;
                                $tot_jumlah_tahun_akhir = 0;
                                $m_on_m                 = 0;
                                $y_on_y                 = 0;

                                foreach ($provinsi as $p): ?>
                                    <tr>
                                        <td class="text-center"><?= $no ?>.</td>
                                        <td><?= $p['nama_provinsi'] ?></td>
                                        <td class="text-right"><?= $p['tot_jumlah_bulan_awal'] ?></td>
                                        <td class="text-right"><?= $p['tot_jumlah_bulan_akhir'] ?></td>
                                        <td class="text-right"><?= $p['tot_jumlah_tahun_awal'] ?></td>
                                        <td class="text-right"><?= $p['tot_jumlah_tahun_akhir'] ?></td>
                                        <td class="text-right"><?= $p['m_on_m'] ?></td>
                                        <td class="text-right"><?= $p['y_on_y'] ?></td>
                                    </tr>
                                <?php 
                                $no++; 
                                $tot_jumlah_bulan_awal  += $p['tot_jumlah_bulan_awal'];
                                $tot_jumlah_bulan_akhir += $p['tot_jumlah_bulan_akhir'];
                                $tot_jumlah_tahun_awal  += $p['tot_jumlah_tahun_awal'];
                                $tot_jumlah_tahun_akhir += $p['tot_jumlah_tahun_akhir'];
                                $m_on_m                 += (int) $p['m_on_m'];
                                $y_on_y                 += (int) $p['y_on_y'];
                            
                                endforeach; ?>
                                <tr>
                                    <th colspan="2" class="text-right">Jumlah 10 Provinsi</th>
                                    <th class="text-right"><?= $tot_jumlah_bulan_awal ?></th>
                                    <th class="text-right"><?= $tot_jumlah_bulan_akhir ?></th>
                                    <th class="text-right"><?= $tot_jumlah_tahun_awal ?></th>
                                    <th class="text-right"><?= $tot_jumlah_tahun_akhir ?></th>
                                    <th class="text-right"><?= number_format($m_on_m,2) ?></th>
                                    <th class="text-right"><?= number_format($y_on_y,2) ?></th>
                                </tr>

                                <tr>
                                    <th colspan="2" class="text-right">Lainnya</th>
                                    <th class="text-right"><?= $lainnya_prov[0]['tot_jumlah_bulan_awal'] ?></th>
                                    <th class="text-right"><?= $lainnya_prov[0]['tot_jumlah_bulan_akhir'] ?></th>
                                    <th class="text-right"><?= $lainnya_prov[0]['tot_jumlah_tahun_awal'] ?></th>
                                    <th class="text-right"><?= $lainnya_prov[0]['tot_jumlah_tahun_akhir'] ?></th>
                                    <th class="text-right"><?= number_format($lainnya_prov[0]['m_on_m'],2) ?></th>
                                    <th class="text-right"><?= number_format($lainnya_prov[0]['y_on_y'],2) ?></th>
                                </tr>

                                <tr>
                                    <th colspan="2" class="text-right">Jumlah Wisnus</th>
                                    <th class="text-right"><?= $tot_jumlah_bulan_awal + $lainnya_prov[0]['tot_jumlah_bulan_awal'] ?></th>
                                    <th class="text-right"><?= $tot_jumlah_bulan_akhir + $lainnya_prov[0]['tot_jumlah_bulan_akhir']?></th>
                                    <th class="text-right"><?= $tot_jumlah_tahun_awal + $lainnya_prov[0]['tot_jumlah_tahun_awal']?></th>
                                    <th class="text-right"><?= $tot_jumlah_tahun_akhir + $lainnya_prov[0]['tot_jumlah_tahun_akhir'] ?></th>
                                    <th class="text-right"><?= number_format($m_on_m + $lainnya_prov[0]['m_on_m'],2) ?></th>
                                    <th class="text-right"><?= number_format($y_on_y + $lainnya_prov[0]['y_on_y'],2) ?></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane link2">
                    <div class="container-fluid list_wisman mt-3">
                        <table id="tbl_wisman" class="table table-bordered table-hover table-striped" width="100%">
                        <thead class="thead-light">
                                <th>No</th>
                                <th width="25%">Negara</th>
                                <th><?= $bln ?></th>
                                <th><?= $bln_skrg ?></th>
                                <th>Jan-Des <?= $thn ?></th>
                                <th>Jan-Des <?= $thn_skrg ?></th>
                                <th>% Perubahan (m on m)</th>
                                <th>% Perubahan (y on y)</th>
                            </thead>
                            <tbody>
                                <?php 
                                $no=1; 
                                $tot_jumlah_bulan_awal  = 0;
                                $tot_jumlah_bulan_akhir = 0;
                                $tot_jumlah_tahun_awal  = 0;
                                $tot_jumlah_tahun_akhir = 0;
                                $m_on_m                 = 0;
                                $y_on_y                 = 0;

                                foreach ($negara as $p): ?>
                                    <tr>
                                        <td class="text-center"><?= $no ?>.</td>
                                        <td><?= $p['nama_negara'] ?></td>
                                        <td class="text-right"><?= $p['tot_jumlah_bulan_awal'] ?></td>
                                        <td class="text-right"><?= $p['tot_jumlah_bulan_akhir'] ?></td>
                                        <td class="text-right"><?= $p['tot_jumlah_tahun_awal'] ?></td>
                                        <td class="text-right"><?= $p['tot_jumlah_tahun_akhir'] ?></td>
                                        <td class="text-right"><?= $p['m_on_m'] ?></td>
                                        <td class="text-right"><?= $p['y_on_y'] ?></td>
                                    </tr>
                                <?php 
                                $no++; 
                                $tot_jumlah_bulan_awal  += $p['tot_jumlah_bulan_awal'];
                                $tot_jumlah_bulan_akhir += $p['tot_jumlah_bulan_akhir'];
                                $tot_jumlah_tahun_awal  += $p['tot_jumlah_tahun_awal'];
                                $tot_jumlah_tahun_akhir += $p['tot_jumlah_tahun_akhir'];
                                $m_on_m                 += (int) $p['m_on_m'];
                                $y_on_y                 += (int) $p['y_on_y'];
                            
                                endforeach; ?>
                                <tr>
                                    <th colspan="2" class="text-right">Jumlah 10 Negara</th>
                                    <th class="text-right"><?= $tot_jumlah_bulan_awal ?></th>
                                    <th class="text-right"><?= $tot_jumlah_bulan_akhir ?></th>
                                    <th class="text-right"><?= $tot_jumlah_tahun_awal ?></th>
                                    <th class="text-right"><?= $tot_jumlah_tahun_akhir ?></th>
                                    <th class="text-right"><?= number_format($m_on_m,2) ?></th>
                                    <th class="text-right"><?= number_format($y_on_y,2) ?></th>
                                </tr>

                                <tr>
                                    <th colspan="2" class="text-right">Lainnya</th>
                                    <th class="text-right"><?= $lainnya_negara[0]['tot_jumlah_bulan_awal'] ?></th>
                                    <th class="text-right"><?= $lainnya_negara[0]['tot_jumlah_bulan_akhir'] ?></th>
                                    <th class="text-right"><?= $lainnya_negara[0]['tot_jumlah_tahun_awal'] ?></th>
                                    <th class="text-right"><?= $lainnya_negara[0]['tot_jumlah_tahun_akhir'] ?></th>
                                    <th class="text-right"><?= number_format($lainnya_negara[0]['m_on_m'],2) ?></th>
                                    <th class="text-right"><?= number_format($lainnya_negara[0]['y_on_y'],2) ?></th>
                                </tr>

                                <tr>
                                    <th colspan="2" class="text-right">Jumlah Wisman</th>
                                    <th class="text-right"><?= $tot_jumlah_bulan_awal + $lainnya_negara[0]['tot_jumlah_bulan_awal'] ?></th>
                                    <th class="text-right"><?= $tot_jumlah_bulan_akhir + $lainnya_negara[0]['tot_jumlah_bulan_akhir']?></th>
                                    <th class="text-right"><?= $tot_jumlah_tahun_awal + $lainnya_negara[0]['tot_jumlah_tahun_awal']?></th>
                                    <th class="text-right"><?= $tot_jumlah_tahun_akhir + $lainnya_negara[0]['tot_jumlah_tahun_akhir'] ?></th>
                                    <th class="text-right"><?= number_format($m_on_m + $lainnya_negara[0]['m_on_m'],2) ?></th>
                                    <th class="text-right"><?= number_format($y_on_y + $lainnya_negara[0]['y_on_y'],2) ?></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="data-filter" hidden>
            
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/js/') ?>ajax/report/dtw.js"></script>

<script>

$(document).ready(function () {

    // 27-02-2020

        $('#loading_list').hide();
        
        // aksi menampilkan data sesuai filter
        $('#tampilkan').on('click', function () {

            var form = $('#form-filter').serialize();

            swal({
                title       : 'Konfirmasi',
                text        : 'Yakin akan kirim data',
                type        : 'warning',
    
                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-info",
                cancelButtonClass   : "btn btn-warning mr-3",
    
                showCancelButton    : true,
                confirmButtonText   : 'Ya',
                confirmButtonColor  : '#3085d6',
                cancelButtonColor   : '#d33',
                cancelButtonText    : 'Batal',
                reverseButtons      : true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url     : "Presentase/menampilkan_filter_perbandingan",
                        type    : "POST",
                        beforeSend  : function () {
                            swal({
                                title   : 'Menunggu',
                                html    : 'Memproses data',
                                onOpen  : () => {
                                    swal.showLoading();
                                }
                            })
                        },
                        data    : form,
                        success : function (data) { 

                            swal.close();

                            $('#data-awal').attr('hidden', true);
                            $('#data-filter').removeAttr('hidden');
                            $('#data-filter').html(data);

                            $('#wisnus').attr('href', '.link3');
                            $('#wisman').attr('href', '.link4');

                        }
                    })

                    return false;
    
                } else if (result.dismiss === swal.DismissReason.cancel) {
    
                    swal({
                        title               : "Batal",
                        text                : 'Anda membatalkan kirim data',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 1000
                    }); 
                }
            })
    
            return false;

        })

        // aksi reset data
        $('#reset').on('click', function () {
            $('#kota').select2('val', '-');
            $('#bulan_awal').val('');
            $('#bulan_akhir').val('');
            $('#jenis_data').select2('val', '-');
            $('.sampai').attr('hidden', true);
            $('#bulan_akhir').attr('hidden', true);
            $('#list').attr('disabled', true);

            $('#data-filter').attr('hidden', true);
            $('#data-awal').removeAttr('hidden');

            $('#wisnus').attr('href', '.link1');
            $('#wisman').attr('href', '.link2');
        })

        // menampilkan list dtw atau hotel 
        $('#jenis_data').change(function () {
            var jenis  = $(this).val();

            $('#list').next('.select2-container').hide();
            $('#loading_list').show();

            $.ajax({
                url         : "Presentase/ambil_list",
                type        : "POST",
                beforeSend 	: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charshet=UTF-8");
                    }				
                },
                data        : {jenis:jenis},
                dataType    : "JSON",
                success     : function (data) {
                    $('#loading_list').hide();
                    $('#list').next('.select2-container').show();
                    $('#judul_list').text(data.judul);

                    $('#list').html(data.option);

                    if (data.judul == 'Dtw / Akomodasi') {
                        $('#list').attr('disabled', true);
                    } else {
                        $('#list').removeAttr('disabled');
                    }
                },
                error 		: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })

            return false;
        })

        // aksi tekan tab wisnus
        $('#wisnus').on('click', function () {
            $('.judul').text('Perbandingan Wisatawan Nusantara');
            $('#jns_wisatawan').val('wisnus');
        })

        // aksi tekan tab wisman
        $('#wisman').on('click', function () {
            $('.judul').text('Perbandingan Wisatawan Mancanegara');
            $('#jns_wisatawan').val('wisman');
        })

        // periode awal
        $('#bulan_awal').on('change', function () {

            var hasil = $(this).val();

            if (hasil == '') {
                $('.sampai').attr('hidden', true);
                $('#bulan_akhir').attr('hidden', true);
            } else {
                $('.sampai').removeAttr('hidden');
                $('#bulan_akhir').removeAttr('hidden');
            }

        })

        // cek periode awal
        $('#bulan_akhir').on('change', function () {
            var bulan_akhir = $(this).val();
            var bulan_awal  = $('#bulan_awal').val();

            $.ajax({
                url         : "Presentase/cek_bulan_akhir",
                type        : "POST",
                beforeSend 	: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charshet=UTF-8");
                    }				
                },
                data        : {bulan_awal:bulan_awal, bulan_akhir:bulan_akhir},
                dataType    : "JSON",
                success     : function (data) {

                    console.log(data.cek);
                    
                    if (data.cek == 'beda') {
                        swal({
                            title               : "Peringatan",
                            text                : 'Periode bulan akhir harus pada tahun '+data.tahun+' atau tahun '+data.tahun_awal,
                            buttonsStyling      : false,
                            confirmButtonClass  : "btn btn-success",
                            type                : 'warning',
                            showConfirmButton   : false,
                            timer               : 2000
                        });    

                        $('#bulan_akhir').val('');
                    }

                    if (data.cek == 'sama_bulan_tahun') {
                        swal({
                            title               : "Peringatan",
                            text                : 'Harap pilih bulan yang berbeda',
                            buttonsStyling      : false,
                            confirmButtonClass  : "btn btn-success",
                            type                : 'warning',
                            showConfirmButton   : false,
                            timer               : 2000
                        });    

                        $('#bulan_akhir').val('');
                    }

                },
                error 		: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })

            return false;

        })

    // Akhir 27-02-2020

})

</script>