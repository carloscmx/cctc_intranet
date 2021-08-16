<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CResellers extends CI_Controller
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
		$this->load->model("M_Facturas", "mf");
		$this->load->library("Utilerias");
		$this->load->model("M_Catalogosat", "msat");


		$this->reseller = $this->session->userdata('reseller');
		$this->template['head'] = $this->load->view("resellers/masterPage/head", array("reseller" => $this->reseller), true);
		$this->template['footer'] = $this->load->view("resellers/masterPage/footer", array(), true);
		$urlogin = url_login_resellers();

		if (!$this->session->userdata('reseller')) {
			header("Location: {$urlogin}");
		}
	}
	public function dashboard()
	{
		$data['template'] = $this->template;
		$data['reseller'] = $this->reseller;
		$this->load->view("resellers/directory/dashboard.php", $data);
	}
	public function invoice_for_service()
	{
		$data['template'] = $this->template;
		$data['reseller'] = $this->reseller;
		$this->load->view("resellers/directory/invoices/invoice_service.php", $data);
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

		return $rows;
	}
	public function invoices()
	{
		$data['template'] = $this->template;
		$data['reseller'] = $this->reseller;
		$data['razonessociales'] = $this->obtenerRazoneSociales();
		$this->load->view("resellers/directory/invoices/invoicesv2.php", $data);
	}
	public function index()
	{
		$data['template'] = $this->template;
		$data['reseller'] = $this->reseller;
		$this->load->view("resellers/directory/index.php", $data);

		//echo $this->obtenerPedidosJsonFilter();
	}
	public function history()
	{
		$data['template'] = $this->template;
		$data['reseller'] = $this->reseller;
		$this->load->view("resellers/directory/history.php", $data);

		//echo $this->obtenerPedidosJsonFilter();
	}
	public function obtenerPedidos()
	{
		$pedidos = array();
		//"userid" => $this->reseller->id
		$result = json_decode($this->whmcs->funcion('GetOrders', array("responsetype" => "json", "limitnum" => 1000000, "status" => "Pending", "userid" => $this->reseller->id)));
		if ($result->numreturned > 0) {
			foreach ($result->orders->order as $row) {
				$orders[] = $row;
			}
			$pedidos =  $orders;
		}
		return $pedidos;
	}
	public function obtenerTodosLosPedidos()
	{
		$pedidos = array();
		//"userid" => $this->reseller->id
		$result = json_decode($this->whmcs->funcion('GetOrders', array("responsetype" => "json", "limitnum" => 1000000, "userid" => $this->reseller->id)));
		if ($result->numreturned > 0) {
			foreach ($result->orders->order as $row) {
				$orders[] = $row;
			}
			$pedidos =  $orders;
		}
		return $pedidos;
	}
	public function obtenerPedidosJsonFilter()
	{
		$pedidos = array();
		foreach ($this->obtenerPedidos() as $row) {

			$row->buttons = "<div style='text-align: center;'
			><button type='submit' class='btn btn-primary btn-sm' onclick='aceptarPedido({$row->id})' id='btnAcept{$row->id}'>Aceptar pedido</button><p></p><button type='submit' class='btn btn-danger btn-sm' onclick=cancelarPedido({'idpedido':'{$row->id}'}) id='btnCancel{$row->id}'>Cancelar Pedido</button>
			</div>";
			$solovps = true;
			$items = "";
			foreach ($row->lineitems->lineitem as $key) {
				if (!strpos($key->product, "Virtuales")) {
					$solovps = false;
				}
				$items .= "<p> {$key->product} - {$key->domain} </p>";
			}
			$row->itemspedidos = $items;
			$row->costo = $row->amount . " " . $row->currencysuffix;

			if ($solovps) {
				$pedidos[] = $row;
			}
		}
		echo json_encode(array("data" => $pedidos));
		//	echo json_encode($this->obtenerPedidos());
	}
	public function obtenerPedidosJsonFilterHistorico()
	{
		$pedidos = array();
		foreach ($this->obtenerTodosLosPedidos() as $row) {
			$items = "";
			if (is_null($row->paymentstatus)) {
				$row->paymentstatus = "No expiration date";
			}
			if (isset($row->lineitems->lineitem)) {
				foreach ($row->lineitems->lineitem as $key) {
					$items .= "<p> {$key->product} - {$key->domain} </p>";
				}
			} else {
				$items .= "Sin detalles";
			}

			$row->itemspedidos = $items;
			$row->costo = $row->amount . " " . $row->currencysuffix;

			$pedidos[] = $row;
		}
		echo json_encode(array("data" => $pedidos));
		//	echo json_encode($this->obtenerPedidos());
	}
	public function obtenerPedidosClassFilter()
	{
		$pedidos = array();
		foreach ($this->obtenerPedidos() as $row) {
			$row->buttons = array("accept" => "aceptarPedido({$row->id})", "cancel" => "cancelarPedido({$row->id})");
			$solovps = true;
			foreach ($row->lineitems->lineitem as $key) {
				if (!strpos($key->product, "Virtuales")) {
					$solovps = false;
				}
				//echo $key->product;
			}
			if ($solovps) {
				$pedidos[] = $row;
			}
		}
		return array("data" => $pedidos);
		//	echo json_encode($this->obtenerPedidos());
	}
	public function aceptarPedido()
	{
		$idpedido = $this->input->post("idpedido", true);
		$this->whmcs->funcion('AcceptOrder', array("orderid" => $idpedido));
	}
	public function cancelarPedido()
	{
		$idpedido = $this->input->post("idpedido", true);
		$this->whmcs->funcion('CancelOrder', array("orderid" => $idpedido));
	}

	public function obternerServicios()
	{
		$result = json_decode($this->whmcs->funcion('GetClientsProducts', array(
			"clientid" => $this->reseller->id, "limitnum" => 1000000,            'responsetype' => 'json',
		)));
		return $result;
	}
	public function obternerServiciosJsonActivo()
	{

		$services = $this->obternerServicios();
		$servicesactives = array();
		if (isset($services->products->product)) {
			foreach ($services->products->product as $row) {
				if ($row->status == "Active") {
					$link = base_url("resellers/invoices/services/service/{$row->id}");
					$row->referencias = "<a href='{$link}'>Ver Referencias</a>";
					$row->typeservice = $row->groupname . " " . $row->name;
					$servicesactives[] = $row;
				}
			}
		}
		echo json_encode(array("data" => $servicesactives));
		//echo json_encode($this->reseller);
	}
	public function obternerServiciosJsonCancelado()
	{

		$services = $this->obternerServicios();
		$servicesactives = array();
		foreach ($services->products->product as $row) {
			if ($row->status == "Cancelled") {
				$row->typeservice = $row->groupname . " " . $row->name;
				$servicesactives[] = $row;
			}
		}
		echo json_encode(array("data" => $servicesactives));
		//echo json_encode($this->reseller);
	}
	public function obternerServiciosActivosMes($mes = null)
	{
		if ($mes == null) {
			$mes = date("m-Y");
		}
		$services = $this->obternerServicios();
		$servicesactives = array();
		if (isset($services->products->product)) {
			foreach ($services->products->product as $row) {
				$condicion = ($mes == date("m-Y", strtotime($row->regdate)));

				if ($row->status == "Active" && $condicion) {
					$row->typeservice = $row->groupname . " " . $row->name;
					$servicesactives[] = $row;
				}
			}
		}

		echo json_encode(array("data" => $servicesactives));
	}
	public function obtenerReferenciasCliente()
	{
		/* $result = json_decode($this->whmcs->funcion('GetInvoices', array("responsetype" => "json", "limitnum" => 1000000, "status" => "Pending", "userid" => $this->reseller->id)));
		*/
		$invoices = array();
		$result = json_decode($this->whmcs->funcion('GetInvoices', array("responsetype" => "json", "limitnum" => 1000000, "userid" => $this->reseller->id)));
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
				><input type='submit' class='btn btn-warning' value='Facturar' onclick='advertenciaFactura({$invoice->id})'></div>";
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

					$urlxml = base_url_directory_invoice_url($datoarchivoxml->fac_arc_ash);
					$urlpdf = base_url_directory_invoice_url($datoarchivopdf->fac_arc_ash);
					$invoice->opcionfactura = "<div style='text-align: center;'
					><button type='submit' class='btn btn-primary btn-sm' '  target='_blank' onclick=javascript:window.open('{$urlxml}')>XML</button><p></p><button type='submit' class='btn btn-danger btn-sm' onclick=javascript:window.open('{$urlpdf}')>PDF</button>
					</div>";
				}
			}
			//===============
			$invoices[] = $invoice;
		}
		echo json_encode(array("data" => $invoices));
	}
	public function obtenerReferenciasClienteService()
	{
		$service = null;
		$relid = array();
		if (isset($_GET['query']) && isset($_GET['invoice'])) {
			$service = $_GET['invoice'];
			$invoices = json_decode($this->whmcs->funcion('GetInvoices', array("responsetype" => "json", "limitnum" => 1000000, "userid" => $this->reseller->id)));
			foreach ($invoices->invoices->invoice as $row) {
				$invoice = json_decode($this->whmcs->funcion('GetInvoice', array("responsetype" => "json", "limitnum" => 1000000, "invoiceid" => $row->id)));
				//=================
				$row->opcionfactura = "No disponible";
				$condicion = (date("m-Y") == date("m-Y", strtotime($row->date)));
				$fechaproduccion = facturacion_fecha_produccion();

				$condicionproduccion = (date("d-m-Y", strtotime($row->date)) >= date_format(date_create("{$fechaproduccion}"), "d-m-Y"));
				if ($row->status == "Paid" && $condicion && $condicionproduccion) {
					$row->opcionfactura = "<div style='text-align: center;'
				><input type='submit' class='btn btn-warning' value='TIMBRAR' onclick='advertenciaFactura({$row->id})'></div>";
					if ($this->mf->existeFactura($row->id)) {
						$facturaref = $this->mf->buscarFactura([
							"fac_idinvoice" => $row->id
						])->row();
						$datoarchivopdf = $this->mf->buscarArchivos([
							"id_fac_reference" => $facturaref->fac_id,
							"fac_arc_tipo" => 2
						])->row();
						$datoarchivoxml = $this->mf->buscarArchivos([
							"id_fac_reference" =>  $facturaref->fac_id,
							"fac_arc_tipo" => 1
						])->row();

						$urlxml = base_url_directory_invoice_url($datoarchivoxml->fac_arc_ash);
						$urlpdf = base_url_directory_invoice_url($datoarchivopdf->fac_arc_ash);
						$invoice->opcionfactura = "<div style='text-align: center;'
					><button type='submit' class='btn btn-primary btn-sm' '  target='_blank' onclick=javascript:window.open('{$urlxml}')>XML</button><p></p><button type='submit' class='btn btn-danger btn-sm' onclick=javascript:window.open('{$urlpdf}')>PDF</button>
					</div>";
					}
				}
				//===============
				foreach ($invoice->items->item as $item) {
					if (isset($item->relid)) {
						if ($item->relid == $service) {
							$link = base_url("resellers/invoices/services/service/invoice/{$row->id}");
							$row->factura = "<a href='{$link}'>Ver referencia</a>";
							if ($row->datepaid == "0000-00-00 00:00:00") {
								$row->datepaid = "-";
							}
							$relid[] = $row;
						}
					}
				}
			}
		}

		echo json_encode(array("data" => $relid));
	}

	public function obtenerReferencia()
	{
		$invoiceid = $this->uri->segment(6);
		$GetInvoice = json_decode($this->whmcs->funcion('GetInvoice', array("responsetype" => "json", "limitnum" => 1000000, "invoiceid" => $invoiceid)));
		if ($GetInvoice->userid != $this->reseller->id) {
			show_404();
			exit(1); // EXIT_ERROR
		}
		$GetClientsDetails = json_decode($this->whmcs->funcion('GetClientsDetails', array("responsetype" => "json", "limitnum" => 1000000, "clientid" => $GetInvoice->userid)));

		$data['nreferencia'] = $GetInvoice->invoicenum;
		$data['facturavencimiento'] =  $GetInvoice->duedate;
		$data['empresato'] = '';
		$data['logo'] = 'https://blazar.com.mx/wp-content/uploads/2021/05/logo2.png';
		$data['estatus'] = $GetInvoice->status;
		$data['facturato'] = $GetClientsDetails->companyname . " " . $GetClientsDetails->fullname . " " . $GetClientsDetails->address1 . " " . $GetClientsDetails->address2 . " " . $GetClientsDetails->city . " " . $GetClientsDetails->fullstate . " " . $GetClientsDetails->postcode . " " . $GetClientsDetails->countryname;
		$data['pagarto'] = reference_paymetto();
		$data['fechafactura'] = $GetInvoice->date;
		$data['facturametodopago'] = $GetInvoice->paymentmethod;
		$data['subtotal'] = $GetInvoice->subtotal;
		$data['tax'] = $GetInvoice->tax;
		$data['taxrate'] = $GetInvoice->taxrate;
		$data['credito'] = $GetInvoice->credit;
		$data['total'] = $GetInvoice->total;
		$data['items'] = array();
		if (isset($GetInvoice->items->item)) {
			$data['items'] = $GetInvoice->items->item;
		}
		$data['transacciones'] = array();
		if (isset($GetInvoice->transactions->transaction)) {
			$data['transacciones'] = $GetInvoice->transactions->transaction;
		}
		$data['balance'] = $GetInvoice->balance;


		$this->load->view("resellers/directory/invoices/print/print_invoice_v1.php", $data);
	}
	public function obternerServiciosCanceladosMes($mes = null)
	{
		if ($mes == null) {
			$mes = date("m-Y");
		}
		$services = $this->obternerServicios();
		$servicesactives = array();
		if (isset($services->products->product)) {
			foreach ($services->products->product as $row) {
				$condicion = ($mes == date("m-Y", strtotime($row->regdate)));

				if ($row->status == "Cancelled" && $condicion) {
					$row->typeservice = $row->groupname . " " . $row->name;
					$servicesactives[] = $row;
				}
			}
		}

		echo json_encode(array("data" => $servicesactives));
	}
	public function obtenerCrecimientoMesactualMesAnterior()
	{

		$mes = date("m-Y"); //Mes actual

		$services = $this->obternerServicios();
		$servicesactivesmesactual = array();
		if (isset($services->products->product)) {
			foreach ($services->products->product as $row) {
				$condicion = ($mes == date("m-Y", strtotime($row->regdate)));

				if ($row->status == "Active" && $condicion) {
					$row->typeservice = $row->groupname . " " . $row->name;
					$servicesactivesmesactual[] = $row;
				}
			}
		}

		$fecha = date('Y-m-j');
		$mesmenos = strtotime('-1 month', strtotime($fecha));
		$mesmenos = date('m-Y', $mesmenos);


		$services = $this->obternerServicios();
		$servicesactivesmesanterioir = array();
		if (isset($services->products->product)) {
			foreach ($services->products->product as $row) {
				$condicion = ($mesmenos == date("m-Y", strtotime($row->regdate)));
				if ($row->status == "Active" && $condicion) {
					$row->typeservice = $row->groupname . " " . $row->name;
					$servicesactivesmesanterioir[] = $row;
				}
			}
		}
		return array("mesactual" => $servicesactivesmesactual, "mesanterior" => $servicesactivesmesanterioir);
	}
	public function generarEstadisticas()
	{

		$comparativamesesservicios = $this->obtenerCrecimientoMesactualMesAnterior();
		$incrementoactual = "0";
		if (!empty($comparativamesesservicios['mesactual']) && !empty($comparativamesesservicios['mesanterior'])) {
			$incrementoactual = (((count($comparativamesesservicios['mesactual']) - count($comparativamesesservicios['mesanterior'])) / count($comparativamesesservicios['mesanterior'])) * 100);
		}


		//Cancelados este mes
		################################################
		$mes = date("m-Y");
		$services = $this->obternerServicios();
		$servicescancelledmes = array();
		if (isset($services->products->product)) {
			foreach ($services->products->product as $row) {
				$condicion = ($mes == date("m-Y", strtotime($row->regdate)));

				if ($row->status == "Cancelled" && $condicion) {
					$row->typeservice = $row->groupname . " " . $row->name;
					$servicescancelledmes[] = $row;
				}
			}
		}
		################################################

		$services = $this->obternerServicios();
		$servicesactivesmes = array();
		if (isset($services->products->product)) {
			foreach ($services->products->product as $row) {
				$condicion = ($mes == date("m-Y", strtotime($row->regdate)));

				if ($row->status == "Active" && $condicion) {
					$row->typeservice = $row->groupname . " " . $row->name;
					$servicesactivesmes[] = $row;
				}
			}
		}

		$services = $this->obternerServicios();
		$servicesactives = array();
		if (isset($services->products->product)) {
			foreach ($services->products->product as $row) {
				if ($row->status == "Active") {
					$row->typeservice = $row->groupname . " " . $row->name;
					$servicesactives[] = $row;
				}
			}
		}
		$serviciosactivos = count($servicesactives);
		$servicioscanceladosmes = count($servicescancelledmes);
		$serviciosactivosmes = count($servicesactivesmes);
		$porcentajedecrecimiento = $incrementoactual;

		$source = "";
		$sourceicon = "arrow-right";
		if ($porcentajedecrecimiento == 0) {

			$source = base_url("recursos/assets/images/src/resellers/statusservices/equal.png");
			$sourceicon = "arrow-right";
		}
		if ($porcentajedecrecimiento < 0) {

			$source = base_url("recursos/assets/images/src/resellers/statusservices/down.png");
			$sourceicon = "arrow-down";
		}
		if ($porcentajedecrecimiento > 0) {

			$source = base_url("recursos/assets/images/src/resellers/statusservices/up.png");
			$sourceicon = "arrow-up";
		}

		$data = array(
			"totalactivos" => $serviciosactivos,
			"activosmes" => $serviciosactivosmes,
			"canceladosmes" => $servicioscanceladosmes,
			"porcentajecrecimiento" => $porcentajedecrecimiento,
			"recursoimagen" => $source,
			"icon" => $sourceicon,

		);
		echo json_encode($data);
	}
}
