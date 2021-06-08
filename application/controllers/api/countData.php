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
class countData extends REST_Controller {

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
        

        $id = $this->get('id_kec');

        // If the id parameter doesn't exist return all the users

        if ($id === NULL)
        {
			$data = $this->Peta->get_ims();
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

            $data = [
				'covid_aktif' => $this->Peta-> get_count_all($id, 'Dalam Perawatan', 'COVID-19'),
				'covid_sembuh' => $this->Peta-> get_count_all($id, 'Sembuh', 'COVID-19'),
				'covid_die' => $this->Peta-> get_count_all($id, 'Meninggal', 'COVID-19'),
	
				'tbc_aktif' => $this->Peta-> get_count_all($id, 'Dalam Perawatan', 'TBC'),
				'tbc_sembuh' => $this->Peta-> get_count_all($id, 'Sembuh', 'TBC'),
				'tbc_die' => $this->Peta-> get_count_all($id, 'Meninggal', 'TBC'),
	
				'ims_aktif' => $this->Peta-> get_count_all($id, 'Dalam Perawatan', 'IMS'),
				'ims_sembuh' => $this->Peta-> get_count_all($id, 'Sembuh', 'IMS'),
				'ims_die' => $this->Peta-> get_count_all($id, 'Meninggal', 'IMS'),
	
				'diare_aktif' => $this->Peta-> get_count_all($id, 'Dalam Perawatan', 'Diare'),
				'diare_sembuh' => $this->Peta-> get_count_all($id, 'Sembuh', 'Diare'),
				'diare_die' => $this->Peta-> get_count_all($id, 'Meninggal', 'Diare'),
	
				'dbd_aktif' => $this->Peta-> get_count_all($id, 'Dalam Perawatan', 'DBD'),
				'dbd_sembuh' => $this->Peta-> get_count_all($id, 'Sembuh', 'DBD'),
				'dbd_die' => $this->Peta-> get_count_all($id, 'Meninggal', 'DBD'),
				
	
				
				'nama_kecamatan' => $this->db->limit(1)->get_where('kecamatan', array('id_kec'=>$id))->row()->nama_kecamatan
			];
			$this->response($data, REST_Controller::HTTP_OK);
        }

        
    }

   

}
