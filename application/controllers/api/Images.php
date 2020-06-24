<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
//require_once APPPATH . '/libraries/JWT.php';

class Images extends REST_Controller
{

	public $msg_not_found = 'Aucun enregitrement trouvé !';

	function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Images_model', 'ImagesModel');

    }
public function index_post()
    {
        if($this->post()){
            $_POST = $this->post();
            if( $this->post('nom_d_img')){
                $photos = $this->post('nom_d_img')['value'];
                $imageurl = $this->uploaderBase64($photos, mt_rand(1111111111,9999999999).time());
                $_POST['nom_d_img'] = ($imageurl != 404)? $imageurl : '';
            }
				$ccccc= 'R'.time();
				$c = $this->PersonnelModel->idchambre($ccccc);
                $_POST['idchambre'] =  ($c)? 'R'.date('YmdHis') : $ccccc;
            $uer = $this->PersonnelModel->create($_POST);
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

    	function uploaderBase64($name, $idchambre){
			$try = [];
		try{
				$directory = "image_hotel/";
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
				$basename= $idchambre;
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