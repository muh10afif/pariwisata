<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-rose">
                <h3 class="card-title">Master Kab / Kota</h3>
            </div>

            <div class="card-body table-responsive">

            <form id="form-kota" class="p-20" autocomplete="off">

                <input type="hidden" name="id_kota" id="id_kota">
                <input type="hidden" name="aksi" id="aksi" value="Tambah">
                <div class="row mt-4" style="margin: 10px;">
                    <div class="col-md-4 offset-md-2">
                        <div class="row">
                            <label class="col-sm-3 text-dark mt-2">Kab / Kota</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="kota" name="kota" placeholder="Masukkan Nama Kab / Kota" autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <label class="col-sm-3 text-dark mt-2">Provinsi</label>
                            <div class="col-sm-9">
                                <label class="font-weight-bold mt-2 text-dark">Jawa Timur</label>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="d-flex justify-content-end mt-3" style="margin: 10px;">

                    <button class="btn btn-sm btn-dark mt-3 mr-3" id="batal_kota" type="button" hidden>Batal</button>
                    <button class="btn btn-sm btn-primary mt-3" id="simpan_kota" type="button">Simpan</button>
                </div>
            </form>

            </div>
        </div>

        <div class="card table-responsive">
            <div class="card-body">

                <table id="tabel_master_kota" class="table table-light table-striped table-hover table-bordered" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama Kab / Kota</th>
                            <th>Provinsi</th>
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

<script src="<?php echo base_url('assets/js/') ?>ajax/master/master_kota.js"></script>