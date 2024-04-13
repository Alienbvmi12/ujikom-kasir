<?php

class Laporan extends JI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load("penjualan_model", "pjm");
        $this->load("transaksi_model", "tm");
        $this->load("produk_model", "pm");
    }

    public function stok()
    {
        $data = $this->__init();

        if (!$this->is_login() or $this->is_admin()) {
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }

        $data["produk"] = $this->pm->get();

        $this->putThemeContent("laporan/stok", $data);
        $this->loadLayout("plain", $data);
        $this->render();
    }

    public function struk($no_transaksi)
    {
        $data = $this->__init();

        if (!$this->is_login() or $this->is_admin()) {
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }

        $data["transaksi_header"] = $this->tm->get($no_transaksi);
        $data["transaksi_detail"] = $this->tm->get_detail($no_transaksi);


        $this->putThemeContent("laporan/struk", $data);
        $this->loadLayout("plain", $data);
        $this->render();
    }
}
