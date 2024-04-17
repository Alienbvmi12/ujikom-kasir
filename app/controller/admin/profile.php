<?php

class Profile extends JI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load("user_model", "um");
        $this->setTheme("admin");
    }

    public function index()
    {
        $data = $this->__init();
        if (!$this->admin_login) {
            redir(base_url_admin());
        }

        $data["active"] = "profile";

        $this->putJSReady("profile/home.bottom", $data);
        $this->putThemeContent("profile/home", $data);
        $this->loadLayout("col-1", $data);
        $this->render();
    }

    public function edit()
    {
        $data = $this->__init();
        $req = $_POST;

        if (!$this->admin_login) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }

        $req["id"] = $data["sess"]->user->id;

        $vald = $this->um->validate($req, "update", [
            "id" => ["required"],
            "nama" => ["required", "max:255"],
            "username" => ["required", "max:50", "unique"],
            "email" => ["required", "max:50", "email", "unique"],
        ]);

        if (!$vald["result"]) {
            http_response_code(422);
            $this->status = 422;
            $this->message = $vald["message"];
            $this->__json_out([]);
        }

        try {
            $sess = $data["sess"];
            $sess->user->nama = $req["nama"];
            $sess->user->username = $req["username"];
            $sess->user->email = $req["email"];

            $this->um->update($req["id"], $req);
            $this->setKey($sess);
            http_response_code(200);
            $this->status = 200;
            $this->message = "Berhasil mengubah profile!!";
            $this->__json_out($req);
        } catch (Exception $e) {
            http_response_code(500);
            $this->status = 500;
            $this->message = "Internal server error";
            $this->__json_out([]);
        }
    }

    public function edit_password()
    {
        $data = $this->__init();
        $req = $_POST;

        if (!$this->admin_login) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }

        $req["id"] = $data["sess"]->user->id;

        $vald = $this->um->validate($req, "update", [
            "id" => ["required"],
            "password" => ["required", "min:6", "max:50"],
            "konfirmasi_password" => ["required", "min:6", "max:50"],
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
            $this->um->update($req["id"], $req);
            http_response_code(200);
            $this->status = 200;
            $this->message = "Berhasil mengubah password!!";
            $this->__json_out($req);
        } catch (Exception $e) {
            http_response_code(500);
            $this->status = 500;
            $this->message = "Internal server error";
            $this->__json_out([]);
        }
    }
}
