<?php 

class Images_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function Insert_image($imageData){

       return $this->db->insert('chambre_image', $imageData);
    }

    public function Insert_hotel_image($data)
    {
        return $this->db->insert('hotel_image', $data);
    }
   
}