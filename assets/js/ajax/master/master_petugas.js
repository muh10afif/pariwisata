$(document).ready(function() {

    show_petugas()
      $('#tbl_petugas').DataTable({
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search records",
        }
      });


      function show_petugas() {
      	$('#b-update').hide();
        $('#edit-title').hide();
        $('#b-simpan').show();
        $('#add-title').show();
      	$.ajax({
                type  : 'ajax',
                url   : 'Petugas/json',
                async : false,
                dataType : 'json',
                success : function(data){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        if (data[i].status == 1) {
                            var sts = '<span class="badge badge-success">active</span>'
                        }
                        else{
                        var sts = '<span class="badge badge-danger">non active</span>'
                        }
                        html += '<tr>'+
                                '<td>'+(i+1)+'</td>'+
                                '<td>'+data[i].nama_petugas+'</td>'+
                                '<td>'+data[i].nik+'</td>'+
                                '<td>'+data[i].email+'</td>'+
                                '<td>'+data[i].no_telp+'</td>'+
                                '<td>'+data[i].alamat+'</td>'+
                                '<td>'+sts+'</td>'+
                                '<td class="text-center">'+
                                    '<button  class="btn btn-info btn-sm btn-link edit"  rel="tooltip" data-original-title="Edit Data" data="'+data[i].id_petugas+'" ><i class="fa fa-edit"></i></button>'+' '+
                                    '<button  class="btn btn-danger btn-sm btn-link hapus" rel="tooltip" data-original-title="Hapus Data" data="'+data[i].id_petugas+'" ><i class="fa fa-trash"></i></button>'+
                                    ''
                                '</td>'+
                                '</tr>';
                    }
                    $('#data-petugas').html(html);
                }
 
            });
        }

       $("#btn-link2").on('click',function(){
       		$('#btn-link1').show();
       		$(this).hide();
       		
       })

        $("#btn-link1").on('click',function(){
       		$(this).hide();
       		$('#btn-link2').show();
       })
          //button-simpan
        $('#b-simpan').on('click',function(){
            var username = $('#username').val();
            var password = $('#password').val();
            var petugas =$('#petugas').val();
            var nik =$('#nik').val();
            var alamat = $('#alamat').val();
            var email = $('#email').val();
            var no_telp = $('#no_telp').val();
            var status= $('#status').val();
            $.ajax({
                type : "POST",
                url  : "Petugas/simpan",
                dataType : "JSON",
                data : {username:username,password:password,petugas:petugas,nik:nik,alamat:alamat,email:email,no_telp:no_telp,status:status},
                success: function(data){
                  if (data == true) {
                    $('#username').val("");
                    $('#password').val("");
                    $('#petugas').val("");
                    $('#nik').val("");
                    $('#alamat').val("");
                    $('#email').val("");
                    $('#no_telp').val("");
                    $('#status').val("");
                    $('#modal-add').modal('hide');
                    show_petugas();
                    $('#btn-link1').show();
                    Swal.fire('Data Berhasil Disimpan!','','success');
                  }
                  else{
                    Swal.fire('Data Gagal Disimpan!','','warning');
                  }
                    
                }
            });
            return false;
        });

        //GET HAPUS
        $('#data-petugas').on('click','.hapus',function() {
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
                url   : 'Petugas/hapus',
                async : false,
                data : {id:id},
                dataType : 'json',
                success : function(data){
                show_petugas();
                $('#btn-link2').show();
                Swal.fire('Data Berhasil Dihapus!','','success');    
                }
            });
           }
         })
        });

    $('#data-petugas').on('click','.edit',function(){
            var id=$(this).attr('data');
            $('#b-update').show();
            $('#edit-title').show();
            $('#b-simpan').hide();
            $('#add-title').hide();
            $.ajax({
                type : "POST",
                url  : "Petugas/edit",
                dataType : "JSON",
                data : {id:id},
                success: function(data){
                  $('#id').val(data.id_petugas);  
                  $('#username').val(data.username);
                  $('#password').val(data.password);
                  $('#petugas').val(data.nama_petugas);
                  $('#nik').val(data.nik);
                  $('#alamat').val(data.alamat);
                  $('#email').val(data.email);
                  $('#no_hp').val(data.no_telp);
                  $('#status').val(data.status);
                  $('#modal-add').modal('show');
                  }
            }); 
        });

    $('#b-update').on('click',function() {
            var id =$('#id').val();
            var petugas =$('#petugas').val();
            var nik =$('#nik').val();
            var alamat = $('#alamat').val();
            var email = $('#email').val();
            var no_telp = $('#no_telp').val();
            var status= $('#status').val();
            $.ajax({
                type : "POST",
                url  : "Petugas/update",
                dataType : "JSON",
                data : {id:id,petugas:petugas,nik:nik,alamat:alamat,email:email,no_telp:no_telp,status:status},
                success: function(data){
                  if (data == true) {
                    $('#id').val("");
                    $('#petugas').val("");
                    $('#nik').val("");
                    $('#alamat').val("");
                    $('#email').val("");
                    $('#no_hp').val("");
                    $('#status').val("");
                    $('#modal-add').modal('hide');
                    show_petugas();
                    Swal.fire('Data Berhasil Diupdate!','','success');
                  }
                  else{

                   Swal.fire('Data Gagal Diupdate!','','warning'); 
                }
                  }
            });
            return false;
    })
     $('.sel2').select2({
      placeholder: "Pilih Kota",
      allowClear: true
     });
     	
})