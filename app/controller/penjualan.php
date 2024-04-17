<?php

class Penjualan extends JI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load("penjualan_model", "pnm");
    }

    public function index()
    {
        $data = $this->__init();
        if (!$this->user_login ) {
            redir(base_url());
        }
        $data["active"] = "laporan";

        $this->putJSReady("penjualan/home.bottom", $data);
        $this->putThemeContent("penjualan/home", $data);
        $this->loadLayout("col-1", $data);
        $this->render();
    }

    public function read($from = "", $until = "")
    {
        $data = $this->__init();
        if (!$this->user_login ) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }
        $req = $this->__datatablesRequest();
        if ($from == "" || $until == "") {
            $dt = [];
            $adi = array();
            $adi["recordsTotal"] = 0;
            $adi["recordsFiltered"] = 0;
            $this->status = 200;
            $this->message = "Success";
            $this->__json_out($dt, $adi);
        } else {
            $dt = $this->pnm->read($req, $from, $until);
            $count = $this->pnm->count($from, $until)->total;
            $adi = array();
            $adi["recordsTotal"] = $count;
            $adi["recordsFiltered"] = $count;
            $this->status = 200;
            $this->message = "Success";
            $this->__json_out($dt, $adi);
        }
    }
}