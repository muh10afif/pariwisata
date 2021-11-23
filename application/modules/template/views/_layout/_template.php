<!DOCTYPE html>
<html>
  <head>
    <!-- meta -->
    <?php echo @$_meta; ?>

    <!-- css --> 
    <?php echo @$_css; ?>

  </head>

  <body class="">
  <div class="wrapper">
    
      <!-- data-image="../assets/img/sidebar-1.jpg" -->
      <div class="sidebar" data-color="rose" data-background-color="black" data-image="<?php echo base_url('assets/material-temp') ?>/assets/img/sidebar-5.png">
      <!-- header -->
        <?php echo @$_header; ?> <!-- nav -->
      
      <!-- sidebar -->
        <?php echo @$_sidebar; ?>
        </div>
       <div class="main-panel">
      <!-- header -->
        <?php echo @$_nav; ?> 

      <!-- content -->
        <?php echo @$_content; ?> <!-- headerContent --><!-- mainContent -->
    
      <!-- footer -->
        <?php echo @$_footer; ?>
      </div>
  </div>

    <!-- js -->
    <?php echo @$_js; ?>
  </body>
  <script type="text/javascript">
    $(document).ready(function() {
        var loading = $.loading();

    function startAjax() {
        $.get('http://www.google.com', function () {
        });
    }
function openLoading() {
        loading.open();
    }

    function closeLoading() {
        loading.close();
    }
  })
  </script>
</html>