<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';

/**
 * 
 */
class Reservation extends REST_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Reservation_model', 'ReserveModel');
		// $this->load->helper('url');
		// $this->load->helper('text');
	}

	public function reservation_post()
	{
		$id = $this->input->post('id');
        $nom = $this->input->post('nom');
        $prix_chambre = $this->post('prix_chambre');
        $nom_person = $this->input->post('nom_person');
        $phone_person = $this->input->post('phone_person');
        $nombre_person =  $this->input->post('nombre_person');
        $localite = $this->input->post('localite');
        $categorie = $this->input->post('categorie');
        $type_chambre = $this->input->post('type_chambre');
        $nombre_ch = $this->input->post('nombre_ch');
        $email_person = $this->input->post('email_person');
        $date_arrive = $this->input->post('date_arrive');
        $date_depart = $this->input->post('date_depart');
        // $is_active = $this->input->post('1');


        // $reserveData = array()
        
        $reserveData = array(
        	'id' => $id,
        	'nom' =>$nom,
        	'prix_chambre' =>$prix_chambre,
        	'nom_person' =>$nom_person,
        	'phone_person' =>$phone_person,
        	'email_person' =>$email_person,
        	'localite' =>$localite,
        	'nombre_person' =>$nombre_person,
        	'nombre_ch' =>$nombre_ch,
        	'categorie' =>$categorie,
        	'type_chambre' =>$type_chambre,
        	'date_arrive'=>$date_arrive,
			'date_depart'=>$date_depart,
			'is_active' =>1,				
			'created_at' => date('Y-m-d H:i:s', time()),
			//'updated_at' =>date('Y-m-d H:i:s', time())
             );
        $insert = $this->ReserveModel->insertreservation($reserveData);
                
                // Check if the user data is inserted
         if($insert){
                    // Set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'message' => 'réservation passée avec succès.',
                        'data' => $insert
                    ], REST_Controller::HTTP_OK);
                }else{
                    // Set the response and exit
                    $this->response("un problème est intervenu lors de la réservation.", REST_Controller::HTTP_BAD_REQUEST);
                }
    }


	public function adminReservations_get(){

		$posts = array();
		$reservations = $this->ReserveModel->get_admin_reservations();		
			foreach($reservations as $reservation) {
				$posts[] = array(
					'id' => $reservation->id,
					// 'num_reservation' => $reservation->num_reservation,
					'nom' =>$reservation->nom,
					'prix_chambre' =>$reservation->prix_chambre,
					'nom_person' =>$reservation->nom_person,
					'phone_person' =>$reservation->phone_person,
					'categorie' =>$reservation->categorie,
					'email_person' =>$reservation->email_person,
					'date_arrive'=>$reservation->date_arrive,
					'date_depart'=>$reservation->date_depart,
					'created_at' => $reservation->created_at,
					'nombre_ch' =>$reservation->nombre_ch,
					'type_chambre' =>$reservation->type_chambre,
					'localite' =>$reservation->localite,
					'is_active' =>$reservation->is_active				

				);
			}

			$this->output
				->set_status_header(200)
				->set_content_type('application/json')
				->set_output(json_encode($posts)); 
		
	}

		public function adminReservation_get($id)
	{

			$reservation = $this->ReserveModel->get_admin_reservation($id);

			$posts[] = array(
					'id' => $reservation->id,
					// 'num_reservation' => $reservation->num_reservation,
					'nom' =>$reservation->nom,
					'prix_chambre' =>$reservation->prix_chambre,
					'nom_person' =>$reservation->nom_person,
					'phone_person' =>$reservation->phone_person,
					'categorie' =>$reservation->categorie,
					'email_person' =>$reservation->email_person,
					'date_arrive'=>$reservation->date_arrive,
					'date_depart'=>$reservation->date_depart,
					'created_at' => $reservation->created_at,
					'nombre_ch' =>$reservation->nombre_ch,
					'type_chambre' =>$reservation->type_chambre,
					'localite' =>$reservation->localite,
					'is_active' =>$reservation->is_active			

				);
			

			$this->output
				->set_status_header(200)
				->set_content_type('application/json')
				->set_output(json_encode($posts)); 
		
	}

	public function updateReservation_post($id)

	{
		$reservations = $this->ReserveModel->get_admin_reservation($id);

        $nom = $this->input->post('nom');
        $prix_chambre = $this->post('prix_chambre');
        $nom_person = $this->input->post('nom_person');
        $phone_person = $this->input->post('phone_person');
        $nombre_person =  $this->input->post('nombre_person');
        $localite = $this->input->post('localite');
        $categorie = $this->input->post('categorie');
        $type_chambre = $this->input->post('type_chambre');
        $nombre_ch = $this->input->post('nombre_ch');
        $email_person = $this->input->post('email_person');
        $date_arrive = $this->input->post('date_arrive');
        $date_depart = $this->input->post('date_depart');
        $is_active = $this->input->post('is_active');

        $reservationData = array(
        	'nom' =>$nom,
			'prix_chambre' =>$prix_chambre,
			'nom_person' =>$nom_person,
			'phone_person' =>$phone_person,
			'nombre_person' =>$nombre_person,
			'categorie' =>$categorie,
			'email_person' =>$email_person,
			'date_arrive'=>$date_arrive,
			'date_depart'=>$date_depart,
			'nombre_ch' =>$nombre_ch,
			'type_chambre' =>$type_chambre,
			'localite' =>$localite,
			'is_active' =>$is_active
        );
        $update= $this->ReserveModel->updateResrve($id, $reservationData);


        if($update){
                    // Set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'message' => 'réservation statuée avec succès.',
                        'data' => $update
                    ], REST_Controller::HTTP_OK);
                }else{
                    // Set the response and exit
                    $this->response("un problème est intervenu lors de la réservation.", REST_Controller::HTTP_BAD_REQUEST);
        }
	}



	public function deleteHotel_delete($id)
	{

		$reservation = $this->ReserveModel->get_admin_reservation($id);

		$this->ReserveModel->deletereservation($id);

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