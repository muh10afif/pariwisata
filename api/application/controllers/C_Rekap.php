<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/API_Controller.php';
class C_Rekap extends API_Controller
{
    function __construct($config = 'rest') 
    {
        parent::__construct($config);
        $this->load->model('M_Rekap');
        $this->load->model('M_dtw');
        $this->load->model('M_hotel');
        $this->load->database();
    }

    public function GetDataDTW()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            //'requireAuthorization' => true,
        ]);

        header('Content-Type: application/json'); 
        
        $id_pegawai = $this->input->get('id_pegawai');
        $id_dtw = $this->input->get('id_dtw');
        $periode = $this->input->get('periode');
        $id_kawasan = $this->input->get('id_kawasan');
        $list_dtw = $this->M_Rekap->Rekap_DTW_wisman($id_dtw,$periode,$id_kawasan);

        if(count($list_dtw) > 0)
        {
           echo json_encode($list_dtw);
        }
        else
        {
           $this->api_return([       'No Data'     ],        404);
        }
    }

    public function GetDataSementaraWisnusDTW()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            //'requireAuthorization' => true,
        ]);

        header('Content-Type: application/json'); 
        
        $id_pegawai = $this->input->get('id_pegawai');
        $id_dtw = $this->input->get('id_dtw');
        $periode = $this->input->get('periode');
        $list_dtw = $this->M_Rekap->Rekap_DTWSementara_wisnus($id_dtw,$periode);

        if(count($list_dtw) > 0)
        {
           echo json_encode($list_dtw);
        }
        else
        {
           $this->api_return([       'No Data'     ],        404);
        }
    }

    public function GetDataHotelWisman()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            //'requireAuthorization' => true,
        ]);

        header('Content-Type: application/json'); 
        
        $id_pegawai = $this->input->get('id_pegawai');
        $id_hotel = $this->input->get('id_hotel');
        $periode = $this->input->get('periode');
        $id_kawasan = $this->input->get('id_kawasan');
        $list_dtw = $this->M_Rekap->Rekap_Hotel_wisman($id_hotel,$periode,$id_kawasan);

        if(count($list_dtw) > 0)
        {
           echo json_encode($list_dtw);
        }
        else
        {
           $this->api_return([       'No Data'     ],        404);
        }
    }

    public function GetDataHotelWisnus()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            //'requireAuthorization' => true,
        ]);

        header('Content-Type: application/json'); 
        
        $id_pegawai = $this->input->get('id_pegawai');
        $id_hotel = $this->input->get('id_hotel');
        $periode = $this->input->get('periode');
        $list_dtw = $this->M_Rekap->Rekap_Hotel_wisnus($id_hotel,$periode);

        if(count($list_dtw) > 0)
        {
           echo json_encode($list_dtw);
        }
        else
        {
           $this->api_return([       'No Data'     ],        404);
        }
    }

    public function InputWismanHotel()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            //'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);
        foreach($data as $row)
        {
            $id_hotel = $row['id_hotel'];
            $id_negara = $row['id_negara'];
            $id_rekap = $row['id_rekap_wisman_hotel'];
            $pria = $row['pengunjung_pria'];
            $wanita = $row['pengunjung_wanita'];
            $jml = $row['jumlah_pengunjung'];
            $periode = $row['periode'];
            $add = $row['add_by'];
            $status = $row['status'];
            if($status != 0)
            { 
                $hasil = $this->M_Rekap->SimpanWismanHotel($data);
            }
                
            else
            {
                $hasil = $this->M_dtw->ubah_data('rekap_wisman_hotel', array('status' => 1), array('id_rekap_wisman_hotel' => $id_rekap, 'periode' => $periode, 'status' => 0));
            }
        }
        echo json_encode($hasil);
    }

    public function InputWisnusHotel()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
           // 'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);

        foreach($data as $row)
        {
            $id_hotel = $row['id_hotel'];
            $id_provinsi = $row['id_provinsi'];
            $pria = $row['pengunjung_pria'];
            $wanita = $row['pengunjung_wanita'];
            $jml = $row['jumlah_pengunjung'];
            $periode = $row['periode'];
            $add = $row['add_by'];
            $status = $row['status'];
            if($status != 0)
            { 
                $hasil = $this->M_Rekap->SimpanWisnusHotel($data);
            }
                
            else
            {
                $hasil = $this->M_hotel->ubah_data('rekap_wisnus_hotel', array('status' => 1), array('id_hotel' => $id_hotel, 'periode' => $periode, 'status' => 0));
            }
        }
        echo json_encode($hasil);
    }

    public function InputWisnusDTW()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            //'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);
        foreach($data as $row)
        {
            $id_dtw = $row['id_dtw'];
            $id_provinsi = $row['id_provinsi'];
            $id_kawasan = $row['id_kawasan'];
            $pria = $row['pengunjung_pria'];
            $wanita = $row['pengunjung_wanita'];
            $jml = $row['jumlah_pengunjung'];
            $provinsi = $row['id_provinsi'];
            $periode = $row['periode'];
            $add = $row['add_by'];
            $status = $row['status'];
            if($status != 0)
            { 
                $hasil = $this->M_Rekap->SimpanWisnusDTW($data);
            }
                
            else
            {
                $hasil = $this->M_dtw->ubah_data('rekap_wisnus_dtw', array('status' => 1), array('id_dtw' => $id_dtw, 'periode' => $periode, 'status' => 0));
            }
        }
        echo json_encode($hasil);
    }

    public function InputWismanDTW()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
           // 'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);
        foreach($data as $row)
        {
            $id_dtw = $row['id_dtw'];
            $id_provinsi = $row['id_provinsi'];
            $id_rekap = $row['id_rekap_wisman_dtw'];
            $pria = $row['pengunjung_pria'];
            $wanita = $row['pengunjung_wanita'];
            $jml = $row['jumlah_pengunjung'];
            $periode = $row['periode'];
            $add = $row['add_by'];
            $status = $row['status'];
            if($status != 0)
            { 
                $hasil = $this->M_Rekap->SimpanWismanDTW($data);
            }
                
            else
            {
                $hasil = $this->M_dtw->ubah_data('rekap_wisman_dtw', array('status' => 1), array('id_rekap_wisman_dtw' => $id_rekap, 'periode' => $periode, 'status' => 0));
            }
        }
        echo json_encode($hasil);
    }

    public function InputWisnusDTWSementara()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            //'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);

        $hasil = $this->M_Rekap->SimpanWisnusDTWSementara($data);

        if($hasil == "Data Sudah Ada")
        {
            $this->api_return([       'No Data'     ],        404);
        }
        else
        {
            echo json_encode($hasil);
        }
    }

    public function InputWismanDTWSementara()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            //'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);

        $hasil = $this->M_Rekap->SimpanWismanDTWSementara($data);

        if($hasil == "Data Sudah Ada")
        {
            $this->api_return([       'No Data'     ],        404);
        }
        else
        {
            echo json_encode($hasil);
        }
    }

    public function InputWisnusHotelSementara()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            //'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);

        $hasil = $this->M_Rekap->SimpanWisnusHotelSementara($data);

        if($hasil == "Data Sudah Ada")
        {
            $this->api_return([       'No Data'     ],        404);
        }
        else
        {
            echo json_encode($hasil);
        }
    }

    public function InputWismanHotelSementara()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            //'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);

        $hasil = $this->M_Rekap->SimpanWismanHotelSementara($data);

        if($hasil == "Data Sudah Ada")
        {
            $this->api_return([       'No Data'     ],        404);
        }
        else
        {
            echo json_encode($hasil);
        }
    }

    public function LoadDataSementaraWisnusDTW()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            //'requireAuthorization' => true,
        ]);

        header('Content-Type: application/json'); 
        
        $id_dtw = $this->input->get('id_dtw');
        $periode = $this->input->get('periode');
        $list_dtw = $this->M_Rekap->Rekap_DTWSementara_wisnus($id_dtw,$periode);

        if(count($list_dtw) > 0)
        {
           echo json_encode($list_dtw);
        }
        else
        {
           $this->api_return([       'No Data'     ],        404);
        }
    }

    public function LoadDataSementaraWismanDtw()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            //'requireAuthorization' => true,
        ]);

        header('Content-Type: application/json'); 
        
        $id_dtw = $this->input->get('id_dtw');
        $periode = $this->input->get('periode');
        $list_hotel = $this->M_Rekap->Rekap_DTWSementara_wisman($id_dtw,$periode);

        if(count($list_hotel) > 0)
        {
           echo json_encode($list_hotel);
        }
        else
        {
           $this->api_return([       'No Data'     ],        404);
        }
    }

    public function LoadDataSementaraWisnusHotel()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            //'requireAuthorization' => true,
        ]);

        header('Content-Type: application/json'); 
        
        $id_hotel = $this->input->get('id_hotel');
        $periode = $this->input->get('periode');
        $list_hotel = $this->M_Rekap->Rekap_HotelSementara_wisnus($id_hotel,$periode);

        if(count($list_hotel) > 0)
        {
           echo json_encode($list_hotel);
        }
        else
        {
           $this->api_return([       'No Data'     ],        404);
        }
    }

    public function LoadDataSementaraWismanHotel()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            //'requireAuthorization' => true,
        ]);

        header('Content-Type: application/json'); 
        
        $id_hotel = $this->input->get('id_hotel');
        $periode = $this->input->get('periode');
        $list_hotel = $this->M_Rekap->Rekap_HotelSementara_wisman($id_hotel,$periode);

        if(count($list_hotel) > 0)
        {
           echo json_encode($list_hotel);
        }
        else
        {
           $this->api_return([       'No Data'     ],        404);
        }
    }

    public function TambahDataWisnusDTW()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            //'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);

        $id_dtw = $data['id_dtw'];
        $id_rekap = $data['id_rekap_wisnus_dtw'];
        $id_provinsi = $data['id_provinsi'];
        $id_kawasan = $data['id_kawasan'];
        $pria = $data['pengunjung_pria'];
        $wanita = $data['pengunjung_wanita'];
        $jumlah = $data['jumlah_pengunjung'];
        $provinsi = $data['id_provinsi'];
        $periode = $data['periode'];
        $add = $data['add_by'];

        $this->M_dtw->ubah_data('rekap_wisnus_dtw', array('status'  => 3), array('id_rekap_wisnus_dtw' => $id_rekap,'periode'=>$periode,'id_provinsi'=>$provinsi));

        $data = ['id_dtw'           => $id_dtw,
                 'pengunjung_pria'  => $pria,
                 'pengunjung_wanita'=> $wanita,
                 'jumlah_pengunjung'=> $jumlah,
                 'id_provinsi'      => $provinsi,
                 'add_by'           => $add,
                 'status'           => 0,
                 'periode'          => $periode
                ];
        
        $hasil = $this->M_dtw->input_data('rekap_wisnus_dtw', $data);

        echo json_encode($hasil);
    }

    public function UbahDataWisnusDTW()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            //'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);

        $id_dtw = $data['id_dtw'];
        $id_rekap = $data['id_rekap_wisnus_dtw'];
        $id_provinsi = $data['id_provinsi'];
        $id_kawasan = $data['id_kawasan'];
        $pria = $data['pengunjung_pria'];
        $wanita = $data['pengunjung_wanita'];
        $jumlah = $data['jumlah_pengunjung'];
        $provinsi = $data['id_provinsi'];
        $periode = $data['periode'];
        $add = $data['add_by'];

        $this->M_dtw->ubah_data('rekap_wisnus_dtw', array('status'  => 2), array('id_rekap_wisnus_dtw' => $id_rekap,'periode'=>$periode,'id_provinsi'=>$provinsi));
                
        $cr_data = $this->M_dtw->cari_data('rekap_wisnus_dtw', array('id_rekap_wisnus_dtw' => $id_rekap,'periode'=>$periode,'id_provinsi'=>$provinsi))->row_array();

        $cr_pria    = $cr_data['pengunjung_pria'];
        $cr_wanita  = $cr_data['pengunjung_wanita'];
        $cr_jumlah  = $cr_data['jumlah_pengunjung'];

        $dt = [ 'id_dtw'            => $id_dtw,
                'pengunjung_pria'   => $cr_pria + $pria,
                'pengunjung_wanita' => $cr_wanita + $wanita,
                'jumlah_pengunjung' => $cr_jumlah + $jumlah,
                'id_provinsi'       => $provinsi,
                'add_by'            => $id_dtw,
                'status'            => 0,
                'periode'           => $periode
                ];

        $hasil = $this->M_dtw->input_data('rekap_wisnus_dtw', $dt);
        echo json_encode($hasil);
    }

    public function TambahDataWismanDTW()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            //'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);

        $id_dtw = $data['id_dtw'];
        $id_rekap = $data['id_rekap_wisman_dtw'];
        $id_negara = $data['id_negara'];
        $id_kawasan = $data['id_kawasan'];
        $pria = $data['pengunjung_pria'];
        $wanita = $data['pengunjung_wanita'];
        $jml = $data['jumlah_pengunjung'];
        $periode = $data['periode'];
        $add = $data['add_by'];

        $this->M_dtw->ubah_data('rekap_wisman_dtw', array('status'  => 3), array('id_rekap_wisman_dtw' => $id_rekap,'periode'=>$periode,'id_negara'=>$id_negara));

        $data = [
                    'id_dtw'=>$id_dtw,
                    'id_negara'=>$id_negara,
                    'pengunjung_pria'=>$pria,
                    'pengunjung_wanita'=>$wanita,
                    'jumlah_pengunjung'=>$jml,
                    'periode'=>$periode,
                    'add_by'=>$add,
                    'status'=>0
                ];
        
        $hasil = $this->M_dtw->input_data('rekap_wisman_dtw', $data);

        echo json_encode($hasil);
    }

    public function UbahDataWismanDTW()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            //'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);

        $id_dtw = $data['id_dtw'];
        $id_rekap = $data['id_rekap_wisman_dtw'];
        $id_negara = $data['id_negara'];
        $pria = $data['pengunjung_pria'];
        $wanita = $data['pengunjung_wanita'];
        $jumlah = $data['jumlah_pengunjung'];
        $periode = $data['periode'];
        $add = $data['add_by'];

        $this->M_dtw->ubah_data('rekap_wisman_dtw', array('status'  => 2), array('id_rekap_wisman_dtw' => $id_rekap,'periode'=>$periode,'id_negara'=>$id_negara));
                
        $cr_data = $this->M_dtw->cari_data('rekap_wisman_dtw', array('id_rekap_wisman_dtw' => $id_rekap,'periode'=>$periode,'id_negara'=>$id_negara))->row_array();

        $cr_pria    = $cr_data['pengunjung_pria'];
        $cr_wanita  = $cr_data['pengunjung_wanita'];
        $cr_jumlah  = $cr_data['jumlah_pengunjung'];

        $dt = [ 
                'id_dtw'            => $id_dtw,
                'pengunjung_pria'   => $cr_pria + $pria,
                'pengunjung_wanita' => $cr_wanita + $wanita,
                'jumlah_pengunjung' => $cr_jumlah + $jumlah,
                'id_negara'         => $id_negara,
                'add_by'            => $add,
                'status'            => 0,
                'periode'           => $periode
                ];

        $hasil = $this->M_dtw->input_data('rekap_wisman_dtw', $dt);
        echo json_encode($hasil);
    }

    public function TambahDataWismanHotel()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            //'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);

        $id_hotel = $data['id_hotel'];
        $id_rekap = $data['id_rekap_wisman_hotel'];
        $id_negara = $data['id_negara'];
        $id_kawasan = $data['id_kawasan'];
        $pria = $data['pengunjung_pria'];
        $wanita = $data['pengunjung_wanita'];
        $jml = $data['jumlah_pengunjung'];
        $periode = $data['periode'];
        $add = $data['add_by'];

        $this->M_dtw->ubah_data('rekap_wisman_hotel', array('status'  => 3), array('id_rekap_wisman_hotel' => $id_rekap,'periode'=>$periode,'id_negara'=>$id_negara));

        $data = [
                    'id_hotel'=>$id_hotel,
                    'id_negara'=>$id_negara,
                    'pengunjung_pria'=>$pria,
                    'pengunjung_wanita'=>$wanita,
                    'jumlah_pengunjung'=>$jml,
                    'periode'=>$periode,
                    'add_by'=>$add,
                    'status'=>0
                ];
        
        $hasil = $this->M_dtw->input_data('rekap_wisman_hotel', $data);

        echo json_encode($hasil);
    }

    public function UbahDataWismanHotel()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            //'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);

        $id_hotel = $data['id_hotel'];
        $id_rekap = $data['id_rekap_wisman_hotel'];
        $id_negara = $data['id_negara'];
        $id_kawasan = $data['id_kawasan'];
        $pria = $data['pengunjung_pria'];
        $wanita = $data['pengunjung_wanita'];
        $jumlah = $data['jumlah_pengunjung'];
        $periode = $data['periode'];
        $add = $data['add_by'];

        $this->M_dtw->ubah_data('rekap_wisman_hotel', array('status'  => 2), array('id_rekap_wisman_hotel' => $id_rekap,'periode'=>$periode,'id_negara'=>$id_negara));
                
        $cr_data = $this->M_dtw->cari_data('rekap_wisman_hotel', array('id_rekap_wisman_hotel' => $id_rekap,'periode'=>$periode,'id_negara'=>$id_negara))->row_array();

        $cr_pria    = $cr_data['pengunjung_pria'];
        $cr_wanita  = $cr_data['pengunjung_wanita'];
        $cr_jumlah  = $cr_data['jumlah_pengunjung'];

        $dt = [ 
                'id_hotel'          => $id_hotel,
                'pengunjung_pria'   => $cr_pria + $pria,
                'pengunjung_wanita' => $cr_wanita + $wanita,
                'jumlah_pengunjung' => $cr_jumlah + $jumlah,
                'id_negara'         => $id_negara,
                'add_by'            => $add,
                'status'            => 0,
                'periode'           => $periode
                ];

        $this->M_dtw->input_data('rekap_wisman_hotel', $dt);
    }

    public function TambahDataWisnusHotel()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            //'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);

        $id_hotel = $data['id_hotel'];
        $id_rekap = $data['id_rekap_wisnus_hotel'];
        $id_provinsi = $data['id_provinsi'];
        $pria = $data['pengunjung_pria'];
        $wanita = $data['pengunjung_wanita'];
        $jml = $data['jumlah_pengunjung'];
        $periode = $data['periode'];
        $add = $data['add_by'];

        $this->M_dtw->ubah_data('rekap_wisnus_hotel', array('status'  => 3), array('id_rekap_wisnus_hotel' => $id_rekap,'periode'=>$periode,'id_provinsi'=>$id_provinsi));

        $data = [
                    'id_provinsi'=>$id_provinsi,
                    'pengunjung_pria'=>$pria,
                    'pengunjung_wanita'=>$wanita,
                    'jumlah_pengunjung'=>$jml,
                    'periode'=>$periode,
                    'add_by'=>$add,
                    'status'=>0
                ];
        
        $hasil = $this->M_dtw->input_data('rekap_wisnus_hotel', $data);

        echo json_encode($hasil);
    }

    public function UbahDataWisnusHotel()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            //'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);

        $id_hotel = $data['id_hotel'];
        $id_rekap = $data['id_rekap_wisnus_hotel'];
        $id_provinsi = $data['id_provinsi'];
        $pria = $data['pengunjung_pria'];
        $wanita = $data['pengunjung_wanita'];
        $jumlah = $data['jumlah_pengunjung'];
        $periode = $data['periode'];
        $add = $data['add_by'];

        $this->M_dtw->ubah_data('rekap_wisnus_hotel', array('status'  => 2), array('id_rekap_wisnus_hotel' => $id_rekap,'periode'=>$periode,'id_provinsi'=>$id_provinsi));
                
        $cr_data = $this->M_dtw->cari_data('rekap_wisnus_hotel', array('id_rekap_wisnus_hotel' => $id_rekap,'periode'=>$periode,'id_provinsi'=>$id_provinsi))->row_array();

        $cr_pria    = $cr_data['pengunjung_pria'];
        $cr_wanita  = $cr_data['pengunjung_wanita'];
        $cr_jumlah  = $cr_data['jumlah_pengunjung'];

        $dt = [ 
                'id_hotel'          => $id_hotel,
                'pengunjung_pria'   => $cr_pria + $pria,
                'pengunjung_wanita' => $cr_wanita + $wanita,
                'jumlah_pengunjung' => $cr_jumlah + $jumlah,
                'id_provinsi'       => $id_provinsi,
                'add_by'            => $add,
                'status'            => 0,
                'periode'           => $periode
                ];

        $this->M_dtw->input_data('rekap_wisnus_hotel', $dt);
    }

    public function GetDataDTWWisnus()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            //'requireAuthorization' => true,
        ]);

        header('Content-Type: application/json'); 
        
        $id_pegawai = $this->input->get('id_pegawai');
        $id_dtw = $this->input->get('id_dtw');
        $periode = $this->input->get('periode');
        $list_dtw = $this->M_Rekap->Rekap_DTW_wisnus($id_dtw,$periode);

        if(count($list_dtw) > 0)
        {
           echo json_encode($list_dtw);
        }
        else
        {
           $this->api_return([       'No Data'     ],        404);
        }
    }

    public function GetKelolaan()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            //'requireAuthorization' => true,
        ]);

        header('Content-Type: application/json'); 
        
        $id_pegawai = $this->input->get('id_petugas');

        $hasil = array();
        
        $dtw = $this->M_Rekap->jml_kelolaan_dtw($id_pegawai);
        $hotel = $this->M_Rekap->jml_kelolaan_hotel($id_pegawai);

        $hasil[] = array
        (
            'total_dtw' => $dtw,
            'total_hotel' => $hotel
        );

        if(count($hasil) > 0)
        {
           echo json_encode($hasil);
        }
        else
        {
           $this->api_return([       'No Data'     ],        404);
        }
    }

    public function GetKelolaanDTW()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            //'requireAuthorization' => true,
        ]);

        header('Content-Type: application/json'); 
        
        $id_dtw = $this->input->get('id_dtw');

        $hasil = array();
        
        $dtw = $this->M_Rekap->jml_rkp_dtw($id_dtw);

        $hasil[] = array
        (
            'total_dtw' => $dtw,
        );

        if(count($hasil) > 0)
        {
           echo json_encode($hasil);
        }
        else
        {
           $this->api_return([       'No Data'     ],        404);
        }
    }

    public function GetKelolaanHotel()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            //'requireAuthorization' => true,
        ]);

        header('Content-Type: application/json'); 
        
        $id_hotel = $this->input->get('id_hotel');

        $hasil = array();
        
        $hotel = $this->M_Rekap->jml_rkp_hotel($id_hotel);

        $hasil[] = array
        (
            'total_hotel' => $hotel,
        );

        if(count($hasil) > 0)
        {
           echo json_encode($hasil);
        }
        else
        {
           $this->api_return([       'No Data'     ],        404);
        }
    }

    public function TotalDTWWisnus()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            //'requireAuthorization' => true,
        ]);

        header('Content-Type: application/json'); 
        
        $id_dtw = $this->input->get('id_dtw');
        $periode = $this->input->get('periode');
        
        $hasil = array();

        $jml = $this->M_Rekap->total_rkp_dtw_wisnus($id_dtw,$periode);

        $hasil = array
        (
            $jml
        );

        if(count($hasil) > 0)
        {
           echo json_encode($hasil);
        }
        else
        {
           $this->api_return([       'No Data'     ],        404);
        }
    }

    public function TotalDTWWisman()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            //'requireAuthorization' => true,
        ]);

        header('Content-Type: application/json'); 
        
        $id_dtw = $this->input->get('id_dtw');
        $periode = $this->input->get('periode');
        $id_kawasan = $this->input->get('id_kawasan');
        
        $hasil = array();

        $jml = $this->M_Rekap->total_rkp_dtw_wisman($id_kawasan,$periode,$id_dtw);

        $hasil = array
        (
            $jml
        );

        if(count($hasil) > 0)
        {
           echo json_encode($hasil);
        }
        else
        {
           $this->api_return([       'No Data'     ],        404);
        }
    }

    public function TotalHotelWisnus()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            //'requireAuthorization' => true,
        ]);

        header('Content-Type: application/json'); 
        
        $id_hotel = $this->input->get('id_hotel');
        $periode = $this->input->get('periode');
        
        $hasil = array();

        $jml = $this->M_Rekap->total_rkp_hotel_wisnus($id_hotel,$periode);

        $hasil = array
        (
            $jml
        );

        if(count($hasil) > 0)
        {
           echo json_encode($hasil);
        }
        else
        {
           $this->api_return([       'No Data'     ],        404);
        }
    }

    public function TotalHotelWisman()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            //'requireAuthorization' => true,
        ]);

        header('Content-Type: application/json'); 
        
        $id_hotel = $this->input->get('id_hotel');
        $periode = $this->input->get('periode');
        $id_kawasan = $this->input->get('id_kawasan');
        
        $hasil = array();

        $jml = $this->M_Rekap->total_rkp_hotel_wisman($id_kawasan,$periode,$id_hotel);

        $hasil = array
        (
            $jml
        );

        if(count($hasil) > 0)
        {
           echo json_encode($hasil);
        }
        else
        {
           $this->api_return([       'No Data'     ],        404);
        }
    }
}