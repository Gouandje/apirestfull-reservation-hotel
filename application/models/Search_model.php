 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}

	public function search($prix=0, $like='', $etoile=6){
		$this->db->select('h.*, c.prix, c.hotel_id');
		$this->db->from('hotels h');
		$this->db->join('chambres c','h.id=c.hotel_id', 'left');
		if ($prix >0) {
			$this->db->where('c.prix <=', $prix);
		}
		if ($etoile >= 0 && $etoile < 6) {
			$this->db->where('h.categorie', $etoile);
		}
		$this->db->group_start();
		$this->db->like('h.nom', $like);
		$this->db->or_like('h.localite', $like);
		$this->db->group_end();


		$retour = $this->db->get()->result();

		return $retour;
		

	}

	public function research($ville=''){
		$this->db->select('h.*');
		$this->db->from('hotels h');
		$this->db->group_start();
		$this->db->like('h.localite', $ville);
		$this->db->group_end();

	   $retr = $this->db->get()->result();
	   return $retr;



	}
}	