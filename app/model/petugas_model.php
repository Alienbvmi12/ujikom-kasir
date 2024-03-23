<?php

class Petugas_Model extends JI_Model
{

    public $tbl = "user";
    public $tbl_as = "ptgs";
    public $columns = [
        "id",
        "nama",
        "username",
        "email",
        "status",
        "created_at",
        "id"
    ];

    public function __construct()
    {
        parent::__construct();
        $this->db->from($this->tbl, $this->tbl_as);
    }

    private function __search($q)
    {
        if (strlen($q) > 0) {
            $this->db->where("id", $q, "OR", "%like%", 1, 0);
            $this->db->where("nama", $q, "OR", "%like%", 0, 0);
            $this->db->where("username", $q, "OR", "%like%", 0, 0);
            $this->db->where("email", $q, "OR", "%like%", 0, 0);
            $this->db->where("created_at", $q, "OR", "%like%", 0, 1);
        }
    }

    public function read($data)
    {
        $this->db->select_as("$this->tbl_as.id", "id");
        $this->db->select_as("$this->tbl_as.nama", "nama");
        $this->db->select_as("$this->tbl_as.username", "username");
        $this->db->select_as("$this->tbl_as.email", "email");
        $this->db->select_as("$this->tbl_as.status", "status");
        $this->db->select_as("$this->tbl_as.created_at", "created_at");

        $this->db->where("$this->tbl_as.role", "1", "AND", "=", 1, 1);
        $this->__search($data->search);
        $this->db->order_by($this->columns[$data->column], $data->dir);
        $this->db->limit($data->start, $data->length);
        return $this->db->get();
    }

    public function count()
    {
        $this->db->select_as("COUNT(*)", "total");
        $this->db->where("role", "1", "AND", "=", 1, 1);
        return $this->db->get_first();
    }

    public function delete($id)
    {
        $this->db->where("role", "1", "AND", "=");
        $this->db->where("id", $id, "AND", "=");
        return $this->db->delete($this->tbl);
    }
}
