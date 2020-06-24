<?php
if(!defined('BASEPATH')) exit('No direct script allowed');

	class Aide_model extends MY_Model{

        protected $aide_table = 'tab_faq';

		public function __construct(){

			$this->load->database();
		}
        
        public function aide($id)
        {
            $where = array('id'=>$id);
            $row = $this->crud_get_where($this->aide_table, $where)->row();
            return $row;
        }

        public function aide_all()
        {
            $result = $this->crud_get_all($this->aide_table)->result_array();
            return $result;
        }

        public function create(array $data){
            return $this->crud_insert($this->aide_table, $data);
        }

        public function update(array $data){
            $id = $this->db->get_where($this->aide_table, array('id'=>$data['id']))->row()->id;
            $where = array('id'=>$id);
            return $this->crud_update($this->aide_table, $data, $where);
        }

        public function delete(array $data){
            return $this->crud_delete($this->aide_table, $data);
        }

}