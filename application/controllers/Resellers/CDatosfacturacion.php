<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CDatosfacturacion extends CI_Controller
{

	private $template, $reseller;
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->helper('url');
		$this->load->library("whmcs");
		$this->load->library("session");
		$this->load->helper("scripts");
		$this->reseller = $this->session->userdata('reseller');
		$this->template['head'] = $this->load->view("resellers/masterPage/head", array("reseller" => $this->reseller), true);
		$this->template['footer'] = $this->load->view("resellers/masterPage/footer", array(), true);
		$urlogin = url_login_resellers();
		$this->load->model("M_Catalogosat", "msat");

		if (!$this->session->userdata('reseller')) {
			header("Location: {$urlogin}");
		}
	}

	public function vistaDatosFacturacion()
	{
		$data['template'] = $this->template;
		$data['metodopago'] = $this->msat->obtenermetodopago(['fac_metodo_activo' => 1])->result();
		$data['usocfdi'] = $this->msat->obtenerusocfdi(['fac_cfdi_activo' => 1])->result();

		$this->load->view("resellers/directory/datos_facturacion", $data);
	}
	public function registrarDatoFacturacion()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$txtrazonsocial = $this->input->post("txtrazonsocial", true);
			$txtrfc = $this->input->post("txtrfc", true);
			$metodogasto = $this->input->post("cbometodogasto", true);
			$usocfdi = $this->input->post("cbotipogasto", true);
			$row = [
				'clientid' => $_SESSION['reseller']->client_id,
				'idmetodopago' => $metodogasto,
				'idusocfdi' => $usocfdi,
				'rfc' => $txtrfc,
				'razonsocial' => $txtrazonsocial
			];
			$this->msat->guardarRazonSocial($row);
		}
	}
	public function obtenerRazoneSociales()
	{
		$rows = [];
		$result = $this->msat->obtenerRazoneSociales(['clientid' => $_SESSION['reseller']->client_id, 'activo' => 1])->result();
		foreach ($result as $row) {
			$row->metodopagoinfo = $this->msat->obtenermetodopago(['id_fac_cat' => $row->idmetodopago])->row();
			$rows[] = $row;
			$row->usocfdiinfo = $this->msat->obtenerusocfdi(['int_cfdi' => $row->idusocfdi])->row();
		}

		echo json_encode($rows);
	}
	public function eliminarRazonSocial()
	{
		$id = $this->input->post("id", true);
		$this->msat->eliminarRazonSocial($id);
	}
}
