<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
//require APPPATH . '/core/WC_Controller.php';

class Upload extends REST_Controller
{

    public $msg_not_found = 'Aucun enregitrement trouvé !';

   public  function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Images_model', 'ImagesModel');

    }

        public function index_post()
    {
    $this->upload($_FILES['image']);
   

            //var_dump($_FILES['img']);
            //$this->response($_FILES['img'], REST_Controller::HTTP_OK);
    }

    public function upload($param)
    {
        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Request-Headers: GET,POST,OPTIONS,DELETE,PUT");

        $filename = NULL;

        $isUploadError = FALSE;
        $fullPath = '';

        if ($param && $param['name']) {
            $new_name = time().$param['name'];
            $config['upload_path']          = 'Chambres/';
            $config['allowed_types']        = 'jpg|jpeg|png|gif';
            $config['max_size']             = 2048;
            $config['file_name'] = $new_name; 

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
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
                $fullPath = base_url('Chambres/'.$filename);
                $this->load->model('ImagesModel');

                 $imageData = array(
                    'images'=> $filename
                );

                $this->ImagesModel->Insert_image($imageData);

            }

        }

        if( ! $isUploadError) {


            $response = array(
                'status' => 'success',
                'filename' => $filename,
                'imagePath' => $fullPath
            );
        }



        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}