<?php

class Produk_Model extends JI_Model
{
    public $tbl = "produk";
    public $tbl_as = "prd";
    public $tbl2 = "diskon";
    public $tbl2_as = "disc";
    public $columns = [
        "id",
        "nama_produk",
        "harga",
        "stok",
        "id"
    ];

    public function __construct()
    {
        parent::__construct();
        $this->db->from($this->tbl, $this->tbl_as);
    }

    private function __search($q)
    {
        if (strlen($q) > 0) {
            $this->db->where("id", $q, "OR", "%like%", 1, 0);
            $this->db->where("nama_produk", $q, "OR", "%like%", 0, 0);
            $this->db->where("harga", $q, "OR", "%like%", 0, 0);
            $this->db->where("stok", $q, "OR", "%like%", 0, 1);
        }
    }

    public function read(stdClass $data)
    {
        $this->__search($data->search);
        $this->db->order_by($this->columns[$data->column], $data->dir);
        $this->db->limit($data->start, $data->length);
        return $this->db->get();
    }

    public function count()
    {
        $this->db->select_as("COUNT(*)", "total");
        return $this->db->get_first();
    }

    public function get_last()
    {
        $this->db->order_by("id", "desc");
        $this->db->limit("0", "1");
        return $this->db->get_first();
    }

    public function src($q = "")
    {
        $this->db->select_as("$this->tbl_as.id", "id");
        $this->db->select_as("CONCAT($this->tbl_as.id, ' - ', $this->tbl_as.nama_produk)", "text");
        $this->db->where_as("CONCAT($this->tbl_as.id, ' - ', $this->tbl_as.nama_produk)", $q, "AND", "%like%", 0, 0);
        $this->db->limit("0", "15");
        return $this->db->get();
    }

    public function src_trans($q = "")
    {
        $this->db->select_as("CONCAT($this->tbl_as.id, '|', $this->tbl_as.harga)", "id");
        $this->db->select_as("CONCAT($this->tbl_as.id, ' - ', $this->tbl_as.nama_produk)", "text");
        $this->db->where_as("CONCAT($this->tbl_as.id, ' - ', $this->tbl_as.nama_produk)", $q, "AND", "%like%", 0, 0);
        $this->db->limit("0", "15");
        return $this->db->get();
    }

    public function src_produk_diskon($id)
    {
        $this->db->select_as("$this->tbl_as.id", "id");
        $this->db->select_as("$this->tbl_as.nama_produk", "produk");
        $this->db->select_as("$this->tbl_as.harga", "harga_satuan");
        $this->db->select_as("$this->tbl_as.stok", "stok");
        $this->db->select_as("$this->tbl2_as.id", "diskon_id");
        $this->db->select_as("$this->tbl2_as.diskon", "diskon");

        $this->db->join($this->tbl2, $this->tbl2_as, "produk_id", $this->tbl_as, "id", "left");
        $this->db->where("$this->tbl_as.id", $id);
        $this->db->order_by("$this->tbl2_as.expired_date", "asc");
        return $this->db->get_first();
    }
}
