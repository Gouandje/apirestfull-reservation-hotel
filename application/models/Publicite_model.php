<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publicite_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}
	public function get_pubs()
	{

		$this->db->select('p.*');
		$this->db->from('publicite p');
		$query = $this->db->get();
		return $query->result();
	}

	public function insertPub($pubData)
	{
		$this->db->insert('publicite', $pubData);
		return $this->db->insert_id();
	}




	public function get_admin_publicite($id)
	{
		$this->db->select('pub.*');
		$this->db->from('publicite pub');
		$this->db->where('pub.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function updatepub($id, $publiciteData)
	{
		$this->db->where('id', $id);
		$this->db->update('publicite', $publiciteData);
	}

	public function deletepub($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('publicite');
	}
}