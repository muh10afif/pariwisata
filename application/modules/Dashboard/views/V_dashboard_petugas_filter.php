<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">location_city</i>
            </div>
            <p class="card-category">Total Rekap Destinasi Wisatawan Nusantara</p>
            <h3 class="card-title mb-3"><?= ($tot_dtw_wisnus['total'] == '') ? '0' : $tot_dtw_wisnus['total'] ?>
              <small>Wisatawan</small>
            </h3>
          </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                <i class="material-icons">public</i>
                </div>
                <p class="card-category">Total Rekap Destinasi Wisatawan Mancanegara</p>
                <h3 class="card-title mb-3"><?= ($tot_dtw_wisman['total'] == '') ? '0' : $tot_dtw_wisman['total'] ?>
                <small>Wisatawan</small>
                </h3>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
                <i class="material-icons">location_city</i>
            </div>
            <p class="card-category">Total Rekap Akomodasi Wisatawan Nusantara</p>
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
            <p class="card-category">Total Rekap Akomodasi Wisatawan Mancanegara</p>
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
            <div class="card-header card-header-rose">
                <h3 class="card-title">DTW</h3>
            </div>

            <div class="card-body table-responsive">
                <canvas id="myChart_dtw2" width="40" height="10"></canvas>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header card-header-info">
                <h3 class="card-title">DTW Wisnus</h3>
            </div>

            <div class="card-body table-responsive">
                <canvas id="myChart_dtw_wisnus2" width="40" height="15"></canvas>
            </div>

        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header card-header-warning">
                <h3 class="card-title">DTW Wisman</h3>
            </div>

            <div class="card-body table-responsive">
                <canvas id="myChart_dtw_wisman2" width="40" height="15"></canvas>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-rose">
                <h3 class="card-title">Akomodasi</h3>
            </div>

            <div class="card-body table-responsive">
                <canvas id="myChart_hotel2" width="40" height="10"></canvas>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header card-header-info">
                <h3 class="card-title">Akomodasi Wisnus</h3>
            </div>

            <div class="card-body table-responsive">
                <canvas id="myChart_hotel_wisnus2" width="40" height="15"></canvas>
            </div>

        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header card-header-warning">
                <h3 class="card-title">Akomodasi Wisman</h3>
            </div>

            <div class="card-body table-responsive">
                <canvas id="myChart_hotel_wisman2" width="40" height="15"></canvas>
            </div>

        </div>
    </div>
</div>

<?php 

    foreach ($dtw_petugas as $d) {
        $nama[]   = ucwords(strtolower($d->nama_dtw));
        $jumlah[] = $d->jumlah;
        $wisnus[] = $d->jumlah_wisnus;
        $wisman[] = $d->jumlah_wisman;
    }

    foreach ($dtw_petugas_wisnus as $d) {
        $nama_du[]   = ucwords(strtolower($d->nama_provinsi));
        $wisnus_du[] = $d->jumlah_wisnus;
    }

    foreach ($dtw_petugas_wisman as $d) {
        $nama_dm[]   = ucwords(strtolower($d->nama_negara));
        $wisman_dm[] = $d->jumlah_wisman;
    }

    foreach ($hotel_petugas as $d) {
        $nama_h[]   = ucwords(strtolower($d->nama_hotel));
        $jumlah_h[] = $d->jumlah;
        $wisnus_h[] = $d->jumlah_wisnus;
        $wisman_h[] = $d->jumlah_wisman;
    }

    foreach ($hotel_petugas_wisnus as $d) {
        $nama_hdu[]   = ucwords(strtolower($d->nama_provinsi));
        $wisnus_hdu[] = $d->jumlah_wisnus;
    }

    foreach ($hotel_petugas_wisman as $d) {
        $nama_hdm[]   = ucwords(strtolower($d->nama_negara));
        $wisman_hdm[] = $d->jumlah_wisman;
    }

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script> 

<script>
    
    var dtw             = document.getElementById('myChart_dtw2').getContext('2d');
    var dtw_wisnus      = document.getElementById('myChart_dtw_wisnus2').getContext('2d');
    var dtw_wisman      = document.getElementById('myChart_dtw_wisman2').getContext('2d');
    var hotel           = document.getElementById('myChart_hotel2').getContext('2d');
    var hotel_wisnus    = document.getElementById('myChart_hotel_wisnus2').getContext('2d');
    var hotel_wisman    = document.getElementById('myChart_hotel_wisman2').getContext('2d');

    // diagram dtw wisnus wisman
    var myChart_dtw = new Chart(dtw, {
        type: 'bar',
        data: {
            labels: <?= json_encode($nama) ?>,
            datasets: [{
                label: 'Wisnus',
                data: <?= json_encode($wisnus) ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                ],
                borderWidth: 1
            }, {
                label: 'Wisman',
                data: <?= json_encode($wisman) ?>,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    
                ],
                borderColor: [
                'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
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
            }
        }
    });

    // diagram dtw wisnus
    var myChart_dtw_wisnus = new Chart(dtw_wisnus, {
        type: 'bar',
        data: {
            labels: <?= json_encode($nama_du) ?>,
            datasets: [{
                label: 'Total',
                data: <?= json_encode($wisnus_du) ?>,
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

    // diagram dtw wisman
    var myChart_dtw_wisman = new Chart(dtw_wisman, {
        type: 'bar',
        data: {
            labels: <?= json_encode($nama_dm) ?>,
            datasets: [{
                label: 'Total',
                data: <?= json_encode($wisman_dm) ?>,
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

    // diagram hotel wisnus wisman
    var myChart_hotel = new Chart(hotel, {
        type: 'bar',
        data: {
            labels: <?= json_encode($nama_h) ?>,
            datasets: [{
                label: 'Wisnus',
                data: <?= json_encode($wisnus_h) ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 99, 132, 1)',
                ],
                borderWidth: 1
            }, {
                label: 'Wisman',
                data: <?= json_encode($wisman_h) ?>,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
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
            }
        }
    });

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