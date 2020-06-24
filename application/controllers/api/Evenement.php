<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
// require APPPATH . '/core/WC_Controller.php';

class Evenement extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Evenement_model', 'EvenementModel');
		// $this->load->helper('url');
		// $this->load->helper('text');
	}
		public function evenements_get()
	{

		$evenements = $this->EvenementModel->get_evenements();

		$posts = array();

			foreach($evenements as $event){

				$posts[] = array(
					'id' => $event->id,
					'titre_ev' => $event->titre_ev,
					'date_ev' => $event->date_ev,
					'description_ev' => $event->description_ev,
					'image_ev' => base_url('photo_event/images/'.$event->image_ev),
					'created_at' => $event->created_at
				);
			}
		

		$this->output
		     // ->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($posts));
	
	}

		public function evenement_get($id)
	{
		$evenement = $this->ChambreModel->get_admin_evenement($id);
		$post = array(
			'id' => $evenement->id,
			'titre_ev' => $evenement->titre_ev,
			'description_ev' => $evenement->description_ev,
			'date_ev' =>$evenement->date_ev,
			//'status' => $chambre->status,
			'image_ev' => base_url('photo_event/images/'.$evenement->image_ev),
				// 'is_featured' => $chambre->is_featured,
				//'is_active' => $chambre->is_active
			);
			

			$this->output
				->set_status_header(200)
				->set_content_type('application/json')
				->set_output(json_encode($post)); 
	}

    public function adminEvenements_get()
	{
		
		$posts = array();
		// if($isValidToken) {
			$evenements = $this->EvenementModel->get_admin_evenements();
			foreach($evenements as $events) {
				$posts[] = array(
					'id' => $events->id,
					'titre_ev' => $events->titre_ev,
					'date_ev' => $events->date_ev,
					'description_ev' => $events->description_ev,
					'image_ev' => base_url('photo_event/images/'.$events->image_ev),
					'created_at' => $events->created_at
				);
			}

			$this->output
				->set_status_header(200)
				->set_content_type('application/json')
				->set_output(json_encode($posts)); 
		//}
	}

	public function adminEvenement_get($id)
	{


			$event = $this->EvenementModel->get_admin_evenement($id);

			$post = array(
				'id' => $event->id,
				'titre_ev' => $event->titre_ev,
				'description_ev' => $event->description_ev,
				'date_ev' => $event->date_ev,
				'image_ev' => base_url('photo_event/images/'.$event->image_ev)
			);
			

			$this->output
				->set_status_header(200)
				->set_content_type('application/json')
				->set_output(json_encode($post)); 
		
	}
	public function createEvenement_post()
	{
		
			$titre_ev = $this->input->post('titre_ev');
			$date_ev = $this->input->post('date_ev');
			$image_ev = $this->input->post('image_ev');
			$description_ev = $this->input->post('description_ev');
			

			$filename = NULL;

			$isUploadError = FALSE;

			if ($_FILES && $_FILES['image_ev']['name']) {

				$config['upload_path']          = './photo_event/images/';
	            $config['allowed_types']        = 'gif|jpg|png|jpeg';
	            $config['max_size']             = 5000;

	            $this->load->library('upload', $config);
	            if ( ! $this->upload->do_upload('image_ev')) {

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
	        	$eventData = array(
					'titre_ev' => $titre_ev,
					'description_ev' => $description_ev,
					'image_ev' => $filename,
					'date_ev' => $date_ev,
					'created_at' => date('Y-m-d H:i:s', time())
				);

				$id = $this->EvenementModel->insertevent($eventData);

				$response = array(
					'status' => 'success'
				);
			}

			$this->output
				->set_status_header(200)
				->set_content_type('application/json')
				->set_output(json_encode($response)); 
		
	} 

	public function updateEvenement_post($id)
	{
		$event = $this->EvenementModel->get_admin_evenement($id);
		$filename = $event->image_ev;

		$titre_ev = $this->input->post('titre_ev');
		$date_ev = $this->input->post('date_ev');
		$description_ev = $this->input->post('description_ev');

		$isUploadError = FALSE;

		if ($_FILES && $_FILES['image_ev']['name']) {

			$config['upload_path']          = './photo_event/images/';
	        $config['allowed_types']        = 'gif|jpg|png|jpeg';
	        $config['max_size']             = 5000;

	        $this->load->library('upload', $config);
	        if ( ! $this->upload->do_upload('image_ev')) {

	        $isUploadError = TRUE;

			$response = array(
					'status' => 'error',
					'message' => $this->upload->display_errors()
					);
	        }
	            else {
	   
					if($event->image_ev && file_exists(FCPATH.'photo_event/images/'.$event->image_ev))
					{
						unlink(FCPATH.'photo_event/images/'.$event->image_ev);
					}

	            	$uploadData = $this->upload->data();
            		$filename = $uploadData['file_name'];
	            }
			}

			if( ! $isUploadError) {
	        	$eventData = array(
					'titre_ev' => $titre_ev,
					'date_ev' => $date_ev,
					'description_ev' => $description_ev,
					'image_ev' => $filename
				);

				$this->EvenementModel->updateevent($id, $eventData);

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

	public function deleteEvenement_delete($id)
	{

		$event = $this->EvenementModel->get_admin_evenement($id);

		if($event->image_ev && file_exists(FCPATH.'photo_event/images/'.$event->image_ev))
		{
			unlink(FCPATH.'photo_event/images/'.$event->image_ev);
		}

		$this->EvenementModel->deleteevente($id);

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
