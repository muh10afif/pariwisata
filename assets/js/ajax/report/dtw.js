$(document).ready(function () {
    
    // 24-20-2020

    // menampilkan list kota
    var tabel_kota = $('#tabel_kota').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "Dtw/tampil_kota",
            "type"  : "POST"
        },

        "columnDefs"        : [{
            "targets"   : [0,5],
            "orderable" : false
        }, {
            'targets'   : [0,2,3,4,5],
            'className' : 'text-center',
        }]
    })

    $('#wisnus').on('click', function () {
		$('.float-wisnus').removeAttr('hidden');
		$('.float-wisman').attr('hidden', true);
	})

	$('#wisman').on('click', function () {
		$('.float-wisman').removeAttr('hidden');
		$('.float-wisnus').attr('hidden', true);
	})

	$('#tabel_kota').on('click','.det',function() {
		var id 		= $(this).data('id');
		
		$.ajax({
			type		: "POST",
			url			: "Dtw/get_detail_kota_dtw",
			data		: {id:id, periode:'awal'},
			dataType	: "json",
			success: function (data) {

				$('.float-wisnus').removeAttr('hidden');

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

					$('#data-wisnus').html(html);
				} else {
					html = '<tr><td colspan="5" class="text-center">Data Tidak Ada</td></tr>';

					$('#lt').text(0);
					$('#pt').text(0);
					$('#jt').text(0);

					$('#data-wisnus').html(html);
				}

				if (data.jml_wn != null) {

					var wisman = "<tr><td colspan=5 class='font-weight-bold'><b>KAWASAN ASIA</b></td></tr>";

					var tot_pria_wisman1 	= 0;
					var tot_wanita_wisman1	= 0;
					
					for (var i = 0; i < data['asia'].length; i++) {
						wisman += '<tr>' +
						'<td class="text-center">' + (i + 1) + '.</td>' +
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
						'<td class="text-center">' + (i + 1) + '.</td>' +
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
						'<td class="text-center">' + (i + 1) + '.</td>' +
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
						'<td class="text-center">' + (i + 1) + '.</td>' +
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
						'<td class="text-center">' + (i + 1) + '.</td>' +
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
					
					$('#data-wisman').html(wisman);

				} else {

					html = '<tr><td colspan="5" class="text-center">Data Tidak Ada</td></tr>';

					$('#lt2').text(0);
					$('#pt2').text(0);
					$('#jt2').text(0);

					$('#data-wisman').html(html);

				}

				$('#id_kota').val(id);
				$('#label_dtw').text(': '+data.nama_kota);
				$('a[href="#menu2"]').tab('show');
				
			}
		});
		
	})

	$('.sel2').select2({
		placeholder:"Pilih DTW"
	})

	$('#btn-back').on('click',function(){
		$('a[href="#menu1"]').tab('show');
		
		$('.float-wisman').attr('hidden', true);
		$('.float-wisnus').attr('hidden', true);
	})
	
	$('#periode').on('change',function(){
		var per 	= $(this).val();
		var id_kota = $('#id_kota').val();

		$.ajax({
			type		: "POST",
			url			: "Dtw/get_detail_kota_dtw",
			data		: {periode:per,id:id_kota},
			dataType	: "json",
			success		: function (data) {
				
				var html = "";
				var i;
				var no=1;
				var tot_pria_wisnus = 0;
				var tot_wanita_wisnus = 0;

				console.log(data['jml_ws']);

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

					$('#data-wisnus').html(html);
				} else {
					html = '<tr><td colspan="5" class="text-center">Data Tidak Ada</td></tr>';

					$('#lt').text(0);
					$('#pt').text(0);
					$('#jt').text(0);

					$('#data-wisnus').html(html);
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

					// $('#label_dtw').text('Nama DTW : '+dtw);
					
					$('#data-wisman').html(wisman);

				} else {

					html = '<tr><td colspan="5" class="text-center">Data Tidak Ada</td></tr>';

					$('#lt2').text(0);
					$('#pt2').text(0);
					$('#jt2').text(0);

					$('#data-wisman').html(html);

				}

				$('#id_dtw').val(id_dtw);
				
			}
		});
	})

	// level kota 

	// menampilkan list dtw
    var tabel_dtw = $('#tabel_dtw').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "Dtw/tampil_dtw",
            "type"  : "POST"
        },

        "columnDefs"        : [{
            "targets"   : [0,5],
            "orderable" : false
        }, {
            'targets'   : [0,2,3,4,5],
            'className' : 'text-center',
        }]
	})
	
	$('#tabel_dtw').on('click','.det',function() {
		var id 		= $(this).data('id');
		
		$.ajax({
			type		: "POST",
			url			: "Dtw/get_detail_jml_dtw",
			data		: {id:id, periode:'awal'},
			dataType	: "json",
			success: function (data) {

				$('.float-wisnus').removeAttr('hidden');

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

					$('#data-wisnus').html(html);
				} else {
					html = '<tr><td colspan="5" class="text-center">Data Tidak Ada</td></tr>';

					$('#lt').text(0);
					$('#pt').text(0);
					$('#jt').text(0);

					$('#data-wisnus').html(html);
				}

				if (data.jml_wn != null) {

					var wisman = "<tr><td colspan=5 class='font-weight-bold'><b>KAWASAN ASIA</b></td></tr>";

					var tot_pria_wisman1 	= 0;
					var tot_wanita_wisman1	= 0;
					
					for (var i = 0; i < data['asia'].length; i++) {
						wisman += '<tr>' +
						'<td class="text-center">' + (i + 1) + '.</td>' +
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
						'<td class="text-center">' + (i + 1) + '.</td>' +
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
						'<td class="text-center">' + (i + 1) + '.</td>' +
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
						'<td class="text-center">' + (i + 1) + '.</td>' +
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
						'<td class="text-center">' + (i + 1) + '.</td>' +
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
					
					$('#data-wisman').html(wisman);

				} else {

					html = '<tr><td colspan="5" class="text-center">Data Tidak Ada</td></tr>';

					$('#lt2').text(0);
					$('#pt2').text(0);
					$('#jt2').text(0);

					$('#data-wisman').html(html);

				}

				$('#id_dtw').val(id);
				$('#label_dtw').text(': '+data.nama_dtw);
				$('a[href="#menu2"]').tab('show');
				
			}
		});
		
	})

	$('#periode_kota').on('change',function(){
		var per 	= $(this).val();
		var id_dtw  = $('#id_dtw').val();

		$.ajax({
			type		: "POST",
			url			: "Dtw/get_detail_jml_dtw",
			data		: {periode:per,id:id_dtw},
			dataType	: "json",
			success		: function (data) {
				
				var html = "";
				var i;
				var no=1;
				var tot_pria_wisnus = 0;
				var tot_wanita_wisnus = 0;

				console.log(data['jml_ws']);

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

					$('#data-wisnus').html(html);
				} else {
					html = '<tr><td colspan="5" class="text-center">Data Tidak Ada</td></tr>';

					$('#lt').text(0);
					$('#pt').text(0);
					$('#jt').text(0);

					$('#data-wisnus').html(html);
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

					// $('#label_dtw').text('Nama DTW : '+dtw);
					
					$('#data-wisman').html(wisman);

				} else {

					html = '<tr><td colspan="5" class="text-center">Data Tidak Ada</td></tr>';

					$('#lt2').text(0);
					$('#pt2').text(0);
					$('#jt2').text(0);

					$('#data-wisman').html(html);

				}

				$('#id_dtw').val(id_dtw);
				
			}
		});
	})

    // Akhir 24-02-2020
    
})