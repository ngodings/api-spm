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
class Medis extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function index_get()
    {
        // Users from a data store e.g. database
        

        $id = $this->get('id_rm');

        // If the id parameter doesn't exist return all the users

        if ($id === NULL)
        {
			$users = $this->db->get("rekam_medik")->result_array();
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($users)
            {
                // Set the response and exit
                $this->response($users, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No users were found'
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

            $this->db->where(array("id_rm"=>$id));
			$users = $this->db->get("rekam_medik")->row_array();
			$this->response($users, REST_Controller::HTTP_OK);
        }

        
    }

    public function index_post()
    {
        
        $data = [
            'id_rm' => $this->post('id_rm'),
            'id_pasien' => $this->post('id_pasien'),
			'tanggal_terinfeksi' => $this->post('tanggal_terinfeksi'),
			'id_penyakit' => $this->post('id_penyakit'),
			'status' => $this->post('status'),
			'tanggal_sembuh' => $this->post('tanggal_sembuh'),
			'keterangan' => $this->post('keterangan'),
			'id_user' => $this->post('id_user'),
        ];
		$this->db->insert("rekam_medik", $data);
        $this->set_response($data, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function index_delete()
    {
        $id = $this->delete('id');

        // Validate the id.
        // if ($id <= 0)
        // {
        //     // Set the response and exit
        //     $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        // }

        // $this->some_model->delete_something($id);
        $where = [
            'id_rm' => $id,
            
        ];
		$this->db->delete("rekam_medik", $where);
		$message=array("status"=>"Data berhasil terhapus");
        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

	public function index_put()
	{
		$where = array(
			'id_rm' => $this->put('id_rm')
		);
		$data = array(
			'id_rm' => $this->put('id_rm'),
            'id_pasien' => $this->put('id_pasien'),
			'tanggal_terinfeksi' => $this->put('tanggal_terinfeksi'),
			'id_penyakit' => $this->put('id_penyakit'),
			'status' => $this->put('status'),
			'tanggal_sembuh' => $this->put('tanggal_sembuh'),
			'keterangan' => $this->put('keterangan'),
			'id_user' => $this->put('id_user'),
		);

		$this->db->update("rekam_medik", $where, $data);
		$this->set_response($data, REST_Controller::HTTP_CREATED);
	}

}
