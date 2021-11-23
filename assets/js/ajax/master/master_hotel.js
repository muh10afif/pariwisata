$(document).ready(function() {

    // 18-02-2020

    // menampilkan list kota
    var tabel_kota_hotel = $('#tabel_kota_hotel').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "Hotel/tampil_kota_hotel",
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

    // menampilkan list hotel
    var base_url = $('#base_url').val();

    var tabel_list_hotel = $('#tabel_list_hotel').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : base_url+"Master/Hotel/tampil_list_hotel",
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

    // aksi simpan data hotel
    $('#simpan_hotel').on('click', function () {

        var form_hotel = $('#form-hotel').serialize();
        var nama_hotel = $('#nama_hotel').val();

        if (nama_hotel == '') {
            swal({
                title               : "Peringatan",
                text                : 'Nama Hotel harus terisi!',
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
                        url     : base_url+"Master/Hotel/simpan_data_hotel",
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
                        data    : form_hotel,
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
            
                            tabel_list_hotel.ajax.reload(null,false);        
                            
                            $('#form-hotel').trigger("reset");
                            $('[name="status"]').select2('val', '1');

                            $('#batal_hotel').attr('hidden', true);

                            $('.hapus-hotel').removeAttr('disabled');
            
                        }
                    })
            
                    return false;
    
                } else if (result.dismiss === swal.DismissReason.cancel) {
    
                    swal({
                        title               : "Batal",
                        text                : 'Anda membatalkan simpan data',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error'
                    }); 
                }
            })
    
            return false;
        
        }
        
    })

    // edit data hotel
    $('#tabel_list_hotel').on('click', '.edit-hotel', function () {

        $('.hapus-hotel').attr('disabled', true);
        
        var id_hotel  = $(this).data('id');

        $.ajax({
            url         : base_url+"Master/Hotel/ambil_data_hotel/"+id_hotel,
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
                
                $('#id_hotel').val(data.id_hotel);
                $('#nama_hotel').val(data.nama_hotel);
                $('#alamat').val(data.alamat);
                $('#lat').val(data.lat);
                $('#long').val(data.long);
                $('#email').val(data.email);
                $('#no_hp').val(data.no_hp);
                $('#status').select2("val", data.status);

                $('#aksi').val('Ubah');
                $('#batal_hotel').removeAttr('hidden');
     
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
         })

         return false;

    })

    // aksi batal hotel
    $('#batal_hotel').on('click', function () {
        $('#form-hotel').trigger("reset");
        $('[name="status"]').select2('val', '1');
        $(this).attr('hidden', true);

        $('#aksi').val('Tambah');
        $('.hapus-hotel').removeAttr('disabled');
    })

    // hapus jabatan
    $('#tabel_list_hotel').on('click', '.hapus-hotel', function () {
          
        var id_hotel = $(this).data('id');

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
                      url         : base_url+"Master/Hotel/simpan_data_hotel",
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
                      data        : {aksi:'Hapus', id_hotel:id_hotel},
                      dataType    : "JSON",
                      success     : function (data) {

                          tabel_list_hotel.ajax.reload(null, false);

                            swal({
                                title               : 'Hapus Hotel',
                                text                : 'Data Berhasil Dihapus',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            }); 

                            $('#form-hotel').trigger("reset");
                            $('[name="status"]').select2('val', '1');

                            $('#batal_hotel').attr('hidden', true);

                            $('.hapus-hotel').removeAttr('disabled');
                          
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
                        text                : 'Anda membatalkan hapus Hotel',
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

    $('#btn-link1').hide();

    // menampilkan data dtw 
    var tbl_hotel = $('#tbl_hotel').DataTable({
        "processing"    : true,
        'ajax'          : 'Hotel/tampil_hotel',
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

    // show_hotel()
    //   $('#tbl_hotel').DataTable({
    //     language: {
    //       search: "_INPUT_",
    //       searchPlaceholder: "Search records",
    //     }
    //   });


    //   function show_hotel() {
    //   	$('#btn-link1').hide()
    //   	$.ajax({
    //             type  : 'ajax',
    //             url   : 'Hotel/json_prov',
    //             async : false,
    //             dataType : 'json',
    //             success : function(data){
    //                 var html = '';
    //                 var i;
    //                 for(i=0; i<data.length; i++){
    //                     if (data[i].status == 1) {
    //                         var sts = '<span class="badge badge-success">active</span>'
    //                     }
    //                     else{
    //                     	var sts = '<span class="badge badge-danger">non active</span>'
    //                     }
    //                     html += '<tr>'+
    //                             '<td>'+(i+1)+'</td>'+
    //                             '<td>'+data[i].nama_hotel+'</td>'+
    //                             '<td>'+data[i].nama_kota+'</td>'+
    //                             '<td>'+data[i].alamat+'</td>'+
    //                             '<td>'+data[i].lat+'</td>'+
    //                             '<td>'+data[i].long+'</td>'+
    //                             '<td>'+data[i].email+'</td>'+
    //                             '<td>'+data[i].no_hp+'</td>'+
    //                             '<td>'+sts+'</td>'+
    //                             '<td class="text-center">'+
    //                                 '<button  class="btn btn-info btn-sm btn-link edit"  rel="tooltip" data-original-title="Edit Data" data="'+data[i].id_hotel+'" ><i class="fa fa-edit"></i></button>'+' '+
    //                                 '<button  class="btn btn-danger btn-sm btn-link hapus" rel="tooltip" data-original-title="Hapus Data" data="'+data[i].id_hotel+'" ><i class="fa fa-trash"></i></button>'+
    //                                 ''
    //                             '</td>'+
    //                             '</tr>';
    //                 }
    //                 $('#data-hotel').html(html);
    //             }
 
    //         });
    //     }

       $("#btn-link2").on('click',function(){
       		$('#btn-link1').show();
       		$(this).hide();
       		
       })

        $("#btn-link1").on('click',function(){
       		$(this).hide();
       		$('#btn-link2').show();
       })
          //button-simpan
        $('#s-hotel').on('click',function(){
            var hotel =$('#hotel').val();
            var kota = $('#kota').val();
            var alamat = $('#alamat').val();
            var lat = $('#lat').val();
            var long = $('#long').val();
            var email = $('#email').val();
            var no_hp = $('#no_hp').val();
            var status= $('#status').val();
            $.ajax({
                type : "POST",
                url  : "Hotel/simpan",
                dataType : "JSON",
                data : {hotel:hotel,kota:kota,alamat:alamat,lat:lat,long:long,email:email,no_hp:no_hp,status:status},
                success: function(data){
                    $('#hotel').val("");
                    $('#kota').val("");
                    $('#alamat').val("");
                    $('#lat').val("");
                    $('#long').val("");
                    $('#email').val("");
                    $('#no_hp').val("");
                    $('#status').val("");
                    $('#modal-add').modal('hide');
                    tbl_hotel.ajax.reload(null,false)
                    $('#btn-link1').show();
                    Swal.fire('Data Berhasil Disimpan!','','success');
                }
            });
            return false;
        });

        //GET HAPUS
        $('#data-hotel').on('click','.hapus',function() {
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
                url   : 'Hotel/hapus',
                async : false,
                data : {id:id},
                dataType : 'json',
                success : function(data){
                tbl_hotel.ajax.reload(null,false)
                $('#btn-link2').show();
                Swal.fire('Data Berhasil Dihapus!','','success');    
                }
            });
           }
         })
        });

    $('#data-hotel').on('click','.edit',function(){
            var id=$(this).attr('data');
            $.ajax({
                type : "POST",
                url  : "Hotel/edit",
                dataType : "JSON",
                data : {id:id},
                success: function(data){
                  $('#id2').val(data.id_hotel);  
                  $('#hotel2').val(data.nama_hotel);
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
            var hotel =$('#hotel2').val();
            var kota = $('#kota2').val();
            var alamat = $('#alamat2').val();
            var lat = $('#lat2').val();
            var long = $('#long2').val();
            var email = $('#email2').val();
            var no_hp = $('#no_hp2').val();
            var status= $('#status2').val();
            $.ajax({
                type : "POST",
                url  : "Hotel/update",
                dataType : "JSON",
                data : {id:id,hotel:hotel,kota:kota,alamat:alamat,lat:lat,long:long,email:email,no_hp:no_hp,status:status},
                success: function(data){
                    $('#id2').val("");
                    $('#hotel2').val("");
                    $('#kota2').val("");
                    $('#alamat2').val("");
                    $('#lat2').val("");
                    $('#long2').val("");
                    $('#email2').val("");
                    $('#no_hp2').val("");
                    $('#status2').val("");
                    $('#modal-edit').modal('hide');
                    tbl_hotel.ajax.reload(null,false)
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