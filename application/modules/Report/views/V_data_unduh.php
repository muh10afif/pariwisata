<style>
    .a tr td {
      font-weight: bold;
    }
</style>
<?php if ($kondisi == 'unduh'): ?>

    <style>
        #tbl_data thead th {
            background-color: #122E5D; color: white;
        }
        h5, h6 {
            font-weight: bold;
            text-align: center;
        }
    </style>

<?php endif; ?>
<div class="card">
    <div class="card-body">

        <?php if ($kondisi == 'lihat'): ?>
        
            <form action="<?= base_url('Report/menampilkan_data_unduh/unduh') ?>" method="POST">
                <input type="hidden" name="jenis_report" value="<?= $jenis ?>">
                <input type="hidden" name="start" value="<?= $start ?>">
                <input type="hidden" name="end" value="<?= $end ?>">
                <input type="hidden" name="kondisi" value="unduh">
                <button class="btn btn-sm btn-success float-left" type="submit">Unduh Excel</button>
            </form>

        <?php endif; ?>

        <?php if ($kondisi == 'unduh'): ?>

            <h5 style="font-weight: bold;">Data <?= ucwords($jenis) ?></h5>

            <table class="a">

                <?php if(!empty($start)) : ?>
                    <tr>
                        <td width="150px">Bulan Awal</td>
                        <td>: <?= $start ?></td>
                    </tr>
                <?php endif ?>
                <?php if(!empty($end)) : ?>
                    <tr>
                        <td width="150px">Bulan Akhir</td>
                        <td>: <?= $end ?></td>
                    </tr>
                <?php endif ?>
                
            </table><?= br() ?>

        <?php endif; ?>
        
        <table border="1" id="tbl_data" class="table table-light table-bordered table-hover table-striped" width="100%" >
            <thead class="thead-light">
                <th width="10%">Bulan</th>
                <th>Nama Kota</th>
                <th>Nama <?= ucfirst($jenis) ?></th>
                <th>Kategori Wisatawan</th>
                <th>Asal</th>
                <th>Pria</th>
                <th>Wanita</th>
                <th>Jumlah</th>
            </thead>
            <tbody>
                <?php 

                $data = "data_$jenis";
                
                foreach ($$data as $key => $value): ?>
                
                    <?php foreach ($value as $d): 
                        
                        $nm = "nama_$jenis";

                    ?>

                        <tr>
                            <td><?= $d['bulan'] ?></td>
                            <td><?= $d['nama_kota'] ?></td>
                            <td><?= $d[$nm] ?></td>
                            <td><?= $d['kategori'] ?></td>
                            <td><?= $d['asal'] ?></td>
                            <td><?= $d['pria'] ?></td>
                            <td><?= $d['wanita'] ?></td>
                            <td><?= $d['jumlah'] ?></td>
                        </tr>
                    
                    <?php endforeach; ?>
                
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>

$(document).ready(function () {
    
    $('#tbl_data').DataTable({
        "paging"    : false,
        "columnDefs"        : [{
            "targets"   : [],
            "orderable" : false
        }, {
            'targets'   : [0,3,4,5,6,7],
            'className' : 'text-center',
        }]
    })

})

</script>