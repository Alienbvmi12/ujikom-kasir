<?php

class Transaksi extends JI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load("transaksi_model", "tm");
        $this->load("produk_model", "pm");
        $this->load("member_model", "mm");
        $this->load("diskon_model", "dm");
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

    public function __api_produk()
    {
        $data = $this->__init();
        if (!$this->is_login()) {
            if (!$this->is_login()) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }
        }

        $q = $_GET["q"] ?? "";
        $res = $this->pm->src_trans($q);

        http_response_code(200);
        $this->status = 200;
        $this->message = "Data retrivied";
        $this->__json_out($res);
    }

    public function __api_member()
    {
        $data = $this->__init();
        if (!$this->is_login()) {
            if (!$this->is_login()) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }
        }

        $q = $_GET["q"] ?? "";
        $res = $this->mm->src($q);

        http_response_code(200);
        $this->status = 200;
        $this->message = "Data retrivied";
        $this->__json_out($res);
    }

    public function __api_diskon_produk()
    {
        $data = $this->__init();
        if (!$this->is_login()) {
            if (!$this->is_login()) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }
        }

        $q = $_GET["q"] ?? "";
        $res = $this->dm->src_produk($q);

        http_response_code(200);
        $this->status = 200;
        $this->message = "Data retrivied";
        $this->__json_out($res);
    }

    public function __api_diskon_transaksi()
    {
        $data = $this->__init();
        if (!$this->is_login()) {
            if (!$this->is_login()) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }
        }

        $q = $_GET["q"] ?? "";
        $res = $this->dm->src_member($q);

        http_response_code(200);
        $this->status = 200;
        $this->message = "Data retrivied";
        $this->__json_out($res);
    }
}
