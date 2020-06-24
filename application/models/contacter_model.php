 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacter_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}

 public function insertMessage($contactData){

		$this->db->insert('contacts', $contactData);
		return $this->db->insert_id();
  }
}