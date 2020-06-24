<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;
if(!function_exists('trust')){
	function trust($token){
		$decoded = JWT::decode($token, '@RESTAPITOKENFORWIKEAGROUP_2018', array('HS256'));
		if(!$decoded){
		    $this->set_response([
				 			'statut'=>FALSE,
					 		'error'=>'TOKEN INVALID PLEASE GET AUTHENTIFICATION TO ACCESS'
				  		], REST_Controller::HTTP_NOT_FOUND);
		    
		}
		
	}
}