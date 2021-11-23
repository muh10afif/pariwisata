$(document).ready(function(){

  $('#loading_negara').hide();

  // menampilkan data tabel list kelolaan dtw
  var tbl_dtw = $('#tbl_dtw').DataTable({
      "processing"    : true,
      'ajax'          : {
          'url'   : 'Dtw/tampil_dtw',
          'type'  : 'POST',
          "data"  : function (data) {
              data.periode    = $('#periode_dtw').val();
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
  $('#periode_dtw').on('change', function () {

      var periode   = $(this).val();
      var per_awal  = $('#per_awal').val();

    $.ajax({
        url     : "Dtw/ambil_periode",
        type    : "POST",
        data    : {periode:periode},
        dataType: "JSON",
        success : function (data) {                  

            tbl_dtw.ajax.reload(null, false);

            $('#periode_dtw').val(data.periode);
      
            if (periode == '') {
                $('#periode_dtw').val(per_awal)
            }
            
        }
    })

    return false;

  })

  // saat klik input data
  $('#tbl_dtw').on('click','.input-dtw',function(){

      var dtw     = $(this).attr('nm-dtw');
      var id_dtw  = $(this).attr('data-id');
      var tgl_per = $(this).attr('tgl-periode');

    $.ajax({
        url     : "Dtw/simpan_list",
        type    : "POST",
        data    : {periode:tgl_per, id_dtw:id_dtw, data:'lihat', jenis_data:'wisnus'},
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
            $('.label_dtw').text('Nama DTW : '+dtw);
            $('#id_dtw').val(id_dtw);
            $('#periode').val(tgl_per);
            $('#periode_h_wisman').val(tgl_per);

            $('#kawasan').attr('data', 'cari_negara');

            if (data.tot_jumlah == null) {
                $('#simpan_list_wisnus_dtw').attr('hidden', true);
            } else {
                $('#simpan_list_wisnus_dtw').removeAttr('hidden');
            }

            tabel_list_input_wisnus.ajax.reload(null, false); 
            tabel_list_input_wisman.ajax.reload(null, false); 
            
        }
    })

    return false;

  })

  // saat klik tab wisman
  $('#wisman').on('click',function() {

    var id_dtw  = $('#id_dtw').val();
    var tgl_per = $('#periode_h_wisman').val();

    $.ajax({
      url     : "Dtw/simpan_list",
      type    : "POST",
      data    : {periode:tgl_per, id_dtw:id_dtw, data:'lihat', jenis_data:'wisman'},
      dataType: "JSON",
      success : function (data) {                  

          $('#tp_wisman').text(data.tot_pria);
          $('#tw_wisman').text(data.tot_wanita);
          $('#tj_wisman').text(data.tot_jumlah);

          $('#tab-wisman').removeAttr('hidden');
          $('#tab-wisnus').attr('hidden', true);

          $('#kawasan').attr('data', 'cari_negara');

          if (data.tot_jumlah == null) {
              $('#simpan_list_wisman_dtw').attr('hidden', true);
          } else {
              $('#simpan_list_wisman_dtw').removeAttr('hidden');
          }

          tabel_list_input_wisman.ajax.reload(null, false); 
          
      }
    })

  })

  // saat klik tab wisnus
  $('#wisnus').on('click',function() {

    var id_dtw  = $('#id_dtw').val();
    var tgl_per = $('#periode').val();

    $.ajax({
      url     : "Dtw/simpan_list",
      type    : "POST",
      data    : {periode:tgl_per, id_dtw:id_dtw, data:'lihat', jenis_data:'wisnus'},
      dataType: "JSON",
      success : function (data) {                  

          $('#tp').text(data.tot_pria);
          $('#tw').text(data.tot_wanita);
          $('#tj').text(data.tot_jumlah);

          $('#tab-wisnus').removeAttr('hidden');
          $('#tab-wisman').attr('hidden', true);

          $('#provinsi').html(data.provinsi);

          if (data.tot_jumlah == null) {
              $('#simpan_list_wisnus_dtw').attr('hidden', true);
          } else {
              $('#simpan_list_wisnus_dtw').removeAttr('hidden');
          }

          tabel_list_input_wisnus.ajax.reload(null, false); 
          
      }
    })
  })

  // wisnus

  // menampilkan data
  var tabel_list_input_wisnus = $('#tabel_list_input_wisnus').DataTable({
    "processing"    : true,
    "dom"           : "t",
    "ajax"          : {
        "url"   : "Dtw/tampil_list_dtw",
        "type"  : "POST",
        "data"  : function (data) {
            data.periode   = $('#periode').val();
            data.id_dtw    = $('#id_dtw').val();
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
  $('#tabel_list_input_wisnus').on('click', '.ubah-dtw', function () {
      
      var id_rekap_wisnus_dtw = $(this).data('id');

      $.ajax({
          url     : "Dtw/tampil_data_ubah_dtw",
          type    : "POST",
          data    : {id_rekap_wisnus_dtw:id_rekap_wisnus_dtw},
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

              $('.ubah-dtw').attr('disabled', true);
              $('.hapus-dtw').attr('disabled', true);
              $('#simpan_list_wisnus_dtw').attr('disabled', true);

              $('#tambah_dtw').attr('hidden', true);
              $('#ubah_dtw').removeAttr('hidden');
              $('#cancel_dtw').removeAttr('hidden');
              
          }
      })

      return false;

  })

  // hapus data list dtw
  $('#tabel_list_input_wisnus').on('click', '.hapus-dtw', function () {
      
      var id_rekap_wisnus_dtw = $(this).data('id');
      var periode             = $('#periode').val();
      var id_dtw              = $('#id_dtw').val();

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
                  url     : "Dtw/simpan_ubah_hapus_list",
                  type    : "POST",
                  data    : {id_rekap:id_rekap_wisnus_dtw, periode:periode, id_dtw:id_dtw, aksi:'hapus'},
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

                      $('#simpan_list_wisnus_dtw').removeAttr('hidden');
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

  // cancel ubah data dtw
  $('#cancel_dtw').on('click', function () {

      var periode     = $('#periode').val();
      var id_dtw      = $('#id_dtw').val();

      $.ajax({
          url     : "Dtw/ambil_option_provinsi",
          type    : "POST",
          data    : {periode:periode, id_dtw:id_dtw},
          dataType: "JSON",
          success : function (data) {      

              $('#pria').val('');
              $('#wanita').val('');
              $('#jumlah').val('');
              $('#tambah_dtw').removeAttr('hidden');
              $('#ubah_dtw').attr('hidden', true);
              $('#cancel_dtw').attr('hidden', true);

              $('.ubah-dtw').removeAttr('disabled');
              $('.hapus-dtw').removeAttr('disabled');
              $('#simpan_list_wisnus_dtw').removeAttr('disabled');
              
              $('#provinsi').next('.select2-container').show();
              $('#nm_provinsi').attr('hidden', true);
              $('#provinsi').html(data.provinsi);

          }
      })

      return false;

  })

  // ubah data dtw
  $('#ubah_dtw').on('click', function () {
      
      var id_dtw   = $('#id_dtw').val();
      var periode  = $('#periode').val();
      var id_rekap = $('#id_rekap').val();
      var pria     = $('#pria').val();
      var wanita   = $('#wanita').val();
      var jumlah   = $('#jumlah').val();

      $.ajax({
          url      : "Dtw/simpan_ubah_hapus_list",
          type     : "POST",
          data     : {periode:periode, id_dtw:id_dtw, pria:pria, wanita:wanita, jumlah:jumlah, id_rekap:id_rekap, aksi:'ubah'},
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

              $('#tambah_dtw').removeAttr('hidden');
              $('#ubah_dtw').attr('hidden', true);
              $('#cancel_dtw').attr('hidden', true);

              $('.ubah-dtw').removeAttr('disabled');
              $('.hapus-dtw').removeAttr('disabled');
              $('#simpan_list_wisnus_dtw').removeAttr('disabled');
              
              $('#provinsi').next('.select2-container').show();
              $('#nm_provinsi').attr('hidden', true);
              $('#provinsi').html(data.provinsi);

              $('#simpan_list_wisnus_dtw').removeAttr('hidden');
          }
      })

      return false;

  })

  // proses simpan list wisnus dtw
  $('#simpan_list_wisnus_dtw').on('click', function () {

      var periode     = $('#periode').val();
      var id_dtw      = $('#id_dtw').val();

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
                  url     : "Dtw/simpan_list_wisnus_dtw",
                  type    : "POST",
                  data    : {periode:periode, id_dtw:id_dtw},
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
                      
                      $('#provinsi').html(data.provinsi);

                      $('#simpan_list_wisnus_dtw').attr('hidden', true);
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
  $('#tambah_dtw').on('click', function () {

      var periode     = $('#periode').val();
      var pria        = $('#pria').val();
      var wanita      = $('#wanita').val();
      var jumlah      = $('#jumlah').val();
      var provinsi    = $('#provinsi').val();
      var id_dtw      = $('#id_dtw').val();
    
    // mengambil nama provinsi
    var nm_provinsi   = $("#provinsi option:selected").text();

    console.log(nm_provinsi);

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
              url     : "Dtw/cek_provinsi",
              type    : "POST",
              data    : {periode:periode,id_dtw:id_dtw, provinsi:provinsi},
              dataType: "JSON",
              success : function (data) {

                  var id_rekap_wisnus_dtw = data.id_rkp_wisnus_dtw;
                  var jml_pengunjung      = data.jml_pengunjung;
                  var add_time            = data.add_time;
                  
                  if (data.cek == 0) {
                      
                      $.ajax({
                          url     : "Dtw/simpan_list",
                          type    : "POST",
                          data    : {periode:periode, pria:pria, wanita:wanita, jumlah:jumlah, provinsi:provinsi, id_dtw:id_dtw, jenis_data:'wisnus'},
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

                              $('#simpan_list_wisnus_dtw').removeAttr('hidden');
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
                                  url         : "Dtw/simpan_list",
                                  method      : "POST",
                                  data        : {periode:periode, pria:pria, wanita:wanita, jumlah:jumlah, provinsi:provinsi, id_dtw:id_dtw, id_rekap_wisnus_dtw:id_rekap_wisnus_dtw, aksi:'tambah_baru', jenis_data:'wisnus'},
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

                                      $('#simpan_list_wisnus_dtw').removeAttr('hidden');

                                  },
                                  error       : function(xhr, status, error) {
                                      var err = eval("(" + xhr.responseText + ")");
                                      alert(err.Message);
                                  }

                              })

                              return false;

                          } else if (result.dismiss === swal.DismissReason.cancel) {
                              
                              $.ajax({
                                  url         : "Dtw/simpan_list",
                                  method      : "POST",
                                  data        : {periode:periode, pria:pria, wanita:wanita, jumlah:jumlah, provinsi:provinsi, id_dtw:id_dtw, id_rekap_wisnus_dtw:id_rekap_wisnus_dtw, aksi:'ubah_jumlah_data', jenis_data:'wisnus'},
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

                                      $('#simpan_list_wisnus_dtw').removeAttr('hidden');

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

  // menampilkan list negara
  $('#kawasan').change(function () {
    var id_kawasan  = $(this).find('option:selected').val();
    var aksi        = $(this).attr('data');
    var periode     = $('#periode_h_wisman').val();
    var id_dtw      = $('#id_dtw').val();

    $('#negara').next('.select2-container').hide();
    $('#loading_negara').show();

    $.ajax({
        url         : "Dtw/ambil_negara",
        type        : "POST",
        beforeSend 	: function (e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charshet=UTF-8");
            }				
        },
        data        : {id_kawasan:id_kawasan, aksi:aksi, periode:periode, id_dtw:id_dtw},
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
        "url"   : "Dtw/tampil_list_dtw_wisman",
        "type"  : "POST",
        "data"  : function (data) {
            data.periode   = $('#periode_h_wisman').val();
            data.id_dtw    = $('#id_dtw').val();
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
  $('#tabel_list_input_wisman').on('click', '.ubah-dtw-wisman', function () {
            
    var id_rekap_wisman_dtw = $(this).data('id');

    $.ajax({
        url     : "Dtw/tampil_data_ubah_dtw_wisman",
        type    : "POST",
        data    : {id_rekap_wisman_dtw:id_rekap_wisman_dtw},
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

            $('.ubah-dtw-wisman').attr('disabled', true);
            $('.hapus-dtw-wisman').attr('disabled', true);
            $('#simpan_list_wisman_dtw').attr('disabled', true);

            $('#tambah_dtw_wisman').attr('hidden', true);
            $('#ubah_dtw_wisman').removeAttr('hidden');
            $('#cancel_dtw_wisman').removeAttr('hidden');
            
        }
    })

    return false;

    })

// hapus data list dtw
$('#tabel_list_input_wisman').on('click', '.hapus-dtw-wisman', function () {
    
    var id_rekap_wisman_dtw = $(this).data('id');
    var periode             = $('#periode_h_wisman').val();
    var id_dtw              = $('#id_dtw').val();

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
                url     : "Dtw/simpan_ubah_hapus_list_wisman",
                type    : "POST",
                data    : {id_rekap:id_rekap_wisman_dtw, periode:periode, id_dtw:id_dtw, aksi:'hapus'},
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
                        $('#simpan_list_wisman_dtw').attr('hidden', true);
                    } else {
                        $('#simpan_list_wisman_dtw').removeAttr('hidden');
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

// cancel ubah data dtw
$('#cancel_dtw_wisman').on('click', function () {  

    $('#pria_wisman').val('');
    $('#wanita_wisman').val('');
    $('#jumlah_wisman').val('');
    $('#tambah_dtw_wisman').removeAttr('hidden');
    $('#ubah_dtw_wisman').attr('hidden', true);
    $('#cancel_dtw_wisman').attr('hidden', true);

    $('.ubah-dtw-wisman').removeAttr('disabled');
    $('.hapus-dtw-wisman').removeAttr('disabled');
    $('#simpan_list_wisman_dtw').removeAttr('disabled');

    $('#kawasan').attr('data', 'cari_negara');
    
    $('#kawasan').next('.select2-container').show();
    $('#nm_kawasan').attr('hidden', true);

    $('#negara').next('.select2-container').show();
    $('#nm_negara').attr('hidden', true);

    $('#kawasan').select2('val', 'x');
    $('#negara').select2('val', 'x');
    $('#negara').attr('disabled', true);

})

// ubah data dtw
$('#ubah_dtw_wisman').on('click', function () {
    
    var id_dtw   = $('#id_dtw').val();
    var periode  = $('#periode_h_wisman').val();
    var id_rekap = $('#id_rekap_wisman').val();
    var pria     = $('#pria_wisman').val();
    var wanita   = $('#wanita_wisman').val();
    var jumlah   = $('#jumlah_wisman').val();

    $.ajax({
        url      : "Dtw/simpan_ubah_hapus_list_wisman",
        type     : "POST",
        data     : {periode:periode, id_dtw:id_dtw, pria:pria, wanita:wanita, jumlah:jumlah, id_rekap:id_rekap, aksi:'ubah'},
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

            $('#tambah_dtw_wisman').removeAttr('hidden');
            $('#ubah_dtw_wisman').attr('hidden', true);
            $('#cancel_dtw_wisman').attr('hidden', true);

            $('.ubah-dtw-wisman').removeAttr('disabled');
            $('.hapus-dtw-wisman').removeAttr('disabled');
            $('#simpan_list_wisman_dtw').removeAttr('disabled');
            
            $('#kawasan').next('.select2-container').show();
            $('#nm_kawasan').attr('hidden', true);

            $('#negara').next('.select2-container').show();
            $('#nm_negara').attr('hidden', true);

            $('#kawasan').attr('data', 'cari_negara');

            $('#simpan_list_wisman_dtw').removeAttr('hidden');
        }
    })

    return false;

})

// proses simpan list wisman dtw
$('#simpan_list_wisman_dtw').on('click', function () {

    var periode     = $('#periode_h_wisman').val();
    var id_dtw      = $('#id_dtw').val();

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
                url     : "Dtw/simpan_list_wisman_dtw",
                type    : "POST",
                data    : {periode:periode, id_dtw:id_dtw},
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

                    $('#simpan_list_wisman_dtw').attr('hidden', true);
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
$('#tambah_dtw_wisman').on('click', function () {

    var periode     = $('#periode_h_wisman').val();
    var pria        = $('#pria_wisman').val();
    var wanita      = $('#wanita_wisman').val();
    var jumlah      = $('#jumlah_wisman').val();
    var negara      = $('#negara').val();
    var id_dtw      = $('#id_dtw').val();

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
            url     : "Dtw/cek_negara",
            type    : "POST",
            data    : {periode:periode,id_dtw:id_dtw, negara:negara},
            dataType: "JSON",
            success : function (data) {

                var id_rekap_wisman_dtw = data.id_rkp_wisman_dtw;
                var jml_pengunjung      = data.jml_pengunjung;
                var add_time            = data.add_time;
                
                if (data.cek == 0) {
                    
                    $.ajax({
                        url     : "Dtw/simpan_list_wisman",
                        type    : "POST",
                        data    : {periode:periode, pria:pria, wanita:wanita, jumlah:jumlah, negara:negara, id_dtw:id_dtw},
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

                            $('#simpan_list_wisman_dtw').removeAttr('hidden');
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
                                url         : "Dtw/simpan_list_wisman",
                                method      : "POST",
                                data        : {periode:periode, pria:pria, wanita:wanita, jumlah:jumlah, negara:negara, id_dtw:id_dtw, id_rekap_wisman_dtw:id_rekap_wisman_dtw, aksi:'tambah_baru'},
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

                                    $('#simpan_list_wisman_dtw').removeAttr('hidden');

                                },
                                error       : function(xhr, status, error) {
                                    var err = eval("(" + xhr.responseText + ")");
                                    alert(err.Message);
                                }

                            })

                            return false;

                        } else if (result.dismiss === swal.DismissReason.cancel) {
                            
                            $.ajax({
                                url         : "Dtw/simpan_list_wisman",
                                method      : "POST",
                                data        : {periode:periode, pria:pria, wanita:wanita, jumlah:jumlah, negara:negara, id_dtw:id_dtw, id_rekap_wisman_dtw:id_rekap_wisman_dtw, aksi:'ubah_jumlah_data'},
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

                                    $('#simpan_list_wisman_dtw').removeAttr('hidden');

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

  $('#btn-back').on('click',function() {
    $('a[href="#menu1"]').tab('show');   
    
    tbl_dtw.ajax.reload(null, false);
  })
})