<?php

class Transaksi_Model extends JI_Model{
    public $tbl = "transaksi";
    public $tbl_as = "trs";

    public function __construct(){
        parent::__construct();
        $this->db->from($this->tbl, $this->tbl_as);
    }

    public function count(){
        $this->db->select_as("COUNT(*)", "total");
        return $this->db->get_first();
    }

    public function countTransaksiByDate($date){
        $this->db->select_as("COUNT(*)", "total");
        $this->db->where("$this->tbl_as.tanggal_transaksi", $date, "AND", "=");
        return $this->db->get_first();
    }
}