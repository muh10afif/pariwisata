<style>
	#tbl_wisnus_ad th {
		font-weight: bold;
	}
	#tbl_wisman_ad th {
		font-weight: bold;
	}
	.float-b{
        position    :fixed;
        width       :115%;
        height      :60px;
        bottom      :-20px;
    }

	.field-icon {
        float: right;
        margin-left: -30px;
        margin-right: 10px;
        margin-top: 0px;
        position: relative;
        z-index: 2;
    }
</style>
<div class="card">
  <form method="POST" id="fwisnus" action="<?php echo base_url('Kelolaan/Hotel/simpan_wisnus') ?>">
    <div class="card-header card-header-tabs card-header-rose">
      <div class="nav-tabs-navigation">
        <div class="nav-tabs-wrapper">
          <h3 class="float-left" style="margin-top: -1px;" id="judul_rekap">Rekap Wisatawan Nusantara</h3>
          <ul class="nav nav-tabs float-right" data-tabs="tabs">
            <li class="nav-item">
              <a class="nav-link active show" id="wisnus" href="#link1" data-toggle="tab">
                <i class="material-icons">arrow_downward</i> WISNUS
                <div class="ripple-container"></div>
              </a>
            </li>
            <li class="nav-item mb-3">
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
          <div class="row">
            <div class="col-md-6 col-lg-6">
            <input type="hidden" name="id_hotel" id="id_hotel">
              <div class="input-group ">
              <h5 id="label_hotel" class="font-weight-bold mt-2">Nama hotel : <?= $nama_hotel ?></h5>
              </div>
            </div>
            <div class="col-md-6 col-lg-6">
              <div class="input-group "> 
				<input type="text" class="form-control datepicker12" id="periode_rekap" data="1" name="periode" style="margin-top: -6px;" placeholder="Pilih Bulan" autocomplete="off">
				<span class="fa fa-times field-icon hapus" hidden></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="tab-content tab-space">
        <div class="tab-pane active" id="link1">
          <div class="container-fluid mt-3">
            <table id="tbl_wisnus_ad" class="table table-bordered table-hover table-striped" width="100%">
              <thead class="thead-light">
				  <tr>
                <th class="text-center" width="30px;">No</th>
                <th class="text-center" width="250px;">Provinsi</th>
                <th class="text-center" width="200px;">Pria</th>
                <th class="text-center" width="200px;">Wanita</th>
				<th class="text-center" width="100px">Jumlah</th>
				</tr>
              </thead>
              <tbody id="data-wisnus-ad">
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane" id="link2">
          <div class="container-fluid mt-3">
          <table id="tbl_wisman_ad" class="table table-bordered table-hover table-striped" width="100%">
              <thead class="thead-light">
                <th class="text-center" width="30px;">No</th>
                <th class="text-center" width="250px;">Negara / Kebangsaan</th>
                <th class="text-center" width="200px;">Pria</th>
                <th class="text-center" width="200px;">Wanita</th>
                <th class="text-center" width="100px">Jumlah</th>
              </thead>
              <tbody id="data-wisman-ad">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    </form>
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

  <script src="<?php echo base_url('assets/js/') ?>ajax/rekap/hotel.js"></script>

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

  <script>

