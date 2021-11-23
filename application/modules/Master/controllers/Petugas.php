<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Petugas extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_petugas');
    }

    public function index()
    {
        if (!empty($this->userdata)) {
            $data['userdata'] = $this->userdata;
            $data['Menu'] = "Master";
            $data['Page'] = "Master Petugas";
            $this->template->views('V_petugas', $data);
        }
    }

    public function json()
    {
        $kota = $this->userdata->id_kota;
        $data = $this->M_petugas->get_petugas($kota);
        echo json_encode($data);
    }

    public function simpan()
    {   
        $user = array(
            'username'=>$this->input->post('username'),
            'password'=> $this->input->post('password'),
            'sha' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'id_kota' => $this->userdata->id_kota,
        );
       
        $arr = array(
           'nama_petugas' => $this->input->post('petugas'),
           'nik' => $this->input->post('nik'),
           'alamat' => $this->input->post('alamat'),
           'email' => $this->input->post('email'),
           'no_telp' => $this->input->post('no_telp'),
           'alamat' => $this->input->post('alamat'),
           'status' => $this->input->post('status'),
        );

        $data = $this->M_petugas->simpan($arr,$user);
        echo json_encode($data);
    }

    public function hapus()
    {
        $id = $this->input->post('id');
        $data = $this->M_petugas->hapus($id);
        echo json_encode($data);
    }

    public function edit()
    {
        $id = $this->input->post('id');
        $data = $this->M_petugas->edit($id);
        echo json_encode($data);
    }

    public function update()
    {
        $id = $this->input->post('id');
        $arr = array(
           'nama_petugas' => $this->input->post('petugas'),
           'nik' => $this->input->post('nik'),
           'alamat' => $this->input->post('alamat'),
           'email' => $this->input->post('email'),
           'no_telp' => $this->input->post('no_telp'),
           'status' => $this->input->post('status')
        );
        $data = $this->M_petugas->update($id, $arr);
        echo json_encode($data);
    }
}