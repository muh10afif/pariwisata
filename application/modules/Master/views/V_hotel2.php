<style>
  #tbl_hotel thead th {
    text-align: center;
  }
</style>

<?php echo $this->session->flashdata('pesan'); ?>
<div class="card">
  <div class="card-header card-header-tabs card-header-rose">
    <div class="nav-tabs-navigation">
      <div class="nav-tabs-wrapper">
        <h3 class="float-left" style="margin-top: -1px;">Tabel Master Hotel</h3>
      </div>
    </div>
    <ul class="nav nav-pills float-right" role="tablist">
      <li class="nav-item">
          <button class="btn btn-link text-white" data-toggle="modal" data-target="#modal-import"><i class="material-icons " style="font-size:30px;">cloud_upload</i> Upload</button>
      </li>
    </ul>
  </div>
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
  <ul class="nav nav-tabs float-right" data-tabs="tabs">
    <li class="nav-item">
      <!--  <a class="nav-link active show" href="#link1" data-toggle="tab">
        <i class="material-icons">panorama</i> Users DTW
        <div class="ripple-container"></div>
      </a> -->
      <a href="#link1" id="btn-link1" class="btn btn-warning btn-fab btn-round ml-5" style="margin-top:-20px;z-index:9" rel="tooltip" data-original-title="Kembali" data-toggle="tab"><i class="material-icons text-white">chevron_left</i></a>
    </li>
    <li class="nav-item">
      <!-- <a class="nav-link" href="#link2" data-toggle="tab">
        <i class="material-icons">location_city</i> Users Hotel
        <div class="ripple-container"></div>
        <div class="ripple-container"></div></a> -->
        <a href="#link2" id="btn-link2" class="btn btn-warning btn-fab btn-round ml-5" style="margin-top:-20px;z-index:9" rel="tooltip" data-original-title="Tambah Data" data-toggle="tab"><i class="material-icons text-white">add</i></a>
      </li>
    </ul>
    <div class="card-body">
      <div class="tab-content tab-space">
        <div class="tab-pane active" id="link1">
          <table id="tbl_hotel" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width: 100%;" role="grid">
            <thead class="text-primary">
              <th width="50px;">No</th>
              <th>Nama Hotel</th>
              <th>Kota</th>
              <th>Alamat</th>
              <th>Lat</th>
              <th>Long</th>
              <th>Email</th>
              <th>No HP</th>
              <th>Status</th>
              <th>Aksi</th>
            </thead>
            <tbody id="data-hotel">
            </tbody>
          </table>
        </div>
        <div class="tab-pane" id="link2">
          <form>
            <input type="hidden" id="id">
            <div class="row">
              <div class="col-md-6 col-lg-6">
                <div class="form-group">
                  <input type="text" class="form-control" id="hotel" placeholder="Nama Hotel">
                </div>
                <div class="form-group">
                  <select class="form-control sel2" id="kota">
                    <option value=""></option>
                    <?php foreach ($kota as $k) : ?>
                    <option value="<?php echo $k->id_kota ?>"><?php echo $k->nama_kota ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group">
                  <textarea class="form-control" id="alamat" placeholder="Alamat" ></textarea>
                </div>
                <div class="form-group">
                  <input type="number" class="form-control" id="lat" placeholder="Latitude">
                </div>
              </div>
              <div class="col-md-6 col-lg-6">
                <div class="form-group">
                  <input type="number" class="form-control" id="long" placeholder="Longitude">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" id="email" placeholder="Email">
                </div>
                <div class="form-group">
                  <input type="number" class="form-control" id="no_hp" placeholder="No HP">
                </div>
                <div class="input-field">
                  <select class="form-control"  id="status">
                    <option value="" disabled selected="selected">Pilih Status</option>
                    <option value="1">Active</option>
                    <option value="2">non Active</option>
                  </select>
                </div>
              </div>
              <button class="btn btn-rose float-right" id="s-hotel">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable|modal-dialog-centered modal-sm|modal-lg|modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-edit"></i> Edit Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="id2">
            <div class="form-group">
            <input type="text" class="form-control" id="hotel2" placeholder="Nama Hotel">
          </div>
          <div class="form-group">
              <select class="form-control sel2" id="kota2">
                <option value=""></option>
              <?php foreach ($kota as $k) : ?>
              <option value="<?php echo $k->id_kota ?>"><?php echo $k->nama_kota ?></option>
              <?php endforeach ?>
          </select>      
          </div>
          <div class="form-group">
            <textarea class="form-control" placeholder="Alamat" id="alamat2" ></textarea>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="lat2" placeholder="Latitude">
          </div>
          <div class="form-group">
          <input type="text" class="form-control" id="long2" placeholder="Longitude">  
          </div>
          <div class="form-group">
          <input type="email" class="form-control" id="email2" placeholder="Email">  
          </div>
          <div class="form-group">
          <input type="no_hp" class="form-control" id="no_hp2" placeholder="No HP">  
          </div>
          <div class="form-group">
              <select class="form-control" id="status2">
                  <option value="" disabled selected="selected">-- Pilih Status --</option>
                  <option value="1">active</option>
              </select>   
          </div>
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-rose" id="b-update">Update</button>
        <!-- <button type="button" class="btn btn-rose" id="s_hotel">Simpan</button>
        <button type="button" class="btn btn-rose" id="u_dtw">Update</button>
        <button type="button" class="btn btn-rose" id="u_hotel">Update</button> -->
      </div>
    </div>
  </div>
</div>

  <!-- Modal -->
<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable|modal-dialog-centered modal-dialog-scrollable|modal-dialog-centered" role="document">
    <form method="POST" action="<?php echo base_url()?>/Master/Hotel/import" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Import</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="dropzone">
              <input type="file" name="file">
            </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-rose">Import</button>
      </div>
    </div>
    </form>
  </div>
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

<script src="<?php echo base_url('assets/js/') ?>ajax/master/master_hotel.js">

              
