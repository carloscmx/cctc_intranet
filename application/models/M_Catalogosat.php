<?php
defined('BASEPATH') or exit('No direct script access allowed');


class M_Catalogosat extends CI_Model
{



    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    // ------------------------------------------------------------------------

    // ------------------------------------------------------------------------
    public function obtenerusocfdi($where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->select('*');
        $this->db->from('fac_catalogo_uso_cfdi');
        return $this->db->get();
    }
    public function obtenermetodopago($where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->select('*');
        $this->db->from('fac_catalogo_metodo_pago');
        return $this->db->get();
    }
    public function guardarRazonSocial($data)
    {
        $this->db->insert("fac_razones_sociales", $data);
    }
    public function obtenerRazoneSociales($where)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->select('*');
        $this->db->from('fac_razones_sociales');
        return $this->db->get();
    }
    public function eliminarRazonSocial($id)
    {
        $this->db->where(["id_relacion" => $id]);
        $this->db->update('fac_razones_sociales', ["activo" => 0]);
    }
    public function fac_info_emisor($where)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->select('*');
        $this->db->from('fac_info_emisor');
        return $this->db->get();
    }
}
