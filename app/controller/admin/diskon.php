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

        if (!$this->is_login() or !$this->is_admin()) {
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
        if (!$this->is_login() or !$this->is_admin()) {
            redir(base_url());
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
        if (!$this->is_login() or !$this->is_admin()) {
            redir(base_url());
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

    public function create()
    {
        $data = $this->__init();
        $req = $_POST;
        if (!$this->is_login() or !$this->is_admin()) {
            redir(base_url());
        }

        $vald = $this->dm->validate($req, "insert", [
            "diskon" => ['required', 'max:3'],
            "deskripsi" => ['required'],
            "type" => ['required'],
            "expired_date" => ['required', "max:10", "min:10", "as: Tanggal Kadaluarsa"]
        ]);

        if (!$vald["result"]) {
            http_response_code(422);
            $this->status = 422;
            $this->message = $vald["message"];
            $this->__json_out([]);
        }

        if ($req["type"] == "0") {
            $vald = $this->dm->validate($req, "insert", [
                "produk_id" => ['required', 'max:7', "as: Produk"]
            ]);
            unset($req["minimum_transaksi"]);
        } else {
            $vald = $this->dm->validate($req, "insert", [
                "minimum_transaksi" => ['required', 'max:13', "as: Minimum Transaksi"]
            ]);
            unset($req["produk_id"]);
        }

        if (!$vald["result"]) {
            http_response_code(422);
            $this->status = 422;
            $this->message = $vald["message"];
            $this->__json_out([]);
        }


        try {
            $this->dm->set($req);
            http_response_code(200);
            $this->status = 200;
            $this->message = "Berhasil menambahkan diskon baru!!";
            $this->__json_out($req);
        } catch (Exception $e) {
            http_response_code(500);
            $this->status = 500;
            $this->message = "Internal server error";
            $this->__json_out([]);
        }
    }

    public function edit()
    {
        $data = $this->__init();
        $req = $_POST;
        if (!$this->is_login() or !$this->is_admin()) {
            redir(base_url());
        }

        $vald = $this->dm->validate($req, "update", [
            "id" => ["required"],
            "diskon" => ['required', 'max:3'],
            "deskripsi" => ['required'],
            "type" => ['required'],
            "expired_date" => ['required', "max:10", "min:10", "as: Tanggal Kadaluarsa"]
        ]);

        if (!$vald["result"]) {
            http_response_code(422);
            $this->status = 422;
            $this->message = $vald["message"];
            $this->__json_out([]);
        }

        if ($req["type"] == "0") {
            $vald = $this->dm->validate($req, "update", [
                "produk_id" => ['required', 'max:7', "as: Produk"]
            ]);
            unset($req["minimum_transaksi"]);
        } else {
            $vald = $this->dm->validate($req, "update", [
                "minimum_transaksi" => ['required', 'max:13', "as: Minimum Transaksi"]
            ]);
            unset($req["produk_id"]);
        }

        if (!$vald["result"]) {
            http_response_code(422);
            $this->status = 422;
            $this->message = $vald["message"];
            $this->__json_out([]);
        }

        try {
            $this->dm->update($req["id"], $req);
            http_response_code(200);
            $this->status = 200;
            $this->message = "Berhasil mengedit diskon!!";
            $this->__json_out($req);
        } catch (Exception $e) {
            http_response_code(500);
            $this->status = 500;
            $this->message = "Internal server error";
            $this->__json_out([]);
        }
    }

    public function delete($id)
    {
        $data = $this->__init();
        if (!$this->is_login() and !$this->is_admin()) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }

        if ($id == "" or $id == "0" or $id == null) {
            http_response_code(422);
            $this->status = 422;
            $this->message = "ID Undefined";
            $this->__json_out([]);
        }

        try {
            $this->dm->del($id);
            http_response_code(200);
            $this->status = 200;
            $this->message = "Hapus data berhasil!!";
            $this->__json_out([]);
        } catch (Exception $e) {
            http_response_code(500);
            $this->status = 500;
            $this->message = "Internal server error";
            $this->__json_out([]);
        }
    }

    public function get_by_id($id)
    {
        $data = $this->__init();
        if (!$this->is_login() and !$this->is_admin()) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }

        if ($id == "" or $id == "0" or $id == null) {
            http_response_code(422);
            $this->status = 422;
            $this->message = "ID Undefined";
            $this->__json_out([]);
        }

        $res = $this->dm->id($id);

        http_response_code(200);
        $this->status = 200;
        $this->message = "Data retrivied successfully";
        $this->__json_out($res);
    }
}
