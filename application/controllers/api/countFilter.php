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
class countFilter extends REST_Controller {

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
        
		$tahun1 = $this->get('tahun_awal');
		$tahun2 = $this->get('tahun_akhir');
        $id = $this->get('id_kec');

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
		else if ($id >= 0 && $tahun1 === NULL){
			$data = [
				'covid_all' => $this->Peta-> penyakit_kec2($id, $tahun2, 'COVID-19'),
				'covid_aktif' => $this->Peta->  penyakit_kec1($id, 'Dalam Perawatan', $tahun2, 'COVID-19'),
				'covid_sembuh' => $this->Peta->  penyakit_kec1($id, 'Sembuh', $tahun2, 'COVID-19'),
				'covid_die' => $this->Peta->  penyakit_kec1($id, 'Meninggal', $tahun2, 'COVID-19'),

				'TBC_all' => $this->Peta-> penyakit_kec2($id, $tahun2, 'TBC'),
				'TBC_aktif' => $this->Peta->  penyakit_kec1($id, 'Dalam Perawatan', $tahun2, 'TBC'),
				'TBC_sembuh' => $this->Peta->  penyakit_kec1($id, 'Sembuh', $tahun2, 'TBC'),
				'TBC_die' => $this->Peta->  penyakit_kec1($id, 'Meninggal', $tahun2, 'TBC'),


				'IMS_all' => $this->Peta-> penyakit_kec2($id, $tahun2, 'IMS'),
				'IMS_aktif' => $this->Peta->  penyakit_kec1($id, 'Dalam Perawatan', $tahun2, 'IMS'),
				'IMS_sembuh' => $this->Peta->  penyakit_kec1($id, 'Sembuh', $tahun2, 'IMS'),
				'IMS_die' => $this->Peta->  penyakit_kec1($id, 'Meninggal', $tahun2, 'IMS'),
				

				'Diare_all' => $this->Peta-> penyakit_kec2($id, $tahun2, 'Diare'),
				'Diare_aktif' => $this->Peta->  penyakit_kec1($id, 'Dalam Perawatan', $tahun2, 'Diare'),
				'Diare_sembuh' => $this->Peta->  penyakit_kec1($id, 'Sembuh', $tahun2, 'Diare'),
				'Diare_die' => $this->Peta->  penyakit_kec1($id, 'Meninggal', $tahun2, 'Diare'),

				'DBD_all' => $this->Peta-> penyakit_kec2($id, $tahun2, 'DBD'),
				'DBD_aktif' => $this->Peta->  penyakit_kec1($id, 'Dalam Perawatan', $tahun2, 'DBD'),
				'DBD_sembuh' => $this->Peta->  penyakit_kec1($id, 'Sembuh', $tahun2, 'DBD'),
				'DBD_die' => $this->Peta->  penyakit_kec1($id, 'Meninggal', $tahun2, 'DBD'),
				
				'nama_kecamatan' => $this->db->limit(1)->get_where('kecamatan', array('id_kec'=>$id))->row()->nama_kecamatan
			];
			$this->response($data, REST_Controller::HTTP_OK);

		}
		else if ($id >= 0 && $tahun2 === NULL){
			$data = [
				'covid_all' => $this->Peta->penyakit_kec4($id, $tahun1, 'COVID-19'),
				'covid_aktif' => $this->Peta->penyakit_kec3($id, 'Dalam Perawatan', $tahun1, 'COVID-19'),
				'covid_sembuh' => $this->Peta->penyakit_kec3($id, 'Sembuh', $tahun1, 'COVID-19'),
				'covid_die' => $this->Peta->penyakit_kec3($id, 'Meninggal', $tahun1, 'COVID-19'),

				'TBC_all' => $this->Peta->penyakit_kec4($id, $tahun1, 'TBC'),
				'TBC_aktif' => $this->Peta->penyakit_kec3($id, 'Dalam Perawatan', $tahun1, 'TBC'),
				'TBC_sembuh' => $this->Peta->penyakit_kec3($id, 'Sembuh', $tahun1, 'TBC'),
				'TBC_die' => $this->Peta->penyakit_kec3($id, 'Meninggal', $tahun1, 'TBC'),


				'IMS_all' => $this->Peta->penyakit_kec4($id, $tahun1, 'IMS'),
				'IMS_aktif' => $this->Peta->penyakit_kec3($id, 'Dalam Perawatan', $tahun1, 'IMS'),
				'IMS_sembuh' => $this->Peta->penyakit_kec3($id, 'Sembuh', $tahun1, 'IMS'),
				'IMS_die' => $this->Peta->penyakit_kec3($id, 'Meninggal', $tahun1, 'IMS'),
				

				'Diare_all' => $this->Peta->penyakit_kec4($id, $tahun1, 'Diare'),
				'Diare_aktif' => $this->Peta->penyakit_kec3($id, 'Dalam Perawatan', $tahun1, 'Diare'),
				'Diare_sembuh' => $this->Peta->penyakit_kec3($id, 'Sembuh', $tahun1, 'Diare'),
				'Diare_die' => $this->Peta->penyakit_kec3($id, 'Meninggal', $tahun1, 'Diare'),

				'DBD_all' => $this->Peta->penyakit_kec4($id, $tahun1, 'DBD'),
				'DBD_aktif' => $this->Peta->penyakit_kec3($id, 'Dalam Perawatan', $tahun1, 'DBD'),
				'DBD_sembuh' => $this->Peta->penyakit_kec3($id, 'Sembuh', $tahun1, 'DBD'),
				'DBD_die' => $this->Peta->penyakit_kec3($id, 'Meninggal', $tahun1, 'DBD'),
				
				'nama_kecamatan' => $this->db->limit(1)->get_where('kecamatan', array('id_kec'=>$id))->row()->nama_kecamatan
			];
			$this->response($data, REST_Controller::HTTP_OK);

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

            $data = [
				'covid_all' => $this->Peta-> penyakit_kec($id, $tahun1, $tahun2, 'COVID-19'),
				'covid_aktif' => $this->Peta-> penyakit_kec_tahun($id, 'Dalam Perawatan', $tahun1, $tahun2, 'COVID-19'),
				'covid_sembuh' => $this->Peta-> penyakit_kec_tahun($id, 'Sembuh', $tahun1, $tahun2, 'COVID-19'),
				'covid_die' => $this->Peta-> penyakit_kec_tahun($id, 'Meninggal', $tahun1, $tahun2, 'COVID-19'),

				'TBC_all' => $this->Peta-> penyakit_kec($id, $tahun1, $tahun2, 'TBC'),
				'TBC_aktif' => $this->Peta-> penyakit_kec_tahun($id, 'Dalam Perawatan', $tahun1, $tahun2, 'TBC'),
				'TBC_sembuh' => $this->Peta-> penyakit_kec_tahun($id, 'Sembuh', $tahun1, $tahun2, 'TBC'),
				'TBC_die' => $this->Peta-> penyakit_kec_tahun($id, 'Meninggal', $tahun1, $tahun2, 'TBC'),


				'IMS_all' => $this->Peta-> penyakit_kec($id, $tahun1, $tahun2, 'IMS'),
				'IMS_aktif' => $this->Peta-> penyakit_kec_tahun($id, 'Dalam Perawatan', $tahun1, $tahun2, 'IMS'),
				'IMS_sembuh' => $this->Peta-> penyakit_kec_tahun($id, 'Sembuh', $tahun1, $tahun2, 'IMS'),
				'IMS_die' => $this->Peta-> penyakit_kec_tahun($id, 'Meninggal', $tahun1, $tahun2, 'IMS'),
				

				'Diare_all' => $this->Peta-> penyakit_kec($id, $tahun1, $tahun2, 'Diare'),
				'Diare_aktif' => $this->Peta-> penyakit_kec_tahun($id, 'Dalam Perawatan', $tahun1, $tahun2, 'Diare'),
				'Diare_sembuh' => $this->Peta-> penyakit_kec_tahun($id, 'Sembuh', $tahun1, $tahun2, 'Diare'),
				'Diare_die' => $this->Peta-> penyakit_kec_tahun($id, 'Meninggal', $tahun1, $tahun2, 'Diare'),

				'DBD_all' => $this->Peta-> penyakit_kec($id, $tahun1, $tahun2, 'DBD'),
				'DBD_aktif' => $this->Peta-> penyakit_kec_tahun($id, 'Dalam Perawatan', $tahun1, $tahun2, 'DBD'),
				'DBD_sembuh' => $this->Peta-> penyakit_kec_tahun($id, 'Sembuh', $tahun1, $tahun2, 'DBD'),
				'DBD_die' => $this->Peta-> penyakit_kec_tahun($id, 'Meninggal', $tahun1, $tahun2, 'DBD'),
				
				'nama_kecamatan' => $this->db->limit(1)->get_where('kecamatan', array('id_kec'=>$id))->row()->nama_kecamatan
			];
			$this->response($data, REST_Controller::HTTP_OK);
        }


        
    }

   

}
