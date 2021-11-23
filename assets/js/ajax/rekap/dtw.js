$(document).ready(function () {

	// 20-02-2020

	var tabel_rekap_dtw_kota = $('#tabel_rekap_dtw_kota').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "Dtw/tampil_rekap_dtw_kota",
            "type"  : "POST",
            "data"  : function (data) {
                data.bln_awal 	= $('#start').val();
                data.bln_akhir 	= $('#end').val();
            }
        },

		"columnDefs"        : [{
			"targets"   : [0,6],
			"orderable" : false
		}, {
			'targets'   : [0,2,3,4,5,6],
			'className' : 'text-center',
		}]

	})

	$('#tampilkan_rekap').on('click', function () {
		tabel_rekap_dtw_kota.ajax.reload(null, false);
	})

	$('#reset_rekap').on('click', function () {
		
		$('#form-rekap').trigger('reset');

		tabel_rekap_dtw_kota.ajax.reload();

		tabel_rekap_dtw_kota.clear().draw();
		tabel_rekap_dtw_kota.search("").draw();
		
		var bln_awal 	= $('#start').val();
		var bln_akhir 	= $('#end').val();

		if (bln_awal == '' || bln_akhir == '') {
			$('.detail-rekap').attr('disabled', true);
			$('.grup-lihat').attr('hidden', true);
		} else {
			$('.detail-rekap').removeAttr('disabled');
			$('.grup-lihat').removeAttr('hidden');
		}

	})

	$('#end').on('change', function () {

		console.log('okkk');

		var bln_awal 	= $('#start').val();
		var bln_akhir 	= $('#end').val();

		if (bln_awal == '' || bln_akhir == '') {
			$('.detail-rekap').attr('disabled', true);
			$('.grup-lihat').attr('hidden', true);
		} else {
			$('.detail-rekap').removeAttr('disabled');
			$('.grup-lihat').removeAttr('hidden');
		}
	})

	$('#start').on('change', function () {

		console.log('okkk');

		var bln_awal 	= $('#start').val();
		var bln_akhir 	= $('#end').val();

		if (bln_awal == '' || bln_akhir == '') {
			$('.detail-rekap').attr('disabled', true);
			$('.grup-lihat').attr('hidden', true);
		} else {
			$('.detail-rekap').removeAttr('disabled');
			$('.grup-lihat').removeAttr('hidden');
		}
	})
	
	$('#tabel_rekap_dtw_kota').on('click', '.detail-rekap', function () {
		
		var bln_awal 	= $('#start').val();
		var bln_akhir 	= $('#end').val();
		var id_kota 	= $(this).data('id');

		if (bln_awal == '' || bln_akhir == '') {
			window.location.href = window.location.href + "/tampil_detail_rekap_dtw_kota/"+id_kota;
		} else {
			window.location.href = window.location.href + "/tampil_detail_rekap_dtw_kota/"+id_kota+"/"+bln_awal+"/"+bln_akhir;
		}

	})

	$('#reset_rekap_dtw').on('click', function () {
		$('#form-rekap-dtw').trigger('reset');

		$('.form-detail').attr('hidden', true);
		$('.tabel-rekap').removeAttr('hidden');
	})

	// menampilkan list dtw, kota
    var base_url = $('#base_url').val();

    var tabel_rekap_dtw = $('#tabel_rekap_dtw').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : base_url+"Rekap/Dtw/tampil_list_dtw",
            "type"  : "POST",
            "data"  : function (data) {
				data.id_kota 	= $('#id_kota').val();
				data.bln_awal 	= $('#bln_awal').val();
                data.bln_akhir 	= $('#bln_akhir').val();
            }
        },

		"columnDefs"        : [{
			"targets"   : [0],
			"orderable" : false
		}, {
			'targets'   : [0,2,3,4],
			'className' : 'text-center',
		}]

	})
	
	// aksi lihat detail
	$('#lihat_detail_dtw1').on('click', function () {
		
		var form_rekap 		= $('#form-rekap-dtw').serialize();
		var jenis_wisatawan = $('#jenis_wisatawan').val();

		if (jenis_wisatawan == ' ') {

			swal({
                title               : "Peringatan",
                text                : 'Jenis wisatawan harus terisi!',
                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-success",
                type                : 'warning',
                showConfirmButton   : false,
                timer               : 1000
            }); 

			return false;
			
		} else {
			

			// $.ajax({
			// 	url     : base_url+"rekap/dtw/tampil_lihat_detail",
			// 	type    : "POST",
			// 	beforeSend  : function () {
			// 		swal({
			// 			title   : 'Menunggu',
			// 			html    : 'Memproses Data',
			// 			onOpen  : () => {
			// 				swal.showLoading();
			// 			}
			// 		})
			// 	},
			// 	data    : form_rekap,
			// 	success : function (data) {

			// 		swal.close();

			// 		$('.tabel-rekap').attr('hidden', true);
			// 		$('.form-detail').removeAttr('hidden');
			// 		$('.form-detail').html(data);
	
			// 	}
			// })
	
			// return false;

		}

	})

	// Akhir 20-02-2020

	// 21-02-2020

	$('.detail-wisnus').on('click', function () {
		
		var bln_awal 	= $('#start').val();
		var bln_akhir 	= $('#end').val();

		var bu = base_url+"Rekap/Dtw/tampil_lihat_detail_all/wisnus/lihat/"+bln_awal+"/"+bln_akhir;

		window.open(bu, '_blank');

	})

	$('.detail-wisman').on('click', function () {
		
		var bln_awal 	= $('#start').val();
		var bln_akhir 	= $('#end').val();

		var bu = base_url+"Rekap/Dtw/tampil_lihat_detail_all/wisman/lihat/"+bln_awal+"/"+bln_akhir;

		window.open(bu, '_blank');

	})

	// Akhir 21-02-2020

	show_dtw();

	$('.datepicker').bootstrapMaterialDatePicker({
		time:false,
        format:"YYYY-MM",
        monthPicker:true,
        clearButton:true
	});

	function show_dtw() {
		$.ajax({
			type	: 'POST',
			url		: 'Dtw/json_all',
			data 	: {periode:''},
			dataType: 'json',
			success: function (data) {
				var html = "";
				var i;
				for (var i = 0; i < data.length; i++) {
					var total = +data[i].total_wisnus+ +data[i].total_wisman;

					var hidden;
					
					if (total == 0) {
						hidden = 'disabled';
					} else {
						hidden = '';
					}

					html += '<tr>' +
						'<td>' + (i + 1) + '.</td>' +
						'<td>' + data[i].nama_dtw + '</td>' +
						'<td>' + data[i].alamat + '</td>' +
						'<td>'+total+'</td>' +
						'<td class="text-center">' +
						'<button  class="btn btn-rose btn-sm det" data="'+data[i].nama_dtw+'" data-id="'+data[i].id_dtw+'" '+hidden+'>Detail</button>' +

						'</td>' +
						'</tr>';
				}
				$('#data-dtw').html(html);
				$('#tbl_dtw').DataTable({
					language: {
						search: "_INPUT_",
						searchPlaceholder: "Search records"
					},

					'columnDefs': [{
						'targets': [0],
						'orderable': false,
					  }, {
						  'targets': [0,3,4],
						  'className': 'text-center',
					  }],
					
				});
				$("body").tooltip({
					selector: '[rel="tooltip"]'
				});
			}
		})
	}

	$('#wisnus').on('click', function () {
		$('.float-wisnus').removeAttr('hidden');
		$('.float-wisman').attr('hidden', true);
	})

	$('#wisman').on('click', function () {
		$('.float-wisman').removeAttr('hidden');
		$('.float-wisnus').attr('hidden', true);
	})

	$('#data-dtw').on('click','.det',function() {
		var dtw 	= $(this).attr('data');
		var id 		= $(this).attr('data-id');
		
		$.ajax({
			type		: "POST",
			url			: "Dtw/get_wisnus_p_dtw",
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
				$('#label_dtw').text('Nama DTW : '+dtw);
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
		var id_dtw 	= $('#id_dtw').val();

		$.ajax({
			type		: "POST",
			url			: "Dtw/get_wisnus_p_dtw",
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

})