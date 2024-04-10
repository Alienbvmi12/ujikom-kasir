<?php

class Laporan extends JI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load("transaksi_model", "tm");
        $this->load("produk_model", "pm");
    }

    public function stok()
    {
        $data = $this->__init();

        if (!$this->is_login()) {
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }

        $data["produk"] = $this->pm->get();

        $this->putThemeContent("laporan/stok", $data);
        $this->loadLayout("plain", $data);
        $this->render();
    }
}
