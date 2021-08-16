<?php
class M_Facturas extends CI_Model
{


	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	//METODO que te trae los directorios de los correos
	public function existeFactura($idinvoice)
	{
		$existe = false;
		$this->db->select('*');
		$this->db->from('fac_referencias AS fac');
		$this->db->where('fac.fac_idinvoice', $idinvoice);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$existe = true;
		}
		return $existe;
	}
	public function buscarFactura($where)
	{
		$this->db->where($where);
		$existe = false;
		$this->db->select('*');
		$this->db->from('fac_referencias');
		return $this->db->get();
	}
	public function buscarArchivos($where)
	{
		$this->db->where($where);
		$this->db->select('*');
		$this->db->from('fac_archivos');
		return $this->db->get();
	}

	public function insertarFactura($data)
	{
		$this->db->insert("fac_referencias", $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	public function insertarFacturaArchivos($data)
	{
		$this->db->insert("fac_archivos", $data);
	}
}
