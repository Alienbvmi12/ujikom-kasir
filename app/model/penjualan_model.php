<?php

class Penjualan_Model extends JI_Model
{
    public $tbl = "transaksi";
    public $tbl_as = "trs";
    public $tbl2 = "transaksi_detail";
    public $tbl2_as = "trsd";
    public $tbl3 = "user";
    public $tbl3_as = "ussr";
    public $tbl4 = "admin";
    public $tbl4_as = "adm";
    public $columns = [
        "id",
        "tanggal_transaksi",
        "total",
        "kasir",
        "id"
    ];
    public $columns2 = [
        "date",
        "omset"
    ];

    public function __construct()
    {
        parent::__construct();
        $this->db->from($this->tbl, $this->tbl_as);
    }

    private function __search($q)
    {
        if (strlen($q) > 0) {
            $this->db->where_as("$this->tbl_as.id", $q, "OR", "%like%", 1, 0);
            $this->db->where_as("$this->tbl_as.tanggal_transaksi", $q, "OR", "%like%", 0, 0);
            // $this->db->where_as("$this->tbl2_as.harga_satuan * $this->tbl2_as.qty", $q, "OR", "%like%", 0, 0);
            $this->db->where_as("$this->tbl_as.subtotal_harga - ($this->tbl_as.subtotal_harga * (if($this->tbl_as.diskon is null, 0, $this->tbl_as.diskon) / 100))", $q, "OR", "%like%", 0, 0);
            $this->db->where_as("CONCAT($this->tbl_as.user_id, ' - ' , $this->tbl3_as.nama)", $q, "OR", "%like%", 0, 1);
        }
    }

    private function __search2($q)
    {
        if (strlen($q) > 0) {
            $this->db->where_as("CONCAT(year($this->tbl_as.tanggal_transaksi), ', ', month($this->tbl_as.tanggal_transaksi))", $q, "OR", "%like%", 1, 0);
            // $this->db->where_as("SUM($this->tbl2_as.harga_satuan * $this->tbl2_as.qty)", $q, "OR", "%like%", 0, 1);
            $this->db->where_as("SUM($this->tbl_as.subtotal_harga - ($this->tbl_as.subtotal_harga * (if($this->tbl_as.diskon is null, 0, $this->tbl_as.diskon) / 100)))", $q, "OR", "%like%", 0, 1);
        }
    }

    public function count($from, $until)
    {
        $this->db->from($this->tbl, $this->tbl_as);
        $this->db->select_as("COUNT(*)", "total");

        $this->db->where("$this->tbl_as.tanggal_transaksi", $from, "AND", ">=");
        $this->db->where("$this->tbl_as.tanggal_transaksi", $until, "AND", "<=");
        return $this->db->get_first();
    }

    public function count_omset($from, $until)
    {
        $this->db->from($this->tbl, $this->tbl_as);
        $this->db->select_as("$this->tbl_as.tanggal_transaksi", "tanggal_transaksi");

        $this->db->where("$this->tbl_as.tanggal_transaksi", $from, "AND", ">=");
        $this->db->where("$this->tbl_as.tanggal_transaksi", $until, "AND", "<=");
        $this->db->group_by("month($this->tbl_as.tanggal_transaksi)");
        $res = $this->db->get();
        $rcount = count($res);
        $dt = new stdClass();
        $dt->total = $rcount;
        return $dt;
    }

    public function read(stdClass $data, string $from, string $until, bool $is_laporan = false)
    {
        $this->db->select_as("$this->tbl_as.id", "id");
        $this->db->select_as("$this->tbl_as.tanggal_transaksi", "tanggal_transaksi");
        // $this->db->select_as("SUM($this->tbl2_as.harga_satuan * $this->tbl2_as.qty)", "total");
        $this->db->select_as("$this->tbl_as.subtotal_harga - ($this->tbl_as.subtotal_harga * (if($this->tbl_as.diskon is null, 0, $this->tbl_as.diskon) / 100))", "total");
        $this->db->select_as("CONCAT($this->tbl_as.user_id, ' - ' , $this->tbl3_as.nama)", "kasir");
        $this->db->select_as("CONCAT($this->tbl_as.admin_id, 'A - ' , $this->tbl4_as.nama)", "kasir2");
        $this->db->join($this->tbl2, $this->tbl2_as, "transaksi_id", $this->tbl_as, "id", "left");
        $this->db->join($this->tbl3, $this->tbl3_as, "id", $this->tbl_as, "user_id", "left");
        $this->db->join($this->tbl4, $this->tbl4_as, "id", $this->tbl_as, "admin_id", "left");

        $this->db->where("$this->tbl_as.tanggal_transaksi", $from, "AND", ">=");
        $this->db->where("$this->tbl_as.tanggal_transaksi", $until, "AND", "<=");

        if (!$is_laporan) {
            $this->__search($data->search);
            $this->db->order_by($this->columns[$data->column], $data->dir);
            $this->db->limit($data->start, $data->length);
        }

        $this->db->group_by("$this->tbl_as.id");
        return $this->db->get();
    }

    public function omset(stdClass $data, string $from, string $until, bool $is_laporan = false)
    {
        $this->db->select_as("CONCAT(month($this->tbl_as.tanggal_transaksi), ', ', year($this->tbl_as.tanggal_transaksi))", "date");
        // $this->db->select_as("SUM($this->tbl2_as.harga_satuan * $this->tbl2_as.qty)", "omset");
        $this->db->select_as("SUM($this->tbl_as.subtotal_harga - if($this->tbl_as.diskon is null, '0', ($this->tbl_as.subtotal_harga * ( $this->tbl_as.diskon / 100))))", "omset");
        // $this->db->join($this->tbl2, $this->tbl2_as, "transaksi_id", $this->tbl_as, "id", "inner");

        $this->db->where("$this->tbl_as.tanggal_transaksi", $from, "AND", ">=");
        $this->db->where("$this->tbl_as.tanggal_transaksi", $until, "AND", "<=");

        if (!$is_laporan) {
            $this->__search2($data->search);
            $this->db->order_by($this->columns2[$data->column], $data->dir);
            $this->db->limit($data->start, $data->length);
        }

        $this->db->group_by("month($this->tbl_as.tanggal_transaksi)");
        return $this->db->get();
    }
}
