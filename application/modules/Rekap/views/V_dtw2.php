<style>

  #tbl_wisnus th {
		font-weight: bold;
	}
	#tbl_wisman th {
		font-weight: bold;
	}

  .float-b{
        position    :fixed;
        width       :115%;
        height      :60px;
        bottom      :-20px;
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
              <h3 class="float-left" style="margin-top: -1px;">Tabel Rekap DTW</h3>
            </div>
          </div>
        </div>
        
        <div class="card-body">
          <div class="tab-content tab-space">
            <div class="tab-pane active" id="menu1">
              <div class="container-fluid mt-3">
                <table id="tbl_dtw" class="table table-no-bordered table-hover table-striped" cellspacing="0"
                  width="100%" style="width: 100%;" role="grid">
                  <thead class="text-primary">
                    <th class="text-center" width="30px;">No</th>
                    <th class="text-center" width="150px;">Nama DTW</th>
                    <th class="text-center" width="200px;">Alamat</th>
                    <th class="text-center" width="150px">Jumlah Pengunjung</th>
                    <th class="text-center" width="100px">Aksi</th>
                  </thead>
                  <tbody id="data-dtw">
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
          <h3 class="float-left" style="margin-top: -1px;">Tabel Kelola DTW</h3>
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
        <div class="card-body">
          <!-- <h4><i class="fa fa-add"></i> Tambah Data Wisnus</h4> -->
          <div class="row">
            <div class="col-md-6 col-lg-6">
            <input type="hidden" name="id_dtw" id="id_dtw">
              <div class="input-group ">
              <h5 id="label_dtw" class="font-weight-bold mt-2"></h5>
              </div>
            </div>
            <div class="col-md-6 col-lg-6">
              <div class="input-group "> 
                <input type="text" class="form-control datepicker11" id="periode" data="1" name="periode" style="margin-top: -6px;" placeholder="Pilih Bulan" autocomplete="off">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <a id="btn-back" class="btn btn-warning btn-fab btn-round ml-5" style="margin-top:-20px;z-index:9" rel="tooltip" data-original-title="Kembali" data-toggle="tab"><i class="material-icons text-white">chevron_left</i></a>
    <div class="card-body">
      <div class="tab-content tab-space">
        <div class="tab-pane active" id="link1">
          <div class="container-fluid mt-3">
            <table id="tbl_wisnus" class="table table-no-bordered table-hover table-striped" cellspacing="0"
              width="100%" style="width: 100%;" role="grid">
              <thead class="thead-light">
                <th class="text-center" width="30px;">No</th>
                <th class="text-center" width="250px;">Provinsi</th>
                <th class="text-center" width="200px;">Pria</th>
                <th class="text-center" width="200px;">Wanita</th>
                <th class="text-center" width="100px">Jumlah</th>
              </thead>
              <tbody id="data-wisnus">
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane" id="link2">
          <div class="container-fluid mt-3">
          <table id="tbl_wisman" class="table table-no-bordered table-hover table-striped" cellspacing="0"
              width="100%" style="width: 100%;" role="grid">
              <thead class="thead-light">
                <th class="text-center" width="30px;">No</th>
                <th class="text-center" width="250px;">Negara / Kebangsaan</th>
                <th class="text-center" width="200px;">Pria</th>
                <th class="text-center" width="200px;">Wanita</th>
                <th class="text-center" width="100px">Jumlah</th>
              </thead>
              <tbody id="data-wisman">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    </form>
  </div>
</div>

<div class="card float-b float-wisman" hidden>
    <div class="card-body table-responsive">
        <table border="0" style="margin-top: 0px; margin-left: 30%;" width="40%">
            <th width="15%">Total Pria : <span id="lt2">0</span></th>
            <th  width="10%">Total Wanita : <span id="pt2">0</span></th>
            <th width="10%">Total Jumlah : <span id="jt2">0</span></th>
        </table>
    </div>
</div>

<div class="card float-b float-wisnus" hidden>
    <div class="card-body table-responsive">
        <table border="0" style="margin-top: 0px; margin-left: 30%;" width="40%">
            <th width="15%">Total Pria : <span id="lt">0</span></th>
            <th  width="10%">Total Wanita : <span id="pt">0</span></th>
            <th width="10%">Total Jumlah : <span id="jt">0</span></th>
        </table>
    </div>
</div>

<script src="<?php echo base_url('assets/js/') ?>ajax/rekap/dtw.js"></script>

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