$(document).ready(function () {

    // 30-12-2019

    // menampilkan data tabel list kelolaan penempatan
    var tbl_penempatan = $('#tbl_penempatan').DataTable({
        "processing"    : true,
        'ajax'          : {
            'url'   : 'Penempatan/tampil_penempatan',
            'type'  : 'POST',
            "data"  : function (data) {
                data.penempatan = $('#penempatan-add').val();
                data.id_pegawai = $('#petugas').val();
            }
        },
        stateSave       : true,
        "order"         : [],
        'columnDefs'    : [{
            'targets'   : [5],
            'orderable' : false,
        }, {
            'targets'   : [0,4,5],
            'className' : 'text-center',
        }],

    });

    // filter penempatan
    $('#penempatan-add').on('change', function () {
        
        tbl_penempatan.ajax.reload(null, false);

    })

    // filter petugas
    $('#petugas').on('change', function () {

        console.log($(this).val());
        
        tbl_penempatan.ajax.reload(null, false);

    })

    // aksi hapus penempatan 
    $('#data-penempatan').on('click', '.hapus-penempatan', function () {
        
        var id_penempatan = $(this).data('id');
        var nm_tabel      = $(this).attr('nm_tabel');

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
                    url     : "Penempatan/aksi_penempatan",
                    type    : "POST",
                    data    : {id_penempatan:id_penempatan, nm_tabel:nm_tabel, aksi:'hapus'},
                    dataType: "JSON",
                    success : function (data) {
                        swal({
                            title               : "Berhasil",
                            text                : 'Data berhasil dihapus',
                            buttonsStyling      : false,
                            confirmButtonClass  : "btn btn-success",
                            type                : 'success'
                        });    
  
                        tbl_penempatan.ajax.reload(null,false);                   
  
                    }
                })
  
                return false;
  
            } else if (result.dismiss === swal.DismissReason.cancel) {
  
                swal({
                    title               : "Batal",
                    text                : 'Anda membatalkan hapus data',
                    buttonsStyling      : false,
                    confirmButtonClass  : "btn btn-danger",
                    type                : 'error'
                }); 
            }
        })
  
        return false;

    })

    // aksi ubah aktif penempatan 
    $('#data-penempatan').on('click', '.ubah-kembali', function () {
        
        var id_penempatan = $(this).data('id');
        var nm_tabel      = $(this).attr('nm_tabel');
        var penempatan    = $(this).attr('penempatan');
        var id_dtw_hotel  = $(this).attr('id_dtw_hotel');

        $.ajax({
            url     : "Penempatan/cek_penempatan",
            type    : "POST",
            data    : {id_penempatan:id_penempatan, nm_tabel:nm_tabel, penempatan:penempatan, id_dtw_hotel:id_dtw_hotel},
            dataType: "JSON",
            success : function (data) {

                var id_penempatan_sbl = data.id_penempatan;
                
                if (data.cari_p > 0) {

                    swal({
                        title       : 'Konfirmasi',
                        text        : 'Yakin akan aktifkan kembali, hapus kelolaan petugas sebelumnya?',
                        type        : 'warning',
              
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-success",
                        cancelButtonClass   : "btn btn-warning mr-3",
              
                        showCancelButton    : true,
                        confirmButtonText   : 'Ya',
                        confirmButtonColor  : '#d33',
                        cancelButtonColor   : '#3085d6',
                        cancelButtonText    : 'Tidak',
                        reverseButtons      : true
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                url     : "Penempatan/aksi_penempatan",
                                type    : "POST",
                                data    : {id_penempatan:id_penempatan, nm_tabel:nm_tabel, id_penempatan_sbl:id_penempatan_sbl, aksi:'ubah_kembali_hapus'},
                                dataType: "JSON",
                                success : function (data) {
                                    swal({
                                        title               : "Berhasil",
                                        text                : 'Data berhasil diubah',
                                        buttonsStyling      : false,
                                        confirmButtonClass  : "btn btn-success",
                                        type                : 'success'
                                    });    
              
                                    tbl_penempatan.ajax.reload(null,false);                   
              
                                }
                            })
              
                            return false;
              
                        } else if (result.dismiss === swal.DismissReason.cancel) {
              
                            swal({
                                title               : "Batal",
                                text                : 'Anda membatalkan ubah data',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-danger",
                                type                : 'error'
                            }); 
                        }
                    })
              
                    return false;
                    
                } else {

                    swal({
                        title       : 'Konfirmasi',
                        text        : 'Yakin akan aktifkan kembali?',
                        type        : 'warning',
              
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-success",
                        cancelButtonClass   : "btn btn-warning mr-3",
              
                        showCancelButton    : true,
                        confirmButtonText   : 'Ya',
                        confirmButtonColor  : '#d33',
                        cancelButtonColor   : '#3085d6',
                        cancelButtonText    : 'Tidak',
                        reverseButtons      : true
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                url     : "Penempatan/aksi_penempatan",
                                type    : "POST",
                                data    : {id_penempatan:id_penempatan, nm_tabel:nm_tabel, aksi:'ubah_kembali'},
                                dataType: "JSON",
                                success : function (data) {
                                    swal({
                                        title               : "Berhasil",
                                        text                : 'Data berhasil diubah',
                                        buttonsStyling      : false,
                                        confirmButtonClass  : "btn btn-success",
                                        type                : 'success'
                                    });    
              
                                    tbl_penempatan.ajax.reload(null,false);                   
              
                                }
                            })
              
                            return false;
              
                        } else if (result.dismiss === swal.DismissReason.cancel) {
              
                            swal({
                                title               : "Batal",
                                text                : 'Anda membatalkan ubah data',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-danger",
                                type                : 'error'
                            }); 
                        }
                    })
              
                    return false;

                }

            }
        })

        return false;

    })

    // aksi ubah penempatan
    $('#data-penempatan').on('click', '.ubah-penempatan', function () {
        
        var id_penempatan = $(this).data('id');
        var nm_tabel      = $(this).attr('nm_tabel');
        var penempatan    = $(this).attr('penempatan');
        var id_kota       = $(this).attr('id_kota');

        console.log(penempatan);

        $.ajax({
            url     : "Penempatan/ambil_data_penempatan",
            type    : "POST",
            data    : {id_penempatan:id_penempatan, nm_tabel:nm_tabel, penempatan:penempatan, id_kota:id_kota},
            dataType: "JSON",
            success : function (data) {

                if (penempatan == 'dtw') {
                    $('.s_hotel').attr('hidden', true);
                    $('.s_dtw').removeAttr('hidden');
                    $('#select_dtw').html(data.select_p);
                } else {
                    $('.s_dtw').attr('hidden', true);
                    $('.s_hotel').removeAttr('hidden');
                    $('#select_hotel').html(data.select_p);
                }

                $('#nm_petugas').val(data.nm_petugas);
                
                $('#modal_edit_penempatan').modal('show');

                var id_pegawai = data.id_petugas;

                // aksi simpan ubah penempatan
                $('#simpan_penempatan').on('click' , function () {

                    var select = $('#select_'+penempatan).val();
                    
                    if (select == 'a') {
                        swal({
                            title               : "Peringatan",
                            text                : 'Pilih '+penempatan.toUpperCase()+ ' terlebih dahulu',
                            buttonsStyling      : false,
                            confirmButtonClass  : "btn btn-warning",
                            type                : 'warning'
                        });   

                        return false;
                    } else {

                        swal({
                            title       : 'Konfirmasi',
                            text        : 'Yakin akan ubah penempatan?',
                            type        : 'warning',
                  
                            buttonsStyling      : false,
                            confirmButtonClass  : "btn btn-success",
                            cancelButtonClass   : "btn btn-warning mr-3",
                  
                            showCancelButton    : true,
                            confirmButtonText   : 'Ya',
                            confirmButtonColor  : '#d33',
                            cancelButtonColor   : '#3085d6',
                            cancelButtonText    : 'Tidak',
                            reverseButtons      : true
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    url     : "Penempatan/aksi_penempatan",
                                    type    : "POST",
                                    data    : {id_penempatan:id_penempatan, nm_tabel:nm_tabel, penempatan:penempatan, id_hotel_dtw:select, aksi:'ubah'},
                                    dataType: "JSON",
                                    success : function (data) {
                                        swal({
                                            title               : "Berhasil",
                                            text                : 'Data berhasil diubah',
                                            buttonsStyling      : false,
                                            confirmButtonClass  : "btn btn-success",
                                            type                : 'success'
                                        });    

                                        $('#modal_edit_penempatan').modal('hide');
                  
                                        tbl_penempatan.ajax.reload(null,false);                   
                  
                                    }
                                })
                  
                                return false;
                  
                            } else if (result.dismiss === swal.DismissReason.cancel) {
                  
                                swal({
                                    title               : "Batal",
                                    text                : 'Anda membatalkan kirim data',
                                    buttonsStyling      : false,
                                    confirmButtonClass  : "btn btn-danger",
                                    type                : 'error'
                                }); 
                            }
                        })
                  
                        return false;

                    }

                })

            }
        })

        return false;

    })

    // menampilkan data tabel list kelolaan penempatan
    var tbl_penempatan_add = $('#tbl_penempatan_add').DataTable({
        "processing"    : true,
        'ajax'          : 'Penempatan/tampil_penempatan_tambah',
        stateSave       : true,
        "order"         : [],
        'columnDefs'    : [{
            'targets'   : [1],
            'orderable' : false,
        }, {
            'targets'   : [0,1],
            'className' : 'text-center',
        }],

    });

    // tombol tambah
    $("#btn-add").on('click', function () {
        $('[href="#link2"]').tab('show');
        $('#petugas_add').select2('val', " ");
        $('#fil_penempatan').select2('val', " ");

        tbl_penempatan_add.ajax.reload(null, false);
        // tbl_penempatan_add.clear().draw();

        tbl_penempatan_add.search( '' ).columns().search( '' ).draw();
    })

    // tombol kembali
    $('#btn-back').on('click', function () {
        $('a[href="#link1"]').tab('show');
        $('#penempatan-add').select2('val', " ");
        $('#petugas').select2('val', " ");

        tbl_penempatan.ajax.reload(null, false);
    })

    // filter penempatan pada halaman tambah penempatan
    $('#fil_penempatan').on('change', function () {
        i=$(this).find(':selected').val()
        $("#tbl_penempatan_add").DataTable().columns(2).search(i).draw();
    });

    $('#simpan_tambah_penempatan').on('click', function () {
        
        var id_petugas      = $('#petugas_add').val();
        var penempatan      = $('#fil_penempatan').val();
        var id_dtw_hotel    = $('input[name="id_jenis[]"]:checked').map(function () {
            return this.value;
        }).get();

        if (id_petugas == '') {
            swal({
                title               : "Peringatan",
                text                : 'Nama petugas harus terisi dahulu',
                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-warning",
                type                : 'warning'
            });
  
            return false;
        } else if (penempatan == '') {
            swal({
                title               : "Peringatan",
                text                : 'Jenis penempatan harus terisi dahulu',
                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-warning",
                type                : 'warning'
            });
  
            return false;
        } else if (id_dtw_hotel == '') {
            swal({
                title               : "Peringatan",
                text                : 'Harap pilih dahulu tempat penempatan',
                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-warning",
                type                : 'warning'
            });
  
            return false;
        } else {

            swal({
                title       : 'Konfirmasi',
                text        : 'Yakin akan kirim data',
                type        : 'warning',
      
                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-success",
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
                        url         : "Penempatan/simpan_tambah_penempatan",
                        method      : "POST",
                        data        : {id_petugas:id_petugas, penempatan:penempatan, id_dtw_hotel:id_dtw_hotel},
                        dataType    : "JSON",
                        success     : function (data) {
                            tbl_penempatan_add.ajax.reload(null, false);
                            tbl_penempatan.ajax.reload(null, false);
        
                            swal({
                                title               : "Berhasil",
                                text                : 'Data berhasil ditambahkan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success'
                            });    
        
                            $('a[href="#link1"]').tab('show');
        
                        },
                        error       : function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            alert(err.Message);
                        }
        
                    })
        
                    return false;
      
                } else if (result.dismiss === swal.DismissReason.cancel) {
      
                    swal({
                        title               : "Batal",
                        text                : 'Anda membatalkan kirim data',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-danger",
                        type                : 'error'
                    }); 
                }
            })
      
            return false;

        }


    })

    // Akhir 30-12-2019

    $('.sel2').select2({
        placeholder: "Pilih Kota / Kabupaten",
        allowClear:true
    });

    $('.sel2pn').select2({
        placeholder: "Pilih Tempat Penempatan",
        allowClear:true
    });

    $('.sel2p').select2({
        placeholder: "Pilih Petugas",
        allowClear:true
    });

    $('#kota').on('change', function () {
    i=$(this).find(':selected').val()
    $("#tbl_penempatan").DataTable().columns(1).search(i).draw();
    });

    $('#submit').on('click',function(){
        var penempatan = $('#fil_penempatan').val();
        var users = $("form,input[type='checkbox']").serialize();
        console.log(penempatan);
        if(penempatan == 'DTW'){
            $.ajax({
                type: "POST",
                url: "Penempatan/simpan_dtw",
                data: users,
                dataType: "json",
                success: function (data) {
                    Swal.fire('Data Berhasil Disimpan!','','success');
                    data_penempatan();
                }
            });
        }
        else{
            $.ajax({
                type: "POST",
                url: "Penempatan/simpan_hotel",
                data: users,
                dataType: "json",
                success: function (data) {
                    Swal.fire('Data Berhasil Disimpan!','','success');
                    data_penempatan();
                }
            });
        }
       
    })

})