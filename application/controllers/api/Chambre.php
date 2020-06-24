<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';

class Chambre extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Chambre_model', 'ChambreModel');
		// $this->load->helper('url');
		// $this->load->helper('text');
	}

	public function chambres_get(){

		$chambres = $this->ChambreModel->get_chambres();

		$posts = array();

			foreach($chambres as $chambre){

				$posts[] = array(
					'id' => $chambre->id,
					'hotel_id' => $chambre->hotel_id,
					'nom' => $chambre->nom,
					'ch_image' => base_url('photo_chambre/images/'.$chambre->ch_image),
					'type_chambre' =>$chambre->type_chambre,
					'ch_capacite' =>$chambre->ch_capacite,
					'ch_avantage'=>$chambre->ch_avantage
					//'updated_at' =>$chambre->updated_at
				);
			}
		

		$this->output
		     // ->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($posts));




	}

	

	public function adminChambres_get()
	{

		$posts = array();
			$chambres = $this->ChambreModel->get_admin_chambres();		
			foreach($chambres as $chambre) {
				$posts[] = array(
					'id' => $chambre->id,
					'code_chambre' => $chambre->code_chambre,
					'hotel_id' => $chambre->hotel_id,
					'nom' => $chambre->nom,
					'ch_image' => base_url('photo_chambre/images/'.$chambre->ch_image),
					'type_chambre' =>$chambre->type_chambre,
					'ch_capacite' =>$chambre->ch_capacite,
					'ch_avantage'=>$chambre->ch_avantage,
					'created_at' => $chambre->created_at,
					'updated_at' =>$chambre->updated_at
				);
			//$chambres = $this->ChambreModel->get_admin_chambres();
			}

			$this->output
				->set_status_header(200)
				->set_content_type('application/json')
				->set_output(json_encode($posts)); 
		
	}

	public function adminChambre_get($id)
	{


			$chambre = $this->ChambreModel->get_admin_chambre($id);

			$post = array(
				'id' => $chambre->id,
				'hotel_id' => $chambre->hotel_id,
				'code_chambre' => $chambre->code_chambre,
				'type_chambre' =>$chambre->type_chambre,
				'ch_description' => $chambre->ch_description,
			    'prix' => $chambre->prix,
			    'ch_capacite' => $chambre->ch_capacite,
				'ch_avantage' => $chambre->ch_avantage,
				//'status' => $chambre->status,
				'ch_image' => base_url('photo_chambre/images/'.$chambre->ch_image),
				// 'is_featured' => $chambre->is_featured,
				//'is_active' => $chambre->is_active
			);
			

			$this->output
				->set_status_header(200)
				->set_content_type('application/json')
				->set_output(json_encode($post)); 
		
	}

	public function createChambre_post()
	{
		    $type_chambre = $this->input->post('type_chambre');
		     $ch_capacite = $this->input->post('ch_capacite');
		     $code_chambre = $this->input->post('code_chambre');
		     $hotel_id = $this->input->post('hotel_id');
		     $prix = $this->input->post('prix');
			$ch_description = $this->input->post('ch_description');
			$ch_avantage = $this->input->post('ch_avantage');
			//$is_featured = $this->input->post('is_featured');
			//$status = $this->input->post('status');

			$filename = NULL;

			$isUploadError = FALSE;

			if ($_FILES && $_FILES['ch_image']['name']) {

				$config['upload_path']          = './photo_chambre/images/';
	            $config['allowed_types']        = 'gif|jpg|png|jpeg';
	            $config['max_size']             = 5000;

	            $this->load->library('upload', $config);
	            if ( ! $this->upload->do_upload('ch_image')) {

	            	$isUploadError = TRUE;

					$response = array(
						'status' => 'error',
						'message' => $this->upload->display_errors()
					);
	            }
	            else {
	            	$uploadData = $this->upload->data();
            		$filename = $uploadData['file_name'];
	            }
			}

			if( ! $isUploadError) {
	        	$chambreData = array(
					'type_chambre' => $type_chambre,
					'code_chambre' => $code_chambre,
					'hotel_id' => $hotel_id,
					'ch_capacite' => $ch_capacite,
					'ch_description' => $ch_description,
					'ch_image' => $filename,
					'prix' =>$prix,
					'ch_avantage' =>$ch_avantage,
					//'status' =>$status,
					// 'is_featured' => $is_featured,
					// 'is_active' => $is_active,
					'created_at' => date('Y-m-d H:i:s', time())
				);

				$id = $this->ChambreModel->insertchambre($chambreData);

				$response = array(
					'status' => 'success'
				);
			}

			$this->output
				->set_status_header(200)
				->set_content_type('application/json')
				->set_output(json_encode($response)); 
		}
	

	public function updateChambre_post($id){
			$chambre = $this->ChambreModel->get_admin_chambre($id);
			$filename = $chambre->ch_image;

			$type_chambre = $this->input->post('type_chambre');
			$ch_description = $this->input->post('ch_description');
			$ch_capacite = $this->input->post('ch_capacite');
			$code_chambre = $this->input->post('code_chambre');
			$prix = $this->input->post('prix');
			$ch_avantage = $this->input->post('ch_avantage');
			$hotel_id = $this->input->post('hotel_id');
			//$status = $this->input->post('status');

			$isUploadError = FALSE;

			if ($_FILES && $_FILES['ch_image']['name']) 
			{

				$config['upload_path']          = './photo_chambre/images/';
	            $config['allowed_types']        = 'gif|jpg|png|jpeg';
	            $config['max_size']             = 500;

	            $this->load->library('upload', $config);
	            if ( ! $this->upload->do_upload('ch_image')) {

	            	$isUploadError = TRUE;

					$response = array(
						'status' => 'error',
						'message' => $this->upload->display_errors()
					);
	            }
	            else {
	   
					if($chambre->ch_image && file_exists(FCPATH.'photo_chambre/images/'.$chambre->ch_image))
					{
						unlink(FCPATH.'photo_chambre/images/'.$chambre->ch_image);
					}

	            	$uploadData = $this->upload->data();
            		$filename = $uploadData['file_name'];
	            }
			}

			if( ! $isUploadError) {
	        	$chambreData = array(
					'type_chambre' => $type_chambre,
					'ch_description' => $ch_description,
					'ch_image' => $filename,
					'code_chambre' => $code_chambre,
					//'hotel_id' => $hotel_id,
					'prix' =>$prix,
					'ch_capacite' => $ch_capacite,
                    'ch_avantage' =>$ch_avantage,
					//'status' =>$status,
					'updated_at' => date('Y-m-d H:i:s', time())
				);

				$this->ChambreModel->updatechambre($id, $chambreData);

				$response = array(
					'status' => 'success'
				);
           	}

			$this->output
				->set_status_header(200)
				->set_content_type('application/json')
				->set_output(json_encode($response)); 
		
	}

	public function deletechambre_delete($id)
	{
		

			$chambre = $this->ChambreModel->get_admin_chambre($id);

			if($chambre->ch_image && file_exists(FCPATH.'photo_chambre/images/'.$chambre->ich_mage))
			{
				unlink(FCPATH.'photo_chambre/images/'.$chambre->ch_image);
			}

			$this->ChambreModel->deletechambre($id);

			$response = array(
				'status' => 'success'
			);

			$this->output
				->set_status_header(200)
				->set_content_type('application/json')
				->set_output(json_encode($response)); 
		
	}
}
