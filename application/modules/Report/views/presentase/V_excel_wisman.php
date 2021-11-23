<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

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
        thead th{
            background-color: #122E5D; color: white;
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

<h5 style="font-weight: bold;">Perbandingan Wisatawan Mancanegara</h5>

<br>

<table class="a">

    <?php if(!empty($kota)) : ?>
        <tr>
            <td width="150px">Kab / Kota</td>
            <td>: <?= ucwords(strtolower($kota)) ?></td>
        </tr>
    <?php endif ?>
    <?php if(!empty($bulan_awal)) : ?>
        <tr>
            <td width="150px">Bulan Awal</td>
            <td>: <?= $bulan_awal ?></td>
        </tr>
    <?php endif ?>
    <?php if(!empty($bulan_akhir)) : ?>
        <tr>
            <td width="150px">Bulan Akhir</td>
            <td>: <?= $bulan_akhir ?></td>
        </tr>
    <?php endif ?>
    <?php if($jenis_data != '-') : ?>
        <tr>
            <td width="150px">Nama <?= ucwords(strtolower($jenis_data)) ?></td>
            <td>: <?= $nama_dtw_hotel ?></td>
        </tr>
    <?php endif ?>
    <?php if($id_dtw_hotel == 'all') : ?>
        <tr>
            <td width="150px">Jenis Data</td>
            <td>: <?= ucwords($jenis_data) ?></td>
        </tr>
    <?php endif ?>
    
</table><?= br() ?>

<table border="1" width="100%">
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
        $m_on_m                 += $p['m_on_m'];
        $y_on_y                 += $p['y_on_y'];
    
        endforeach; ?>
        <tr>
            <th colspan="2" class="text-right">Jumlah 10 Negara</th>
            <th class="text-right"><?= $tot_jumlah_bulan_awal ?></th>
            <th class="text-right"><?= $tot_jumlah_bulan_akhir ?></th>
            <th class="text-right"><?= $tot_jumlah_tahun_awal ?></th>
            <th class="text-right"><?= $tot_jumlah_tahun_akhir ?></th>
            <th class="text-right"><?= $m_on_m ?></th>
            <th class="text-right"><?= $y_on_y ?></th>
        </tr>

        <tr>
            <th colspan="2" class="text-right">Lainnya</th>
            <th class="text-right"><?= $lainnya_negara[0]['tot_jumlah_bulan_awal'] ?></th>
            <th class="text-right"><?= $lainnya_negara[0]['tot_jumlah_bulan_akhir'] ?></th>
            <th class="text-right"><?= $lainnya_negara[0]['tot_jumlah_tahun_awal'] ?></th>
            <th class="text-right"><?= $lainnya_negara[0]['tot_jumlah_tahun_akhir'] ?></th>
            <th class="text-right"><?= $lainnya_negara[0]['m_on_m'] ?></th>
            <th class="text-right"><?= $lainnya_negara[0]['y_on_y'] ?></th>
        </tr>

        <tr>
            <th colspan="2" class="text-right">Jumlah Wisman</th>
            <th class="text-right"><?= $tot_jumlah_bulan_awal + $lainnya_negara[0]['tot_jumlah_bulan_awal'] ?></th>
            <th class="text-right"><?= $tot_jumlah_bulan_akhir + $lainnya_negara[0]['tot_jumlah_bulan_akhir']?></th>
            <th class="text-right"><?= $tot_jumlah_tahun_awal + $lainnya_negara[0]['tot_jumlah_tahun_awal']?></th>
            <th class="text-right"><?= $tot_jumlah_tahun_akhir + $lainnya_negara[0]['tot_jumlah_tahun_akhir'] ?></th>
            <th class="text-right"><?= $m_on_m + $lainnya_negara[0]['m_on_m'] ?></th>
            <th class="text-right"><?= $y_on_y + $lainnya_negara[0]['y_on_y'] ?></th>
        </tr>
    </tbody>
</table>


</body>
</html>