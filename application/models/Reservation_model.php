<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}

	public function get_admin_reservations()
	{
		$this->db->select('reserve.*');
		$this->db->from('reservation reserve');
		$this->db->where('reserve.is_active = 1');
		$this->db->order_by('reserve.created_at', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	  	public function get_admin_reservation($id)
	{
		$this->db->select('*');
		$this->db->from('reservation');
		$this->db->where('reservation.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

    public function insertreservation($reserveData){

		$this->db->insert('reservation', $reserveData);
		return $this->db->insert_id();
  }

  public function updateResrve($id, $reservationData){
  	$this->db->where('id', $id);
	$this->db->update('reservation', $reservationData);

  }
  public function deletereservation($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('reservation');
	}




}  