$(document).ready(function () {
        
	show_data();
	
	$('.float-wisnus').removeAttr('hidden');

 	function show_data() {

		var periode = 'awal';
		var id 		= '<?php echo $id_hotel ?>';
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('Rekap/Hotel/get_wisnus_p_hotel') ?>",
			data: {id:id, periode:periode},
			dataType: "json",
			success: function (data) {
				var html = "";
				var wisman = "<tr><td colspan=5 class='font-weight-bold'><b>KAWASAN ASIA</b></td></tr>";
				var i;
				var no=1;
				var tot_pria_wisnus = 0;
				var tot_wanita_wisnus = 0;

				if (data.jml_ws != null) {
					for (var i = 0; i < data['wisnus'].length; i++) {
						html += '<tr>' +
							'<td class="text-center">' + (i + 1) + '.</td>' +
							'<td>' + data['wisnus'][i].nama_provinsi + '</td>' +
							'<td class="text-center">' + +data['wisnus'][i].tot_pria + '</td>' +
							'<td class="text-center">' + +data['wisnus'][i].tot_wanita + '</td>' +
							'<td class="text-center">' + +data['wisnus'][i].tot_jumlah + '</td>' +
							'</tr>';

						tot_pria_wisnus 	+= +data['wisnus'][i].tot_pria;
						tot_wanita_wisnus 	+= +data['wisnus'][i].tot_wanita;
					};

					var tot_kj = +tot_pria_wisnus + +tot_wanita_wisnus;

					$('#lt').text(tot_pria_wisnus);
					$('#pt').text(tot_wanita_wisnus);
					$('#jt').text(data.jml_ws);

					$('#data-wisnus-ad').html(html);
				} else {
					html = '<tr><td colspan="5" class="text-center">Data Tidak Ada</td></tr>';

					$('#lt').text(0);
					$('#pt').text(0);
					$('#jt').text(0);

					$('#data-wisnus-ad').html(html);
				}

				if (data.jml_wn != null) {

					var wisman = "<tr><td colspan=5 class='font-weight-bold'><b>KAWASAN ASIA</b></td></tr>";

					var tot_pria_wisman1 	= 0;
					var tot_wanita_wisman1	= 0;
					
					for (var i = 0; i < data['asia'].length; i++) {
						wisman += '<tr>' +
						'<td class="text-center">' + (i + 1) + '</td>' +
						'<td>' + data['asia'][i].nama_negara + '</td>' +
						'<td class="text-center">' + +data['asia'][i].tot_pria + '</td>' +
						'<td class="text-center">' + +data['asia'][i].tot_wanita + '</td>' +
						'<td class="text-center">' + +data['asia'][i].tot_jumlah + '</td>'+
						'</tr>';

						tot_pria_wisman1 	+= +data['asia'][i].tot_pria;
						tot_wanita_wisman1 	+= +data['asia'][i].tot_wanita;
					}

					wisman += "<tr><td colspan=5 class='font-weight-bold'><b>KAWASAN EROPA</b></td></tr>";

					var tot_pria_wisman2 	= 0;
					var tot_wanita_wisman2	= 0;

					for (var i = 0; i < data['eropa'].length; i++) {
						wisman += '<tr>' +
						'<td class="text-center">' + (i + 1) + '</td>' +
						'<td>' + data['eropa'][i].nama_negara + '</td>' +
						'<td class="text-center">' + +data['eropa'][i].tot_pria + '</td>' +
						'<td class="text-center">' + +data['eropa'][i].tot_wanita + '</td>' +
						'<td class="text-center">' + +data['eropa'][i].tot_jumlah + '</td>'+
						'</tr>';

						tot_pria_wisman2 	+= +data['eropa'][i].tot_pria;
						tot_wanita_wisman2 	+= +data['eropa'][i].tot_wanita;
					}

					wisman += "<tr><td colspan=5 class='font-weight-bold'><b>KAWASAN AMERIKA</b></td></tr>";

					var tot_pria_wisman3 	= 0;
					var tot_wanita_wisman3	= 0;

					for (var i = 0; i < data['amerika'].length; i++) {
						wisman += '<tr>' +
						'<td class="text-center">' + (i + 1) + '</td>' +
						'<td>' + data['amerika'][i].nama_negara + '</td>' +
						'<td class="text-center">' + +data['amerika'][i].tot_pria + '</td>' +
						'<td class="text-center">' + +data['amerika'][i].tot_wanita + '</td>' +
						'<td class="text-center">' + +data['amerika'][i].tot_jumlah + '</td>'+
						'</tr>';

						tot_pria_wisman3 	+= +data['amerika'][i].tot_pria;
						tot_wanita_wisman3 	+= +data['amerika'][i].tot_wanita;
					}

					wisman += "<tr><td colspan=5 class='font-weight-bold'><b>KAWASAN AUSTRALIA</b></td></tr>";

					var tot_pria_wisman4 	= 0;
					var tot_wanita_wisman4	= 0;

					for (var i = 0; i < data['australia'].length; i++) {
						wisman += '<tr>' +
						'<td class="text-center">' + (i + 1) + '</td>' +
						'<td>' + data['australia'][i].nama_negara + '</td>' +
						'<td class="text-center">' + +data['australia'][i].tot_pria + '</td>' +
						'<td class="text-center">' + +data['australia'][i].tot_wanita + '</td>' +
						'<td class="text-center">' + +data['australia'][i].tot_jumlah + '</td>'+
						'</tr>';

						tot_pria_wisman4 	+= +data['australia'][i].tot_pria;
						tot_wanita_wisman4 	+= +data['australia'][i].tot_wanita;
					}

					wisman += "<tr><td colspan=5 class='font-weight-bold'><b>KAWASAN AFRIKA</b></td></tr>";

					var tot_pria_wisman5 	= 0;
					var tot_wanita_wisman5	= 0;

					for (var i = 0; i < data['afrika'].length; i++) {
						wisman += '<tr>' +
						'<td class="text-center">' + (i + 1) + '</td>' +
						'<td>' + data['afrika'][i].nama_negara + '</td>' +
						'<td class="text-center">' + +data['afrika'][i].tot_pria + '</td>' +
						'<td class="text-center">' + +data['afrika'][i].tot_wanita + '</td>' +
						'<td class="text-center">' + +data['afrika'][i].tot_jumlah + '</td>'+
						'</tr>';

						tot_pria_wisman5 	+= +data['afrika'][i].tot_pria;
						tot_wanita_wisman5 	+= +data['afrika'][i].tot_wanita;
					}

					var tot_p_wisman = +tot_pria_wisman1 + +tot_pria_wisman2 + +tot_pria_wisman3 + +tot_pria_wisman4 + +tot_pria_wisman5;
					var tot_w_wisman = +tot_wanita_wisman1 + +tot_wanita_wisman2 + +tot_wanita_wisman3 + +tot_wanita_wisman4 + +tot_wanita_wisman5;

					$('#lt2').text(tot_p_wisman);
					$('#pt2').text(tot_w_wisman);
					$('#jt2').text(data.jml_wn);

					$('#id_hotel').val(id_hotel);
					
					$('#data-wisman-ad').html(wisman);

				} else {

					html = '<tr><td colspan="5" class="text-center">Data Tidak Ada</td></tr>';

					$('#lt2').text(0);
					$('#pt2').text(0);
					$('#jt2').text(0);

					$('#data-wisman-ad').html(html);

				}

			}
		});
		
	}

	$('.hapus').on('click', function () {
		$('#periode_rekap').val('');

		$(this).attr('hidden', true);

		show_data();
	})

	// saat klik tab wisnus
	$('#wisnus').on('click', function () {
		$('a[href="#link1"]').tab('show');
		$('#judul_rekap').text('Rekap Wisatawan Nusantara');

		$('.float-wisnus').removeAttr('hidden');
		$('.float-wisman').attr('hidden', true);
	})

	// saat klik tab wisman
	$('#wisman').on('click', function () {
		$('a[href="#link2"]').tab('show');
		$('#judul_rekap').text('Rekap Wisatawan Mancanegara');

		$('.float-wisman').removeAttr('hidden');
		$('.float-wisnus').attr('hidden', true);
	})

	// filter dengan periode
	$('#periode_rekap').on('change', function () {

		var periode = $(this).val();
		var id 		= '<?php echo $id_hotel ?>';
		$.ajax({
			type		: "POST",
			url			: "<?php echo base_url('Rekap/Hotel/get_wisnus_p_hotel') ?>",
			data		: {id:id, periode:periode},
			dataType	: "json",
			success	: function (data) {
				swal.close();

				$('.hapus').removeAttr('hidden');

				$('#periode_rekap').val(data.periode);

				var html = "";
				var i;
				var no=1;
				var tot_pria_wisnus = 0;
				var tot_wanita_wisnus = 0;

				if (data.jml_ws == null) {

					html = '<tr><td colspan="5" class="text-center">Data Tidak Ada</td></tr>';

					$('#lt').text(0);
					$('#pt').text(0);
					$('#jt').text(0);

					$('#data-wisnus-ad').html(html);

				} else {

					for (var i = 0; i < data['wisnus'].length; i++) {
						html += '<tr>' +
							'<td class="text-center">' + (i + 1) + '.</td>' +
							'<td>' + data['wisnus'][i].nama_provinsi + '</td>' +
							'<td class="text-center">' + +data['wisnus'][i].tot_pria + '</td>' +
							'<td class="text-center">' + +data['wisnus'][i].tot_wanita + '</td>' +
							'<td class="text-center">' + +data['wisnus'][i].tot_jumlah + '</td>' +
							'</tr>';

						tot_pria_wisnus 	+= +data['wisnus'][i].tot_pria;
						tot_wanita_wisnus 	+= +data['wisnus'][i].tot_wanita;
					};

					var tot_kj = +tot_pria_wisnus + +tot_wanita_wisnus;

					$('#lt').text(tot_pria_wisnus);
					$('#pt').text(tot_wanita_wisnus);
					$('#jt').text(data.jml_ws);

					$('#data-wisnus-ad').html(html);

				}

				if (data.jml_wn == null) {

					html = '<tr><td colspan="5" class="text-center">Data Tidak Ada</td></tr>';

					$('#lt2').text(0);
					$('#pt2').text(0);
					$('#jt2').text(0);

					$('#data-wisman-ad').html(html);

				} else {

					var wisman = "<tr><td colspan=5 class='font-weight-bold'><b>KAWASAN ASIA</b></td></tr>";

					var tot_pria_wisman1 	= 0;
					var tot_wanita_wisman1	= 0;
					
					for (var i = 0; i < data['asia'].length; i++) {
						wisman += '<tr>' +
						'<td class="text-center">' + (i + 1) + '</td>' +
						'<td>' + data['asia'][i].nama_negara + '</td>' +
						'<td class="text-center">' + +data['asia'][i].tot_pria + '</td>' +
						'<td class="text-center">' + +data['asia'][i].tot_wanita + '</td>' +
						'<td class="text-center">' + +data['asia'][i].tot_jumlah + '</td>'+
						'</tr>';

						tot_pria_wisman1 	+= +data['asia'][i].tot_pria;
						tot_wanita_wisman1 	+= +data['asia'][i].tot_wanita;
					}

					wisman += "<tr><td colspan=5 class='font-weight-bold'><b>KAWASAN EROPA</b></td></tr>";

					var tot_pria_wisman2 	= 0;
					var tot_wanita_wisman2	= 0;

					for (var i = 0; i < data['eropa'].length; i++) {
						wisman += '<tr>' +
						'<td class="text-center">' + (i + 1) + '</td>' +
						'<td>' + data['eropa'][i].nama_negara + '</td>' +
						'<td class="text-center">' + +data['eropa'][i].tot_pria + '</td>' +
						'<td class="text-center">' + +data['eropa'][i].tot_wanita + '</td>' +
						'<td class="text-center">' + +data['eropa'][i].tot_jumlah + '</td>'+
						'</tr>';

						tot_pria_wisman2 	+= +data['eropa'][i].tot_pria;
						tot_wanita_wisman2 	+= +data['eropa'][i].tot_wanita;
					}

					wisman += "<tr><td colspan=5 class='font-weight-bold'><b>KAWASAN AMERIKA</b></td></tr>";

					var tot_pria_wisman3 	= 0;
					var tot_wanita_wisman3	= 0;

					for (var i = 0; i < data['amerika'].length; i++) {
						wisman += '<tr>' +
						'<td class="text-center">' + (i + 1) + '</td>' +
						'<td>' + data['amerika'][i].nama_negara + '</td>' +
						'<td class="text-center">' + +data['amerika'][i].tot_pria + '</td>' +
						'<td class="text-center">' + +data['amerika'][i].tot_wanita + '</td>' +
						'<td class="text-center">' + +data['amerika'][i].tot_jumlah + '</td>'+
						'</tr>';

						tot_pria_wisman3 	+= +data['amerika'][i].tot_pria;
						tot_wanita_wisman3 	+= +data['amerika'][i].tot_wanita;
					}

					wisman += "<tr><td colspan=5 class='font-weight-bold'><b>KAWASAN AUSTRALIA</b></td></tr>";

					var tot_pria_wisman4 	= 0;
					var tot_wanita_wisman4	= 0;

					for (var i = 0; i < data['australia'].length; i++) {
						wisman += '<tr>' +
						'<td class="text-center">' + (i + 1) + '</td>' +
						'<td>' + data['australia'][i].nama_negara + '</td>' +
						'<td class="text-center">' + +data['australia'][i].tot_pria + '</td>' +
						'<td class="text-center">' + +data['australia'][i].tot_wanita + '</td>' +
						'<td class="text-center">' + +data['australia'][i].tot_jumlah + '</td>'+
						'</tr>';

						tot_pria_wisman4 	+= +data['australia'][i].tot_pria;
						tot_wanita_wisman4 	+= +data['australia'][i].tot_wanita;
					}

					wisman += "<tr><td colspan=5 class='font-weight-bold'><b>KAWASAN AFRIKA</b></td></tr>";

					var tot_pria_wisman5 	= 0;
					var tot_wanita_wisman5	= 0;

					for (var i = 0; i < data['afrika'].length; i++) {
						wisman += '<tr>' +
						'<td class="text-center">' + (i + 1) + '</td>' +
						'<td>' + data['afrika'][i].nama_negara + '</td>' +
						'<td class="text-center">' + +data['afrika'][i].tot_pria + '</td>' +
						'<td class="text-center">' + +data['afrika'][i].tot_wanita + '</td>' +
						'<td class="text-center">' + +data['afrika'][i].tot_jumlah + '</td>'+
						'</tr>';

						tot_pria_wisman5 	+= +data['afrika'][i].tot_pria;
						tot_wanita_wisman5 	+= +data['afrika'][i].tot_wanita;
					}

					var tot_p_wisman = +tot_pria_wisman1 + +tot_pria_wisman2 + +tot_pria_wisman3 + +tot_pria_wisman4 + +tot_pria_wisman5;
					var tot_w_wisman = +tot_wanita_wisman1 + +tot_wanita_wisman2 + +tot_wanita_wisman3 + +tot_wanita_wisman4 + +tot_wanita_wisman5;

					$('#lt2').text(tot_p_wisman);
					$('#pt2').text(tot_w_wisman);
					$('#jt2').text(data.jml_wn);

					$('#id_hotel').val(id_hotel);
					
					$('#data-wisman-ad').html(wisman);

				}

			}
		})
		
	})
	
});
    
  
  </script>