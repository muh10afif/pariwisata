<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/API_Controller.php';
class C_Tracking extends API_Controller
{
    function __construct($config = 'rest') 
    {
        parent::__construct($config);
        date_default_timezone_set("Asia/Jakarta");//set you countary name from below timezone list
        $this->load->model('M_Tracking');
        $this->load->database();
    }  

    public function PostLocation()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            //'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);
        $data['Add_time'] = date("Y-m-d H:i:s");
        $hasil = $this->M_Tracking->PostLocation($data);
        echo json_encode($hasil);
    }
}