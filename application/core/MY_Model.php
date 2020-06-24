<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model
{
    protected $erreur_bdd = 'Erreur base de donnée';
    public function __construct(){

        $this->load->database();
    }

    /**
     * Recuperer un element d'une table
     * @method: get_where
     * @param : {Table, where}
     */
    public function crud_get_where($table_name, array $where){
        try {
            $qry = $this->db->get_where($table_name,$where);
            return $qry;
        } catch (\Throwable $th) {
            return $this->erreur_bdd;
        }
    }

    /**
     * Recuperer tous elements d'une table
     * @method: get_all
     * @param : {Table}
     */
    public function crud_get_all($table_name){
        $query = $this->db->get($table_name);
        return $query;
    }

    /**
     * Inserer un element dans une table
     * @method: insert
     * @param : {Table, data}
     */
    public function crud_insert($table_name, $data){
        $this->db->insert($table_name,  $data);
        return $this->db->insert_id();
    }

    /**
     * Inserer un tableau d'element dans une table
     * @method: batch
     * @param : {Table, data}
     */
    public function crud_insert_batch($table_name, array $data){
        // $count = count($data);
        
        // $first_id = $this->db->insert_id();
        // $last_id = $first_id + ($count-1);

        return $this->db->insert($table_name, $data);
    }

    /**
     * Modifier un element d'une table
     * @method: update
     * @param : {Table, where,ligne}
     */
    public function crud_update($table_name, array $data, array $where){
        return $this->db->update($table_name,$data, $where);
    }

    /**
     * Supprimer un element d'une table
     * @method: delete
     * @param : {Table, data}
     */
    public function crud_delete($table_name, array $data){
        $query = $this->db->get_where($table_name, $data);
        if ($this->db->affected_rows()>0) {
            $this->db->delete($table_name, $data);
            if ($this->db->affected_rows()>0) {
                return true;
            }
            return false;
        } 
        return false;
    }

}

