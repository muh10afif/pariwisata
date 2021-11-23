<style>

thead th {
    text-align: center;
}

</style>
<ul class="nav nav-pills nav-pills-warning" role="tablist" hidden>
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#link1" role="tablist"> User DTW </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#link2" role="tablist"> User Hotel </a>
    </li>
</ul>
<div class="tab-content tab-space">
    <div class="tab-pane active" id="link1">
        <div class="card">
            <div class="card-header card-header-tabs card-header-rose">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <h3 class="float-left" style="margin-top: -1px;">Tabel Penempatan Petugas</h3>
                    </div>
                </div>
                <div class="card" style="opacity:0.8;">
                    <div class="d-flex justify-content-center">
                        <!-- <div class="col-md-4">
                            <div class="form-group">
                                <select name="kota" id="kota" class="form-control sel2" style="margin-top:10px;">
                                    <option value=""></option>
                                    <?php foreach ($kota as $k) { ?>
                                    <option value="<?php  echo $k->nama_kota ?>"><?php echo $k->nama_kota?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div> -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="penempatan-add" id="penempatan-add" class="form-control sel2pn" style="margin-top:10px; width:100%">
                                    <option value="">-- Pilih Tempat Penempatan --</option>
                                    <option value="dtw">DTW</option>
                                    <option value="hotel">Hotel</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="petugas" id="petugas" class="form-control sel2p" style="margin-top:10px; width:100%">
                                    <option value="">-- Pilih Petugas --</option>
                                    <?php foreach ($petugas as $p) { ?>
                                    <option value="<?php  echo $p->id_petugas ?>"><?php echo $p->nama_petugas?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <button id="btn-add" class="btn btn-warning btn-fab btn-round ml-5" style="margin-top:-20px;z-index:9" rel="tooltip" data-original-title="Tambah Data"><i class="material-icons text-white">add</i></button>                            

            <div class="card-body">

                <table id="tbl_penempatan" class="table table-striped table-no-bordered table-hover" style="width: 100%;">
                    <thead class="text-primary">
                        <th width="50px;">No</th>
                        <th>Nama Petugas</th>
                        <th>Penempatan</th>
                        <th>Nama Tempat</th>
                        <th>Status</th>
                        <th width="20%">Aksi</th>
                    </thead>
                    <tbody id="data-penempatan">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="tab-pane " id="link2">
        <div class="card">
            <div class="card-header card-header-tabs card-header-rose">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <h3 class="float-left" style="margin-top: -1px;">Tambah Data Penempatan Pegawai</h3>
                    </div>
                </div>
                <div class="card" style="opacity:0.8;">
                    <div class="d-flex justify-content-center">
                        <div class="col-md-4">
                        <form method="POST">
                            <div class="form-group">
                                <select name="petugas_add" id="petugas_add" class="form-control sel2p" style="margin-top:10px; width:100%">
                                <option value="">-- Pilih Petugas --</option>
                                    <?php foreach ($petugas as $p) { ?>
                                    <option value="<?php  echo $p->id_petugas ?>"><?php echo $p->nama_petugas?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="fil_penempatan" id="fil_penempatan" class="form-control sel2pn" style="margin-top:10px; width:100%">
                                    <option value="">-- Pilih Tempat Penempatan --</option>
                                    <option value="DTW">DTW</option>
                                    <option value="HOTEL">Hotel</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <a id="btn-back" class="btn btn-warning btn-fab btn-round ml-5" style="margin-top:-20px;z-index:9" rel="tooltip" data-original-title="Kembali"><i class="material-icons text-white">chevron_left</i></a>
            <div class="card-body">
                    <table id="tbl_penempatan_add" class="table table-hover table-striped" width="100%">
                    <thead class="text-primary">
                    <tr>
                        <th>No.</th>
                        <th>Check</th>
                        <th>Penempatan</th>
                        <th>Nama Tempat</th>
                        <th>Alamat</th>
                    </tr>
                    </thead>
                    <tbody id="data-penempatan-add">
                    </tbody>   
                    </table>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button type="button" id="simpan_tambah_penempatan" class="btn btn-rose btn-sm float-right">SIMPAN</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_edit_penempatan" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="my-modal-title">Ubah Penempatan</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-3">
                        <p>Petugas</p>
                    </div>
                    <div class="col-md-9">
                        <input type="text" id="nm_petugas" class="form-control" disabled>
                    </div>
                </div>
                <div class="form-group row s_dtw" hidden>
                    <div class="col-md-3">
                        <p>DTW</p>
                    </div>
                    <div class="col-md-9">
                        <select id="select_dtw" class="form-control sel2">

                        </select>
                    </div>
                </div>
                <div class="form-group row s_hotel" hidden>
                    <div class="col-md-3">
                        <p>Hotel</p>
                    </div>
                    <div class="col-md-9">
                        <select id="select_hotel" class="form-control sel2">
                            
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-sm btn-success" type="button" id="simpan_penempatan">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/js/')?>ajax/master/penempatan.js"></script>

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

<!-- <script>
$(document).ready(function () {
    data_penempatan();
    
    function data_penempatan() {
        var id = '<?php echo $userdata->id_kota;?>'
        $.ajax({
            type: "GET",
            url: "Penempatan/get_penempatan",
            dataType: "JSON",
            data : {id:id},
            success: function(data) {
                var html = "";
                for (i = 0; i < data['dtw'].length; i++) {
                    html += '<tr>' +
                        '<td><input type="checkbox" class="form-control pn" id="'+i+'" name="id_pn[]" value="'+data['dtw'][i].id_dtw+'"></td>' +
                        '<td>DTW</td>' +
                        '<td>' + data['dtw'][i].nama_dtw + '</td>' +
                        '<td>' + data['dtw'][i].alamat + '</td>' +
                        '</tr>';
                }

                for (i = 0; i < data['hotel'].length; i++) {
                    html += '<tr>' +
                        '<td><input type="checkbox" class="form-control pn" id="'+i+'" name="id_pn[]" value="'+data['hotel'][i].id_hotel+'"></td>' +
                        '<td>HOTEL</td>' +
                        '<td>' + data['hotel'][i].nama_hotel + '</td>' +
                        '<td>' + data['hotel'][i].alamat + '</td>' +
                        '</tr>';
                }
                
                $('#data-penempatan-add').html(html);
                var tables = $("#tbl_penempatan_add").DataTable();
            }
        });
        $.ajax({
            type: "GET",
            url: "Penempatan/json_penempatan",
            dataType: "JSON",
            data : {id:id},
            success: function(data) {
                var html = "";
                for (i = 0; i < data['dtw'].length; i++) {
                    if (data['dtw'][i].status == 1) {
                          var sts = '<span class="badge badge-success">active</span>';
                      }
                    html += '<tr>' +
                        // '<td>'+(i+1)+'</td>'+
                        '<td>'+data['dtw'][i].nama_petugas +'</td>' +
                        '<td>'+data['dtw'][i].nama_kota +'</td>' +
                        '<td>DTW</td>'+
                        '<td>' + data['dtw'][i].nama_dtw + '</td>' +
                        '<td>' + sts + '</td>' +
                        // '<td class="text-center">'+
                        //             '<button  class="btn btn-info btn-sm btn-link edit"  rel="tooltip" data-original-title="Edit Data" data="'+data['dtw'][i].id_dtw+'" ><i class="fa fa-edit"></i></button>'+' '+
                        //             '<button  class="btn btn-danger btn-sm btn-link hapus" rel="tooltip" data-original-title="Hapus Data" data="'+data['dtw'][i].id_dtw+'" ><i class="fa fa-trash"></i></button>'+
                        //         '</td>'+
                        '</tr>';
                }
                for (i = 0; i < data['hotel'].length; i++) {
                    if (data['hotel'][i].status == 1) {
                          var sts = '<span class="badge badge-success">active</span>';
                      }
                    html += '<tr>' +
                        // '<td>'+(i+1)+'</td>'+
                        '<td>'+data['hotel'][i].nama_petugas +'</td>' +
                        '<td>'+data['hotel'][i].nama_kota +'</td>' +
                        '<td>HOTEL</td>'+
                        '<td>' + data['hotel'][i].nama_hotel + '</td>' +
                        '<td>' + sts + '</td>' +
                        // '<td class="text-center">'+
                        //             '<button  class="btn btn-info btn-sm btn-link edit"  rel="tooltip" data-original-title="Edit Data" data="'+data['hotel'][i].id_hotel+'" ><i class="fa fa-edit"></i></button>'+' '+
                        //             '<button  class="btn btn-danger btn-sm btn-link hapus" rel="tooltip" data-original-title="Hapus Data" data="'+data['hotel'][i].id_hotel+'" ><i class="fa fa-trash"></i></button>'+
                        //         '</td>'+
                        '</tr>';
                }
                
                $('#data-penempatan').html(html);
                var tables = $("#tbl_penempatan").DataTable();
            }
        });
    }
    $('.sel2').select2({
        placeholder: "Pilih Kota / Kabupaten",
        allowClear:true
    });

    $('.sel2pn').select2({
        placeholder: "Pilih Tempat Penempatan",
        allowClear:true
    });

    $('.sel2p').select2({
        placeholder: "Pilih Petugas",
        allowClear:true
    });

    $("#btn-add").on('click', function () {
        $('[href="#link2"]').tab('show');
    })

    $('#btn-back').on('click', function () {
        $('[href="#link1"]').tab('show');
    })

    $('#fil_penempatan').on('change', function () {
        i=$(this).find(':selected').val()
        $("#tbl_penempatan_add").DataTable().columns(1).search(i).draw();
      });

      $('#kota').on('change', function () {
        i=$(this).find(':selected').val()
        $("#tbl_penempatan").DataTable().columns(1).search(i).draw();
      });

      $('#penempatan-add').on('change', function () {
        i=$(this).find(':selected').val()
        $("#tbl_penempatan").DataTable().columns(2).search(i).draw();
      });
    
      $('#petugas').on('change', function () {
        i=$(this).find(':selected').val()
        $("#tbl_penempatan").DataTable().columns(0).search(i).draw();
      });

    $('#submit').on('click',function(){
        var penempatan = $('#fil_penempatan').val();
        var users = $("form,input[type='checkbox']").serialize();
        console.log(penempatan);
        if(penempatan == 'DTW'){
            $.ajax({
                type: "POST",
                url: "Penempatan/simpan_dtw",
                data: users,
                dataType: "json",
                success: function (data) {
                    Swal.fire('Data Berhasil Disimpan!','','success');
                    data_penempatan();
                }
            });
        }
        else{
            $.ajax({
                type: "POST",
                url: "Penempatan/simpan_hotel",
                data: users,
                dataType: "json",
                success: function (data) {
                    Swal.fire('Data Berhasil Disimpan!','','success');
                    data_penempatan();
                }
            });
        }
       
    })

})
</script> -->