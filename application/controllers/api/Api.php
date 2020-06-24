<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
// require APPPATH . '/core/WC_Controller.php';

class Api extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Api_model', 'ApiModel');
		// $this->load->helper('url');
		// $this->load->helper('text');
	}
		public function hotels_get()
	{

		$hotels = $this->ApiModel->get_hotels();

		$posts = array();

			foreach($hotels as $hotel){

				$posts[] = array(
					'id' => $hotel->id,
					'nom' => $hotel->nom,
					'localite' => $hotel->localite,
					'categorie'=> $hotel->categorie,
					'capacite' => $hotel->capacite,
					'description' => $hotel->description,
					'telephone'=> $hotel->telephone,
					'image' => $hotel->image,
					'created_at' => $hotel->created_at
				);
			}
		

		$this->output
		     // ->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($posts));
	
	}
	public function categorie_get(){
		$cat =$this->ApiModel->get_categorie();
		// if ($cat) {
		// 	$cate[] = array(
		// 	'id' => $cat['id'],
		// 	'categorie' => $cat->categorie
		// );
			
		// }
		

		 $this->response([
        'status' => TRUE,
        'message' => 'voici les catégories.',
        'data' => $cat
                ], REST_Controller::HTTP_OK);

	 }
	

	public function hotel_get($id)
	{
		
		$hotel = $this->ApiModel->get_hotel($id);
		$post=[];
		foreach ($hotel as $key => $value) {
					$post[] = array(
			'id' => $value->id,
			'nom' => $value->nom,
			'description' => $value->description,
			'localite' => $value->localite,
			'categorie'=> $value->categorie,
			'capacite' => $value->capacite,
			'ch_capacite' =>$value->ch_capacite,
			'ch_description'=>$value->ch_description,
			'ch_image' =>base_url('photo_chambre/images/'.$value->ch_image),
			'prix' => $value->prix,
			'image' => base_url('media/images/'.$value->image),
			'created_at' => $value->created_at
		);
		}

		
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($post));
	}

    public function adminHotels_get()
	{
		
		$posts = array();
		// if($isValidToken) {
			$hotels = $this->ApiModel->get_admin_hotels();
			foreach($hotels as $hotel) {
				$posts[] = array(
					'id' => $hotel->id,
					'nom' => $hotel->nom,
					'capacite' =>$hotel->capacite,
					'telephone' =>$hotel->telephone,
					'categorie' =>$hotel->categorie,
					'localite' => $hotel->localite,
					'image' => base_url('media/images/'.$hotel->image),
					'created_at' => $hotel->created_at
				);
			}

			$this->output
				->set_status_header(200)
				->set_content_type('application/json')
				->set_output(json_encode($posts)); 
		//}
	}

	public function adminhotel_get($id)
	{


			$hotel = $this->ApiModel->get_admin_hotel($id);

			$post = array(
				'id' => $hotel->id,
				'nom' => $hotel->nom,
				'capacite' =>$hotel->capacite,
				'description' => $hotel->description,
				'categorie' => $hotel->categorie,
				'image' => base_url('media/images/'.$hotel->image),
				'telephone' => $hotel->telephone,
				'localite' => $hotel->localite
			);
			

			$this->output
				->set_status_header(200)
				->set_content_type('application/json')
				->set_output(json_encode($post)); 
		
	}
	public function createhotel_post()
	{
		
			$nom = $this->input->post('nom');
			$localite = $this->input->post('localite');
			$capacite = $this->input->post('capacite');
			$telephone = $this->input->post('telephone');
			$categorie = $this->input->post('categorie');
			$image = $this->input->post('image');
			$description = $this->input->post('description');
			

			$filename = NULL;

			$isUploadError = FALSE;

			if ($_FILES && $_FILES['image']['name']) {

				$config['upload_path']          = './media/images/';
	            $config['allowed_types']        = 'gif|jpg|png|jpeg';
	            $config['max_size']             = 5000;

	            $this->load->library('upload', $config);
	            if ( ! $this->upload->do_upload('image')) {

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
	        	$hotelData = array(
					'nom' => $nom,
					'user_id' => 1,
					'description' => $description,
					'image' => $filename,
					'localite' => $localite,
					'capacite' =>$capacite,
					'telephone' => $telephone,
					'categorie' => $categorie,
					'created_at' => date('Y-m-d H:i:s', time())
				);

				$id = $this->ApiModel->inserthotel($hotelData);

				$response['status']= 200;
				$response['message']='Succès de la requete !';
				$response['data']=[];
			}

			$this->set_response($response, 200);
		
	} 

	public function updateHotel_post($id)
	{
		$hotel = $this->ApiModel->get_admin_hotel($id);
		$filename = $hotel->image;

		$nom = $this->input->post('nom');
		$capacite = $this->input->post('capacite');
		$description = $this->input->post('description');
		$localite = $this->input->post('localite');
		$telephone = $this->input->post('telephone');

		$isUploadError = FALSE;

		if ($_FILES && $_FILES['image']['name']) {

			$config['upload_path']          = './media/images/';
	        $config['allowed_types']        = 'gif|jpg|png|jpeg';
	        $config['max_size']             = 5000;

	        $this->load->library('upload', $config);
	        if ( ! $this->upload->do_upload('image')) {

	        $isUploadError = TRUE;

			$response = array(
					'status' => 'error',
					'message' => $this->upload->display_errors()
					);
	        }
	            else {
	   
					if($hotel->image && file_exists(FCPATH.'media/images/'.$hotel->image))
					{
						unlink(FCPATH.'media/images/'.$hotel->image);
					}

	            	$uploadData = $this->upload->data();
            		$filename = $uploadData['file_name'];
	            }
			}

			if( ! $isUploadError) {
	        	$hotelData = array(
					'nom' => $nom,
					'capacite' => $capacite,
					'user_id' => 1,
					'description' => $description,
					'image' => $filename,
					'localite' => $localite,
					'telephone' => $telephone
				);

				$this->ApiModel->updatehotel($id, $hotelData);

				$response = array(
					'status' => 'success'
				);
           	}

			$this->output
				->set_status_header(200)
				->set_content_type('application/json')
				->set_output(json_encode($response)); 
		//}
	}

	public function deleteHotel_delete($id)
	{

		$hotel = $this->ApiModel->get_admin_hotel($id);

		if($hotel->image && file_exists(FCPATH.'media/images/'.$hotel->image))
		{
			unlink(FCPATH.'media/images/'.$hotel->image);
		}

		$this->ApiModel->deletehotel($id);

		$response = array(
			'status' => 'success'
		);

			$this->output
				->set_status_header(200)
				->set_content_type('application/json')
				->set_output(json_encode($response)); 
		// }
	}
}	
