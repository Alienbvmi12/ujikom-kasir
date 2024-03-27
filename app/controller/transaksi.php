<?php

class Transaksi extends JI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load("transaksi_model", "tm");
    }

    public function index()
    {
        $data = $this->__init();
        $data["active"] = "transaksi";

        if (!$this->is_login()) {
            redir(base_url());
        }

        $this->putJsReady("transaksi/home.bottom", $data);
        $this->putThemeContent("transaksi/home", $data);
        $this->loadLayout("col-1", $data);
        $this->render();
    }
}
