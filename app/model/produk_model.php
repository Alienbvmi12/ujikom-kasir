<?php

class Produk_Model extends JI_Model{
    public $tbl = "produk";
    public $tbl_as = "prd";
    public $columns = [
        "id",
        "nama_produk",
        "harga",
        "stok",
        "id"
    ];

    public function __construct(){
        parent::__construct();
        $this->db->from($this->tbl, $this->tbl_as);
    }

    private function __search($q){
        if(strlen($q) > 0){
            $this->db->where("id", $q, "OR", "%like%", 1, 0);
            $this->db->where("nama_produk", $q, "OR", "%like%", 0, 0);
            $this->db->where("harga", $q, "OR", "%like%", 0, 0);
            $this->db->where("stok", $q, "OR", "%like%", 0, 1);
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

    public function get_last(){
        $this->db->order_by("id", "desc");
        $this->db->limit("0", "1");
        return $this->db->get_first();
    }
}