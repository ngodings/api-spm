<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class diareKel extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		$this->load->model('Peta');
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function index_get()
    {
        // Users from a data store e.g. database
        

        $id = $this->get('id_kel');

        // If the id parameter doesn't exist return all the users

        if ($id === NULL)
        {
			$data = $this->Peta->getJoin();
            // Check if the data data store contains data (in case the database result returns NULL)
            if ($data)
            {
                // Set the response and exit
                $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No data were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
		// Find and return a single record for a particular user.
        else {
            

            // Validate the id.
            if ($id <= 0)
            {
                // Invalid id, set the response and exit.
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }

            // Get the user from the array, using the id as key for retrieval.
            // Usually a model is to be used for this.

            $tgl=date('Y-m-d');

		
		$data = [
				'Diare_aktif' => $this->Peta-> get_count_kel($id, 'Dalam Perawatan', 'Diare'),
				'Diare_sembuh' => $this->Peta-> get_count_kel($id, 'Sembuh', 'Diare'),
				'Diare_die' => $this->Peta-> get_count_kel($id, 'Meninggal', 'Diare'),
	

				//dalam perawatan
				'pr_aktif_balita' => $this->Peta->penyakit_kel_usia ($id, 'Dalam Perawatan', 'Perempuan', '2016-01-01', $tgl, 'Diare'),
				'lk_aktif_balita' => $this->Peta->penyakit_kel_usia ($id, 'Dalam Perawatan', 'Laki-laki', '2016-01-01', $tgl, 'Diare'),
				'pr_aktif_anak' => $this->Peta->penyakit_kel_usia ($id, 'Dalam Perawatan', 'Perempuan', '2009-01-01', '2017-01-01', 'Diare'),
				'lk_aktif_anak' => $this->Peta->penyakit_kel_usia ($id, 'Dalam Perawatan', 'Laki-laki', '2009-01-01', '2017-01-01', 'Diare'),
				'pr_aktif_remaja' => $this->Peta->penyakit_kel_usia ($id, 'Dalam Perawatan', 'Perempuan', '1997-01-01', '2008-01-01', 'Diare'),
				'lk_aktif_remaja' => $this->Peta->penyakit_kel_usia ($id, 'Dalam Perawatan', 'Laki-laki', '1997-01-01', '2008-01-01', 'Diare'),
				'pr_aktif_dewasa' => $this->Peta->penyakit_kel_usia ($id, 'Dalam Perawatan', 'Perempuan', '1976-01-01', '1996-01-01', 'Diare'),
				'lk_aktif_dewasa' => $this->Peta->penyakit_kel_usia ($id, 'Dalam Perawatan', 'Laki-laki', '1976-01-01', '1996-01-01', 'Diare'),
				'pr_aktif_lansia' => $this->Peta->penyakit_kel_usia ($id, 'Dalam Perawatan', 'Perempuan', '1940-01-01', '1975-01-01', 'Diare'),
				'lk_aktif_lansia' => $this->Peta->penyakit_kel_usia ($id, 'Dalam Perawatan', 'Laki-laki', '1940-01-01', '1975-01-01', 'Diare'),
				//sembuh
				'pr_sembuh_balita' => $this->Peta->penyakit_kel_usia ($id, 'Sembuh', 'Perempuan', '2016-01-01', $tgl, 'Diare'),
				'lk_sembuh_balita' => $this->Peta->penyakit_kel_usia ($id, 'Sembuh', 'Laki-laki', '2016-01-01', $tgl, 'Diare'),
				'pr_sembuh_anak' => $this->Peta->penyakit_kel_usia ($id, 'Sembuh', 'Perempuan', '2009-01-01', '2017-01-01', 'Diare'),
				'lk_sembuh_anak' => $this->Peta->penyakit_kel_usia ($id, 'Sembuh', 'Laki-laki', '2009-01-01', '2017-01-01', 'Diare'),
				'pr_sembuh_remaja' => $this->Peta->penyakit_kel_usia ($id, 'Sembuh', 'Perempuan', '1997-01-01', '2008-01-01', 'Diare'),
				'lk_sembuh_remaja' => $this->Peta->penyakit_kel_usia ($id, 'Sembuh', 'Laki-laki', '1997-01-01', '2008-01-01', 'Diare'),
				'pr_sembuh_dewasa' => $this->Peta->penyakit_kel_usia ($id, 'Sembuh', 'Perempuan', '1976-01-01', '1996-01-01', 'Diare'),
				'lk_sembuh_dewasa' => $this->Peta->penyakit_kel_usia ($id, 'Sembuh', 'Laki-laki', '1976-01-01', '1996-01-01', 'Diare'),
				'pr_sembuh_lansia' => $this->Peta->penyakit_kel_usia ($id, 'Sembuh', 'Perempuan', '1940-01-01', '1975-01-01', 'Diare'),
				'lk_sembuh_lansia' => $this->Peta->penyakit_kel_usia ($id, 'Sembuh', 'Laki-laki', '1940-01-01', '1975-01-01', 'Diare'),
				//meninggal
				'pr_die_balita' => $this->Peta->penyakit_kel_usia ($id, 'Meninggal', 'Perempuan', '2016-01-01', $tgl, 'Diare'),
				'lk_die_balita' => $this->Peta->penyakit_kel_usia ($id, 'Meninggal', 'Laki-laki', '2016-01-01', $tgl, 'Diare'),
				'pr_die_anak' => $this->Peta->penyakit_kel_usia ($id, 'Meninggal', 'Perempuan', '2009-01-01', '2017-01-01', 'Diare'),
				'lk_die_anak' => $this->Peta->penyakit_kel_usia ($id, 'Meninggal', 'Laki-laki', '2009-01-01', '2017-01-01', 'Diare'),
				'pr_die_remaja' => $this->Peta->penyakit_kel_usia ($id, 'Meninggal', 'Perempuan', '1997-01-01', '2008-01-01', 'Diare'),
				'lk_die_remaja' => $this->Peta->penyakit_kel_usia ($id, 'Meninggal', 'Laki-laki', '1997-01-01', '2008-01-01', 'Diare'),
				'pr_die_dewasa' => $this->Peta->penyakit_kel_usia ($id, 'Meninggal', 'Perempuan', '1976-01-01', '1996-01-01', 'Diare'),
				'lk_die_dewasa' => $this->Peta->penyakit_kel_usia ($id, 'Meninggal', 'Laki-laki', '1976-01-01', '1996-01-01', 'Diare'),
				'pr_die_lansia' => $this->Peta->penyakit_kel_usia ($id, 'Meninggal', 'Perempuan', '1940-01-01', '1975-01-01', 'Diare'),
				'lk_die_lansia' => $this->Peta->penyakit_kel_usia ($id, 'Meninggal', 'Laki-laki', '1940-01-01', '1975-01-01', 'Diare'),

				'nama_kelurahan' => $this->db->limit(1)->get_where('kelurahan', array('id_kel'=>$id))->row()->nama_kelurahan
			];
			$this->response($data, REST_Controller::HTTP_OK);
        }

        
    }

    
}
