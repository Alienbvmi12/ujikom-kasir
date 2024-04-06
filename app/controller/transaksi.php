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

    public function process()
    {
        $data = $this->__init();

        if (!$this->is_login()) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }

        $input = json_decode(file_get_contents("php://input"), true);

        $tanggal = date("Y-m-d");
        $no_transaksi = date("Ymd");
        $transaksiCount = intval($this->tm->countTransaksiByDate($tanggal)->total) + 1;
        $cos_tam = "";

        if ($transaksiCount >= 0 and $transaksiCount < 10) {
            $cos_tam = "000";
        } elseif ($transaksiCount >= 10 and $transaksiCount < 100) {
            $cos_tam = "00";
        } elseif ($transaksiCount >= 100 and $transaksiCount < 1000) {
            $cos_tam = "0";
        } elseif ($transaksiCount >= 1000 and $transaksiCount < 10000) {
            $cos_tam = "";
        } else {
            http_response_code(422);
            $this->status = 422;
            $this->message = "Data Produk Sudah Penuh!!!";
            $this->__json_out([]);
        }

        $no_transaksi .= $cos_tam . $transaksiCount;

        $input["transaksi"]["tanggal_transaksi"] = $tanggal;

        $vald = $this->tm->validate($input["transaksi"], "insert", [
            "tanggal_transaksi" => ["required"],
            "user_id" => ["required"],
            "subtotal_harga" => ["required", "max:13"],
            "total_harga" => ["required", "max:13"],
            "diskon" => ["max:3"],
            "cash" => ["required", "max:13"]
        ]);

        if (!$vald["result"]) {
            http_response_code(422);
            $this->status = 422;
            $this->message = $vald["message"];
            $this->__json_out([]);
        }
        
        if( $input["transaksi"]["member_id"] == null){
            unset($input["transaksi"]["member_id"]);
        }
        if( $input["transaksi"]["diskon_id"] == null){
            unset($input["transaksi"]["diskon_id"]);
        }
        if( $input["transaksi"]["diskon"] == null){
            unset($input["transaksi"]["diskon"]);
        }

        $ins = $this->tm->set($input["transaksi"]);
        http_response_code(200);
        $this->status = 200;
        $this->message = "Transaksi Sukses";
        $this->__json_out([
            "redirect_url" => base_url() . "transaksi/invoice/" . $no_transaksi . "/"
        ]);
    }

    public function __api_produk()
    {
        $data = $this->__init();
        if (!$this->is_login()) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
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
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }

        $q = $_GET["q"] ?? "";
        $res = $this->mm->src($q);

        http_response_code(200);
        $this->status = 200;
        $this->message = "Data retrivied";
        $this->__json_out($res);
    }

    public function __api_produk_diskon($id = "")
    {
        $data = $this->__init();
        if (!$this->is_login()) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }

        if ($id == "") {
            http_response_code(422);
            $this->status = 422;
            $this->message = "Id Required";
            $this->__json_out([]);
        }

        $res = $this->pm->src_produk_diskon($id);

        http_response_code(200);
        $this->status = 200;
        $this->message = "Data retrivied";
        $this->__json_out($res);
    }

    public function __api_diskon_transaksi()
    {
        $data = $this->__init();
        if (!$this->is_login()) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }

        $q = $_GET["nominal"] ?? "0";
        $res = $this->dm->src_member($q);

        http_response_code(200);
        $this->status = 200;
        $this->message = "Data retrivied";
        $this->__json_out($res);
    }
}
