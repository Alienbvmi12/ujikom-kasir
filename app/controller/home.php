<?php

class Home extends JI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $data = $this->__init();
        
        if(!$this->is_login()){
            redir(base_url("login"));
        }

        $data["active"] = "dashboard";
        
        $this->putJSReady('home/home.bottom', $data);
        $this->putThemeContent('home/home', $data);
        $this->loadLayout('col-1', $data);
        $this->render();
    }
}
