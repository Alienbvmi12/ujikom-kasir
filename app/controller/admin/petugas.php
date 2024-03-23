<?php

class Petugas extends JI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load("petugas_model", "pm");
    }

    public function index()
    {
        $data = $this->__init();
        if (!$this->is_login() OR !$this->is_admin()) {
            redir(base_url());
        }
        
        $data["active"] = "petugas";

        $this->putJSReady("petugas/home.bottom", $data);
        $this->putThemeContent("petugas/home", $data);
        $this->loadLayout("col-1", $data);
        $this->render();
    }

    public function read()
    {
        $data = $this->__init();
        if (!$this->is_login() AND !$this->is_admin()) {
            redir(base_url());
        }
        $req = $this->__datatablesRequest();
        $dt = $this->pm->read($req);
        $count = $this->pm->count()->total;
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

        if (!$this->is_login() AND !$this->is_admin()) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }

        $vald = $this->pm->validate($req, "insert", [
            "nama" => ["required", "max:255"],
            "username" => ["required", "max:50", "unique"],
            "email" => ["required", "max:50", "email", "unique"],
            "password" => ["required", "min:6", "max:50"],
            "konfirmasi_password" => ["required", "min:6", "max:50"],
            "status" => ["required"]
        ]);

        if (!$vald["result"]) {
            http_response_code(422);
            $this->status = 422;
            $this->message = $vald["message"];
            $this->__json_out([]);
        }

        if ($req["konfirmasi_password"] !== $req["password"]) {
            http_response_code(422);
            $this->status = 422;
            $this->message = "Password tidak sama!!";
            $this->__json_out([]);
        }

        $req["password"] = password_hash($req["password"], PASSWORD_BCRYPT);

        unset($req["konfirmasi_password"]);
        try {
            $req["role"] = "1";
            $this->pm->set($req);
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
        if (!$this->is_login() AND !$this->is_admin()) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }

        if($id == "" or $id == "0" or $id == null){
            http_response_code(422);
            $this->status = 422;
            $this->message = "ID Undefined";
            $this->__json_out([]);
        }

        try {
            $this->pm->delete($id);
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

        if (!$this->is_login() AND !$this->is_admin()) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }

        $vald = $this->pm->validate($req, "update", [
            "id" => ["required"],
            "nama" => ["required", "max:255"],
            "username" => ["required", "max:50", "unique"],
            "email" => ["required", "max:50", "email", "unique"],
            "status" => ["required"]
        ]);

        if (!$vald["result"]) {
            http_response_code(422);
            $this->status = 422;
            $this->message = $vald["message"];
            $this->__json_out([]);
        }

        if ($req["password"] != "") {
            $vald = $this->pm->validate($req, "update", [
                "password" => ["required", "min:6", "max:50"],
                "konfirmasi_password" => ["required", "min:6", "max:50"]
            ]);

            if (!$vald["result"]) {
                http_response_code(422);
                $this->status = 422;
                $this->message = $vald["message"];
                $this->__json_out([]);
            }

            if ($req["konfirmasi_password"] !== $req["password"]) {
                http_response_code(422);
                $this->status = 422;
                $this->message = "Password tidak sama!!";
                $this->__json_out([]);
            }

            $req["password"] = password_hash($req["password"], PASSWORD_BCRYPT);
        }
        else{
            unset($req["password"]);
        }

        unset($req["konfirmasi_password"]);

        try {
            $req["role"] = "1";
            $this->pm->update($req["id"], $req);
            http_response_code(200);
            $this->status = 200;
            $this->message = "Berhasil mengedit data petugas!!";
            $this->__json_out($req);
        } catch (Exception $e) {
            http_response_code(500);
            $this->status = 500;
            $this->message = "Internal server error";
            $this->__json_out([]);
        }
    }
}
