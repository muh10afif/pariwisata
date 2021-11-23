$(document).ready(function () {

    // 19-02-2020

    /***************************/
    /********* USER KOTA *******/
    /***************************/

    // menampilkan list kota
    var tabel_user_kota = $('#tabel_user_kota').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "Kota/tampil_user_kota",
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

    $('.form-checkbox').click(function(){
        if($(this).is(':checked')){
            $('.password').attr('type','text');
        }else{
            $('.password').attr('type','password');
        }
    });

    $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");

        var input = $($(this).attr("toggle"));

        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    // aksi simpan data user kota
    $('#simpan_kota').on('click', function () {

        var form_kota   = $('#form-kota').serialize();
        var kota        = $('#kota').val();
        var username    = $('#username').val();
        var password    = $('#password').val();
        var aksi        = $('#aksi').val();

        if (aksi == 'Ubah') {
            password1 = 'isi';
        } else {
            password1 = password;
        }

        if (kota == ' ') {
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

        } else if (username == '') {
            swal({
                title               : "Peringatan",
                text                : 'Username harus terisi!',
                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-success",
                type                : 'warning',
                showConfirmButton   : false,
                timer               : 1000
            }); 

            return false;

        } else if (password1 == '') {
            swal({
                title               : "Peringatan",
                text                : 'Password harus terisi!',
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
                        url     : "kota/simpan_data_user_kota",
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

                            console.log(data.list_kota);
                            
                            swal({
                                title               : "Berhasil",
                                text                : 'Data berhasil disimpan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            });    
            
                            tabel_user_kota.ajax.reload(null,false);        
                            
                            $('#form-kota').trigger("reset");

                            $('#aksi').val('Tambah');

                            $('#kota').html(data.list_kota);

                            $('#batal_kota').attr('hidden', true);

                            $('.hapus-kota').removeAttr('disabled');

                            $('.mark_pass').text('Harap Catat Pasword Anda!!');
            
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
    $('#tabel_user_kota').on('click', '.edit-kota', function () {

        $('.hapus-kota').attr('disabled', true);
        
        var id_user  = $(this).data('id');

        $.ajax({
            url         : "Kota/ambil_data_user_kota/"+id_user,
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

                console.log(data[0].nama_kota);
                
                $('#id_user').val(data.id_user);
                $('#nama_dtw').val(data.nama_dtw);
                $('#username').val(data.username);
                $('#password').val('');
                $('#kota').html(data[0].nama_kota);

                $('#kota').val(data.id_kota).trigger('change.select2');

                $('#aksi').val('Ubah');
                $('#batal_kota').removeAttr('hidden');

                $('.mark_pass').text('Isi password bila ingin ganti password !!');
     
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
         })

         return false;

    })

    // aksi batal dtw
    $('#batal_kota').on('click', function () {

        $.ajax({
            url     : "Kota/ambil_list_kota",
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
            dataType: "JSON",
            success : function (data) {

                swal.close();

                $('#form-kota').trigger("reset");
                $('#batal_kota').attr('hidden', true);

                $('#kota').html(data.list_kota);

                $('#aksi').val('Tambah');
                $('.hapus-kota').removeAttr('disabled');

                $('.mark_pass').text('Harap Catat Pasword Anda!!');

            }
        })

        return false;
    })

    // hapus jabatan
    $('#tabel_user_kota').on('click', '.hapus-kota', function () {
          
        var id_user = $(this).data('id');

        swal({
              title       : 'Konfirmasi',
              text        : 'Yakin akan hapus data',
              type        : 'warning',

              buttonsStyling      : false,
              confirmButtonClass  : "btn btn-danger",
              cancelButtonClass   : "btn btn-info mr-3",

              showCancelButton    : true,
              confirmButtonText   : 'Hapus',
              confirmButtonColor  : '#d33',
              cancelButtonColor   : '#3085d6',
              cancelButtonText    : 'Batal',
              reverseButtons      : true
          }).then((result) => {
              if (result.value) {
                  $.ajax({
                      url         : "Kota/simpan_data_user_kota",
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
                      data        : {aksi:'Hapus', id_user:id_user},
                      dataType    : "JSON",
                      success     : function (data) {

                          tabel_user_kota.ajax.reload(null, false);

                            swal({
                                title               : 'Hapus user kota',
                                text                : 'Data Berhasil Dihapus',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            }); 

                            $('#form-kota').trigger("reset");

                            $('#kota').html(data.list_kota);

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
                        text                : 'Anda membatalkan hapus user kota',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 1000
                    }); 
              }
          })

    })

    /***************************/
    /********* USER DTW ********/
    /***************************/

    // menampilkan list kota
    var tabel_user_dtw = $('#tabel_user_dtw').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "Dtw/tampil_kota_dtw",
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

    // menampilkan list dtw
    var base_url = $('#base_url').val();

    var tabel_list_dtw = $('#tabel_list_dtw').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : base_url+"Users/Dtw/tampil_list_dtw",
            "type"  : "POST",
            "data"  : function (data) {
                data.id_kota = $('#id_kota').val();
            }
        },

        "columnDefs"        : [{
            "targets"   : [0,4],
            "orderable" : false
        }, {
            'targets'   : [0,4],
            'className' : 'text-center',
        }]

    })

    // aksi simpan data user dtw
    $('#simpan_dtw').on('click', function () {

        var form_dtw    = $('#form-dtw').serialize();
        var dtw         = $('#dtw').val();
        var username    = $('#username').val();
        var password    = $('#password').val();
        var aksi        = $('#aksi').val();

        if (aksi == 'Ubah') {
            password1 = 'isi';
        } else {
            password1 = password;
        }

        if (dtw == ' ') {
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

        } else if (username == '') {
            swal({
                title               : "Peringatan",
                text                : 'Username harus terisi!',
                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-success",
                type                : 'warning',
                showConfirmButton   : false,
                timer               : 1000
            }); 

            return false;

        } else if (password1 == '') {
            swal({
                title               : "Peringatan",
                text                : 'Password harus terisi!',
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
                        url     : base_url+"Users/Dtw/simpan_data_user_dtw",
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

                            console.log(data.list_dtw);
                            
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

                            $('#aksi').val('Tambah');

                            $('#dtw').html(data.list_dtw);

                            $('#batal_dtw').attr('hidden', true);

                            $('.hapus-dtw').removeAttr('disabled');

                            $('.mark_pass').text('Harap Catat Pasword Anda!!');

                            if (data.jml_dtw == 0) {
                                $('#form-dtw').attr('hidden', true);
                            } else {
                                $('#form-dtw').removeAttr('hidden');
                            }
            
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
        
        var id_user  = $(this).data('id');
        var id_kota  = $('#id_kota').val();

        $.ajax({
            url         : base_url+"Users/Dtw/ambil_data_user_dtw/"+id_user,
            type        : "POST",
            beforeSend  : function () {
                swal({
                    title   : 'Menunggu',
                    html    : 'Memproses Data',
                    onOpen  : () => {
                        swal.showLoading();
                    }
                })
            },
            data        : {id_kota:id_kota},
            dataType    : "JSON",
            success     : function(data)
            {
                swal.close();

                console.log(data[0].nama_dtw);
                
                $('#id_user').val(data.id_user);
                $('#username').val(data.username);
                $('#password').val('');
                $('#dtw').html(data[0].nama_dtw);

                $('#dtw').val(data.id_dtw).trigger('change.select2');

                $('#aksi').val('Ubah');
                $('#batal_dtw').removeAttr('hidden');

                $('.mark_pass').text('Isi password bila ingin ganti password !!');

                if (data.jml_dtw == 0) {
                    $('#form-dtw').attr('hidden', true);
                } else {
                    $('#form-dtw').removeAttr('hidden');
                }
     
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

        var id_kota = $('#id_kota').val();

        $.ajax({
            url     : base_url+"Users/Dtw/ambil_list_dtw/"+id_kota,
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
            dataType: "JSON",
            success : function (data) {

                swal.close();

                $('#form-dtw').trigger("reset");
                $('#batal_dtw').attr('hidden', true);

                $('#dtw').html(data.list_dtw);

                $('#aksi').val('Tambah');
                $('.hapus-dtw').removeAttr('disabled');

                $('.mark_pass').text('Harap Catat Pasword Anda!!');

                if (data.jml_dtw == 0) {
                    $('#form-dtw').attr('hidden', true);
                } else {
                    $('#form-dtw').removeAttr('hidden');
                }

            }
        })

        return false;
    })

    // hapus jabatan
    $('#tabel_list_dtw').on('click', '.hapus-dtw', function () {
          
        var id_user = $(this).data('id');
        var id_kota = $('#id_kota').val();

        swal({
              title       : 'Konfirmasi',
              text        : 'Yakin akan hapus data',
              type        : 'warning',

              buttonsStyling      : false,
              confirmButtonClass  : "btn btn-danger",
              cancelButtonClass   : "btn btn-info mr-3",

              showCancelButton    : true,
              confirmButtonText   : 'Hapus',
              confirmButtonColor  : '#d33',
              cancelButtonColor   : '#3085d6',
              cancelButtonText    : 'Batal',
              reverseButtons      : true
          }).then((result) => {
              if (result.value) {
                  $.ajax({
                      url         : base_url+"Users/Dtw/simpan_data_user_dtw",
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
                      data        : {aksi:'Hapus', id_user:id_user, id_kota:id_kota},
                      dataType    : "JSON",
                      success     : function (data) {

                            tabel_list_dtw.ajax.reload(null, false);

                            swal({
                                title               : 'Hapus user dtw',
                                text                : 'Data Berhasil Dihapus',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            }); 

                            $('#form-dtw').trigger("reset");

                            $('#dtw').html(data.list_dtw);

                            $('#batal_dtw').attr('hidden', true);

                            $('.hapus-dtw').removeAttr('disabled');

                            if (data.jml_dtw == 0) {
                                $('#form-dtw').attr('hidden', true);
                            } else {
                                $('#form-dtw').removeAttr('hidden');
                            }
                          
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
                        text                : 'Anda membatalkan hapus user dtw',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 1000
                    }); 
              }
          })

    })

    /***************************/
    /********* USER Hotel ********/
    /***************************/

    // menampilkan list kota
    var tabel_user_hotel = $('#tabel_user_hotel').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "Hotel/tampil_kota_hotel",
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

    // menampilkan list hotel
    var base_url = $('#base_url').val();

    var tabel_list_hotel = $('#tabel_list_hotel').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : base_url+"Users/Hotel/tampil_list_hotel",
            "type"  : "POST",
            "data"  : function (data) {
                data.id_kota = $('#id_kota').val();
            }
        },

        "columnDefs"        : [{
            "targets"   : [0,4],
            "orderable" : false
        }, {
            'targets'   : [0,4],
            'className' : 'text-center',
        }]

    })

    // aksi simpan data user hotel
    $('#simpan_hotel').on('click', function () {

        var form_hotel  = $('#form-hotel').serialize();
        var hotel       = $('#hotel').val();
        var username    = $('#username').val();
        var password    = $('#password').val();
        var aksi        = $('#aksi').val();

        if (aksi == 'Ubah') {
            password1 = 'isi';
        } else {
            password1 = password;
        }

        if (hotel == ' ') {
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

        } else if (username == '') {
            swal({
                title               : "Peringatan",
                text                : 'Username harus terisi!',
                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-success",
                type                : 'warning',
                showConfirmButton   : false,
                timer               : 1000
            }); 

            return false;

        } else if (password1 == '') {
            swal({
                title               : "Peringatan",
                text                : 'Password harus terisi!',
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
                        url     : base_url+"Users/Hotel/simpan_data_user_hotel",
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

                            $('#aksi').val('Tambah');

                            $('#hotel').html(data.list_hotel);

                            $('#batal_hotel').attr('hidden', true);

                            $('.hapus-hotel').removeAttr('disabled');

                            $('.mark_pass').text('Harap Catat Pasword Anda!!');

                            if (data.jml_hotel == 0) {
                                $('#form-hotel').attr('hidden', true);
                            } else {
                                $('#form-hotel').removeAttr('hidden');
                            }
            
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

    // edit data hotel
    $('#tabel_list_hotel').on('click', '.edit-hotel', function () {

        $('.hapus-hotel').attr('disabled', true);
        
        var id_user  = $(this).data('id');
        var id_kota  = $('#id_kota').val();

        $.ajax({
            url         : base_url+"Users/Hotel/ambil_data_user_hotel/"+id_user,
            type        : "POST",
            beforeSend  : function () {
                swal({
                    title   : 'Menunggu',
                    html    : 'Memproses Data',
                    onOpen  : () => {
                        swal.showLoading();
                    }
                })
            },
            data        : {id_kota:id_kota},
            dataType    : "JSON",
            success     : function(data)
            {
                swal.close();

                console.log(data[0].nama_hotel);
                
                $('#id_user').val(data.id_user);
                $('#username').val(data.username);
                $('#password').val('');
                $('#hotel').html(data[0].nama_hotel);

                $('#hotel').val(data.id_hotel).trigger('change.select2');

                $('#aksi').val('Ubah');
                $('#batal_hotel').removeAttr('hidden');

                $('.mark_pass').text('Isi password bila ingin ganti password !!');

                if (data.jml_hotel == 0) {
                    $('#form-hotel').attr('hidden', true);
                } else {
                    $('#form-hotel').removeAttr('hidden');
                }
        
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

        var id_kota = $('#id_kota').val();

        $.ajax({
            url     : base_url+"Users/Hotel/ambil_list_hotel/"+id_kota,
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
            dataType: "JSON",
            success : function (data) {

                swal.close();

                $('#form-hotel').trigger("reset");
                $('#batal_hotel').attr('hidden', true);

                $('#hotel').html(data.list_hotel);

                $('#aksi').val('Tambah');
                $('.hapus-hotel').removeAttr('disabled');

                $('.mark_pass').text('Harap Catat Pasword Anda!!');

                if (data.jml_hotel == 0) {
                    $('#form-hotel').attr('hidden', true);
                } else {
                    $('#form-hotel').removeAttr('hidden');
                }

            }
        })

        return false;
    })

    // hapus jabatan
    $('#tabel_list_hotel').on('click', '.hapus-hotel', function () {
            
        var id_user = $(this).data('id');
        var id_kota = $('#id_kota').val();

        swal({
                title       : 'Konfirmasi',
                text        : 'Yakin akan hapus data',
                type        : 'warning',

                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-danger",
                cancelButtonClass   : "btn btn-info mr-3",

                showCancelButton    : true,
                confirmButtonText   : 'Hapus',
                confirmButtonColor  : '#d33',
                cancelButtonColor   : '#3085d6',
                cancelButtonText    : 'Batal',
                reverseButtons      : true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url         : base_url+"Users/Hotel/simpan_data_user_hotel",
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
                        data        : {aksi:'Hapus', id_user:id_user, id_kota:id_kota},
                        dataType    : "JSON",
                        success     : function (data) {

                            tabel_list_hotel.ajax.reload(null, false);

                            swal({
                                title               : 'Hapus user hotel',
                                text                : 'Data Berhasil Dihapus',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            }); 

                            $('#form-hotel').trigger("reset");

                            $('#hotel').html(data.list_hotel);

                            $('#batal_hotel').attr('hidden', true);

                            $('.hapus-hotel').removeAttr('disabled');

                            if (data.jml_hotel == 0) {
                                $('#form-hotel').attr('hidden', true);
                            } else {
                                $('#form-hotel').removeAttr('hidden');
                            }
                            
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
                        text                : 'Anda membatalkan hapus user hotel',
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


})