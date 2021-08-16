<?php if (!defined('BASEPATH')) exit('No se permite el acceso directo al script');



class Datos
{
	public function __construct()
	{
		$this->CI = &get_instance();
		$CI = &get_instance();
		$CI->load->model("M_Comisiones", "cm");

		$CI->load->model("M_Logininternal", "ml");
		$CI->load->library("session");
	}

	function setDatosVendedor($id)
	{
		$result = $this->CI->cm->getVendedores(array("ven_idvendedor" => $id));
		return $result->row_array();
	}
	function getPersonasAdministradores($id)
	{
		$result = $this->CI->ml->getPersonasAdministradores(array("usr_id_personas" => $id));
		return $result->row_array();
	}
	function obtenerNombreAdminActual()
	{
		$sesion = $this->CI->session->userdata('user');
		$external_id = $sesion['lg_external_id'];
		$datos = $this->getPersonasAdministradores($external_id);

		return $datos['usr_nombre'] . " " . $datos['usr_apellido_pat'];
	}
}
