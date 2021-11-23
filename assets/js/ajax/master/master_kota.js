$(document).ready(function() {

    // 19-02-2020

    // menampilkan list kota
    var tabel_list_kota = $('#tabel_master_kota').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "Kota/tampil_data_kota",
            "type"  : "POST"
        },

            "columnDefs"        : [{
                "targets"   : [0,3],
                "orderable" : false
            }, {
                'targets'   : [0,3],
                'className' : 'text-center',
            }]

    })

    // aksi simpan data kota
    $('#simpan_kota').on('click', function () {

        var form_kota = $('#form-kota').serialize();
        var nama_kota = $('#kota').val();
        var provinsi  = $('#provinsi').val();

        if (nama_kota == '') {
            swal({
                title               : "Peringatan",
                text                : 'Nama Kota harus terisi!',
                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-success",
                type                : 'warning',
                showConfirmButton   : false,
                timer               : 1000
            }); 

            return false;
        } else if (provinsi == ' ') {
            swal({
                title               : "Peringatan",
                text                : 'Provinsi harus terisi!',
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
                        url     : "Kota/simpan_data_kota",
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
                        data    : form_kota,
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
            
                            tabel_list_kota.ajax.reload(null,false);        
                            
                            $('#form-kota').trigger("reset");
                            $('#provinsi').select2("val", ' ');

                            $('#batal_kota').attr('hidden', true);

                            $('.hapus-kota').removeAttr('disabled');
            
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

    // aksi batal dtw
    $('#batal_kota').on('click', function () {

        $('#form-kota').trigger("reset");
        $('#batal_kota').attr('hidden', true);

        $('#provinsi').select2("val", ' ');

        $('#aksi').val('Tambah');
        $('.hapus-kota').removeAttr('disabled');
    })

    // edit data kota
    $('#tabel_master_kota').on('click', '.edit-kota', function () {

        $('.hapus-kota').attr('disabled', true);
        
        var id_kota  = $(this).data('id');

        $.ajax({
            url         : "Kota/ambil_data_kota/"+id_kota,
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
                
                $('#id_kota').val(data.id_kota);
                $('#kota').val(data.nama_kota);
                $('#provinsi').val(data.id_provinsi).trigger('change.select2');

                $('#aksi').val('Ubah');
                $('#batal_kota').removeAttr('hidden');

                $('#kota').attr('autofocus', true);

                return false;
     
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
         })

         return false;

    })

    // hapus kota
    $('#tabel_master_kota').on('click', '.hapus-kota', function () {
          
        var id_kota = $(this).data('id');

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
                      url         : "Kota/simpan_data_kota",
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
                      data        : {aksi:'Hapus', id_kota:id_kota},
                      dataType    : "JSON",
                      success     : function (data) {

                            tabel_list_kota.ajax.reload(null,false);   

                            swal({
                                title               : 'Hapus Kota',
                                text                : 'Data Berhasil Dihapus',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            }); 

                                 
                            
                            $('#form-kota').trigger("reset");

                            $('#batal_kota').attr('hidden', true);

                            $('.hapus-kota').removeAttr('disabled');
                          
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
                        text                : 'Anda membatalkan hapus kota',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 1000
                    }); 
              }
          })

    })

    // Akhir 19-02-2020

    $("body").tooltip({
        selector: '[rel="tooltip"]'
    });

    // menampilkan data kota 
    var tbl_kota = $('#tbl_kota').DataTable({
        "processing"    : true,
        'ajax'          : 'Kota/tampil_kota',
        stateSave       : true,
        "order"         : [],
        'columnDefs'    : [{
            'targets'   : [2],
            'orderable' : false,
        }, {
            'targets'   : [0,2],
            'className' : 'text-center',
        }],

    });

    // show_kota()
    // $('#tbl_kota').DataTable({
    //     language: {
    //     search: "_INPUT_",
    //     searchPlaceholder: "Search records",
    //     }
    // });

    // function show_kota() {
    // $.ajax({
    //         type  : 'ajax',
    //         url   : 'Kota/json',
    //         async : false,
    //         dataType : 'json',
    //         success : function(data){
    //             var html = '';
    //             var i;
    //             for(i=0; i<data.length; i++){
    //                 html += '<tr>'+
    //                         '<td class="text-center">'+(i+1)+'.</td>'+
    //                         '<td>'+data[i].nama_kota+'</td>'+
    //                         '<td class="text-center">'+
    //                         '<button  class="btn btn-info btn-sm btn-link add"  rel="tooltip" data-original-title="Buat User" data="'+data[i].id_kota+'" ><i class="fa fa-plus"></i></button>'+' '+
    //                         '</td>'+
    //                         '</tr>';
    //             }
    //             $('#data-kota').html(html);
    //         }
    //     });
    // }
    
    $('#provinsi').on('change',function(){
        var id_prov  = $(this).val();
        $('#tbl_kota').DataTable().clear().destroy();
        $.ajax({
            type: "POST",
            url: 'Kota/fil_prov',
            data: {id_prov:id_prov},
            dataType: "json",
            success: function (data) {
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<tr>'+
                            '<td>'+(i+1)+'</td>'+
                            '<td>'+data[i].nama_kota+'</td>'+
                            '</tr>';
                }
                $('#data-kota').html(html);
                $('#tbl_kota').DataTable({
                    language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records",
                    }
                });
            }
            })
        });

    $("#btn-link2").on('click',function(){
    $('#btn-link1').show();
    $(this).hide();
    })

    $("#btn-link1").on('click',function(){
    $(this).hide();
    $('#btn-link2').show();
    })

    $('#data-kota').on('click','.add',function(){
        var id=$(this).attr('data');
        $.ajax({
            type : "POST",
            url  : "Kota/buat_user",
            dataType : "JSON",
            data : {id:id},
            success: function(data){
              $('#id2').val(id);
              $('#modal-add').modal('show');
              }
        });
    });

    //button-simpan
    $('#s_user').on('click',function(){
        var username = $('#username').val();
        var password = $('#password').val();
        var id_kota = $('#id2').val();
        var status = $('#status').val();
        $.ajax({
            type: "POST",
            url: "Kota/simpan_users_kota",
            dataType: "JSON",
            data: {
                    id_kota: id_kota,
                    username: username,
                    password: password,
                    status: status
                  },
            success: function (data) {
                if(data == true) {
                    $('#id2').val("");
                    $('#username').val("");
                    $('#password').val("");
                    $('#status').val("");
                    $('#modal-add').modal('hide');
                    tbl_kota.ajax.reload(null, false);
                    Swal.fire('Data Berhasil Disimpan!', '', 'success');
                }
                else{
                    Swal.fire('Data Gagal Disimpan!','','warning');
                }
            }
        });
        return false;
    });

    //GET HAPUS
    $('#data-kota').on('click','.hapus',function() {
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
            url   : 'kota/hapus',
            async : false,
            data : {id:id},
            dataType : 'json',
            success : function(data){
            tbl_kota.ajax.reload(null, false);
            $('#btn-link2').show();
            Swal.fire('Data Berhasil Dihapus!','','success');    
            }
        });
        }
        })
    });

    $('#data-kota').on('click','.edit',function(){
            var id=$(this).attr('data');
            $.ajax({
                type : "POST",
                url  : "kota/edit",
                dataType : "JSON",
                data : {id:id},
                success: function(data){
                  $('#id2').val(data.id_kota);  
                  $('#kota2').val(data.nama_kota);
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
            var kota =$('#kota2').val();
            var kota = $('#kota2').val();
            var alamat = $('#alamat2').val();
            var lat = $('#lat2').val();
            var long = $('#long2').val();
            var email = $('#email2').val();
            var no_hp = $('#no_hp2').val();
            var status= $('#status2').val();
            $.ajax({
                type : "POST",
                url  : "kota/update",
                dataType : "JSON",
                data : {id:id,kota:kota,kota:kota,alamat:alamat,lat:lat,long:long,email:email,no_hp:no_hp,status:status},
                success: function(data){
                    $('#id2').val("");
                    $('#kota2').val("");
                    $('#kota2').val("");
                    $('#alamat2').val("");
                    $('#lat2').val("");
                    $('#long2').val("");
                    $('#email2').val("");
                    $('#no_hp2').val("");
                    $('#status2').val("");
                    $('#modal-edit').modal('hide');
                    tbl_kota.ajax.reload(null, false);
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