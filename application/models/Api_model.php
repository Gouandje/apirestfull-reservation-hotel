<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}

	public function get_hotels()
	{

		$this->db->select('h.*');
		$this->db->from('hotels h');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_categorie()
	{
		$this->db->select('*');
		$this->db->from('categories');
		$query = $this->db->get();
		return $query->result();
	}


		public function get_hotel($id)
	{
		$this->db->select('c.*, h.*');
		$this->db->from('chambres as c');
		$this->db->join('hotels as h', 'h.id=c.hotel_id','left');
		$this->db->where('c.hotel_id', $id);
		$query = $this->db->get();
		return $query->result();
	}




	public function get_admin_hotels()
	{
		$this->db->select('hotel.*, u.first_name, u.last_name');
		$this->db->from('hotels hotel');
		$this->db->join('users u', 'u.id=hotel.user_id');
		$this->db->order_by('hotel.created_at', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_admin_hotel($id)
	{
		$this->db->select('hotel.*, u.first_name, u.last_name');
		$this->db->from('hotels hotel');
		$this->db->join('users u', 'u.id=hotel.user_id');
		$this->db->where('hotel.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	
	public function inserthotel($hotelData)
	{
		$this->db->insert('hotels', $hotelData);
		return $this->db->insert_id();
	}

	public function updatehotel($id, $hotelData)
	{
		$this->db->where('id', $id);
		$this->db->update('hotels', $hotelData);
	}

	public function deletehotel($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('hotels');
	}
	
}
