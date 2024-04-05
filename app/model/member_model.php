<?php

class Member_Model extends JI_Model{
    public $tbl = "member";
    public $tbl_as = "mber";
    public $columns = [
        "id",
        "nik",
        "nama",
        "nomor_telepon",
        "alamat",
        "tanggal_registrasi",
        "status",
        "id"
    ];

    public function __construct(){
        parent::__construct();
        $this->db->from($this->tbl, $this->tbl_as);
    }

    private function __search($q){
        if(strlen($q) > 0){
            $this->db->where("id", $q, "OR", "%like%", 1, 0);
            $this->db->where("nik", $q, "OR", "%like%", 0, 0);
            $this->db->where("nama", $q, "OR", "%like%", 0, 0);
            $this->db->where("nomor_telepon", $q, "OR", "%like%", 0, 0);
            $this->db->where("alamat", $q, "OR", "%like%", 0, 0);
            $this->db->where("tanggal_registrasi", $q, "OR", "%like%", 0, 1);
        }
    }

    public function read(stdClass $data){
        $this->__search($data->search);
        $this->db->order_by($this->columns[$data->column], $data->dir);
        $this->db->limit($data->start, $data->length);
        return $this->db->get();
    }

    public function count(){
        $this->db->select_as("COUNT(*)", "total");
        return $this->db->get_first();
    }

    public function src($q){
        $this->db->select_as("$this->tbl_as.id", "id");
        $this->db->select_as("CONCAT($this->tbl_as.id, ' - ', $this->tbl_as.nama)", "text");
        $this->db->where_as("CONCAT($this->tbl_as.id, ' - ', $this->tbl_as.nama)", $q, "AND", "%like%");
        $this->db->limit("0", "15");
        return $this->db->get();
    }
}