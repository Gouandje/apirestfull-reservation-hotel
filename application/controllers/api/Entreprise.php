<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/core/WC_Controller.php';



class Entreprise extends WC_Controller
{
  		function __construct()
    {
        parent::__construct();
        $this->load->model('entreprise_model', 'EntrepriseModel');

    }

     public function entreprise_get()
    {
		$return = $this->db->get("tab_entreprise")->result();
		if($return){
							$output['status'] = 200;
							$output['data'] = $return;
							$output['message'] = "succès de la requête!";			
        $this->set_response($output, 200);
			
		}else{
							$output['status'] = 404;
							$output['data'] = "resultat vide";
							$output['message'] = "succès de la requête!";			
			
        $this->set_response($output, 200);
		}
	}
	
    public function single_entreprise_get($id)
    {
		$return = $this->EntrepriseModel->entreprise($id);
		if($return){
							$output['status'] = 200;
							$output['data'] = $return;
							$output['message'] = "succès de la requête!";			
        $this->set_response($output, 200);
			
		}else{
							$output['status'] = 404;
							$output['data'] = "resultat vide";
							$output['message'] = "succès de la requête!";			
			
        $this->set_response($output, 200);
		}
    }
    
    
    public function entreprise_delete(){
							$id = $this->input->get('id');
							if($id){
								$data= array('entreprise_id'=>$id);
								$uer = $this->EntrepriseModel->delete($data);
								$output['status'] = 200;
								$output['message'] = 'requete executer. Resultat : '.(($uer == true)? 'true' : 'false');
								$output['data'] = [];
								$output['response'] = $uer;
								$this->set_response($output, 200);
								return;   
							}else{
								$output['status'] = 404;
								$output['data'] = date("Y-m-d H:i:s");
								$output['message'] = 'Echec de la requete! ';
								$this->set_response($output, 200);
								return; 								
							}
    }


    public function entreprise_post(){



							if($this->post()){
								$_POST = $this->post();
								if( $this->post('entreprise_logo')){
									$photos = $this->post('entreprise_logo')['value'];
									$imageurl = $this->uploaderBase64($photos, mt_rand(1111111111,9999999999).time());
									$_POST['entreprise_logo'] = ($imageurl != 404)? $imageurl : '';
								}
								$uer = $this->EntrepriseModel->create($_POST);
								$output['status'] = 200;
								$output['message'] = 'requete executer. Resultat : '.(($uer == true)? 'succès' : 'Echec');
								$output['data'] = [];
								$output['response'] = $uer;
								$this->set_response($output, 200);
								return; 
								
							}else{
								             
								$output['status'] = 404;
								$output['data'] = [];
								$output['message'] = 'Echec de la requete! ';
								$this->set_response($output, 200);
								return; 
								
							}
    }

    public function entrepriseUpdate_post(){


							if($this->post() && $this->post('entreprise_id')){
								$_POST = $this->post();
								if( $this->post('entreprise_logo')){
									$photos = $this->post('entreprise_logo')['value'];
									$imageurl = $this->uploaderBase64($photos, $this->post('entreprise_id'));
									$_POST['entreprise_logo'] = ($imageurl != 404)? $imageurl : '';
								}
								$uer = $this->EntrepriseModel->update($_POST);
								$output['status'] = 200;
								$output['message'] = 'requete executer. Resultat : '.(($uer)? 'succès' : 'Echec');
								$output['data'] = [];
								$output['response'] = $uer;
								$this->set_response($output, 200);
								return; 
								
							}else{
								             
								$output['status'] = 404;
								$output['data'] = [];
								$output['message'] = 'Echec de la requete! ';
								$this->set_response($output, 200);
								return; 
								
							}
							
							
    }
    

   

   
   	public function upload($params, $id){
	    
			$uploaddir = 'Logo_entreprise/';
			if(!is_dir($uploaddir)){
			    mkdir($uploaddir);
			}
			
			if($params['name']){
				$path = $params['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$user_img = $id.'_'.time(). '.' . $ext;
				$uploadfile = $uploaddir . $user_img;
				if ($params["name"]) {
					if (move_uploaded_file($params["tmp_name"],$uploadfile)) {
						return $uploadfile;
					}
				}
			}else{
			
			}
	}
	
	
	
	
	function uploaderBase64($name, $code_personnel){
			$try = [];
		try{
				$directory = "Logo_entreprise/";
				if(!is_dir($directory)){
					mkdir($directory);
				}
				define('UPLOAD_DIR', $directory);
				$total_saved=0;

								
				$img = $name;
				$img = str_replace('data:image/png;base64,', '', $img);
				$img = str_replace('ata:image/png;base64,', '', $img);
				$img = str_replace(' ', '+', $img);
				$data = base64_decode($img);
				$basename= $code_personnel;
				$file = UPLOAD_DIR . $basename . '.png';
				$success=file_put_contents($file, $data);
				if($success){
			
						$total_saved++;
					
				}else{
					$try[] = [1];
				}
			
			if(is_array($try) && count($try) > 0){
				return 404;
			}else{
				return $file;				
			}
		}catch(Exception $e){
            $invalid = ['status' => $e->getCode(),
                'messageGet'=>$e->getMessage() ,
                "msgPut"=>"Attention, une erreur est survenue pendant l'execution de la requête upload !"
            ];
            $this->response($invalid, 402);//402			
		}
	}
	
}