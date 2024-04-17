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
            $this->db->where("$this->tbl_as.id", $q, "OR", "%like%", 1, 0);
            $this->db->where("diskon", $q, "OR", "%like%", 0, 0);
            $this->db->where("deskripsi", $q, "OR", "%like%", 0, 0);
            $this->db->where("minimum_transaksi", $q, "OR", "%like%", 0, 0);
            $this->db->where("expired_date", $q, "OR", "%like%", 0, 1);
        }
    }

    public function read(stdClass $data){
        $this->db->select_as("$this->tbl_as.id", "id");
        $this->db->select_as("$this->tbl_as.diskon", "diskon");
        $this->db->select_as("$this->tbl_as.deskripsi", "deskripsi");
        $this->db->select_as("$this->tbl_as.minimum_transaksi", "minimum_transaksi");
        $this->db->select_as("$this->tbl_as.expired_date", "expired_date");

        $this->db->where("$this->tbl_as.is_deleted", "1", "AND", "<>"); // is deleted

        $this->__search($data->search);
        $this->db->order_by($this->columns[$data->column], $data->dir);
        $this->db->limit($data->start, $data->length);
        return $this->db->get();
    }

    public function count(){
        $this->db->from($this->tbl, $this->tbl_as);
        $this->db->select_as("COUNT(*)", "total");
        $this->db->where("$this->tbl_as.is_deleted", "1", "AND", "<>");
        return $this->db->get_first();
    }

    public function src_member($q){
        $this->db->select_as("$this->tbl_as.id", "id");
        $this->db->select_as("$this->tbl_as.diskon", "diskon");
        $this->db->where("$this->tbl_as.is_deleted", "1", "AND", "<>"); // is deleted
        $this->db->where_as("$this->tbl_as.minimum_transaksi", $q, "AND", "<=");
        $this->db->where("$this->tbl_as.expired_date", date("Y-m-d"), "AND", ">");
        $this->db->order_by("$this->tbl_as.minimum_transaksi", "desc");
        return $this->db->get_first();
    }
}
