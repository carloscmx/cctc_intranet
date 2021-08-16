<?php
defined('BASEPATH') or exit('No direct script access allowed');


class M_Procesos extends CI_Model
{



    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    // ------------------------------------------------------------------------

    // ------------------------------------------------------------------------
    public function obetenerProcesosInternos($where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->select('*');
        $this->db->from('ps_procesos');
        return $this->db->get();
    }
    public function editarProceso($data, $where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->update('ps_procesos', $data);
    }
    public function guardarProceso($data)
    {

        $this->db->insert('ps_procesos', $data);
    }
}
