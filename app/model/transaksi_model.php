<?php

class Transaksi_Model extends JI_Model
{
    public $tbl = "transaksi";
    public $tbl_as = "trs";
    public $tbl2 = "transaksi_detail";
    public $tbl2_as = "trsd";
    public $tbl3 = "produk";
    public $tbl3_as = "prd";
    public $tbl4 = "diskon";
    public $tbl4_as = "dsk";
    public $tbl5 = "user";
    public $tbl5_as = "ussr";
    public $tbl6 = "member";
    public $tbl6_as = "member";
    public $tbl7 = "admin";
    public $tbl7_as = "adm";

    public function __construct()
    {
        parent::__construct();
        $this->db->from($this->tbl, $this->tbl_as);
    }

    public function count()
    {
        $this->db->select_as("COUNT(*)", "total");
        return $this->db->get_first();
    }

    public function count_terjual()
    {
        $this->db->from($this->tbl2, $this->tbl2_as);
        $this->db->select_as("SUM($this->tbl2_as.qty)", "total");
        return $this->db->get_first();
    }

    public function countTransaksiByDate($date)
    {
        $this->db->select_as("COUNT(*)", "total");
        $this->db->where("$this->tbl_as.tanggal_transaksi", $date, "AND", "=");
        return $this->db->get_first();
    }

    public function get($id)
    {
        $this->db->select_as("$this->tbl_as.id", "no_transaksi");
        $this->db->select_as("$this->tbl_as.tanggal_transaksi", "tanggal_transaksi");
        $this->db->select_as("$this->tbl_as.user_id", "user_id");
        $this->db->select_as("$this->tbl5_as.nama", "user_nama");
        $this->db->select_as("$this->tbl_as.admin_id", "admin_id");
        $this->db->select_as("$this->tbl7_as.nama", "admin_nama");
        $this->db->select_as("$this->tbl_as.member_id", "member_id");
        $this->db->select_as("$this->tbl6_as.nama", "member_nama");
        $this->db->select_as("$this->tbl_as.diskon_id", "diskon_id");
        $this->db->select_as("$this->tbl_as.diskon", "diskon");
        $this->db->select_as("$this->tbl_as.cash", "cash");
        $this->db->select_as("$this->tbl4_as.minimum_transaksi", "minimum_transaksi");
        $this->db->join($this->tbl5, $this->tbl5_as, "id", $this->tbl_as, "user_id", "left");
        $this->db->join($this->tbl7, $this->tbl7_as, "id", $this->tbl_as, "admin_id", "left");
        $this->db->join($this->tbl6, $this->tbl6_as, "id", $this->tbl_as, "member_id", "left");
        $this->db->join($this->tbl4, $this->tbl4_as, "id", $this->tbl_as, "diskon_id", "left");
        $this->db->where("$this->tbl_as.id", $id);
        return $this->db->get_first();
    }

    public function get_detail($no_transaksi)
    {
        $this->db->from($this->tbl2, $this->tbl2_as);
        $this->db->select_as("$this->tbl2_as.produk_id", "produk_id");
        $this->db->select_as("$this->tbl3_as.nama_produk", "nama_produk");
        $this->db->select_as("$this->tbl2_as.harga_satuan", "harga_satuan");
        $this->db->select_as("$this->tbl2_as.qty", "qty");
        $this->db->join($this->tbl3, $this->tbl3_as, "id", $this->tbl2_as, "produk_id", "left");
        $this->db->where("$this->tbl2_as.transaksi_id", $no_transaksi);
        return $this->db->get();
    }

    public function insert_detail($data)
    {
        $this->db->insert($this->tbl2, $data);
        return $this->db->last_id;
    }
}
