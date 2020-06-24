<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
// require APPPATH . '/core/WC_Controller.php';

class Publicite extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Publicite_model', 'PubModel');
	}
	public function adminPubs_get(){
		$pubs = $this->PubModel->get_pubs();

		$posts = array();

			foreach($pubs as $pub){

				$posts[] = array(
					'id' => $pub->id,
					'nom' => $pub->nom,
					'description' => $pub->description,
					'web'=> $pub->web,
					'image' => base_url('publicite/images/'.$pub->image),
					'is_active' =>$pub->is_active,
					'created_at' => $pub->created_at
				);
			}
			$this->output
		     // ->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($posts));
	}

	

		public function adminpub_get($id)
	{
		
		$pub = $this->PubModel->get_admin_publicite($id);
	
			$post = array(
			'id' => $pub->id,
			'nom' => $pub->nom,
			'description' => $pub->description,
			'web' => $pub->web,
			'is_active'=>$pub->is_active,
			'image' =>base_url('publicite/images/'.$pub->image),
			// 'created_at' => $value->created_at
		);

		
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($post));
	}


		public function createpub_post()
		{

			$nom = $this->input->post('nom');
			$web = $this->input->post('web');
			$is_active = $this->input->post('is_active');
			$image = $this->input->post('image');
			$description = $this->input->post('description');
			

			$filename = NULL;

			$isUploadError = FALSE;

			if ($_FILES && $_FILES['image']['name']) {

				$config['upload_path']          = './publicite/images/';
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
	        	$pubData = array(
					'nom' => $nom,
					'description' => $description,
					'image' => $filename,
					'web' => $web,
					'is_active' =>$is_active,
					'created_at' => date('Y-m-d H:i:s', time())
				);

				$id = $this->PubModel->insertPub($pubData);

				$response['status']= 200;
				$response['message']='Succès de la requete !';
				$response['data']=[];
			}

			$this->set_response($response, 200);
		
	} 

	public function updatePublicite_post($id)

	{
		$pub = $this->PubModel->get_admin_publicite($id);

        $nom = $this->input->post('nom');
        $web = $this->input->post('web');
        $description = $this->input->post('description');
        $image = $this->input->post('image');
        $is_active = $this->input->post('is_active');

        $isUploadError = FALSE;

		if ($_FILES && $_FILES['image']['name']) {

			$config['upload_path']          = './publicite/images/';
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
	   
					if($pub->image && file_exists(FCPATH.'publicite/images/'.$pub->image))
					{
						unlink(FCPATH.'publicite/images/'.$pub->image);
					}

	            	$uploadData = $this->upload->data();
            		$filename = $uploadData['file_name'];
	            }
		}
		if( ! $isUploadError) {
	       $publiciteData = array(
        	'nom' =>$nom,
			'web' =>$web,
			'description' =>$description,
			'image' => $filename,
			'is_active' =>$is_active,
			'updated_at' => date('Y-m-d H:i:s', time())
             );

				$this->PubModel->updatepub($id, $publiciteData);

				$response = array(
					'status' => 'success'
				);

           	}
           	$this->output
				->set_status_header(200)
				->set_content_type('application/json')
				->set_output(json_encode($response));
	}

	public function deletePub_delete($id)
	{

		$pub = $this->PubModel->get_admin_publicite($id);

		if($pub->image && file_exists(FCPATH.'publicite/images/'.$pub->image))
		{
			unlink(FCPATH.'publicite/images/'.$pub->image);
		}

		$this->PubModel->deletepub($id);

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
