<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
                <i class="material-icons">location_city</i>
            </div>
            <p class="card-category">Total Rekap Hotel Wisatawan Nusantara</p>
            <h3 class="card-title mb-3"><?= ($tot_hotel_wisnus['total'] == '') ? '0' : $tot_hotel_wisnus['total'] ?>
                <small>Wisatawan</small>
            </h3>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
            <div class="card-icon">
                <i class="material-icons">public</i>
            </div>
            <p class="card-category">Total Rekap Hotel Wisatawan Mancanegara</p>
            <h3 class="card-title mb-3"><?= ($tot_hotel_wisman['total'] == '') ? '0' : $tot_hotel_wisman['total'] ?>
                <small>Wisatawan</small>
            </h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title">Akomodasi Wisnus</h3>
            </div>

            <div class="card-body table-responsive">
                <canvas id="myChart_hotel_wisnus2" width="40" height="10"></canvas>
            </div>

        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success">
                <h3 class="card-title">Akomodasi Wisman</h3>
            </div>

            <div class="card-body table-responsive">
                <canvas id="myChart_hotel_wisman2" width="40" height="10"></canvas>
            </div>

        </div>
    </div>
</div>

<?php 

    foreach ($hotel_level_wisnus as $d) {
        $nama_hdu[]   = ucwords(strtolower($d->nama_provinsi));
        $wisnus_hdu[] = $d->jumlah_wisnus;
    }

    foreach ($hotel_level_wisman as $d) {
        $nama_hdm[]   = ucwords(strtolower($d->nama_negara));
        $wisman_hdm[] = $d->jumlah_wisman;
    }

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script> 

<script>

    var hotel_wisnus    = document.getElementById('myChart_hotel_wisnus2').getContext('2d');
    var hotel_wisman    = document.getElementById('myChart_hotel_wisman2').getContext('2d');

    // diagram hotel wisnus
    var myChart_hotel_wisnus = new Chart(hotel_wisnus, {
        type: 'bar',
        data: {
            labels: <?= json_encode($nama_hdu) ?>,
            datasets: [{
                label: 'Total',
                data: <?= json_encode($wisnus_hdu) ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }],
                xAxes: [{
                    ticks: {
                        callback: function(label) {
                            if (/\s/.test(label)) {
                                return label.split(" ");
                            }else{
                                return label;
                            }              
                        }
                    }
                }]
            },
            legend: {
                display: false
            }
        }
    });

    // diagram hotel wisman
    var myChart_hotel_wisman = new Chart(hotel_wisman, {
        type: 'bar',
        data: {
            labels: <?= json_encode($nama_hdm) ?>,
            datasets: [{
                label: 'Total',
                data: <?= json_encode($wisman_hdm) ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }],
                xAxes: [{
                    ticks: {
                        callback: function(label) {
                            if (/\s/.test(label)) {
                                return label.split(" ");
                            }else{
                                return label;
                            }              
                        }
                    }
                }]
            },
            legend: {
                display: false
            }
        }
    });

</script>