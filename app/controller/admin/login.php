<?php

class Login extends JI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load("admin_model", "admin");
        $this->setTheme("admin");
    }

    public function index()
    {
        $data = array();
        if ($this->admin_login) {
            redir(base_url_admin());
        }
        $this->putJSReady("login/home.bottom", $data);
        $this->putThemeContent("login/home");
        $this->loadLayout("login");
        $this->render();
    }

    public function login()
    {
        $c_sess = $this->__init();
        $input = $_POST;

        if ($this->admin_login) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Sudah login";
            $this->__json_out([]);
        }

        $vald = $this->admin->validate($input, "read", [
            "email" => ["required"],
            "password" => ["required"]
        ]);

        if (!$vald["result"]) {
            http_response_code(422);
            $this->status = 422;
            $this->message = $vald["message"];
            $this->__json_out([]);
            die;
        }

        $user = $this->admin->auth($input["email"]);

        if (isset($user->id)) {
            if ($user->status == 0) {
                $this->status = 409;
                $this->message = "User Nonaktif";
                $this->__json_out([]);
                die;
            }

            if (md5($input["password"]) === $user->password) {
                $user->password = password_hash($input["password"], PASSWORD_BCRYPT);
                $this->admin->update($user->id, ["password" => $user->password]);
            }

            if (!password_verify($input["password"], $user->password)) {
                http_response_code(401);
                $this->status = 401;
                $this->message = "Username atau password salah!!";
                $this->__json_out([]);
                die;
            }

            $sess = $c_sess["sess"];
            $sess->admin = $user;
            $this->setKey($sess);
            http_response_code(200);
            $this->status = 200;
            $this->message = "Login berhasil!!!";
            $this->__json_out($sess->user);
            die;
        } else {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Username atau password salah!!";
            $this->__json_out([]);
            die;
        }
    }
}
