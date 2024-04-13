<?php

class Diskon extends JI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load("diskon_model", "dm");
        $this->load("produk_model", "prm");
        $this->lib("sene_json_engine", "sene_json");
    }

    public function index()
    {
        $data = $this->__init();
        $data["active"] = "diskon";

        if (!$this->is_login() or $this->is_admin()) {
            redir(base_url());
        }

        $this->putJsReady("diskon/home.bottom", $data);
        $this->putThemeContent("diskon/home", $data);
        $this->loadLayout("col-1", $data);
        $this->render();
    }

    public function search()
    {
        $data = $this->__init();
        if (!$this->is_login() AND $this->is_admin()) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }

        $q = $_GET["q"] ?? "";
        $res = $this->prm->src($q);

        http_response_code(200);
        $this->status = 200;
        $this->message = "Data retrivied";
        $this->__json_out($res);
    }

    public function read()
    {
        $data = $this->__init();
        if (!$this->is_login() AND $this->is_admin()) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }

        $req = $this->__datatablesRequest();
        $dt = $this->dm->read($req);
        $count = $this->dm->count()->total;
        $addon = array();
        $addon["recordsFiltered"] = $count;
        $addon["recordsTotal"] = $count;
        http_response_code(200);
        $this->status = 200;
        $this->message = "Data retrivied";
        $this->__json_out($dt, $addon);
    }


}
