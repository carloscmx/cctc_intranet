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

class M_Logininternal extends CI_Model
{

    // ------------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    // ------------------------------------------------------------------------

    // ------------------------------------------------------------------------
    public function getUsers($where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->select('lg_usuarios_id,lg_usuarios_nombre,lg_usuarios_lg_perfiles_id,lg_activo,lg_external_id,lg_usuarios_correo,lg_reset');
        $this->db->from('lg_usuarios');
        return $this->db->get();
    }
    public function login($user, $password)
    {
        $this->db->where(array('lg_usuarios_nombre' => $user, 'lg_usuarios_password' => $password, "lg_activo" => 1));
        $this->db->select("l.lg_usuarios_id,l.lg_usuarios_nombre,l.lg_usuarios_lg_perfiles_id,l.lg_external_id,l.lg_usuarios_correo, l.lg_reset,p.lg_perfil_nombre,p.lg_patch");
        $this->db->from('lg_usuarios as l');
        $this->db->join("lg_perfiles as p", "p.lg_perfil_id=l.lg_usuarios_lg_perfiles_id");
        $query = $this->db->get();
        return $query->row_array();
    }
    public function userUpdate($data, $where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->update("lg_usuarios", $data);
    }
    public function getPersonasAdministradores($where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->select('*');
        $this->db->from('usr_personas');
        return $this->db->get();
    }
}

/* End of file M_Addons_model.php */
/* Location: ./application/models/M_Addons_model.php */
