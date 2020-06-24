<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';

/**
 * 
 */
class Contacter extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Contacter_model', 'ContacterModel');
		// $this->load->helper('url');
		// $this->load->helper('text');
	}

		public function contacter_post()
	{
		$id = $this->input->post('id');
        $nom_prenom = $this->input->post('nom_prenom');
        $email = $this->post('email');
        $telephone = $this->post('telephone');
        $Message = $this->post('Message');
        $staus = $this->post('status');
        
        
        $contactData = array(
        	'id' => $id,
        	'nom_prenom' =>$nom_prenom,
        	'email' =>$email,
        	'telephone' =>$telephone,
        	'Message' =>$Message,
        	'status' => 1,
			'created_at' => date('Y-m-d H:i:s', time())
			//'updated_at' =>date('Y-m-d H:i:s', time())
             );
        $insert = $this->ContacterModel->insertMessage($contactData);
                
                // Check if the user data is inserted
         if($insert){
                    // Set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'message' => 'Message envoyé avec succès.',
                        'data' => $insert
                    ], REST_Controller::HTTP_OK);
                }else{
                    // Set the response and exit
                    $this->response("un problème est survenu lors de l\'envoi du message.", REST_Controller::HTTP_BAD_REQUEST);
                }
    }
}
