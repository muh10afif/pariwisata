<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/API_Controller.php';
class C_Tasklist extends API_Controller
{
    function __construct($config = 'rest') 
    {
        parent::__construct($config);
        date_default_timezone_set("Asia/Jakarta");//set you countary name from below timezone list
        $this->load->model('M_Tasklist');
        $this->load->database();
    }  

    public function PutTasklist()
    {
        $user_data = $this->_apiConfig([
            'methods' => ['PUT'],
            //'requireAuthorization' => true,
        ]);
        
        $data = json_decode(file_get_contents('php://input'), true);
        $hasil = $this->M_Tasklist->PutTasklist($data);
        echo json_encode($hasil);
    }

    public function GetTasklist()
    {
        try
        {
            $user_data = $this->_apiConfig([
                'methods' => ['GET'],
                //'requireAuthorization' => true,
            ]);

            header('Content-Type: application/json');

            $id_karyawan = $this->input->get('id_karyawan');

            $hasil = $this->M_Tasklist->GetTasklist($id_karyawan);
            if(!empty($hasil))
            {
                echo json_encode($hasil);
            }
            else
            {
                $this->api_return(
                [       'No Data'     ],        404);
            }
        }
        catch( Exception $e)
        {
            log_message( 'error', $e->getMessage( ) . ' in ' . $e->getFile() . ':' . $e->getLine() );
        }
    }

    public function GetTasklistKunjungan()
    {
        try
        {
            $user_data = $this->_apiConfig([
                'methods' => ['GET'],
                //'requireAuthorization' => true,
            ]);

            header('Content-Type: application/json');

            $id_karyawan = $this->input->get('id_karyawan');

            $hasil = $this->M_Tasklist->GetTasklistKunjungan($id_karyawan);
            if(!empty($hasil))
            {
                echo json_encode($hasil);
            }
            else
            {
                $this->api_return(
                [       'No Data'     ],        404);
            }
        }
        catch( Exception $e)
        {
            log_message( 'error', $e->getMessage( ) . ' in ' . $e->getFile() . ':' . $e->getLine() );
        }
    }
}