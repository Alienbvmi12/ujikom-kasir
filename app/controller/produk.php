<?php

class Produk extends JI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load("produk_model", "prm");
    }

    public function index()
    {
        $data = $this->__init();
        if (!$this->is_login() or !$this->is_admin()) {
            redir(base_url());
        }

        $data["active"] = "produk";

        $this->putJSReady("produk/home.bottom", $data);
        $this->putThemeContent("produk/home", $data);
        $this->loadLayout("col-1", $data);
        $this->render();
    }

    public function read()
    {
        $data = $this->__init();
        if (!$this->is_login()) {
            redir(base_url());
        }
        $req = $this->__datatablesRequest();
        $dt = $this->prm->read($req);
        $count = $this->prm->count()->total;
        $adi = array();
        $adi["recordsTotal"] = $count;
        $adi["recordsFiltered"] = $count;
        $this->status = 200;
        $this->message = "Success";
        $this->__json_out($dt, $adi);
    }

    public function create()
    {
        $data = $this->__init();
        $req = $_POST;

        if (!$this->is_login()) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }

        $vald = $this->prm->validate($req, "insert", [
            "nama_produk" => ["required", "max:255"],
            "harga" => ["required", "max:13"],
            "stok" => ["required", "max:11"]
        ]);

        if (!$vald["result"]) {
            http_response_code(422);
            $this->status = 422;
            $this->message = $vald["message"];
            $this->__json_out([]);
        }

        $last_id = $this->prm->get_last()->id;
        $id_num = intval(str_replace("BRG", "", strtoupper($last_id))) + 1;
        $cos_tam = "";

        if ($id_num >= 0 and $id_num < 10) {
            $cos_tam = "000";
        } elseif ($id_num >= 10 and $id_num < 100) {
            $cos_tam = "00";
        } elseif ($id_num >= 100 and $id_num < 1000) {
            $cos_tam = "0";
        } elseif ($id_num >= 1000 and $id_num < 10000) {
            $cos_tam = "";
        } else {
            http_response_code(422);
            $this->status = 422;
            $this->message = "Data Produk Sudah Penuh!!!";
            $this->__json_out([]);
        }

        $cos_tam = "BRG" . $cos_tam . $id_num;
        $req["id"] = $cos_tam;

        try {
            $this->prm->set($req);
            http_response_code(200);
            $this->status = 200;
            $this->message = "Berhasil menambahkan data petugas!!";
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
        if (!$this->is_login()) {
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
            $this->prm->del($id);
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

    public function edit()
    {
        $data = $this->__init();
        $req = $_POST;

        if (!$this->is_login()) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }

        $vald = $this->prm->validate($req, "update", [
            "id" => ["required"],
            "nama_produk" => ["required", "max:255"],
            "harga" => ["required", "max:13"],
            "stok" => ["required", "max:11"]
        ]);

        if (!$vald["result"]) {
            http_response_code(422);
            $this->status = 422;
            $this->message = $vald["message"];
            $this->__json_out([]);
        }

        try {
            $this->prm->update($req["id"], $req);
            http_response_code(200);
            $this->status = 200;
            $this->message = "Berhasil mengedit data produk!!";
            $this->__json_out($req);
        } catch (Exception $e) {
            http_response_code(500);
            $this->status = 500;
            $this->message = "Internal server error";
            $this->__json_out([]);
        }
    }
}
