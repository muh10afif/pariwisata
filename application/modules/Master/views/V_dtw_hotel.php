<style>

    .table thead tr th {
        text-align: center;
        font-weight: bold;
    }

    table.dataTable thead .sorting::before{
            display:none;
        }
    table.dataTable thead .sorting::after{
            display:none;
        }

    table.dataTable thead .sorting_asc::after {
        display:none;
    }
    table.dataTable thead .sorting_asc::before {
        display:none;
    }

    table.dataTable thead .sorting_desc::after {
        display:none;
    }
    table.dataTable thead .sorting_desc::before {
        display:none;
    }

    table.dataTable thead .sorting {
    background-image: url(https://datatables.net/media/images/sort_both.png);
    background-repeat: no-repeat;
    background-position: center right;
    }

    table.dataTable thead .sorting_asc {
    background-image: url(https://datatables.net/media/images/sort_asc.png);
    background-repeat: no-repeat;
    background-position: center right;
    }

    table.dataTable thead .sorting_desc {
    background-image: url(https://datatables.net/media/images/sort_desc.png);
    background-repeat: no-repeat;
    background-position: center right;
    }

    .l-btn:active {
        box-shadow: 3px 3px 3px #00823F;
        top: 5px;
    }

</style>
<div class="row list-kota">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-rose">
                <h3 class="card-title">List Kota</h3>
                <p class="card-category">Menampilkan semua list kota</p>
            </div>
            <div class="card-body table-responsive">
                <table id="tabel_dtw_hotel" class="table table-light table-striped table-hover table-bordered" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>No.</th>
                            <th>Kota / Kabupaten</th>
                            <th>Jumlah DTW</th>
                            <th>Jumlah Hotel</th>
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

<script src="<?php echo base_url('assets/js/') ?>ajax/master/master_dtw_hotel.js"></script>
