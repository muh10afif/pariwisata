<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hotel extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_hotel', 'M_dtw'));
    }

    public function index()
    {
        if (!empty($this->userdata)) {
            $data['userdata']   = $this->userdata;
            $data['Menu']       = "Kelolaan";
            $data['Page']       = "Kelolaan Hotel";
            $data['provinsi']   = $this->M_hotel->get_provinsi();
            $data['kawasan']    = $this->M_hotel->get_data('kawasan', 'nama_kawasan')->result_array();
            $data['hotel']      = $this->M_hotel->get_hotel_list();
            $data['asia']       = $this->M_hotel->asia();
            $data['afrika']     = $this->M_hotel->afrika();
            $data['amerika']    = $this->M_hotel->amerika();
            $data['australia']  = $this->M_hotel->australia();
            $data['eropa']      = $this->M_hotel->eropa();
            $data['per_awal']   = date('d-F-Y', now('Asia/Jakarta'));

            $this->template->views('V_hotel', $data);

        } else {
            redirect('Auth', 'refsresh');
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

    // menampilkan data hotel dengan json
    public function tampil_hotel()
    {   
        $periode    = $this->input->post('periode');
        $id_pegawai = $this->input->post('id_pegawai');

        $per_awal   = date('d-F-Y', now('Asia/Jakarta'));
              
        $data_hotel = $this->M_hotel->get_hotel_petugas_2($id_pegawai)->result_array();

        $no =1;
        foreach ($data_hotel as $value) {

            if ($periode == '') {
                $periode = $per_awal;
            } else {
                $periode = $periode;
            }

            $cek_wisnus = $this->M_hotel->cek_wisnusman_petugas('rekap_wisnus_hotel', $periode, $per_awal, $id_pegawai, $value['id_hotel']);
            $cek_wisman = $this->M_hotel->cek_wisnusman_petugas('rekap_wisman_hotel', $periode, $per_awal, $id_pegawai, $value['id_hotel']);

            if ($cek_wisman != 0 || $cek_wisnus != 0) {
                $status = '<span class="badge badge-success">Data Sudah Ada</span>';
            } else {
                $status = '<span class="badge badge-warning">Data Belum Ada</span>';
            }

            $tbody = array();
            $tbody[] = "<div align='center'>".$no++.".</div>";
            $tbody[] = $value['nama_hotel'];
            $tbody[] = $value['alamat'];
            $tbody[] = $value['email'];
            $tbody[] = $value['no_hp'];
            $tbody[] = $status;
            $tbody[] = "<button class='btn btn-rose btn-sm input-hotel' data-id='".$value['id_hotel']."' nm-hotel='".$value['nama_hotel']."' tgl-periode='".$periode."'>Input Data</button>";
            $data[]  = $tbody; 
        }

        if ($data_hotel ) {
            echo json_encode(array('data'=> $data));
        }else{
            echo json_encode(array('data'=>0));
        }
    }

    // halaman admin hotel 
    public function input_hotel($jenis)
    {
        $id_hotel = $this->userdata->id_hotel;

        $nm_hotel = $this->M_hotel->cari_data('hotel', array('id_hotel' => $id_hotel))->row_array();

        $data = [   'Menu'      => 'input_hotel',
                    'Page'      => $jenis,
                    'userdata'  => $this->userdata,
                    'id_hotel'  => $id_hotel,
                    'nama_hotel'=> $nm_hotel['nama_hotel'],
                    'kawasan'   => $this->M_hotel->get_data('kawasan', 'nama_kawasan')->result_array(),
                    'provinsi'  => $this->M_hotel->get_provinsi(),
                    'hotel'     => $this->M_hotel->get_hotel_list(),
                    'asia'      => $this->M_hotel->asia(),
                    'afrika'    => $this->M_hotel->afrika(),
                    'amerika'   => $this->M_hotel->amerika(),
                    'australia' => $this->M_hotel->australia(),
                    'eropa'     => $this->M_hotel->eropa()
                ];

        $this->template->views("V_hotel_$jenis", $data);
    }

    // menampilkan list hotel status 0
    public function tampil_list_hotel()
    {
        $periode    = nice_date($this->input->post('periode'), 'd-F-Y');
        $id_hotel   = $this->input->post('id_hotel');
        
        $list = $this->M_dtw->get_data_list('rekap_wisnus_hotel', $periode, array('id_hotel' => $id_hotel))->result_array();
        $no =1;
        foreach ($list as $value) {
            $tbody = array();

            $tbody[] = "<div align='center'>".$no++.".</div>";
            $tbody[] = $value['nama_provinsi'];
            $tbody[] = $value['pengunjung_pria'];
            $tbody[] = $value['pengunjung_wanita'];
            $tbody[] = $value['jumlah_pengunjung'];
            $aksi    = "<div align='center'> <button class='btn btn-warning btn-sm ubah-hotel' type='button' data-id=".$value['id_rekap_wisnus_hotel'].">Edit</button>".' '."<button class='btn btn-danger btn-sm hapus-hotel' type='button' data-id=".$value['id_rekap_wisnus_hotel'].">Hapus</button> </div>";
            $tbody[] = $aksi;
            $data[]  = $tbody; 
        }

        if ($list) {
            echo json_encode(array('data'=> $data));
        }else{
            echo json_encode(array('data'=>0));
        }
    }

    // menampilakan data ubah hotel
    public function tampil_data_ubah_hotel()
    {
        $id_rekap_wisnus_hotel = $this->input->post('id_rekap_wisnus_hotel');

        $data = $this->M_hotel->cari_data('rekap_wisnus_hotel', array('id_rekap_wisnus_hotel' => $id_rekap_wisnus_hotel))->row_array();

        $nm = $this->M_hotel->cari_data('provinsi', array('id_provinsi' => $data['id_provinsi']))->row_array();

        $dt = [ 'pria'          => $data['pengunjung_pria'],
                'wanita'        => $data['pengunjung_wanita'],
                'jumlah'        => $data['jumlah_pengunjung'],
                'id_rekap'      => $data['id_rekap_wisnus_hotel'],
                'nm_provinsi'   => $nm['nama_provinsi']
            ];

        echo json_encode($dt);
        
    }

    // simpan ubah list hotel
    public function simpan_ubah_hapus_list()
    {
        $periode                = $this->input->post('periode');
        $pria                   = $this->input->post('pria');
        $wanita                 = $this->input->post('wanita');
        $jumlah                 = $this->input->post('jumlah');
        $id_hotel               = $this->input->post('id_hotel');
        $id_rekap_wisnus_hotel  = $this->input->post('id_rekap');
        $aksi                   = $this->input->post('aksi');
        
        if ($aksi == 'ubah') {
            $data = ['pengunjung_pria'  => $pria,
                    'pengunjung_wanita'=> $wanita,
                    'jumlah_pengunjung'=> $jumlah
                    ];

            $this->M_hotel->ubah_data('rekap_wisnus_hotel', $data, array('id_rekap_wisnus_hotel' => $id_rekap_wisnus_hotel));
        } else {
            $this->M_hotel->hapus_data('rekap_wisnus_hotel', array('id_rekap_wisnus_hotel' => $id_rekap_wisnus_hotel));
        }

        // cari total jumlah
        $tot_j = $this->M_hotel->cari_tot_jml_hotel('rekap_wisnus_hotel', $periode, $id_hotel)->row_array();

        // membuat dropdown provinsi
        $list = $this->M_hotel->get_provinsi_hotel($periode, $id_hotel)->result_array();

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

    // menampilkan option provinsi
    public function ambil_option_provinsi()
    {
        $periode = $this->input->post('periode');
        $id_hotel  = $this->input->post('id_hotel');

        // membuat dropdown provinsi
        $list = $this->M_hotel->get_provinsi_hotel($periode, $id_hotel)->result_array();

        $option = "";

        foreach ($list as $a) {
            $option .= "<option value='".$a['id_provinsi']."'>".$a['nama_provinsi']."</option>";
        }

        echo json_encode(['provinsi'  => $option]);
    }

    public function simpan_list_wisnus_hotel()
    {
        $periode             = $this->input->post('periode');
        $id_hotel            = $this->input->post('id_hotel');

        $this->M_hotel->ubah_data('rekap_wisnus_hotel', array('status' => 1), array('id_hotel' => $id_hotel, 'periode' => $periode, 'status' => 0));

        // membuat dropdown provinsi
        $list = $this->M_hotel->get_provinsi();

        $option = "";

        foreach ($list as $a) {
            $option .= "<option value='".$a->id_provinsi."'>".$a->nama_provinsi."</option>";
        }

        echo json_encode(['status' => TRUE, 'provinsi' => $option]);
    }

    // cek provinsi
    public function cek_provinsi()
    {
        $periode    = $this->input->post('periode');
        $id_hotel   = $this->input->post('id_hotel');
        $provinsi   = $this->input->post('provinsi');

        $ck = $this->M_hotel->cek_provinsi($periode, $id_hotel, $provinsi);

        $d = $ck->row_array();

        $id_rekap_wisnus_hotel  = $d['id_rekap_wisnus_hotel'];
        $jml_pengunjung         = $d['jumlah_pengunjung'];
        $add_time               = nice_date($d['add_time'], 'd-m-Y H:i:s');

        echo json_encode(['cek'                 => $ck->num_rows(),
                          'id_rkp_wisnus_hotel' => $id_rekap_wisnus_hotel,
                          'jml_pengunjung'      => $jml_pengunjung,
                          'add_time'            => $add_time
                        ]);
    }

    // proses simpan list
    public function simpan_list()
    {
        $periode             = nice_date($this->input->post('periode'), 'd-F-Y');
        $pria                = ($this->input->post('pria') == '') ? '0' : $this->input->post('pria');
        $wanita              = ($this->input->post('wanita') == '') ? '0' : $this->input->post('wanita');
        $jumlah              = $this->input->post('jumlah');
        $provinsi            = $this->input->post('provinsi');
        $id_hotel            = $this->input->post('id_hotel');
        $jns                 = $this->input->post('data');
        $aksi                = $this->input->post('aksi');
        $id_rekap_wisnus_hotel = $this->input->post('id_rekap_wisnus_hotel');
        

        $cr = $this->M_hotel->cari_data('penempatan_hotel', array('id_hotel' => $id_hotel))->row_array();
        
        if ($jns != 'lihat') {

            if ($aksi == 'tambah_baru') {

                $this->M_hotel->ubah_data('rekap_wisnus_hotel', array('status'  => 3), array('id_rekap_wisnus_hotel' => $id_rekap_wisnus_hotel));

                $data = ['id_hotel'           => $id_hotel,
                         'pengunjung_pria'  => $pria,
                         'pengunjung_wanita'=> $wanita,
                         'jumlah_pengunjung'=> $jumlah,
                         'id_provinsi'      => $provinsi,
                         'add_by'           => $cr['id_pegawai'],
                         'status'           => 1,
                         'periode'          => $periode
                        ];
                
                $this->M_hotel->input_data('rekap_wisnus_hotel', $data);

            } elseif ($aksi == 'ubah_jumlah_data') {

                $this->M_hotel->ubah_data('rekap_wisnus_hotel', array('status'  => 2), array('id_rekap_wisnus_hotel' => $id_rekap_wisnus_hotel));
                
                $cr_data = $this->M_hotel->cari_data('rekap_wisnus_hotel', array('id_rekap_wisnus_hotel' => $id_rekap_wisnus_hotel))->row_array();

                $cr_pria    = $cr_data['pengunjung_pria'];
                $cr_wanita  = $cr_data['pengunjung_wanita'];
                $cr_jumlah  = $cr_data['jumlah_pengunjung'];

                $dt = [ 'id_hotel'            => $id_hotel,
                        'pengunjung_pria'   => $cr_pria + $pria,
                        'pengunjung_wanita' => $cr_wanita + $wanita,
                        'jumlah_pengunjung' => $cr_jumlah + $jumlah,
                        'id_provinsi'       => $provinsi,
                        'add_by'            => $cr['id_pegawai'],
                        'status'            => 1,
                        'periode'           => $periode
                        ];

                $this->M_hotel->input_data('rekap_wisnus_hotel', $dt);
                
            } else {

                $data = ['id_hotel'             => $id_hotel,
                         'pengunjung_pria'      => $pria,
                         'pengunjung_wanita'    => $wanita,
                         'jumlah_pengunjung'    => $jumlah,
                         'id_provinsi'          => $provinsi,
                         'add_by'               => $cr['id_pegawai'],
                         'status'               => 1,
                         'periode'              => $periode
                        ];
                
                $this->M_hotel->input_data('rekap_wisnus_hotel', $data);

            }

        }

        // cari total jumlah
        $jenis_data = $this->input->post('jenis_data');

        if ($jenis_data == 'wisnus') {
            // cari total jumlah
            $tot_j = $this->M_hotel->cari_tot_jml_hotel('rekap_wisnus_hotel', $periode, $id_hotel)->row_array();
        } else {
            // cari total jumlah
            $tot_j = $this->M_hotel->cari_tot_jml_hotel('rekap_wisman_hotel', $periode, $id_hotel)->row_array();
        }

        // membuat dropdown provinsi
        $list = $this->M_hotel->get_provinsi_hotel($periode, $id_hotel)->result_array();

        $option = "";

        foreach ($list as $a) {
            $option .= "<option value='".$a['id_provinsi']."'>".$a['nama_provinsi']."</option>";
        }

        $dt = [ 'status'      => TRUE, 
                'tot_pria'    => $tot_j['tot_pria'], 
                'tot_wanita'  => $tot_j['tot_wanita'],
                'tot_jumlah'  => $tot_j['tot_jumlah'],
                'provinsi'    => $option,
                'periode'     => nice_date($periode, 'd-F-Y')
             ];
        
        echo json_encode($dt);
    }

    // WISMAN

    // menampilkan list hotel wisman status 0
    public function tampil_list_hotel_wisman()
    {
        $periode    = nice_date($this->input->post('periode'), 'd-F-Y');
        $id_hotel   = $this->input->post('id_hotel');

        $list = $this->M_hotel->get_data_list_hotel_wisman($periode, array('d.id_hotel' => $id_hotel))->result_array();

        $no =1;
        foreach ($list as $value) {
            $tbody = array();
            $tbody[] = "<div align='center'>".$no++.".</div>";
            $tbody[] = $value['nama_kawasan'];
            $tbody[] = $value['nama_negara'];
            $tbody[] = $value['pengunjung_pria'];
            $tbody[] = $value['pengunjung_wanita'];
            $tbody[] = $value['jumlah_pengunjung'];
            $aksi= "<div align='center'> <button class='btn btn-warning btn-sm ubah-hotel-wisman' type='button' data-id=".$value['id_rekap_wisman_hotel'].">Edit</button>".' '."<button class='btn btn-danger btn-sm hapus-hotel-wisman' type='button' data-id=".$value['id_rekap_wisman_hotel'].">Hapus</button> </div>";
            $tbody[] = $aksi;
            $data[]  = $tbody; 
        }

        if ($list) {
            echo json_encode(array('data'=> $data));
        }else{
            echo json_encode(array('data'=>0));
        }
    }

    // ambil negara dropdown
    public function ambil_negara()
    {
        $id_kawasan = $this->input->post('id_kawasan');
        $aksi       = $this->input->post('aksi');
        $periode    = $this->input->post('periode');
        $id_hotel   = $this->input->post('id_hotel');

        if ($id_kawasan == "x") {
            $option = "<option value='x'>-- Pilih Negara --</option>";
            $ds     = "disabled";
        } else {

            if ($aksi == 'cari_negara') {
                $list_negara = $this->M_hotel->cari_negara_rekap_wisman($periode, $id_hotel, $id_kawasan)->result_array();          
            } else {
                $list_negara = $this->M_hotel->cari_data_o('negara', array('id_kawasan' => $id_kawasan), 'nama_negara')->result_array();
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

    // menampilkan data ubah hotel wisman
    public function tampil_data_ubah_hotel_wisman()
    {
        $id_rekap_wisman_hotel = $this->input->post('id_rekap_wisman_hotel');

        $data = $this->M_hotel->cari_data('rekap_wisman_hotel', array('id_rekap_wisman_hotel' => $id_rekap_wisman_hotel))->row_array();

        $nm = $this->M_hotel->cari_data('negara', array('id_negara' => $data['id_negara']))->row_array();

        $nk = $this->M_hotel->cari_data('kawasan', array('id_kawasan' => $nm['id_kawasan']))->row_array();

        $dt = [ 'pria'          => $data['pengunjung_pria'],
                'wanita'        => $data['pengunjung_wanita'],
                'jumlah'        => $data['jumlah_pengunjung'],
                'id_rekap'      => $data['id_rekap_wisman_hotel'],
                'nm_negara'     => $nm['nama_negara'],
                'nm_kawasan'    => $nk['nama_kawasan']
            ];

        echo json_encode($dt);
        
    }

    // simpan ubah list hotel wisman
    public function simpan_ubah_hapus_list_wisman()
    {
        $periode                = $this->input->post('periode');
        $pria                   = $this->input->post('pria');
        $wanita                 = $this->input->post('wanita');
        $jumlah                 = $this->input->post('jumlah');
        $id_hotel               = $this->input->post('id_hotel');
        $id_rekap_wisman_hotel  = $this->input->post('id_rekap');
        $aksi                   = $this->input->post('aksi');
        
        if ($aksi == 'ubah') {
            $data = ['pengunjung_pria'  => $pria,
                    'pengunjung_wanita'=> $wanita,
                    'jumlah_pengunjung'=> $jumlah
                    ];

            $this->M_hotel->ubah_data('rekap_wisman_hotel', $data, array('id_rekap_wisman_hotel' => $id_rekap_wisman_hotel));
        } else {
            $this->M_hotel->hapus_data('rekap_wisman_hotel', array('id_rekap_wisman_hotel' => $id_rekap_wisman_hotel));
        }

        // cari total jumlah
        $tot_j = $this->M_hotel->cari_tot_jml_hotel('rekap_wisman_hotel', $periode, $id_hotel)->row_array();

        $dt = [ 'status'      => TRUE, 
                'tot_pria'    => $tot_j['tot_pria'], 
                'tot_wanita'  => $tot_j['tot_wanita'],
                'tot_jumlah'  => $tot_j['tot_jumlah']
             ];
        
        echo json_encode($dt);
    }

    public function simpan_list_wisman_hotel()
    {
        $periode    = $this->input->post('periode');
        $id_hotel   = $this->input->post('id_hotel');

        $this->M_hotel->ubah_data('rekap_wisman_hotel', array('status' => 1), array('id_hotel' => $id_hotel, 'periode' => $periode, 'status' => 0));

        echo json_encode(['status' => TRUE]);
    }

    // cek negara
    public function cek_negara()
    {
        $periode    = $this->input->post('periode');
        $id_hotel   = $this->input->post('id_hotel');
        $negara     = $this->input->post('negara');

        $ck = $this->M_hotel->cek_negara($periode, $id_hotel, $negara);

        $d = $ck->row_array();

        $id_rekap_wisman_hotel  = $d['id_rekap_wisman_hotel'];
        $jml_pengunjung         = $d['jumlah_pengunjung'];
        $add_time               = nice_date($d['add_time'], 'd-m-Y H:i:s');

        echo json_encode(['cek'                 => $ck->num_rows(),
                          'id_rkp_wisman_hotel' => $id_rekap_wisman_hotel,
                          'jml_pengunjung'      => $jml_pengunjung,
                          'add_time'            => $add_time
                        ]);
    }

    // proses simpan list hotel wisman
    public function simpan_list_wisman()
    {
        $periode             = nice_date($this->input->post('periode'), 'd-F-Y');
        $pria                = ($this->input->post('pria') == '') ? '0' : $this->input->post('pria');
        $wanita              = ($this->input->post('wanita') == '') ? '0' : $this->input->post('wanita');
        $jumlah              = $this->input->post('jumlah');
        $negara              = $this->input->post('negara');
        $id_hotel            = $this->input->post('id_hotel');
        $jns                 = $this->input->post('data');
        $aksi                = $this->input->post('aksi');
        $id_rekap_wisman_hotel = $this->input->post('id_rekap_wisman_hotel');
        

        $cr = $this->M_hotel->cari_data('penempatan_hotel', array('id_hotel' => $id_hotel))->row_array();
        
        if ($jns != 'lihat') {

            if ($aksi == 'tambah_baru') {

                $this->M_hotel->ubah_data('rekap_wisman_hotel', array('status'  => 3), array('id_rekap_wisman_hotel' => $id_rekap_wisman_hotel));

                $data = ['id_hotel'           => $id_hotel,
                         'pengunjung_pria'  => $pria,
                         'pengunjung_wanita'=> $wanita,
                         'jumlah_pengunjung'=> $jumlah,
                         'id_negara'        => $negara,
                         'add_by'           => $cr['id_pegawai'],
                         'status'           => 1,
                         'periode'          => $periode
                        ];
                
                $this->M_hotel->input_data('rekap_wisman_hotel', $data);

            } elseif ($aksi == 'ubah_jumlah_data') {

                $this->M_hotel->ubah_data('rekap_wisman_hotel', array('status'  => 2), array('id_rekap_wisman_hotel' => $id_rekap_wisman_hotel));
                
                $cr_data = $this->M_hotel->cari_data('rekap_wisman_hotel', array('id_rekap_wisman_hotel' => $id_rekap_wisman_hotel))->row_array();

                $cr_pria    = $cr_data['pengunjung_pria'];
                $cr_wanita  = $cr_data['pengunjung_wanita'];
                $cr_jumlah  = $cr_data['jumlah_pengunjung'];

                $dt = [ 'id_hotel'            => $id_hotel,
                        'pengunjung_pria'   => $cr_pria + $pria,
                        'pengunjung_wanita' => $cr_wanita + $wanita,
                        'jumlah_pengunjung' => $cr_jumlah + $jumlah,
                        'id_negara'         => $negara,
                        'add_by'            => $cr['id_pegawai'],
                        'status'            => 1,
                        'periode'           => $periode
                        ];

                $this->M_hotel->input_data('rekap_wisman_hotel', $dt);
                
            } else {

                $data = ['id_hotel'           => $id_hotel,
                         'pengunjung_pria'  => $pria,
                         'pengunjung_wanita'=> $wanita,
                         'jumlah_pengunjung'=> $jumlah,
                         'id_negara'        => $negara,
                         'add_by'           => $cr['id_pegawai'],
                         'status'           => 1,
                         'periode'          => $periode
                        ];
                
                $this->M_hotel->input_data('rekap_wisman_hotel', $data);

            }

        }

        // cari total jumlah
        $tot_j = $this->M_hotel->cari_tot_jml_hotel('rekap_wisman_hotel', $periode, $id_hotel)->row_array();

        $dt = [ 'status'      => TRUE, 
                'tot_pria'    => $tot_j['tot_pria'], 
                'tot_wanita'  => $tot_j['tot_wanita'],
                'tot_jumlah'  => $tot_j['tot_jumlah'],
                'periode'     => nice_date($periode, 'd-F-Y')
             ];
        
        echo json_encode($dt);
    }
}
