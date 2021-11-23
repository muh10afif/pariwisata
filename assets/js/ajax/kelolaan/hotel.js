$(document).ready(function(){

  // menampilkan data tabel list kelolaan hotel
  var tbl_hotel = $('#tbl_hotel').DataTable({
    "processing"    : true,
    'ajax'          : {
        'url'   : 'Hotel/tampil_hotel',
        'type'  : 'POST',
        "data"  : function (data) {
            data.periode    = $('#periode_hotel').val();
            data.id_pegawai = $('#id_pegawai').val();
        }
    },
    stateSave       : true,
    "order"         : [],
    'columnDefs'    : [{
        'targets'   : [5,6],
        'orderable' : false,
    }, {
        'targets'   : [0,5,6],
        'className' : 'text-center',
    }],

  });

  // filter tanggal periode
  $('#periode_hotel').on('change', function () {

    var periode   = $(this).val();
    var per_awal  = $('#per_awal').val();

    $.ajax({
        url     : "Hotel/ambil_periode",
        type    : "POST",
        data    : {periode:periode},
        dataType: "JSON",
        success : function (data) {                  

            $('#periode_hotel').val(data.periode);
      
            tbl_hotel.ajax.reload(null, false);
    
            if (periode == '') {
                $('#periode_hotel').val(per_awal)
            }
            
        }
    })

    return false;

  })

  // saat klik input data
  $('#tbl_hotel').on('click','.input-hotel',function(){

    var hotel     = $(this).attr('nm-hotel');
    var id_hotel  = $(this).attr('data-id');
    var tgl_per   = $(this).attr('tgl-periode');

    $.ajax({
      url     : "Hotel/simpan_list",
      type    : "POST",
      data    : {periode:tgl_per, id_hotel:id_hotel, data:'lihat', jenis_data:'wisnus'},
      dataType: "JSON",
      success : function (data) {                  

          $('#tp').text(data.tot_pria);
          $('#tw').text(data.tot_wanita);
          $('#tj').text(data.tot_jumlah);

          $('#provinsi').html(data.provinsi);

          $('a[href="#menu2"]').tab('show');
          $('a[href="#link1"]').tab('show');
          $('#tab-wisnus').removeAttr('hidden');
          $('#tab-wisman').attr('hidden', true);
          $('.label_hotel').text('Nama Hotel : '+hotel);
          $('#id_hotel').val(id_hotel);
          $('#periode').val(tgl_per);
          $('#periode_h_wisman').val(tgl_per);

          $('#kawasan').attr('data', 'cari_negara');

          if (data.tot_jumlah == null) {
              $('#simpan_list_wisnus_hotel').attr('hidden', true);
          } else {
              $('#simpan_list_wisnus_hotel').removeAttr('hidden');
          }

            tabel_list_input_wisnus.ajax.reload(null, false); 
            tabel_list_input_wisman.ajax.reload(null, false); 
          
      }
  })

  return false;

  })

  // saat klik tab wisman
  $('#wisman').on('click',function() {

    var id_hotel  = $('#id_hotel').val();
    var tgl_per   = $('#periode_h_wisman').val();

    $.ajax({
      url     : "Hotel/simpan_list",
      type    : "POST",
      data    : {periode:tgl_per, id_hotel:id_hotel, data:'lihat', jenis_data:'wisman'},
      dataType: "JSON",
      success : function (data) {                  

          $('#tp_wisman').text(data.tot_pria);
          $('#tw_wisman').text(data.tot_wanita);
          $('#tj_wisman').text(data.tot_jumlah);

          $('#tab-wisman').removeAttr('hidden');
          $('#tab-wisnus').attr('hidden', true);

          $('#kawasan').attr('data', 'cari_negara');

          if (data.tot_jumlah == null) {
              $('#simpan_list_wisman_hotel').attr('hidden', true);
          } else {
              $('#simpan_list_wisman_hotel').removeAttr('hidden');
          }

          tabel_list_input_wisman.ajax.reload(null, false); 
          
      }
    })

  })

  // saat klik tab wisnus
  $('#wisnus').on('click',function() {

    var id_hotel  = $('#id_hotel').val();
    var tgl_per   = $('#periode').val();

    $.ajax({
      url     : "Hotel/simpan_list",
      type    : "POST",
      data    : {periode:tgl_per, id_hotel:id_hotel, data:'lihat', jenis_data:'wisnus'},
      dataType: "JSON",
      success : function (data) {                  

          $('#tp').text(data.tot_pria);
          $('#tw').text(data.tot_wanita);
          $('#tj').text(data.tot_jumlah);

          $('#tab-wisnus').removeAttr('hidden');
          $('#tab-wisman').attr('hidden', true);

          $('#provinsi').html(data.provinsi);

          if (data.tot_jumlah == null) {
              $('#simpan_list_wisnus_hotel').attr('hidden', true);
          } else {
              $('#simpan_list_wisnus_hotel').removeAttr('hidden');
          }

          tabel_list_input_wisnus.ajax.reload(null, false); 
          
      }
    })
  })

  $('#btn-back').on('click',function() {
    $('a[href="#menu1"]').tab('show');   
    
    tbl_hotel.ajax.reload(null, false);
  })

  // wisnus

  // menampilkan data
  var tabel_list_input_wisnus = $('#tabel_list_input_wisnus').DataTable({
    "processing"    : true,
    "dom"           : "t",
    "ajax"          : {
        "url"   : "Hotel/tampil_list_hotel",
        "type"  : "POST",
        "data"  : function (data) {
            data.periode   = $('#periode').val();
            data.id_hotel  = $('#id_hotel').val();
        }
    },
    stateSave       : true,
    "order"         : [ [0, 'asc']],
    "columnDefs"        : [{
        "targets"   : [2,3,4],
        "className" : 'text-center'
    }, {
        "targets"   : [5],
        "orderable" : false
    }]
  });

  // ubah data
  $('#tabel_list_input_wisnus').on('click', '.ubah-hotel', function () {
      
      var id_rekap_wisnus_hotel = $(this).data('id');

      $.ajax({
          url     : "Hotel/tampil_data_ubah_hotel",
          type    : "POST",
          data    : {id_rekap_wisnus_hotel:id_rekap_wisnus_hotel},
          dataType: "JSON",
          success : function (data) { 

              $('#pria').val(data.pria);
              $('#wanita').val(data.wanita);
              $('#jumlah').val(data.jumlah);
              $('#provinsi').next('.select2-container').hide();
              $('#nm_provinsi').removeAttr('hidden');
              $('#nm_provinsi').attr('disabled', true);
              $('#nm_provinsi').val(data.nm_provinsi);
              $('#id_rekap').val(data.id_rekap);
              $('#periode').attr('disabled', true);

              $('.ubah-hotel').attr('disabled', true);
              $('.hapus-hotel').attr('disabled', true);
              $('#simpan_list_wisnus_hotel').attr('disabled', true);

              $('#tambah_hotel').attr('hidden', true);
              $('#ubah_hotel').removeAttr('hidden');
              $('#cancel_hotel').removeAttr('hidden');
              
          }
      })

      return false;

  })

  // hapus data list hotel
  $('#tabel_list_input_wisnus').on('click', '.hapus-hotel', function () {
      
      var id_rekap_wisnus_hotel = $(this).data('id');
      var periode             = $('#periode').val();
      var id_hotel              = $('#id_hotel').val();

      swal({
          title       : 'Konfirmasi',
          text        : 'Yakin akan hapus data',
          type        : 'warning',

          buttonsStyling      : false,
          confirmButtonClass  : "btn btn-danger",
          cancelButtonClass   : "btn btn-warning mr-3",

          showCancelButton    : true,
          confirmButtonText   : 'Hapus',
          confirmButtonColor  : '#3085d6',
          cancelButtonColor   : '#d33',
          cancelButtonText    : 'Tidak',
          reverseButtons      : true
      }).then((result) => {
          if (result.value) {
              $.ajax({
                  url     : "Hotel/simpan_ubah_hapus_list",
                  type    : "POST",
                  data    : {id_rekap:id_rekap_wisnus_hotel, periode:periode, id_hotel:id_hotel, aksi:'hapus'},
                  dataType: "JSON",
                  success : function (data) {
                      swal({
                          title               : "Berhasil",
                          text                : 'Data berhasil dihapus',
                          buttonsStyling      : false,
                          confirmButtonClass  : "btn btn-success",
                          type                : 'success'
                      });    

                      tabel_list_input_wisnus.ajax.reload(null,false);                   

                      $('#tp').text(data.tot_pria);
                      $('#tw').text(data.tot_wanita);
                      $('#tj').text(data.tot_jumlah);

                      $('#pria').val('');
                      $('#wanita').val('');
                      $('#jumlah').val('');

                      $('#provinsi').html(data.provinsi);

                      $('#simpan_list_wisnus_hotel').removeAttr('hidden');
                  }
              })

              return false;

          } else if (result.dismiss === swal.DismissReason.cancel) {

              swal({
                  title               : "Batal",
                  text                : 'Anda membatalkan hapus data',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-info",
                  type                : 'error'
              }); 
          }
      })

      return false;

  })

  // cancel ubah data hotel
  $('#cancel_hotel').on('click', function () {

      var periode     = $('#periode').val();
      var id_hotel      = $('#id_hotel').val();

      $.ajax({
          url     : "Hotel/ambil_option_provinsi",
          type    : "POST",
          data    : {periode:periode, id_hotel:id_hotel},
          dataType: "JSON",
          success : function (data) {      

              $('#pria').val('');
              $('#wanita').val('');
              $('#jumlah').val('');
              $('#tambah_hotel').removeAttr('hidden');
              $('#ubah_hotel').attr('hidden', true);
              $('#cancel_hotel').attr('hidden', true);

              $('.ubah-hotel').removeAttr('disabled');
              $('.hapus-hotel').removeAttr('disabled');
              $('#simpan_list_wisnus_hotel').removeAttr('disabled');
              
              $('#provinsi').next('.select2-container').show();
              $('#nm_provinsi').attr('hidden', true);
              $('#provinsi').html(data.provinsi);

              $('#periode').attr('disabled', true);

          }
      })

      return false;

  })

  // ubah data hotel
  $('#ubah_hotel').on('click', function () {
      
      var id_hotel   = $('#id_hotel').val();
      var periode  = $('#periode').val();
      var id_rekap = $('#id_rekap').val();
      var pria     = $('#pria').val();
      var wanita   = $('#wanita').val();
      var jumlah   = $('#jumlah').val();

      $.ajax({
          url      : "Hotel/simpan_ubah_hapus_list",
          type     : "POST",
          data     : {periode:periode, id_hotel:id_hotel, pria:pria, wanita:wanita, jumlah:jumlah, id_rekap:id_rekap, aksi:'ubah'},
          dataType : "JSON",
          success  : function (data) {
              swal({
                  title               : "Berhasil",
                  text                : 'Data berhasil diubah',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-success",
                  type                : 'success'
              });    

              tabel_list_input_wisnus.ajax.reload(null, false);                   

              $('#tp').text(data.tot_pria);
              $('#tw').text(data.tot_wanita);
              $('#tj').text(data.tot_jumlah);

              $('#pria').val('');
              $('#wanita').val('');
              $('#jumlah').val('');

              $('#tambah_hotel').removeAttr('hidden');
              $('#ubah_hotel').attr('hidden', true);
              $('#cancel_hotel').attr('hidden', true);

              $('.ubah-hotel').removeAttr('disabled');
              $('.hapus-hotel').removeAttr('disabled');
              $('#simpan_list_wisnus_hotel').removeAttr('disabled');
              
              $('#provinsi').next('.select2-container').show();
              $('#nm_provinsi').attr('hidden', true);
              $('#provinsi').html(data.provinsi);

              $('#periode_hotel').attr('disabled', true);

              $('#simpan_list_wisnus_hotel').removeAttr('hidden');
          }
      })

      return false;

  })

  // proses simpan list wisnus hotel
  $('#simpan_list_wisnus_hotel').on('click', function () {

      var periode     = $('#periode').val();
      var id_hotel    = $('#id_hotel').val();

      swal({
          title       : 'Konfirmasi',
          text        : 'Yakin akan kirim data',
          type        : 'warning',

          buttonsStyling      : false,
          confirmButtonClass  : "btn btn-info",
          cancelButtonClass   : "btn btn-danger mr-3",

          showCancelButton    : true,
          confirmButtonText   : 'Kirim Data',
          confirmButtonColor  : '#3085d6',
          cancelButtonColor   : '#d33',
          cancelButtonText    : 'Batal',
          reverseButtons      : true
      }).then((result) => {
          if (result.value) {
              $.ajax({
                  url     : "Hotel/simpan_list_wisnus_hotel",
                  type    : "POST",
                  data    : {periode:periode, id_hotel:id_hotel},
                  dataType: "JSON",
                  success : function (data) {
                      swal({
                          title               : "Berhasil",
                          text                : 'Data berhasil ditambahkan',
                          buttonsStyling      : false,
                          confirmButtonClass  : "btn btn-success",
                          type                : 'success'
                      });    

                      tabel_list_input_wisnus.clear().draw();                   

                      $('#tp').text('0');
                      $('#tw').text('0');
                      $('#tj').text('0');

                      $('#pria').val('');
                      $('#wanita').val('');
                      $('#jumlah').val('');

                      $('#periode_hotel').attr('disabled', true);
                      
                      $('#provinsi').html(data.provinsi);

                      $('#simpan_list_wisnus_hotel').attr('hidden', true);
                  }
              })

              return false;

          } else if (result.dismiss === swal.DismissReason.cancel) {

              swal({
                  title               : "Batal",
                  text                : 'Anda membatalkan kirim data',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-info",
                  type                : 'error'
              }); 
          }
      })

      return false;
      
  })

  // proses tambah list status 0
  $('#tambah_hotel').on('click', function () {

      var periode     = $('#periode').val();
      var pria        = $('#pria').val();
      var wanita      = $('#wanita').val();
      var jumlah      = $('#jumlah').val();
      var provinsi    = $('#provinsi').val();
      var id_hotel      = $('#id_hotel').val();

      // mengambil nama provinsi
      var nm_provinsi   = $("#provinsi option:selected").text();

      if (periode == '') {
          swal({
              title               : "Peringatan",
              text                : 'Periode harus terisi dahulu',
              buttonsStyling      : false,
              confirmButtonClass  : "btn btn-warning",
              type                : 'warning'
          });

          return false;
      } else if (jumlah == '' || jumlah == 0) {
          swal({
              title               : "Peringatan",
              text                : 'Jumlah Pengunjung Harus Terisi!',
              buttonsStyling      : false,
              confirmButtonClass  : "btn btn-warning",
              type                : 'warning'
          });

          return false;
      } else {

          // cek provinsi
          $.ajax({
              url     : "Hotel/cek_provinsi",
              type    : "POST",
              data    : {periode:periode,id_hotel:id_hotel, provinsi:provinsi},
              dataType: "JSON",
              success : function (data) {

                  var id_rekap_wisnus_hotel = data.id_rkp_wisnus_hotel;
                  var jml_pengunjung        = data.jml_pengunjung;
                  var add_time              = data.add_time;
                  
                  if (data.cek == 0) {
                      
                      $.ajax({
                          url     : "Hotel/simpan_list",
                          type    : "POST",
                          data    : {periode:periode, pria:pria, wanita:wanita, jumlah:jumlah, provinsi:provinsi, id_hotel:id_hotel, jenis_data:'wisnus'},
                          dataType: "JSON",
                          success : function (data) {
                              swal({
                                  title               : "Berhasil",
                                  text                : 'Data berhasil ditambahkan',
                                  buttonsStyling      : false,
                                  confirmButtonClass  : "btn btn-success",
                                  type                : 'success'
                              });    

                              tabel_list_input_wisnus.ajax.reload(null, false);                   

                              $('#tp').text(data.tot_pria);
                              $('#tw').text(data.tot_wanita);
                              $('#tj').text(data.tot_jumlah);

                              $('#pria').val('');
                              $('#wanita').val('');
                              $('#jumlah').val('');

                              $('#provinsi').html(data.provinsi);

                              $('#simpan_list_wisnus_hotel').removeAttr('hidden');
                          }
                      })

                      return false;
                      
                  } else {
                      
                      swal({
                            title       : 'Konfirmasi',
                            html        : "Data Wisatawan dari provinsi "+nm_provinsi+" tanggal "+periode+" terakhir diinput "+add_time+"<br> Sejumlah <b>"+jml_pengunjung+" Pengunjung</b><br><br><b>Apakah data saat ini untuk menggantikan data sebelumnya atau menambahkan jumlah data sebelumnya?</b>",
                            type        : 'warning',

                            buttonsStyling      : false,
                            confirmButtonClass  : "btn btn-success",
                            cancelButtonClass   : "btn btn-danger mr-1",

                            showCancelButton    : true,
                            confirmButtonText   : 'Mengganti data sebelumnya',
                            confirmButtonColor  : '#3085d6',
                            cancelButtonColor   : '#d33',
                            cancelButtonText    : 'menambahkan jumlah data',
                            reverseButtons      : true
                      }).then((result) => {
                          if (result.value) {
                              $.ajax({
                                  url         : "Hotel/simpan_list",
                                  method      : "POST",
                                  data        : {periode:periode, pria:pria, wanita:wanita, jumlah:jumlah, provinsi:provinsi, id_hotel:id_hotel, id_rekap_wisnus_hotel:id_rekap_wisnus_hotel, aksi:'tambah_baru', jenis_data:'wisnus'},
                                  dataType    : "JSON",
                                  success     : function (data) {
                                      tabel_list_input_wisnus.ajax.reload(null, false);

                                      swal({
                                          title               : "Berhasil",
                                          text                : 'Data berhasil ditambahkan',
                                          buttonsStyling      : false,
                                          confirmButtonClass  : "btn btn-success",
                                          type                : 'success'
                                      });    

                                      $('#tp').text(data.tot_pria);
                                      $('#tw').text(data.tot_wanita);
                                      $('#tj').text(data.tot_jumlah);

                                      $('#pria').val('');
                                      $('#wanita').val('');
                                      $('#jumlah').val('');

                                      $('#provinsi').html(data.provinsi);

                                      $('#simpan_list_wisnus_hotel').removeAttr('hidden');

                                  },
                                  error       : function(xhr, status, error) {
                                      var err = eval("(" + xhr.responseText + ")");
                                      alert(err.Message);
                                  }

                              })

                              return false;

                          } else if (result.dismiss === swal.DismissReason.cancel) {
                              
                              $.ajax({
                                  url         : "Hotel/simpan_list",
                                  method      : "POST",
                                  data        : {periode:periode, pria:pria, wanita:wanita, jumlah:jumlah, provinsi:provinsi, id_hotel:id_hotel, id_rekap_wisnus_hotel:id_rekap_wisnus_hotel, aksi:'ubah_jumlah_data', jenis_data:'wisnus'},
                                  dataType    : "JSON",
                                  success     : function (data) {
                                      tabel_list_input_wisnus.ajax.reload(null, false);

                                      swal({
                                          title               : "Berhasil",
                                          text                : 'Data berhasil ditambahkan',
                                          buttonsStyling      : false,
                                          confirmButtonClass  : "btn btn-success",
                                          type                : 'success'
                                      });    

                                      $('#tp').text(data.tot_pria);
                                      $('#tw').text(data.tot_wanita);
                                      $('#tj').text(data.tot_jumlah);

                                      $('#pria').val('');
                                      $('#wanita').val('');
                                      $('#jumlah').val('');

                                      $('#provinsi').html(data.provinsi);

                                      $('#simpan_list_wisnus_hotel').removeAttr('hidden');

                                  },
                                  error       : function(xhr, status, error) {
                                      var err = eval("(" + xhr.responseText + ")");
                                      alert(err.Message);
                                  }

                              })

                              return false;
                              
                          }
                      })

                      return false;

                  }

              }
          })

          return false;

      }
  })

  // hitung jumlah pria
  $('#pria').on('keyup', function () {
      
      var a = $(this).val();
      var b = $('#wanita').val();

      var c = +a + +b;

      $('#jumlah').val(c);

  })

  // hitung jumlah wanita
  $('#wanita').on('keyup', function () {
      
      var a = $(this).val();
      var b = $('#pria').val();

      var c = +a + +b;

      $('#jumlah').val(c);

  })

  // wisman

  $('#loading_negara').hide();
  
  // menampilkan list negara
  $('#kawasan').change(function () {
    var id_kawasan  = $(this).find('option:selected').val();
    var aksi        = $(this).attr('data');
    var periode     = $('#periode_h_wisman').val();
    var id_hotel      = $('#id_hotel').val();

    $('#negara').next('.select2-container').hide();
    $('#loading_negara').show();

    $.ajax({
        url         : "Hotel/ambil_negara",
        type        : "POST",
        beforeSend 	: function (e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charshet=UTF-8");
            }				
        },
        data        : {id_kawasan:id_kawasan, aksi:aksi, periode:periode, id_hotel:id_hotel},
        dataType    : "JSON",
        success     : function (data) {
            $('#loading_negara').hide();
            $('#negara').next('.select2-container').show();

            if (data.ds != 'aktif') {
                $('#negara').attr('disabled', true);
            } else {
                $('#negara').removeAttr('disabled');
            }

            $('#negara').html(data.negara);
        },
        error 		: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    })
  })

  // menampilkan data
  var tabel_list_input_wisman = $('#tabel_list_input_wisman').DataTable({
    "processing"    : true,
    "dom"           : "t",
    "ajax"          : {
        "url"   : "Hotel/tampil_list_hotel_wisman",
        "type"  : "POST",
        "data"  : function (data) {
            data.periode   = $('#periode_h_wisman').val();
            data.id_hotel    = $('#id_hotel').val();
        }
    },
    stateSave       : true,
    "order"         : [ [0, 'asc']],
    "columnDefs"        : [{
        "targets"   : [3,4,5],
        "className" : 'text-center'
    }, {
        "targets"   : [6],
        "orderable" : false
    }]
  });

  // ubah data
  $('#tabel_list_input_wisman').on('click', '.ubah-hotel-wisman', function () {
            
    var id_rekap_wisman_hotel = $(this).data('id');

    $.ajax({
        url     : "Hotel/tampil_data_ubah_hotel_wisman",
        type    : "POST",
        data    : {id_rekap_wisman_hotel:id_rekap_wisman_hotel},
        dataType: "JSON",
        success : function (data) { 

            $('#pria_wisman').val(data.pria);
            $('#wanita_wisman').val(data.wanita);
            $('#jumlah_wisman').val(data.jumlah);
            $('#kawasan').next('.select2-container').hide();
            $('#nm_kawasan').removeAttr('hidden');
            $('#nm_kawasan').attr('disabled', true);
            $('#nm_kawasan').val(data.nm_kawasan);

            $('#negara').next('.select2-container').hide();
            $('#nm_negara').removeAttr('hidden');
            $('#nm_negara').attr('disabled', true);
            $('#nm_negara').val(data.nm_negara);

            $('#id_rekap_wisman').val(data.id_rekap);
            $('#periode_h_wisman').attr('disabled', true);

            $('.ubah-hotel-wisman').attr('disabled', true);
            $('.hapus-hotel-wisman').attr('disabled', true);
            $('#simpan_list_wisman_hotel').attr('disabled', true);

            $('#tambah_hotel_wisman').attr('hidden', true);
            $('#ubah_hotel_wisman').removeAttr('hidden');
            $('#cancel_hotel_wisman').removeAttr('hidden');
            
        }
    })

    return false;

  })

  // hapus data list hotel
  $('#tabel_list_input_wisman').on('click', '.hapus-hotel-wisman', function () {
      
      var id_rekap_wisman_hotel = $(this).data('id');
      var periode             = $('#periode_h_wisman').val();
      var id_hotel              = $('#id_hotel').val();

      swal({
          title       : 'Konfirmasi',
          text        : 'Yakin akan hapus data',
          type        : 'warning',

          buttonsStyling      : false,
          confirmButtonClass  : "btn btn-danger",
          cancelButtonClass   : "btn btn-warning mr-3",

          showCancelButton    : true,
          confirmButtonText   : 'Hapus',
          confirmButtonColor  : '#3085d6',
          cancelButtonColor   : '#d33',
          cancelButtonText    : 'Tidak',
          reverseButtons      : true
      }).then((result) => {
          if (result.value) {
              $.ajax({
                  url     : "Hotel/simpan_ubah_hapus_list_wisman",
                  type    : "POST",
                  data    : {id_rekap:id_rekap_wisman_hotel, periode:periode, id_hotel:id_hotel, aksi:'hapus'},
                  dataType: "JSON",
                  success : function (data) {
                      swal({
                          title               : "Berhasil",
                          text                : 'Data berhasil dihapus',
                          buttonsStyling      : false,
                          confirmButtonClass  : "btn btn-success",
                          type                : 'success'
                      });    

                      tabel_list_input_wisman.ajax.reload(null,false);                   

                      $('#tp_wisman').text(data.tot_pria);
                      $('#tw_wisman').text(data.tot_wanita);
                      $('#tj_wisman').text(data.tot_jumlah);

                      $('#pria_wisman').val('');
                      $('#wanita_wisman').val('');
                      $('#jumlah_wisman').val('');

                      $('#kawasan').attr('data', 'cari_negara');

                      $('#kawasan').select2('val', 'x');
                      $('#negara').select2('val', 'x');
                      $('#negara').attr('disabled', true);

                      if (data.tot_jumlah == null) {
                          $('#simpan_list_wisman_hotel').attr('hidden', true);
                      } else {
                          $('#simpan_list_wisman_hotel').removeAttr('hidden');
                      }
                  }
              })

              return false;

          } else if (result.dismiss === swal.DismissReason.cancel) {

              swal({
                  title               : "Batal",
                  text                : 'Anda membatalkan hapus data',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-info",
                  type                : 'error'
              }); 
          }
      })

      return false;

  })

  // cancel ubah data hotel
  $('#cancel_hotel_wisman').on('click', function () {  

      $('#pria_wisman').val('');
      $('#wanita_wisman').val('');
      $('#jumlah_wisman').val('');
      $('#tambah_hotel_wisman').removeAttr('hidden');
      $('#ubah_hotel_wisman').attr('hidden', true);
      $('#cancel_hotel_wisman').attr('hidden', true);

      $('.ubah-hotel-wisman').removeAttr('disabled');
      $('.hapus-hotel-wisman').removeAttr('disabled');
      $('#simpan_list_wisman_hotel').removeAttr('disabled');

      $('#kawasan').attr('data', 'cari_negara');
      
      $('#kawasan').next('.select2-container').show();
      $('#nm_kawasan').attr('hidden', true);

      $('#negara').next('.select2-container').show();
      $('#nm_negara').attr('hidden', true);

      $('#kawasan').select2('val', 'x');
      $('#negara').select2('val', 'x');
      $('#negara').attr('disabled', true);

  })

  // ubah data hotel
  $('#ubah_hotel_wisman').on('click', function () {
      
      var id_hotel   = $('#id_hotel').val();
      var periode  = $('#periode_h_wisman').val();
      var id_rekap = $('#id_rekap_wisman').val();
      var pria     = $('#pria_wisman').val();
      var wanita   = $('#wanita_wisman').val();
      var jumlah   = $('#jumlah_wisman').val();

      $.ajax({
          url      : "Hotel/simpan_ubah_hapus_list_wisman",
          type     : "POST",
          data     : {periode:periode, id_hotel:id_hotel, pria:pria, wanita:wanita, jumlah:jumlah, id_rekap:id_rekap, aksi:'ubah'},
          dataType : "JSON",
          success  : function (data) {
              swal({
                  title               : "Berhasil",
                  text                : 'Data berhasil diubah',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-success",
                  type                : 'success'
              });    

              tabel_list_input_wisman.ajax.reload(null, false);                   

              $('#tp_wisman').text(data.tot_pria);
              $('#tw_wisman').text(data.tot_wanita);
              $('#tj_wisman').text(data.tot_jumlah);

              $('#pria_wisman').val('');
              $('#wanita_wisman').val('');
              $('#jumlah_wisman').val('');

              $('#tambah_hotel_wisman').removeAttr('hidden');
              $('#ubah_hotel_wisman').attr('hidden', true);
              $('#cancel_hotel_wisman').attr('hidden', true);

              $('.ubah-hotel-wisman').removeAttr('disabled');
              $('.hapus-hotel-wisman').removeAttr('disabled');
              $('#simpan_list_wisman_hotel').removeAttr('disabled');
              
              $('#kawasan').next('.select2-container').show();
              $('#nm_kawasan').attr('hidden', true);

              $('#negara').next('.select2-container').show();
              $('#nm_negara').attr('hidden', true);

              $('#kawasan').attr('data', 'cari_negara');

              $('#simpan_list_wisman_hotel').removeAttr('hidden');
          }
      })

      return false;

  })

  // proses simpan list wisman hotel
  $('#simpan_list_wisman_hotel').on('click', function () {

      var periode     = $('#periode_h_wisman').val();
      var id_hotel      = $('#id_hotel').val();

      swal({
          title       : 'Konfirmasi',
          text        : 'Yakin akan kirim data',
          type        : 'warning',

          buttonsStyling      : false,
          confirmButtonClass  : "btn btn-info",
          cancelButtonClass   : "btn btn-danger mr-3",

          showCancelButton    : true,
          confirmButtonText   : 'Kirim Data',
          confirmButtonColor  : '#3085d6',
          cancelButtonColor   : '#d33',
          cancelButtonText    : 'Batal',
          reverseButtons      : true
      }).then((result) => {
          if (result.value) {
              $.ajax({
                  url     : "Hotel/simpan_list_wisman_hotel",
                  type    : "POST",
                  data    : {periode:periode, id_hotel:id_hotel},
                  dataType: "JSON",
                  success : function (data) {
                      swal({
                          title               : "Berhasil",
                          text                : 'Data berhasil ditambahkan',
                          buttonsStyling      : false,
                          confirmButtonClass  : "btn btn-success",
                          type                : 'success'
                      });    

                      tabel_list_input_wisman.clear().draw();                   

                      $('#tp_wisman').text('0');
                      $('#tw_wisman').text('0');
                      $('#tj_wisman').text('0');

                      $('#pria_wisman').val('');
                      $('#wanita_wisman').val('');
                      $('#jumlah_wisman').val('');
                      
                      $('#kawasan').removeAttr('data');

                      $('#kawasan').select2('val', 'x');
                      $('#negara').select2('val', 'x');
                      $('#negara').attr('disabled', true);

                      $('#simpan_list_wisman_hotel').attr('hidden', true);
                  }
              })

              return false;

          } else if (result.dismiss === swal.DismissReason.cancel) {

              swal({
                  title               : "Batal",
                  text                : 'Anda membatalkan kirim data',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-info",
                  type                : 'error'
              }); 
          }
      })

      return false;
      
  })

  // proses tambah list status 0
  $('#tambah_hotel_wisman').on('click', function () {

      var periode     = $('#periode_h_wisman').val();
      var pria        = $('#pria_wisman').val();
      var wanita      = $('#wanita_wisman').val();
      var jumlah      = $('#jumlah_wisman').val();
      var negara      = $('#negara').val();
      var id_hotel      = $('#id_hotel').val();

      // mengambil nama negara
      var nm_negara   = $("#negara option:selected").text();

      if (periode == '') {
          swal({
              title               : "Peringatan",
              text                : 'Periode harus terisi dahulu',
              buttonsStyling      : false,
              confirmButtonClass  : "btn btn-warning",
              type                : 'warning'
          });

          return false;
      } else if (negara == 'x') {
          swal({
              title               : "Peringatan",
              text                : 'Negara Harus Terisi!',
              buttonsStyling      : false,
              confirmButtonClass  : "btn btn-warning",
              type                : 'warning'
          });

          return false;
      } else if (jumlah == '' || jumlah == 0) {
          swal({
              title               : "Peringatan",
              text                : 'Jumlah Pengunjung Harus Terisi!',
              buttonsStyling      : false,
              confirmButtonClass  : "btn btn-warning",
              type                : 'warning'
          });

          return false;
      } else {

          // cek negara
          $.ajax({
              url     : "Hotel/cek_negara",
              type    : "POST",
              data    : {periode:periode,id_hotel:id_hotel, negara:negara},
              dataType: "JSON",
              success : function (data) {

                  var id_rekap_wisman_hotel = data.id_rkp_wisman_hotel;
                  var jml_pengunjung        = data.jml_pengunjung;
                  var add_time              = data.add_time;
                  
                  if (data.cek == 0) {
                      
                      $.ajax({
                          url     : "Hotel/simpan_list_wisman",
                          type    : "POST",
                          data    : {periode:periode, pria:pria, wanita:wanita, jumlah:jumlah, negara:negara, id_hotel:id_hotel},
                          dataType: "JSON",
                          success : function (data) {
                              swal({
                                  title               : "Berhasil",
                                  text                : 'Data berhasil ditambahkan',
                                  buttonsStyling      : false,
                                  confirmButtonClass  : "btn btn-success",
                                  type                : 'success'
                              });    

                              tabel_list_input_wisman.ajax.reload(null, false);                   

                              $('#tp_wisman').text(data.tot_pria);
                              $('#tw_wisman').text(data.tot_wanita);
                              $('#tj_wisman').text(data.tot_jumlah);

                              $('#pria_wisman').val('');
                              $('#wanita_wisman').val('');
                              $('#jumlah_wisman').val('');

                              $('#kawasan').select2('val', 'x');
                              $('#negara').select2('val', 'x');
                              $('#negara').attr('disabled', true);

                              $('#kawasan').attr('data', 'cari_negara');

                              $('#simpan_list_wisman_hotel').removeAttr('hidden');
                          }
                      })

                      return false;
                      
                  } else {
                      
                      swal({
                            title       : 'Konfirmasi',
                            html        : "Data Wisatawan dari negara "+nm_negara+" tanggal "+periode+" terakhir diinput "+add_time+"<br> Sejumlah <b>"+jml_pengunjung+" Pengunjung</b><br><br><b>Apakah data saat ini untuk menggantikan data sebelumnya atau menambahkan jumlah data sebelumnya?</b>",
                            type        : 'warning',

                            buttonsStyling      : false,
                            confirmButtonClass  : "btn btn-success",
                            cancelButtonClass   : "btn btn-danger mr-1",

                            showCancelButton    : true,
                            confirmButtonText   : 'Mengganti data sebelumnya',
                            confirmButtonColor  : '#3085d6',
                            cancelButtonColor   : '#d33',
                            cancelButtonText    : 'menambahkan jumlah data',
                            reverseButtons      : true
                      }).then((result) => {
                          if (result.value) {
                              $.ajax({
                                  url         : "Hotel/simpan_list_wisman",
                                  method      : "POST",
                                  data        : {periode:periode, pria:pria, wanita:wanita, jumlah:jumlah, negara:negara, id_hotel:id_hotel, id_rekap_wisman_hotel:id_rekap_wisman_hotel, aksi:'tambah_baru'},
                                  dataType    : "JSON",
                                  success     : function (data) {
                                      tabel_list_input_wisman.ajax.reload(null, false);

                                      swal({
                                          title               : "Berhasil",
                                          text                : 'Data berhasil ditambahkan',
                                          buttonsStyling      : false,
                                          confirmButtonClass  : "btn btn-success",
                                          type                : 'success'
                                      });    

                                      $('#tp_wisman').text(data.tot_pria);
                                      $('#tw_wisman').text(data.tot_wanita);
                                      $('#tj_wisman').text(data.tot_jumlah);

                                      $('#pria_wisman').val('');
                                      $('#wanita_wisman').val('');
                                      $('#jumlah_wisman').val('');

                                      $('#kawasan').select2('val', 'x');
                                      $('#negara').select2('val', 'x');
                                      $('#negara').attr('disabled', true);

                                      $('#kawasan').attr('data', 'cari_negara');

                                      $('#simpan_list_wisman_hotel').removeAttr('hidden');

                                  },
                                  error       : function(xhr, status, error) {
                                      var err = eval("(" + xhr.responseText + ")");
                                      alert(err.Message);
                                  }

                              })

                              return false;

                          } else if (result.dismiss === swal.DismissReason.cancel) {
                              
                              $.ajax({
                                  url         : "Hotel/simpan_list_wisman",
                                  method      : "POST",
                                  data        : {periode:periode, pria:pria, wanita:wanita, jumlah:jumlah, negara:negara, id_hotel:id_hotel, id_rekap_wisman_hotel:id_rekap_wisman_hotel, aksi:'ubah_jumlah_data'},
                                  dataType    : "JSON",
                                  success     : function (data) {
                                      tabel_list_input_wisman.ajax.reload(null, false);

                                      swal({
                                          title               : "Berhasil",
                                          text                : 'Data berhasil ditambahkan',
                                          buttonsStyling      : false,
                                          confirmButtonClass  : "btn btn-success",
                                          type                : 'success'
                                      });    

                                      $('#tp_wisman').text(data.tot_pria);
                                      $('#tw_wisman').text(data.tot_wanita);
                                      $('#tj_wisman').text(data.tot_jumlah);

                                      $('#pria_wisman').val('');
                                      $('#wanita_wisman').val('');
                                      $('#jumlah_wisman').val('');

                                      $('#kawasan').select2('val', 'x');
                                      $('#negara').select2('val', 'x');
                                      $('#negara').attr('disabled', true);

                                      $('#kawasan').attr('data', 'cari_negara');

                                      $('#simpan_list_wisman_hotel').removeAttr('hidden');

                                  },
                                  error       : function(xhr, status, error) {
                                      var err = eval("(" + xhr.responseText + ")");
                                      alert(err.Message);
                                  }

                              })

                              return false;
                              
                          }
                      })

                      return false;

                  }

              }
          })

          return false;

      }
  })

  // hitung jumlah pria
  $('#pria_wisman').on('keyup', function () {
      
      var a = $(this).val();
      var b = $('#wanita_wisman').val();

      var c = +a + +b;

      $('#jumlah_wisman').val(c);

  })

  // hitung jumlah wanita
  $('#wanita_wisman').on('keyup', function () {
      
      var a = $(this).val();
      var b = $('#pria_wisman').val();

      var c = +a + +b;

      $('#jumlah_wisman').val(c);

  })

})


