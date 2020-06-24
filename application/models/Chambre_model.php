<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chambre_model extends CI_Model 
{
	public function __construct(){

	    $this->load->database();
	}

	public function get_chambres()
	{
		$this->db->select('c.id, c.code_chambre, c.hotel_id, c.type_chambre, c.ch_capacite, c.prix, c.ch_image, c.ch_avantage, h.nom');
		$this->db->from('chambres c');
		$this->db->join('hotels h', 'h.id = c.hotel_id');
		$query = $this->db->get();
		return $query->result();
	}



	public function get_admin_chambres()
	{
		$this->db->select('c.id, c.code_chambre, c.hotel_id, c.type_chambre, c.ch_capacite, c.prix, c.ch_image, c.ch_avantage, c.created_at, c.updated_at, h.nom');
		$this->db->from('chambres c');
		$this->db->join('hotels h', 'h.id=c.hotel_id');
		//$this->db->where('h.id=c.hotel_id');
		$this->db->order_by('c.created_at', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_admin_chambre($id)
	{
		$this->db->select('chambre.*, h.nom');
		$this->db->from('chambres chambre');
		$this->db->join('hotels h', 'h.id=chambre.hotel_id');
		$this->db->where('chambre.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function insertchambre($chambreData)
	{
		$this->db->insert('chambres', $chambreData);
		return $this->db->insert_id();

	}

	public function updatechambre($id, $chambreData)
	{
		$this->db->where('id', $id);
		$this->db->update('chambres', $chambreData);
	}

	public function deletechambre($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('chambres');
	}
}
