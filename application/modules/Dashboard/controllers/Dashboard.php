<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_dashboard');
    }

    public function coba()
    {
        $tgl_sekarang_df = date("Y-m-d", now('Asia/Jakarta'));

        $tahun_skrg_dft = date("Y", now('Asia/Jakarta'));
        
        $tgl_awal_dft   = "$tahun_skrg_dft-01-2020";

        echo $tgl_sekarang_df;

    }

    public function index()
    {
        if (!empty($this->userdata)) {

            $level      = $this->session->userdata('level');
            $id_dtw     = $this->userdata->id_dtw;
            $id_hotel   = $this->userdata->id_hotel;
            $id_kota    = $this->userdata->id_kota;
            $id_pegawai = $this->userdata->id_pegawai;

            $tgl_sekarang_df = date("Y-m-d", now('Asia/Jakarta'));

            $tahun_skrg_dft = date("Y", now('Asia/Jakarta'));
            
            $tgl_awal_dft   = "$tahun_skrg_dft-01-01";

            // level PROVINSI

                // untuk diagram dtw

                    $dtw = $this->M_dashboard->get_total_dtw($tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari = $this->M_dashboard->get_total_dtw($tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisnus = 0;
                    $wisman = 0;
                    $jumlah = 0;

                    foreach ($cari->result_array() as $c) {
                        $wisnus += $c['jumlah_wisnus'];
                        $wisman += $c['jumlah_wisman'];
                        $jumlah += $c['jumlah'];
                    }

                    $data   = (object) ['id_kota'          => '',
                                        'nama_kota'        => 'lain-lain',
                                        'jumlah_wisnus'    => $wisnus,
                                        'jumlah_wisman'    => $wisman,
                                        'jumlah'           => $jumlah
                                        ];

                    array_push($dtw, $data);

                // Akhir untuk diagram dtw

                // untuk diagram dtw wisnus

                    $dtw_wisnus      = $this->M_dashboard->total_dtw_wisnus($tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari_dtw_wisnus = $this->M_dashboard->total_dtw_wisnus($tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisnus_dtw = 0;

                    foreach ($cari_dtw_wisnus->result_array() as $c) {
                        $wisnus_dtw += $c['jumlah_wisnus'];
                    }

                    $data_wisnus   = (object) [ 'id_provinsi'      => '',
                                                'nama_provinsi'    => 'lain-lain',
                                                'jumlah_wisnus'    => $wisnus_dtw
                                            ];

                    array_push($dtw_wisnus, $data_wisnus);

                // Akhir untuk diagram dtw wisnus

                // untuk diagram dtw wisman

                    $dtw_wisman      = $this->M_dashboard->total_dtw_wisman($tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari_dtw_wisman = $this->M_dashboard->total_dtw_wisman($tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisman_dtw = 0;

                    foreach ($cari_dtw_wisman->result_array() as $c) {
                        $wisman_dtw += $c['jumlah_wisman'];
                    }

                    $data_wisman   = (object) [ 'id_negara'      => '',
                                                'nama_negara'    => 'lain-lain',
                                                'jumlah_wisman'  => $wisman_dtw
                                            ];

                    array_push($dtw_wisman, $data_wisman);
                    
                // Akhir untuk diagram dtw wisman

                // untuk diagram hotel

                    $hotel = $this->M_dashboard->get_total_hotel($tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari = $this->M_dashboard->get_total_hotel($tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisnus = 0;
                    $wisman = 0;
                    $jumlah = 0;

                    foreach ($cari->result_array() as $c) {
                        $wisnus += $c['jumlah_wisnus'];
                        $wisman += $c['jumlah_wisman'];
                        $jumlah += $c['jumlah'];
                    }

                    $data2   = (object) ['id_kota'         => '',
                                        'nama_kota'        => 'lain-lain',
                                        'jumlah_wisnus'    => $wisnus,
                                        'jumlah_wisman'    => $wisman,
                                        'jumlah'           => $jumlah
                                        ];

                    array_push($hotel, $data2);

                // Akhir untuk diagram hotel

                // untuk diagram hotel wisnus

                    $hotel_wisnus      = $this->M_dashboard->total_hotel_wisnus($tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari_hotel_wisnus = $this->M_dashboard->total_hotel_wisnus($tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisnus_hotel = 0;

                    foreach ($cari_hotel_wisnus->result_array() as $c) {
                        $wisnus_hotel += $c['jumlah_wisnus'];
                    }

                    $data_wisnus   = (object) [ 'id_provinsi'      => '',
                                                'nama_provinsi'    => 'lain-lain',
                                                'jumlah_wisnus'    => $wisnus_hotel
                                            ];

                    array_push($hotel_wisnus, $data_wisnus);

                // Akhir untuk diagram hotel wisnus

                // untuk diagram hotel wisman

                    $hotel_wisman      = $this->M_dashboard->total_hotel_wisman($tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari_hotel_wisman = $this->M_dashboard->total_hotel_wisman($tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisman_hotel = 0;

                    foreach ($cari_hotel_wisman->result_array() as $c) {
                        $wisman_hotel += $c['jumlah_wisman'];
                    }

                    $data_wisman   = (object) [ 'id_negara'      => '',
                                                'nama_negara'    => 'lain-lain',
                                                'jumlah_wisman'  => $wisman_hotel
                                            ];

                    array_push($hotel_wisman, $data_wisman);
                    
                // Akhir untuk diagram hotel wisman

            // Akhir level PROVINSI

            if ($level == 'kota') {
               
                // level KOTA

                    // untuk diagram dtw kota

                        $dtw_kota       = $this->M_dashboard->total_dtw_kota($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                        $cari_dtw_kota  = $this->M_dashboard->total_dtw_kota($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                        $wisnus_dtw_kota = 0;
                        $wisman_dtw_kota = 0;
                        $jumlah_dtw_kota = 0;

                        foreach ($cari_dtw_kota->result_array() as $c) {
                            $wisnus_dtw_kota += $c['jumlah_wisnus'];
                            $wisman_dtw_kota += $c['jumlah_wisman'];
                            $jumlah_dtw_kota += $c['jumlah'];
                        }

                        $data_dtw_kota   = (object) ['id_dtw'           => '',
                                                    'nama_dtw'         => 'lain-lain',
                                                    'jumlah_wisnus'    => $wisnus_dtw_kota,
                                                    'jumlah_wisman'    => $wisman_dtw_kota,
                                                    'jumlah'           => $jumlah_dtw_kota
                                                    ];

                        array_push($dtw_kota, $data_dtw_kota);

                    // Akhir untuk diagram dtw kota

                    // untuk diagram dtw kota wisnus

                        $dtw_kota_wisnus      = $this->M_dashboard->total_dtw_kota_wisnus($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                        $cari_dtw_kota_wisnus = $this->M_dashboard->total_dtw_kota_wisnus($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                        $wisnus_dtw_kota = 0;

                        foreach ($cari_dtw_kota_wisnus->result_array() as $c) {
                            $wisnus_dtw_kota += $c['jumlah_wisnus'];
                        }

                        $data_dtw_kota_wisnus   = (object) [ 'id_provinsi'      => '',
                                                        'nama_provinsi'    => 'lain-lain',
                                                        'jumlah_wisnus'    => $wisnus_dtw_kota
                                                    ];

                        array_push($dtw_kota_wisnus, $data_dtw_kota_wisnus);

                    // Akhir untuk diagram dtw kota wisnus

                    // untuk diagram dtw kota wisman

                        $dtw_kota_wisman      = $this->M_dashboard->total_dtw_kota_wisman($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                        $cari_dtw_kota_wisman = $this->M_dashboard->total_dtw_kota_wisman($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                        $wisman_dtw_kota = 0;

                        foreach ($cari_dtw_kota_wisman->result_array() as $c) {
                            $wisman_dtw_kota += $c['jumlah_wisman'];
                        }

                        $data_dtw_kota_wisman   = (object) [ 'id_negara'      => '',
                                                            'nama_negara'    => 'lain-lain',
                                                            'jumlah_wisman'  => $wisman_dtw_kota
                                                        ];

                        array_push($dtw_kota_wisman, $data_dtw_kota_wisman);
                        
                    // Akhir untuk diagram dtw kota wisman

                    // untuk diagram hotel kota

                        $hotel_kota       = $this->M_dashboard->total_hotel_kota($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                        $cari_hotel_kota  = $this->M_dashboard->total_hotel_kota($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                        $wisnus_hotel_kota = 0;
                        $wisman_hotel_kota = 0;
                        $jumlah_hotel_kota = 0;

                        foreach ($cari_hotel_kota->result_array() as $c) {
                            $wisnus_hotel_kota += $c['jumlah_wisnus'];
                            $wisman_hotel_kota += $c['jumlah_wisman'];
                            $jumlah_hotel_kota += $c['jumlah'];
                        }

                        $data_hotel_kota   = (object) ['id_hotel'           => '',
                                                    'nama_hotel'         => 'lain-lain',
                                                    'jumlah_wisnus'      => $wisnus_hotel_kota,
                                                    'jumlah_wisman'      => $wisman_hotel_kota,
                                                    'jumlah'             => $jumlah_hotel_kota
                                                    ];

                        array_push($hotel_kota, $data_hotel_kota);

                    // Akhir untuk diagram hotel kota

                    // untuk diagram hotel kota wisnus

                        $hotel_kota_wisnus      = $this->M_dashboard->total_hotel_kota_wisnus($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                        $cari_hotel_kota_wisnus = $this->M_dashboard->total_hotel_kota_wisnus($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                        $wisnus_hotel_kota = 0;

                        foreach ($cari_hotel_kota_wisnus->result_array() as $c) {
                            $wisnus_hotel_kota += $c['jumlah_wisnus'];
                        }

                        $data_hotel_kota_wisnus   = (object) [ 'id_provinsi'      => '',
                                                        'nama_provinsi'    => 'lain-lain',
                                                        'jumlah_wisnus'    => $wisnus_hotel_kota
                                                    ];

                        array_push($hotel_kota_wisnus, $data_hotel_kota_wisnus);

                    // Akhir untuk diagram hotel kota wisnus

                    // untuk diagram hotel kota wisman

                        $hotel_kota_wisman      = $this->M_dashboard->total_hotel_kota_wisman($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                        $cari_hotel_kota_wisman = $this->M_dashboard->total_hotel_kota_wisman($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                        $wisman_hotel_kota = 0;

                        foreach ($cari_hotel_kota_wisman->result_array() as $c) {
                            $wisman_hotel_kota += $c['jumlah_wisman'];
                        }

                        $data_hotel_kota_wisman   = (object) [ 'id_negara'      => '',
                                                                'nama_negara'    => 'lain-lain',
                                                                'jumlah_wisman'  => $wisman_hotel_kota
                                                            ];

                        array_push($hotel_kota_wisman, $data_hotel_kota_wisman);
                        
                    // Akhir untuk diagram hotel kota wisman

                // Akhir KOTA

                $data_kota = ['judul'            => 'dashboard',
                            'userdata'         => $this->userdata,
                            'Menu'             => 'Dashboard',
                            'Page'             => 'Dashboard',
                            'dtw_kota'         => $dtw_kota,
                            'dtw_kota_wisnus'  => $dtw_kota_wisnus,
                            'dtw_kota_wisman'  => $dtw_kota_wisman,
                            'hotel_kota'       => $hotel_kota,
                            'hotel_kota_wisnus'=> $hotel_kota_wisnus,
                            'hotel_kota_wisman'=> $hotel_kota_wisman,
                            'tot_dtw_wisman'   => $this->M_dashboard->get_tot_dtw('rekap_wisman_dtw', $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                            'tot_dtw_wisnus'   => $this->M_dashboard->get_tot_dtw('rekap_wisnus_dtw', $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                            'tot_hotel_wisman' => $this->M_dashboard->get_tot_hotel('rekap_wisman_hotel', $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                            'tot_hotel_wisnus' => $this->M_dashboard->get_tot_hotel('rekap_wisnus_hotel', $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                            'tgl_awal'         => $tgl_awal_dft,
                            'tgl_akhir'        => $tgl_sekarang_df
                            ];

            }

            if ($level == 'petugas') {
               
                // level PETUGAS
    
                    // untuk diagram dtw petugas
    
                        $dtw_petugas       = $this->M_dashboard->total_dtw_petugas($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'top');
    
                        $cari_dtw_petugas  = $this->M_dashboard->total_dtw_petugas($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'all');
    
                        $wisnus_dtw_petugas = 0;
                        $wisman_dtw_petugas = 0;
                        $jumlah_dtw_petugas = 0;
    
                        foreach ($cari_dtw_petugas->result_array() as $c) {
                            $wisnus_dtw_petugas += $c['jumlah_wisnus'];
                            $wisman_dtw_petugas += $c['jumlah_wisman'];
                            $jumlah_dtw_petugas += $c['jumlah'];
                        }
    
                        $data_dtw_petugas   = (object) ['id_dtw'           => '',
                                                    'nama_dtw'         => 'lain-lain',
                                                    'jumlah_wisnus'    => $wisnus_dtw_petugas,
                                                    'jumlah_wisman'    => $wisman_dtw_petugas,
                                                    'jumlah'           => $jumlah_dtw_petugas
                                                    ];
    
                        array_push($dtw_petugas, $data_dtw_petugas);
    
                    // Akhir untuk diagram dtw petugas
    
                    // untuk diagram dtw petugas wisnus
    
                        $dtw_petugas_wisnus      = $this->M_dashboard->total_dtw_petugas_wisnus($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'top');
    
                        $cari_dtw_petugas_wisnus = $this->M_dashboard->total_dtw_petugas_wisnus($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'all');
    
                        $wisnus_dtw_petugas = 0;
    
                        foreach ($cari_dtw_petugas_wisnus->result_array() as $c) {
                            $wisnus_dtw_petugas += $c['jumlah_wisnus'];
                        }
    
                        $data_dtw_petugas_wisnus   = (object) [ 'id_provinsi'      => '',
                                                        'nama_provinsi'    => 'lain-lain',
                                                        'jumlah_wisnus'    => $wisnus_dtw_petugas
                                                    ];
    
                        array_push($dtw_petugas_wisnus, $data_dtw_petugas_wisnus);
    
                    // Akhir untuk diagram dtw petugas wisnus
    
                    // untuk diagram dtw petugas wisman
    
                        $dtw_petugas_wisman      = $this->M_dashboard->total_dtw_petugas_wisman($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'top');
    
                        $cari_dtw_petugas_wisman = $this->M_dashboard->total_dtw_petugas_wisman($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'all');
    
                        $wisman_dtw_petugas = 0;
    
                        foreach ($cari_dtw_petugas_wisman->result_array() as $c) {
                            $wisman_dtw_petugas += $c['jumlah_wisman'];
                        }
    
                        $data_dtw_petugas_wisman   = (object) [ 'id_negara'      => '',
                                                            'nama_negara'    => 'lain-lain',
                                                            'jumlah_wisman'  => $wisman_dtw_petugas
                                                        ];
    
                        array_push($dtw_petugas_wisman, $data_dtw_petugas_wisman);
                        
                    // Akhir untuk diagram dtw petugas wisman
    
                    // untuk diagram hotel petugas
    
                        $hotel_petugas       = $this->M_dashboard->total_hotel_petugas($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'top');
    
                        $cari_hotel_petugas  = $this->M_dashboard->total_hotel_petugas($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'all');
    
                        $wisnus_hotel_petugas = 0;
                        $wisman_hotel_petugas = 0;
                        $jumlah_hotel_petugas = 0;
    
                        foreach ($cari_hotel_petugas->result_array() as $c) {
                            $wisnus_hotel_petugas += $c['jumlah_wisnus'];
                            $wisman_hotel_petugas += $c['jumlah_wisman'];
                            $jumlah_hotel_petugas += $c['jumlah'];
                        }
    
                        $data_hotel_petugas   = (object) ['id_hotel'           => '',
                                                    'nama_hotel'         => 'lain-lain',
                                                    'jumlah_wisnus'      => $wisnus_hotel_petugas,
                                                    'jumlah_wisman'      => $wisman_hotel_petugas,
                                                    'jumlah'             => $jumlah_hotel_petugas
                                                    ];
    
                        array_push($hotel_petugas, $data_hotel_petugas);
    
                    // Akhir untuk diagram hotel petugas
    
                    // untuk diagram hotel petugas wisnus
    
                        $hotel_petugas_wisnus      = $this->M_dashboard->total_hotel_petugas_wisnus($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'top');
    
                        $cari_hotel_petugas_wisnus = $this->M_dashboard->total_hotel_petugas_wisnus($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'all');
    
                        $wisnus_hotel_petugas = 0;
    
                        foreach ($cari_hotel_petugas_wisnus->result_array() as $c) {
                            $wisnus_hotel_petugas += $c['jumlah_wisnus'];
                        }
    
                        $data_hotel_petugas_wisnus   = (object) [ 'id_provinsi'      => '',
                                                        'nama_provinsi'    => 'lain-lain',
                                                        'jumlah_wisnus'    => $wisnus_hotel_petugas
                                                    ];
    
                        array_push($hotel_petugas_wisnus, $data_hotel_petugas_wisnus);
    
                    // Akhir untuk diagram hotel petugas wisnus
    
                    // untuk diagram hotel petugas wisman
    
                        $hotel_petugas_wisman      = $this->M_dashboard->total_hotel_petugas_wisman($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'top');
    
                        $cari_hotel_petugas_wisman = $this->M_dashboard->total_hotel_petugas_wisman($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'all');
    
                        $wisman_hotel_petugas = 0;
    
                        foreach ($cari_hotel_petugas_wisman->result_array() as $c) {
                            $wisman_hotel_petugas += $c['jumlah_wisman'];
                        }
    
                        $data_hotel_petugas_wisman   = (object) [ 'id_negara'      => '',
                                                                'nama_negara'    => 'lain-lain',
                                                                'jumlah_wisman'  => $wisman_hotel_petugas
                                                            ];
    
                        array_push($hotel_petugas_wisman, $data_hotel_petugas_wisman);
                        
                    // Akhir untuk diagram hotel petugas wisman
    
                // Akhir PETUGAS
    
                $data_petugas = ['judul'              => 'dashboard',
                                'userdata'            => $this->userdata,
                                'Menu'                => 'Dashboard',
                                'Page'                => 'Dashboard',
                                'dtw_petugas'         => $dtw_petugas,
                                'dtw_petugas_wisnus'  => $dtw_petugas_wisnus,
                                'dtw_petugas_wisman'  => $dtw_petugas_wisman,
                                'hotel_petugas'       => $hotel_petugas,
                                'hotel_petugas_wisnus'=> $hotel_petugas_wisnus,
                                'hotel_petugas_wisman'=> $hotel_petugas_wisman,
                                'tot_dtw_wisman'   => $this->M_dashboard->get_tot_dtw('rekap_wisman_dtw', $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                                'tot_dtw_wisnus'   => $this->M_dashboard->get_tot_dtw('rekap_wisnus_dtw', $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                                'tot_hotel_wisman' => $this->M_dashboard->get_tot_hotel('rekap_wisman_hotel', $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                                'tot_hotel_wisnus' => $this->M_dashboard->get_tot_hotel('rekap_wisnus_hotel', $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                                'tgl_awal'         => $tgl_awal_dft,
                                'tgl_akhir'        => $tgl_sekarang_df
                                ];
    
            }
    
            if ($level == 'dtw') {
                
                // level dtw
    
                    // untuk diagram dtw level dtw wisnus
    
                        $dtw_level_wisnus      = $this->M_dashboard->total_dtw_level_wisnus($id_dtw, $tgl_awal_dft, $tgl_sekarang_df, 'top');
    
                        $cari_dtw_level_wisnus = $this->M_dashboard->total_dtw_level_wisnus($id_dtw, $tgl_awal_dft, $tgl_sekarang_df, 'all');
    
                        $wisnus_dtw_level = 0;
    
                        foreach ($cari_dtw_level_wisnus->result_array() as $c) {
                            $wisnus_dtw_level += $c['jumlah_wisnus'];
                        }
    
                        $data_dtw_level_wisnus   = (object) [ 'id_provinsi'      => '',
                                                            'nama_provinsi'    => 'lain-lain',
                                                            'jumlah_wisnus'    => $wisnus_dtw_level
                                                        ];
    
                        array_push($dtw_level_wisnus, $data_dtw_level_wisnus);
    
                    // Akhir untuk diagram dtw kota wisnus
    
                    // untuk diagram dtw level dtw wisman
    
                        $dtw_level_wisman      = $this->M_dashboard->total_dtw_level_wisman($id_dtw, $tgl_awal_dft, $tgl_sekarang_df, 'top');
    
                        $cari_dtw_level_wisman = $this->M_dashboard->total_dtw_level_wisman($id_dtw, $tgl_awal_dft, $tgl_sekarang_df, 'all');
    
                        $wisman_dtw_level = 0;
    
                        foreach ($cari_dtw_level_wisman->result_array() as $c) {
                            $wisman_dtw_level += $c['jumlah_wisman'];
                        }
    
                        $data_dtw_level_wisman   = (object) [ 'id_negara'      => '',
                                                            'nama_negara'    => 'lain-lain',
                                                            'jumlah_wisman'  => $wisman_dtw_level
                                                        ];
    
                        array_push($dtw_level_wisman, $data_dtw_level_wisman);
                        
                    // Akhir untuk diagram dtw kota wisman
    
                // Akhir level dtw
    
                $data_dtw = ['judul'            => 'dashboard',
                              'userdata'         => $this->userdata,
                              'Menu'             => 'Dashboard',
                              'Page'             => 'Dashboard',
                              'dtw_level_wisnus'  => $dtw_level_wisnus,
                              'dtw_level_wisman'  => $dtw_level_wisman,
                              'tot_dtw_wisman'   => $this->M_dashboard->get_tot_dtw('rekap_wisman_dtw', $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                              'tot_dtw_wisnus'   => $this->M_dashboard->get_tot_dtw('rekap_wisnus_dtw', $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                              'tot_hotel_wisman' => $this->M_dashboard->get_tot_hotel('rekap_wisman_hotel', $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                              'tot_hotel_wisnus' => $this->M_dashboard->get_tot_hotel('rekap_wisnus_hotel', $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                              'tgl_awal'         => $tgl_awal_dft,
                              'tgl_akhir'        => $tgl_sekarang_df
                            ];
    
            }
    
            if ($level == 'hotel') {
                
                // level hotel
    
                    // untuk diagram hotel level hotel wisnus
    
                        $hotel_level_wisnus      = $this->M_dashboard->total_hotel_level_wisnus($id_hotel, $tgl_awal_dft, $tgl_sekarang_df, 'top');
    
                        $cari_hotel_level_wisnus = $this->M_dashboard->total_hotel_level_wisnus($id_hotel, $tgl_awal_dft, $tgl_sekarang_df, 'all');
    
                        $wisnus_hotel_level = 0;
    
                        foreach ($cari_hotel_level_wisnus->result_array() as $c) {
                            $wisnus_hotel_level += $c['jumlah_wisnus'];
                        }
    
                        $data_hotel_level_wisnus   = (object) [ 'id_provinsi'      => '',
                                                        'nama_provinsi'    => 'lain-lain',
                                                        'jumlah_wisnus'    => $wisnus_hotel_level
                                                    ];
    
                        array_push($hotel_level_wisnus, $data_hotel_level_wisnus);
    
                    // Akhir untuk diagram hotel kota wisnus
    
                    // untuk diagram hotel level hotel wisman
    
                        $hotel_level_wisman      = $this->M_dashboard->total_hotel_level_wisman($id_hotel, $tgl_awal_dft, $tgl_sekarang_df, 'top');
    
                        $cari_hotel_level_wisman = $this->M_dashboard->total_hotel_level_wisman($id_hotel, $tgl_awal_dft, $tgl_sekarang_df, 'all');
    
                        $wisman_hotel_level = 0;
    
                        foreach ($cari_hotel_level_wisman->result_array() as $c) {
                            $wisman_hotel_level += $c['jumlah_wisman'];
                        }
    
                        $data_hotel_level_wisman   = (object) [ 'id_negara'      => '',
                                                            'nama_negara'    => 'lain-lain',
                                                            'jumlah_wisman'  => $wisman_hotel_level
                                                        ];
    
                        array_push($hotel_level_wisman, $data_hotel_level_wisman);
                        
                    // Akhir untuk diagram hotel kota wisman
    
                // Akhir level hotel
    
                $data_hotel = ['judul'              => 'dashboard',
                              'userdata'            => $this->userdata,
                              'Menu'                => 'Dashboard',
                              'Page'                => 'Dashboard',
                              'hotel_level_wisnus'  => $hotel_level_wisnus,
                              'hotel_level_wisman'  => $hotel_level_wisman,
                              'tot_dtw_wisman'   => $this->M_dashboard->get_tot_dtw('rekap_wisman_dtw', $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                              'tot_dtw_wisnus'   => $this->M_dashboard->get_tot_dtw('rekap_wisnus_dtw', $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                              'tot_hotel_wisman' => $this->M_dashboard->get_tot_hotel('rekap_wisman_hotel', $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                              'tot_hotel_wisnus' => $this->M_dashboard->get_tot_hotel('rekap_wisnus_hotel', $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                              'tgl_awal'         => $tgl_awal_dft,
                              'tgl_akhir'        => $tgl_sekarang_df
                            ];
    
            }
            
            $data = ['judul'            => 'dashboard',
                     'userdata'         => $this->userdata,
                     'Menu'             => 'Dashboard',
                     'Page'             => 'Dashboard',
                     'tot_dtw_wisman'   => $this->M_dashboard->get_tot_dtw('rekap_wisman_dtw', $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                     'tot_dtw_wisnus'   => $this->M_dashboard->get_tot_dtw('rekap_wisnus_dtw', $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                     'tot_hotel_wisman' => $this->M_dashboard->get_tot_hotel('rekap_wisman_hotel', $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                     'tot_hotel_wisnus' => $this->M_dashboard->get_tot_hotel('rekap_wisnus_hotel', $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                     'dtw'              => $dtw,
                     'hotel'            => $hotel,
                     'dtw_wisnus'       => $dtw_wisnus,
                     'dtw_wisman'       => $dtw_wisman,
                     'hotel_wisnus'     => $hotel_wisnus,
                     'hotel_wisman'     => $hotel_wisman,
                     'tgl_awal'         => $tgl_awal_dft,
                     'tgl_akhir'        => $tgl_sekarang_df
                    ];

            $level = $this->session->userdata('level');

            if ($level == 'provinsi') {
                $this->template->views('index', $data);
            } elseif($level == 'kota') {
                $this->template->views('V_dashboard_kota', $data_kota);
            } elseif($level == 'dtw') {
                $this->template->views('V_dashboard_dtw', $data_dtw);
            } elseif($level == 'hotel') {
                $this->template->views('V_dashboard_hotel', $data_hotel);
            } elseif($level == 'petugas') {
                $this->template->views('V_dashboard_petugas', $data_petugas);
            } else {
                $this->template->views('index', $data);
            }

        } else {

            session_destroy();
            redirect('Auth');

        }
    }

    // menampilkan tanggal
    public function menampilkan_tgl()
    {
        $tgl = $this->input->post('tgl');

        $data = ['tgl' => nice_date($tgl, 'd-F-Y'), 'status' => TRUE];

        echo json_encode($data);
        
    }

    // menampilkan filter dashboard
    public function menampilkan_filter_dashboard()
    {
        $periode    = $this->input->post('periode');
        
        $tgl_awal_dft       = nice_date($this->input->post('tgl_awal'), 'Y-m-d');
        $tgl_sekarang_df    = nice_date($this->input->post('tgl_akhir'), 'Y-m-d');

        $level      = $this->session->userdata('level');
        $id_dtw     = $this->userdata->id_dtw;
        $id_hotel   = $this->userdata->id_hotel;
        $id_kota    = $this->userdata->id_kota;
        $id_pegawai = $this->userdata->id_pegawai;
        
        // level PROVINSI

            // untuk diagram dtw

                $dtw = $this->M_dashboard->get_total_dtw($tgl_awal_dft, $tgl_sekarang_df, 'top');

                $cari = $this->M_dashboard->get_total_dtw($tgl_awal_dft, $tgl_sekarang_df, 'all');

                $wisnus = 0;
                $wisman = 0;
                $jumlah = 0;

                foreach ($cari->result_array() as $c) {
                    $wisnus += $c['jumlah_wisnus'];
                    $wisman += $c['jumlah_wisman'];
                    $jumlah += $c['jumlah'];
                }

                $data   = (object) ['id_kota'          => '',
                                    'nama_kota'        => 'lain-lain',
                                    'jumlah_wisnus'    => $wisnus,
                                    'jumlah_wisman'    => $wisman,
                                    'jumlah'           => $jumlah
                                    ];

                array_push($dtw, $data);

            // Akhir untuk diagram dtw

            // untuk diagram dtw wisnus

                $dtw_wisnus      = $this->M_dashboard->total_dtw_wisnus($tgl_awal_dft, $tgl_sekarang_df, 'top');

                $cari_dtw_wisnus = $this->M_dashboard->total_dtw_wisnus($tgl_awal_dft, $tgl_sekarang_df, 'all');

                $wisnus_dtw = 0;

                foreach ($cari_dtw_wisnus->result_array() as $c) {
                    $wisnus_dtw += $c['jumlah_wisnus'];
                }

                $data_wisnus   = (object) [ 'id_provinsi'      => '',
                                            'nama_provinsi'    => 'lain-lain',
                                            'jumlah_wisnus'    => $wisnus_dtw
                                        ];

                array_push($dtw_wisnus, $data_wisnus);

            // Akhir untuk diagram dtw wisnus

            // untuk diagram dtw wisman

                $dtw_wisman      = $this->M_dashboard->total_dtw_wisman($tgl_awal_dft, $tgl_sekarang_df, 'top');

                $cari_dtw_wisman = $this->M_dashboard->total_dtw_wisman($tgl_awal_dft, $tgl_sekarang_df, 'all');

                $wisman_dtw = 0;

                foreach ($cari_dtw_wisman->result_array() as $c) {
                    $wisman_dtw += $c['jumlah_wisman'];
                }

                $data_wisman   = (object) [ 'id_negara'      => '',
                                            'nama_negara'    => 'lain-lain',
                                            'jumlah_wisman'  => $wisman_dtw
                                        ];

                array_push($dtw_wisman, $data_wisman);
                
            // Akhir untuk diagram dtw wisman

            // untuk diagram hotel

                $hotel = $this->M_dashboard->get_total_hotel($tgl_awal_dft, $tgl_sekarang_df, 'top');

                $cari = $this->M_dashboard->get_total_hotel($tgl_awal_dft, $tgl_sekarang_df, 'all');

                $wisnus = 0;
                $wisman = 0;
                $jumlah = 0;

                foreach ($cari->result_array() as $c) {
                    $wisnus += $c['jumlah_wisnus'];
                    $wisman += $c['jumlah_wisman'];
                    $jumlah += $c['jumlah'];
                }

                $data2   = (object) ['id_kota'         => '',
                                    'nama_kota'        => 'lain-lain',
                                    'jumlah_wisnus'    => $wisnus,
                                    'jumlah_wisman'    => $wisman,
                                    'jumlah'           => $jumlah
                                    ];

                array_push($hotel, $data2);

            // Akhir untuk diagram hotel

            // untuk diagram hotel wisnus

                $hotel_wisnus      = $this->M_dashboard->total_hotel_wisnus($tgl_awal_dft, $tgl_sekarang_df, 'top');

                $cari_hotel_wisnus = $this->M_dashboard->total_hotel_wisnus($tgl_awal_dft, $tgl_sekarang_df, 'all');

                $wisnus_hotel = 0;

                foreach ($cari_hotel_wisnus->result_array() as $c) {
                    $wisnus_hotel += $c['jumlah_wisnus'];
                }

                $data_wisnus   = (object) [ 'id_provinsi'      => '',
                                            'nama_provinsi'    => 'lain-lain',
                                            'jumlah_wisnus'    => $wisnus_hotel
                                        ];

                array_push($hotel_wisnus, $data_wisnus);

            // Akhir untuk diagram hotel wisnus

            // untuk diagram hotel wisman

                $hotel_wisman      = $this->M_dashboard->total_hotel_wisman($tgl_awal_dft, $tgl_sekarang_df, 'top');

                $cari_hotel_wisman = $this->M_dashboard->total_hotel_wisman($tgl_awal_dft, $tgl_sekarang_df, 'all');

                $wisman_hotel = 0;

                foreach ($cari_hotel_wisman->result_array() as $c) {
                    $wisman_hotel += $c['jumlah_wisman'];
                }

                $data_wisman   = (object) [ 'id_negara'      => '',
                                            'nama_negara'    => 'lain-lain',
                                            'jumlah_wisman'  => $wisman_hotel
                                        ];

                array_push($hotel_wisman, $data_wisman);
                
            // Akhir untuk diagram hotel wisman

        // Akhir level PROVINSI

        if ($level == 'kota') {
               
            // level KOTA

                // untuk diagram dtw kota

                    $dtw_kota       = $this->M_dashboard->total_dtw_kota($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari_dtw_kota  = $this->M_dashboard->total_dtw_kota($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisnus_dtw_kota = 0;
                    $wisman_dtw_kota = 0;
                    $jumlah_dtw_kota = 0;

                    foreach ($cari_dtw_kota->result_array() as $c) {
                        $wisnus_dtw_kota += $c['jumlah_wisnus'];
                        $wisman_dtw_kota += $c['jumlah_wisman'];
                        $jumlah_dtw_kota += $c['jumlah'];
                    }

                    $data_dtw_kota   = (object) ['id_dtw'           => '',
                                                'nama_dtw'         => 'lain-lain',
                                                'jumlah_wisnus'    => $wisnus_dtw_kota,
                                                'jumlah_wisman'    => $wisman_dtw_kota,
                                                'jumlah'           => $jumlah_dtw_kota
                                                ];

                    array_push($dtw_kota, $data_dtw_kota);

                // Akhir untuk diagram dtw kota

                // untuk diagram dtw kota wisnus

                    $dtw_kota_wisnus      = $this->M_dashboard->total_dtw_kota_wisnus($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari_dtw_kota_wisnus = $this->M_dashboard->total_dtw_kota_wisnus($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisnus_dtw_kota = 0;

                    foreach ($cari_dtw_kota_wisnus->result_array() as $c) {
                        $wisnus_dtw_kota += $c['jumlah_wisnus'];
                    }

                    $data_dtw_kota_wisnus   = (object) [ 'id_provinsi'      => '',
                                                    'nama_provinsi'    => 'lain-lain',
                                                    'jumlah_wisnus'    => $wisnus_dtw_kota
                                                ];

                    array_push($dtw_kota_wisnus, $data_dtw_kota_wisnus);

                // Akhir untuk diagram dtw kota wisnus

                // untuk diagram dtw kota wisman

                    $dtw_kota_wisman      = $this->M_dashboard->total_dtw_kota_wisman($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari_dtw_kota_wisman = $this->M_dashboard->total_dtw_kota_wisman($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisman_dtw_kota = 0;

                    foreach ($cari_dtw_kota_wisman->result_array() as $c) {
                        $wisman_dtw_kota += $c['jumlah_wisman'];
                    }

                    $data_dtw_kota_wisman   = (object) [ 'id_negara'      => '',
                                                        'nama_negara'    => 'lain-lain',
                                                        'jumlah_wisman'  => $wisman_dtw_kota
                                                    ];

                    array_push($dtw_kota_wisman, $data_dtw_kota_wisman);
                    
                // Akhir untuk diagram dtw kota wisman

                // untuk diagram hotel kota

                    $hotel_kota       = $this->M_dashboard->total_hotel_kota($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari_hotel_kota  = $this->M_dashboard->total_hotel_kota($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisnus_hotel_kota = 0;
                    $wisman_hotel_kota = 0;
                    $jumlah_hotel_kota = 0;

                    foreach ($cari_hotel_kota->result_array() as $c) {
                        $wisnus_hotel_kota += $c['jumlah_wisnus'];
                        $wisman_hotel_kota += $c['jumlah_wisman'];
                        $jumlah_hotel_kota += $c['jumlah'];
                    }

                    $data_hotel_kota   = (object) ['id_hotel'           => '',
                                                'nama_hotel'         => 'lain-lain',
                                                'jumlah_wisnus'      => $wisnus_hotel_kota,
                                                'jumlah_wisman'      => $wisman_hotel_kota,
                                                'jumlah'             => $jumlah_hotel_kota
                                                ];

                    array_push($hotel_kota, $data_hotel_kota);

                // Akhir untuk diagram hotel kota

                // untuk diagram hotel kota wisnus

                    $hotel_kota_wisnus      = $this->M_dashboard->total_hotel_kota_wisnus($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari_hotel_kota_wisnus = $this->M_dashboard->total_hotel_kota_wisnus($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisnus_hotel_kota = 0;

                    foreach ($cari_hotel_kota_wisnus->result_array() as $c) {
                        $wisnus_hotel_kota += $c['jumlah_wisnus'];
                    }

                    $data_hotel_kota_wisnus   = (object) [ 'id_provinsi'      => '',
                                                    'nama_provinsi'    => 'lain-lain',
                                                    'jumlah_wisnus'    => $wisnus_hotel_kota
                                                ];

                    array_push($hotel_kota_wisnus, $data_hotel_kota_wisnus);

                // Akhir untuk diagram hotel kota wisnus

                // untuk diagram hotel kota wisman

                    $hotel_kota_wisman      = $this->M_dashboard->total_hotel_kota_wisman($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari_hotel_kota_wisman = $this->M_dashboard->total_hotel_kota_wisman($id_kota, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisman_hotel_kota = 0;

                    foreach ($cari_hotel_kota_wisman->result_array() as $c) {
                        $wisman_hotel_kota += $c['jumlah_wisman'];
                    }

                    $data_hotel_kota_wisman   = (object) [ 'id_negara'      => '',
                                                            'nama_negara'    => 'lain-lain',
                                                            'jumlah_wisman'  => $wisman_hotel_kota
                                                        ];

                    array_push($hotel_kota_wisman, $data_hotel_kota_wisman);
                    
                // Akhir untuk diagram hotel kota wisman

            // Akhir KOTA

            $data_kota = ['judul'            => 'dashboard',
                        'userdata'         => $this->userdata,
                        'Menu'             => 'Dashboard',
                        'Page'             => 'Dashboard',
                        'dtw_kota'         => $dtw_kota,
                        'dtw_kota_wisnus'  => $dtw_kota_wisnus,
                        'dtw_kota_wisman'  => $dtw_kota_wisman,
                        'hotel_kota'       => $hotel_kota,
                        'hotel_kota_wisnus'=> $hotel_kota_wisnus,
                        'hotel_kota_wisman'=> $hotel_kota_wisman,
                        'tot_dtw_wisman'   => $this->M_dashboard->get_tot_dtw('rekap_wisman_dtw', $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                        'tot_dtw_wisnus'   => $this->M_dashboard->get_tot_dtw('rekap_wisnus_dtw', $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                        'tot_hotel_wisman' => $this->M_dashboard->get_tot_hotel('rekap_wisman_hotel', $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                        'tot_hotel_wisnus' => $this->M_dashboard->get_tot_hotel('rekap_wisnus_hotel', $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array()
                        ];

        }

        if ($level == 'petugas') {
               
            // level PETUGAS

                // untuk diagram dtw petugas

                    $dtw_petugas       = $this->M_dashboard->total_dtw_petugas($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari_dtw_petugas  = $this->M_dashboard->total_dtw_petugas($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisnus_dtw_petugas = 0;
                    $wisman_dtw_petugas = 0;
                    $jumlah_dtw_petugas = 0;

                    foreach ($cari_dtw_petugas->result_array() as $c) {
                        $wisnus_dtw_petugas += $c['jumlah_wisnus'];
                        $wisman_dtw_petugas += $c['jumlah_wisman'];
                        $jumlah_dtw_petugas += $c['jumlah'];
                    }

                    $data_dtw_petugas   = (object) ['id_dtw'           => '',
                                                'nama_dtw'         => 'lain-lain',
                                                'jumlah_wisnus'    => $wisnus_dtw_petugas,
                                                'jumlah_wisman'    => $wisman_dtw_petugas,
                                                'jumlah'           => $jumlah_dtw_petugas
                                                ];

                    array_push($dtw_petugas, $data_dtw_petugas);

                // Akhir untuk diagram dtw petugas

                // untuk diagram dtw petugas wisnus

                    $dtw_petugas_wisnus      = $this->M_dashboard->total_dtw_petugas_wisnus($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari_dtw_petugas_wisnus = $this->M_dashboard->total_dtw_petugas_wisnus($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisnus_dtw_petugas = 0;

                    foreach ($cari_dtw_petugas_wisnus->result_array() as $c) {
                        $wisnus_dtw_petugas += $c['jumlah_wisnus'];
                    }

                    $data_dtw_petugas_wisnus   = (object) [ 'id_provinsi'      => '',
                                                    'nama_provinsi'    => 'lain-lain',
                                                    'jumlah_wisnus'    => $wisnus_dtw_petugas
                                                ];

                    array_push($dtw_petugas_wisnus, $data_dtw_petugas_wisnus);

                // Akhir untuk diagram dtw petugas wisnus

                // untuk diagram dtw petugas wisman

                    $dtw_petugas_wisman      = $this->M_dashboard->total_dtw_petugas_wisman($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari_dtw_petugas_wisman = $this->M_dashboard->total_dtw_petugas_wisman($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisman_dtw_petugas = 0;

                    foreach ($cari_dtw_petugas_wisman->result_array() as $c) {
                        $wisman_dtw_petugas += $c['jumlah_wisman'];
                    }

                    $data_dtw_petugas_wisman   = (object) [ 'id_negara'      => '',
                                                        'nama_negara'    => 'lain-lain',
                                                        'jumlah_wisman'  => $wisman_dtw_petugas
                                                    ];

                    array_push($dtw_petugas_wisman, $data_dtw_petugas_wisman);
                    
                // Akhir untuk diagram dtw petugas wisman

                // untuk diagram hotel petugas

                    $hotel_petugas       = $this->M_dashboard->total_hotel_petugas($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari_hotel_petugas  = $this->M_dashboard->total_hotel_petugas($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisnus_hotel_petugas = 0;
                    $wisman_hotel_petugas = 0;
                    $jumlah_hotel_petugas = 0;

                    foreach ($cari_hotel_petugas->result_array() as $c) {
                        $wisnus_hotel_petugas += $c['jumlah_wisnus'];
                        $wisman_hotel_petugas += $c['jumlah_wisman'];
                        $jumlah_hotel_petugas += $c['jumlah'];
                    }

                    $data_hotel_petugas   = (object) ['id_hotel'           => '',
                                                'nama_hotel'         => 'lain-lain',
                                                'jumlah_wisnus'      => $wisnus_hotel_petugas,
                                                'jumlah_wisman'      => $wisman_hotel_petugas,
                                                'jumlah'             => $jumlah_hotel_petugas
                                                ];

                    array_push($hotel_petugas, $data_hotel_petugas);

                // Akhir untuk diagram hotel petugas

                // untuk diagram hotel petugas wisnus

                    $hotel_petugas_wisnus      = $this->M_dashboard->total_hotel_petugas_wisnus($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari_hotel_petugas_wisnus = $this->M_dashboard->total_hotel_petugas_wisnus($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisnus_hotel_petugas = 0;

                    foreach ($cari_hotel_petugas_wisnus->result_array() as $c) {
                        $wisnus_hotel_petugas += $c['jumlah_wisnus'];
                    }

                    $data_hotel_petugas_wisnus   = (object) [ 'id_provinsi'      => '',
                                                    'nama_provinsi'    => 'lain-lain',
                                                    'jumlah_wisnus'    => $wisnus_hotel_petugas
                                                ];

                    array_push($hotel_petugas_wisnus, $data_hotel_petugas_wisnus);

                // Akhir untuk diagram hotel petugas wisnus

                // untuk diagram hotel petugas wisman

                    $hotel_petugas_wisman      = $this->M_dashboard->total_hotel_petugas_wisman($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari_hotel_petugas_wisman = $this->M_dashboard->total_hotel_petugas_wisman($id_pegawai, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisman_hotel_petugas = 0;

                    foreach ($cari_hotel_petugas_wisman->result_array() as $c) {
                        $wisman_hotel_petugas += $c['jumlah_wisman'];
                    }

                    $data_hotel_petugas_wisman   = (object) [ 'id_negara'      => '',
                                                            'nama_negara'    => 'lain-lain',
                                                            'jumlah_wisman'  => $wisman_hotel_petugas
                                                        ];

                    array_push($hotel_petugas_wisman, $data_hotel_petugas_wisman);
                    
                // Akhir untuk diagram hotel petugas wisman

            // Akhir PETUGAS

            $data_petugas = ['judul'              => 'dashboard',
                            'userdata'            => $this->userdata,
                            'Menu'                => 'Dashboard',
                            'Page'                => 'Dashboard',
                            'dtw_petugas'         => $dtw_petugas,
                            'dtw_petugas_wisnus'  => $dtw_petugas_wisnus,
                            'dtw_petugas_wisman'  => $dtw_petugas_wisman,
                            'hotel_petugas'       => $hotel_petugas,
                            'hotel_petugas_wisnus'=> $hotel_petugas_wisnus,
                            'hotel_petugas_wisman'=> $hotel_petugas_wisman,
                            'tot_dtw_wisman'   => $this->M_dashboard->get_tot_dtw('rekap_wisman_dtw', $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                            'tot_dtw_wisnus'   => $this->M_dashboard->get_tot_dtw('rekap_wisnus_dtw', $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                            'tot_hotel_wisman' => $this->M_dashboard->get_tot_hotel('rekap_wisman_hotel', $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                            'tot_hotel_wisnus' => $this->M_dashboard->get_tot_hotel('rekap_wisnus_hotel', $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                            'tgl_awal'         => $tgl_awal_dft,
                            'tgl_akhir'        => $tgl_sekarang_df
                            ];

        }

        if ($level == 'dtw') {
            
            // level dtw

                // untuk diagram dtw level dtw wisnus

                    $dtw_level_wisnus      = $this->M_dashboard->total_dtw_level_wisnus($id_dtw, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari_dtw_level_wisnus = $this->M_dashboard->total_dtw_level_wisnus($id_dtw, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisnus_dtw_level = 0;

                    foreach ($cari_dtw_level_wisnus->result_array() as $c) {
                        $wisnus_dtw_level += $c['jumlah_wisnus'];
                    }

                    $data_dtw_level_wisnus   = (object) [ 'id_provinsi'      => '',
                                                        'nama_provinsi'    => 'lain-lain',
                                                        'jumlah_wisnus'    => $wisnus_dtw_level
                                                    ];

                    array_push($dtw_level_wisnus, $data_dtw_level_wisnus);

                // Akhir untuk diagram dtw kota wisnus

                // untuk diagram dtw level dtw wisman

                    $dtw_level_wisman      = $this->M_dashboard->total_dtw_level_wisman($id_dtw, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari_dtw_level_wisman = $this->M_dashboard->total_dtw_level_wisman($id_dtw, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisman_dtw_level = 0;

                    foreach ($cari_dtw_level_wisman->result_array() as $c) {
                        $wisman_dtw_level += $c['jumlah_wisman'];
                    }

                    $data_dtw_level_wisman   = (object) [ 'id_negara'      => '',
                                                        'nama_negara'    => 'lain-lain',
                                                        'jumlah_wisman'  => $wisman_dtw_level
                                                    ];

                    array_push($dtw_level_wisman, $data_dtw_level_wisman);
                    
                // Akhir untuk diagram dtw kota wisman

            // Akhir level dtw

            $data_dtw = ['judul'            => 'dashboard',
                          'userdata'         => $this->userdata,
                          'Menu'             => 'Dashboard',
                          'Page'             => 'Dashboard',
                          'dtw_level_wisnus'  => $dtw_level_wisnus,
                          'dtw_level_wisman'  => $dtw_level_wisman,
                          'tot_dtw_wisman'   => $this->M_dashboard->get_tot_dtw('rekap_wisman_dtw', $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                          'tot_dtw_wisnus'   => $this->M_dashboard->get_tot_dtw('rekap_wisnus_dtw', $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                          'tot_hotel_wisman' => $this->M_dashboard->get_tot_hotel('rekap_wisman_hotel', $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                          'tot_hotel_wisnus' => $this->M_dashboard->get_tot_hotel('rekap_wisnus_hotel', $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                          'tgl_awal'         => $tgl_awal_dft,
                          'tgl_akhir'        => $tgl_sekarang_df
                        ];

        }

        if ($level == 'hotel') {
            
            // level hotel

                // untuk diagram hotel level hotel wisnus

                    $hotel_level_wisnus      = $this->M_dashboard->total_hotel_level_wisnus($id_hotel, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari_hotel_level_wisnus = $this->M_dashboard->total_hotel_level_wisnus($id_hotel, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisnus_hotel_level = 0;

                    foreach ($cari_hotel_level_wisnus->result_array() as $c) {
                        $wisnus_hotel_level += $c['jumlah_wisnus'];
                    }

                    $data_hotel_level_wisnus   = (object) [ 'id_provinsi'      => '',
                                                    'nama_provinsi'    => 'lain-lain',
                                                    'jumlah_wisnus'    => $wisnus_hotel_level
                                                ];

                    array_push($hotel_level_wisnus, $data_hotel_level_wisnus);

                // Akhir untuk diagram hotel kota wisnus

                // untuk diagram hotel level hotel wisman

                    $hotel_level_wisman      = $this->M_dashboard->total_hotel_level_wisman($id_hotel, $tgl_awal_dft, $tgl_sekarang_df, 'top');

                    $cari_hotel_level_wisman = $this->M_dashboard->total_hotel_level_wisman($id_hotel, $tgl_awal_dft, $tgl_sekarang_df, 'all');

                    $wisman_hotel_level = 0;

                    foreach ($cari_hotel_level_wisman->result_array() as $c) {
                        $wisman_hotel_level += $c['jumlah_wisman'];
                    }

                    $data_hotel_level_wisman   = (object) [ 'id_negara'      => '',
                                                        'nama_negara'    => 'lain-lain',
                                                        'jumlah_wisman'  => $wisman_hotel_level
                                                    ];

                    array_push($hotel_level_wisman, $data_hotel_level_wisman);
                    
                // Akhir untuk diagram hotel kota wisman

            // Akhir level hotel

            $data_hotel = ['judul'              => 'dashboard',
                          'userdata'            => $this->userdata,
                          'Menu'                => 'Dashboard',
                          'Page'                => 'Dashboard',
                          'hotel_level_wisnus'  => $hotel_level_wisnus,
                          'hotel_level_wisman'  => $hotel_level_wisman,
                          'tot_dtw_wisman'   => $this->M_dashboard->get_tot_dtw('rekap_wisman_dtw', $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                          'tot_dtw_wisnus'   => $this->M_dashboard->get_tot_dtw('rekap_wisnus_dtw', $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                          'tot_hotel_wisman' => $this->M_dashboard->get_tot_hotel('rekap_wisman_hotel', $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                          'tot_hotel_wisnus' => $this->M_dashboard->get_tot_hotel('rekap_wisnus_hotel', $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                          'tgl_awal'         => $tgl_awal_dft,
                          'tgl_akhir'        => $tgl_sekarang_df
                        ];

        }

        $data = ['judul'           => 'dashboard',
                'userdata'         => $this->userdata,
                'Menu'             => 'Dashboard',
                'Page'             => 'Dashboard',
                'dtw'              => $dtw,
                'hotel'            => $hotel,
                'dtw_wisnus'       => $dtw_wisnus,
                'dtw_wisman'       => $dtw_wisman,
                'hotel_wisnus'     => $hotel_wisnus,
                'hotel_wisman'     => $hotel_wisman,
                'tot_dtw_wisman'   => $this->M_dashboard->get_tot_dtw('rekap_wisman_dtw', $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                'tot_dtw_wisnus'   => $this->M_dashboard->get_tot_dtw('rekap_wisnus_dtw', $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                'tot_hotel_wisman' => $this->M_dashboard->get_tot_hotel('rekap_wisman_hotel', $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
                'tot_hotel_wisnus' => $this->M_dashboard->get_tot_hotel('rekap_wisnus_hotel', $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal_dft, $tgl_sekarang_df)->row_array(),
            ];
        
        if ($level == 'provinsi') {
            $this->load->view('V_dashboard_filter', $data);
        } elseif($level == 'kota') {
            $this->load->view('V_dashboard_kota_filter', $data_kota);
        } elseif($level == 'dtw') {
            $this->load->view('V_dashboard_dtw_filter', $data_dtw);
        } elseif($level == 'hotel') {
            $this->load->view('V_dashboard_hotel_filter', $data_hotel);
        } elseif ($level == 'petugas') {
            $this->load->view('V_dashboard_petugas_filter', $data_petugas);
        } else {
            $this->load->view('V_dashboard_filter', $data);
        }

    }

    public function tes()
    {
        $dtw = $this->M_dashboard->get_total_dtw();

        $cari = $this->M_dashboard->get_total();

        $wisnus = 0;
        $wisman = 0;
        $jumlah = 0;

        foreach ($cari->result_array() as $c) {
            $wisnus += $c['jumlah_wisnus'];
            $wisman += $c['jumlah_wisman'];
            $jumlah += $c['jumlah'];
        }

        $data      = (object) ['id_kota'          => '',
                     'nama_kota'        => 'lainlain',
                     'jumlah_wisnus'    => $wisnus,
                     'jumlah_wisman'    => $wisman,
                     'jumlah'           => $jumlah
                    ];

        array_push($dtw, $data);

        echo "<pre>";
        print_r($dtw);
        echo "</pre>";

    }
}
