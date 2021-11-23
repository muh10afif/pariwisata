<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_report'));
    }

    public function coba()
    {
        $id_kota        = 253;
        $jns            = 'dtw';

        $a = 'get_data_'.$jns;

        $b = $this->M_report->$a($id_kota)->result_array();

        echo "<pre>";
        print_r($b);
        echo "</pre>";

    }
    
    public function index()
    {
        if (isset($_POST['cari'])) {
            $jenis_report   = $this->input->post('jenis_report');
            $tgl_awal       = $this->input->post('start');
            $tgl_akhir      = $this->input->post('end');

            $id_kota        = $this->userdata->id_kota;

            $datanya = array();

            $dtw    = $this->M_report->get_data_dtw($id_kota)->result_array();

            // mengambil data dtw
            foreach ($dtw as $d) {

                $datanya[$d['nama_kota']][] = [ 'nama_kota'       => $d['nama_kota'],
                                                'nama_dtw_hotel'  => $d['nama_dtw'],
                                                'id_dtw_hotel'    => $d['id_dtw'],
                                                'jenis'           => 'dtw'
                                              ];
                
            }

            $hotel  = $this->M_report->get_data_hotel($id_kota)->result_array();

            // mengambil data hotel 
            foreach ($hotel as $h) {
                
                $datanya[$h['nama_kota']][] = [ 'nama_kota'       => $h['nama_kota'],
                                                'nama_dtw_hotel'  => $h['nama_hotel'],
                                                'id_dtw_hotel'    => $h['id_hotel'],
                                                'jenis'           => 'hotel'
                                              ];
            }

            ksort($datanya);

            $data = [ 'Page'            => 'Report',
                      'jenis_report'    => $jenis_report,
                      'tgl_awal'        => $tgl_awal,
                      'tgl_akhir'       => $tgl_akhir,
                      'dtw'             => $dtw,
                      'hotel'           => $hotel,
                      'kondisi'         => 'lihat',
                      'id_kota'         => $id_kota,
                      'data_all'        => $datanya
                    ];

            $this->load->view("V_report_$jenis_report", $data);
    
        } else {
            $data = ['userdata' => $this->userdata,
                    'Menu'      => '',
                    'Page'      => 'report',
                    'id_kota'   => $this->userdata->id_kota,
                    'Page'      => 'Report',
                    ];

            $this->template->views('V_report', $data);
        }
        
    }

    public function unduh_data()
    {
        $jenis_report   = $this->input->post('jenis_report');
        $tgl_awal       = $this->input->post('start');
        $tgl_akhir      = $this->input->post('end');

        $id_kota        = $this->userdata->id_kota;

        $datanya = array();

        $dtw    = $this->M_report->get_data_dtw($id_kota)->result_array();

        // mengambil data dtw
        foreach ($dtw as $d) {

            $datanya[$d['nama_kota']][] = [ 'nama_kota'       => $d['nama_kota'],
                                            'nama_dtw_hotel'  => $d['nama_dtw'],
                                            'id_dtw_hotel'    => $d['id_dtw'],
                                            'jenis'           => 'dtw'
                                            ];
            
        }

        $hotel  = $this->M_report->get_data_hotel($id_kota)->result_array();

        // mengambil data hotel 
        foreach ($hotel as $h) {
            
            $datanya[$h['nama_kota']][] = [ 'nama_kota'       => $h['nama_kota'],
                                            'nama_dtw_hotel'  => $h['nama_hotel'],
                                            'id_dtw_hotel'    => $h['id_hotel'],
                                            'jenis'           => 'hotel'
                                            ];
        }

        ksort($datanya);

        $data = [ 'jenis_report'    => $jenis_report,
                    'tgl_awal'        => $tgl_awal,
                    'tgl_akhir'       => $tgl_akhir,
                    'dtw'             => $this->M_report->get_data_dtw($id_kota)->result_array(),
                    'hotel'           => $this->M_report->get_data_hotel($id_kota)->result_array(),
                    'kondisi'         => '',
                    'id_kota'         => $id_kota,
                    'data_all'        => $datanya
                ];

        $this->template->excel("V_report_$jenis_report", $data);
    }

    // 28-02-2020

        // menampilkan unduh database
        public function unduh_database()
        {
            if (isset($_POST['cari'])) {

                $jenis_report   = $this->input->post('jenis_report');
                $tgl_awal       = $this->input->post('start');
                $tgl_akhir      = $this->input->post('end');

                $id_kota        = $this->userdata->id_kota;

                $bulan_awal		= nice_date($tgl_awal, 'Y-m');
                $bulan_akhir 	= nice_date($tgl_akhir, 'Y-m');

                $from   = $bulan_awal."-01";
                $from   = date('Y-m-d', strtotime("-1 day", strtotime($from)));
                $to     = $bulan_akhir."-01";

                $ar = array();
                $i=1;
                while (strtotime($from)<strtotime($to)){
                    $from = mktime(0,0,0,date('m',strtotime($from)),date("d",strtotime($from))+1,date("Y",strtotime($from)));
                    $from=date("Y-m-d", $from);
                    array_push($ar, nice_date($from, 'Y-m'));

                    $i++;
                }

                $bulan = array_unique($ar);

                $datanya = array();

                // perulangan bulan
                foreach ($bulan as $b) {

                    // data dtw
                    $hasil = $this->M_report->data_dtw_wisnus_unduh_db($b)->result_array();

                    foreach ($hasil as $h) {

                        $datanya[$h['nama_dtw']][] = [  'bulan'     => $h['bulan'],
                                                        'nama_kota' => $h['nama_kota'],
                                                        'nama_dtw'  => $h['nama_dtw'],
                                                        'kategori'  => $h['kategori_wisatawan'],
                                                        'asal'      => $h['nama_provinsi'],
                                                        'pria'      => $h['tot_pria'],
                                                        'wanita'    => $h['tot_wanita'],
                                                        'jumlah'    => $h['jumlah']
                                                    ];
                        
                    }

                    // data dtw wisman
                    $hasil1 = $this->M_report->data_dtw_wisman_unduh_db($b)->result_array();

                    foreach ($hasil1 as $h) {

                        $datanya[$h['nama_dtw']][] = [  'bulan'     => $h['bulan'],
                                                        'nama_kota' => $h['nama_kota'],
                                                        'nama_hotel'=> $h['nama_dtw'],
                                                        'kategori'  => $h['kategori_wisatawan'],
                                                        'asal'      => $h['nama_negara'],
                                                        'pria'      => $h['tot_pria'],
                                                        'wanita'    => $h['tot_wanita'],
                                                        'jumlah'    => $h['jumlah']
                                                    ];
                        
                    }

                }

                ksort($datanya);
                
                $data = ['userdata' => $this->userdata,
                        'Menu'      => '',
                        'Page'      => 'report',
                        'id_kota'   => $this->userdata->id_kota,
                        'Page'      => 'Report',
                        ];

                $this->template->views('V_unduh_database', $data); 
            } else {
                $data = ['userdata' => $this->userdata,
                        'Menu'      => '',
                        'Page'      => 'report',
                        'id_kota'   => $this->userdata->id_kota,
                        'Page'      => 'Report',
                        ];

                $this->template->views('V_unduh_database', $data);
            }

            
        }

        // menampilkan data unduh
        public function menampilkan_data_unduh($aksi = '')
        {
            $jenis  = $this->input->post('jenis_report');
            $start  = $this->input->post('start');
            $end    = $this->input->post('end');
            $kondisi= $this->input->post('kondisi');

            // proses ambil data
            $bulan_awal		= nice_date($start, 'Y-m');
            $bulan_akhir 	= nice_date($end, 'Y-m');

            $from   = $bulan_awal."-01";
            $from   = date('Y-m-d', strtotime("-1 day", strtotime($from)));
            $to     = $bulan_akhir."-01";

            $ar = array();
            $i=1;
            while (strtotime($from)<strtotime($to)){
                $from = mktime(0,0,0,date('m',strtotime($from)),date("d",strtotime($from))+1,date("Y",strtotime($from)));
                $from=date("Y-m-d", $from);
                array_push($ar, nice_date($from, 'Y-m'));

                $i++;
            }

            $bulan = array_unique($ar);

            $datanya = array();

            // perulangan bulan
            foreach ($bulan as $b) {

                // data dtw
                $hasil = $this->M_report->data_dtw_wisnus_unduh_db($b)->result_array();

                foreach ($hasil as $value => $h) {

                    if ($h['jumlah'] == 0) {
                        unset($hasil[$value]);
                    } else {
                        $datanya_dtw[$h['nama_dtw']][] = [  'bulan'     => $h['bulan'],
                                                    'nama_kota' => $h['nama_kota'],
                                                    'nama_dtw'  => $h['nama_dtw'],
                                                    'kategori'  => $h['kategori_wisatawan'],
                                                    'asal'      => $h['nama_provinsi'],
                                                    'pria'      => $h['tot_pria'],
                                                    'wanita'    => $h['tot_wanita'],
                                                    'jumlah'    => $h['jumlah']
                                                ];
                    }

                    
                    
                }

                // data dtw wisman
                $hasil1 = $this->M_report->data_dtw_wisman_unduh_db($b)->result_array();

                foreach ($hasil1 as $value => $h) {

                    if ($h['jumlah'] == 0) {
                        unset($hasil[$value]);
                    } else {
                        $datanya_dtw[$h['nama_dtw']][] = [  'bulan'     => $h['bulan'],
                                                            'nama_kota' => $h['nama_kota'],
                                                            'nama_dtw'=> $h['nama_dtw'],
                                                            'kategori'  => $h['kategori_wisatawan'],
                                                            'asal'      => $h['nama_negara'],
                                                            'pria'      => $h['tot_pria'],
                                                            'wanita'    => $h['tot_wanita'],
                                                            'jumlah'    => $h['jumlah']
                                                        ];
                    }

                    
                    
                }

                // data hotel
                $hasil = $this->M_report->data_hotel_wisnus_unduh_db($b)->result_array();

                foreach ($hasil as $value => $h) {

                    if ($h['jumlah'] == 0) {
                        unset($hasil[$value]);
                    } else {
                        $datanya_hotel[$h['nama_hotel']][] = [  'bulan'     => $h['bulan'],
                                                                'nama_kota' => $h['nama_kota'],
                                                                'nama_hotel'  => $h['nama_hotel'],
                                                                'asal'      => $h['nama_provinsi'],
                                                                'kategori'  => $h['kategori_wisatawan'],
                                                                'pria'      => $h['tot_pria'],
                                                                'wanita'    => $h['tot_wanita'],
                                                                'jumlah'    => $h['jumlah']
                                                            ];
                    }
                    
                    
                }

                // data hotel wisman
                $hasil1 = $this->M_report->data_hotel_wisman_unduh_db($b)->result_array();

                foreach ($hasil1 as $value => $h) {

                    if ($h['jumlah'] == 0) {
                        unset($hasil[$value]);
                    } else {

                        $datanya_hotel[$h['nama_hotel']][] = [  'bulan'     => $h['bulan'],
                                                            'nama_kota' => $h['nama_kota'],
                                                            'nama_hotel'=> $h['nama_hotel'],
                                                            'asal'      => $h['nama_negara'],
                                                            'kategori'  => $h['kategori_wisatawan'],
                                                            'pria'      => $h['tot_pria'],
                                                            'wanita'    => $h['tot_wanita'],
                                                            'jumlah'    => $h['jumlah']
                                                        ];

                    }
                    
                }

            }

            if($jenis == 'dtw') {
                if (empty($datanya_dtw)) {

                    $datanya_dtw = [];

                    $dt = "datanya_$jenis";
                } else {
                    $dt = "datanya_$jenis";
                    ksort($datanya_dtw);
                }
                
            } else {
                if (empty($datanya_hotel)) {

                    $datanya_hotel = [];

                    $dt = "datanya_$jenis";
                } else {
                    $dt = "datanya_$jenis";
                    ksort($datanya_hotel);
                }
            }

            $data = ['userdata'     => $this->userdata,
                    'Menu'          => '',
                    'Page'          => 'report',
                    'Page'          => 'Report',
                    "data_$jenis"   => $$dt,
                    'jenis'         => $jenis,
                    'start'         => $start,
                    'end'           => $end,
                    'jenis_report'  => $jenis,
                    'kondisi'       => $kondisi
                    ];

            if ($aksi == 'unduh') {
                $this->template->excel('V_data_unduh', $data);
            } else {
                $this->load->view('V_data_unduh', $data);
            }
            
        }

    // Akhir 28-02-2020

    // 02-03-2020

        public function unduh_excel_detail()
        {
            $id_kota = $this->input->post('id_kota');
            $periode = $this->input->post('periode');
            $jenis   = $this->input->post('jenis');

            // data dtw
            $hasil = $this->M_report->data_dtw_wisnus_unduh_detail($periode, $id_kota)->result_array();

            foreach ($hasil as $h) {

                $datanya_dtw[$h['nama_dtw']][] = [  'bulan'     => $h['bulan'],
                                                'nama_kota' => $h['nama_kota'],
                                                'nama_dtw'  => $h['nama_dtw'],
                                                'kategori'  => $h['kategori_wisatawan'],
                                                'asal'      => $h['nama_provinsi'],
                                                'pria'      => $h['tot_pria'],
                                                'wanita'    => $h['tot_wanita'],
                                                'jumlah'    => $h['jumlah']
                                            ];
                
            }

            // data dtw wisman
            $hasil1 = $this->M_report->data_dtw_wisman_unduh_detail($periode, $id_kota)->result_array();

            foreach ($hasil1 as $h) {

                $datanya_dtw[$h['nama_dtw']][] = [  'bulan'     => $h['bulan'],
                                                'nama_kota' => $h['nama_kota'],
                                                'nama_dtw'=> $h['nama_dtw'],
                                                'kategori'  => $h['kategori_wisatawan'],
                                                'asal'      => $h['nama_negara'],
                                                'pria'      => $h['tot_pria'],
                                                'wanita'    => $h['tot_wanita'],
                                                'jumlah'    => $h['jumlah']
                                            ];
                
            }

            // data hotel
            $hasil = $this->M_report->data_hotel_wisnus_unduh_detail($periode, $id_kota)->result_array();

            foreach ($hasil as $h) {

                $datanya_hotel[$h['nama_hotel']][] = [  'bulan'     => $h['bulan'],
                                                'nama_kota' => $h['nama_kota'],
                                                'nama_hotel'  => $h['nama_hotel'],
                                                'asal'      => $h['nama_provinsi'],
                                                'kategori'  => $h['kategori_wisatawan'],
                                                'pria'      => $h['tot_pria'],
                                                'wanita'    => $h['tot_wanita'],
                                                'jumlah'    => $h['jumlah']
                                            ];
                
            }

            // data hotel wisman
            $hasil1 = $this->M_report->data_hotel_wisman_unduh_detail($periode, $id_kota)->result_array();

            foreach ($hasil1 as $h) {

                $datanya_hotel[$h['nama_hotel']][] = [  'bulan'     => $h['bulan'],
                                                'nama_kota' => $h['nama_kota'],
                                                'nama_hotel'=> $h['nama_hotel'],
                                                'asal'      => $h['nama_negara'],
                                                'kategori'  => $h['kategori_wisatawan'],
                                                'pria'      => $h['tot_pria'],
                                                'wanita'    => $h['tot_wanita'],
                                                'jumlah'    => $h['jumlah']
                                            ];
                
            }

            ksort($datanya_dtw);
            ksort($datanya_hotel);

            $dt = "datanya_$jenis";

            $data = ['userdata'     => $this->userdata,
                    'Menu'          => '',
                    'Page'          => 'report',
                    'Page'          => 'Report',
                    "data_$jenis"   => $$dt,
                    'jenis_report'  => $jenis,
                    'periode'       => $periode,
                    'jenis'         => $jenis
                    ];

            $this->template->excel('V_excel_detail_wisatawan', $data);
            
        }

    // Akhir 02-03-2020

    public function tes()
    {
        // $from='2011-05-28';
        // $from = date('Y-m-d', strtotime("-1 day", strtotime($from)));
        // $to ='2011-06-07';

        // $i=1;
        // while (strtotime($from)<strtotime($to)){
        // $from = mktime(0,0,0,date('m',strtotime($from)),date("d",strtotime($from))+1,date("Y",strtotime($from)));
        // $from=date("Y-m-d", $from);
        // echo $from." - $i <br/>";

        // $i++;
        // }

        $bulan_awal		= nice_date('2019-12', 'Y-m');
        $bulan_akhir 	= nice_date('2020-01', 'Y-m');

        $from   = $bulan_awal."-01";
        $from   = date('Y-m-d', strtotime("-1 day", strtotime($from)));
        $to     = $bulan_akhir."-01";

        $ar = array();
        $i=1;
        while (strtotime($from)<strtotime($to)){
            $from = mktime(0,0,0,date('m',strtotime($from)),date("d",strtotime($from))+1,date("Y",strtotime($from)));
            $from=date("Y-m-d", $from);
            array_push($ar, nice_date($from, 'Y-m'));

            $i++;
        }

        $bulan = array_unique($ar);

        $datanya = array();

        // perulangan bulan
        foreach ($bulan as $b) {

            // data dtw
            $hasil = $this->M_report->data_dtw_wisnus_unduh_db($b)->result_array();

            foreach ($hasil as $h) {

                $datanya[$h['nama_dtw']][] = [  'bulan'     => $h['bulan'],
                                                'nama_kota' => $h['nama_kota'],
                                                'nama_dtw'  => $h['nama_dtw'],
                                                'asal'      => $h['nama_provinsi'],
                                                'kategori'  => $h['kategori_wisatawan'],
                                                'pria'      => $h['tot_pria'],
                                                'wanita'    => $h['tot_wanita'],
                                                'jumlah'    => $h['jumlah']
                                            ];
                
            }

            // data dtw wisman
            $hasil1 = $this->M_report->data_dtw_wisman_unduh_db($b)->result_array();

            foreach ($hasil1 as $h) {

                $datanya[$h['nama_dtw']][] = [  'bulan'     => $h['bulan'],
                                                'nama_kota' => $h['nama_kota'],
                                                'nama_hotel'=> $h['nama_dtw'],
                                                'asal'      => $h['nama_negara'],
                                                'kategori'  => $h['kategori_wisatawan'],
                                                'pria'      => $h['tot_pria'],
                                                'wanita'    => $h['tot_wanita'],
                                                'jumlah'    => $h['jumlah']
                                            ];
                
            }

            // data hotel
            $hasil = $this->M_report->data_hotel_wisnus_unduh_db($b)->result_array();

            foreach ($hasil as $h) {

                $datanya2[$h['nama_hotel']][] = [  'bulan'     => $h['bulan'],
                                                'nama_kota' => $h['nama_kota'],
                                                'nama_hotel'  => $h['nama_hotel'],
                                                'asal'      => $h['nama_provinsi'],
                                                'kategori'  => $h['kategori_wisatawan'],
                                                'pria'      => $h['tot_pria'],
                                                'wanita'    => $h['tot_wanita'],
                                                'jumlah'    => $h['jumlah']
                                            ];
                
            }

            // data hotel wisman
            $hasil1 = $this->M_report->data_hotel_wisman_unduh_db($b)->result_array();

            foreach ($hasil1 as $h) {

                $datanya2[$h['nama_hotel']][] = [  'bulan'     => $h['bulan'],
                                                'nama_kota' => $h['nama_kota'],
                                                'nama_hotel'=> $h['nama_hotel'],
                                                'asal'      => $h['nama_negara'],
                                                'kategori'  => $h['kategori_wisatawan'],
                                                'pria'      => $h['tot_pria'],
                                                'wanita'    => $h['tot_wanita'],
                                                'jumlah'    => $h['jumlah']
                                            ];
                
            }

        }

        ksort($datanya2);
        ksort($datanya);

        echo "<pre>";
        print_r($datanya);
        echo "</pre>";
    }

}

/* End of file Report.php */
