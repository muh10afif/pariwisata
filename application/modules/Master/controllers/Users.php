<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_users');
    }

/*=======================================
=            master pengguna            =
=======================================*/

    public function index()
    {
        if (!empty($this->userdata)) {
            $data['userdata']   = $this->userdata;
            $data['Menu']       = "Master";
            $data['Page']       = "Master Users";

            $id_kota = $this->userdata->id_kota;

            $data['dtw']        = $this->M_users->get_dtw($id_kota);
            $data['hotel']      = $this->M_users->get_hotel($id_kota);
            $data['kota']       = $this->M_users->get_kota()->result();

            $this->template->views('V_users', $data);
        }
    }

    // menampilkan user dtw
    public function json_p_dtw()
    {
        $id_kota = $this->userdata->id_kota;

        $data = $this->M_users->get_users_dtw($id_kota)->result();

        echo json_encode($data);
    }
    
    public function json_p_kota()
    {
        $data = $this->M_users->get_users_kota()->result();
        echo json_encode($data);
    }

    public function simpan_users()
    {
        $password = $this->input->post('password');
        $arr       = [     
                        'id_dtw'=> $this->input->post('dtw') ,
                        'id_hotel'=> "0" ,
                        'id_pegawai' => "0",
                        'id_kota' => "0",
                        'username'=>$this->input->post('username') ,
                        'password'=> password_hash($password, PASSWORD_DEFAULT) ,
                        //'status' => $this->input->post('status')
                      ];

        // $arr  = array(
        //     'id_dtw'=> $this->input->post('dtw') ,
        //     'id_hotel'=> "0" ,
        //     'id_pegawai' => "0",
        //     'id_kota' => "0",
        //     'username'=>$this->input->post('username') ,
        //     'password'=> password_hash($password, PASSWORD_DEFAULT) ,
        //     'status' => $this->input->post('status')
        // );

        $data = $this->M_users->simpan_users($arr);
        echo json_encode($data);
    }

    public function hapus_users()
    {
        $id = $this->input->post('id');
        $data = $this->M_users->hapus_users($id);
        echo json_encode($data);
    }

    public function edit_users()
    {
        $id = $this->input->post('id');
        $data = $this->M_users->edit_users($id);
        echo json_encode($data);
    }

    public function update_users()
    {
        $id = $this->input->post('id');
         $arr  = array(
            'id_dtw'=> $this->input->post('dtw') ,
            'username'=>$this->input->post('username') ,
            //'password'=>$this->input->post('password')  ,
            'password'=> password_hash($this->input->post('password'), PASSWORD_DEFAULT) ,
            //'status' => $this->input->post('status')
         );
         $data = $this->M_users->update_users($arr, $id);
         echo json_encode($data);
    }

    //HOTEL

    // menampilkan user data hotel
    public function json_p_hotel()
    {
        $id_kota = $this->userdata->id_kota;

        $data = $this->M_users->get_users_hotel($id_kota)->result();
        echo json_encode($data);
    }

    public function simpan_users_hotel()
    {
        $arr  = array(
            'id_hotel'=> $this->input->post('hotel') ,
            'id_pegawai'=>"0",
            'id_kota'=>"0",
            'id_dtw'=>"0",
            'foto'=>" ",
            'username'=>$this->input->post('username') ,
            'password'=> password_hash($this->input->post('password'), PASSWORD_DEFAULT) ,
            //'status' => $this->input->post('status')
        );
        $data = $this->M_users->simpan_users_hotel($arr);
        echo json_encode($data);
    }

    public function hapus_users_hotel()
    {
        $id = $this->input->post('id');
        $data = $this->M_users->hapus_users_hotel($id);
        echo json_encode($data);
    }

    public function edit_users_hotel()
    {
        $id = $this->input->post('id');
        $data = $this->M_users->edit_users_hotel($id);
        echo json_encode($data);
    }

    public function update_users_hotel()
    {
        $id = $this->input->post('id');
         $arr  = array(
            'id_hotel'=> $this->input->post('hotel') ,
            'username'=>$this->input->post('username') ,
            //'password'=>$this->input->post('password')  ,
            'password'=> password_hash($this->input->post('password'), PASSWORD_DEFAULT) ,
            //'status' => $this->input->post('status')
         );
         $data = $this->M_users->update_users($arr, $id);
         echo json_encode($data);
    }
    
    public function update_users_kota()
    {
        $id = $this->input->post('id');
         $arr  = array(
            'id_kota'=> $this->input->post('kota') ,
            'username'=>$this->input->post('username') ,
            //'password'=>$this->input->post('password')  ,
            'password'=> password_hash($this->input->post('password'), PASSWORD_DEFAULT) ,
            //'status' => $this->input->post('status')
         );
         $data = $this->M_users->update_users($arr, $id);
         echo json_encode($data);
    }

/*=====  End of master pengguna  ======*/
}
