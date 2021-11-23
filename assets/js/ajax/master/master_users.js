$(document).ready(function () {

    // var loading = $.loading();

    // function startAjax() {
    //     $.get('http://www.google.com', function () {});
    // }

    // function openLoading() {
    //     loading.open();
    // }

    // function closeLoading() {
    //     loading.close();
    // }

    // User DTW

    tampil_pengguna_dtw()

    $('#pengguna_dtw').DataTable({
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });

    // menampilkan data user dtw
    function tampil_pengguna_dtw() {
        
        $('#btn-modal-hotel').hide();

        $.ajax({
            type    : 'ajax',
            url     : 'Users/json_p_dtw',
            async   : false,
            dataType: 'json',
            success: function (data) {
                $('#hotel').next('.select2-container').hide();
                $('#dtw').next('.select2-container').hide();
                $('#s_hotel').hide();
                $('#u_dtw').hide();
                $('#u_hotel').hide();
                $('#u_kota').hide();
                $('#s_dtw').show();
                $('#u_title').hide();
                $('#t_title').show();

                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {
                    if (data[i].status == 1) {
                        var sts = '<span class="badge badge-success">active</span>'
                    }
                    html += '<tr>' +
                        '<td class="text-center">' + (i + 1) + '.</td>' +
                        '<td>' + data[i].nama_dtw + '</td>' +
                        '<td>' + data[i].username + '</td>' +
                        '<td>' + data[i].alamat + '</td>' +
                        '<td class="text-center">' + sts + '</td>' +
                        '<td class="text-center">' +
                        '<button  class="btn btn-info btn-sm btn-link edit"  rel="tooltip" data-original-title="Edit Data" data="' + data[i].id_user + '" ><i class="fa fa-edit"></i></button>' +
                        '<button  class="btn btn-danger btn-sm btn-link hapus" rel="tooltip" data-original-title="Hapus Data" data="' + data[i].id_user + '" ><i class="fa fa-trash"></i></button>' +
                    '</td>' +
                    '</tr>';
                }

                $('#data-p-dwt').html(html);
            }

        });
    }

    $('.btn').tooltip({
        container: 'body'
    });

    //GET edit
    $('#data-p-dwt').on('click', '.edit', function () {
        var id = $(this).attr('data');
        $.ajax({
            type: "POST",
            url: "Users/edit_users",
            dataType: "JSON",
            data: {id:id},
            success: function (data) {
                $('#u_title').show();
                $('#t_title').hide();
                $('#u_dtw').show();
                $('#s_dtw').hide();
                $('#u_hotel').hide();
                $('#u_kota').hide();
                $('#s_hotel').hide();
                $('#dtw').next('.select2-container').show();
                $('#hotel').next('.select2-container').hide();
                $('#modal-add').modal('show');
                $('#dtw').select2('val', data.id_dtw);
                $('#id').val(id);
                $('#username').val(data.username);
                $('#password').val(data.password);
                $('#status').val(data.status);
                $('#id_group').val(data.group);
            }
        });
        return false;
    });

    //GET HAPUS
    $('#data-p-dwt').on('click', '.hapus', function () {
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
                    type: 'POST',
                    url: 'Users/hapus_users',
                    async: false,
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (data) {
                        tampil_pengguna_dtw()
                        Swal.fire('Data Berhasil Dihapus!', '', 'success');
                    }
                });
            }
        })
    });

    //button-simpan
    $('#s_dtw').on('click', function () {
        var username = $('#username').val();
        var password = $('#password').val();
        var dtw = $('#dtw').val();
        var status = $('#status').val();

        console.log(dtw);

        $.ajax({
            type: "POST",
            url: "Users/simpan_users",
            dataType: "JSON",
            data: {
                    dtw: dtw,
                    username: username,
                    password: password,
                    status: status
                  },
            success: function (data) {
                if(data == true) {
                    $('#dtw').val("");
                    $('#username').val("");
                    $('#password').val("");
                    $('#status').val("");
                    $('#hotel').val("");
                    $('#modal-add').modal('hide');
                    tampil_pengguna_dtw();
                    Swal.fire('Data Berhasil Disimpan!', '', 'success');
                }
                else{
                    Swal.fire('Data Gagal Disimpan!','','warning');
                }
            }
        });
        return false;
    });

    //Update
    $('#u_dtw').on('click', function () {
        var id = $('#id').val();
        var username = $('#username').val();
        var password = $('#password').val();
        var status = $('#status').val();
        var dtw = $('#dtw').val();
        $.ajax({
            type: "POST",
            url: "Users/update_users",
            dataType: "JSON",
            data: {
                id: id,
                dtw: dtw,
                username: username,
                password: password,
                status: status
            },
            success: function (data) {
                $('#id').val("");
                $('#username').val("");
                $('#password').val("");
                $('#status').val("");
                $('#dtw').val("");
                $('#hotel').val("");
                $('#modal-add').modal('hide');
                tampil_pengguna_dtw();
                Swal.fire('Data Berhasil Diupdate!', '', 'success');
            }
        });
        return false;
    });

    $('[href="#link2"]').on('click', function () {
        $('#btn-modal-hotel').show();
        $('#btn-modal').hide();

    })

    $('[href="#link1"]').on('click', function () {
        $('#btn-modal').show();
        $('#btn-modal-hotel').hide();

    })

    $('[href="#link3"]').on('click', function () {
        $('#btn-modal').hide();
        $('#btn-modal-hotel').hide();

    })

    $('#btn-modal').on('click', function () {
        $('#s_dtw').show();
        $('#u_dtw').hide();
        $('#u_hotel').hide();
        $('#s_hotel').hide();
        $('#u_kota').hide();
        $('#dtw').next('.select2-container').show();
        $('#hotel').next('.select2-container').hide();
        $('#id').val("");
        $('#username').val("");
        $('#password').val("");
        $('#status').val("");
        $('#dtw').val("");

    })

    $('#btn-modal-hotel').on('click', function () {
        $('#s_dtw').hide();
        $('#u_dtw').hide();
        $('#u_hotel').hide();
        $('#s_hotel').show();
        $('#u_kota').hide();
        $('#dtw').next('.select2-container').hide();
        $('#hotel').next('.select2-container').show();
        $('#id').val("");
        $('#username').val("");
        $('#password').val("");
        $('#status').val("");
        $('#dtw').val("");

    })


    //User Hotel 

    tampil_pengguna_hotel();

    $('#pengguna_hotel').DataTable({
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });

    function tampil_pengguna_hotel() {
        $.ajax({
            type    : 'ajax',
            url     : 'Users/json_p_hotel',
            async   : false,
            dataType: 'json',
            success: function (data) {
                // $('#dtw').next('.select2-container').hide();
                // $('#s_hotel').hide();
                // $('#u_dtw').hide();
                // $('#u_hotel').hide();
                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {
                    if (data[i].status == 1) {
                        var sts = '<span class="badge badge-success">active</span>';
                    }
                    html += '<tr>' +
                        '<td class="text-center">' + (i + 1) + '.</td>' +
                        '<td>' + data[i].nama_hotel + '</td>' +
                        '<td>' + data[i].username + '</td>' +
                        '<td>' + data[i].alamat + '</td>' +
                        '<td class="text-center">' + sts + '</td>' +
                        '<td class="text-center">' +
                        '<button  class="btn btn-info btn-sm btn-link edit" rel="tooltip" data-original-title="Edit Data" data="' + data[i].id_user + '"><i class="fa fa-edit"></i></button>'+
                        '<button " class="btn btn-danger btn-sm btn-link hapus" rel="tooltip" data-original-title="Hapus Data" data="' + data[i].id_user + '"><i class="fa fa-trash"></i></button>' +
                        '</td>' +
                        '</tr>';
                }
                $('#data-p-hotel').html(html);
            }

        });
    }

    $('.btn').tooltip({
        container: 'body'
    });

    //button-simpan
    $('#s_hotel').on('click', function () {
        var username = $('#username').val();
        var password = $('#password').val();
        var hotel = $('#hotel').val();
        var status = $('#status').val();
        $.ajax({
            type: "POST",
            url: "Users/simpan_users_hotel",
            dataType: "JSON",
            data: {
                hotel: hotel,
                username: username,
                password: password,
                status: status
            },
            success: function (data) {
                if(data == true) {
                    $('#dtw').val("");
                    $('#hotel').val("");
                    $('#username').val("");
                    $('#password').val("");
                    $('#status').val("");
                    $('#modal-add').modal('hide');
                    tampil_pengguna_hotel();
                    Swal.fire('Data Berhasil Disimpan!', '', 'success');
                }
                else{
                    Swal.fire('Data Gagal Disimpan!','','warning');
                }
            }
        });
        return false;
    });

    //GET UPDATE
    $('#data-p-hotel').on('click', '.edit', function () {
        var id = $(this).attr('data');
        $.ajax({
            type: "POST",
            url: "Users/edit_users_hotel",
            dataType: "JSON",
            data: {
                id: id
            },
            success: function (data) {
                $.each(data, function (id, username, jabatan) {
                    $('#u_dtw').hide();
                    $('#s_dtw').hide();
                    $('#u_hotel').show();
                    $('#u_kota').hide();
                    $('#s_hotel').hide();
                    $('#dtw').next('.select2-container').hide();
                    $('#hotel').next('.select2-container').show();
                    $('#modal-add').modal('show');
                    $('#id').val(data.id_user);
                    $('#hotel').val(data.id_hotel);
                    $('#username').val(data.username);
                    $('#password').val(data.password);
                    $('#status').val(data.status);
                    $('#id_group').val(data.group);
                });
            }
        });
        return false;
    });

    //GET HAPUS
    $('#data-p-hotel').on('click', '.hapus', function () {
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
                    type: 'POST',
                    url: 'Users/hapus_users_hotel',
                    async: false,
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (data) {
                        tampil_pengguna_hotel()
                        Swal.fire('Data Berhasil Dihapus!', '', 'success');
                    }
                });
            }
        })
    });

    $('#u_hotel').on('click', function () {
        var id = $('#id').val();
        var username = $('#username').val();
        var password = $('#password').val();
        var status = $('#status').val();
        var hotel = $('#hotel').val();
        $.ajax({
            type: "POST",
            url: "Users/update_users_hotel",
            dataType: "JSON",
            data: {
                id: id,
                hotel: hotel,
                username: username,
                password: password,
                status: status
            },
            success: function (data) {
                $('#id').val("");
                $('#username').val("");
                $('#password').val("");
                $('#status').val("");
                $('#dtw').val("");
                $('#hotel').val("");
                $('#modal-add').modal('hide');
                tampil_pengguna_hotel();
                Swal.fire('Data Berhasil Diupdate!', '', 'success');
            }
        });
        return false;
    });

    //Kota
    tampil_pengguna_kota();
    $('#pengguna_kota').DataTable({
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }
    });

    function tampil_pengguna_kota() {
        $.ajax({
            type: 'ajax',
            url: 'Users/json_p_kota',
            async: false,
            dataType: 'json',
            success: function (data) {
                // $('#dtw').next('.select2-container').hide();
                // $('#s_hotel').hide();
                // $('#u_dtw').hide();
                // $('#u_hotel').hide();
                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {
                    html += '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + data[i].nama_kota + '</td>' +
                        '<td>' + data[i].username + '</td>' +
                        '<td class="text-center">' +
                        '<button  class="btn btn-info btn-sm btn-link edit" rel="tooltip" data-original-title="Edit Data" data="' + data[i].id_user + '"><i class="fa fa-edit"></i></button>' + ' ' +
                        '<button " class="btn btn-danger btn-sm btn-link hapus" rel="tooltip" data-original-title="Hapus Data" data="' + data[i].id_user + '"><i class="fa fa-trash"></i></button>' +
                        '</td>' +
                        '</tr>';
                }
                $('#data-p-kota').html(html);
            }

        });
    }

    $('.btn').tooltip({
        container: 'body'
    });
    
    //GET UPDATE
    $('#data-p-kota').on('click', '.edit', function () {
        var id = $(this).attr('data');
        $.ajax({
            type: "POST",
            url: "Users/edit_users",
            dataType: "JSON",
            data: {
                id: id
            },
            success: function (data) {
                $.each(data, function (id, username, jabatan) {
                    $('#modal-add').modal('show'); 
                    $('#u_dtw').hide();
                    $('#s_dtw').hide();
                    $('#u_hotel').hide();
                    $('#u_kota').show();
                    $('#s_hotel').hide();
                    $('#dtw').next('.select2-container').hide();
                    $('#hotel').next('.select2-container').hide();
                    $('#kota').show();
                    $('#status').hide();
                    $('#id').val(data.id_user);
                    $('#kota').val(data.id_kota);
                    $('#username').val(data.username);
                    $('#password').val(data.password);
                });
            }
        });
        return false;
    });


    //GET HAPUS
    $('#data-p-kota').on('click', '.hapus', function () {
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
                    type: 'POST',
                    url: 'Users/hapus_users_hotel',
                    async: false,
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (data) {
                        tampil_pengguna_kota()
                        Swal.fire('Data Berhasil Dihapus!', '', 'success');
                    }
                });
            }
        })
    });
    
    $('#u_kota').on('click', function () {
        var id = $('#id').val();
        var username = $('#username').val();
        var password = $('#password').val();
        var status = $('#status').val();
        var kota = $('#kota').val();
        $.ajax({
            type: "POST",
            url: "Users/update_users_kota",
            dataType: "JSON",
            data: {
                id: id,
                kota: kota,
                username: username,
                password: password,
                status: status
            },
            success: function (data) {
                $('#id').val("");
                $('#username').val("");
                $('#password').val("");
                $('#status').val("");
                $('#dtw').val("");
                $('#hotel').val("");
                $('#kota').val("");
                $('#modal-add').modal('hide');
                tampil_pengguna_kota();
                Swal.fire('Data Berhasil Diupdate!', '', 'success');
            }
        });
        return false;
    });
    /*=====  End of Pengguna  ======*/

    /*==================================
    =            Master DTW            =
    ==================================*/



    /*=====  End of Master DTW  ======*/

});
