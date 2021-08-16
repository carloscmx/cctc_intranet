<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CFacturacionadmin extends CI_Controller
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
		$this->load->model("M_Facturas", "mf");
		$this->load->library("Utilerias");


		$urlogin = url_login_admin();

		if ($this->session->userdata('user')) {
			$sesion = $this->session->userdata('user');
			if ($sesion['lg_usuarios_lg_perfiles_id'] == 1) {
				//	header("Location: {$urldashboard}");
			} else {
				header("Location: {$urlogin}");
			}
		} else {
			header("Location: {$urlogin}");
		}
	}
	public function index()
	{
		$this->load->view('masterPageCards/facturacion/referencias');
	}
	public function obtenerReferenciasCliente()
	{
		/* $result = json_decode($this->whmcs->funcion('GetInvoices', array("responsetype" => "json", "limitnum" => 1000000, "status" => "Pending", "userid" => $this->reseller->id)));
		*/
		$invoices = array();
		$result = json_decode($this->whmcs->funcion('GetInvoices', array("responsetype" => "json", "limitnum" => 1000000)));
		foreach ($result->invoices->invoice as $invoice) {
			if ($invoice->datepaid == "0000-00-00 00:00:00") {
				$invoice->datepaid = "-";
			}
			$link = base_url("resellers/invoices/services/service/invoice/{$invoice->id}");
			$invoice->referencias = "<a href='{$link}'>Ver Referencia</a>";
			//=================
			$invoice->opcionfactura = "No disponible";
			$invoice->opcionfacturaid = 1;
			$condicion = (date("m-Y") == date("m-Y", strtotime($invoice->date)));
			$produccion = $this->utilerias->fechaproduccion($invoice->date);

			if ($invoice->status == "Paid" && $condicion && $produccion) {
				$invoice->opcionfacturaid = 2;
				$invoice->opcionfactura = "<div style='text-align: center;'
				><input type='submit' class='btn btn-danger' value='Facturar' onclick='advertenciaFactura({$invoice->id})'></div>";
				if ($this->mf->existeFactura($invoice->id)) {
					$invoice->opcionfacturaid = 3;
					$facturaref = $this->mf->buscarFactura([
						"fac_idinvoice" => $invoice->id
					])->row();
					$datoarchivopdf = $this->mf->buscarArchivos([
						"id_fac_reference" => $facturaref->fac_id,
						"fac_arc_tipo" => 2
					])->row();
					$datoarchivoxml = $this->mf->buscarArchivos([
						"id_fac_reference" =>  $facturaref->fac_id,
						"fac_arc_tipo" => 1
					])->row();

					$urlxml = base_url_directory_invoice_url_admin($datoarchivoxml->fac_arc_ash);
					$urlpdf = base_url_directory_invoice_url_admin($datoarchivopdf->fac_arc_ash);
					$invoice->opcionfactura = "<div style='text-align: center;'
					><button type='submit' class='btn btn-primary btn-sm' '  target='_blank' onclick=javascript:window.open('{$urlxml}')>XML</button><p></p><button type='submit' class='btn btn-danger btn-sm' onclick=javascript:window.open('{$urlpdf}')>PDF</button>
					</div>";
				}
			}
			$invoice->cliente = "{$invoice->firstname} {$invoice->lastname} - {$invoice->companyname}";
			//===============
			$invoices[] = $invoice;
		}
		echo json_encode(array("data" => $invoices));
	}
}
