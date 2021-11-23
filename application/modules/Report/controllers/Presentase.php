<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Presentase extends MY_Controller {

    // 26-02-2020
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_presentase'));
        $this->cek_login_lib->belum_login();
    }
    
    public function index()
    {
        $bln_skrg = date("Y-m", now('Asia/Jakarta'));
        $bln      = date('Y-m', strtotime("-1 month", strtotime($bln_skrg)));

        $thn_skrg = date("Y", now('Asia/Jakarta'));
        $thn      = date('Y', strtotime("-1 years", strtotime($thn_skrg)));

        // mencari data lainnya provinsi
            $hasil = $this->M_presentase->data_perbandingan_provinsi($bln_skrg, $bln, $thn_skrg, $thn, 'lainnya')->result_array();

            $tot_jumlah_bulan_awal  = 0;
            $tot_jumlah_bulan_akhir = 0;
            $tot_jumlah_tahun_awal  = 0;
            $tot_jumlah_tahun_akhir = 0;
            $m_on_m                 = 0;
            $y_on_y                 = 0;

            foreach ($hasil as $p) {
                $tot_jumlah_bulan_awal  += $p['tot_jumlah_bulan_awal'];
                $tot_jumlah_bulan_akhir += $p['tot_jumlah_bulan_akhir'];
                $tot_jumlah_tahun_awal  += $p['tot_jumlah_tahun_awal'];
                $tot_jumlah_tahun_akhir += $p['tot_jumlah_tahun_akhir'];
                $m_on_m                 += $p['m_on_m'];
                $y_on_y                 += $p['y_on_y'];
            }

            $lainnya_provinsi = array();

            $data_lp = ['tot_jumlah_bulan_awal'     => $tot_jumlah_bulan_awal,
                        'tot_jumlah_bulan_akhir'    => $tot_jumlah_bulan_akhir,
                        'tot_jumlah_tahun_awal'     => $tot_jumlah_tahun_awal,
                        'tot_jumlah_tahun_akhir'    => $tot_jumlah_tahun_akhir,
                        'm_on_m'                    => $m_on_m,
                        'y_on_y'                    => $y_on_y,
                        ];

            array_push($lainnya_provinsi, $data_lp);

        // 27-02-2020

        // mencari data lainnya negara
            $hasil = $this->M_presentase->data_perbandingan_negara($bln_skrg, $bln, $thn_skrg, $thn, 'lainnya')->result_array();

            $tot_jumlah_bulan_awal  = 0;
            $tot_jumlah_bulan_akhir = 0;
            $tot_jumlah_tahun_awal  = 0;
            $tot_jumlah_tahun_akhir = 0;
            $m_on_m                 = 0;
            $y_on_y                 = 0;

            foreach ($hasil as $p) {
                $tot_jumlah_bulan_awal  += $p['tot_jumlah_bulan_awal'];
                $tot_jumlah_bulan_akhir += $p['tot_jumlah_bulan_akhir'];
                $tot_jumlah_tahun_awal  += $p['tot_jumlah_tahun_awal'];
                $tot_jumlah_tahun_akhir += $p['tot_jumlah_tahun_akhir'];
                $m_on_m                 += $p['m_on_m'];
                $y_on_y                 += $p['y_on_y'];
            }

            $lainnya_negara = array();

            $data_lp = ['tot_jumlah_bulan_awal'     => $tot_jumlah_bulan_awal,
                        'tot_jumlah_bulan_akhir'    => $tot_jumlah_bulan_akhir,
                        'tot_jumlah_tahun_awal'     => $tot_jumlah_tahun_awal,
                        'tot_jumlah_tahun_akhir'    => $tot_jumlah_tahun_akhir,
                        'm_on_m'                    => $m_on_m,
                        'y_on_y'                    => $y_on_y,
                        ];

            array_push($lainnya_negara, $data_lp);

        // Akhir 27-02-2020

        $id_kota = $this->userdata->id_kota;

        // cari nama kota
        $cr_kota = $this->M_presentase->cari_data('kota', array('id_kota' => $id_kota))->row_array();


        $data = ['userdata'         => $this->userdata,
                 'nama_kota'        => $cr_kota['nama_kota'],
                 'id_kota'          => $id_kota,
                 'Menu'             => 'Report',
                 'Page'             => 'Report Presentase',
                 'provinsi'         => $this->M_presentase->data_perbandingan_provinsi($bln_skrg, $bln, $thn_skrg, $thn, 'top')->result_array(),
                 'lainnya_prov'     => $lainnya_provinsi,
                 'negara'           => $this->M_presentase->data_perbandingan_negara($bln_skrg, $bln, $thn_skrg, $thn, 'top')->result_array(),
                 'lainnya_negara'   => $lainnya_negara,
                 'bln_skrg'         => nice_date($bln_skrg, 'M-Y'),
                 'bln'              => nice_date($bln, 'M-Y'),
                 'thn_skrg'         => $thn_skrg,
                 'thn'              => $thn,
                 'kota'             => $this->M_presentase->cari_data('kota', array('id_provinsi' => 35))->result_array()
                ];

        $this->template->views('presentase/V_presentase', $data);
    }

    // 27-02-2020

        public function ambil_list()
        {
            $jenis = $this->input->post('jenis');

            $option = '';

            if ($jenis == 'dtw') {
                
                $hasil = $this->M_presentase->get_data_order('dtw', 'nama_dtw', 'asc')->result_array();

                $option = "<option value='all'>-- Pilih Dtw --</option>";

                foreach ($hasil as $h) {
                    $option .= "<option value='".$h['id_dtw']."'>".$h['nama_dtw']."</option>";
                }

                $judul = 'Dtw';

            } elseif ($jenis == 'hotel') {
                
                $hasil = $this->M_presentase->get_data_order('hotel', 'nama_hotel', 'asc')->result_array();

                $option = "<option value='all'>-- Pilih Hotel --</option>";

                foreach ($hasil as $h) {
                    $option .= "<option value='".$h['id_hotel']."'>".$h['nama_hotel']."</option>";
                }

                $judul = 'Akomodasi';

            } else {

                $option = "<option value='all'>-- Pilih Dtw / Akomodasi --</option>";

                $judul = 'Dtw / Akomodasi';

            }

            $data   = [ 'option' => $option,
                        'judul'  => $judul,
                        'status' => TRUE
                      ];
            
            echo json_encode($data);
            
        }

        // menampilkan list data perbandingan filter
        public function menampilkan_filter_perbandingan($aksi = '')
        {
            $kota           = $this->input->post('kota');
            $jenis_data     = $this->input->post('jenis_data');
            $bulan_awal     = $this->input->post('bulan_awal');
            $bulan_akhir    = $this->input->post('bulan_akhir');
            $id_dtw_hotel   = $this->input->post('list');
            $jns_wisatawan  = $this->input->post('jns_wisatawan');

            // cek tahun bulan awal dan akhir 
                $bl_awal    = date('Y', strtotime($bulan_awal));
                $bl_akhir   = date('Y', strtotime($bulan_akhir));

            if ($bulan_awal != '') {
                if ($bl_awal == $bl_akhir) {
                    $bulan_awal_thn2   = date('Y', strtotime("-1 years", strtotime($bulan_akhir)));
                    $bulan_akhir_thn2  = date('Y', strtotime($bulan_akhir));
                } else {
                    $bulan_awal_thn2   = date('Y', strtotime($bulan_awal));
                    $bulan_akhir_thn2  = date('Y', strtotime($bulan_akhir));
                }
            } else {
                $bulan_akhir = date("Y-m", now('Asia/Jakarta'));
                $bulan_awal  = date('Y-m', strtotime("-1 month", strtotime($bulan_akhir)));

                $bulan_akhir_thn2   = date("Y", now('Asia/Jakarta'));
                $bulan_awal_thn2    = date('Y', strtotime("-1 years", strtotime($bulan_akhir_thn2)));
            }

            $dt = ['id_kota'        => $kota,
                   'jenis_data'     => $jenis_data,
                   'bulan_awal'     => $bulan_awal,
                   'bulan_akhir'    => $bulan_akhir,
                   'id_dtw_hotel'   => $id_dtw_hotel,
                   'aksi'           => 'top'
                  ];

            $dt_f = ['id_kota'        => $kota,
                   'jenis_data'     => $jenis_data,
                   'bulan_awal'     => $bulan_awal,
                   'bulan_akhir'    => $bulan_akhir,
                   'id_dtw_hotel'   => $id_dtw_hotel,
                   'aksi'           => 'lainnya'
                  ];

            // data lainnya provinsi
                $hasil = $this->M_presentase->data_perbandingan_provinsi_filter($dt_f)->result_array();

                $tot_jumlah_bulan_awal  = 0;
                $tot_jumlah_bulan_akhir = 0;
                $tot_jumlah_tahun_awal  = 0;
                $tot_jumlah_tahun_akhir = 0;
                $m_on_m                 = 0;
                $y_on_y                 = 0;

                foreach ($hasil as $p) {
                    $tot_jumlah_bulan_awal  += $p['tot_jumlah_bulan_awal'];
                    $tot_jumlah_bulan_akhir += $p['tot_jumlah_bulan_akhir'];
                    $tot_jumlah_tahun_awal  += $p['tot_jumlah_tahun_awal'];
                    $tot_jumlah_tahun_akhir += $p['tot_jumlah_tahun_akhir'];
                    $m_on_m                 += $p['m_on_m'];
                    $y_on_y                 += $p['y_on_y'];
                }

                $lainnya_provinsi = array();

                $data_lp = ['tot_jumlah_bulan_awal'     => $tot_jumlah_bulan_awal,
                            'tot_jumlah_bulan_akhir'    => $tot_jumlah_bulan_akhir,
                            'tot_jumlah_tahun_awal'     => $tot_jumlah_tahun_awal,
                            'tot_jumlah_tahun_akhir'    => $tot_jumlah_tahun_akhir,
                            'm_on_m'                    => $m_on_m,
                            'y_on_y'                    => $y_on_y,
                            ];

                array_push($lainnya_provinsi, $data_lp);
            
            // mencari data lainnya negara
                $hasil = $this->M_presentase->data_perbandingan_negara_filter($dt_f)->result_array();

                $tot_jumlah_bulan_awal  = 0;
                $tot_jumlah_bulan_akhir = 0;
                $tot_jumlah_tahun_awal  = 0;
                $tot_jumlah_tahun_akhir = 0;
                $m_on_m                 = 0;
                $y_on_y                 = 0;

                foreach ($hasil as $p) {
                    $tot_jumlah_bulan_awal  += $p['tot_jumlah_bulan_awal'];
                    $tot_jumlah_bulan_akhir += $p['tot_jumlah_bulan_akhir'];
                    $tot_jumlah_tahun_awal  += $p['tot_jumlah_tahun_awal'];
                    $tot_jumlah_tahun_akhir += $p['tot_jumlah_tahun_akhir'];
                    $m_on_m                 += $p['m_on_m'];
                    $y_on_y                 += $p['y_on_y'];
                }

                $lainnya_negara = array();

                $data_lp = ['tot_jumlah_bulan_awal'     => $tot_jumlah_bulan_awal,
                            'tot_jumlah_bulan_akhir'    => $tot_jumlah_bulan_akhir,
                            'tot_jumlah_tahun_awal'     => $tot_jumlah_tahun_awal,
                            'tot_jumlah_tahun_akhir'    => $tot_jumlah_tahun_akhir,
                            'm_on_m'                    => $m_on_m,
                            'y_on_y'                    => $y_on_y,
                            ];

                array_push($lainnya_negara, $data_lp);

            if ($jenis_data != '-') {
                $cari = $this->M_presentase->cari_data("$jenis_data", array("id_$jenis_data" => $id_dtw_hotel))->row_array();
                $nama_dtw_hotel = $cari["nama_$jenis_data"];
            } else {
                $nama_dtw_hotel = '';
            }

            if ($kota != '-') {
                $nama = $this->M_presentase->cari_data('kota', array('id_kota' => $kota))->row_array();
                $nama_kota = $nama['nama_kota'];
            } else {
                $nama_kota = '';
            }

            $data = ['userdata'         => $this->userdata,
                     'Menu'             => 'Report',
                     'Page'             => 'Report Presentase',
                     'provinsi'         => $this->M_presentase->data_perbandingan_provinsi_filter($dt)->result_array(),
                     'lainnya_prov'     => $lainnya_provinsi,
                     'negara'           => $this->M_presentase->data_perbandingan_negara_filter($dt)->result_array(),
                     'lainnya_negara'   => $lainnya_negara,
                     'bln_skrg'         => nice_date($bulan_akhir, 'M-Y'),
                     'bln'              => nice_date($bulan_awal, 'M-Y'),
                     'thn_skrg'         => $bulan_akhir_thn2,
                     'thn'              => $bulan_awal_thn2,
                     'jenis_report'     => $jns_wisatawan,
                     'kota'             => $nama_kota,
                     'bulan_awal'       => $this->input->post('bulan_awal'),
                     'bulan_akhir'      => $this->input->post('bulan_akhir'),
                     'jenis_data'       => $jenis_data,
                     'nama_dtw_hotel'   => $nama_dtw_hotel,
                     'id_dtw_hotel'     => $id_dtw_hotel
                    ];

            if ($aksi == 'unduh') {
                $this->template->excel("presentase/V_excel_$jns_wisatawan", $data);
            } else {
                $this->load->view('presentase/V_presentase_filter', $data);
            }
            
        }

        // cek bulan periode awal 
        public function cek_bulan_akhir()
        {
            $bulan_akhir     = $this->input->post('bulan_akhir');
            $bulan_awal      = $this->input->post('bulan_awal');

            $bulan_akhir_thn = nice_date($bulan_akhir, 'Y');
            $bulan_awal_thn  = nice_date($bulan_awal, 'Y');
            
            $hasil = date('Y', strtotime("+1 years", strtotime($bulan_awal)));

            if ($hasil == $bulan_akhir_thn) {
                $cek = 'sama';
            } else {
                if ($bulan_awal == $bulan_akhir) {
                    $cek = 'sama_bulan_tahun';
                } elseif ($bulan_awal_thn == $bulan_akhir_thn) {
                    $cek = 'sama';
                } else {
                    $cek = 'beda';
                }
            }

            echo json_encode(['cek' => $cek, 'tahun' => $hasil, 'tahun_awal' => $bulan_awal_thn]);
        }

    // Akhir 27-02-2020

    public function tes()
    {
        // $from = date("d-F-Y", now('Asia/Jakarta'));
        // $from = date('d-F-Y', strtotime("-1 years", strtotime($from)));
        
        // echo nice_date($from, 'M-Y');

        $from = date("F-Y", now('Asia/Jakarta'));

        $a = date('Y', strtotime(''));

        $b = nice_date('', 'Y');

        echo $a;
    }

    public function coba()
    {
        $hasil = $this->M_presentase->tes()->result_array();

        echo "<pre>";
        print_r($hasil);
        echo "</pre>";
    }

    // Akhir 26-02-2020

}

/* End of file Presentase.php */
