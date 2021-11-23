<style>
    .a tr td {
      font-weight: bold;
    }
</style>

<style>
    #tbl_data thead th {
        background-color: #122E5D; color: white;
    }
    h5, h6 {
        font-weight: bold;
        text-align: center;
    }
</style>

<div class="card">
    <div class="card-body">

        <h5 style="font-weight: bold;">Data <?= ucwords($jenis) ?></h5>

        <table class="a">

            <?php if(!empty($periode)) : ?>
                <tr>
                    <td width="150px">Periode</td>
                    <td>: <?= $periode ?></td>
                </tr>
            <?php endif ?>
            
        </table><?= br() ?>
        
        <table border="1" width="100%" >
            <thead>
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