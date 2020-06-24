<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
// require APPPATH . '/core/WC_Controller.php';

class Search extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Search_model', 'SM');
		// $this->load->helper('url');
		// $this->load->helper('text');
	}
	public function Search_post(){
		if ($this->post()) {
			$prix = ($this->post('prix')) ? $this->post('prix') : '';
			$etoile= ($this->post('etoile')) ? $this->post('etoile') : 6;
			$like = ($this->post('like')) ? $this->post('like') : '';

		$search = $this->SM->search($prix, $like, $etoile );

		$this->response([
			'staus' =>  TRUE,
			'message' => 'voici les chambres recherchées',
			'data' => $search
		], REST_Controller::HTTP_OK);

		} 
	}
	public function Research_post(){
		if($this->post()){
			$ville = ($this->post('ville'))? $this->post('ville') : '';
			
			$research = $this->SM->research($ville);

			$this->response([
			'staus' =>  TRUE,
			'message' => 'voici les hôtels recherchés',
			'data' => $research
		], REST_Controller::HTTP_OK);
		}
	}	
		


}