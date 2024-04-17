<?php

class Home extends JI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load("produk_model", "pm");
        $this->load("member_model", "mm");
        $this->load("transaksi_model", "tm");
        $this->load("diskon_model", "dm");
        $this->setTheme("admin");
    }
    public function index()
    {
        $data = $this->__init();
        
        if(!$this->admin_login){
            redir(base_url_admin("login/"));
        }

        $data["active"] = "dashboard";
        $data["produk"] = $this->pm->count()->total;
        $data["member"] = $this->mm->count()->total;
        $data["terjual"] = $this->tm->count_terjual()->total;
        $data["diskon"] = $this->dm->count()->total;
        
        $this->putJSReady('home/home.bottom', $data);
        $this->putThemeContent('home/home', $data);
        $this->loadLayout('col-1', $data);
        $this->render();
    }
}
