<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dtw extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_dtw');
    }

    public function index()
    {
        if (!empty($this->userdata)) {
            $data['userdata']   = $this->userdata;
            $data['Menu']       = "Kelolaan";
            $data['Page']       = "Kelolaan DTW";
            $data['provinsi']   = $this->M_dtw->get_provinsi();
            $data['dtw']        = $this->M_dtw->get_dtw_list();
            $data['kawasan']    = $this->M_dtw->get_data('kawasan', 'nama_kawasan')->result_array();
            $data['asia']       = $this->M_dtw->asia();
            $data['afrika']     = $this->M_dtw->afrika();
            $data['amerika']    = $this->M_dtw->amerika();
            $data['australia']  = $this->M_dtw->australia();
            $data['eropa']      = $this->M_dtw->eropa();
            $data['per_awal']   = date('d-F-Y', now('Asia/Jakarta'));

            $this->template->views('V_dtw', $data);
        }
    }

    // 12-03-2020

        // mengambil tanggal 
        public function ambil_periode()
        {
            $periode = nice_date($this->input->post('periode'), 'd-F-Y');

            echo json_encode(['periode' => $periode]);
            
        }

    // Akhir 12-03-2020

    public function tes()
    {
        echo date('d-F-Y', now('Asia/Jakarta'));

        if ('29-December-2019' == '29-December-2019') {
            echo 'sama';
        } else {
            echo 'beda';
        }
    }

    // menampilkan data dtw dengan json
    public function tampil_dtw()
    {   
        $periode    = $this->input->post('periode');
        $id_pegawai = $this->input->post('id_pegawai');

        $per_awal   = date('d-F-Y', now('Asia/Jakarta'));
              
        $data_dtw = $this->M_dtw->get_dtw_petugas_2($id_pegawai)->result_array();

        $no =1;
        foreach ($data_dtw as $value) {

            if ($periode == '') {
                $periode = $per_awal;
            } else {
                $periode = $periode;
            }

            $cek_wisnus = $this->M_dtw->cek_wisnusman_petugas('rekap_wisnus_dtw', $periode, $per_awal, $id_pegawai, $value['id_dtw']);
            $cek_wisman = $this->M_dtw->cek_wisnusman_petugas('rekap_wisman_dtw', $periode, $per_awal, $id_pegawai, $value['id_dtw']);

            if ($cek_wisman != 0 || $cek_wisnus != 0) {
                $status = '<span class="badge badge-success">Data Sudah Ada</span>';
            } else {
                $status = '<span class="badge badge-warning">Data Belum Ada</span>';
            }

            $tbody = array();
            $tbody[] = "<div align='center'>".$no++.".</div>";
            $tbody[] = $value['nama_dtw'];
            $tbody[] = $value['alamat'];
            $tbody[] = $value['email'];
            $tbody[] = $value['no_hp'];
            $tbody[] = $status;
            $tbody[] = "<button class='btn btn-rose btn-sm input-dtw' data-id='".$value['id_dtw']."' nm-dtw='".$value['nama_dtw']."' tgl-periode='".$periode."'>Input Data</button>";
            $data[]  = $tbody; 
        }

        if ($data_dtw ) {
            echo json_encode(array('data'=> $data));
        }else{
            echo json_encode(array('data'=>0));
        }
    }

    // halaman admin hotel 
    public function input_dtw($jenis)
    {
        $id_dtw = $this->userdata->id_dtw;

        $nm_dtw = $this->M_dtw->cari_data('dtw', array('id_dtw' => $id_dtw))->row_array();

        $data = [   'Menu'      => 'input_dtw',
                    'Page'      => $jenis,
                    'judul'     => "Input $jenis",
                    'userdata'  => $this->userdata,
                    'id_dtw'    => $id_dtw,
                    'nama_dtw'  => $nm_dtw['nama_dtw'],
                    'kawasan'   => $this->M_dtw->get_data('kawasan', 'nama_kawasan')->result_array(),
                    'provinsi'  => $this->M_dtw->get_provinsi(),
                    'hotel'     => $this->M_dtw->get_dtw_list(),
                    'asia'      => $this->M_dtw->asia(),
                    'afrika'    => $this->M_dtw->afrika(),
                    'amerika'   => $this->M_dtw->amerika(),
                    'australia' => $this->M_dtw->australia(),
                    'eropa'     => $this->M_dtw->eropa()
                ];

        $this->template->views("V_dtw_$jenis", $data);
    }

    // ambil negara dropdown
    public function ambil_negara()
    {
        $id_kawasan = $this->input->post('id_kawasan');
        $aksi       = $this->input->post('aksi');
        $periode    = $this->input->post('periode');
        $id_dtw     = $this->input->post('id_dtw');

        if ($id_kawasan == "x") {
            $option = "<option value='x'>-- Pilih Negara --</option>";
            $ds     = "disabled";
        } else {

            if ($aksi == 'cari_negara') {
                $list_negara = $this->M_dtw->cari_negara_rekap_wisman($periode, $id_dtw, $id_kawasan)->result_array();          
            } else {
                $list_negara = $this->M_dtw->cari_data_o('negara', array('id_kawasan' => $id_kawasan), 'nama_negara')->result_array();
            }

            $option = "<option value='x'>-- Pilih Negara --</option>";

            foreach ($list_negara as $a) {
                $option .= "<option value='".$a['id_negara']."'>".$a['nama_negara']."</option>";
            }

            $ds     = "aktif";
        }

        $data = ['negara'    => $option, 'ds' => $ds];

        echo json_encode($data);
    }

    // menampilkan list dtw status 0
    public function tampil_list_dtw()
    {
        $periode = nice_date($this->input->post('periode'), 'd-F-Y');
        $id_dtw  = $this->input->post('id_dtw');
        
        $list = $this->M_dtw->get_data_list('rekap_wisnus_dtw', $periode, array('id_dtw' => $id_dtw))->result_array();
        $no =1;
        foreach ($list as $value) {
            $tbody = array();
            $tbody[] = "<div align='center'>".$no++.".</div>";
            $tbody[] = $value['nama_provinsi'];
            $tbody[] = $value['pengunjung_pria'];
            $tbody[] = $value['pengunjung_wanita'];
            $tbody[] = $value['jumlah_pengunjung'];
            $aksi= "<div align='center' width='10%'> <button class='btn btn-warning btn-sm ubah-dtw' type='button' data-id=".$value['id_rekap_wisnus_dtw'].">Edit</button>".' '."<button class='btn btn-danger btn-sm hapus-dtw' type='button' data-id=".$value['id_rekap_wisnus_dtw'].">Hapus</button> </div>";
            $tbody[] = $aksi;
            $data[]  = $tbody; 
        }

        if ($list) {
            echo json_encode(array('data'=> $data));
        }else{
            echo json_encode(array('data'=> 0));
        }
    }

    // menampilkan list dtw wisman status 0
    public function tampil_list_dtw_wisman()
    {
        $periode = nice_date($this->input->post('periode'), 'd-F-Y');
        $id_dtw  = $this->input->post('id_dtw');
        
        $list = $this->M_dtw->get_data_list_dtw_wisman($periode, $id_dtw)->result_array();
        $no =1;
        foreach ($list as $value) {
            $tbody = array();
            $tbody[] = "<div align='center'>".$no++.".</div>";
            $tbody[] = $value['nama_kawasan'];
            $tbody[] = $value['nama_negara'];
            $tbody[] = $value['pengunjung_pria'];
            $tbody[] = $value['pengunjung_wanita'];
            $tbody[] = $value['jumlah_pengunjung'];
            $aksi= "<div align='center'> <button class='btn btn-warning btn-sm ubah-dtw-wisman' type='button' data-id=".$value['id_rekap_wisman_dtw'].">Edit</button>".' '."<button class='btn btn-danger btn-sm hapus-dtw-wisman' type='button' data-id=".$value['id_rekap_wisman_dtw'].">Hapus</button> </div>";
            $tbody[] = $aksi;
            $data[]  = $tbody; 
        }

        if ($list) {
            echo json_encode(array('data'=> $data));
        }else{
            echo json_encode(array('data'=>0));
        }
    }

    // proses simpan list
    public function simpan_list()
    {
        $periode             = nice_date($this->input->post('periode'), 'd-F-Y');
        $pria                = ($this->input->post('pria') == '') ? '0' : $this->input->post('pria');
        $wanita              = ($this->input->post('wanita') == '') ? '0' : $this->input->post('wanita');
        $jumlah              = $this->input->post('jumlah');
        $provinsi            = $this->input->post('provinsi');
        $id_dtw              = $this->input->post('id_dtw');
        $jns                 = $this->input->post('data');
        $aksi                = $this->input->post('aksi');
        $id_rekap_wisnus_dtw = $this->input->post('id_rekap_wisnus_dtw');
        

        $cr = $this->M_dtw->cari_data('penempatan_dtw', array('id_dtw' => $id_dtw))->row_array();
        
        if ($jns != 'lihat') {

            if ($aksi == 'tambah_baru') {

                $this->M_dtw->ubah_data('rekap_wisnus_dtw', array('status'  => 3), array('id_rekap_wisnus_dtw' => $id_rekap_wisnus_dtw));

                $data = ['id_dtw'           => $id_dtw,
                         'pengunjung_pria'  => $pria,
                         'pengunjung_wanita'=> $wanita,
                         'jumlah_pengunjung'=> $jumlah,
                         'id_provinsi'      => $provinsi,
                         'add_by'           => $cr['id_pegawai'],
                         'status'           => 1,
                         'periode'          => $periode
                        ];
                
                $this->M_dtw->input_data('rekap_wisnus_dtw', $data);

            } elseif ($aksi == 'ubah_jumlah_data') {

                $this->M_dtw->ubah_data('rekap_wisnus_dtw', array('status'  => 2), array('id_rekap_wisnus_dtw' => $id_rekap_wisnus_dtw));
                
                $cr_data = $this->M_dtw->cari_data('rekap_wisnus_dtw', array('id_rekap_wisnus_dtw' => $id_rekap_wisnus_dtw))->row_array();

                $cr_pria    = $cr_data['pengunjung_pria'];
                $cr_wanita  = $cr_data['pengunjung_wanita'];
                $cr_jumlah  = $cr_data['jumlah_pengunjung'];

                $dt = [ 'id_dtw'            => $id_dtw,
                        'pengunjung_pria'   => $cr_pria + $pria,
                        'pengunjung_wanita' => $cr_wanita + $wanita,
                        'jumlah_pengunjung' => $cr_jumlah + $jumlah,
                        'id_provinsi'       => $provinsi,
                        'add_by'            => $cr['id_pegawai'],
                        'status'            => 1,
                        'periode'           => $periode
                        ];

                $this->M_dtw->input_data('rekap_wisnus_dtw', $dt);
                
            } else {

                $data = ['id_dtw'           => $id_dtw,
                         'pengunjung_pria'  => $pria,
                         'pengunjung_wanita'=> $wanita,
                         'jumlah_pengunjung'=> $jumlah,
                         'id_provinsi'      => $provinsi,
                         'add_by'           => $cr['id_pegawai'],
                         'status'           => 1,
                         'periode'          => $periode
                        ];
                
                $this->M_dtw->input_data('rekap_wisnus_dtw', $data);

            }

        }

        $jenis_data = $this->input->post('jenis_data');

        if ($jenis_data == 'wisnus') {
            // cari total jumlah
            $tot_j = $this->M_dtw->cari_tot_jml_dtw('rekap_wisnus_dtw', $periode, $id_dtw)->row_array();
        } else {
            // cari total jumlah
            $tot_j = $this->M_dtw->cari_tot_jml_dtw('rekap_wisman_dtw', $periode, $id_dtw)->row_array();
        }

        // membuat dropdown provinsi
        $list = $this->M_dtw->get_provinsi_dtw($periode, $id_dtw)->result_array();

        $option = "";

        foreach ($list as $a) {
            $option .= "<option value='".$a['id_provinsi']."'>".$a['nama_provinsi']."</option>";
        }

        $dt = [ 'status'      => TRUE, 
                'tot_pria'    => $tot_j['tot_pria'], 
                'tot_wanita'  => $tot_j['tot_wanita'],
                'tot_jumlah'  => $tot_j['tot_jumlah'],
                'provinsi'    => $option,
                'periode'     => $periode
             ];
        
        echo json_encode($dt);
    }

    // proses simpan list dtw wisman
    public function simpan_list_wisman()
    {
        $periode             = nice_date($this->input->post('periode'), 'd-F-Y');
        $pria                = ($this->input->post('pria') == '') ? '0' : $this->input->post('pria');
        $wanita              = ($this->input->post('wanita') == '') ? '0' : $this->input->post('wanita');
        $jumlah              = $this->input->post('jumlah');
        $negara              = $this->input->post('negara');
        $id_dtw              = $this->input->post('id_dtw');
        $jns                 = $this->input->post('data');
        $aksi                = $this->input->post('aksi');
        $id_rekap_wisman_dtw = $this->input->post('id_rekap_wisman_dtw');
        

        $cr = $this->M_dtw->cari_data('penempatan_dtw', array('id_dtw' => $id_dtw))->row_array();
        
        if ($jns != 'lihat') {

            if ($aksi == 'tambah_baru') {

                $this->M_dtw->ubah_data('rekap_wisman_dtw', array('status'  => 3), array('id_rekap_wisman_dtw' => $id_rekap_wisman_dtw));

                $data = ['id_dtw'           => $id_dtw,
                         'pengunjung_pria'  => $pria,
                         'pengunjung_wanita'=> $wanita,
                         'jumlah_pengunjung'=> $jumlah,
                         'id_negara'        => $negara,
                         'add_by'           => $cr['id_pegawai'],
                         'status'           => 1,
                         'periode'          => $periode
                        ];
                
                $this->M_dtw->input_data('rekap_wisman_dtw', $data);

            } elseif ($aksi == 'ubah_jumlah_data') {

                $this->M_dtw->ubah_data('rekap_wisman_dtw', array('status'  => 2), array('id_rekap_wisman_dtw' => $id_rekap_wisman_dtw));
                
                $cr_data = $this->M_dtw->cari_data('rekap_wisman_dtw', array('id_rekap_wisman_dtw' => $id_rekap_wisman_dtw))->row_array();

                $cr_pria    = $cr_data['pengunjung_pria'];
                $cr_wanita  = $cr_data['pengunjung_wanita'];
                $cr_jumlah  = $cr_data['jumlah_pengunjung'];

                $dt = [ 'id_dtw'            => $id_dtw,
                        'pengunjung_pria'   => $cr_pria + $pria,
                        'pengunjung_wanita' => $cr_wanita + $wanita,
                        'jumlah_pengunjung' => $cr_jumlah + $jumlah,
                        'id_negara'         => $negara,
                        'add_by'            => $cr['id_pegawai'],
                        'status'            => 1,
                        'periode'           => $periode
                        ];

                $this->M_dtw->input_data('rekap_wisman_dtw', $dt);
                
            } else {

                $data = ['id_dtw'           => $id_dtw,
                         'pengunjung_pria'  => $pria,
                         'pengunjung_wanita'=> $wanita,
                         'jumlah_pengunjung'=> $jumlah,
                         'id_negara'        => $negara,
                         'add_by'           => $cr['id_pegawai'],
                         'status'           => 1,
                         'periode'          => $periode
                        ];
                
                $this->M_dtw->input_data('rekap_wisman_dtw', $data);

            }

        }

        // cari total jumlah
        $tot_j = $this->M_dtw->cari_tot_jml_dtw('rekap_wisman_dtw', $periode, $id_dtw)->row_array();

        $dt = [ 'status'      => TRUE, 
                'tot_pria'    => $tot_j['tot_pria'], 
                'tot_wanita'  => $tot_j['tot_wanita'],
                'tot_jumlah'  => $tot_j['tot_jumlah'],
                'periode'     => $periode
             ];
        
        echo json_encode($dt);
    }

    // simpan ubah list dtw
    public function simpan_ubah_hapus_list()
    {
        $periode             = $this->input->post('periode');
        $pria                = $this->input->post('pria');
        $wanita              = $this->input->post('wanita');
        $jumlah              = $this->input->post('jumlah');
        $id_dtw              = $this->input->post('id_dtw');
        $id_rekap_wisnus_dtw = $this->input->post('id_rekap');
        $aksi                = $this->input->post('aksi');
        
        if ($aksi == 'ubah') {
            $data = ['pengunjung_pria'  => $pria,
                    'pengunjung_wanita'=> $wanita,
                    'jumlah_pengunjung'=> $jumlah
                    ];

            $this->M_dtw->ubah_data('rekap_wisnus_dtw', $data, array('id_rekap_wisnus_dtw' => $id_rekap_wisnus_dtw));
        } else {
            $this->M_dtw->hapus_data('rekap_wisnus_dtw', array('id_rekap_wisnus_dtw' => $id_rekap_wisnus_dtw));
        }

        // cari total jumlah
        $tot_j = $this->M_dtw->cari_tot_jml_dtw('rekap_wisnus_dtw', $periode, $id_dtw)->row_array();

        // membuat dropdown provinsi
        $list = $this->M_dtw->get_provinsi_dtw($periode, $id_dtw)->result_array();

        $option = "";

        foreach ($list as $a) {
            $option .= "<option value='".$a['id_provinsi']."'>".$a['nama_provinsi']."</option>";
        }

        $dt = [ 'status'      => TRUE, 
                'tot_pria'    => $tot_j['tot_pria'], 
                'tot_wanita'  => $tot_j['tot_wanita'],
                'tot_jumlah'  => $tot_j['tot_jumlah'],
                'provinsi'    => $option
             ];
        
        echo json_encode($dt);
    }

    // simpan ubah list dtw wisman
    public function simpan_ubah_hapus_list_wisman()
    {
        $periode             = $this->input->post('periode');
        $pria                = $this->input->post('pria');
        $wanita              = $this->input->post('wanita');
        $jumlah              = $this->input->post('jumlah');
        $id_dtw              = $this->input->post('id_dtw');
        $id_rekap_wisman_dtw = $this->input->post('id_rekap');
        $aksi                = $this->input->post('aksi');
        
        if ($aksi == 'ubah') {
            $data = ['pengunjung_pria'  => $pria,
                    'pengunjung_wanita'=> $wanita,
                    'jumlah_pengunjung'=> $jumlah
                    ];

            $this->M_dtw->ubah_data('rekap_wisman_dtw', $data, array('id_rekap_wisman_dtw' => $id_rekap_wisman_dtw));
        } else {
            $this->M_dtw->hapus_data('rekap_wisman_dtw', array('id_rekap_wisman_dtw' => $id_rekap_wisman_dtw));
        }

        // cari total jumlah
        $tot_j = $this->M_dtw->cari_tot_jml_dtw('rekap_wisman_dtw', $periode, $id_dtw)->row_array();

        $dt = [ 'status'      => TRUE, 
                'tot_pria'    => $tot_j['tot_pria'], 
                'tot_wanita'  => $tot_j['tot_wanita'],
                'tot_jumlah'  => $tot_j['tot_jumlah']
             ];
        
        echo json_encode($dt);
    }

    public function simpan_list_wisnus_dtw()
    {
        $periode             = $this->input->post('periode');
        $id_dtw              = $this->input->post('id_dtw');

        $this->M_dtw->ubah_data('rekap_wisnus_dtw', array('status' => 1), array('id_dtw' => $id_dtw, 'periode' => $periode, 'status' => 0));

        // membuat dropdown provinsi
        $list = $this->M_dtw->get_provinsi();

        $option = "";

        foreach ($list as $a) {
            $option .= "<option value='".$a->id_provinsi."'>".$a->nama_provinsi."</option>";
        }

        echo json_encode(['status' => TRUE, 'provinsi' => $option]);
    }

    public function simpan_list_wisman_dtw()
    {
        $periode             = $this->input->post('periode');
        $id_dtw              = $this->input->post('id_dtw');

        $this->M_dtw->ubah_data('rekap_wisman_dtw', array('status' => 1), array('id_dtw' => $id_dtw, 'periode' => $periode, 'status' => 0));

        echo json_encode(['status' => TRUE]);
    }

    // cek provinsi
    public function cek_provinsi()
    {
        $periode = $this->input->post('periode');
        $id_dtw  = $this->input->post('id_dtw');
        $provinsi= $this->input->post('provinsi');

        $ck = $this->M_dtw->cek_provinsi($periode, $id_dtw, $provinsi);

        $d = $ck->row_array();

        $id_rekap_wisnus_dtw = $d['id_rekap_wisnus_dtw'];
        $jml_pengunjung      = $d['jumlah_pengunjung'];
        $add_time            = nice_date($d['add_time'], 'd-m-Y H:i:s');

        echo json_encode(['cek'                 => $ck->num_rows(),
                          'id_rkp_wisnus_dtw'   => $id_rekap_wisnus_dtw,
                          'jml_pengunjung'      => $jml_pengunjung,
                          'add_time'            => $add_time
                        ]);
    }

    // cek negara
    public function cek_negara()
    {
        $periode = $this->input->post('periode');
        $id_dtw  = $this->input->post('id_dtw');
        $negara  = $this->input->post('negara');

        $ck = $this->M_dtw->cek_negara($periode, $id_dtw, $negara);

        $d = $ck->row_array();

        $id_rekap_wisman_dtw = $d['id_rekap_wisman_dtw'];
        $jml_pengunjung      = $d['jumlah_pengunjung'];
        $add_time            = nice_date($d['add_time'], 'd-m-Y H:i:s');

        echo json_encode(['cek'                 => $ck->num_rows(),
                          'id_rkp_wisman_dtw'   => $id_rekap_wisman_dtw,
                          'jml_pengunjung'      => $jml_pengunjung,
                          'add_time'            => $add_time
                        ]);
    }

    // menampilakan data ubah dtw
    public function tampil_data_ubah_dtw()
    {
        $id_rekap_wisnus_dtw = $this->input->post('id_rekap_wisnus_dtw');

        $data = $this->M_dtw->cari_data('rekap_wisnus_dtw', array('id_rekap_wisnus_dtw' => $id_rekap_wisnus_dtw))->row_array();

        $nm = $this->M_dtw->cari_data('provinsi', array('id_provinsi' => $data['id_provinsi']))->row_array();

        $dt = [ 'pria'          => $data['pengunjung_pria'],
                'wanita'        => $data['pengunjung_wanita'],
                'jumlah'        => $data['jumlah_pengunjung'],
                'id_rekap'      => $data['id_rekap_wisnus_dtw'],
                'nm_provinsi'   => $nm['nama_provinsi']
            ];

        echo json_encode($dt);
        
    }

    // menampilkan data ubah dtw wisman
    public function tampil_data_ubah_dtw_wisman()
    {
        $id_rekap_wisman_dtw = $this->input->post('id_rekap_wisman_dtw');

        $data = $this->M_dtw->cari_data('rekap_wisman_dtw', array('id_rekap_wisman_dtw' => $id_rekap_wisman_dtw))->row_array();

        $nm = $this->M_dtw->cari_data('negara', array('id_negara' => $data['id_negara']))->row_array();

        $nk = $this->M_dtw->cari_data('kawasan', array('id_kawasan' => $nm['id_kawasan']))->row_array();

        $dt = [ 'pria'          => $data['pengunjung_pria'],
                'wanita'        => $data['pengunjung_wanita'],
                'jumlah'        => $data['jumlah_pengunjung'],
                'id_rekap'      => $data['id_rekap_wisman_dtw'],
                'nm_negara'     => $nm['nama_negara'],
                'nm_kawasan'    => $nk['nama_kawasan']
            ];

        echo json_encode($dt);
        
    }

    // menampilkan option provinsi
    public function ambil_option_provinsi()
    {
        $periode = $this->input->post('periode');
        $id_dtw  = $this->input->post('id_dtw');

        // membuat dropdown provinsi
        $list = $this->M_dtw->get_provinsi_dtw($periode, $id_dtw)->result_array();

        $option = "";

        foreach ($list as $a) {
            $option .= "<option value='".$a['id_provinsi']."'>".$a['nama_provinsi']."</option>";
        }

        echo json_encode(['provinsi'  => $option]);
    }

    public function simpan_wisnus_dtw()
    {
        $user       = $this->userdata->id_user;
        $id_dtw     = $this->input->post('id_dtw');
        $periode    = $this->input->post('periode');

        $this->db->from('rekap_wisnus_dtw');
        $this->db->where("periode LIKE '%$periode%'");
        $this->db->where('id_dtw', $id_dtw);
        $cek = $this->db->get()->num_rows();
        
        $i='0';
        $id_provinsi = $this->input->post('id_provinsi[]');
        $l = $this->input->post('l[]');
        $p = $this->input->post('p[]');
        $j = $this->input->post('j[]');
        if ($cek == 0) {
            if (is_array($id_provinsi)) {
                foreach ($id_provinsi as $key => $val) {
                    $data[$i]['id_provinsi']        = $val;
                    $data[$i]['pengunjung_pria']    = $l[$key];
                    $data[$i]['pengunjung_wanita']  = $p[$key];
                    $data[$i]['jumlah_pengunjung']  = $j[$key];
                    $data[$i]['add_by']             = $user;
                    $data[$i]['periode']            = $periode;
                    $data[$i]['id_dtw']             = $id_dtw;
                    $i++;
                }
                $this->db->insert_batch('rekap_wisnus_dtw', $data);

                if ($this->db->affected_rows() > 0) {
                    echo json_encode(['status' => 'berhasil']);
                } else {
                    echo json_encode(['status' => 'gagal']);
                }
            }
        } else {
            echo json_encode(['status' => 'sudah_terisi']);
        }
    }

    public function simpan_wisman_dtw()
    {
        $user       = $this->userdata->id_user;
        $id_dtw     = $this->input->post('id_dtw');
        $periode    = $this->input->post('periode');

        $this->db->from('rekap_wisman_dtw');
        $this->db->where("periode LIKE '%$periode%'");
        $this->db->where('id_dtw', $id_dtw);
        $cek = $this->db->get()->num_rows();
        
        $i='0';
        $id_negara = $this->input->post('id_negara[]');
        $l = $this->input->post('ll[]');
        $p = $this->input->post('pp[]');
        $j = $this->input->post('jj[]');
        if ($cek == 0) {
            if (is_array($id_negara)) {
                foreach ($id_negara as $key => $val) {
                    $data[$i]['id_negara']          = $val;
                    $data[$i]['pengunjung_pria']    = $l[$key];
                    $data[$i]['pengunjung_wanita']  = $p[$key];
                    $data[$i]['jumlah_pengunjung']  = $j[$key];
                    $data[$i]['add_by']             = $user;
                    $data[$i]['periode']            = $periode;
                    $data[$i]['id_dtw']             = $id_dtw;
                    $i++;
                }
                $this->db->insert_batch('rekap_wisman_dtw', $data);

                if ($this->db->affected_rows() > 0) {
                    echo json_encode(['status' => 'berhasil']);
                } else {
                    echo json_encode(['status' => 'gagal']);
                }
            }
        } else {
            echo json_encode(['status' => 'sudah_terisi']);
        }
    }

    // AKHIR

    public function json()
    {   
        $id_kota = $this->input->get('id');
        $per = date('Y-m-01');
        $data['cek_wisnus'] = $this->M_dtw->cek_wisnus($per,$id_kota);
        $data['cek_wisman'] = $this->M_dtw->cek_wisman($per,$id_kota);
        $data['dtw'] = $this->M_dtw->get_dtw($id_kota);
        echo json_encode($data);
    }

    public function simpan_wisnus()
    {
        $user = $this->userdata->id_user;
        $id_dtw = $this->input->post('id_dtw');
        $periode = $this->input->post('periode');
        $cek = $this->db->query("Select * from rekap_wisnus_dtw where periode='".$periode."' AND id_dtw = '".$id_dtw."'")->result();
        $i='0';
        $id_provinsi = $this->input->post('id_provinsi[]');
        $l = $this->input->post('l[]');
        $p = $this->input->post('p[]');
        $j = $this->input->post('j[]');
        if ($this->db->affected_rows()<1) {
            if (is_array($id_provinsi)) {
                foreach ($id_provinsi as $key => $val) {
                    $data[$i]['id_provinsi'] = $val;
                    $data[$i]['pengunjung_pria'] = $l[$key];
                    $data[$i]['pengunjung_wanita'] = $p[$key];
                    $data[$i]['jumlah_pengunjung'] = $j[$key];
                    $data[$i]['add_by'] = $user;
                    $data[$i]['periode'] = $periode;
                    $data[$i]['id_dtw'] = $id_dtw;
                    $i++;
                }
                $this->db->insert_batch('rekap_wisnus_dtw', $data);

                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('pesan', "<div class='alert alert-success alert-block'> <a class='close' data-dismiss='alert' href='#'>×</a> <h4 class='alert-heading'>Data Berhasil Disimpan</h4></div>");
                    redirect('Kelolaan/Dtw', 'refresh');
                } else {
                    $this->session->set_flashdata('pesan', "<div class='alert alert-danger alert-block'> <a class='close' data-dismiss='alert' href='#'>×</a> <h4 class='alert-heading'>Data Gagal Simpan</h4></div>");
                     redirect('Kelolaan/Dtw', 'refresh');
                }
            }
        } else {
            $this->session->set_flashdata('pesan', "<div class='alert alert-danger alert-block'> <a class='close' data-dismiss='alert' href='#'>×</a> <h4 class='alert-heading'>Data Periode Tersebut Sudah Terisi</h4></div>");
                     redirect('Kelolaan/Dtw', 'refresh');
        }
    }

    public function cek_periode()
    {
        $id_dtw = $this->input->post('id_dtw');
        $per = $this->input->post('per');
        $data = $this->db->get_where('rekap_wisnus_dtw', array('periode'=>$per,'id_dtw'=> $id_dtw))->result();
        if ($this->db->affected_rows()> 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    public function cek_periode_wisman()
    {
        $id_dtw = $this->input->post('id_dtw');
        $per = $this->input->post('per');
        $data = $this->db->get_where('rekap_wisman_dtw', array('periode'=>$per,'id_dtw'=> $id_dtw))->result();
        if ($this->db->affected_rows()> 0) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    public function simpan_wisman()
    {
        $user = $this->userdata->id_user;
        $id_dtw = $this->input->post('id_dtw');
        $periode = $this->input->post('periode');
        $cek = $this->db->query("Select * from rekap_wisman_dtw where periode='".$periode."' AND id_dtw = '".$id_dtw."'")->result();
        $i='0';
        $id_negara = $this->input->post('id_negara[]');
        $l = $this->input->post('ll[]');
        $p = $this->input->post('pp[]');
        $j = $this->input->post('jj[]');
        if ($this->db->affected_rows()<1) {
            if (is_array($id_negara)) {
                foreach ($id_negara as $key => $val) {
                    $data[$i]['id_negara'] = $val;
                    $data[$i]['pengunjung_pria'] = $l[$key];
                    $data[$i]['pengunjung_wanita'] = $p[$key];
                    $data[$i]['jumlah_pengunjung'] = $j[$key];
                    $data[$i]['add_by'] = $user;
                    $data[$i]['periode'] = $periode;
                    $data[$i]['id_dtw'] = $id_dtw;
                    $i++;
                }
                // var_dump($data);
                // exit();
                $this->db->insert_batch('rekap_wisman_dtw', $data);

                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('pesan', "<div class='alert alert-success alert-block'> <a class='close' data-dismiss='alert' href='#'>×</a> <h4 class='alert-heading'>Data Berhasil Disimpan</h4></div>");
                    redirect('Kelolaan/Dtw', 'refresh');
                } else {
                    $this->session->set_flashdata('pesan', "<div class='alert alert-danger alert-block'> <a class='close' data-dismiss='alert' href='#'>×</a> <h4 class='alert-heading'>Data Gagal Simpan</h4></div>");
                     redirect('Kelolaan/Dtw', 'refresh');
                }
            }
        } else {
            $this->session->set_flashdata('pesan', "<div class='alert alert-danger alert-block'> <a class='close' data-dismiss='alert' href='#'>×</a> <h4 class='alert-heading'>Data Periode Tersebut Sudah Terisi</h4></div>");
                     redirect('Kelolaan/Dtw', 'refresh');
        }
    }

    public function fil_periode()
    {
        $per = $this->input->post('per');
        $data['cek_wisnus'] = $this->M_dtw->cek_wisnus($per);
        $data['cek_wisman'] = $this->M_dtw->cek_wisman($per);
        $data['dtw'] = $this->M_dtw->get_dtw();
        echo json_encode($data);
    }
}
