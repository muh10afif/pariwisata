<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/API_Controller.php';
class C_User extends API_Controller
{
    function __construct($config = 'rest') 
    {
        parent::__construct($config);
        date_default_timezone_set("Asia/Jakarta");//set you countary name from below timezone list
        $this->load->model('M_User');
        $this->load->database();
    }

    public function Get()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['GET'],
            //'requireAuthorization' => true,
        ]);

        header('Content-Type: application/json'); 

         $username = $this->input->get('username');
         $password = $this->input->get('password');
         $hasil = $this->M_User->Login($username, $password);
         if($hasil != null)
         {
            echo json_encode($hasil);
         }
         else
         {
            $this->api_return([       'No Data'      ],        404);
         }
    }

    public function UpdateFoto()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['PUT'],
            //'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);
        $hasil = $this->M_User->UpdateFoto($data);
        echo json_encode($hasil);
    }

    public function ChangePassword()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['PUT'],
            //'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);
        $hasil = $this->M_User->ChangePassword($data);
        echo json_encode($hasil);
    }
}