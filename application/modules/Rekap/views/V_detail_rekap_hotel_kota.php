<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-rose">
                <h3 class="card-title mb-3">Detail rekap Hotel, <?= ucwords($nama_kota) ?></h3>
            </div>

            <?php if ($id_sess_kota == 0) : ?>
                <a href="<?= base_url('Rekap/Hotel') ?>" class="btn btn-warning btn-fab btn-round ml-5" style="margin-top:-20px;z-index:9" rel="tooltip" data-original-title="Kembali"><i class="material-icons text-white">chevron_left</i></a>
            <?php endif; ?>

            <div class="card-body table-responsive">

            <div class="d-flex justify-content-end mb-3">
                <?php if ($bln_awal != '' && $bln_akhir != '') : ?>
                    <h4><mark>Data terhitung dari bulan <?= $bln_awal ?> s/d <?= $bln_akhir ?></mark></h4>
                <?php else : ?>
                    <h4><mark>Data Keseluruhan</mark></h4>
                <?php endif; ?>
            </div>

            <form action="<?= base_url('Rekap/Hotel/tampil_lihat_detail') ?>" method="POST" target="_blank" id="form-rekap-hotel" class="mb-5 p-20" autocomplete="off" <?= ($bln_awal != '' && $bln_akhir != '') ? '' : 'hidden' ?>>

                <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>">
                <input type="hidden" name="id_kota" id="id_kota" value="<?= $id_kota ?>">
                <input type="hidden" name="bln_awal" id='bln_awal' value="<?= $bln_awal ?>">
                <input type="hidden" name="bln_akhir" id='bln_akhir' value="<?= $bln_akhir ?>">

                <div class="row mt-2" style="margin: 5px;">
                    <div class="col-md-4 offset-md-3 mt-1">
                        <div class="row">
                            <label class="col-sm-4 text-dark mt-2">Jenis Wisatawan</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="jenis_wisatawan" id="jenis_wisatawan" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="rekap_wisnus_hotel">Nusantara</option>
                                        <option value="rekap_wisman_hotel">Mancanegara</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-1">
                        <button class="btn btn-sm btn-success mr-3" id="lihat_detail_hotel" type="submit">Lihat Detail</button>
                        <button class="btn btn-sm btn-dark" id="reset_rekap_hotel" type="reset">Reset</button>
                    </div>
                </div>
               
            </form>

            
            </div>
        </div>
        <div class="card table-responsive">
            <div class="card-body">
                <table id="tabel_rekap_hotel" class="table table-light table-striped table-hover table-bordered" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama Akomodasi</th>
                            <th>Wisatawan Nusantara</th>
                            <th>Wisatawan Mancanegara</th>
                            <th>Jumlah Keseluruhan</th>
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

<script src="<?php echo base_url('assets/js/') ?>ajax/rekap/hotel.js"></script>