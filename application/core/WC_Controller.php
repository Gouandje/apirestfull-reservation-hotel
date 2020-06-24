<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/BeforeValidException.php';
require_once APPPATH . '/libraries/ExpiredException.php';
require_once APPPATH . '/libraries/SignatureInvalidException.php';
use \Firebase\JWT\JWT;

class WC_Controller extends REST_Controller
{
	private $user_credential;
	public function __construct(){
	    parent::__construct();
	    $this->auth();
	}

    public function auth()
    {
                 
  
        $this->methods['users_get']['limit'] = 500;
        // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100;
        // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50;
        // 50 requests per hour per user/key
        //JWT Auth middleware
        $headers = $this->input->get_request_header('Authorization');
        $key = $this->config->item('reservation_keys_security');
        $token= "token";
       	if (!empty($headers)) {
        	if (preg_match('/Bearer\s(\S+)/', $headers , $matches)) {
            $token = $matches[1];
        	}
    	}
        try {
            
           $decoded = JWT::decode($token, $key, array('HS256'));
		   if($decoded){
			   
			   if($decoded->level != 8){
					$invalid = ['status' => 401,
						'messageGet'=>'Accès refusé' ,
						"msgPut"=>"TOKEN ACCESS DENIED !"
					];
					$this->response($invalid, 401);//401	
						return;
			   }
		   }else{
					$invalid = ['status' => 401,
						'messageGet'=>'Accès refusé' ,
						"msgPut"=>"TOKEN INVALID PLEASE GET AUTHENTIFICATION TO ACCESS!"
					];
					$this->response($invalid, 401);//401	
						return;			   
		   }

        } catch (Exception $e) {
            $invalid = ['status' => $e->getCode(),
                'messageGet'=>$e->getMessage() ,
                "msgPut"=>"TOKEN INVALID PLEASE GET AUTHENTIFICATION TO ACCESS"
            ];
            $this->response($invalid, 401);//401
        }

    }
}