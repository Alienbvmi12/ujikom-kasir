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
        $this->setTheme("admin");
    }

    public function index()
    {
        $data = $this->__init();
        $data["active"] = "transaksi";

        if (!$this->admin_login) {
            redir(base_url_admin());
        }

        $this->putJsReady("transaksi/home.bottom", $data);
        $this->putThemeContent("transaksi/home", $data);
        $this->loadLayout("transaksi", $data);
        $this->render();
    }

    public function process()
    {
        $data = $this->__init();

        if (!$this->admin_login) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }

        $input = json_decode(file_get_contents("php://input"), true);

        $tanggal = date("Y-m-d");
        $no_transaksi = $this->__gen_no_transaksi($tanggal);

        $input["transaksi"]["id"] = $no_transaksi;

        $input["transaksi"]["tanggal_transaksi"] = $tanggal;

        $vald = $this->tm->validate($input["transaksi"], "insert", [
            "tanggal_transaksi" => ["required"],
            "admin_id" => ["required"],
            "subtotal_harga" => ["required", "max:13"],
            "total_harga" => ["required", "max:13"],
            "cash" => ["required", "max:13"]
        ]);

        unset($input["transaksi"]["total_harga"]);

        if (!$vald["result"]) {
            http_response_code(422);
            $this->status = 422;
            $this->message = $vald["message"];
            $this->__json_out([]);
        }

        if ($input["transaksi"]["member_id"] == null) {
            unset($input["transaksi"]["member_id"]);
        }
        if ($input["transaksi"]["diskon_id"] == null) {
            unset($input["transaksi"]["diskon_id"]);
        }
        if ($input["transaksi"]["diskon"] == null) {
            unset($input["transaksi"]["diskon"]);
        } else {
            $vald = $this->tm->validate($input["transaksi"], "insert", [
                "diskon" => ["required", "max:3"],
                "diskon_id" => ["required"],
            ]);

            if (!$vald["result"]) {
                http_response_code(422);
                $this->status = 422;
                $this->message = $vald["message"];
                $this->__json_out([]);
            }
        }

        // Input transaksi to DB

        try {
            $this->tm->set($input["transaksi"]);

            //Process detail transaksi 

            foreach ($input["transaksi_detail"] as $detail) {
                $detail["transaksi_id"] = $no_transaksi;

                unset($detail["produk"]);

                $vald = $this->tm->validate($detail, "insert", [
                    "produk_id" => ["required"],
                    "harga_satuan" => ["required", "max:13"],
                    "qty" => ["required", "max:11"],
                ]);

                if (!$vald["result"]) {
                    http_response_code(422);
                    $this->status = 422;
                    $this->message = $vald["message"];
                    $this->__json_out([]);
                }

                $this->tm->insert_detail($detail);
            }
            http_response_code(200);
            $this->status = 200;
            $this->message = "Transaksi Sukses";
            $this->__json_out([
                "redirect_url" => base_url() . "admin/laporan/struk/" . $no_transaksi . "/"
            ]);
        } catch (Exception $ee) {
            http_response_code(200);
            $this->status = 200;
            $this->message = "Internal Server Error";
            $this->__json_out([]);
        }
    }

    private function __gen_no_transaksi($tanggal)
    {
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
        return $no_transaksi;
    }

    public function __api_produk()
    {
        $data = $this->__init();
        if (!$this->admin_login) {
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
        if (!$this->admin_login) {
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

    public function __api_produk_add($id = "")
    {
        $data = $this->__init();
        if (!$this->admin_login) {
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

        $res = $this->pm->src_produk($id);

        http_response_code(200);
        $this->status = 200;
        $this->message = "Data retrivied";
        $this->__json_out($res);
    }

    public function __api_diskon_transaksi()
    {
        $data = $this->__init();
        if (!$this->admin_login) {
            http_response_code(401);
            $this->status = 401;
            $this->message = "Unauthorized";
            $this->__json_out([]);
        }

        $q = $_GET["nominal"] == 0 ? 0.0000000000000001 : $_GET["nominal"];
        $res = $this->dm->src_member($q);

        http_response_code(200);
        $this->status = 200;
        $this->message = "Data retrivied";
        $this->__json_out($res);
    }
}
