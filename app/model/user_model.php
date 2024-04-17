<?php

class User_Model extends JI_Model{

    public $tbl = "user";
    public $tbl_as = "ussr";

    public function __construct(){
        parent::__construct();
        $this->db->from($this->tbl, $this->tbl_as);
    }

    public function get_by_id($id){    
        $this->db->where("$this->tbl_as.is_deleted", "1", "AND", "<>"); //Is not deleted data 
        $this->db->where("id", $id);
    }

    public function auth($email){
        $this->db->where("$this->tbl_as.is_deleted", "1", "AND", "<>"); //Is not deleted data
        $this->db->where("email", $email, "OR", "=", 1, 0);
        $this->db->where("username", $email, "OR", "=", 0, 1);
        return $this->db->get_first();
    }
}
