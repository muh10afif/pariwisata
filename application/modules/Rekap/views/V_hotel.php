<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-rose">
                <h3 class="card-title">Rekap Hotel</h3>
            </div>

            <div class="card-body table-responsive">

            <form id="form-rekap" class="mb-5 p-20" autocomplete="off">

            <input type="hidden" name="base_url" id="base_url" value="<?= base_url() ?>">

                <div class="row mt-4" style="margin: 10px;">
                    <div class="col-md-6 offset-md-3">
                        <div class="row">
                            <label class="col-sm-3 text-dark mt-2">Periode</label>
                            <div class="col-sm-9">
                                <div class="input-daterange input-group">
                                    <input type="text" class="form-control text-center datepicker12" name="bulan_awal" id="start" placeholder="Awal Periode"/>
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-info b-0 text-white">s / d</span>
                                    </div>
                                    <input type="text" class="form-control text-center datepicker12" name="bulan_akhir" id="end" placeholder="Akhir Periode"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="d-flex justify-content-end mt-3" style="margin: 10px;">
                    <button class="btn btn-sm btn-primary mr-3" id="tampilkan_rekap" type="button" style="margin: 10px">Tampilkan</button>
                    <div class="btn-group grup-lihat" role="group" hidden>
                        <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-success mr-2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Lihat Detail
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item detail-wisnus" href="#" target="_blank">Wisnus</a>
                            <a class="dropdown-item detail-wisman" href="#" target="_blank">Wisman</a>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-dark" id="reset_rekap" type="button" style="margin: 10px">Reset</button>
                </div>
            </form>

            
            </div>
        </div>

        <div class="card table-responsive">
            <div class="card-body">
                <table id="tabel_rekap_hotel_kota" class="table table-light table-striped table-hover table-bordered" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Kab / Kota</th>
                            <th>Jumlah Akomodasi</th>
                            <th>Wisatawan Nusantara</th>
                            <th>Wisatawan Mancanegara</th>
                            <th>Jumlah Keseluruhan</th>
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

<script src="<?php echo base_url('assets/js/') ?>ajax/rekap/hotel.js"></script>