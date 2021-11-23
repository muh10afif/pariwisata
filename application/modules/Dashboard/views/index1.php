<div class="container-fluid">
  <div class="row">

  <?php $level = $this->session->userdata('level'); ?>

    <?php if ($level == 'petugas' || $level == 'kota' || $level == 'admin') : ?>

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

    <?php endif; ?>

    <?php if ($level == 'dtw') : ?>
    
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
    <?php endif; ?>

    <?php if ($level == 'hotel') : ?>

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
    <?php endif; ?>

  </div>
  <canvas id="myChart" width="400" height="400"></canvas>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script> 

<script>
var ctx = document.getElementById('myChart').getContext('2d');

  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
          datasets: [{
              label: '# of Votes',
              data: [12, 19, 3, 5, 2, 3],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
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
                  'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1
          },{
              label: '# terr',
              data: [12, 19, 3, 5, 2, 3],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
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
              }]
          }
      }
  });
</script>

    