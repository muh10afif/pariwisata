<style>
  thead tr th {
      text-align: center;
      vertical-align: middle;
      font-weight: bold;
  }

  #aksi {
    width: 20% !important;
  }
  #th_provinsi {
    width: 30% !important;
  }
  .float{
      position:fixed;
      width:60px;
      height:60px;
      bottom:6px;
      right:150px;
      text-align:center;
  }

  .float-b{
      position:fixed;
      width:84%;
      height:60px;
      bottom:-20px;
      right:30px;
  }
</style>
<?php echo $this->session->flashdata('pesan'); ?>
<ul class="nav nav-tabs float-right" data-tabs="tabs">
  <li class="nav-item" hidden>
    <a class="nav-link active show" id="m1" href="#menu1" data-toggle="tab">
      <i class="material-icons">arrow_downward</i> WISNUS
      <div class="ripple-container"></div>
    </a>
  </li>
  <li class="nav-item" hidden>
    <a class="nav-link" id="m2" href="#menu2" data-toggle="tab">
      <i class="material-icons">arrow_upward</i> WISMAN
      <div class="ripple-container"></div>
      <div class="ripple-container"></div>
    </a>
  </li>
</ul><div class="tab-content tab-space">
  <div class="tab-pane active" id="menu1">
    <div class="card">
        <div class="card-header card-header-tabs card-header-rose">
          <div class="nav-tabs-navigation">
            <div class="nav-tabs-wrapper">
              <h3 class="float-left" style="margin-top: -1px;">Tabel Kelola Destinasi Tujuan Wisata</h3>
            </div>
          </div>
          <div class="card" style="margin-top:50px;opacity:0.8">
            <div class="card-body">
              <div class="row">
                <div class="col-md-2 col-lg-2">
                  <p class="font-weight-bold">Tanggal Periode</p>
                </div>
                <div class="col-md-4 col-lg-4">
                  <div class="input-group ">
                    <input type="hidden" id="per_awal" value="<?= $per_awal ?>">
                    <input type="hidden" id="id_pegawai" value="<?= $userdata->id_pegawai ?>">
                    <input type="text" class="form-control datepicker11" id="periode_hotel" data="1" name="periode" style="margin-top: -6px;" placeholder="Pilih Bulan" autocomplete="off" value="<?= $per_awal ?>">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="card-body">
          <div class="tab-content tab-space">
            <div class="tab-pane active" id="menu1">
              <div class="container-fluid mt-3">
                <table id="tbl_hotel" class="table table-bordered table-hover table-striped" style="width: 100%;">
                  <thead class="thead-light">
                    <th class="text-center" width="30px;">No</th>
                    <th class="text-center" width="250px;">Nama Hotel</th>
                    <th class="text-center" width="200px;">Alamat</th>
                    <th class="text-center" width="200px;">Email</th>
                    <th class="text-center" width="100px">No HP</th>
                    <th class="text-center" width="100px">Status</th>
                    <th class="text-center" width="100px">Aksi</th>
                  </thead>
                  <tbody id="data-hotel">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
  <div class="tab-pane" id="menu2">
