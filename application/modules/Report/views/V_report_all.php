<!doctype html>
<html>
    <head>
        <title>Report Keseluruhan</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <style>

    #ad thead tr th {
      vertical-align: middle;
      text-align: center;
    }

    th, td {
      padding: 5px;
      font-size: 10px;
    }

    th {
      text-align: center;
    }
    th {
      background-color: #122E5D; color: white;
    }
    .a tr td {
      font-weight: bold;
    }
    body {
      margin: 20px 20px 20px 20px;
      color: black;
    }
    h5, h6 {
      font-weight: bold;
      text-align: center;
    }
    #d th {
      background-color: #122E5D; color: white;
    }
    </style>
    </head>
    <body>
      <?php if ($kondisi == 'lihat'): ?>
        <form method="POST" target="_self" id="tab" action="<?= base_url('Report/unduh_data') ?>">
          <input type="hidden" name="jenis_report" value="<?= $jenis_report ?>">
          <input type="hidden" name="start" value="<?= $tgl_awal ?>">
          <input type="hidden" name="end" value="<?= $tgl_akhir ?>">

          <button name="excel" onclick="b()" class="btn btn-success">UNDUH - EXCEL</button>

        </form><br>
      <?php endif ?>

      <h5>Report Keseluruhan <br> <?= nice_date($tgl_awal, 'd-F-Y') ?> s/d <?= nice_date($tgl_akhir, 'd-F-Y') ?></h5>
      <br>
      <?php 

        $from   = $tgl_awal;
        $from   = date('Y-m-d', strtotime("-1 day", strtotime($from)));
        $to     = $tgl_akhir;
      
      ?>


      <table border="1" id="ad" width="100%">
        <thead>
          <tr>
            <th>Kab/Kota</th>
            <th>Jenis Data</th>
            <th>Klasifikasi</th>
            <th>Nama Tempat</th>
            <?php $i=1; $tot_i = 1;
                while (strtotime($from)<strtotime($to)){
                $from = mktime(0,0,0,date('m',strtotime($from)),date("d",strtotime($from))+1,date("Y",strtotime($from)));
                $from =date("d-M-Y", $from); ?>
            <th><?= $from ?> <br> WISNUS</th>
            <th><?= $from ?> <br> WISMAN</th>

            <?php $tot_i += $i; $i++; }?>
            <th>Total WISNUS</th>
            <th>Total WISMAN</th>
          </tr>
        </thead>

        <?php if (!empty($data_all)): ?>
        <tbody>
            <?php foreach ($data_all as $d => $value): ?>
                <?php foreach ($value as $d): ?>
                <tr>
                    <td><?= $d['nama_kota'] ?></td>
                    <td><?= strtoupper($d['jenis']) ?></td>
                    <td></td>
                    <td><?= $d['nama_dtw_hotel'] ?></td>
                    <?php

                        $jenis = $d['jenis'];
                        $tot_jml_wisnus = 0;
                        $tot_jml_wisman = 0;

                        $get_tot_wisnus_wisman = 'get_tot_'.$jenis.'_wisnus_wisman';

                        $from   = $tgl_awal;
                        $from   = date('Y-m-d', strtotime("-1 day", strtotime($from)));
                        $to     = $tgl_akhir;

                        while (strtotime($from)<strtotime($to)){
                        $from = mktime(0,0,0,date('m',strtotime($from)),date("d",strtotime($from))+1,date("Y",strtotime($from)));
                        $from =date("d-F-Y", $from); ?>

                    <?php $tot_wisnus = $this->M_report->$get_tot_wisnus_wisman('wisnus', $from, $d['id_dtw_hotel'], $id_kota)->row_array(); 

                          $tot_jml_wisnus += $tot_wisnus['tot_jml_pengunjung'];
                    ?>

                    <td class="text-right"><?= ($tot_wisnus['tot_jml_pengunjung'] == '') ? '0' : $tot_wisnus['tot_jml_pengunjung'] ?></td>

                    <?php $tot_wisman = $this->M_report->$get_tot_wisnus_wisman('wisman', $from, $d['id_dtw_hotel'], $id_kota)->row_array(); 

                          $tot_jml_wisman += $tot_wisman['tot_jml_pengunjung'];
                    ?>

                    <td class="text-right"><?= ($tot_wisman['tot_jml_pengunjung'] == '') ? '0' : $tot_wisman['tot_jml_pengunjung'] ?></td>

                    <?php }?>
                    <td class="text-right"><?= $tot_jml_wisnus ?></td>
                    <td class="text-right"><?= $tot_jml_wisman ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
                
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-center"><b>GRAND TOTAL</b></th>
                <?php

                    $jenis = $d['jenis'];
                    $tot_jml_wisnus_dtw   = 0;
                    $tot_jml_wisnus_hotel = 0;
                    $tot_wisnus_dtw_hotel = 0;
                    $g_total_wisnus       = 0;

                    $tot_jml_wisman_dtw   = 0;
                    $tot_jml_wisman_hotel = 0;
                    $tot_wisman_dtw_hotel = 0;
                    $g_total_wisman       = 0;

                    $get_tot_wisnus_wisman = 'get_tot_'.$jenis.'_wisnus_wisman';
                    $id_dtw_hotel          = '$id_'.$jenis;

                    $from   = $tgl_awal;
                    $from   = date('Y-m-d', strtotime("-1 day", strtotime($from)));
                    $to     = $tgl_akhir;

                    while (strtotime($from)<strtotime($to)){
                    $from = mktime(0,0,0,date('m',strtotime($from)),date("d",strtotime($from))+1,date("Y",strtotime($from)));
                    $from =date("d-F-Y", $from); ?>

                <?php 
                        $tot_wisnus_dtw = $this->M_report->get_tot_dtw_wisnus_wisman('wisnus', $from, $id_dtw = '', $id_kota)->row_array(); 

                        $tot_jml_wisnus_dtw += $tot_wisnus_dtw['tot_jml_pengunjung'];

                        $tot_wisnus_hotel = $this->M_report->get_tot_hotel_wisnus_wisman('wisnus', $from, $id_hotel = '', $id_kota)->row_array(); 

                        $tot_jml_wisnus_hotel += $tot_wisnus_hotel['tot_jml_pengunjung'];

                        $tot_wisnus_dtw_hotel = $tot_wisnus_dtw['tot_jml_pengunjung'] + $tot_wisnus_hotel['tot_jml_pengunjung'];

                        $g_total_wisnus += $tot_wisnus_dtw_hotel;
                        
                ?>

                <th class="text-right"><?= ($tot_wisnus_dtw_hotel == '') ? '0' : $tot_wisnus_dtw_hotel ?></th>

                <?php 
                        $tot_wisman_dtw = $this->M_report->get_tot_dtw_wisnus_wisman('wisman', $from, $id_dtw = '', $id_kota)->row_array(); 

                        $tot_jml_wisman_dtw += $tot_wisman_dtw['tot_jml_pengunjung'];

                        $tot_wisman_hotel = $this->M_report->get_tot_hotel_wisnus_wisman('wisman', $from, $id_hotel = '', $id_kota)->row_array(); 

                        $tot_jml_wisman_hotel += $tot_wisman_hotel['tot_jml_pengunjung'];

                        $tot_wisman_dtw_hotel = $tot_wisman_dtw['tot_jml_pengunjung'] + $tot_wisman_hotel['tot_jml_pengunjung'];

                        $g_total_wisman += $tot_wisman_dtw_hotel;
                ?>

                <th class="text-right"><?= ($tot_wisman_dtw_hotel == '') ? '0' : $tot_wisman_dtw_hotel ?></th>

                <?php }?>
                <th class="text-right"><?= $g_total_wisnus ?></th>
                <th class="text-right"><?= $g_total_wisman ?></th>
            </tr>
        </tfoot>
        <?php else: ?>
            <tr>
                <td colspan="<?= 4+$tot_i ?>"><center><b>Data Tidak Ada</b></center></td>
            </tr>
        <?php endif; ?>
      </table>

</body>
</html>