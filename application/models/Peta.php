<?php

class Peta extends CI_Model
{
   

	public function getJoin()
    {
        $this->db->select('*');
        $this->db->from('rekam_medik');
        $this->db->join('pasien', 'pasien.id_pasien=rekam_medik.id_pasien');
        $this->db->join('penyakit', 'penyakit.id_penyakit=rekam_medik.id_penyakit');
        $this->db->join('user', 'user.id_user=rekam_medik.id_user');

        
        $query = $this->db->get();
        return $query->result_array();
    }
	public function getJoinId($id)
    {
        $this->db->select('*');
        $this->db->from('rekam_medik');
        $this->db->join('pasien', 'pasien.id_pasien=rekam_medik.id_pasien');
        $this->db->join('penyakit', 'penyakit.id_penyakit=rekam_medik.id_penyakit');
		
        $this->db->join('user', 'user.id_user=rekam_medik.id_user');
        $this->db->where('rekam_medik.id_rm', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

	public function get_ims($id_kec){
		
		$tgl=date('Y-m-d');
		$tgl1= '2015-01-01';
		$this->db->join('penyakit', 'rekam_medik.id_penyakit = penyakit.id_penyakit');
		$this->db->join('pasien','rekam_medik.id_pasien = pasien.id_pasien');
		$this->db->join('kecamatan', 'pasien.id_kec = kecamatan.id_kec');
		$this->db->where('penyakit.nama_penyakit', 'IMS');
		//$this->db->where('rekam_medik.status', $status);
		$this->db->where('rekam_medik.tanggal_terinfeksi >=', $tgl1);
		$this->db->where('rekam_medik.tanggal_terinfeksi <=', $tgl);
		
		$this->db->where('kecamatan.id_kec', $id_kec);
		
		

		return $this->db->count_all_results('rekam_medik');
	}
	public function get_count ($id_kel, $penyakit){
		$tgl=date('Y-m-d');
		$tgl1= '2015-01-01';
		$this->db->join('penyakit', 'rekam_medik.id_penyakit = penyakit.id_penyakit');
		$this->db->join('pasien','rekam_medik.id_pasien = pasien.id_pasien');
		$this->db->join('kecamatan', 'pasien.id_kec = kecamatan.id_kec');
		$this->db->join('kelurahan', 'pasien.id_kel = kelurahan.id_kel');
		$this->db->where('penyakit.nama_penyakit', $penyakit);
		$this->db->where('rekam_medik.tanggal_terinfeksi >=', $tgl1);
		$this->db->where('rekam_medik.tanggal_terinfeksi <=', $tgl);
		$this->db->where('kelurahan.id_kel', $id_kel);


		return $this->db->count_all_results('rekam_medik');
	}
	public function get_count_kec($id_kec, $penyakit){
		$tgl=date('Y-m-d');
		$tgl1= '2015-01-01';
		$this->db->join('penyakit', 'rekam_medik.id_penyakit = penyakit.id_penyakit');
		$this->db->join('pasien','rekam_medik.id_pasien = pasien.id_pasien');
		$this->db->join('kecamatan', 'pasien.id_kec = kecamatan.id_kec');
		$this->db->join('kelurahan', 'pasien.id_kel = kelurahan.id_kel');
		$this->db->where('penyakit.nama_penyakit', $penyakit);
		$this->db->where('rekam_medik.tanggal_terinfeksi >=', $tgl1);
		$this->db->where('rekam_medik.tanggal_terinfeksi <=', $tgl);
		$this->db->where('kecamatan.id_kec', $id_kec);

		return $this->db->count_all_results('rekam_medik');
	}
	public function get_count_all ($id_kec, $status, $penyakit){
		$tgl=date('Y-m-d');
		$tgl1= '2015-01-01';
		$this->db->join('penyakit', 'rekam_medik.id_penyakit = penyakit.id_penyakit');
		$this->db->join('pasien','rekam_medik.id_pasien = pasien.id_pasien');
		$this->db->join('kecamatan', 'pasien.id_kec = kecamatan.id_kec');
		$this->db->join('kelurahan', 'pasien.id_kel = kelurahan.id_kel');
		$this->db->where('penyakit.nama_penyakit', $penyakit);
		$this->db->where('rekam_medik.status', $status);
		$this->db->where('rekam_medik.tanggal_terinfeksi >=', $tgl1);
		$this->db->where('rekam_medik.tanggal_terinfeksi <=', $tgl);
		$this->db->where('kecamatan.id_kec', $id_kec);

		return $this->db->count_all_results('rekam_medik');
	}
	public function get_count_kel ($id_kel, $status, $penyakit){
		$tgl=date('Y-m-d');
		$tgl1= '2015-01-01';
		$this->db->join('penyakit', 'rekam_medik.id_penyakit = penyakit.id_penyakit');
		$this->db->join('pasien','rekam_medik.id_pasien = pasien.id_pasien');
		$this->db->join('kecamatan', 'pasien.id_kec = kecamatan.id_kec');
		$this->db->join('kelurahan', 'pasien.id_kel = kelurahan.id_kel');
		$this->db->where('penyakit.nama_penyakit', $penyakit);
		$this->db->where('rekam_medik.status', $status);
		$this->db->where('rekam_medik.tanggal_terinfeksi >=', $tgl1);
		$this->db->where('rekam_medik.tanggal_terinfeksi <=', $tgl);
		$this->db->where('kelurahan.id_kel', $id_kel);

		return $this->db->count_all_results('rekam_medik');
	}
	public function penyakit_kel_usia ($id_kel, $status, $jk, $tahun1, $tahun2, $penyakit){
		$tgl=date('Y-m-d');
		$tgl1= '2015-01-01';
		$this->db->join('penyakit', 'rekam_medik.id_penyakit = penyakit.id_penyakit');
		$this->db->join('pasien','rekam_medik.id_pasien = pasien.id_pasien');
		$this->db->join('kecamatan', 'pasien.id_kec = kecamatan.id_kec');
		$this->db->join('kelurahan', 'pasien.id_kel = kelurahan.id_kel');
		$this->db->where('penyakit.nama_penyakit', $penyakit);
		$this->db->where('rekam_medik.status', $status);
		$this->db->where('pasien.jk', $jk);
		$this->db->where('pasien.tanggal_lahir >=', $tahun1);
		$this->db->where('pasien.tanggal_lahir <=', $tahun2);
		$this->db->where('rekam_medik.tanggal_terinfeksi >=', $tgl1);
		$this->db->where('rekam_medik.tanggal_terinfeksi <=', $tgl);
		$this->db->where('kelurahan.id_kel', $id_kel);

		return $this->db->count_all_results('rekam_medik');
	}
}
