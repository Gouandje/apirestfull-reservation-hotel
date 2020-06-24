<?php
if(!defined('BASEPATH')) exit('No direct script allowed');

	class Users_model extends MY_Model{

        protected $user_table = 'tab_user';

		public function __construct(){

			$this->load->database();
		}
        
        public function user($id)
        {
            $where = array('id_user'=>$id);
            $row = $this->crud_get_where($this->user_table, $where)->row();
            return $row;
        }

        public function user_where(array $params)
        {
            $where = $params;
            $row = $this->crud_get_where($this->user_table, $where)->row();
            return $row;
        }

        public function user_all()
        {
            $result = $this->crud_get_all($this->user_table)->result_array();
            return $result;
        }

        public function create(array $data){
            return $this->crud_insert($this->user_table, $data);
        }

        public function update(array $data){
            $id = $this->db->get_where($this->user_table, array('id_user'=>$data['id_user']))->row()->id_user;
            $where = array('id_user'=>$id);
            return $this->crud_update($this->user_table, $data, $where);
        }

        public function delete(array $data){
            return $this->crud_delete($this->user_table, $data);
        }

}