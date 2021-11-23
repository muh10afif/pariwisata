<style>
  thead th {
    text-align: center;
  }
</style>
<div class="card">
    <div class="card-header card-header-tabs card-header-rose">
      <div class="nav-tabs-navigation">
        <div class="nav-tabs-wrapper">
          <h3 class="float-left" style="margin-top: -1px;">Tabel Master Users</h3>
          <ul class="nav nav-tabs float-right" data-tabs="tabs">
            <li class="nav-item">
              <a class="nav-link active show" href="#link1" data-toggle="tab">
                <i class="material-icons">panorama</i> Users DTW
                <div class="ripple-container"></div>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#link2" data-toggle="tab">
                <i class="material-icons">location_city</i> Users Hotel
                <div class="ripple-container"></div>
                <div class="ripple-container"></div>
              </a>
            </li>

            <?php if ($this->session->userdata('level') == 'admin') : ?>
            <li class="nav-item">
              <a class="nav-link" href="#link3" data-toggle="tab">
                <i class="material-icons">accessibility</i> Users Kota
                <div class="ripple-container"></div>
                <div class="ripple-container"></div>
              </a>
            </li>
            <?php endif; ?>

          </ul>
        </div>
      </div>
    </div>
    <button id="btn-modal" class="btn btn-warning btn-fab btn-round float-right ml-5" style="margin-top:-20px;z-index:9"
      rel="tooltip" data-original-title="Tambah Data" data-toggle="modal" data-target="#modal-add"><i
        class="material-icons">add</i></button>
    <button id="btn-modal-hotel" class="btn btn-warning btn-fab btn-round float-right ml-5"
      style="margin-top:-20px;z-index:9" rel="tooltip" data-original-title="Tambah Data" data-toggle="modal"
      data-target="#modal-add"><i class="material-icons">add</i></button>
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

      <div class="tab-content tab-space">
        <div class="tab-pane active" id="link1">
          <div class="container-fluid mt-3">
            <table id="pengguna_dtw" class="table table-striped table-no-bordered table-hover" cellspacing="0"
              width="100%" style="width: 100%;" role="grid">
              <thead class="text-primary">
                <th width="50px;">No</th>
                <th width="250px;">Nama DTW</th>
                <th width="200px;">Username</th>
                <th width="200px;">Alamat</th>
                <th width="100px">Status</th>
                <th width="100px;">Aksi</th>
              </thead>
              <tbody id="data-p-dwt">
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane" id="link2">
          <div class="container-fluid mt-3">
            <table id="pengguna_hotel" class="table table-striped table-no-bordered table-hover" cellspacing="0"
              width="100%" style="width: 100%;" role="grid">
              <thead class="text-primary">
                <th width="50px">No</th>
                <th width="250px">Nama Hotel</th>
                <th width="200px">Username</th>
                <th width="200px">Alamat</th>
                <th width="100px">Status</th>
                <th width="100px">Aksi</th>
              </thead>
              <tbody id="data-p-hotel">
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane" id="link3">
          <div class="container-fluid mt-3">
            <table id="pengguna_kota" class="table table-striped table-no-bordered table-hover" cellspacing="0"
              width="100%" style="width: 100%;" role="grid">
              <thead class="text-primary">
                <th width="50px">No</th>
                <th width="250px">Nama Kota</th>
                <th width="200px">Username</th>
                <th width="100px">Aksi</th>
              </thead>
              <tbody id="data-p-kota">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="modal-add" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable|modal-dialog-centered modal-sm|modal-lg|modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="t_title"><i class="fa fa-plus"></i> Tambah Data</h5>
          <h5 class="modal-title" id="u_title"><i class="fa fa-plus"></i> Update Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <input type="hidden" id="id">
            <div class="form-group">
              <select class="form-control sel2" id="dtw">
                <option value="" disabled selected="selected">-- Pilih DTW --</option>
                <?php foreach ($dtw as $d) : ?>
                <option value="<?php echo $d->id_dtw ?>"><?php echo $d->nama_dtw ?></option>
                <?php endforeach ?>

              </select>
              <select class="form-control sel2" id="hotel">
                <option value="" disabled selected="selected">-- Pilih Hotel --</option>
                <?php foreach ($hotel as $h) : ?>
                <option value="<?php echo $h->id_hotel ?>"><?php echo $h->nama_hotel ?></option>
                <?php endforeach ?>
              </select>
              <select class="form-control" id="kota" hidden>
                <option value="" disabled selected="selected">-- Pilih Kota --</option>
                <?php foreach ($kota as $h) : ?>
                <option value="<?php echo $h->id_kota ?>"><?php echo $h->nama_kota ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="username" placeholder="Username">
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="password" placeholder="Password">
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
          <button type="button" class="btn btn-rose" id="s_dtw">Simpan</button>
          <button type="button" class="btn btn-rose" id="s_hotel">Simpan</button>
          <button type="button" class="btn btn-rose" id="u_dtw">Update</button>
          <button type="button" class="btn btn-rose" id="u_hotel">Update</button>
          <button type="button" class="btn btn-rose" id="u_kota">Update</button>
        </div>
      </div>
    </div>
  </div>

  <script src="<?php echo base_url('assets/js/') ?>ajax/master/master_users.js"></script>

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

  <!-- <?php if ($userdata->id_dtw == "0" AND $userdata->id_hotel == "0" AND $userdata->id_pegawai == "0" AND $userdata->id_kota != "0")
              {?>
  <script>             
  $(document).ready(function () {
    var loading = $.loading();

    function startAjax() {
        $.get('http://www.google.com', function () {});
    }

    function openLoading() {
        loading.open();
    }

    function closeLoading() {
        loading.close();
    }
    /*================================
    =            Pengguna            =
    ================================*/
    tampil_pengguna_dtw()
    $('#pengguna_dtw').DataTable({
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });

    function tampil_pengguna_dtw() {
        var id = <?= $userdata->id_kota; ?> 
        $('#btn-modal-hotel').hide();
        $.ajax({
            type: 'GET',
            url: 'Users/json_p_dtw',
            async: false,
            data:{id:id},
            dataType: 'json',
            success: function (data) {
                $('#hotel').hide();
                $('#dtw').hide();
                $('#s_hotel').hide();
                $('#u_dtw').hide();
                $('#u_hotel').hide();
                $('#s_dtw').show();
                $('#u_title').hide();
                $('#t_title').show();

                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {
                    if (data[i].status == 1) {
                        var sts = '<span class="badge badge-success">active</span>'
                    }
                    html += '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + data[i].nama_dtw + '</td>' +
                        '<td>' + data[i].username + '</td>' +
                        '<td>' + data[i].alamat + '</td>' +
                        '<td>' + sts + '</td>' +
                        '<td class="text-center">' +
                        '<button  class="btn btn-info btn-sm btn-link edit"  rel="tooltip" data-original-title="Edit Data" data="' + data[i].id_user + '" ><i class="fa fa-edit"></i></button>' + ' ' +
                        '<button  class="btn btn-danger btn-sm btn-link hapus" rel="tooltip" data-original-title="Hapus Data" data="' + data[i].id_user + '" ><i class="fa fa-trash"></i></button>' +
                        ''
                    '</td>' +
                    '</tr>';
                }
                $('#data-p-dwt').html(html);
            }

        });
    }

    $('.btn').tooltip({
        container: 'body'
    });

    //GET edit
    $('#data-p-dwt').on('click', '.edit', function () {
        var id = $(this).attr('data');
        $.ajax({
            type: "POST",
            url: "Users/edit_users",
            dataType: "JSON",
            data: {id:id},
            success: function (data) {
                $('#u_title').show();
                $('#t_title').hide();
                $('#u_dtw').show();
                $('#s_dtw').hide();
                $('#u_hotel').hide();
                $('#s_hotel').hide();
                $('#u_kota').hide();
                $('#dtw').show();
                $('#hotel').hide();
                $('#modal-add').modal('show');
                $('#dtw').val(data.id_dtw);
                $('#id').val(id);
                $('#username').val(data.username);
                $('#password').val(data.password);
                $('#status').val(data.status);
                $('#id_group').val(data.group);
            }
        });
        return false;
    });

    //GET HAPUS
    $('#data-p-dwt').on('click', '.hapus', function () {
        var id = $(this).attr('data');
        Swal.fire({
            title: 'Yakin ingin menghapus data ini?',
            text: "data yang sudah dihapus tidak dapat kembali!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'YA!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'POST',
                    url: 'Users/hapus_users',
                    async: false,
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (data) {
                        tampil_pengguna_dtw()
                        Swal.fire('Data Berhasil Dihapus!', '', 'success');
                    }
                });
            }
        })
    });

    //button-simpan
    $('#s_dtw').on('click', function () {
        var username = $('#username').val();
        var password = $('#password').val();
        var dtw = $('#dtw').val();
        var status = $('#status').val();
        $.ajax({
            type: "POST",
            url: "Users/simpan_users",
            dataType: "JSON",
            data: {
                    dtw: dtw,
                    username: username,
                    password: password,
                    status: status
                  },
            success: function (data) {
                if(data == true) {
                    $('#dtw').val("");
                    $('#username').val("");
                    $('#password').val("");
                    $('#status').val("");
                    $('#hotel').val("");
                    $('#modal-add').modal('hide');
                    tampil_pengguna_dtw();
                    Swal.fire('Data Berhasil Disimpan!', '', 'success');
                }
                else{
                    Swal.fire('Data Gagal Disimpan!','','warning');
                }
            }
        });
        return false;
    });

    //Update
    $('#u_dtw').on('click', function () {
        var id = $('#id').val();
        var username = $('#username').val();
        var password = $('#password').val();
        var status = $('#status').val();
        var dtw = $('#dtw').val();
        $.ajax({
            type: "POST",
            url: "Users/update_users",
            dataType: "JSON",
            data: {
                id: id,
                dtw: dtw,
                username: username,
                password: password,
                status: status
            },
            success: function (data) {
                $('#id').val("");
                $('#username').val("");
                $('#password').val("");
                $('#status').val("");
                $('#dtw').val("");
                $('#hotel').val("");
                $('#modal-add').modal('hide');
                tampil_pengguna_dtw();
                Swal.fire('Data Berhasil Diupdate!', '', 'success');
            }
        });
        return false;
    });

    $('[href="#link2"]').on('click', function () {
        $('#btn-modal-hotel').show();
        $('#btn-modal').hide();

    })

    $('[href="#link1"]').on('click', function () {
        $('#btn-modal').show();
        $('#btn-modal-hotel').hide();

    })

    $('#btn-modal').on('click', function () {
        $('#s_dtw').show();
        $('#u_dtw').hide();
        $('#u_hotel').hide();
        $('#s_hotel').hide();
        $('#u_kota').hide();
        $('#dtw').show();
        $('#hotel').hide();
        $('#id').val("");
        $('#username').val("");
        $('#password').val("");
        $('#status').val("");
        $('#dtw').val("");

    })

    $('#btn-modal-hotel').on('click', function () {
        $('#s_dtw').hide();
        $('#u_dtw').hide();
        $('#u_hotel').hide();
        $('#s_hotel').show();
        $('#u_kota').hide();
        $('#dtw').hide();
        $('#hotel').show();
        $('#id').val("");
        $('#username').val("");
        $('#password').val("");
        $('#status').val("");
        $('#dtw').val("");

    })





    //Hotel
    tampil_pengguna_hotel();
    $('#pengguna_hotel').DataTable({
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });

    function tampil_pengguna_hotel() {
        var id = '<?php echo $userdata->id_kota; ?>';
        $.ajax({
            type: 'GET',
            url: 'Users/json_p_hotel',
            async: false,
            data:{id:id},
            dataType: 'json',
            success: function (data) {
                // $('#dtw').hide();
                // $('#s_hotel').hide();
                // $('#u_dtw').hide();
                // $('#u_hotel').hide();
                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {
                    if (data[i].status == 1) {
                        var sts = '<span class="badge badge-success">active</span>';
                    }
                    html += '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + data[i].nama_hotel + '</td>' +
                        '<td>' + data[i].username + '</td>' +
                        '<td>' + data[i].alamat + '</td>' +
                        '<td>' + sts + '</td>' +
                        '<td class="text-center">' +
                        '<button  class="btn btn-info btn-sm btn-link edit" rel="tooltip" data-original-title="Edit Data" data="' + data[i].id_user + '"><i class="fa fa-edit"></i></button>' + ' ' +
                        '<button " class="btn btn-danger btn-sm btn-link hapus" rel="tooltip" data-original-title="Hapus Data" data="' + data[i].id_user + '"><i class="fa fa-trash"></i></button>' +
                        '</td>' +
                        '</tr>';
                }
                $('#data-p-hotel').html(html);
            }

        });
    }

    $('.btn').tooltip({
        container: 'body'
    });

    //button-simpan
    $('#s_hotel').on('click', function () {
        var username = $('#username').val();
        var password = $('#password').val();
        var hotel = $('#hotel').val();
        var status = $('#status').val();
        $.ajax({
            type: "POST",
            url: "Users/simpan_users_hotel",
            dataType: "JSON",
            data: {
                hotel: hotel,
                username: username,
                password: password,
                status: status
            },
            success: function (data) {
                if(data == true) {
                    $('#dtw').val("");
                    $('#hotel').val("");
                    $('#username').val("");
                    $('#password').val("");
                    $('#status').val("");
                    $('#modal-add').modal('hide');
                    tampil_pengguna_hotel();
                    Swal.fire('Data Berhasil Disimpan!', '', 'success');
                }
                else{
                    Swal.fire('Data Gagal Disimpan!','','warning');
                }
            }
        });
        return false;
    });


    //GET UPDATE
    $('#data-p-hotel').on('click', '.edit', function () {
        var id = $(this).attr('data');
        $.ajax({
            type: "POST",
            url: "Users/edit_users_hotel",
            dataType: "JSON",
            data: {
                id: id
            },
            success: function (data) {
                $.each(data, function (id, username, jabatan) {
                    $('#u_dtw').hide();
                    $('#s_dtw').hide();
                    $('#u_hotel').show();
                    $('#u_kota').hide();
                    $('#s_hotel').hide();
                    $('#dtw').hide();
                    $('#hotel').show();
                    $('#modal-add').modal('show');
                    $('#id').val(data.id_user);
                    $('#hotel').val(data.id_hotel);
                    $('#username').val(data.username);
                    $('#password').val(data.password);
                    $('#status').val(data.status);
                    $('#id_group').val(data.group);
                });
            }
        });
        return false;
    });


    //GET HAPUS
    $('#data-p-hotel').on('click', '.hapus', function () {
        var id = $(this).attr('data');
        Swal.fire({
            title: 'Yakin ingin menghapus data ini?',
            text: "data yang sudah dihapus tidak dapat kembali!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'YA!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'POST',
                    url: 'Users/hapus_users_hotel',
                    async: false,
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (data) {
                        tampil_pengguna_hotel()
                        Swal.fire('Data Berhasil Dihapus!', '', 'success');
                    }
                });
            }
        })
    });

    $('#u_hotel').on('click', function () {
        var id = $('#id').val();
        var username = $('#username').val();
        var password = $('#password').val();
        var status = $('#status').val();
        var hotel = $('#hotel').val();
        $.ajax({
            type: "POST",
            url: "Users/update_users_hotel",
            dataType: "JSON",
            data: {
                id: id,
                hotel: hotel,
                username: username,
                password: password,
                status: status
            },
            success: function (data) {
                $('#id').val("");
                $('#username').val("");
                $('#password').val("");
                $('#status').val("");
                $('#dtw').val("");
                $('#hotel').val("");
                $('#modal-add').modal('hide');
                tampil_pengguna_hotel();
                Swal.fire('Data Berhasil Diupdate!', '', 'success');
            }
        });
        
        return false;
    });

    /*=====  End of Pengguna  ======*/

    /*==================================
    =            Master DTW            =
    ==================================*/



    /*=====  End of Master DTW  ======*/

  });
</script> -->

  <!-- <?php }elseif ($userdata->id_dtw == 0 AND $userdata->id_hotel == "0" AND $userdata->id_pegawai == "0" AND $userdata->id_kota == "0")
  {?>
  <script src="<?php echo base_url('assets/js/') ?>ajax/master/master_users.js"></script>
  <?php }?> -->