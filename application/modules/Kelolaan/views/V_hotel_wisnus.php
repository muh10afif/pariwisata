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
        position:fixed;
        width:85%;
        height:60px;
        bottom:-20px;
    }

    .my-float{
        margin-top:22px;
    }
</style>
<div class="card">
    <form method="POST" id="form_wisnus_hotel">
    <div class="card-header card-header-tabs card-header-rose">
            <h3 class="float-left" style="margin-top: -1px;">Input Wisatawan Nusantara</h3>
        <div class="card-body">
            <div class="card" style="margin-top:50px;opacity:0.8">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6 col-lg-6">
                        <input type="hidden" id="id_rekap">
                        <input type="hidden" id="id_hotel" name="id_hotel" value="<?= $id_hotel ?>">
                            <div class="input-group ">
                            <p id="label_hotel" class="font-weight-bold mt-2">Nama Hotel : <?= $nama_hotel ?></p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="input-group "> 
                            <input type="text" class="form-control datepicker11" id="periode_h" name="periode" placeholder="Pilih Tanggal Periode" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <span class="col-md-3 font-weight-bold">Provinsi</span>
                                <select name="provinsi" id="provinsi" class="form-control sel2">
                                    <?php foreach ($provinsi as $p): ?>
                                        <option value="<?= $p->id_provinsi ?>"><?= $p->nama_provinsi ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="text" id="nm_provinsi" class="form-control" hidden>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <span class="col-md-3 font-weight-bold">Pria</span>
                                <input type="number" name="pria" id="pria" class="form-control" placeholder="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <span class="col-md-3 font-weight-bold">Wanita</span>
                                <input type="number" name="wanita" id="wanita" class="form-control" placeholder="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <span class="col-md-3 font-weight-bold">Jumlah</span>
                                <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="0">
                            </div>
                        </div>
                    </div> 
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-warning mt-3 mb-3" type="button" id="tambah_hotel">Tambah</button>
                        <button class="btn btn-warning mt-3 mb-3 mr-3" type="button" id="ubah_hotel" hidden>Ubah Data</button>
                        <button class="btn btn-default mt-3 mb-3" type="button" id="cancel_hotel" hidden>Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body table-responsive">
    
        <div class="container-fluid mt-3 table-responsive">
           <table class="table table-light table-bordered table-hover table-striped" id="tabel_list_input_wisnus" width="100%">
               <thead class="thead-light">
                   <tr>
                       <th>No</th>
                       <th>Provinsi</th>
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
        <table border="0" style="margin-top: 0px; margin-left: 35%;" width="50%">
            <th>Total Pria : <span id="tp">0</span></th>
            <th>Total Wanita : <span id="tw">0</span></th>
            <th width="30%">Total Jumlah : <span id="tj">0</span></th>
        </table>
    </div>
</div>

<!-- <div class="float">
    <button class="btn btn-rose my-float" id="simpan_list_wisnus_hotel" type="button" hidden>Simpan</button>
