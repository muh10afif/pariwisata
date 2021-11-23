<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/API_Controller.php';
class C_Spinner extends API_Controller
{
	function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('M_Spinner');
        $this->load->database();
    }


    public function GetProvinsi()
    {
        try
        {
            $user_data = $this->_apiConfig([
                'methods' => ['POST'],
                //'requireAuthorization' => true,
            ]);

            header('Content-Type: application/json');
            $data = json_decode(file_get_contents('php://input'), true);
            //$id_provinsi = $this->input->get('id_provinsi');
            
            $hasil = $this->M_Spinner->GetProvinsi($data);
            // echo json_encode($data);
            // exit();
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

    public function GetKawasan()
    {
        try
        {
            $user_data = $this->_apiConfig([
                'methods' => ['GET'],
                //'requireAuthorization' => true,
            ]);

            header('Content-Type: application/json');
            
            $hasil = $this->M_Spinner->GetKawasan();
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

    public function GetNegara()
    {
        try
        {
            $user_data = $this->_apiConfig([
                'methods' => ['GET'],
                //'requireAuthorization' => true,
            ]);

            header('Content-Type: application/json');
            
            $kawasan = $this->input->get('id_kawasan');

            $hasil = $this->M_Spinner->GetNegara($kawasan);
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