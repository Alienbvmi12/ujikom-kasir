<?php

class Laporan extends JI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load("penjualan_model", "pjm");
        $this->load("transaksi_model", "tm");
        $this->load("produk_model", "pm");
        $this->setTheme("admin");
    }

    public function stok()
    {
        $data = $this->__init();

        if (!$this->admin_login) {
            redir(base_url_admin());
        }

        $data["produk"] = $this->pm->get();

        $this->putThemeContent("laporan/stok", $data);
        $this->loadLayout("plain", $data);
        $this->render();
    }

    public function struk($no_transaksi)
    {
        $data = $this->__init();

        if (!$this->admin_login) {
            redir(base_url_admin());
        }

        $data["transaksi_header"] = $this->tm->get($no_transaksi);
        $data["transaksi_detail"] = $this->tm->get_detail($no_transaksi);


        $this->putThemeContent("laporan/struk", $data);
        $this->loadLayout("plain", $data);
        $this->render();
    }

    public function penjualan($type, string $from, string $until)
    {
        $data = $this->__init();

        if (!$this->admin_login) {
            redir(base_url_admin());
        }

        $data["from"] = $from;
        $data["until"] = $until;

        if ($type == "omset") {
            $data["omset"] = $this->pjm->omset(new stdClass(), $from, $until, true);
            $this->putThemeContent("laporan/omset", $data);
        } else {
            $data["transaksi"] = $this->pjm->read(new stdClass(), $from, $until, true);
            $this->putThemeContent("laporan/transaksi", $data);
        }
        $this->loadLayout("plain", $data);
        $this->render();
    }
}