</div> -->

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

        // menampilkan data
        var tabel_list_input_wisnus = $('#tabel_list_input_wisnus').DataTable({
            "processing"    : true,
            // "dom"           : "t",
            "ajax"          : {
                "url"   : "<?=base_url("Kelolaan/Hotel/tampil_list_hotel")?>",
                "type"  : "POST",
                "data"  : function (data) {
                    data.periode    = $('#periode_h').val();
                    data.id_hotel   = $('#id_hotel').val();
                }
            },
            stateSave       : true,
            "order"         : [ [0, 'asc']],
            "columnDefs"        : [{
                "targets"   : [2,3,4],
                "className" : 'text-center'
            }, {
                "targets"   : [5],
                "orderable" : false
            }],
            "paging"        : false
        });

        // ubah data
        $('#tabel_list_input_wisnus').on('click', '.ubah-hotel', function () {
            
            var id_rekap_wisnus_hotel = $(this).data('id');

            $.ajax({
                url     : "<?= base_url('Kelolaan/Hotel/tampil_data_ubah_hotel') ?>",
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
                data    : {id_rekap_wisnus_hotel:id_rekap_wisnus_hotel},
                dataType: "JSON",
                success : function (data) { 
                    swal.close();

                    $('#pria').val(data.pria);
                    $('#wanita').val(data.wanita);
                    $('#jumlah').val(data.jumlah);
                    $('#provinsi').next('.select2-container').hide();
                    $('#nm_provinsi').removeAttr('hidden');
                    $('#nm_provinsi').attr('disabled', true);
                    $('#nm_provinsi').val(data.nm_provinsi);
                    $('#id_rekap').val(data.id_rekap);
                    $('#periode_h').attr('disabled', true);

                    $('.ubah-hotel').attr('disabled', true);
                    $('.hapus-hotel').attr('disabled', true);
                    $('#simpan_list_wisnus_hotel').attr('disabled', true);

                    $('#tambah_hotel').attr('hidden', true);
                    $('#ubah_hotel').removeAttr('hidden');
                    $('#cancel_hotel').removeAttr('hidden');
                    
                }
            })

            return false;

        })

        // hapus data list hotel
        $('#tabel_list_input_wisnus').on('click', '.hapus-hotel', function () {
            
            var id_rekap_wisnus_hotel = $(this).data('id');
            var periode             = $('#periode_h').val();
            var id_hotel              = $('#id_hotel').val();

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
                        url     : "<?= base_url('Kelolaan/Hotel/simpan_ubah_hapus_list') ?>",
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
                        data    : {id_rekap:id_rekap_wisnus_hotel, periode:periode, id_hotel:id_hotel, aksi:'hapus'},
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

                            tabel_list_input_wisnus.ajax.reload(null,false);                   

                            $('#tp').text(data.tot_pria);
                            $('#tw').text(data.tot_wanita);
                            $('#tj').text(data.tot_jumlah);

                            $('#pria').val('');
                            $('#wanita').val('');
                            $('#jumlah').val('');

                            // $('#provinsi').html(data.provinsi);

                            $('#simpan_list_wisnus_hotel').removeAttr('hidden');
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

        // cancel ubah data hotel
        $('#cancel_hotel').on('click', function () {

            var periode     = $('#periode_h').val();
            var id_hotel      = $('#id_hotel').val();

            $.ajax({
                url     : "<?= base_url('Kelolaan/Hotel/ambil_option_provinsi') ?>",
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
                data    : {periode:periode, id_hotel:id_hotel},
                dataType: "JSON",
                success : function (data) {   
                    swal.close();   

                    $('#pria').val('');
                    $('#wanita').val('');
                    $('#jumlah').val('');
                    $('#tambah_hotel').removeAttr('hidden');
                    $('#ubah_hotel').attr('hidden', true);
                    $('#cancel_hotel').attr('hidden', true);
                    $('#periode_h').removeAttr('disabled');

                    $('.ubah-hotel').removeAttr('disabled');
                    $('.hapus-hotel').removeAttr('disabled');
                    $('#simpan_list_wisnus_hotel').removeAttr('disabled');
                    
                    $('#provinsi').next('.select2-container').show();
                    $('#nm_provinsi').attr('hidden', true);
                    // $('#provinsi').html(data.provinsi);

                }
            })

            return false;

        })

        // ubah data hotel
        $('#ubah_hotel').on('click', function () {
            
            var id_hotel   = $('#id_hotel').val();
            var periode  = $('#periode_h').val();
            var id_rekap = $('#id_rekap').val();
            var pria     = $('#pria').val();
            var wanita   = $('#wanita').val();
            var jumlah   = $('#jumlah').val();

            $.ajax({
                url      : "<?= base_url('Kelolaan/Hotel/simpan_ubah_hapus_list') ?>",
                type     : "POST",
                data     : {periode:periode, id_hotel:id_hotel, pria:pria, wanita:wanita, jumlah:jumlah, id_rekap:id_rekap, aksi:'ubah'},
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

                    tabel_list_input_wisnus.ajax.reload(null, false);                   

                    $('#tp').text(data.tot_pria);
                    $('#tw').text(data.tot_wanita);
                    $('#tj').text(data.tot_jumlah);

                    $('#pria').val('');
                    $('#wanita').val('');
                    $('#jumlah').val('');

                    $('#tambah_hotel').removeAttr('hidden');
                    $('#ubah_hotel').attr('hidden', true);
                    $('#cancel_hotel').attr('hidden', true);
                    $('#periode_h').removeAttr('disabled');

                    $('.ubah-hotel').removeAttr('disabled');
                    $('.hapus-hotel').removeAttr('disabled');
                    $('#simpan_list_wisnus_hotel').removeAttr('disabled');
                    
                    $('#provinsi').next('.select2-container').show();
                    $('#nm_provinsi').attr('hidden', true);
                    // $('#provinsi').html(data.provinsi);

                    $('#simpan_list_wisnus_hotel').removeAttr('hidden');
                }
            })

            return false;

        })

        // proses simpan list wisnus hotel
        $('#simpan_list_wisnus_hotel').on('click', function () {

            var periode     = $('#periode_h').val();
            var id_hotel    = $('#id_hotel').val();

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
                        url     : "<?= base_url('Kelolaan/Hotel/simpan_list_wisnus_hotel') ?>",
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
                        data    : {periode:periode, id_hotel:id_hotel},
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

                            tabel_list_input_wisnus.clear().draw();                   

                            $('#tp').text('0');
                            $('#tw').text('0');
                            $('#tj').text('0');

                            $('#pria').val('');
                            $('#wanita').val('');
                            $('#jumlah').val('');
                            $('#periode_h').val('');
                            
                            // $('#provinsi').html(data.provinsi);

                            $('#simpan_list_wisnus_hotel').attr('hidden', true);
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
        $('#tambah_hotel').on('click', function () {

            var periode     = $('#periode_h').val();
            var pria        = $('#pria').val();
            var wanita      = $('#wanita').val();
            var jumlah      = $('#jumlah').val();
            var provinsi    = $('#provinsi').val();
            var id_hotel      = $('#id_hotel').val();

            // mengambil nama provinsi
            var nm_provinsi   = $("#provinsi option:selected").text();

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

                // cek provinsi
                $.ajax({
                    url     : "<?= base_url('Kelolaan/Hotel/cek_provinsi') ?>",
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
                    data    : {periode:periode,id_hotel:id_hotel, provinsi:provinsi},
                    dataType: "JSON",
                    success : function (data) {

                        var id_rekap_wisnus_hotel = data.id_rkp_wisnus_hotel;
                        var jml_pengunjung        = data.jml_pengunjung;
                        var add_time              = data.add_time;
                        
                        if (data.cek == 0) {
                            
                            $.ajax({
                                url     : "<?= base_url('Kelolaan/Hotel/simpan_list') ?>",
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
                                data    : {periode:periode, pria:pria, wanita:wanita, jumlah:jumlah, provinsi:provinsi, id_hotel:id_hotel, jenis_data:'wisnus'},
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

                                    tabel_list_input_wisnus.ajax.reload(null, false);                   

                                    $('#tp').text(data.tot_pria);
                                    $('#tw').text(data.tot_wanita);
                                    $('#tj').text(data.tot_jumlah);

                                    $('#pria').val('');
                                    $('#wanita').val('');
                                    $('#jumlah').val('');

                                    // // $('#provinsi').html(data.provinsi);

                                    $('#simpan_list_wisnus_hotel').removeAttr('hidden');
                                }
                            })

                            return false;
                            
                        } else {
                            
                            swal({
                                title       : 'Konfirmasi',
                                html        : "Data Wisatawan dari provinsi "+nm_provinsi+" tanggal "+periode+" terakhir diinput "+add_time+"<br> Sejumlah <b>"+jml_pengunjung+" Pengunjung</b><br><br><b>Apakah data saat ini untuk menggantikan data sebelumnya atau menambahkan jumlah data sebelumnya?</b>",
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
                                        url         : "<?= base_url('Kelolaan/Hotel/simpan_list') ?>",
                                        method      : "POST",
                                        data        : {periode:periode, pria:pria, wanita:wanita, jumlah:jumlah, provinsi:provinsi, id_hotel:id_hotel, id_rekap_wisnus_hotel:id_rekap_wisnus_hotel, aksi:'tambah_baru', jenis_data:'wisnus'},
                                        dataType    : "JSON",
                                        success     : function (data) {
                                            tabel_list_input_wisnus.ajax.reload(null, false);

                                            swal({
                                                title               : "Berhasil",
                                                text                : 'Data berhasil ditambahkan',
                                                buttonsStyling      : false,
                                                confirmButtonClass  : "btn btn-success",
                                                type                : 'success',
                                                showConfirmButton   : false,
                                                timer               : 1000
                                            });    

                                            $('#tp').text(data.tot_pria);
                                            $('#tw').text(data.tot_wanita);
                                            $('#tj').text(data.tot_jumlah);

                                            $('#pria').val('');
                                            $('#wanita').val('');
                                            $('#jumlah').val('');

                                            // $('#provinsi').html(data.provinsi);

                                            $('#simpan_list_wisnus_hotel').removeAttr('hidden');

                                        },
                                        error       : function(xhr, status, error) {
                                            var err = eval("(" + xhr.responseText + ")");
                                            alert(err.Message);
                                        }

                                    })

                                    return false;

                                } else if (result.dismiss === swal.DismissReason.cancel) {
                                    
                                    $.ajax({
                                        url         : "<?= base_url('Kelolaan/Hotel/simpan_list') ?>",
                                        method      : "POST",
                                        data        : {periode:periode, pria:pria, wanita:wanita, jumlah:jumlah, provinsi:provinsi, id_hotel:id_hotel, id_rekap_wisnus_hotel:id_rekap_wisnus_hotel, aksi:'ubah_jumlah_data', jenis_data:'wisnus'},
                                        dataType    : "JSON",
                                        success     : function (data) {
                                            tabel_list_input_wisnus.ajax.reload(null, false);

                                            swal({
                                                title               : "Berhasil",
                                                text                : 'Data berhasil ditambahkan',
                                                buttonsStyling      : false,
                                                confirmButtonClass  : "btn btn-success",
                                                type                : 'success',
                                                showConfirmButton   : false,
                                                timer               : 1000
                                            });    

                                            $('#tp').text(data.tot_pria);
                                            $('#tw').text(data.tot_wanita);
                                            $('#tj').text(data.tot_jumlah);

                                            $('#pria').val('');
                                            $('#wanita').val('');
                                            $('#jumlah').val('');

                                            // $('#provinsi').html(data.provinsi);

                                            $('#simpan_list_wisnus_hotel').removeAttr('hidden');

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
        $('#periode_h').on('change', function () {
            var periode     = $('#periode_h').val();
            var id_hotel    = $('#id_hotel').val();
            var provinsi    = $('#provinsi').val();

            $('#periode_h').attr('data', 'lihat');

            var data = $(this).attr('data');

            console.log(id_hotel);

            $.ajax({
                url     : "<?= base_url('Kelolaan/Hotel/simpan_list') ?>",
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
                data    : {periode:periode, id_hotel:id_hotel, data:data, jenis_data:'wisnus'},
                dataType: "JSON",
                success : function (data) {
                    swal.close();
                    
                    tabel_list_input_wisnus.ajax.reload(null, false);                   

                    $('#tp').text(data.tot_pria);
                    $('#tw').text(data.tot_wanita);
                    $('#tj').text(data.tot_jumlah);

                    $('#periode_h').removeAttr('data');

                    // $('#provinsi').html(data.provinsi);

                    $('#provinsi').val(provinsi);

                    $('#periode_h').val(data.periode);

                    if (data.tot_jumlah == null) {
                        $('#simpan_list_wisnus_hotel').attr('hidden', true);
                    } else {
                        $('#simpan_list_wisnus_hotel').removeAttr('hidden');
                    }
                    
                }
            })

            return false;
        })

        // hitung jumlah pria
        $('#pria').on('keyup', function () {
            
            var a = $(this).val();
            var b = $('#wanita').val();

            var c = +a + +b;

            $('#jumlah').val(c);

        })

        // hitung jumlah wanita
        $('#wanita').on('keyup', function () {
            
            var a = $(this).val();
            var b = $('#pria').val();

            var c = +a + +b;

            $('#jumlah').val(c);

        })
        
    })
</script>