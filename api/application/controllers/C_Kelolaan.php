<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/API_Controller.php';
class C_Kelolaan extends API_Controller
{
    function __construct($config = 'rest') 
    {
        parent::__construct($config);
        date_default_timezone_set("Asia/Jakarta");//set you countary name from below timezone list
        $this->load->model('M_Kelolaan');
        $this->load->database();
    }  

    public function GetKelolaanDtw()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            //'requireAuthorization' => true,
        ]);
        
        header('Content-Type: application/json'); 
        
        $id_pegawai = $this->input->get('id_pegawai');
        
        $list_dtw = $this->M_Kelolaan->Kelolaan_DTW($id_pegawai);

        if(count($list_dtw) > 0)
        {
           echo json_encode($list_dtw);
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
        
        $id_pegawai = $this->input->get('id_pegawai');
        
        $list_dtw = $this->M_Kelolaan->Kelolaan_Hotel($id_pegawai);

        if(count($list_dtw) > 0)
        {
           echo json_encode($list_dtw);
        }
        else
        {
           $this->api_return([       'No Data'     ],        404);
        }
    }
}