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

class M_Afiliados extends CI_Model
{

    // ------------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    // ------------------------------------------------------------------------

    // ------------------------------------------------------------------------
    public function getAfiliados($where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->select('*');
        $this->db->from('afiliados');
        return $this->db->get();
    }
    public function setAfiliado($data)
    {
        $this->db->insert('afiliados', $data);
    }
    public function deleteAfiliado($where)
    {
        $this->db->delete('afiliados', $where);
    }
}

/* End of file M_Addons_model.php */
/* Location: ./application/models/M_Addons_model.php */
