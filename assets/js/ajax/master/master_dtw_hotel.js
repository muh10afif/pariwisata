$(document).ready(function () {

    // dataTables tabel_dtw_hotel
    var tabel_dtw_hotel = $('#tabel_dtw_hotel').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "Dtw_hotel_kota/tampil_data_dtw_hotel",
            "type"  : "POST"
        },

            "columnDefs"        : [{
                "targets"   : [0,4],
                "orderable" : false
            }, {
                'targets'   : [0,2,3,4],
                'className' : 'text-center',
            }]

    })

    var base_url = $('#base_url').val();

    var tabel_list_dtw = $('#tabel_list_dtw').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : base_url+"Master/Dtw_hotel_kota/tampil_list_dtw",
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

    var tabel_list_hotel = $('#tabel_list_hotel').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : base_url+"Master/Dtw_hotel_kota/tampil_list_hotel",
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

    $('#tabel_dtw_hotel').on('click', '.tambah-data', function () {
        var id_kota = $(this).data('id');
        
        $.ajax({
            url         : "Dtw_hotel_kota/form_detail_kota",
            type        : "POST",
            data        : {id_kota:id_kota},
            success     : function (data) {
                swal.close();

                $('.detail-kota').html(data);
                $('.detail-kota').removeAttr('hidden');

                $('.list-kota').hide();
            }
        })

    })

    $('#btn-list-dtw').on('click', function () { 
        
        $('#judul').text('List DTW');
        $(this).attr('hidden', true);
        $('#btn-list-hotel').show();

    })

    $('#btn-list-hotel').on('click', function () {
        
        $('#judul').text('List Hotel');
        $(this).hide();
        $('#btn-list-dtw').removeAttr('hidden');

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
                        url     : base_url+"Master/Dtw_hotel_kota/simpan_data_dtw_hotel",
                        type    : "POST",
                        data    : form_dtw,
                        dataType: "JSON",
                        success : function (data) {

                            console.log(data);
                            
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
                        url     : base_url+"Master/Dtw_hotel_kota/simpan_data_dtw_hotel",
                        type    : "POST",
                        data    : form_hotel,
                        dataType: "JSON",
                        success : function (data) {

                            console.log(data);
                            
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

    // edit data dtw
    $('#tabel_list_dtw').on('click', '.edit-dtw', function () {
        
        var id_dtw  = $(this).data('id');

        $.ajax({
            url : base_url+"Master/Dtw_hotel_kota/ambil_data_dtw_hotel/dtw/"+id_dtw,
            type: "GET",
            dataType: "JSON",
            success: function(data)
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
    })

    // aksi batal hotel
    $('#batal_hotel').on('click', function () {
        $('#form-hotel').trigger("reset");
        $('[name="status"]').select2('val', '1');
        $(this).attr('hidden', true);
    })

    // edit data hotel
    $('#tabel_list_hotel').on('click', '.edit-hotel', function () {
        
        var id_hotel = $(this).data('id');

        $.ajax({
            url : base_url+"Master/Dtw_hotel_kota/ambil_data_dtw_hotel/hotel/"+id_hotel,
            type: "GET",
            dataType: "JSON",
            success: function(data)
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

                $('#aksi_hotel').val('Ubah');
                $('#batal_hotel').removeAttr('hidden');
     
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
         })

         return false;

    })

    // hapus data dtw
    $('#tabel_list_dtw').on('click', '.hapus-dtw', function () {
        
        var id_dtw = $(this).data('id');

    })

    // hapus data hotel
    $('#tabel_list_hotel').on('click', '.hapus-hotel', function () {
        
        var id_hotel = $(this).data('id');

    })


})