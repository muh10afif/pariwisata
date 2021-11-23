<style>
    .field-icon {
        float: right;
        margin-left: -30px;
        margin-top: -25px;
        position: relative;
        z-index: 2;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-rose">
                <h3 class="card-title mb-3" id="judul">List DTW, <?= ucwords($nama_kota) ?></h3>
            </div>

            <?php if ($id_sess_kota == 0) : ?>
                <a href="<?= base_url('Users/Dtw') ?>" class="btn btn-warning btn-fab btn-round ml-5" style="margin-top:-20px;z-index:9" rel="tooltip" data-original-title="Kembali"><i class="material-icons text-white">chevron_left</i></a>
            <?php endif; ?>

            <div class="card-body table-responsive">

            <form id="form-dtw" class="p-20" autocomplete="off" <?= (count($dtw) == 0) ? 'hidden' : '' ?>>

                <input type="hidden" name="id_kota" id="id_kota" value="<?= $id_kota ?>">
                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>">
                <input type="hidden" name="id_user" id="id_user">
                <input type="hidden" name="aksi" id="aksi" value="Tambah">
                
                <div class="row mt-3" style="margin: 10px;">
                    <div class="col-md-4">
                        <div class="row">
                            <label class="col-sm-3 text-dark mt-2">DTW</label>
                            <div class="col-sm-9">
                                <select class="form-control sel2" name="dtw" id="dtw">
                                        <option value=" ">-- Pilih DTW --</option>
                                    <?php foreach ($dtw as $k): ?>
                                        <option value="<?= $k['id_dtw'] ?>"><?= $k['nama_dtw'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <label class="col-sm-3 text-dark mt-2">Username</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan Username">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <label class="col-sm-3 text-dark mt-2">Password</label>
                            <div class="col-sm-9">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Masukkan Password">
                                <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                <mark class="mark_pass">Harap Catat Pasword Anda!!</mark>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3" style="margin: 10px;">

                    <button class="btn btn-sm btn-dark mt-3 mr-3" id="batal_dtw" type="button" hidden>Batal</button>
                    <button class="btn btn-sm btn-primary mt-3" id="simpan_dtw" type="button">Simpan</button>
                </div>

            </form>

            </div>
        </div>
        <div class="card table-responsive">
            <div class="card-body">
                <table id="tabel_list_dtw" class="table table-light table-striped table-hover table-bordered" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama DTW</th>
                            <th>Username</th>
                            <th>Alamat</th>
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

<script src="<?php echo base_url('assets/js/') ?>ajax/kelolaan/users.js"></script>