<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CClientes extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->helper('url');
		$this->load->helper('scripts');
		$this->load->library("whmcs");
		$this->load->library("template");
		$this->load->model("M_Licencias", "modellicencias");
		$this->load->model("M_Afiliados", "modelafiliado");
	}
	public function index()
	{
		$this->load->view('welcome_message');
	}
	public function getClients()
	{
		$result =	json_decode($this->whmcs->funcion('GetClients', array("responsetype" => "json", "limitnum" => 1000000, "status" => "Active")));
		$afiliados = $this->modelafiliado->getAfiliados()->result_array();
		$resultadoafiliados = [];
		for ($i = 0; $i < $result->numreturned; $i++) {
			$afiliado = $result->clients->client[$i];
			if ($afiliado->groupid != 0) {
				$afiliado->aliado = false;
				$afiliado->nombrecompleto = $afiliado->firstname . " " . $afiliado->lastname;

				switch ($afiliado->groupid) {
					case 1:
						$afiliado->tipogrupo = "Reseller Silver";
						break;
					case 2:
						$afiliado->tipogrupo = "Reseller Gold";
						break;
					case 3:
						$afiliado->tipogrupo = "Reseller Platinum";
						break;
					default:
						$afiliado->tipogrupo = "No configurado";
						break;
				}
				for ($o = 0; $o < count($afiliados); $o++) {
					if ($afiliados[$o]["idafiliado"] == $afiliado->id) {
						$afiliado->aliado = true;
					}
				}
				if ($afiliado->aliado) {
					$afiliado->button = "<label class='switch'>
					<input type='checkbox' checked id='checkinput{$afiliado->id}'>
					<span class='slider round' onclick='verificar({$afiliado->id})'></span>
				  </label>";
				} else {
					$afiliado->button = "<label class='switch'>
					<input type='checkbox' id='checkinput{$afiliado->id}'>
					<span class='slider round' onclick='verificar({$afiliado->id})' ></span>
				  </label>";
				}
				$resultadoafiliados[] = $afiliado;
			} else {
				/**
				 * Descarta a los clientes que no pertenence a ningun grupo de Resellers
				 */
				unset($afiliado);
			}
		}
		echo json_encode(array("data" => $resultadoafiliados));
	}
	public function setStatusAfiliado()
	{
		$afiliado = $this->input->post("id", true);
		$status = $this->input->post("status", true);
		$data = array("idafiliado" => $afiliado);

		if ($status == "agregar") {
			$this->modelafiliado->setAfiliado($data);
		} else {
			$this->modelafiliado->deleteAfiliado($data);
		}
	}
}
