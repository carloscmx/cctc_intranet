<?php
defined('BASEPATH') or exit('No direct script access allowed');



class M_Comisiones extends CI_Model
{

    // ------------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    public function getVendedores($where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->select('*');
        $this->db->from('cm_vendedores');
        return $this->db->get();
    }
    public function getVendedoresClientes($where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->select('*');
        $this->db->from('cm_vendedores_clientes');
        return $this->db->get();
    }
    public function getVendedoresClientesJoinVendedores($where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->select('*');
        $this->db->from('cm_vendedores_clientes');
        $this->db->join("cm_vendedores", "cm_vendedores.ven_idvendedor=cm_vendedores_clientes.ven_cl_idvendedor");

        return $this->db->get();
    }
    public function insertVendedores($data)
    {
        $this->db->insert("cm_vendedores", $data);
    }
    public function insertVendedoresClientes($data)
    {
        $this->db->insert("cm_vendedores_clientes", $data);
    }
    public function deleteVendedoresClientes($where)
    {
        $this->db->where($where);
        $this->db->delete("cm_vendedores_clientes");
    }
    public function updateVendedores($data, $where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->update("cm_vendedores", $data);
    }


    public function insertUserVendedor($data)
    {
        $this->db->insert("lg_usuarios", $data);
    }
    public function updateUserVendedor($data, $where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->update("lg_usuarios", $data);
    }
}
