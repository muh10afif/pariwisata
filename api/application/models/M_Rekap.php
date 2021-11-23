<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_Rekap extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function Rekap_Hotel_wisman($id_hotel,$periode,$id_kawasan)
    {
        try
        {
            $this->db->select('f.nama_negara, c.pengunjung_pria as pria_wisman, c.pengunjung_wanita as wanita_wisman, c.jumlah_pengunjung as jml_wisman');
            $this->db->from('hotel b');
            $this->db->join('rekap_wisman_hotel c', 'c.id_hotel = b.id_hotel', 'inner');
            $this->db->join('negara f','f.id_negara = c.id_negara', 'inner');
            $this->db->where('b.id_hotel', $id_hotel);
            $this->db->where('c.periode', $periode);
            $this->db->where('f.id_kawasan', $id_kawasan);
            $this->db->where('c.status',1);
            
            return $this->db->get()->result_array();
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return 0;
        }

        //return $ok;
    }

    function Rekap_Hotel_wisnus($id_hotel,$periode)
    {
        try
        {
            $this->db->select('f.nama_provinsi, c.pengunjung_pria as pria_wisnus, c.pengunjung_wanita as wanita_wisnus, c.jumlah_pengunjung as jml_wisnus');
            $this->db->from('hotel b');
            $this->db->join('rekap_wisnus_hotel c', 'c.id_hotel = b.id_hotel', 'inner');
            $this->db->join('provinsi f', 'f.id_provinsi = c.id_provinsi', 'inner');
            $this->db->where('b.id_hotel', $id_hotel);
            $this->db->where('c.periode', $periode);
            $this->db->where('c.status', 1);
            
            return $this->db->get()->result_array();
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return 0;
        }

        //return $ok;
    }

    function Rekap_DTW_wisman($id_dtw,$periode,$id_kawasan)
    {
        //$ok = false;
        
        try
        {
            $this->db->select('f.nama_negara, c.pengunjung_pria as pria_wisman, c.pengunjung_wanita as wanita_wisman, c.jumlah_pengunjung as jml_wisman');
            //$this->db->from('penempatan_dtw a');
            $this->db->from('dtw b');
            $this->db->join('rekap_wisman_dtw c', 'c.id_dtw = b.id_dtw', 'inner');
            $this->db->join('negara f','f.id_negara = c.id_negara', 'inner');
            $this->db->where('c.periode', $periode);
            $this->db->where('f.id_kawasan', $id_kawasan);
            $this->db->where('b.id_dtw', $id_dtw);
            $this->db->where('c.status',1);

            return $this->db->get()->result_array();
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return 0;
        }

        //return $ok;
    }

    function Rekap_DTW_wisnus($id_dtw,$periode)
    {
        //$ok = false;
        
        try
        {
            $this->db->select('f.nama_provinsi, e.pengunjung_pria as pria_wisnus, e.pengunjung_wanita as wanita_wisnus, e.jumlah_pengunjung as jml_wisnus');
            //$this->db->from('penempatan_dtw a');
            $this->db->from('dtw b');
            $this->db->join('rekap_wisnus_dtw e', 'e.id_dtw = b.id_dtw', 'inner');
            $this->db->join('provinsi f', 'f.id_provinsi = e.id_provinsi', 'inner');
            $this->db->where('e.periode', $periode);
            $this->db->where('b.id_dtw', $id_dtw);
            $this->db->where('e.status', 1);
            
            return $this->db->get()->result_array();
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return 0;
        }

        //return $ok;
    }

    function Rekap_DTWSementara_wisnus($id_dtw,$periode)
    {
        try
        {
            $this->db->select('f.nama_provinsi,f.id_provinsi, e.id_rekap_wisnus_dtw,e.pengunjung_pria, e.pengunjung_wanita, e.jumlah_pengunjung,e.status');
            //$this->db->from('penempatan_dtw a');
            $this->db->from('dtw b');
            $this->db->join('rekap_wisnus_dtw e', 'e.id_dtw = b.id_dtw', 'inner');
            $this->db->join('provinsi f', 'f.id_provinsi = e.id_provinsi', 'inner');
            $this->db->where('e.periode', $periode);
            $this->db->where('b.id_dtw', $id_dtw);
            $this->db->where('e.status', 0);
            
            return $this->db->get()->result_array();
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return 0;
        }
    }

    function Rekap_DTWSementara_wisman($id_dtw,$periode)
    {
        try
        {
            $this->db->select('f.nama_negara,f.id_negara,k.nama_kawasan, e.id_rekap_wisman_dtw,e.pengunjung_pria, e.pengunjung_wanita, e.jumlah_pengunjung,e.status');
            $this->db->from('dtw b');
            $this->db->join('rekap_wisman_dtw e', 'e.id_dtw = b.id_dtw', 'inner');
            $this->db->join('negara f', 'f.id_negara = e.id_negara', 'inner'); 
            $this->db->join('kawasan k', 'k.id_kawasan = f.id_kawasan', 'inner');
            $this->db->where('e.periode', $periode);
            $this->db->where('b.id_dtw', $id_dtw);
            $this->db->where('e.status', 0);
            
            return $this->db->get()->result_array();
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return 0;
        }
    }

    function Rekap_HotelSementara_wisnus($id_hotel,$periode)
    {
        try
        {
            $this->db->select('f.nama_provinsi,f.id_provinsi, e.id_rekap_wisnus_hotel,e.pengunjung_pria, e.pengunjung_wanita, e.jumlah_pengunjung,e.status');
            //$this->db->from('penempatan_dtw a');
            $this->db->from('hotel b');
            $this->db->join('rekap_wisnus_hotel e', 'e.id_hotel = b.id_hotel', 'inner');
            $this->db->join('provinsi f', 'f.id_provinsi = e.id_provinsi', 'inner');
            $this->db->where('e.periode', $periode);
            $this->db->where('b.id_hotel', $id_hotel);
            $this->db->where('e.status', 0);
            
            return $this->db->get()->result_array();
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return 0;
        }
    }

    function Rekap_HotelSementara_wisman($id_hotel,$periode)
    {
        try
        {
            $this->db->select('c.id_rekap_wisman_hotel,f.nama_negara, k.nama_kawasan,c.id_negara ,c.pengunjung_pria, c.pengunjung_wanita, c.jumlah_pengunjung, c.status');
            $this->db->from('hotel b');
            $this->db->join('rekap_wisman_hotel c', 'c.id_hotel = b.id_hotel', 'inner');
            $this->db->join('negara f','f.id_negara = c.id_negara', 'inner');
            $this->db->join('kawasan k', 'k.id_kawasan = f.id_kawasan', 'inner');
            
            $this->db->where('b.id_hotel', $id_hotel);
            $this->db->where('c.periode', $periode);
            $this->db->where('c.status', 0);
            
            return $this->db->get()->result_array();
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return 0;
        }
    }

    function jml_kelolaan_dtw($id_pegawai)
    {
        try
        {
            $this->db->from('penempatan_dtw');
            $this->db->where('id_pegawai', $id_pegawai);
            
            return $this->db->count_all_results();
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return 0;
        }
    }

    function jml_rkp_dtw($id_dtw)
    {
        try
        {
            $this->db->from('rekap_wisman_dtw');
            $this->db->where('id_dtw', $id_dtw);
            $this->db->where('status', 1);
            
            return $this->db->count_all_results();
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return 0;
        }
    }

    function jml_rkp_hotel($id_hotel)
    {
        try
        {
            $this->db->from('rekap_wisman_hotel');
            $this->db->where('id_hotel', $id_hotel);
            $this->db->where('status', 1);
            
            return $this->db->count_all_results();
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return 0;
        }
    }

    function total_rkp_dtw_wisman($id_kawasan,$periode,$id_dtw)
    {
        try
        {
            $this->db->select('SUM(c.jumlah_pengunjung) as jml_wisman');
            $this->db->from('dtw b');
            $this->db->join('rekap_wisman_dtw c', 'c.id_dtw = b.id_dtw', 'inner');
            $this->db->join('negara f','f.id_negara = c.id_negara', 'inner');
            $this->db->where('c.periode', $periode);
            $this->db->where('f.id_kawasan', $id_kawasan);
            $this->db->where('b.id_dtw', $id_dtw);
            $this->db->where('c.status',1);
            
            $hasil = $this->db->get()->row_array();

            return $hasil;
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return 0;
        }
    }

    function total_rkp_dtw_wisnus($id_dtw,$periode)
    {
        try
        {
            $this->db->select('SUM(e.jumlah_pengunjung) as jml_wisnus');
            $this->db->from('dtw b');
            $this->db->join('rekap_wisnus_dtw e', 'e.id_dtw = b.id_dtw', 'inner');
            $this->db->join('provinsi f', 'f.id_provinsi = e.id_provinsi', 'inner');
            $this->db->where('e.periode', $periode);
            $this->db->where('b.id_dtw', $id_dtw);
            $this->db->where('e.status', 1);
            
            $hasil = $this->db->get()->row_array();

            return $hasil;
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return 0;
        }
    }

    function total_rkp_hotel_wisman($id_kawasan,$periode,$id_hotel)
    {
        try
        {
            $this->db->select('SUM(c.jumlah_pengunjung) as jml_wisman');
            $this->db->from('hotel b');
            $this->db->join('rekap_wisman_hotel c', 'c.id_hotel = b.id_hotel', 'inner');
            $this->db->join('negara f','f.id_negara = c.id_negara', 'inner');
            $this->db->where('c.periode', $periode);
            $this->db->where('f.id_kawasan', $id_kawasan);
            $this->db->where('b.id_hotel', $id_hotel);
            $this->db->where('c.status',1);
            
            $hasil = $this->db->get()->row_array();

            return $hasil;
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return 0;
        }
    }

    function total_rkp_hotel_wisnus($id_hotel,$periode)
    {
        try
        {
            $this->db->select('SUM(e.jumlah_pengunjung) as jml_wisnus');
            $this->db->from('hotel b');
            $this->db->join('rekap_wisnus_hotel e', 'e.id_hotel = b.id_hotel', 'inner');
            $this->db->join('provinsi f', 'f.id_provinsi = e.id_provinsi', 'inner');
            $this->db->where('e.periode', $periode);
            $this->db->where('b.id_hotel', $id_hotel);
            $this->db->where('e.status',1);
            
            $hasil = $this->db->get()->row_array();

            return $hasil;
        }
        catch (Exception $e) 
        {
            return 0;
        }
    }

    function SimpanWisnusHotel($data)
    {
        $list2 = array();
        try
        {
            foreach($data as $row)
            {
                $id_hotel = $row['id_hotel'];
                $id_provinsi = $row['id_provinsi'];
                $id_kawasan = $row['id_kawasan'];
                $pria = $row['pengunjung_pria'];
                $wanita = $row['pengunjung_wanita'];
                $jml = $row['jumlah_pengunjung'];
                $provinsi = $row['id_provinsi'];
                $periode = $row['periode'];
                $add = $row['add_by'];

                array_push($list2,$id_provinsi);

                $list = array('id_hotel'=>$id_hotel,
                        'id_provinsi'=>$id_provinsi,
                        'pengunjung_pria'=>$pria,
                        'pengunjung_wanita'=>$wanita,
                        'jumlah_pengunjung'=>$jml,
                        'periode'=>$periode,
                        'add_by'=>$add,
                        'status'=>1);

                $this->db->insert('rekap_wisnus_hotel', $list);
            }
            
            // $this->db->select('*');
            // $this->db->from('provinsi');
            // $this->db->where_not_in('id_provinsi', $list2);
            // $hasil = $this->db->get()->result_array();

            // foreach($hasil as $arr)
            // {
            //     $id_prov = $arr['id_provinsi'];
            //     $jml_pria = 0;
            //     $jml_wanita = 0;
            //     $jml_tot = 0;
            //     $list = array('id_hotel'=>$id_hotel,
            //             'id_provinsi'=>$id_prov,
            //             'pengunjung_pria'=>$jml_pria,
            //             'pengunjung_wanita'=>$jml_wanita,
            //             'jumlah_pengunjung'=>$jml_tot,
            //             'periode'=>$periode,
            //             'add_by'=>$add,
            //             'status'=>1);
            //     $this->db->insert('rekap_wisnus_hotel', $list);
            // }
            return true;
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return false;
        }
    }

    function SimpanWismanHotel($data)
    {
        $list2 = array();
        try
        {
            foreach($data as $row)
            {
                $id_hotel = $row['id_hotel'];
                $id_negara = $row['id_negara'];
                $id_kawasan = $row['id_kawasan'];
                $pria = $row['pengunjung_pria'];
                $wanita = $row['pengunjung_wanita'];
                $jml = $row['jumlah_pengunjung'];
                $provinsi = $row['id_provinsi'];
                $periode = $row['periode'];
                $add = $row['add_by'];
                array_push($list2,$id_negara);
                $list = array('id_hotel'=>$id_hotel,
                            'id_negara'=>$id_negara,
                            'pengunjung_pria'=>$pria,
                            'pengunjung_wanita'=>$wanita,
                            'jumlah_pengunjung'=>$jml,
                            'periode'=>$periode,
                            'add_by'=>$add,
                            'status'=>1);

                $this->db->insert('rekap_wisman_hotel', $list);
            }
            // $this->db->select('*');
            // $this->db->from('negara');
            // $this->db->where_not_in('id_negara', $list2);
            // $hasil = $this->db->get()->result_array();

            // foreach($hasil as $arr)
            // {
            //     $id_neg = $arr['id_negara'];
            //     $jml_pria = 0;
            //     $jml_wanita = 0;
            //     $jml_tot = 0;

            //     $list = array('id_hotel'=>$id_hotel,
            //     'id_negara'=>$id_neg,
            //     'pengunjung_pria'=>$jml_pria,
            //     'pengunjung_wanita'=>$jml_wanita,
            //     'jumlah_pengunjung'=>$jml_tot,
            //     'periode'=>$periode,
            //     'add_by'=>$add,
            //     'status'=>1);

            //     $this->db->insert('rekap_wisman_hotel', $list);
            // }
            return true;
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return false;
        }
    }

    function SimpanWisnusDTWSementara($data)
    {
        $this->db->select('*');
        $this->db->from('rekap_wisnus_dtw');
        $this->db->where('status',1);
        $this->db->where('id_dtw',$data['id_dtw']);
        $this->db->where('id_provinsi',$data['id_provinsi']);
        $this->db->where('periode',$data['periode']);
        $hasil = $this->db->get()->num_rows();
        if($hasil != 0)
        {
            return "Data Sudah Ada";
        }
        else
        {
            $id_dtw = $data['id_dtw'];
            $id_provinsi = $data['id_provinsi'];
            $id_kawasan = $data['id_kawasan'];
            $pria = $data['pengunjung_pria'];
            $wanita = $data['pengunjung_wanita'];
            $jml = $data['jumlah_pengunjung'];
            $provinsi = $data['id_provinsi'];
            $periode = $data['periode'];
            $add = $data['add_by'];

            $list = array( 'id_dtw'=>$id_dtw,
                            'id_provinsi'=>$id_provinsi,
                            'pengunjung_pria'=>$pria,
                            'pengunjung_wanita'=>$wanita,
                            'jumlah_pengunjung'=>$jml,
                            'periode'=>$periode,
                            'add_by'=>$add,
                            'status'=>0);

            $this->db->insert('rekap_wisnus_dtw', $list);
        }
    }

    function SimpanWismanDTWSementara($data)
    {
        $this->db->select('*');
        $this->db->from('rekap_wisman_dtw');
        $this->db->where('status',1);
        $this->db->where('id_dtw',$data['id_dtw']);
        $this->db->where('id_negara',$data['id_negara']);
        $this->db->where('periode',$data['periode']);
        $hasil = $this->db->get()->num_rows();
        if($hasil != 0)
        {
            return "Data Sudah Ada";
        }
        else
        {
            $id_dtw = $data['id_dtw'];
            $id_negara = $data['id_negara'];
            $pria = $data['pengunjung_pria'];
            $wanita = $data['pengunjung_wanita'];
            $jml = $data['jumlah_pengunjung'];
            $periode = $data['periode'];
            $add = $data['add_by'];

            $list = array( 'id_dtw'=>$id_dtw,
                            'id_negara'=>$id_negara,
                            'pengunjung_pria'=>$pria,
                            'pengunjung_wanita'=>$wanita,
                            'jumlah_pengunjung'=>$jml,
                            'periode'=>$periode,
                            'add_by'=>$add,
                            'status'=>0);

            $this->db->insert('rekap_wisman_dtw', $list);
        }
    }

    function SimpanWisnusHotelSementara($data)
    {
        $this->db->select('*');
        $this->db->from('rekap_wisnus_hotel');
        $this->db->where('status',1);
        $this->db->where('id_hotel',$data['id_hotel']);
        $this->db->where('id_provinsi',$data['id_provinsi']);
        $this->db->where('periode',$data['periode']);
        $hasil = $this->db->get()->num_rows();
        if($hasil != 0)
        {
            return "Data Sudah Ada";
        }
        else
        {
            $id_hotel = $data['id_hotel'];
            $id_provinsi = $data['id_provinsi'];
            $pria = $data['pengunjung_pria'];
            $wanita = $data['pengunjung_wanita'];
            $jml = $data['jumlah_pengunjung'];
            $provinsi = $data['id_provinsi'];
            $periode = $data['periode'];
            $add = $data['add_by'];

            $list = array(  'id_hotel'=>$id_hotel,
                            'id_provinsi'=>$id_provinsi,
                            'pengunjung_pria'=>$pria,
                            'pengunjung_wanita'=>$wanita,
                            'jumlah_pengunjung'=>$jml,
                            'periode'=>$periode,
                            'add_by'=>$add,
                            'status'=>0);

            $this->db->insert('rekap_wisnus_hotel', $list);
        }
    }

    function SimpanWismanHotelSementara($data)
    {
        $this->db->select('*');
        $this->db->from('rekap_wisman_hotel');
        $this->db->where('status',1);
        $this->db->where('id_hotel',$data['id_hotel']);
        $this->db->where('id_negara',$data['id_negara']);
        $this->db->where('periode',$data['periode']);
        $hasil = $this->db->get()->num_rows();
        if($hasil != 0)
        {
            return "Data Sudah Ada";
        }
        else
        {
            $id_hotel = $data['id_hotel'];
            $id_negara = $data['id_negara'];
            $pria = $data['pengunjung_pria'];
            $wanita = $data['pengunjung_wanita'];
            $jml = $data['jumlah_pengunjung'];
            $periode = $data['periode'];
            $add = $data['add_by'];

            $list = array(  'id_hotel'=>$id_hotel,
                            'id_negara'=>$id_negara,
                            'pengunjung_pria'=>$pria,
                            'pengunjung_wanita'=>$wanita,
                            'jumlah_pengunjung'=>$jml,
                            'periode'=>$periode,
                            'add_by'=>$add,
                            'status'=>0);

            $this->db->insert('rekap_wisman_hotel', $list);
        }
    }

    function SimpanWisnusDTW($data)
    {
        $list2 = array();
        try
        {
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

                array_push($list2,$id_provinsi);

                $list = array('id_dtw'=>$id_dtw,
                        'id_provinsi'=>$id_provinsi,
                        'pengunjung_pria'=>$pria,
                        'pengunjung_wanita'=>$wanita,
                        'jumlah_pengunjung'=>$jml,
                        'periode'=>$periode,
                        'add_by'=>$add,
                        'status'=>1);
                $this->db->insert('rekap_wisnus_dtw', $list);
            }

            // $this->db->select('*');
            // $this->db->from('provinsi');
            // $this->db->where_not_in('id_provinsi', $list2);
            // $hasil = $this->db->get()->result_array();

            // foreach($hasil as $arr)
            // {
            //     $id_prov = $arr['id_provinsi'];
            //     $jml_pria = 0;
            //     $jml_wanita = 0;
            //     $jml_tot = 0;
            //     $list = array(  
            //                     'id_dtw'=>$id_dtw,
            //                     'id_provinsi'=>$id_prov,
            //                     'pengunjung_pria'=>$jml_pria,
            //                     'pengunjung_wanita'=>$jml_wanita,
            //                     'jumlah_pengunjung'=>$jml_tot,
            //                     'periode'=>$periode,
            //                     'add_by'=>$add,
            //                     'status'=>1
            //                 );
            //     $this->db->insert('rekap_wisnus_dtw', $list);
            // }
            return true;
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return false;
        }
    }

    function SimpanWismanDTW($data)
    {
        $list2 = array();
        try
        {
            foreach($data as $row)
            {
                $id_dtw = $row['id_dtw'];
                $id_negara = $row['id_negara'];
                $id_kawasan = $row['id_kawasan'];
                $pria = $row['pengunjung_pria'];
                $wanita = $row['pengunjung_wanita'];
                $jml = $row['jumlah_pengunjung'];
                $provinsi = $row['id_provinsi'];
                $periode = $row['periode'];
                $add = $row['add_by'];
                
                array_push($list2,$id_negara);

                $list = array('id_dtw'=>$id_dtw,
                        'id_negara'=>$id_negara,
                        'pengunjung_pria'=>$pria,
                        'pengunjung_wanita'=>$wanita,
                        'jumlah_pengunjung'=>$jml,
                        'periode'=>$periode,
                        'add_by'=>$add,
                        'status'=>1);

                $this->db->insert('rekap_wisman_dtw', $list);
            }
            // $this->db->select('*');
            // $this->db->from('negara');
            // $this->db->where_not_in('id_negara', $list2);
            // $hasil = $this->db->get()->result_array();

            // foreach($hasil as $arr)
            // {
            //     $id_neg = $arr['id_negara'];
            //     $jml_pria = 0;
            //     $jml_wanita = 0;
            //     $jml_tot = 0;

            //     $list = array('id_dtw'=>$id_dtw,
            //     'id_negara'=>$id_neg,
            //     'pengunjung_pria'=>$jml_pria,
            //     'pengunjung_wanita'=>$jml_wanita,
            //     'jumlah_pengunjung'=>$jml_tot,
            //     'periode'=>$periode,
            //     'add_by'=>$add,
            //     'status'=>1);

            //     $this->db->insert('rekap_wisman_dtw', $list);
            // }
            return true;
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return false;
        }
    }

    function jml_kelolaan_hotel($id_pegawai)
    {
        try
        {
            $this->db->from('penempatan_hotel');
            $this->db->where('id_pegawai', $id_pegawai);
            
            return $this->db->count_all_results();
        }
        catch (Exception $e) 
        {
            //$ok = false;
            return 0;
        }
    }
}