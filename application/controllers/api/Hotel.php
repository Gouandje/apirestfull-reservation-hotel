 <?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
// require APPPATH . '/core/WC_Controller.php';

/**
 * 
 */

class Hotel extends REST_Controller
{
	public $msg= 'hotel ajouté avec succès';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Hotel_model', 'HotelModel');
		// $this->load->helper('url');
		// $this->load->helper('text');
		


	}

	public function hotel_get()
	{
		// $data = $this->Hotel_model->liste();
		
		//test avec id apres je traiterai avec le nom de hotel
	      $id = $this->get('id');

	      if ($id === null) {
	      		$data = $this->HotelModel->liste();
	      }else{
	      	$data = $this->HotelModel->liste($id);
	      }

		if($data) 
		{
			$this->response([

				'status' =>'true',
				'data' => $data
			], REST_Controller::HTTP_OK);
	    }
	    else
	    {
	    	$this->response([
	    		'status' => 'false',
	    		'message' =>'hotel non trouver'
	    	], REST_Controller::HTTP_OK);

	    }

	}


	public function hotels_post()
	{

			$nom = $this->input->post('nom');
			$localite = $this->input->post('localite');
			$types = $this->input->post('types');
			$images = $this->input->post('images');
			$capacite = $this->input->post('capacite');
			$description = $this->input->post('description');			

			$filename = NULL;

			$isUploadError = FALSE;

			if ($_FILES && $_FILES['images']['name']) {

				$config['upload_path']    = 'image_hotel/';
	            $config['allowed_types']  = 'gif|jpg|png|jpeg';
	            $config['max_size']       = 500;

	            $this->load->library('upload', $config);
	            if ( ! $this->upload->do_upload('images'))
	            {

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
					'localite'=> $localite,
					'types' => $types,
					'description' => $description,
					'images' => $filename,
					'capacite' => $capacite
				);
				$id = $this->HotelModel->insertHotel($hotelData);

				$DataImage =array(
					'hotel_id' =>$id,
					'images' =>$filename
				);
				$this->HotelModel->insertHotelImage($DataImage);

				$response = array(
					'status' => 'success'
				);
			}

			$this->output
				->set_status_header(200)
				->set_content_type('application/json')
				->set_output(json_encode($response)); 
		
	}


	public function updateHotel_put($id)
	{

		// $hotelData = array(); 
  //       $id  =  $this ->put ('hotel_id'); 
  //       $hotelData ['nom'] =  $this->put('nom'); 
  //       $hotelData ['localite'] =  $this->put ('localite'); 
  //       $hotelData ['capacite'] = $this ->put( 'capacite' ); 
  //       $hotelData ['type'] = $this -> put ('type'); 
  //       $hotelData ['images'] = $this -> put ('image'); 

        $filename = NULL;

        $isUploadError = FALSE;


        if ($_FILES && $_FILES['image']['name']) {

			$config['upload_path']          = 'image_hotel/';
	        $config['allowed_types']        = 'gif|jpg|png|jpeg';
	           $config['max_size']             = 500;

	        $this->load->library('upload', $config);
	        if ( ! $this->upload->do_upload('images')) 
	        {

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
			if (!$isUploadError) {
				$hotelData = array('nom' => $this->input->post('nom'),
					'localite'=> $this->input->post('localite'),
					'type' => $this->input->post('type'),
					'description' => $this->input->post('description'),
					'images' => $this->input->post('images'),
					'capacite' => $this->input->post('capacite')
  			 );
				$this->HotelModel->updateHotel($this->input->post("id"), $hotelData);
				$DataImage =array(
					'hotel_id' =>$id,
					'images' =>$filename
				);
				$this->HotelModel->insertHotelImage($DataImage);
			}

        $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);

		



		// 	if( ! $isUploadError) {
	 //        	$hotelData = array(
		// 			'id' => $id,
		// 			'nom' => $nom,
		// 			'user_id' => 1,
		// 			'description' => $description,
		// 			'images' => $filename,
		// 			'localite' => $localite,
		// 			'capacite' => $capacite
		// 		);
				
		// 			 $this->HotelModel->updatehotel($hotelData);
  
		// 			$DataImage =array(
		// 				'hotel_id' =>$id,
		// 				'images' =>$filename
		// 			);
		// 			$this->HotelModel->insertHotelImage($DataImage);

		// 			if ($update) {
		// 				$this->response([

	 //                     'status'=>TRUE,
	 //                     'message' =>'hotel mis à jour avec succès'
  //                   	], REST_Controller::HTTP_OK);
		// 			}else{

		// 				$this->response("un problème est survenu", REST_Controller::HTTP_BAD_REQUEST);
		// 			}
				

  //      	}

	}

	public function deleteHotel_delete($id) {

        $result = $this->HotelModel->deletehotel($id);

        if ($result === FALSE) {
            $this->response(array('status' => 'failed'));
        } else {
            $this->response(array('status' => 'success'));
        }
    }


 }	