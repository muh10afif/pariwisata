<div class="sidebar-wrapper">
  <ul class="nav">
    <li class="nav-item <?= ($Menu == "Dashboard") ? "active": '' ?>">
      <a class="nav-link" href="<?php echo base_url('Dashboard/Dashboard') ?>">
        <i class="material-icons">dashboard</i>
        <p> Dashboard</p>
      </a>
    </li>

    <?php $level = $this->session->userdata('level'); ?>

    <?php if ($level == 'admin' || $level == 'kota') : ?>

      <li class="nav-item <?= ($Menu == "Master") ? 'active' : '' ?>">
        <a class="nav-link" data-toggle="collapse" href="#pagesExamples" aria-expanded="false">
          <i class="material-icons">account_balance</i>
          <p> Master
            <b class="caret"></b>
          </p>
        </a>
        <div class="ml-3 collapse <?= ($Menu == "Master") ? 'show' : '' ?>" id="pagesExamples">
          <ul class="nav">
            <?php if ($level == 'admin') : ?>
            <li class="nav-item <?= ($Page == "Master Kota") ? 'active' : '' ?>">
              <a class="nav-link" href="<?php echo base_url('Master/Kota') ?>">
                <i class="material-icons">panorama_fish_eye</i>
                <span class="sidebar-normal">Master Kab / Kota</span>
              </a>
            </li>
            <?php endif; ?>
            <li class="nav-item <?= ($Page == "Master DTW") ? 'active' : '' ?>">
              <a class="nav-link" href="<?php echo base_url('Master/Dtw') ?>">
                <i class="material-icons">panorama_fish_eye</i>
                <span class="sidebar-normal">Master DTW</span>
              </a>
            </li>
            <li class="nav-item <?= ($Page == "Master Hotel") ? 'active' : ''?>">
              <a class="nav-link" href="<?php echo base_url('Master/Hotel') ?>">
                <i class="material-icons">panorama_fish_eye</i>
                <span class="sidebar-normal">Master Akomodasi</span>
              </a>
            </li>
            <!-- <li class="nav-item <?= ($Page == "Master Users") ? 'active' : ''?>">
              <a class="nav-link" href="<?php echo base_url('Master/Users') ?>">
                  <i class="material-icons">panorama_fish_eye</i>
                <span class="sidebar-normal">Master Users</span>
              </a>
            </li> -->
            <?php if ($level == 'kota') : ?>
            <li class="nav-item  <?= ($Page == "Master Petugas") ? 'active' : ''?>">
              <a class="nav-link" href="<?php echo base_url('Master/Petugas') ?>">
                  <i class="material-icons">panorama_fish_eye</i>
                <span class="sidebar-normal">Master Petugas</span>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </div>
      </li> 

      <li class="nav-item <?= ($Menu == "Kelola-Users") ? 'active' : '' ?>">
        <a class="nav-link" data-toggle="collapse" href="#kelola-user" aria-expanded="false">
          <i class="material-icons">account_box</i>
          <p> Kelola Users
            <b class="caret"></b>
          </p>
        </a>
        <div class="ml-3 collapse <?= ($Menu == "Kelola-Users") ? 'show' : '' ?>" id="kelola-user">
          <ul class="nav">
            <?php if ($level == 'admin') : ?>
            <li class="nav-item <?= ($Page == "User Kota") ? 'active' : '' ?>">
              <a class="nav-link" href="<?php echo base_url('Users/Kota') ?>">
                <i class="material-icons">panorama_fish_eye</i>
                <span class="sidebar-normal">User Kab / Kota</span>
              </a>
            </li>
            <?php endif; ?>
            <li class="nav-item <?= ($Page == "User DTW") ? 'active' : '' ?>">
              <a class="nav-link" href="<?php echo base_url('Users/Dtw') ?>">
                <i class="material-icons">panorama_fish_eye</i>
                <span class="sidebar-normal">User DTW</span>
              </a>
            </li>
            <li class="nav-item <?= ($Page == "User Hotel") ? 'active' : ''?>">
              <a class="nav-link" href="<?php echo base_url('Users/Hotel') ?>">
                <i class="material-icons">panorama_fish_eye</i>
                <span class="sidebar-normal">User Akomodasi</span>
              </a>
            </li>
          </ul>
        </div>
      </li>

    <?php endif; ?>

    <?php if ($level == 'kota') : ?>
      <li class="nav-item <?= ($Page == "Penempatan") ? 'active' : ''?>">
          <a class="nav-link" href="<?php echo base_url('Master/Penempatan') ?>">
          <i class="material-icons">transfer_within_a_station</i>
          <p>Penempatan Petugas</p>
          </a>
      </li>
    <?php endif; ?>

    <?php if ($level == 'dtw') : ?>

    <li class="nav-item <?= ($Menu == "input_dtw") ? 'active' : '' ?>">
      <a class="nav-link" data-toggle="collapse" href="#input_dtw" aria-expanded="false">
          <i class="material-icons">input</i>
          <p> Input Wisatawan
          <b class="caret"></b>
          </p>
      </a>
      <div class="ml-3 collapse <?= ($Menu == "input_dtw") ? 'show' : '' ?>" id="input_dtw">
          <ul class="nav">
            <li class="nav-item <?= ($Page == "wisnus") ? 'active' : '' ?>">
                <a class="nav-link" href="<?php echo base_url('Kelolaan/Dtw/input_dtw/wisnus') ?>">
                <i class="material-icons">panorama_fish_eye</i>
                <span class="sidebar-normal">W I S N U S</span>
                </a>
            </li>
            <li class="nav-item <?= ($Page == "wisman") ? 'active' : '' ?>">
                <a class="nav-link" href="<?php echo base_url('Kelolaan/Dtw/input_dtw/wisman') ?>">
                <i class="material-icons">panorama_fish_eye</i>
                <span class="sidebar-normal">W I S M A N</span>
                </a>
            </li>
          </ul>
      </div>
    </li>
    <li class="nav-item <?= ($Menu == "Rekap_dtw") ? 'active' : '' ?>">
      <a class="nav-link" href="<?php echo base_url('Rekap/Dtw/rekap_dtw') ?>">
        <i class="material-icons">assignment</i>
        <p>Rekap Wisatawan</p>
      </a>
    </li>
      
    <?php endif; ?>


    <?php if ($level == 'hotel') : ?>

    <li class="nav-item <?= ($Menu == "Master") ? 'active' : '' ?>">
    <a class="nav-link" data-toggle="collapse" href="#input" aria-expanded="false">
        <i class="material-icons">input</i>
        <p> Input Wisatawan
        <b class="caret"></b>
        </p>
    </a>
    <div class="ml-3 collapse <?= ($Menu == "input_hotel") ? 'show' : ''?>" id="input">
        <ul class="nav">
        <li class="nav-item <?= ($Page == "wisnus") ? 'active' : '' ?>">
            <a class="nav-link" href="<?php echo base_url('Kelolaan/Hotel/input_hotel/wisnus') ?>">
            <i class="material-icons">panorama_fish_eye</i>
            <span class="sidebar-normal">W I S N U S</span>
            </a>
        </li>
        <li class="nav-item <?= ($Page == "wisman") ? 'active' : '' ?>">
            <a class="nav-link" href="<?php echo base_url('Kelolaan/Hotel/input_hotel/wisman') ?>">
            <i class="material-icons">panorama_fish_eye</i>
            <span class="sidebar-normal">W I S M A N</span>
            </a>
        </li>
        </ul>
    </div>
    </li> 
    <li class="nav-item <?= ($Menu == "Rekap_hotel") ? 'active' : '' ?>">
      <a class="nav-link" href="<?php echo base_url('Rekap/Hotel/rekap_hotel') ?>">
        <i class="material-icons">assignment</i>
        <p>Rekap Wisatawan</p>
      </a>
    </li> 

    <?php endif; ?>

    <?php if ($level == 'petugas') : ?>

    <li class="nav-item <?= ($Menu == "Kelolaan") ? 'active' : '' ?>">
      <a class="nav-link" data-toggle="collapse" href="#kelolaan" aria-expanded="false">
        <i class="material-icons">how_to_reg</i>
        <p> Kelolaan
          <b class="caret"></b>
        </p>
      </a>
      <div class="ml-3 collapse <?= ($Menu == "Kelolaan") ? 'show' : '' ?>" id="kelolaan">
        <ul class="nav">
          <li class="nav-item <?= ($Page == "Kelolaan DTW") ? 'active' : ''?>">
            <a class="nav-link" href="<?php echo base_url('Kelolaan/Dtw') ?>">
                <i class="material-icons">panorama_fish_eye</i>
              <span class="sidebar-normal">Kelola DTW</span>
            </a>
          </li>
          <li class="nav-item <?= ($Page == "Kelolaan Hotel") ? 'active' : '' ?>">
            <a class="nav-link" href="<?php echo base_url('Kelolaan/Hotel') ?>">
                <i class="material-icons">panorama_fish_eye</i>
              <span class="sidebar-normal">Kelola Akomodasi</span>
            </a>
          </li>
        </ul>
      </div>
    </li> 

    <?php endif; ?>


    <?php if ($level == 'petugas' || $level == 'kota' || $level == 'admin') : ?>

    <li class="nav-item <?= ($Menu == "Rekap") ? 'active' : '' ?>">
      <a class="nav-link" data-toggle="collapse" href="#Rekap" aria-expanded="false">
        <i class="material-icons">assignment</i>
        <p> Rekap Wisatawan
          <b class="caret"></b>
        </p>
      </a>
      <div class="ml-3 collapse <?= ($Menu == "Rekap") ? 'show' : ''?>" id="Rekap">
        <ul class="nav">
          <li class="nav-item <?= ($Page == "Rekap DTW") ? 'active' : '' ?>">
            <a class="nav-link" href="<?php echo base_url('Rekap/Dtw') ?>">
                <i class="material-icons">panorama_fish_eye</i>
              <span class="sidebar-normal">Rekap DTW</span>
            </a>
          </li>
          <li class="nav-item  <?= ($Page == "Rekap Hotel") ? 'active' : '' ?>">
            <a class="nav-link" href="<?php echo base_url('Rekap/Hotel') ?>">
                <i class="material-icons">panorama_fish_eye</i>
              <span class="sidebar-normal">Rekap Akomodasi</span>
            </a>
      </div>
    </li>

    <?php endif; ?>

    <?php if ($level == 'kota' || $level == 'admin') : ?>

      <!-- <li class="nav-item <?= ($Page == "Report") ? 'active' : '' ?>">
        <a class="nav-link" href="<?php echo base_url('Report/report/') ?>">
          <i class="material-icons">assessment</i>
          <p>Report</p>
        </a>
      </li> -->

      <li class="nav-item <?= ($Menu == "Report") ? 'active' : '' ?>">
        <a class="nav-link" data-toggle="collapse" href="#Report" aria-expanded="false">
          <i class="material-icons">assessment</i>
          <p> Report
            <b class="caret"></b>
          </p>
        </a>

        <div class="ml-3 collapse <?= ($Menu == "Report") ? 'show' : ''?>" id="Report">
          <ul class="nav">
            <li class="nav-item <?= ($Page == "Report Detail DTW" || $Page == "Report Detail Hotel") ? 'active' : '' ?>">
              <a class="nav-link" data-toggle="collapse" href="#report_detail" aria-expanded="false">
                  <i class="material-icons">panorama_fish_eye</i>
                <span class="sidebar-normal">Detail Wisatawan <b class="caret"></b></span>
              </a>

              <div class="ml-3 collapse <?= ($Page == "Report Detail DTW" || $Page == "Report Detail Hotel") ? 'show' : ''?>" id="report_detail">
                <ul class="nav">
                  <li class="nav-item <?= ($Page == "Report Detail DTW") ? 'active' : '' ?>">
                    <a class="nav-link" href="<?php echo base_url('Report/Dtw') ?>">
                      <i class="material-icons">panorama_fish_eye</i>
                      <span class="sidebar-normal">DTW</span>
                    </a>
                  </li>
                  <li class="nav-item  <?= ($Page == "Report Detail Hotel") ? 'active' : '' ?>">
                    <a class="nav-link" href="<?php echo base_url('Report/Hotel') ?>">
                      <i class="material-icons">panorama_fish_eye</i>
                      <span class="sidebar-normal">Akomodasi</span>
                    </a>
              </div>

            </li>

            <li class="nav-item  <?= ($Page == "Report Presentase") ? 'active' : '' ?>">
              <a class="nav-link" href="<?php echo base_url('Report/Presentase') ?>">
                  <i class="material-icons">panorama_fish_eye</i>
                <span class="sidebar-normal">Perbandingan Wisatawan</span>
              </a>
        </div>
      </li>

      <li class="nav-item <?= ($Page == "Report") ? 'active' : '' ?>">
        <a class="nav-link" href="<?php echo base_url('Report/Report/unduh_database') ?>">
          <i class="material-icons">get_app</i>
          <p>Unduh Database</p>
        </a>
      </li>

    <?php endif; ?>
    
  </ul>
</div>
