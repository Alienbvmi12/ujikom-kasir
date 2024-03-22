<?php

class Logout extends JI_Controller{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $data = $this->__init();
        if(is_object($data["sess"])){
            $data["sess"]->user = new stdClass();
            $this->setKey($data["sess"]);
        }
        else{
            $this->setKey(new stdClass());
        }
        redir(base_url());
    }
}