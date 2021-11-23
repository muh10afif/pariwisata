<div class="card">
    <div class="card-header card-header-tabs card-header-rose">
        <div class="nav-tabs-navigation">
            <div class="nav-tabs-wrapper">
            <h3 class="float-left" style="margin-top: -1px;">Unduh Database</h3>
            </div>
        </div>
    </div>

    <form action="<?= base_url('Report/report') ?>" target="_blank" id="form_unduh" method="POST">

    <input type="hidden" name="kondisi" value="lihat">
    
    <div class="card-body">
        <div class="d-flex justify-content-center">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <span class="font-weight-bold">Jenis Report</span>
                        </div>
                        <div class="col-md-9">
                            <select class="form-control" id="jenis" name="jenis_report" required>
                                <option value="">-- Pilih Jenis Report --</option>
                                <option value="dtw">DTW</option>
                                <option value="hotel">Hotel</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <span class="font-weight-bold">Periode</span>
                        </div>
                        <div class="col-md-9">
                            <div class="input-daterange input-group">
                                <input type="text" class="form-control datepicker12 text-center" name="start" id="start" placeholder="Awal Periode" readonly required>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-secondary b-0 text-white">s / d</span>
                                </div>
                                <input type="text" class="form-control datepicker12 text-center" name="end" id="end" placeholder="Akhir Periode" readonly required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
    <div class="card-footer">

        <div class="col-md-12" align="right">
            <button type="button" class="btn btn-sm btn-success" name="tampilkan" id="tampilkan">Tampilkan</button><?= nbs(3) ?>
            <button class="btn btn-sm btn-dark" id="reset" type="button">Reset</button>
        </div>

    </div>

    
</div>

<div class="data-database">

</div>



<script>



$(document).ready(function () {
    
    $('#tampilkan').on('click', function () {

        var jenis = $('#jenis').val();
        var start = $('#start').val();
        var end   = $('#end').val();
        var form  = $('#form_unduh').serialize();

        if (jenis == '') {
            swal({
                title               : "Peringatan",
                text                : 'Jenis Report harus terisi!',
                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-success",
                type                : 'warning',
                showConfirmButton   : false,
                timer               : 1000
            }); 

            return false;
        } else if (start == '') {
            swal({
                title               : "Peringatan",
                text                : 'Periode Awal Bulan harus terisi!',
                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-success",
                type                : 'warning',
                showConfirmButton   : false,
                timer               : 1000
            }); 

            return false;
        } else if (end == '') {
            swal({
                title               : "Peringatan",
                text                : 'Periode AKhir Bulan harus terisi!',
                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-success",
                type                : 'warning',
                showConfirmButton   : false,
                timer               : 1000
            }); 

            return false;
        } else {
            
            $.ajax({
                url     : "menampilkan_data_unduh",
                type    : "POST",
                beforeSend  : function () {
                    swal({
                        title   : 'Menunggu',
                        html    : 'Memproses data',
                        onOpen  : () => {
                            swal.showLoading();
                        }
                    })
                },
                data    : form,
                success : function (data) { 

                    swal.close();

                    $('.data-database').removeAttr('hidden');
                    $('.data-database').html(data);

                }
            })

            return false;

        }
        
    })
    
    $('#reset').on('click', function () {
        $('#form_unduh').trigger('reset');

        $('.data-database').attr('hidden', true);
    })
})

</script>