<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets/material-temp')?>/assets/img/logo.png">
  <link rel="icon" type="image/png" href="<?php echo base_url('assets/material-temp')?>/assets/img/favicon.ico">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Pariwisata
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!-- Extra details for Live View on GitHub Pages -->
  <!-- Canonical SEO -->
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="<?php echo base_url('assets/material-temp')?>/assets/css/material-dashboard.min.css?v=2.1.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="<?php echo base_url('assets/material-temp')?>/assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="off-canvas-sidebar">

  <!-- End Google Tag Manager (noscript) -->
  <div class="wrapper wrapper-full-page">
    <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('<?php echo base_url('assets/material-temp') ?>/assets/img/bg_login1.png'); background-size: cover; background-position: top center;">
      <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->

      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
            <form class="form" method="POST" id="form-login" autocomplete="off">
              <div class="card card-login card-hidden" style="background: #00000094;height: 300px;">
                <div class="card-header card-header-rose text-center">
                  <h4 class="card-title">Sistem Informasi Pariwisata</h4>
                  <h5 class="card-title">Provinsi Jawa Timur</h5>
                </div>
                <div class="card-body ">
                  <span class="bmd-form-group">
                    <div class="input-group" style="margin-top: 30px;">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons text-white">account_circle</i>
                        </span>
                      </div>
                      <input type="text" class="form-control text-white" id="username" placeholder="Username">
                    </div>
                  </span>
                  <span class="bmd-form-group">
                    <div class="input-group mt-4">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons text-white">lock</i>
                        </span>
                      </div>
                      <input type="password" class="form-control text-white" id="password" placeholder="Password">
                    </div>
                  </span>
                </div>
                <div class="card-footer justify-content-center">
                  <button type="submit" class="btn btn-rose">L O G I N</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="<?php echo base_url('assets/material-temp') ?>/assets/js/core/jquery.min.js"></script>
  <script src="<?php echo base_url('assets/material-temp') ?>/assets/js/core/popper.min.js"></script>
  <script src="<?php echo base_url('assets/material-temp') ?>/assets/js/core/bootstrap-material-design.min.js"></script>
  <!--  Google Maps Plugin    -->
  
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="<?php echo base_url('assets/material-temp/') ?>assets/js/plugins/sweetalert2.js"></script>
  <script src="<?php echo base_url('assets/js/') ?>loading-ajax/ajax-loading.js"></script>
  <!-- Chartist JS -->
  <script src="<?php echo base_url('assets/material-temp') ?>/assets/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="<?php echo base_url('assets/material-temp') ?>/assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?php echo base_url('assets/material-temp') ?>/assets/js/material-dashboard.min.js?v=2.1.0" type="text/javascript"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="<?php echo base_url('assets/material-temp') ?>/assets/demo/demo.js"></script>
  <!-- Sharrre libray -->
  <!-- <script src="<?php echo base_url('assets/material-temp') ?>/assets/demo/jquery.sharrre.js"></script> -->

  <script>
        
    $(document).ready(function () {
        
        $('#form-login').on('submit', function () {

            var username    = $('#username').val();
            var password    = $('#password').val();

            console.log(username);

            if ((username == "") && (password == "")) {

                swal({
                    title               : "Peringatan",
                    text                : 'Semua data harus terisi dahulu',
                    buttonsStyling      : false,
                    confirmButtonClass  : "btn btn-warning",
                    type                : 'warning'
                });

                return false;
            } else if (password == "" && username != "") {

                swal({
                    title               : "Peringatan",
                    text                : 'Password harus terisi dahulu',
                    buttonsStyling      : false,
                    confirmButtonClass  : "btn btn-warning",
                    type                : 'warning'
                });

                return false;
            } else if (username == "" && password != "") {
                
                swal({
                    title               : "Peringatan",
                    text                : 'Username harus terisi dahulu',
                    buttonsStyling      : false,
                    confirmButtonClass  : "btn btn-warning",
                    type                : 'warning'
                });

                return false;
            } else {
                // jalankan proses ajax kirim data
                $.ajax({
                    type        : "post",
                    url         : "<?= base_url('Auth/Auth/login') ?>",
                    data        : {username:username, password:password},
                    dataType    : 'JSON',
                    success     : function (data) {
                        
                        if (data.hasil == 2) {

                          var url = "<?= base_url('Dashboard') ?>";

                          window.location.href = url;

                        } else if (data.hasil == 1) {

                            $('#password').val('');

                            swal({
                                title 	: 'Gagal',
                                text 	: 'Password yang dimasukkan salah!!',
                                type 	: 'error',
                                timer 	: 1000,

                                showConfirmButton 	: false
                            })

                            setTimeout(() => {
                                $('#password').focus();
                            }, 1300)

                        } else if (data.hasil == 0) {

                            $('#username').val('');
                            $('#password').val('');

                            swal({
                                title 	: 'Gagal',
                                text 	: 'Username tidak ditemukan!!',
                                type 	: 'error',
                                timer 	: 1000,

                                showConfirmButton	: false
                            })

                            setTimeout(() => {
                                $('#username').focus();
                            }, 1300);

                        } else {
                            $('#username').val('');
                            $('#password').val('');

                            swal({
                                title 	: 'Gagal',
                                text 	: 'Anda tidak mempunyai hak akses masuk!!',
                                type 	: 'error',
                                timer 	: 1000,

                                showConfirmButton	: false
                            })

                            setTimeout(() => {
                                $('#username').focus();
                            }, 1300);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error');
                    }							

                    
                })
                
                return false;

            }

        })

    })
    
</script>

</body>

</html>
