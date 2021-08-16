<?php
class M_DirectorioCorreo extends CI_Model
{


	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	//METODO que te trae los directorios de los correos
	public function ObtenerDirectorios($dr_id)
	{

		$this->db->select('*');
		$this->db->from('dr_correos AS dr');
		$this->db->join('sr_correos AS sr', 'sr.sr_id=dr.dr_sr_id');
		$this->db->where('dr.dr_id', $dr_id);
		return $this->db->get()->result();
	}
}
