<!-- AFIF -->
<style>
    thead tr th {
        text-align: center;
        vertical-align: middle;
        font-weight: bold;
    }
    .float{
        position:fixed;
        width:60px;
        height:60px;
        bottom:20px;
        right:120px;
        text-align:center;
    }

    .float-b{
        position    :fixed;
        width       :115%;
        height      :60px;
        bottom      :-20px;
    }

    .my-float{
        margin-top:22px;
    }
</style>
<div class="card">
    <form method="POST" id="form_wisman_dtw">
    <div class="card-header card-header-tabs card-header-rose">
            <h3 class="float-left" style="margin-top: -1px;">Input Wisatawan Mancanegara</h3>
        <div class="card-body">
            <div class="card" style="margin-top:50px;opacity:0.8">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6 col-lg-6">
                        <input type="hidden" id="id_rekap">
                        <input type="hidden" id="id_dtw" name="id_dtw" value="<?= $id_dtw ?>">
                            <div class="input-group ">
                            <p id="label_dtw" class="font-weight-bold mt-2">Nama DTW : <?= $nama_dtw ?></p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <span class="col-md-3 font-weight-bold">Tanggal Periode</span>
                                <input type="text" class="form-control datepicker11" id="periode_h_wisman" name="periode" placeholder="Pilih Tanggal Periode" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <span class="col-md-3 font-weight-bold">Kawasan</span>
                                <select name="kawasan" id="kawasan" class="form-control sel2">
                                    <option value="x">-- Pilih Kawasan --</option>
                                    <?php foreach ($kawasan as $p): ?>
                                        <option value="<?= $p['id_kawasan'] ?>"><?= $p['nama_kawasan'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="text" id="nm_kawasan" class="form-control" hidden>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <span class="col-md-3 font-weight-bold">Negara</span>
                                <select name="negara" id="negara" class="form-control sel2" disabled>
                                    <option value="x">-- Pilih Negara --</option>

                                </select>

                                <div id="loading_negara" style="margin-top: 10px;" align='center'>
                                    <img src="<?= base_url('assets/img/loading.gif') ?>" width="18"> <small>Loading...</small>
                                </div>
                                <input type="text" id="nm_negara" class="form-control" hidden>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <span class="col-md-3 font-weight-bold">Pria</span>
                                <input type="number" name="pria" id="pria_wisman" class="form-control" placeholder="0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <span class="col-md-3 font-weight-bold">Wanita</span>
                                <input type="number" name="wanita" id="wanita_wisman" class="form-control" placeholder="0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <span class="col-md-3 font-weight-bold">Jumlah</span>
                                <input type="number" name="jumlah" id="jumlah_wisman" class="form-control" placeholder="0">
                            </div>
                        </div>
                    </div> 
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-warning mt-3 mb-3" type="button" id="tambah_dtw_wisman">Tambah</button>
                        <button class="btn btn-warning mt-3 mb-3 mr-3" type="button" id="ubah_dtw_wisman" hidden>Ubah Data</button>
                        <button class="btn btn-default mt-3 mb-3" type="button" id="cancel_dtw_wisman" hidden>Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body table-responsive">
    
        <div class="container-fluid mt-3 table-responsive">
           <table class="table table-hover table-bordered table-striped" id="tabel_list_input_wisman" width="100%">
               <thead class="thead-light">
                   <tr>
                       <th>No</th>
                       <th>Kawasan</th>
                       <th>Negara</th>
                       <th>Pria</th>
                       <th>Wanita</th>
                       <th>Jumlah</th>
                       <th>Aksi</th>
                   </tr>
               </thead>
               <tbody>
               </tbody>
           </table>
        </div>
            
    </div>
    </form>
</div>

<div class="card float-b">
    <div class="card-body table-responsive">
        <table border="0" style="margin-top: 0px; margin-left: 35%;" width="30%">
            <th>Total Pria : <span id="tp_wisman">0</span></th>
            <th>Total Wanita : <span id="tw_wisman">0</span></th>
            <th>Total Jumlah : <span id="tj_wisman">0</span></th>
        </table>
    </div>
</div>

<div class="float">
    <!-- <button class="btn btn-rose my-float" id="simpan_list_wisman_dtw" type="button" hidden>Simpan</button> -->
</div>

<script>

// menampilkan loading web
(function($){
    var config = {};

    $.loading = function (options) {

        var opts = $.extend(
            $.loading.default,
            options
        );

        config = opts;
        init(opts);

        var selector = '#' + opts.id;

        $(document).on('ajaxStart', function(){
            if (config.ajax) {
                $(selector).show();
            }
        });

        $(document).on('ajaxComplete', function(){
            setTimeout(function(){
                $(selector).hide();
            }, opts.minTime);
        });

        return $.loading;
    };

    $.loading.open = function (time) {
        var selector = '#' + config.id;
        $(selector).show();
        if (time) {
            setTimeout(function(){
                $(selector).hide();
            }, parseInt(time));
        }
    };

    $.loading.close = function () {
        var selector = '#' + config.id;
        $(selector).hide();
    };

    $.loading.ajax = function (isListen) {
        config.ajax = isListen;
    };

    $.loading.default = {
        ajax       : true,
        //wrap div
        id         : 'ajaxLoading',
        zIndex     : '1000',
        background : 'rgba(0, 0, 0, 0.7)',
        minTime    : 200,
        radius     : '4px',
        width      : '85px',
        height     : '85px',

        //loading img/gif
        imgPath    : "<?= base_url('assets/js/loading-ajax/img/ajax-loading.gif') ?>",
        imgWidth   : '45px',
        imgHeight  : '45px',

        //loading text
        tip        : 'loading...',
        fontSize   : '14px',
        fontColor  : '#fff'
    };

    function init (opts) {
        //wrap div style
        var wrapCss = 'display: none;position: fixed;top: 0;bottom: 0;left: 0;right: 0;margin: auto;padding: 8px;text-align: center;vertical-align: middle;';
        var cssArray = [
            'width:' + opts.width,
            'height:' + opts.height,
            'z-index:' + opts.zIndex,
            'background:' + opts.background,
            'border-radius:' + opts.radius
        ];
        wrapCss += cssArray.join(';');

        //img style
        var imgCss = 'margin-bottom:8px;';
        cssArray = [
            'width:' + opts.imgWidth,
            'height:' + opts.imgWidth
        ];
        imgCss += cssArray.join(';');

        //text style
        var textCss = 'margin:0;';
        cssArray = [
            'font-size:' + opts.fontSize,
            'color:'     + opts.fontColor
        ];
        textCss += cssArray.join(';');

        var html = '<div id="' + opts.id + '" style="' + wrapCss + '">'
                  +'<img src="' + opts.imgPath + '" style="' + imgCss + '">'
                  +'<p style="' + textCss + '">' + opts.tip + '</p></div>';

        $(document).find('body').append(html);
    }

})(window.jQuery||window.Zepto);

</script>

<script>
    $(document).ready(function () {

        $('#loading_negara').hide();

        // menampilkan data
        var tabel_list_input_wisman = $('#tabel_list_input_wisman').DataTable({
            "processing"    : true,
            // "dom"           : "t",
            "ajax"          : {
                "url"   : "<?=base_url("Kelolaan/Dtw/tampil_list_dtw_wisman")?>",
                "type"  : "POST",
                "data"  : function (data) {
                    data.periode   = $('#periode_h_wisman').val();
                    data.id_dtw    = $('#id_dtw').val();
                }
            },
            stateSave       : true,
            "order"         : [ [0, 'asc']],
            "columnDefs"        : [{
                "targets"   : [3,4,5],
                "className" : 'text-center'
            }, {
                "targets"   : [6],
                "orderable" : false
            }],
            "paging"        : false
        });

        // menampilkan list negara
        $('#kawasan').change(function () {
            var id_kawasan  = $(this).find('option:selected').val();
            var aksi        = $(this).attr('data');
            var periode     = $('#periode_h_wisman').val();
            var id_dtw      = $('#id_dtw').val();

            $('#negara').next('.select2-container').hide();
            $('#loading_negara').show();

            $.ajax({
                url         : "<?= base_url('Kelolaan/Dtw/ambil_negara') ?>",
                type        : "POST",
                beforeSend 	: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charshet=UTF-8");
                    }				
                },
                data        : {id_kawasan:id_kawasan, aksi:aksi, periode:periode, id_dtw:id_dtw},
                dataType    : "JSON",
                success     : function (data) {
                    $('#loading_negara').hide();
                    $('#negara').next('.select2-container').show();

                    if (data.ds != 'aktif') {
                        $('#negara').attr('disabled', true);
                    } else {
                        $('#negara').removeAttr('disabled');
                    }

                    $('#negara').html(data.negara);
                },
                error 		: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        })

        // ubah data
        $('#tabel_list_input_wisman').on('click', '.ubah-dtw-wisman', function () {
            
            var id_rekap_wisman_dtw = $(this).data('id');

            $.ajax({
                url     : "<?= base_url('Kelolaan/Dtw/tampil_data_ubah_dtw_wisman') ?>",
                type    : "POST",
                beforeSend  : function () {
                    swal({
                        title   : 'Menunggu',
                        html    : 'Memproses halaman',
                        onOpen  : () => {
                            swal.showLoading();
                        }
                    })
                },
                data    : {id_rekap_wisman_dtw:id_rekap_wisman_dtw},
                dataType: "JSON",
                success : function (data) { 
                    swal.close();

                    $('#pria_wisman').val(data.pria);
                    $('#wanita_wisman').val(data.wanita);
                    $('#jumlah_wisman').val(data.jumlah);
                    $('#kawasan').next('.select2-container').hide();
                    $('#nm_kawasan').removeAttr('hidden');
                    $('#nm_kawasan').attr('disabled', true);
                    $('#nm_kawasan').val(data.nm_kawasan);

                    $('#negara').next('.select2-container').hide();
                    $('#nm_negara').removeAttr('hidden');
                    $('#nm_negara').attr('disabled', true);
                    $('#nm_negara').val(data.nm_negara);

                    $('#id_rekap').val(data.id_rekap);
                    $('#periode_h_wisman').attr('disabled', true);

                    $('.ubah-dtw-wisman').attr('disabled', true);
                    $('.hapus-dtw-wisman').attr('disabled', true);
                    $('#simpan_list_wisman_dtw').attr('disabled', true);

                    $('#tambah_dtw_wisman').attr('hidden', true);
                    $('#ubah_dtw_wisman').removeAttr('hidden');
                    $('#cancel_dtw_wisman').removeAttr('hidden');
                    
                }
            })

            return false;

        })

        // hapus data list dtw
        $('#tabel_list_input_wisman').on('click', '.hapus-dtw-wisman', function () {
            
            var id_rekap_wisman_dtw = $(this).data('id');
            var periode             = $('#periode_h_wisman').val();
            var id_dtw              = $('#id_dtw').val();

            swal({
                title       : 'Konfirmasi',
                text        : 'Yakin akan hapus data',
                type        : 'warning',

                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-danger",
                cancelButtonClass   : "btn btn-warning mr-3",

                showCancelButton    : true,
                confirmButtonText   : 'Hapus',
                confirmButtonColor  : '#3085d6',
                cancelButtonColor   : '#d33',
                cancelButtonText    : 'Tidak',
                reverseButtons      : true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url     : "<?= base_url('Kelolaan/Dtw/simpan_ubah_hapus_list_wisman') ?>",
                        type    : "POST",
                        beforeSend  : function () {
                            swal({
                                title   : 'Menunggu',
                                html    : 'Memproses halaman',
                                onOpen  : () => {
                                    swal.showLoading();
                                }
                            })
                        },
                        data    : {id_rekap:id_rekap_wisman_dtw, periode:periode, id_dtw:id_dtw, aksi:'hapus'},
                        dataType: "JSON",
                        success : function (data) {
                            swal({
                                title               : "Berhasil",
                                text                : 'Data berhasil dihapus',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            });    

                            tabel_list_input_wisman.ajax.reload(null,false);                   

                            $('#tp_wisman').text(data.tot_pria);
                            $('#tw_wisman').text(data.tot_wanita);
                            $('#tj_wisman').text(data.tot_jumlah);

                            $('#pria_wisman').val('');
                            $('#wanita_wisman').val('');
                            $('#jumlah_wisman').val('');

                            $('#kawasan').attr('data', 'cari_negara');

                            $('#kawasan').select2('val', 'x');
                            $('#negara').select2('val', 'x');
                            $('#negara').attr('disabled', true);

                            if (data.tot_jumlah == null) {
                                $('#simpan_list_wisman_dtw').attr('hidden', true);
                            } else {
                                $('#simpan_list_wisman_dtw').removeAttr('hidden');
                            }
                        }
                    })

                    return false;

                } else if (result.dismiss === swal.DismissReason.cancel) {

                    swal({
                        title               : "Batal",
                        text                : 'Anda membatalkan hapus data',
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

        // cancel ubah data dtw
        $('#cancel_dtw_wisman').on('click', function () {  

            $('#pria_wisman').val('');
            $('#wanita_wisman').val('');
            $('#jumlah_wisman').val('');
            $('#tambah_dtw_wisman').removeAttr('hidden');
            $('#ubah_dtw_wisman').attr('hidden', true);
            $('#cancel_dtw_wisman').attr('hidden', true);
            $('#periode_h_wisman').removeAttr('disabled');

            $('.ubah-dtw-wisman').removeAttr('disabled');
            $('.hapus-dtw-wisman').removeAttr('disabled');
            $('#simpan_list_wisman_dtw').removeAttr('disabled');

            $('#kawasan').attr('data', 'cari_negara');
            
            $('#kawasan').next('.select2-container').show();
            $('#nm_kawasan').attr('hidden', true);

            $('#negara').next('.select2-container').show();
            $('#nm_negara').attr('hidden', true);

            $('#kawasan').select2('val', 'x');
            $('#negara').select2('val', 'x');
            $('#negara').attr('disabled', true);

        })

        // ubah data dtw
        $('#ubah_dtw_wisman').on('click', function () {
            
            var id_dtw   = $('#id_dtw').val();
            var periode  = $('#periode_h_wisman').val();
            var id_rekap = $('#id_rekap').val();
            var pria     = $('#pria_wisman').val();
            var wanita   = $('#wanita_wisman').val();
            var jumlah   = $('#jumlah_wisman').val();

            $.ajax({
                url      : "<?= base_url('Kelolaan/Dtw/simpan_ubah_hapus_list_wisman') ?>",
                type     : "POST",
                data     : {periode:periode, id_dtw:id_dtw, pria:pria, wanita:wanita, jumlah:jumlah, id_rekap:id_rekap, aksi:'ubah'},
                dataType : "JSON",
                success  : function (data) {
                    swal({
                        title               : "Berhasil",
                        text                : 'Data berhasil diubah',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-success",
                        type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                    });    

                    tabel_list_input_wisman.ajax.reload(null, false);                   

                    $('#tp_wisman').text(data.tot_pria);
                    $('#tw_wisman').text(data.tot_wanita);
                    $('#tj_wisman').text(data.tot_jumlah);

                    $('#pria_wisman').val('');
                    $('#wanita_wisman').val('');
                    $('#jumlah_wisman').val('');

                    $('#tambah_dtw_wisman').removeAttr('hidden');
                    $('#ubah_dtw_wisman').attr('hidden', true);
                    $('#cancel_dtw_wisman').attr('hidden', true);
                    $('#periode_h_wisman').removeAttr('disabled');

                    $('.ubah-dtw-wisman').removeAttr('disabled');
                    $('.hapus-dtw-wisman').removeAttr('disabled');
                    $('#simpan_list_wisman_dtw').removeAttr('disabled');
                    
                    $('#kawasan').next('.select2-container').show();
                    $('#nm_kawasan').attr('hidden', true);

                    $('#negara').next('.select2-container').show();
                    $('#nm_negara').attr('hidden', true);

                    $('#kawasan').attr('data', 'cari_negara');

                    $('#simpan_list_wisman_dtw').removeAttr('hidden');
                }
            })

            return false;

        })

        // proses simpan list wisman dtw
        $('#simpan_list_wisman_dtw').on('click', function () {

            var periode     = $('#periode_h_wisman').val();
            var id_dtw      = $('#id_dtw').val();

            swal({
                title       : 'Konfirmasi',
                text        : 'Yakin akan kirim data',
                type        : 'warning',

                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-info",
                cancelButtonClass   : "btn btn-danger mr-3",

                showCancelButton    : true,
                confirmButtonText   : 'Kirim Data',
                confirmButtonColor  : '#3085d6',
                cancelButtonColor   : '#d33',
                cancelButtonText    : 'Batal',
                reverseButtons      : true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url     : "<?= base_url('Kelolaan/Dtw/simpan_list_wisman_dtw') ?>",
                        type    : "POST",
                        beforeSend  : function () {
                            swal({
                                title   : 'Menunggu',
                                html    : 'Memproses halaman',
                                onOpen  : () => {
                                    swal.showLoading();
                                }
                            })
                        },
                        data    : {periode:periode, id_dtw:id_dtw},
                        dataType: "JSON",
                        success : function (data) {
                            swal({
                                title               : "Berhasil",
                                text                : 'Data berhasil ditambahkan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            });    

                            tabel_list_input_wisman.clear().draw();                   

                            $('#tp_wisman').text('0');
                            $('#tw_wisman').text('0');
                            $('#tj_wisman').text('0');

                            $('#pria_wisman').val('');
                            $('#wanita_wisman').val('');
                            $('#jumlah_wisman').val('');
                            $('#periode_h_wisman').val('');
                            
                            $('#kawasan').removeAttr('data');

                            $('#kawasan').select2('val', 'x');
                            $('#negara').select2('val', 'x');
                            $('#negara').attr('disabled', true);

                            $('#simpan_list_wisman_dtw').attr('hidden', true);
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

        // proses tambah list status 0
        $('#tambah_dtw_wisman').on('click', function () {

            var periode     = $('#periode_h_wisman').val();
            var pria        = $('#pria_wisman').val();
            var wanita      = $('#wanita_wisman').val();
            var jumlah      = $('#jumlah_wisman').val();
            var negara      = $('#negara').val();
            var id_dtw      = $('#id_dtw').val();

            // mengambil nama negara
            var nm_negara   = $("#negara option:selected").text();

            if (periode == '') {
                swal({
                    title               : "Peringatan",
                    text                : 'Periode harus terisi dahulu',
                    buttonsStyling      : false,
                    confirmButtonClass  : "btn btn-warning",
                    type                : 'warning',
                    showConfirmButton   : false,
                    timer               : 1000
                });

                return false;
            } else if (negara == 'x') {
                swal({
                    title               : "Peringatan",
                    text                : 'Negara Harus Terisi!',
                    buttonsStyling      : false,
                    confirmButtonClass  : "btn btn-warning",
                    type                : 'warning',
                    showConfirmButton   : false,
                    timer               : 1000
                });

                return false;
            } else if (jumlah == '' || jumlah == 0) {
                swal({
                    title               : "Peringatan",
                    text                : 'Jumlah Pengunjung Harus Terisi!',
                    buttonsStyling      : false,
                    confirmButtonClass  : "btn btn-warning",
                    type                : 'warning',
                    showConfirmButton   : false,
                    timer               : 1000
                });

                return false;
            } else {

                // cek negara
                $.ajax({
                    url     : "<?= base_url('Kelolaan/Dtw/cek_negara') ?>",
                    type    : "POST",
                    beforeSend  : function () {
                        swal({
                            title   : 'Menunggu',
                            html    : 'Memproses halaman',
                            onOpen  : () => {
                                swal.showLoading();
                            }
                        })
                    },
                    data    : {periode:periode,id_dtw:id_dtw, negara:negara},
                    dataType: "JSON",
                    success : function (data) {

                        var id_rekap_wisman_dtw = data.id_rkp_wisman_dtw;
                        var jml_pengunjung      = data.jml_pengunjung;
                        var add_time            = data.add_time;
                        
                        if (data.cek == 0) {
                            
                            $.ajax({
                                url     : "<?= base_url('Kelolaan/Dtw/simpan_list_wisman') ?>",
                                type    : "POST",
                                beforeSend  : function () {
                                    swal({
                                        title   : 'Menunggu',
                                        html    : 'Memproses halaman',
                                        onOpen  : () => {
                                            swal.showLoading();
                                        }
                                    })
                                },
                                data    : {periode:periode, pria:pria, wanita:wanita, jumlah:jumlah, negara:negara, id_dtw:id_dtw},
                                dataType: "JSON",
                                success : function (data) {
                                    swal({
                                        title               : "Berhasil",
                                        text                : 'Data berhasil ditambahkan',
                                        buttonsStyling      : false,
                                        confirmButtonClass  : "btn btn-success",
                                        type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                                    });    

                                    tabel_list_input_wisman.ajax.reload(null, false);                   

                                    $('#tp_wisman').text(data.tot_pria);
                                    $('#tw_wisman').text(data.tot_wanita);
                                    $('#tj_wisman').text(data.tot_jumlah);

                                    $('#pria_wisman').val('');
                                    $('#wanita_wisman').val('');
                                    $('#jumlah_wisman').val('');

                                    $('#kawasan').select2('val', 'x');
                                    $('#negara').select2('val', 'x');
                                    $('#negara').attr('disabled', true);

                                    $('#kawasan').attr('data', 'cari_negara');

                                    $('#simpan_list_wisman_dtw').removeAttr('hidden');
                                }
                            })

                            return false;
                            
                        } else {
                            
                            swal({
                                title       : 'Konfirmasi',
                                html        : "Data Wisatawan dari negara "+nm_negara+" tanggal "+periode+" terakhir diinput "+add_time+"<br> Sejumlah <b>"+jml_pengunjung+" Pengunjung</b><br><br><b>Apakah data saat ini untuk menggantikan data sebelumnya atau menambahkan jumlah data sebelumnya?</b>",
                                type        : 'warning',

                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                cancelButtonClass   : "btn btn-danger mr-1",

                                showCancelButton    : true,
                                confirmButtonText   : 'Mengganti data sebelumnya',
                                confirmButtonColor  : '#3085d6',
                                cancelButtonColor   : '#d33',
                                cancelButtonText    : 'menambahkan jumlah data',
                                reverseButtons      : true
                            }).then((result) => {
                                if (result.value) {
                                    $.ajax({
                                        url         : "<?= base_url('Kelolaan/Dtw/simpan_list_wisman') ?>",
                                        method      : "POST",
                                        data        : {periode:periode, pria:pria, wanita:wanita, jumlah:jumlah, negara:negara, id_dtw:id_dtw, id_rekap_wisman_dtw:id_rekap_wisman_dtw, aksi:'tambah_baru'},
                                        dataType    : "JSON",
                                        success     : function (data) {
                                            tabel_list_input_wisman.ajax.reload(null, false);

                                            swal({
                                                title               : "Berhasil",
                                                text                : 'Data berhasil ditambahkan',
                                                buttonsStyling      : false,
                                                confirmButtonClass  : "btn btn-success",
                                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                                            });    

                                            $('#tp_wisman').text(data.tot_pria);
                                            $('#tw_wisman').text(data.tot_wanita);
                                            $('#tj_wisman').text(data.tot_jumlah);

                                            $('#pria_wisman').val('');
                                            $('#wanita_wisman').val('');
                                            $('#jumlah_wisman').val('');

                                            $('#kawasan').select2('val', 'x');
                                            $('#negara').select2('val', 'x');
                                            $('#negara').attr('disabled', true);

                                            $('#kawasan').attr('data', 'cari_negara');

                                            $('#simpan_list_wisman_dtw').removeAttr('hidden');

                                        },
                                        error       : function(xhr, status, error) {
                                            var err = eval("(" + xhr.responseText + ")");
                                            alert(err.Message);
                                        }

                                    })

                                    return false;

                                } else if (result.dismiss === swal.DismissReason.cancel) {
                                    
                                    $.ajax({
                                        url         : "<?= base_url('Kelolaan/Dtw/simpan_list_wisman') ?>",
                                        method      : "POST",
                                        data        : {periode:periode, pria:pria, wanita:wanita, jumlah:jumlah, negara:negara, id_dtw:id_dtw, id_rekap_wisman_dtw:id_rekap_wisman_dtw, aksi:'ubah_jumlah_data'},
                                        dataType    : "JSON",
                                        success     : function (data) {
                                            tabel_list_input_wisman.ajax.reload(null, false);

                                            swal({
                                                title               : "Berhasil",
                                                text                : 'Data berhasil ditambahkan',
                                                buttonsStyling      : false,
                                                confirmButtonClass  : "btn btn-success",
                                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                                            });    

                                            $('#tp_wisman').text(data.tot_pria);
                                            $('#tw_wisman').text(data.tot_wanita);
                                            $('#tj_wisman').text(data.tot_jumlah);

                                            $('#pria_wisman').val('');
                                            $('#wanita_wisman').val('');
                                            $('#jumlah_wisman').val('');

                                            $('#kawasan').select2('val', 'x');
                                            $('#negara').select2('val', 'x');
                                            $('#negara').attr('disabled', true);

                                            $('#kawasan').attr('data', 'cari_negara');

                                            $('#simpan_list_wisman_dtw').removeAttr('hidden');

                                        },
                                        error       : function(xhr, status, error) {
                                            var err = eval("(" + xhr.responseText + ")");
                                            alert(err.Message);
                                        }

                                    })

                                    return false;
                                    
                                }
                            })

                            return false;

                        }

                    }
                })

                return false;

            }
        })

        // menampilkan data pada periode
        $('#periode_h_wisman').on('change', function () {
            var periode     = $('#periode_h_wisman').val();
            var id_dtw      = $('#id_dtw').val();
            var kws         = $('#kawasan').val();
            var ngr         = $('#negara').val();

            $('#periode_h_wisman').attr('data', 'lihat');

            var data = $(this).attr('data');

            $.ajax({
                url     : "<?= base_url('Kelolaan/Dtw/simpan_list_wisman') ?>",
                type    : "POST",
                beforeSend  : function () {
                    swal({
                        title   : 'Menunggu',
                        html    : 'Memproses halaman',
                        onOpen  : () => {
                            swal.showLoading();
                        }
                    })
                },
                data    : {periode:periode, id_dtw:id_dtw, data:data},
                dataType: "JSON",
                success : function (data) {
                    swal.close();
                    
                    tabel_list_input_wisman.ajax.reload(null, false);                   

                    $('#tp_wisman').text(data.tot_pria);
                    $('#tw_wisman').text(data.tot_wanita);
                    $('#tj_wisman').text(data.tot_jumlah);

                    if (kws != 'x') {
                        $('#kawasan').val(kws);
                    } else {
                        $('#kawasan').select2('val', 'x');
                    }
                    
                    if (ngr != 'x') {
                        $('#negara').val(ngr);
                    } else {
                        $('#negara').select2('val', 'x');
                        $('#negara').attr('disabled', true);
                    }
                    
                    $('#periode_h_wisman').removeAttr('data');

                    $('#periode_h_wisman').val(data.periode);

                    console.log(data.periode);

                    $('#kawasan').attr('data', 'cari_negara');

                    if (data.tot_jumlah == null) {
                        $('#simpan_list_wisman_dtw').attr('hidden', true);
                    } else {
                        $('#simpan_list_wisman_dtw').removeAttr('hidden');
                    }
                    
                }
            })

            return false;
        })

        // hitung jumlah pria
        $('#pria_wisman').on('keyup', function () {
            
            var a = $(this).val();
            var b = $('#wanita_wisman').val();

            var c = +a + +b;

            $('#jumlah_wisman').val(c);

        })

        // hitung jumlah wanita
        $('#wanita_wisman').on('keyup', function () {
            
            var a = $(this).val();
            var b = $('#pria_wisman').val();

            var c = +a + +b;

            $('#jumlah_wisman').val(c);

        })
        
    })
</script>