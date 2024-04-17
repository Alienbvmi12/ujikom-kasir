<?php

class Admin_Model extends JI_Model{

    public $tbl = "admin";
    public $tbl_as = "adm";

    public function __construct(){
        parent::__construct();
        $this->db->from($this->tbl, $this->tbl_as);
    }

    public function get_by_id($id){    
        $this->db->where("id", $id);
    }

    public function auth($email){
        $this->db->where("email", $email, "OR", "=", 1, 0);
        $this->db->where("username", $email, "OR", "=", 0, 1);
        return $this->db->get_first();
    }
}
