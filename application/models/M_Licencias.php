<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model M_Addons_model
 *
 * This Model for ...
 *
 * @package        CodeIgniter
 * @category    Model
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class M_Licencias extends CI_Model
{

    // ------------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    // ------------------------------------------------------------------------

    // ------------------------------------------------------------------------
    public function getTipoLicencia($where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->select('*');
        $this->db->from('tipolicencia');
        return $this->db->get();
    }

    // ------------------------------------------------------------------------
    public function insertProveedorLicencia($data)
    {

        $this->db->insert('proveedorlicencia', $data);
    }

    // ------------------------------------------------------------------------
    public function insertTipoLicencia($data)
    {

        $this->db->insert('tipolicencia', $data);
    }
    // ------------------------------------------------------------------------
    public function insertProveedores($data)
    {

        $this->db->insert('provedoreslicencia', $data);
    } // ------------------------------------------------------------------------
    public function insertLicencia($data)
    {

        $this->db->insert('licenciaswindows', $data);
    }
    // ------------------------------------------------------------------------
    public function UpdateProveedorLicencia($where, $data)
    {
        $this->db->where($where);
        $this->db->update('proveedorlicencia', $data);
    }


    // ------------------------------------------------------------------------
    public function getLicencias($where = null, $limit = false)
    {
        if ($limit) {
            $this->db->limit(1);
        }
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->select('*,licenciaswindows.activo as activolicencia');
        $this->db->from('licenciaswindows');
        $this->db->join("tipolicencia", "tipolicencia.idlicencia=licenciaswindows.idtipolicencia");
        return $this->db->get();
    }
    public function setUpdateLicencia($where, $data)
    {


        $this->db->where($where);
        $this->db->update('licenciaswindows', $data);
    }
    public function setUpdateTipoLicencias($where, $data)
    {


        $this->db->where($where);
        $this->db->update('tipolicencia', $data);
    }
    public function getProveedores($where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->select('*');
        $this->db->from('provedoreslicencia');
        return $this->db->get();
    }
    public function setUpdateProveedor($where, $data)
    {


        $this->db->where($where);
        $this->db->update('provedoreslicencia', $data);
    }
    public function getProvedorLicencia($where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->select('*, proveedorlicencia.activo as activolic');
        $this->db->from('proveedorlicencia');
        $this->db->join("tipolicencia", "tipolicencia.idlicencia=proveedorlicencia.idtipolicencia");
        return $this->db->get();
    }

    // ------------------------------------------------------------------------
    public function insertarPedidoLicencia($data)
    {
        $this->db->insert("pd_licencias", $data);
    }
    public function actualizarPedidoLicencia($data, $where)
    {
        $this->db->where($where);
        $this->db->update("pd_licencias", $data);
    }
    public function obtenerCostoLicencia($where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->select('*');
        $this->db->from('proveedorlicencia');
        return $this->db->get();
    }
    public function obtenerPedidoLicencia($where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->select('*');
        $this->db->from('pd_licencias');
        return $this->db->get();
    }
    public function trasladoStock($data)
    {
        $this->db->insert("lic_traslados", $data);
    }
    public function getLicencia($where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->select('*');
        $this->db->from('licenciaswindows');
        return $this->db->get();
    }
    public function getTraslados($where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->select('*');
        $this->db->from('lic_traslados');
        return $this->db->get();
    }
}

/* End of file M_Addons_model.php */
/* Location: ./application/models/M_Addons_model.php */