<div class="card">
  <form method="POST" id="fwisnus" action="<?php echo base_url('Kelolaan/Dtw/simpan_wisnus') ?>">
    <div class="card-header card-header-tabs card-header-rose">
      <div class="nav-tabs-navigation">
        <div class="nav-tabs-wrapper">
          <h3 class="float-left" style="margin-top: -1px;">Tabel Kelola Hotel</h3>
          <ul class="nav nav-tabs float-right" data-tabs="tabs">
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
        <div class="card-body" id="tab-wisnus"> 
          <div class="row">
            <div class="col-md-6 col-lg-6">
              <input type="hidden" name="id_hotel" id="id_hotel">
              <div class="input-group ">
              <h5 class="font-weight-bold label_hotel"><h5 class="font-weight-bold">
              </div>
            </div>
            <div class="col-md-6 col-lg-6">
              <div class="input-group row"> 
                <div class="col-md-3 col-lg-3">
                  <input type="hidden" id="id_rekap">
                  <p class="font-weight-bold">Tanggal Periode :</p>
                </div>
                <div class="col-md-8 col-lg-8">
                <input type="text" class="form-control datepicker11" id="periode" data="1" name="periode" style="margin-top: -6px;" placeholder="Pilih Bulan" autocomplete="off" required="true" aria-required="true" aria-invalid="true" disabled>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-3">
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

        <div class="card-body" id="tab-wisman" hidden> 
            <div class="row mb-3">
                <div class="col-md-6 col-lg-6">
                    <div class="input-group ">
                    <h5 class="font-weight-bold label_hotel"><h5 class="font-weight-bold">
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                      <input type="hidden" id="id_rekap_wisman">
                        <span class="col-md-3 font-weight-bold">Tanggal Periode</span>
                        <input type="text" class="form-control datepicker11" id="periode_h_wisman" name="periode" placeholder="Pilih Tanggal Periode" autocomplete="off" disabled>
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
                <button class="btn btn-warning mt-3 mb-3" type="button" id="tambah_hotel_wisman">Tambah</button>
                <button class="btn btn-warning mt-3 mb-3 mr-3" type="button" id="ubah_hotel_wisman" hidden>Ubah Data</button>
                <button class="btn btn-default mt-3 mb-3" type="button" id="cancel_hotel_wisman" hidden>Cancel</button>
            </div>
        </div>
      </div>
    </div>
     <a id="btn-back" class="btn btn-warning btn-fab btn-round ml-5" style="margin-top:-20px;z-index:9" rel="tooltip" data-original-title="Kembali" data-toggle="tab"><i class="material-icons text-white">chevron_left</i></a>
    <div class="card-body">
      <div class="tab-content tab-space">
        <div class="tab-pane active" id="link1">
          <div class="container-fluid mt-3">
            <table id="tabel_list_input_wisnus" class="table table-bordered table-hover table-striped" style="width: 100%;">
               <thead class="thead-light">
                  <tr>
                      <th>No</th>
                      <th id="th_provinsi">Provinsi</th>
                      <th>Pria</th>
                      <th>Wanita</th>
                      <th>Jumlah</th>
                      <th id="aksi">Aksi</th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
            </table>
          </div>

          <div class="card float-b">
              <div class="card-body table-responsive">
                  <table border="0" style="margin-top: 0px; margin-left: 40%;" width="40%">
                      <th width="20%">Total Pria : <span id="tp">0</span></th>
                      <th width="20%">Total Wanita : <span id="tw">0</span></th>
                      <th width="20%">Total Jumlah : <span id="tj">0</span></th>
                  </table>
              </div>
          </div>

          <!-- <div class="float">
              <button class="btn btn-rose my-float" id="simpan_list_wisnus_hotel" type="button" hidden>Simpan</button>
          </div> -->

        </div>
        <div class="tab-pane" id="link2">
          <div class="container-fluid mt-3">
           <table id="tabel_list_input_wisman" class="table table-bordered table-hover table-striped" style="width: 100%;">
                <thead class="thead-light">
                  <tr>
                      <th>No</th>
                      <th>Kawasan</th>
                      <th id="th_provinsi">Negara</th>
                      <th>Pria</th>
                      <th>Wanita</th>
                      <th>Jumlah</th>
                      <th id="aksi">Aksi</th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
            </table>
          </div>

          <div class="card float-b">
              <div class="card-body table-responsive">
                  <table border="0" style="margin-top: 0px; margin-left: 50%;" width="30%">
                      <th>Total Pria : <span id="tp_wisman">0</span></th>
                      <th>Total Wanita : <span id="tw_wisman">0</span></th>
                      <th>Total Jumlah : <span id="tj_wisman">0</span></th>
                  </table>
              </div>
          </div>

          <!-- <div class="float">
              <button class="btn btn-rose my-float" id="simpan_list_wisman_hotel" type="button" hidden>Simpan</button>
          </div> -->

        </div>
      </div>
    </div>
    </form>
  </div>
</div>
</div>

<script src="<?= base_url('assets/js/ajax/kelolaan/hotel.js') ?>"></script>

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