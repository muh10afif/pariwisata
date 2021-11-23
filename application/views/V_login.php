<!--
 =========================================================
 Material Dashboard PRO - v2.1.0
 =========================================================

 Product Page: https://www.creative-tim.com/product/material-dashboard-pro
 Copyright 2019 Creative Tim (https://www.creative-tim.com)

 Coded by Creative Tim

 =========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets/material-temp')?>/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url('assets/material-temp')?>/assets/img/favicon.png">
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
  <!-- Google Tag Manager -->
  <!-- <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-NKDMSK6');
  </script> -->
  <!-- End Google Tag Manager -->
</head>

<body class="off-canvas-sidebar">

  <!-- End Google Tag Manager (noscript) -->
  <div class="wrapper wrapper-full-page">
    <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('<?php echo base_url('assets/material-temp') ?>/assets/img/bg_login.png'); background-size: cover; background-position: top center;">
      <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->

      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
            <?php echo  $this->session->flashdata('error_msg'); ?>
            <form class="form" method="POST" action="<?php echo base_url('Auth/Auth/login')?>">
              <div class="card card-login card-hidden" style="background: #00000094;height: 300px;">
                <div class="card-header card-header-rose text-center">
                  <h4 class="card-title">Login</h4>
                </div>
                <div class="card-body ">
                  <!-- <p class="card-description text-center">Or Be Classical</p> -->
                  <span class="bmd-form-group">
                    <div class="input-group" style="margin-top: 30px;">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons text-white">face</i>
                        </span>
                      </div>
                      <input type="text" class="form-control text-white" name="username" placeholder="Username" required="required">
                    </div>
                  </span>
                  <span class="bmd-form-group">
                    <div class="input-group mt-4">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons text-white">lock_outline</i>
                        </span>
                      </div>
                      <input type="password" class="form-control text-white" name="password" placeholder="Password" required="required">
                    </div>
                  </span>
                </div>
                <div class="card-footer justify-content-center">
                  <button type="submit" class="btn btn-rose">LOGIN</button>
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

</body>

</html>