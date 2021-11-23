<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_dashboard extends CI_Model {

	// 02-01-2020

		public function get_tot_dtw($jns, $level, $id_dtw, $id_kota, $id_pegawai, $tgl_awal, $tgl_akhir)
		{
			$this->db->select('sum(j.jumlah_pengunjung) as total');
			$this->db->from("$jns as j");
			$this->db->join('dtw', 'dtw.id_dtw = j.id_dtw', 'inner');
			$this->db->join('kota', 'kota.id_kota = dtw.id_kota', 'inner');
			$this->db->where('j.status', 1);
			$this->db->where('kota.id_provinsi', 35);

			if ($level == 'petugas') {
				$this->db->join('penempatan_dtw as p', 'p.id_dtw = j.id_dtw', 'inner');
				$this->db->where('p.id_pegawai', $id_pegawai);
				$this->db->where('p.status', 1);
			}
			
			if ($level == 'kota') {
				$this->db->where('dtw.id_kota', $id_kota);
			}
			
			if ($id_dtw != 0) {
				$this->db->where('j.id_dtw', $id_dtw);
			}

			$this->db->where("DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'");
		
			return $this->db->get();
		}
		
		public function get_tot_hotel($jns, $level, $id_hotel, $id_kota, $id_pegawai, $tgl_awal, $tgl_akhir)
		{

			$this->db->select('sum(j.jumlah_pengunjung) as total');
			$this->db->from("$jns as j");
			$this->db->join('hotel', 'hotel.id_hotel = j.id_hotel', 'inner');
			$this->db->join('kota', 'kota.id_kota = hotel.id_kota', 'inner');
			$this->db->where('j.status', 1);
			$this->db->where('kota.id_provinsi', 35);

			if ($level == 'petugas') {
				$this->db->join('penempatan_hotel as p', 'p.id_hotel = j.id_hotel', 'inner');
				$this->db->where('p.id_pegawai', $id_pegawai);
				$this->db->where('p.status', 1);
			}
			
			if ($level == 'kota') {
				$this->db->where('hotel.id_kota', $id_kota);
			}

			if ($id_hotel != 0) {
				$this->db->where('j.id_hotel', $id_hotel);
			}

			
			$this->db->where("DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'");
			
			return $this->db->get();
		}

	// akhir 02-01-2020

	// 25-02-2020

		// level provinsi
			// untuk diagram dtw

				public function get_total_dtw($tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('kota')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("k.id_kota, k.nama_kota,COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as t ON t.id_dtw = j.id_dtw WHERE t.id_kota = k.id_kota and j.status = 1 $bln_periode),0) as jumlah_wisnus, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j JOIN dtw as t ON t.id_dtw = j.id_dtw WHERE t.id_kota = k.id_kota and j.status = 1 $bln_periode),0) as jumlah_wisman, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as t ON t.id_dtw = j.id_dtw WHERE t.id_kota = k.id_kota and j.status = 1 $bln_periode),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j JOIN dtw as t ON t.id_dtw = j.id_dtw WHERE t.id_kota = k.id_kota and j.status = 1 $bln_periode),0) as jumlah");
					$this->db->from('kota as k');
					$this->db->where('k.id_provinsi', 35);
					$this->db->order_by('jumlah', 'desc');

					if ($aksi == 'top') {
						$this->db->limit(10);
					
						$query = $this->db->get();

						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);

						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram dtw

			// untuk diagram dtw wisnus

				public function total_dtw_wisnus($tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('provinsi')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("p.id_provinsi, p.nama_provinsi,COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_provinsi = p.id_provinsi and k.id_provinsi = 35 and j.status = 1 $bln_periode),0) as jumlah_wisnus");
					$this->db->from('provinsi as p');
					$this->db->order_by('jumlah_wisnus', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);
					
						$query = $this->db->get();

						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);

						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram dtw wisnus

			// untuk diagram dtw wisman

				public function total_dtw_wisman($tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('negara')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("p.id_negara, p.nama_negara,COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisman_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE j.id_negara = p.id_negara and k.id_provinsi = 35 and j.status = 1 $bln_periode),0) as jumlah_wisman");
					$this->db->from('negara as p');
					$this->db->order_by('jumlah_wisman', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);
					
						$query = $this->db->get();

						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);

						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram dtw wisman

			// untuk diagram hotel

				public function get_total_hotel($tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('kota')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("k.id_kota, k.nama_kota, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as t ON t.id_hotel = j.id_hotel WHERE t.id_kota = k.id_kota and j.status = 1 $bln_periode),0) as jumlah_wisnus, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j JOIN hotel as t ON t.id_hotel = j.id_hotel WHERE t.id_kota = k.id_kota and j.status = 1 $bln_periode),0) as jumlah_wisman, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as t ON t.id_hotel = j.id_hotel WHERE t.id_kota = k.id_kota and j.status = 1 $bln_periode),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j JOIN hotel as t ON t.id_hotel = j.id_hotel WHERE t.id_kota = k.id_kota and j.status = 1 $bln_periode),0) as jumlah");
					$this->db->from('kota as k');
					$this->db->where('k.id_provinsi', 35);
					$this->db->order_by('jumlah', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);
					
						$query = $this->db->get();

						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);

						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram hotel

			// untuk diagram hotel wisnus

				public function total_hotel_wisnus($tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('provinsi')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("p.id_provinsi, p.nama_provinsi,COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_provinsi = p.id_provinsi and j.status = 1 $bln_periode),0) as jumlah_wisnus");
					$this->db->from('provinsi as p');
					$this->db->order_by('jumlah_wisnus', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);
					
						$query = $this->db->get();

						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);

						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram hotel wisnus

			// untuk diagram hotel wisman

				public function total_hotel_wisman($tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('negara')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("p.id_negara, p.nama_negara,COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_negara = p.id_negara and j.status = 1 $bln_periode),0) as jumlah_wisman");
					$this->db->from('negara as p');
					$this->db->order_by('jumlah_wisman', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);
					
						$query = $this->db->get();

						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);

						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram dtw wisman
		// Akhir level provinsi

		
		// level kota

			// untuk diagram dtw kota

				public function total_dtw_kota($id_kota, $tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('dtw')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("k.id_dtw, k.nama_dtw, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j WHERE j.id_dtw = k.id_dtw and j.status = 1 $bln_periode),0) as jumlah_wisnus, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j WHERE j.id_dtw = k.id_dtw and j.status = 1 $bln_periode),0) as jumlah_wisman, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j WHERE j.id_dtw = k.id_dtw and j.status = 1 $bln_periode),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j WHERE j.id_dtw = k.id_dtw and j.status = 1 $bln_periode),0) as jumlah");
					$this->db->from('dtw as k');
					$this->db->join('kota as t', 't.id_kota = k.id_kota', 'inner');
					$this->db->where('k.id_kota', $id_kota);
					$this->db->where('t.id_provinsi', 35);
					$this->db->order_by('jumlah', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);
					
						$query = $this->db->get();
					
						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);
					
						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram dtw kota

			// untuk diagram dtw kota wisnus

				public function total_dtw_kota_wisnus($id_kota, $tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('provinsi')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("p.id_provinsi, p.nama_provinsi, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and d.id_kota = '$id_kota' and j.id_provinsi = p.id_provinsi and j.status = 1 $bln_periode),0) as jumlah_wisnus");
					$this->db->from('provinsi as p');
					$this->db->order_by('jumlah_wisnus', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);
					
						$query = $this->db->get();
					
						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);
					
						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram dtw kota wisnus

			// untuk diagram dtw kota wisman

				public function total_dtw_kota_wisman($id_kota, $tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('negara')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("p.id_negara, p.nama_negara,COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and d.id_kota = '$id_kota' and j.id_negara = p.id_negara and j.status = 1 $bln_periode),0) as jumlah_wisman");
					$this->db->from('negara as p');
					$this->db->order_by('jumlah_wisman', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);
					
						$query = $this->db->get();
					
						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);
					
						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram dtw kota wisman

			// untuk diagram hotel kota

				public function total_hotel_kota($id_kota, $tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('hotel')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("k.id_hotel, k.nama_hotel, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j WHERE j.id_hotel = k.id_hotel and j.status = 1 $bln_periode),0) as jumlah_wisnus, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j WHERE j.id_hotel = k.id_hotel and j.status = 1 $bln_periode),0) as jumlah_wisman, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j WHERE j.id_hotel = k.id_hotel and j.status = 1 $bln_periode),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j WHERE j.id_hotel = k.id_hotel and j.status = 1 $bln_periode),0) as jumlah");
					$this->db->from('hotel as k');
					$this->db->join('kota as t', 't.id_kota = k.id_kota', 'inner');
					$this->db->where('k.id_kota', $id_kota);
					$this->db->where('t.id_provinsi', 35);
					
					$this->db->order_by('jumlah', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);
					
						$query = $this->db->get();
					
						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);
					
						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram hotel kota

			// untuk diagram hotel kota wisnus

				public function total_hotel_kota_wisnus($id_kota, $tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('provinsi')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("p.id_provinsi, p.nama_provinsi, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and d.id_kota = '$id_kota' and j.id_provinsi = p.id_provinsi and j.status = 1 $bln_periode),0) as jumlah_wisnus");
					$this->db->from('provinsi as p');
					$this->db->order_by('jumlah_wisnus', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);
					
						$query = $this->db->get();
					
						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);
					
						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram hotel kota wisnus

			// untuk diagram hotel kota wisman

				public function total_hotel_kota_wisman($id_kota, $tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('negara')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("p.id_negara, p.nama_negara,COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and d.id_kota = '$id_kota' and j.id_negara = p.id_negara and j.status = 1 $bln_periode),0) as jumlah_wisman");
					$this->db->from('negara as p');
					$this->db->order_by('jumlah_wisman', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);
					
						$query = $this->db->get();
					
						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);
					
						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram hotel kota wisman

		// Akhir level kota

		// level petugas

			// untuk diagram dtw petugas

				public function total_dtw_petugas($id_petugas, $tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('kota')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("k.id_dtw, k.nama_dtw, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j WHERE j.id_dtw = k.id_dtw and j.status = 1 $bln_periode),0) as jumlah_wisnus, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j WHERE j.id_dtw = k.id_dtw and j.status = 1 $bln_periode),0) as jumlah_wisman, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j WHERE j.id_dtw = k.id_dtw and j.status = 1 $bln_periode),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j WHERE j.id_dtw = k.id_dtw and j.status = 1 $bln_periode),0) as jumlah");
					$this->db->from('dtw as k');
					$this->db->join('penempatan_dtw as p', 'p.id_dtw = k.id_dtw', 'inner');
					$this->db->join('kota as t', 't.id_kota = k.id_kota', 'inner');
					$this->db->where('t.id_provinsi', 35);
					$this->db->where('p.id_pegawai', $id_petugas);
					$this->db->order_by('jumlah', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);

						$query = $this->db->get();

						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);

						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram dtw petugas

			// untuk diagram dtw petugas wisnus

				public function total_dtw_petugas_wisnus($id_petugas, $tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('kota')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("p.id_provinsi, p.nama_provinsi, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN penempatan_dtw as pd ON pd.id_dtw = d.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and pd.id_pegawai = '$id_petugas' and j.id_provinsi = p.id_provinsi and j.status = 1 $bln_periode),0) as jumlah_wisnus");
					$this->db->from('provinsi as p');
					$this->db->order_by('jumlah_wisnus', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);

						$query = $this->db->get();

						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);

						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram dtw petugas wisnus

			// untuk diagram dtw petugas wisman

				public function total_dtw_petugas_wisman($id_petugas, $tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('kota')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("p.id_negara, p.nama_negara,COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN penempatan_dtw as pd ON pd.id_dtw = d.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and pd.id_pegawai = '$id_petugas' and j.id_negara = p.id_negara and j.status = 1 $bln_periode),0) as jumlah_wisman");
					$this->db->from('negara as p');
					$this->db->order_by('jumlah_wisman', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);

						$query = $this->db->get();

						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);

						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram dtw petugas wisman

			// untuk diagram hotel petugas

				public function total_hotel_petugas($id_petugas, $tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('kota')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("k.id_hotel, k.nama_hotel, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j WHERE j.id_hotel = k.id_hotel and j.status = 1 $bln_periode),0) as jumlah_wisnus, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j WHERE j.id_hotel = k.id_hotel and j.status = 1 $bln_periode),0) as jumlah_wisman, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j WHERE j.id_hotel = k.id_hotel and j.status = 1 $bln_periode),0) + COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j WHERE j.id_hotel = k.id_hotel and j.status = 1 $bln_periode),0) as jumlah");
					$this->db->from('hotel as k');
					$this->db->join('penempatan_hotel as p', 'p.id_hotel = k.id_hotel', 'inner');
					$this->db->join('kota as t', 't.id_kota = k.id_kota', 'inner');
					$this->db->where('t.id_provinsi', 35);
					$this->db->where('p.id_pegawai', $id_petugas);
					$this->db->order_by('jumlah', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);

						$query = $this->db->get();

						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);

						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram hotel petugas

			// untuk diagram hotel petugas wisnus

				public function total_hotel_petugas_wisnus($id_petugas, $tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('kota')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";	

					$this->db->select("p.id_provinsi, p.nama_provinsi, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN penempatan_hotel as pd ON pd.id_hotel = d.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and pd.id_pegawai = '$id_petugas' and j.id_provinsi = p.id_provinsi and j.status = 1 $bln_periode),0) as jumlah_wisnus");
					$this->db->from('provinsi as p');
					$this->db->order_by('jumlah_wisnus', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);

						$query = $this->db->get();

						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);

						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram hotel petugas wisnus

			// untuk diagram hotel petugas wisman

				public function total_hotel_petugas_wisman($id_petugas, $tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('kota')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("p.id_negara, p.nama_negara,COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN penempatan_hotel as pd ON pd.id_hotel = d.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and pd.id_pegawai = '$id_petugas' and j.id_negara = p.id_negara and j.status = 1 $bln_periode),0) as jumlah_wisman");
					$this->db->from('negara as p');
					$this->db->order_by('jumlah_wisman', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);

						$query = $this->db->get();

						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);

						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram hotel petugas wisman

		// Akhir level petugas

		// level dtw

			// untuk diagram dtw level wisnus

				public function total_dtw_level_wisnus($id_dtw, $tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('kota')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("p.id_provinsi, p.nama_provinsi, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_dtw = '$id_dtw' and j.id_provinsi = p.id_provinsi and j.status = 1 $bln_periode),0) as jumlah_wisnus");
					$this->db->from('provinsi as p');
					$this->db->order_by('jumlah_wisnus', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);

						$query = $this->db->get();

						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);

						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram dtw level wisnus

			// untuk diagram dtw kota wisman

				public function total_dtw_level_wisman($id_dtw, $tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('kota')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("p.id_negara, p.nama_negara, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_dtw as j JOIN dtw as d ON d.id_dtw = j.id_dtw JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_dtw = '$id_dtw' and j.id_negara = p.id_negara and j.status = 1 $bln_periode),0) as jumlah_wisman");
					$this->db->from('negara as p');
					$this->db->order_by('jumlah_wisman', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);

						$query = $this->db->get();

						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);

						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram dtw level wisman

		// akhir level dtw

		// level hotel

			// untuk diagram hotel level wisnus

				public function total_hotel_level_wisnus($id_hotel, $tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('kota')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("p.id_provinsi, p.nama_provinsi, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisnus FROM rekap_wisnus_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_hotel = '$id_hotel' and j.id_provinsi = p.id_provinsi and j.status = 1 $bln_periode),0) as jumlah_wisnus");
					$this->db->from('provinsi as p');
					$this->db->order_by('jumlah_wisnus', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);

						$query = $this->db->get();

						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);

						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram hotel level wisnus

			// untuk diagram hotel kota wisman

				public function total_hotel_level_wisman($id_hotel, $tgl_awal, $tgl_akhir, $aksi)
				{
					$jml = $this->db->get('kota')->num_rows();

					$bln_periode = "and DATE_FORMAT(STR_TO_DATE(j.periode,'%d-%M-%Y'), '%Y-%m-%d') BETWEEN '$tgl_awal' and '$tgl_akhir'";

					$this->db->select("p.id_negara, p.nama_negara, COALESCE((SELECT sum(j.jumlah_pengunjung) as tot_wisman FROM rekap_wisman_hotel as j JOIN hotel as d ON d.id_hotel = j.id_hotel JOIN kota as k ON k.id_kota = d.id_kota WHERE k.id_provinsi = 35 and j.id_hotel = '$id_hotel' and j.id_negara = p.id_negara and j.status = 1 $bln_periode),0) as jumlah_wisman");
					$this->db->from('negara as p');
					$this->db->order_by('jumlah_wisman', 'desc');
					if ($aksi == 'top') {
						$this->db->limit(10);

						$query = $this->db->get();

						if($query->num_rows() > 0){
							foreach($query->result() as $data){
								$hasil[] = $data;
							}
							return $hasil;
						}
					} else {
						$this->db->limit($jml, 10);

						return $this->db->get();
						
					}
				}

			// Akhir untuk diagram hotel level wisman

		// Akhir level hotel

	// Akhir 25-02-2020

public function get_dsb_wisnus_provinsi()
{
	$this->db->select('SUM(rwis.jumlah_pengunjung) as total_wisnus');
	$this->db->from('dtw');
	$this->db->join('rekap_wisnus_dtw as rwis', 'rwis.id_dtw = dtw.id_dtw', 'left');
	return $this->db->get()->row();
}

public function get_dsb_wisman_provinsi()
{
	$this->db->select('SUM(rwis.jumlah_pengunjung) as total_wisman');
	$this->db->from('dtw');
	$this->db->join('rekap_wisman_dtw as rwis', 'rwis.id_dtw = dtw.id_dtw', 'left');
	return $this->db->get()->row();
}

public function get_hotel_wisman_provinsi()
{
	$this->db->select('SUM(rwis.jumlah_pengunjung) as total_wisman');
	$this->db->from('hotel');
	$this->db->join('rekap_wisman_hotel as rwis', 'rwis.id_hotel= hotel.id_hotel', 'left');
	return $this->db->get()->row();
}

public function get_hotel_wisnus_provinsi()
{
	$this->db->select('SUM(rwis.jumlah_pengunjung) as total_wisnus');
	$this->db->from('hotel');
	$this->db->join('rekap_wisnus_hotel as rwis', 'rwis.id_hotel= hotel.id_hotel', 'left');
	return $this->db->get()->row();
}

public function get_dsb_wisnus_kota($id_kota)
{
	$this->db->select('SUM(rwis.jumlah_pengunjung) as total_wisnus');
	$this->db->from('dtw');
	$this->db->join('rekap_wisnus_dtw as rwis', 'rwis.id_dtw = dtw.id_dtw', 'left');
	$this->db->where('dtw.id_kota', $id_kota);
	
	return $this->db->get()->row();
}

public function get_dsb_wisman_kota($id_kota)
{
	$this->db->select('SUM(rwis.jumlah_pengunjung) as total_wisman');
	$this->db->from('dtw');
	$this->db->join('rekap_wisman_dtw as rwis', 'rwis.id_dtw = dtw.id_dtw', 'left');
	$this->db->where('dtw.id_kota', $id_kota);
	
	return $this->db->get()->row();
}

public function get_dsb_wisnus_dtw($id_dtw)
{
	$this->db->select('SUM(rwis.jumlah_pengunjung) as total_wisnus');
	$this->db->from('dtw');
	$this->db->join('rekap_wisnus_dtw as rwis', 'rwis.id_dtw = dtw.id_dtw', 'left');
	$this->db->where('dtw.id_dtw', $id_dtw);
	
	return $this->db->get()->row();
}

public function get_dsb_wisman_dtw($id_dtw)
{
	$this->db->select('SUM(rwis.jumlah_pengunjung) as total_wisman');
	$this->db->from('dtw');
	$this->db->join('rekap_wisman_dtw as rwis', 'rwis.id_dtw = dtw.id_dtw', 'left');
	$this->db->where('dtw.id_dtw', $id_dtw);
	
	return $this->db->get()->row();
}

public function get_hotel_wisman_kota($id_kota)
{
	$this->db->select('SUM(rwis.jumlah_pengunjung) as total_wisman');
	$this->db->from('hotel');
	$this->db->join('rekap_wisman_hotel as rwis', 'rwis.id_hotel= hotel.id_hotel', 'left');
	$this->db->where('hotel.id_kota', $id_kota);
	
	return $this->db->get()->row();
}

public function get_hotel_wisnus_kota($id_kota)
{
	$this->db->select('SUM(rwis.jumlah_pengunjung) as total_wisnus');
	$this->db->from('hotel');
	$this->db->join('rekap_wisnus_hotel as rwis', 'rwis.id_hotel= hotel.id_hotel', 'left');
	$this->db->where('hotel.id_kota', $id_kota);
	
	return $this->db->get()->row();
}

public function get_dsb_wisnus_petugas($id_pegawai)
{
	$this->db->select('SUM(rwis.jumlah_pengunjung) as total_wisnus');
	$this->db->from('dtw');
	$this->db->join('rekap_wisnus_dtw as rwis', 'rwis.id_dtw = dtw.id_dtw', 'left');
	$this->db->join('penempatan_dtw', 'penempatan_dtw.id_dtw = penempatan_dtw.id_dtw', 'inner');
	$this->db->where('penempatan_dtw.id_pegawai', $id_pegawai);
	
	return $this->db->get()->row();
}

public function get_dsb_wisman_petugas($id_pegawai)
{
	$this->db->select('SUM(rwis.jumlah_pengunjung) as total_wisman');
	$this->db->from('dtw');
	$this->db->join('rekap_wisman_dtw as rwis', 'rwis.id_dtw = dtw.id_dtw', 'left');
	$this->db->join('penempatan_dtw', 'penempatan_dtw.id_dtw = penempatan_dtw.id_dtw', 'inner');
	$this->db->where('penempatan_dtw.id_pegawai', $id_pegawai);
	
	return $this->db->get()->row();
}

public function get_hotel_wisman_petugas($id_pegawai)
{
	$this->db->select('SUM(rwis.jumlah_pengunjung) as total_wisman');
	$this->db->from('hotel');
	$this->db->join('rekap_wisman_hotel as rwis', 'rwis.id_hotel= hotel.id_hotel', 'left');
	$this->db->join('penempatan_dtw', 'penempatan_dtw.id_dtw = penempatan_dtw.id_dtw', 'inner');
	$this->db->where('penempatan_dtw.id_pegawai', $id_pegawai);
	
	return $this->db->get()->row();
}

public function get_hotel_wisnus_petugas($id_pegawai)
{
	$this->db->select('SUM(rwis.jumlah_pengunjung) as total_wisnus');
	$this->db->from('hotel');
	$this->db->join('rekap_wisnus_hotel as rwis', 'rwis.id_hotel= hotel.id_hotel', 'left');
	$this->db->join('penempatan_dtw', 'penempatan_dtw.id_dtw = penempatan_dtw.id_dtw', 'inner');
	$this->db->where('penempatan_dtw.id_pegawai', $id_pegawai);
	return $this->db->get()->row();
}

public function get_hotel_wisman_hotel($id_pegawai)
{
	$this->db->select('SUM(rwis.jumlah_pengunjung) as total_wisman');
	$this->db->from('hotel');
	$this->db->join('rekap_wisman_hotel as rwis', 'rwis.id_hotel= hotel.id_hotel', 'left');
	$this->db->where('hotel.id_hotel', $id_pegawai);
	
	return $this->db->get()->row();
}

public function get_hotel_wisnus_hotel($id_pegawai)
{
	$this->db->select('SUM(rwis.jumlah_pengunjung) as total_wisnus');
	$this->db->from('hotel');
	$this->db->join('rekap_wisnus_hotel as rwis', 'rwis.id_hotel= hotel.id_hotel', 'left');
	$this->db->where('hotel.id_hotel', $id_pegawai);
	return $this->db->get()->row();
}

public function nilai_p()
{	
	$q = $this->db->query("SELECT AVG(nilai_1) as n1,AVG(nilai_2) as n2,AVG(nilai_3) as n3,AVG(nilai_4) as n4 from nilai where id_ki ='1' AND id_mapel ='1'")->row();
	$q2 = $this->db->query("SELECT AVG(nilai_1) as n1,AVG(nilai_2) as n2,AVG(nilai_3) as n3,AVG(nilai_4) as n4 from nilai where id_ki ='1' AND id_mapel ='2'")->row();
	$q3 = $this->db->query("SELECT AVG(nilai_1) as n1,AVG(nilai_2) as n2,AVG(nilai_3) as n3,AVG(nilai_4) as n4 from nilai where id_ki ='1' AND id_mapel ='3'")->row();
	$q4 = $this->db->query("SELECT AVG(nilai_1) as n1,AVG(nilai_2) as n2,AVG(nilai_3) as n3,AVG(nilai_4) as n4 from nilai where id_ki ='1' AND id_mapel ='4'")->row();
	$avg = ($q->n1+$q->n2+$q->n3+$q->n4)/4;
	$avg2 = ($q2->n1+$q2->n2+$q2->n3+$q2->n4)/4;
	$avg3 = ($q3->n1+$q3->n2+$q3->n3+$q3->n4)/4;
	$avg4 = ($q4->n1+$q4->n2+$q4->n3+$q4->n4)/4;
	$rata = array($avg,$avg2,$avg3,$avg4);

	return $rata;
}

public function nilai_k()
{	
	$q = $this->db->query("SELECT AVG(nilai_1) as n1,AVG(nilai_2) as n2,AVG(nilai_3) as n3,AVG(nilai_4) as n4 from nilai where id_ki ='2' AND id_mapel ='1'")->row();
	$q2 = $this->db->query("SELECT AVG(nilai_1) as n1,AVG(nilai_2) as n2,AVG(nilai_3) as n3,AVG(nilai_4) as n4 from nilai where id_ki ='2' AND id_mapel ='2'")->row();
	$q3 = $this->db->query("SELECT AVG(nilai_1) as n1,AVG(nilai_2) as n2,AVG(nilai_3) as n3,AVG(nilai_4) as n4 from nilai where id_ki ='2' AND id_mapel ='3'")->row();
	$q4 = $this->db->query("SELECT AVG(nilai_1) as n1,AVG(nilai_2) as n2,AVG(nilai_3) as n3,AVG(nilai_4) as n4 from nilai where id_ki ='2' AND id_mapel ='4'")->row();
	$avg = ($q->n1+$q->n2+$q->n3+$q->n4)/4;
	$avg2 = ($q2->n1+$q2->n2+$q2->n3+$q2->n4)/4;
	$avg3 = ($q3->n1+$q3->n2+$q3->n3+$q3->n4)/4;
	$avg4 = ($q4->n1+$q4->n2+$q4->n3+$q4->n4)/4;
	$rata = array($avg,$avg2,$avg3,$avg4);

	return $rata;
}
public function sopan()
{
	$pb = $this->db->query("select kesopanan from siswa LEFT JOIN sikap On sikap.id_siswa = siswa.id where kesopanan = 1")->num_rows();
	$b = $this->db->query("select * from siswa")->num_rows() - $pb;
	$data = array($b,$pb);

	return $data;
}

public function tg_jawab()
{
	$pb = $this->db->query("select tg_jawab from siswa LEFT JOIN sikap On sikap.id_siswa = siswa.id where tg_jawab = 1")->num_rows();
	$b = $this->db->query("select * from siswa")->num_rows() - $pb;

	$data = array($b,$pb);

	return $data;
}

public function doa()
{	
	$pb = $this->db->query("select doa from siswa LEFT JOIN sikap On sikap.id_siswa = siswa.id where doa = 1")->num_rows();
	$b = $this->db->query("select * from siswa")->num_rows() - $pb;
	
	$data = array($b,$pb);

	return $data;
}

}

/* End of file M_auth.php */
/* Location: ./application/models/M_auth.php */
 