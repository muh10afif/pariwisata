<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap DTW <?= ucfirst($jenis) ?></title>

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

        tr th {
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

    </style>

</head>
<body>

    <?php if ($kondisi == 'lihat'): ?>
        <form method="POST" target="_self" id="tab" action="<?= base_url("Rekap/Dtw/tampil_lihat_detail_all/$jenis/unduh") ?>">
            
            <input type="hidden" name="bln_awal" value="<?= $bln_awal ?>">
            <input type="hidden" name="bln_akhir" value="<?= $bln_akhir ?>">
            <input type="hidden" name="jenis_report" value="<?= $jenis ?>">

            <button name="excel" class="btn btn-success">UNDUH - EXCEL</button>

        </form><br>
    <?php endif ?>

    <?php if ($jenis_report == 'rekap_wisnus_dtw') : ?>
        <h5 style="font-weight: bold;">Report Wisatawan Nusantara</h5>
    <?php else : ?>
        <h5 style="font-weight: bold;">Report Wisatawan Mancanegara</h5>
    <?php endif ?>

    <h5><?= $bln_awal ?> s/d <?= $bln_akhir ?></h5>

    <br>

    <table border="1" width="100%">
        <thead class="thead-light">
            <tr>
                <th>No.</th>
                <th>Nama DTW / Kota</th>
                <?php foreach ($bulan as $c): ?>
                <th><?= nice_date($c, 'F-Y') ?></th>
                <?php endforeach ?>
                <th><?= ($jenis_report == 'rekap_wisnus_dtw') ? 'Wisatawan Nusantara' : 'Wisatawan Mancanegara' ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach ($kota as $k): ?>
                <tr>
                    <td align="center"><b><?= $no; ?>.</b></td>
                    <td><b><?= $k['nama_kota'] ?></td>

                    <?php $tot_wisnus=0; foreach ($bulan as $c): ?>
                        
                        <?php $hasil = $this->M_dtw->get_dtw_rekap_bulan_all($c, $jenis_report, $k['id_kota'])->row_array(); ?>

                        <td align="center"><b><?= ($hasil['tot_dtw'] == '') ? '0' : $hasil['tot_dtw'] ?></b></td>

                    <?php 

                        $tot_wisnus += $hasil['tot_dtw'];
                    
                    endforeach ?>

                    <td align="center"><b><?= $tot_wisnus ?></b></td>

                </tr>

                <?php $cari = $this->M_dtw->cari_data_order('dtw', array('id_kota' => $k['id_kota']), 'nama_dtw', 'asc')->result_array(); ?>

                <?php foreach ($cari as $c): ?>

                    <tr>
                        <td align="center">-</td>
                        <td><?= $c['nama_dtw'] ?></td>

                        <?php $tot_wisnus=0; foreach ($bulan as $b): ?>
                        
                            <?php $hasil = $this->M_dtw->get_per_dtw_rekap_bulan_all($b, $jenis_report, $c['id_dtw'])->row_array(); ?>

                            <td align="center"><?= ($hasil['tot_dtw'] == '') ? '0' : $hasil['tot_dtw'] ?></td>

                        <?php 

                            $tot_wisnus += $hasil['tot_dtw'];
                        
                        endforeach ?>

                        <td align="center"><?= $tot_wisnus ?></td>

                    </tr>
                
                <?php endforeach; ?>

                
            <?php $no++; endforeach; ?>
        </tbody>
    </table>
    
</body>
</html>

