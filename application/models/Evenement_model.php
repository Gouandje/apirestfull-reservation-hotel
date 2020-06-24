<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evenement_model extends CI_Model 
{
	public function __construct(){

	    $this->load->database();
	}

	public function get_evenements()
	{
		$this->db->select('*');
		$this->db->from('evenements');
		$query = $this->db->get();
		return $query->result();
	}



	public function get_admin_evenements()
	{
		$this->db->select('eve.*');
		$this->db->from('evenements eve');
		// $this->db->join('hotels h', 'h.id=c.hotel_id');
		//$this->db->where('h.id=c.hotel_id');
		$this->db->order_by('eve.date_ev', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_admin_evenement($id)
	{
		$this->db->select('eve.*');
		$this->db->from('evenements eve');
		$this->db->where('eve.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function insertevent($eventData)
	{
		$this->db->insert('evenements', $eventData);
		return $this->db->insert_id();

	}

	public function updateevent($id, $eventData)
	{
		$this->db->where('id', $id);
		$this->db->update('evenements', $eventData);
	}

	public function deleteevente($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('evenements');
	}
}
