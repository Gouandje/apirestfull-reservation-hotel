 <?php
if(!defined('BASEPATH')) exit('No direct script allowed');


/**
 * 
 */
class Hotel_model extends MY_model
{
	

	public function liste($id =null)
	{
		if ($id === null) {

			return $this->db->get('hotels')->result_array();		
		}else{

			return $this->db->get_where('hotels', ['id'=>$id])->result_array();
		}
		
		
	}
	// public function checkToken($token)
	// {
	// 	$this->db->where('token', $token);
	// 	$query = $this->db->get('users');

	// 	if($query->num_rows() == 1) {
	// 		return true;
	// 	}
	// 	return false;
	// }



	public function insertHotel($id)
	{
		$this->db->insert('hotels', $id);
		return $this->db->insert_id();
	}

	public function updateHotel($id, $hotelData)
	{
		$this->db->where("id", $id);
		$this->db->update('hotels',$hotelData);
	}
 	

	public function insertHotelImage($DataImage)
	{
		 $this->db->insert('hotel_image', $DataImage);
	}

	public function deletehotel($id) {
        $this->db->where('id', $id);
        $this->db->delete('hotels');
    }
}