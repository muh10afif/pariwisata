 <!-- Navbar -->
      <nav class="navbar navbar-expand-lg bg-dark navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper" data-color="rose">
            <div class="navbar-minimize">
              <button class="btn btn-just-icon btn-white btn-fab btn-round mat-raised-button" mat-raised-button="" id="minimizeSidebar">
                <span class="mat-button-wrapper"><i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i><i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i></span>
                <div class="mat-button-ripple mat-ripple" matripple=""></div><div class="mat-button-focus-overlay"></div>
              </button>              
            </div>
           <!--  <a class="navbar-brand" href="#pablo">Dashboard</a> -->
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <form class="navbar-form">
              <!-- <div class="input-group no-border">
               
              </div> -->
            </form>
            <ul class="navbar-nav">
              <li class="nav-item text-white text-center">
                <?= ucwords(str_replace('_', ' ', $userdata->username)); ?> | Level: <?= ucwords(strtolower($this->session->userdata('level'))); ?>
              </li>
              <li class="nav-item text-center">
                <a class="dropdown-item" href="<?php echo base_url('Auth/Auth/logout') ?>"><button class="btn btn-sm btn-rose">Logout</button></a> 
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->