<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-rose">
                <h3 class="card-title mb-3" id="judul">List DTW</h3>

                <ul class="nav nav-tabs float-right" data-tabs="tabs" style="margin-top: -40px;">
                    <li class="nav-item">
                        <a href="#link1" data-toggle="tab"><button class="btn btn-info btn-sm mr-3 l-btn" id="btn-list-dtw" hidden><i class="fa fa-angle-double-left mr-2"></i>DTW</button></a>
                    </li>
                    <li class="nav-item">
                        <a href="#link2" data-toggle="tab"><button class="btn btn-info btn-sm l-btn" id="btn-list-hotel"><i class="fa fa-angle-double-right mr-2"></i>Hotel</button></a>
                    </li>
                </ul>
            </div>
            <a href="<?= base_url('master/dtw_hotel_kota') ?>" class="btn btn-warning btn-fab btn-round ml-5" style="margin-top:-20px;z-index:9" rel="tooltip" data-original-title="Kembali"><i class="material-icons text-white">chevron_left</i></a>
            <div class="card-body table-responsive">

                <div class="tab-content tab-space mt-3">
                    <div class="tab-pane active" id="link1">

                        <form id="form-dtw" class="mb-5 p-20" autocomplete="off">

                            <input type="hidden" name="jenis" id="jenis" value="dtw">
                            <input type="hidden" name="id_kota" id="id_kota" value="<?= $id_kota ?>">
                            <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>">
                            <input type="hidden" name="id" id="id_dtw">
                            <input type="hidden" name="aksi" id="aksi" value="Tambah">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <label class="col-sm-3 text-dark mt-2">Nama DTW</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="nama" id="nama_dtw" placeholder="Masukkan Nama DTW">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <label class="col-sm-3 text-dark mt-2">Latitude</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" name="lat" id="lat" placeholder="Masukkan Latitude">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <label class="col-sm-3 text-dark mt-2">Longitude</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" name="long" id="long" placeholder="Masukkan Longitude">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="row">
                                        <label class="col-sm-3 text-dark mt-2">Alamat</label>
                                        <div class="col-sm-9">
                                            <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukkan Alamat"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <label class="col-sm-3 text-dark mt-2">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <label class="col-sm-3 text-dark mt-2">No Hp</label>
                                        <div class="col-sm-9">
                                            <input type="number" name="no_hp" id="no_hp" class="form-control" placeholder="Masukkan No HP">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="row">
                                        <label class="col-sm-3 text-dark mt-2">Status</label>
                                        <div class="col-sm-9">
                                            <select class="form-control sel2" name="status" id="status">
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button class="btn btn-sm btn-dark mt-3 mr-3" id="batal_dtw" type="button" hidden>Batal</button>
                                <button class="btn btn-sm btn-primary mt-3" id="simpan_dtw" data-id="dtw" type="button">Simpan</button>
                            </div>
                        </form>

                        <table id="tabel_list_dtw" class="table table-light table-striped table-hover table-bordered" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Nama DTW</th>
                                    <th>Alamat</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Email</th>
                                    <th>No Hp</th>
                                    <th>Status</th>
                                    <th width='15%'>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="link2">

                        <form id="form-hotel" class="mb-5 p-20" autocomplete="off">

                            <input type="hidden" name="jenis" id="jenis" value="hotel">
                            <input type="hidden" name="id_kota" id="id_kota" value="<?= $id_kota ?>">
                            <input type="hidden" name="id" id="id_hotel">
                            <input type="hidden" name="aksi" id="aksi_hotel" value="Tambah">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <label class="col-sm-3 text-dark mt-2">Nama Hotel</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="nama" id="nama_hotel" placeholder="Masukkan Nama Hotel">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <label class="col-sm-3 text-dark mt-2">Latitude</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" name="lat" id="lat_hotel" placeholder="Masukkan Latitude">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <label class="col-sm-3 text-dark mt-2">Longitude</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" name="long" id="long_hotel" placeholder="Masukkan Longitude">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="row">
                                        <label class="col-sm-3 text-dark mt-2">Alamat</label>
                                        <div class="col-sm-9">
                                            <textarea id="alamat_hotel" name="alamat" class="form-control" placeholder="Masukkan Alamat"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <label class="col-sm-3 text-dark mt-2">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" name="email" id="email_hotel" class="form-control" placeholder="Masukkan Email">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <label class="col-sm-3 text-dark mt-2">No Hp</label>
                                        <div class="col-sm-9">
                                            <input type="number" name="no_hp" id="no_hp_hotel" class="form-control" placeholder="Masukkan No HP">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="row">
                                        <label class="col-sm-3 text-dark mt-2">Status</label>
                                        <div class="col-sm-9">
                                            <select class="form-control sel2" id="status_hote" name="status">
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button class="btn btn-sm btn-dark mt-3 mr-3" id="batal_hotel" type="button" hidden>Batal</button>
                                <button class="btn btn-sm btn-primary mt-3" id="simpan_hotel" data-id="hotel" type="button">Simpan</button>
                            </div>
                        </form>

                        <table id="tabel_list_hotel" class="table table-light table-striped table-hover table-bordered" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Hotel</th>
                                    <th>Alamat</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Email</th>
                                    <th>No Hp</th>
                                    <th>Status</th>
                                    <th width='15%'>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
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

<script src="<?php echo base_url('assets/js/') ?>ajax/master/master_dtw_hotel.js"></script>