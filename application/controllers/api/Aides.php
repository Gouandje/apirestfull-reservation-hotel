<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Aides extends REST_Controller
{

	public $msg_not_found = 'Aucun enregitrement trouvé !';

	function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('aide_model', 'AideModel');

    }

  	/**
     * Get aide 
     * @method: GET
     */
    public function index_get($param='')
    {
        $aide= array();

        if (empty($param)) {
            
            foreach ($this->AideModel->aide_all() as $row)
            {
                $data = $row;
                $aide[] = $data;  
            }     
            if (empty($aide)) {
                $this->set_response([
                    'status'=>false,
                    'message'=> $this->msg_not_found
                ],
                    REST_Controller::HTTP_NOT_FOUND
                );
            } else {
                $this->set_response($aide, REST_Controller::HTTP_OK);
            }
            
        } else {
            $row = $this->AideModel->aide($param);
            $aide =  $row;

            if (empty($aide)) {
                $this->set_response([
                    'status'=>false,
                    'message'=>$this->msg_not_found
                ],
                    REST_Controller::HTTP_NOT_FOUND
                );
            } else {
                $this->set_response($aide, REST_Controller::HTTP_OK);
            }

        }
        $this->set_response($aide, REST_Controller::HTTP_OK);
	}

    /**
     * Create New Aide
     * @method: POST
     */
    public function index_post()
    {
        if($this->post()){
            $_POST = $this->post();
            $_POST['date_at'] = date('Y-m-d\TH:i:s.u');
            $_POST['update_at'] = date('Y-m-d\TH:i:s.u');
            $aide = $this->AideModel->create($_POST);
            $output['status'] = 200;
            $output['message'] = 'requete executer. Resultat : '.(($aide == true)? 'succès' : 'Echec');
            $output['data'] = [];
            $output['response'] = $aide;
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

    /**
     * Update Aide
     * @method: PUT
     */
    public function indexUpdate_post()
    {
        if($this->post() && $this->post('id')){
            $_POST = $this->post();
            $_POST['update_at'] = date('Y-m-d\TH:i:s.u');
            $aide = $this->AideModel->update($_POST);
            $output['status'] = 200;
            $output['message'] = 'requete executer. Resultat : '.(($aide == true)? 'succès' : 'Echec');
            $output['data'] = [];
            $output['response'] = $aide;
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

    /**
     * Delete Aide
     * @method: DELETE
     */
    public function index_delete($id)
    {
        $id = $this->security->xss_clean($id);

        if (empty($id) AND !is_numeric($id)) {
            $this->set_response([
                'status'=>FALSE,
                'message'=>'L\'Id n\'existe'
            ],
            REST_Controller::HTTP_NOT_FOUND);
        } else {
            $aide= [
                'id'=>$id
            ];
            $outpout = $this->AideModel->delete($aide);
            if ($outpout>0 AND !empty($outpout)) {
                $message = [
                    'status'=>true,
                    'message'=>"Aide supprimé avec succes!"
                ];

                $this->response($message, REST_Controller::HTTP_OK);
                
            } else {
                $message = [
                    'status'=>false,
                    'message'=>"Une erreur est survenue lors de l'enregistrement!"
                ];

                $this->response($message, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

}