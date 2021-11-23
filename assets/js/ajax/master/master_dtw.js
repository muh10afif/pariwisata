$(document).ready(function() {

    // 18-02-2020

    // menampilkan list kota
    var tabel_kota_dtw = $('#tabel_kota_dtw').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "Dtw/tampil_kota_dtw",
            "type"  : "POST"
        },

            "columnDefs"        : [{
                "targets"   : [0,3],
                "orderable" : false
            }, {
                'targets'   : [0,2,3],
                'className' : 'text-center',
            }]

    })

    // menampilkan list dtw
    var base_url = $('#base_url').val();

    var tabel_list_dtw = $('#tabel_list_dtw').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : base_url+"Master/Dtw/tampil_list_dtw",
            "type"  : "POST",
            "data"  : function (data) {
                data.id_kota = $('#id_kota').val();
            }
        },

            "columnDefs"        : [{
                "targets"   : [0,8],
                "orderable" : false
            }, {
                'targets'   : [0,7,8],
                'className' : 'text-center',
            }]

    })

    // aksi simpan data dtw
    $('#simpan_dtw').on('click', function () {

        var form_dtw = $('#form-dtw').serialize();
        var nama_dtw = $('#nama_dtw').val();

        if (nama_dtw == '') {
            swal({
                title               : "Peringatan",
                text                : 'Nama DTW harus terisi!',
                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-success",
                type                : 'warning',
                showConfirmButton   : false,
                timer               : 1000
            }); 

            return false;
        } else {

            swal({
                title       : 'Konfirmasi',
                text        : 'Yakin akan kirim data',
                type        : 'warning',
    
                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-info",
                cancelButtonClass   : "btn btn-warning mr-3",
    
                showCancelButton    : true,
                confirmButtonText   : 'Ya',
                confirmButtonColor  : '#3085d6',
                cancelButtonColor   : '#d33',
                cancelButtonText    : 'Batal',
                reverseButtons      : true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url     : base_url+"Master/Dtw/simpan_data_dtw",
                        type    : "POST",
                        beforeSend  : function () {
                            swal({
                                title   : 'Menunggu',
                                html    : 'Memproses Data',
                                onOpen  : () => {
                                    swal.showLoading();
                                }
                            })
                        },
                        data    : form_dtw,
                        dataType: "JSON",
                        success : function (data) {
                            
                            swal({
                                title               : "Berhasil",
                                text                : 'Data berhasil disimpan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            });    
            
                            tabel_list_dtw.ajax.reload(null,false);        
                            
                            $('#form-dtw').trigger("reset");
                            $('[name="status"]').select2('val', '1');

                            $('#batal_dtw').attr('hidden', true);

                            $('.hapus-dtw').removeAttr('disabled');
            
                        }
                    })
            
                    return false;
    
                } else if (result.dismiss === swal.DismissReason.cancel) {
    
                    swal({
                        title               : "Batal",
                        text                : 'Anda membatalkan simpan data',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 1000
                    }); 
                }
            })
    
            return false;
        
        }
        
    })

    // edit data dtw
    $('#tabel_list_dtw').on('click', '.edit-dtw', function () {

        $('.hapus-dtw').attr('disabled', true);
        
        var id_dtw  = $(this).data('id');

        $.ajax({
            url         : base_url+"Master/Dtw/ambil_data_dtw/"+id_dtw,
            type        : "GET",
            beforeSend  : function () {
                swal({
                    title   : 'Menunggu',
                    html    : 'Memproses Data',
                    onOpen  : () => {
                        swal.showLoading();
                    }
                })
            },
            dataType    : "JSON",
            success     : function(data)
            {
                swal.close();
                
                $('#id_dtw').val(data.id_dtw);
                $('#nama_dtw').val(data.nama_dtw);
                $('#alamat').val(data.alamat);
                $('#lat').val(data.lat);
                $('#long').val(data.long);
                $('#email').val(data.email);
                $('#no_hp').val(data.no_hp);
                $('#status').select2("val", data.status);

                $('#aksi').val('Ubah');
                $('#batal_dtw').removeAttr('hidden');
     
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
         })

         return false;

    })

    // aksi batal dtw
    $('#batal_dtw').on('click', function () {
        $('#form-dtw').trigger("reset");
        $('[name="status"]').select2('val', '1');
        $(this).attr('hidden', true);

        $('#aksi').val('Tambah');
        $('.hapus-dtw').removeAttr('disabled');
    })

    // hapus jabatan
    $('#tabel_list_dtw').on('click', '.hapus-dtw', function () {
          
        var id_dtw = $(this).data('id');

        swal({
              title       : 'Konfirmasi',
              text        : 'Yakin akan hapus data',
              type        : 'warning',

              buttonsStyling      : false,
              confirmButtonClass  : "btn btn-info",
              cancelButtonClass   : "btn btn-danger mr-3",

              showCancelButton    : true,
              confirmButtonText   : 'Hapus',
              confirmButtonColor  : '#d33',
              cancelButtonColor   : '#3085d6',
              cancelButtonText    : 'Batal',
              reverseButtons      : true
          }).then((result) => {
              if (result.value) {
                  $.ajax({
                      url         : base_url+"Master/Dtw/simpan_data_dtw",
                      method      : "POST",
                      beforeSend  : function () {
                          swal({
                              title   : 'Menunggu',
                              html    : 'Memproses Data',
                              onOpen  : () => {
                                  swal.showLoading();
                              }
                          })
                      },
                      data        : {aksi:'Hapus', id_dtw:id_dtw},
                      dataType    : "JSON",
                      success     : function (data) {

                          tabel_list_dtw.ajax.reload(null, false);

                            swal({
                                title               : 'Hapus DTW',
                                text                : 'Data Berhasil Dihapus',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            }); 

                            $('#form-dtw').trigger("reset");
                            $('[name="status"]').select2('val', '1');

                            $('#batal_dtw').attr('hidden', true);

                            $('.hapus-dtw').removeAttr('disabled');
                          
                      },
                      error       : function(xhr, status, error) {
                          var err = eval("(" + xhr.responseText + ")");
                          alert(err.Message);
                      }

                  })

                  return false;
              } else if (result.dismiss === swal.DismissReason.cancel) {

                  swal({
                        title               : 'Batal',
                        text                : 'Anda membatalkan hapus DTW',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 1000
                    }); 
              }
          })

    })

    // Akhir 18-02-2020

    $("body").tooltip({
        selector: '[rel="tooltip"]'
    });

    $('#btn-link1').hide();

    // menampilkan data dtw 
    var tbl_dtw = $('#tbl_dtw').DataTable({
        "processing"    : true,
        'ajax'          : 'Dtw/tampil_dtw',
        stateSave       : true,
        "order"         : [],
        'columnDefs'    : [{
            'targets'   : [8,9],
            'orderable' : false,
        }, {
            'targets'   : [0,8,9],
            'className' : 'text-center',
        }],

    });

    $("#btn-link2").on('click',function(){
        $('#btn-link1').show();
        $(this).hide();
        
    })

    $("#btn-link1").on('click',function(){
        $(this).hide();
        $('#btn-link2').show();
    })
        //button-simpan
    $('#s-dtw').on('click',function(){
        var dtw =$('#dtw').val();
        var kota = $('#kota').val();
        var alamat = $('#alamat').val();
        var lat = $('#lat').val();
        var long = $('#long').val();
        var email = $('#email').val();
        var no_hp = $('#no_hp').val();
        var status= $('#status').val();
        $.ajax({
            type : "POST",
            url  : "Dtw/simpan",
            dataType : "JSON",
            data : {dtw:dtw,kota:kota,alamat:alamat,lat:lat,long:long,email:email,no_hp:no_hp,status:status},
            success: function(data){
                $('#dtw').val("");
                $('#kota').val("");
                $('#alamat').val("");
                $('#lat').val("");
                $('#long').val("");
                $('#email').val("");
                $('#no_hp').val("");
                $('#status').val("");
                $('#modal-add').modal('hide');
                tbl_dtw.ajax.reload(null,false);
                $('#btn-link1').show();
                Swal.fire('Data Berhasil Disimpan!','','success');
            }
        });
        return false;
    });

    //GET HAPUS
    $('#data-dtw').on('click','.hapus',function() {
        var id = $(this).attr('data');
        Swal.fire({
        title: 'Yakin ingin menghapus data ini?',
        text: "data yang sudah dihapus tidak dapat kembali!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'YA!'
    }).then((result) => {
        if (result.value) {
        $.ajax({
            type  : 'POST',
            url   : 'Dtw/hapus',
            async : false,
            data : {id:id},
            dataType : 'json',
            success : function(data){
            tbl_dtw.ajax.reload(null,false);
            $('#btn-link2').show();
            Swal.fire('Data Berhasil Dihapus!','','success');    
            }
        });
        }
        })
    });

    $('#data-dtw').on('click','.edit',function(){
            var id=$(this).attr('data');
            $.ajax({
                type : "POST",
                url  : "Dtw/edit",
                dataType : "JSON",
                data : {id:id},
                success: function(data){
                  $('#id2').val(data.id_dtw);  
                  $('#dtw2').val(data.nama_dtw);
                  $('#kota2').val(data.id_kota).trigger('change');
                  $('#alamat2').val(data.alamat);
                  $('#lat2').val(data.lat);
                  $('#long2').val(data.long);
                  $('#email2').val(data.email);
                  $('#no_hp2').val(data.no_hp);
                  $('#status2').val(data.status);
                  $('#modal-edit').modal('show');
                  }
            });
    });

    $('#b-update').on('click',function() {
            var id =$('#id2').val();
            var dtw =$('#dtw2').val();
            var kota = $('#kota2').val();
            var alamat = $('#alamat2').val();
            var lat = $('#lat2').val();
            var long = $('#long2').val();
            var email = $('#email2').val();
            var no_hp = $('#no_hp2').val();
            var status= $('#status2').val();
            $.ajax({
                type : "POST",
                url  : "Dtw/update",
                dataType : "JSON",
                data : {id:id,dtw:dtw,kota:kota,alamat:alamat,lat:lat,long:long,email:email,no_hp:no_hp,status:status},
                success: function(data){
                    $('#id2').val("");
                    $('#dtw2').val("");
                    $('#kota2').val("");
                    $('#alamat2').val("");
                    $('#lat2').val("");
                    $('#long2').val("");
                    $('#email2').val("");
                    $('#no_hp2').val("");
                    $('#status2').val("");
                    $('#modal-edit').modal('hide');
                    tbl_dtw.ajax.reload(null,false);
                    Swal.fire('Data Berhasil Disimpan!','','success');
                }
            });
            return false;
    })
     
    $('.sel2').select2({
      placeholder: "Pilih Kota",
      allowClear: true
    });

     	
})