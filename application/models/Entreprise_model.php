<?php
if(!defined('BASEPATH')) exit('No direct script allowed');

	class Entreprise_model extends MY_Model{

        protected $entreprise_table = 'tab_entreprise';

		public function __construct(){

			$this->load->database();
		}
        
        public function entreprise($id)
        {
            $where = array('entreprise_id'=>$id);
            $row = $this->crud_get_where($this->entreprise_table, $where)->row();
            return $row;
        }

        public function entreprise_all()
        {
            $result = $this->crud_get_all($this->entreprise_table)->result_array();
            return $result;
        }

        public function create(array $data){
            return $this->crud_insert($this->entreprise_table, $data);
        }

        public function update(array $data){
            $id = $this->db->get_where($this->entreprise_table, array('entreprise_id'=>$data['entreprise_id']))->row()->entreprise_id;
            $where = array('entreprise_id'=>$id);
            return $this->crud_update($this->entreprise_table, $data, $where);
        }

        public function delete(array $data){
            return $this->crud_delete($this->entreprise_table, $data);
        }

}