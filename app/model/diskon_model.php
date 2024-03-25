<?php

class Diskon_Model extends JI_Model{
    public $tbl = "diskon";
    public $tbl_as = "dsc";
    public $tbl2 = "produk";
    public $tbl2_as = "prd";
    public $columns = [
        "id",
        "diskon",
        "deskripsi",
        "type",
        "nama_produk",
        "minimum_transaksi",
        "expired_date",
        "id",
    ];

    public function __construct(){
        parent::__construct();
        $this->db->from($this->tbl, $this->tbl_as);
    }

    private function __search($q){
        if(strlen($q) > 0){
            $this->db->where("id", $q, "OR", "%like%", 1, 0);
            $this->db->where("diskon", $q, "OR", "%like%", 0, 0);
            $this->db->where("deskripsi", $q, "OR", "%like%", 0, 0);
            $this->db->where("type", $q, "OR", "%like%", 0, 0);
            $this->db->where("nama_produk", $q, "OR", "%like%", 0, 0);
            $this->db->where("minimum_transaksi", $q, "OR", "%like%", 0, 0);
            $this->db->where("expired_date", $q, "OR", "%like%", 0, 1);
        }
    }

    public function read(stdClass $data){
        $this->db->select_as("$this->tbl.id", "id");
        $this->db->select_as("$this->tbl.diskon", "diskon");
        $this->db->select_as("$this->tbl.deskripsi", "deskripsi");
        $this->db->select_as("$this->tbl.type", "type");
        $this->db->select_as("$this->tbl2.nama_produk", "nama_produk");
        $this->db->select_as("$this->tbl.minimum_transaksi", "minimum_transaksi");
        $this->db->select_as("$this->tbl.expired_date", "expired_date");

        $this->db->join($this->tbl2, $this->tbl2_as, "id", $this->tbl_as, "produk_id", "left");

        $this->__search($data->search);
        $this->db->order_by($this->columns[$data->column], $data->dir);
        $this->db->limit($data->start, $data->length);
        return $this->db->get();
    }

    public function count(){
        $this->db->select_as("COUNT(*)", "total");
        return $this->db->get_first();
    }

}