<?php

class Member extends JI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load("member_model", "mm");
    }

    public function index()
    {
        $data = $this->__init();
        $data["active"] = "member";

        if (!$this->is_login()) {
            redir(base_url());
        }

        $this->putJsReady("member/admin.bottom", $data);
        $this->putThemeContent("member/admin", $data);
        $this->loadLayout("col-1", $data);
        $this->render();
    }

    public function read()
    {
        $data = $this->__init();
        if (!$this->is_login() or !$this->is_admin()) {
            redir(base_url());
        }

        $req = $this->__datatablesRequest();
        $dt = $this->mm->read($req);
        $count = $this->mm->count()->total;
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

        $vald = $this->mm->validate($req, "insert", [
            "nik" => ['required', 'min:16', 'max:20', "unique"],
            "nama" => ['required', 'max:255'],
            "nomor_telepon" => ['required', 'min:10', 'max:15'],
            "alamat" => ['required', 'min:3'],
            "tanggal_registrasi" => ['required', "max:10"],
            "status" => ['required', "max:1"]
        ]);

        if (!$vald["result"]) {
            http_response_code(422);
            $this->status = 422;
            $this->message = $vald["message"];
            $this->__json_out([]);
        }

        try {
            $this->mm->set($req);
            http_response_code(200);
            $this->status = 200;
            $this->message = "Berhasil menambahkan member baru!!";
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

        $vald = $this->mm->validate($req, "update", [
            "id" => ['required'],
            "nik" => ['required', 'min:16', 'max:20', "unique"],
            "nama" => ['required', 'max:255'],
            "nomor_telepon" => ['required', 'min:10', 'max:15'],
            "alamat" => ['required', 'min:3'],
            "tanggal_registrasi" => ['required', "max:10"],
            "status" => ['required', "max:1"]
        ]);

        if (!$vald["result"]) {
            http_response_code(422);
            $this->status = 422;
            $this->message = $vald["message"];
            $this->__json_out([]);
        }

        try {
            $this->mm->update($req["id"], $req);
            http_response_code(200);
            $this->status = 200;
            $this->message = "Berhasil mengedit member!!";
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
            $this->mm->del($id);
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
}