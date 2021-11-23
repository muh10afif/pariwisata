<div class="tab-content tab-space">
    <div class="tab-pane <?= ($jenis_report == 'wisnus') ? 'active' : '' ?> link3">
        <div class="container-fluid list_wisnus mt-3">
            <table id="tbl_wisnus" class="table table-bordered table-hover table-striped" width="100%">
                <thead class="thead-light">
                    <th>No</th>
                    <th width="25%">Provinsi</th>
                    <th><?= $bln ?></th>
                    <th><?= $bln_skrg ?></th>
                    <th>Jan-Des <?= $thn ?></th>
                    <th>Jan-Des <?= $thn_skrg ?></th>
                    <th>% Perubahan (m on m)</th>
                    <th>% Perubahan (y on y)</th>
                </thead>
                <tbody>
                    <?php 
                    $no=1; 
                    $tot_jumlah_bulan_awal  = 0;
                    $tot_jumlah_bulan_akhir = 0;
                    $tot_jumlah_tahun_awal  = 0;
                    $tot_jumlah_tahun_akhir = 0;
                    $m_on_m                 = 0;
                    $y_on_y                 = 0;

                    foreach ($provinsi as $p): ?>
                        <tr>
                            <td class="text-center"><?= $no ?>.</td>
                            <td><?= $p['nama_provinsi'] ?></td>
                            <td class="text-right"><?= $p['tot_jumlah_bulan_awal'] ?></td>
                            <td class="text-right"><?= $p['tot_jumlah_bulan_akhir'] ?></td>
                            <td class="text-right"><?= $p['tot_jumlah_tahun_awal'] ?></td>
                            <td class="text-right"><?= $p['tot_jumlah_tahun_akhir'] ?></td>
                            <td class="text-right"><?= $p['m_on_m'] ?></td>
                            <td class="text-right"><?= $p['y_on_y'] ?></td>
                        </tr>
                    <?php 
                    $no++; 
                    $tot_jumlah_bulan_awal  += $p['tot_jumlah_bulan_awal'];
                    $tot_jumlah_bulan_akhir += $p['tot_jumlah_bulan_akhir'];
                    $tot_jumlah_tahun_awal  += $p['tot_jumlah_tahun_awal'];
                    $tot_jumlah_tahun_akhir += $p['tot_jumlah_tahun_akhir'];
                    $m_on_m                 += (int) $p['m_on_m'];
                    $y_on_y                 += (int) $p['y_on_y'];
                
                    endforeach; ?>
                    <tr>
                        <th colspan="2" class="text-right">Jumlah 10 Provinsi</th>
                        <th class="text-right"><?= $tot_jumlah_bulan_awal ?></th>
                        <th class="text-right"><?= $tot_jumlah_bulan_akhir ?></th>
                        <th class="text-right"><?= $tot_jumlah_tahun_awal ?></th>
                        <th class="text-right"><?= $tot_jumlah_tahun_akhir ?></th>
                        <th class="text-right"><?= number_format($m_on_m,2) ?></th>
                        <th class="text-right"><?= number_format($y_on_y,2) ?></th>
                    </tr>

                    <tr>
                        <th colspan="2" class="text-right">Lainnya</th>
                        <th class="text-right"><?= $lainnya_prov[0]['tot_jumlah_bulan_awal'] ?></th>
                        <th class="text-right"><?= $lainnya_prov[0]['tot_jumlah_bulan_akhir'] ?></th>
                        <th class="text-right"><?= $lainnya_prov[0]['tot_jumlah_tahun_awal'] ?></th>
                        <th class="text-right"><?= $lainnya_prov[0]['tot_jumlah_tahun_akhir'] ?></th>
                        <th class="text-right"><?= number_format($lainnya_prov[0]['m_on_m'],2) ?></th>
                        <th class="text-right"><?= number_format($lainnya_prov[0]['y_on_y'],2) ?></th>
                    </tr>

                    <tr>
                        <th colspan="2" class="text-right">Jumlah Wisnus</th>
                        <th class="text-right"><?= $tot_jumlah_bulan_awal + $lainnya_prov[0]['tot_jumlah_bulan_awal'] ?></th>
                        <th class="text-right"><?= $tot_jumlah_bulan_akhir + $lainnya_prov[0]['tot_jumlah_bulan_akhir']?></th>
                        <th class="text-right"><?= $tot_jumlah_tahun_awal + $lainnya_prov[0]['tot_jumlah_tahun_awal']?></th>
                        <th class="text-right"><?= $tot_jumlah_tahun_akhir + $lainnya_prov[0]['tot_jumlah_tahun_akhir'] ?></th>
                        <th class="text-right"><?= number_format($m_on_m + $lainnya_prov[0]['m_on_m'],2) ?></th>
                        <th class="text-right"><?= number_format($y_on_y + $lainnya_prov[0]['y_on_y'],2) ?></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane <?= ($jenis_report == 'wisman') ? 'active' : '' ?> link4">
        <div class="container-fluid list_wisman mt-3">
            <table id="tbl_wisman" class="table table-bordered table-hover table-striped" width="100%">
                <thead class="thead-light">
                    <th>No</th>
                    <th width="25%">Negara</th>
                    <th><?= $bln ?></th>
                    <th><?= $bln_skrg ?></th>
                    <th>Jan-Des <?= $thn ?></th>
                    <th>Jan-Des <?= $thn_skrg ?></th>
                    <th>% Perubahan (m on m)</th>
                    <th>% Perubahan (y on y)</th>
                </thead>
                <tbody>
                    <?php 
                    $no=1; 
                    $tot_jumlah_bulan_awal  = 0;
                    $tot_jumlah_bulan_akhir = 0;
                    $tot_jumlah_tahun_awal  = 0;
                    $tot_jumlah_tahun_akhir = 0;
                    $m_on_m                 = 0;
                    $y_on_y                 = 0;

                    foreach ($negara as $p): ?>
                        <tr>
                            <td class="text-center"><?= $no ?>.</td>
                            <td><?= $p['nama_negara'] ?></td>
                            <td class="text-right"><?= $p['tot_jumlah_bulan_awal'] ?></td>
                            <td class="text-right"><?= $p['tot_jumlah_bulan_akhir'] ?></td>
                            <td class="text-right"><?= $p['tot_jumlah_tahun_awal'] ?></td>
                            <td class="text-right"><?= $p['tot_jumlah_tahun_akhir'] ?></td>
                            <td class="text-right"><?= $p['m_on_m'] ?></td>
                            <td class="text-right"><?= $p['y_on_y'] ?></td>
                        </tr>
                    <?php 
                    $no++; 
                    $tot_jumlah_bulan_awal  += $p['tot_jumlah_bulan_awal'];
                    $tot_jumlah_bulan_akhir += $p['tot_jumlah_bulan_akhir'];
                    $tot_jumlah_tahun_awal  += $p['tot_jumlah_tahun_awal'];
                    $tot_jumlah_tahun_akhir += $p['tot_jumlah_tahun_akhir'];
                    $m_on_m                 += (int) $p['m_on_m'];
                    $y_on_y                 += (int) $p['y_on_y'];
                
                    endforeach; ?>
                    <tr>
                        <th colspan="2" class="text-right">Jumlah 10 Negara</th>
                        <th class="text-right"><?= $tot_jumlah_bulan_awal ?></th>
                        <th class="text-right"><?= $tot_jumlah_bulan_akhir ?></th>
                        <th class="text-right"><?= $tot_jumlah_tahun_awal ?></th>
                        <th class="text-right"><?= $tot_jumlah_tahun_akhir ?></th>
                        <th class="text-right"><?= number_format($m_on_m,2) ?></th>
                        <th class="text-right"><?= number_format($y_on_y,2) ?></th>
                    </tr>

                    <tr>
                        <th colspan="2" class="text-right">Lainnya</th>
                        <th class="text-right"><?= $lainnya_negara[0]['tot_jumlah_bulan_awal'] ?></th>
                        <th class="text-right"><?= $lainnya_negara[0]['tot_jumlah_bulan_akhir'] ?></th>
                        <th class="text-right"><?= $lainnya_negara[0]['tot_jumlah_tahun_awal'] ?></th>
                        <th class="text-right"><?= $lainnya_negara[0]['tot_jumlah_tahun_akhir'] ?></th>
                        <th class="text-right"><?= number_format($lainnya_negara[0]['m_on_m'],2) ?></th>
                        <th class="text-right"><?= number_format($lainnya_negara[0]['y_on_y'],2) ?></th>
                    </tr>

                    <tr>
                        <th colspan="2" class="text-right">Jumlah Wisman</th>
                        <th class="text-right"><?= $tot_jumlah_bulan_awal + $lainnya_negara[0]['tot_jumlah_bulan_awal'] ?></th>
                        <th class="text-right"><?= $tot_jumlah_bulan_akhir + $lainnya_negara[0]['tot_jumlah_bulan_akhir']?></th>
                        <th class="text-right"><?= $tot_jumlah_tahun_awal + $lainnya_negara[0]['tot_jumlah_tahun_awal']?></th>
                        <th class="text-right"><?= $tot_jumlah_tahun_akhir + $lainnya_negara[0]['tot_jumlah_tahun_akhir'] ?></th>
                        <th class="text-right"><?= number_format($m_on_m + $lainnya_negara[0]['m_on_m'],2) ?></th>
                        <th class="text-right"><?= number_format($y_on_y + $lainnya_negara[0]['y_on_y'],2) ?></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
