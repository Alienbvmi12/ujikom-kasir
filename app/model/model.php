<?php

class Model extends JI_Model
{
    public $tbl = "model";
    public $tbl_as = "mdl";
    
    public function __construct()
    {
        parent::__construct();
        $this->db->from($this->tbl, $this->tbl_as);
    }
}
