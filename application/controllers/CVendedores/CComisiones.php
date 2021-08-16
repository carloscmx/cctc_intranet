<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CComisiones extends CI_Controller
{


	private $templates;

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('scripts');
		$this->load->library("whmcs");
		$this->load->library("template");
		$this->load->library("utilerias");
		$this->load->model("M_Comisiones", "cm");
		$this->load->library("seguridad");
		$this->load->library("Sendmail");
		$this->load->model("M_Logininternal", "ml");
		$this->load->library("session");
		$this->load->library("datos");
		$urlogin = base_url("directory/login");

		if ($this->session->userdata('user')) {
			$sesion = $this->session->userdata('user');
			$external_id = $sesion['lg_external_id'];
			$data['datos'] = $this->datos->setDatosVendedor($external_id);

			$this->templates['head'] = $this->load->view('masterPageVendedores/head', $data, true);
			$this->templates['footer']  = $this->load->view('masterPageVendedores/footer', '', true);
		} else {
			// do something when doesn't exist
			header("Location: {$urlogin}");
		}
	}

	public function vendedores()
	{
		$template['head'] = $this->load->view('masterPageVendedores/head', '', true);
		$template['footer'] = $this->load->view('masterPageVendedores/footer', '', true);


		$this->load->view('masterPageCards/comisiones/cvendedores/vendedores', $template);
	}
	public function vendedoresclientes()
	{


		$this->load->view('masterPageCards/comisiones/CVendedores/clientesvendedores', $this->templates);
	}
	public function reportes()
	{

		$this->load->view('masterPageCards/comisiones/CVendedores/reportes',  $this->templates);
	}
	public function getVendedores()
	{
		$where = array("ven_activo" => 1);
		if (isset($_POST['query'])) {
			unset($_POST['query']);
			$where = $_POST;
		}
		$vendedores = $this->cm->getVendedores($where)->result_array();
		for ($i = 0; $i < count($vendedores); $i++) {
			$vendedores[$i]['ven_id_num_config'] = $this->utilerias->set_zero_format($vendedores[$i]['ven_idvendedor'], 5);
			$vendedores[$i]['ven_porcentaje_config'] = $vendedores[$i]['ven_porcentaje'] . "%";
			$vendedores[$i]['ven_nombrecompleto_config'] = $vendedores[$i]['ven_nombre'] . " " . $vendedores[$i]['ven_ape_pat'] . " " . $vendedores[$i]['ven_ape_mat'];
			$idvendedores = $vendedores[$i]['ven_idvendedor'];
			$vendedores[$i]["buttons"] = "<button type='button' class='btn btn-success' onclick='abrirModificar({$idvendedores})'>Editar</button> <button type='button' class='btn btn-danger' onclick='confirmarEliminar({id:{$idvendedores}})'>Eliminar</button>";
		}
		echo json_encode(array("data" => $vendedores));
	}



	public function getClients()
	{
		$vendedoresClientes = $this->cm->getVendedoresClientesJoinVendedores(array("ven_activo" => 1))->result_array();
		$vendedores = $this->cm->getVendedores(array("ven_activo" => 1))->result_array();
		$result =	json_decode($this->whmcs->funcion('GetClients', array("responsetype" => "json", "limitnum" => 1000000, "status" => "Active")));
		for ($i = 0; $i < $result->numreturned; $i++) {
			$cliente = $result->clients->client[$i];
			$vendedor = 0;
			$options = "";

			for ($x = 0; $x < count($vendedoresClientes); $x++) {

				if ($vendedoresClientes[$x]['ven_cl_idcliente'] == $cliente->id) {
					$vendedor = $vendedoresClientes[$x]['ven_cl_idvendedor'];
				}

				//$options .= "<option {$status} value='{$vendedorselect}'>{$nombrevenderdor}</option>";
			}
			for ($q = 0; $q < count($vendedores); $q++) {
				$status = "";
				if ($vendedor == $vendedores[$q]['ven_idvendedor']) {
					$status = "selected ";
				}
				$nombrevenderdor = $vendedores[$q]['ven_nombre'] . " " . $vendedores[$q]['ven_ape_pat'];
				$vendedorselect = $vendedores[$q]['ven_idvendedor'];
				$options .= "<option {$status} value='{$vendedorselect}'>{$nombrevenderdor}</option>";
			}


			$button = "<select class='form-control' onchange='javascript:cambiarVendedor(this,{$cliente->id})'>
			<option value='0'>Sin definir vendedor</option>		
			{$options}	
			</select>";

			$cliente->nombrecompleto = $cliente->firstname . " " . $cliente->lastname;
			$cliente->vendedor = $vendedor;
			$cliente->buttons = $button;
			$resultadoaclientes[] = $cliente;
		}
		//	echo $button;
		echo json_encode(array("data" => $resultadoaclientes));
	}

	public function getUsers()
	{
		$where = array("lg_activo" => 1);
		if (isset($_POST['query'])) {
			unset($_POST['query']);
			$where = $_POST;
		}
		$users = $this->ml->getUsers($where)->result_array();
		echo json_encode(array("data" => $users));
	}
	public function ReturnInvoicesForClient($userid, $status)
	{
		return json_decode($this->whmcs->funcion('GetInvoices', array("responsetype" => "json", "limitnum" => 1000000, "status" => $status, "userid" => $userid)));
	}
	public function getInvoicesForVendedor()
	{
		$ven_cl_idvendedor = $this->input->post("ven_cl_idvendedor", true);
		$datepaid = $this->input->post("datepaid", true);
		$where = array("ven_cl_idvendedor" => $ven_cl_idvendedor);
		$vendedoresClientes = $this->cm->getVendedoresClientes($where)->result_array();
		$vendedor = $this->cm->getVendedores(array("ven_idvendedor" => $ven_cl_idvendedor))->result_array();
		$poncentajecomision = $vendedor[0]['ven_porcentaje'];
		for ($i = 0; $i < count($vendedoresClientes); $i++) {
			$resultadofacturas[] = $this->ReturnInvoicesForClient($vendedoresClientes[$i]['ven_cl_idcliente'], "paid");
		}
		//Recorre las peticiones por usuario
		for ($q = 0; $q < count($resultadofacturas); $q++) {
			if (isset($resultadofacturas[$q]->invoices->invoice)) {
				//RECORE LAS FACTURAS POR USUARIO
				for ($x = 0; $x < count($resultadofacturas[$q]->invoices->invoice); $x++) {
					//var_dump($resultadofacturas[$q]->invoices->invoice[$x]->datepaid);
					$fecha_entrada = date("m-Y", strtotime($resultadofacturas[$q]->invoices->invoice[$x]->datepaid));
					//DESCARTAMOS LAS FACTURAS QUE NO CORRESPONDEN CON EL MES SOLICITADO
					if ($fecha_entrada == $datepaid) {
						$facturasfinales[] = $resultadofacturas[$q]->invoices->invoice[$x];
					}
				}
			}
		}
		//AHORA PURGAMOS LAS FACTURAS VALIDAS
		for ($d = 0; $d < count($facturasfinales); $d++) {
			if (isset(($facturasfinales[$d]->firstname))) {
				$nombre = $facturasfinales[$d]->firstname . " " . $facturasfinales[$d]->lastname;
				$empresa = $facturasfinales[$d]->companyname;
				$nreferencia = $facturasfinales[$d]->invoicenum;
				$fechapago = $facturasfinales[$d]->datepaid;
				$subtotal = $facturasfinales[$d]->subtotal;
				$comision = ($subtotal * $poncentajecomision) / 100;
				$referencias[] = array("nombre" => $nombre, "empresa" => $empresa, "nreferencia" => $nreferencia, "fechapago" => $fechapago, "subtotal" => $subtotal, "ganaciacomision" => number_format($comision, 2));
			}
		}
		echo json_encode($referencias);
	}
}
