<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CComisiones extends CI_Controller
{

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
		$urlogin = url_login_admin();
		if ($this->session->userdata('user')) {
			$sesion = $this->session->userdata('user');
			if ($sesion['lg_usuarios_lg_perfiles_id'] != 1) {
				header("Location: {$urlogin}");
			}
		} else {
			header("Location: {$urlogin}");
		}
	}
	public function vendedores()
	{
		$this->load->view('masterPageCards/comisiones/vendedores');
	}
	public function vendedoresclientes()
	{
		$this->load->view('masterPageCards/comisiones/clientesvendedores');
	}
	public function reportes()
	{
		$this->load->view('masterPageCards/comisiones/reportes');
	}
	public function reportestickets()
	{
		$this->load->view('masterPageCards/comisiones/reportestickets');
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
	public function getOperadores()
	{
		echo $this->whmcs->funcion('GetAdminUsers', ["responsetype" => "json", "limitnum" => 1000000]);
	}
	public function insertVendedores()
	{
		$ven_nombre = $this->input->post("ven_nombre", true);
		$ven_ape_pat = $this->input->post("ven_ape_pat", true);
		$ven_ape_mat = $this->input->post("ven_ape_mat", true);
		$ven_porcentaje = $this->input->post("ven_porcentaje", true);

		$data = array(
			"ven_nombre" => $ven_nombre,
			"ven_ape_pat" => $ven_ape_pat,
			"ven_ape_mat" => $ven_ape_mat,
			"ven_porcentaje" => $ven_porcentaje,
		);
		$this->cm->insertVendedores($data);
	}
	public function insertUserVendedor()
	{
		$passwordline = $this->utilerias->generatePassword(7);
		$lg_usuarios_nombre = $this->input->post("lg_usuarios_nombre", true);
		$lg_usuarios_correo = $this->input->post("lg_usuarios_correo", true);
		$lg_usuarios_password = $this->seguridad->encriptar($passwordline);
		$lg_usuarios_lg_perfiles_id = 2;
		$lg_activo = 1;
		$lg_external_id = $this->input->post("lg_external_id", true);
		$action = $this->input->post("lg_action", true);
		$data = array(
			"lg_usuarios_nombre" => $lg_usuarios_nombre,
			"lg_usuarios_correo" => $lg_usuarios_correo,
			"lg_usuarios_password" => $lg_usuarios_password,
			"lg_usuarios_lg_perfiles_id" => $lg_usuarios_lg_perfiles_id,
			"lg_activo" => $lg_activo,
			"lg_external_id" => $lg_external_id,
			"lg_reset" => 1
		);


		switch ($action) {
			case "create":
				$datatemplate['titulo'] = "Bienvenido a Intranet Blazar, estos son tus accesos.";
				$link = base_url("directory/login");
				$datatemplate['mensaje'] = "<p>Usuario: {$lg_usuarios_nombre}</p><p>Contraseña: {$passwordline}</p><br><p>Ingrese a: <a href='{$link}'>{$link}</a></p>";
				$html = $this->load->view('emailtemplates/setpassword/v1/index', $datatemplate, TRUE);
				$this->sendmail->setEmail(1, $lg_usuarios_correo, "Nuevo usuario creado", $html);
				//	var_dump($data);
				$this->cm->insertUserVendedor($data);
				break;
			case "update":

				$data = array(
					"lg_usuarios_nombre" => $lg_usuarios_nombre,
					"lg_usuarios_correo" => $lg_usuarios_correo,
					"lg_usuarios_lg_perfiles_id" => $lg_usuarios_lg_perfiles_id,
					"lg_activo" => 1,
				);
				$where = array(
					"lg_external_id" => $lg_external_id,					"lg_usuarios_lg_perfiles_id" => $lg_usuarios_lg_perfiles_id
				);
				$this->cm->updateUserVendedor($data, $where);
				break;
		}
	}
	public function reesetPasswordVendedor()
	{
		$passwordline = $this->utilerias->generatePassword(7);
		$lg_usuarios_nombre = $this->input->post("lg_usuarios_nombre", true);
		$lg_usuarios_correo = $this->input->post("lg_usuarios_correo", true);
		$lg_usuarios_lg_perfiles_id = 2;
		$lg_external_id = $this->input->post("lg_external_id", true);


		$lg_usuarios_password = $this->seguridad->encriptar($passwordline);
		$data = array(
			"lg_usuarios_password" => $lg_usuarios_password,
			"lg_reset" => 1
		);
		$where = array(
			"lg_external_id" => $lg_external_id,					"lg_usuarios_lg_perfiles_id" => $lg_usuarios_lg_perfiles_id
		);
		$this->cm->updateUserVendedor($data, $where);

		$datatemplate['titulo'] = "Bienvenido a Intranet Blazar, estos son tus nuevos accesos.";
		$link = base_url("directory/login");
		$datatemplate['mensaje'] = "<p>Usuario: {$lg_usuarios_nombre}</p><p>Contraseña: {$passwordline}</p><br><p>Ingrese a: <a href='{$link}'>{$link}</a></p>";
		$html = $this->load->view('emailtemplates/setpassword/v1/index', $datatemplate, TRUE);
		$this->sendmail->setEmail(1, $lg_usuarios_correo, "Usuario reestablecido", $html);
	}
	public function disableVendedoresCliente()
	{
		$lg_external_id = $this->input->post("lg_external_id", true);
		$data = array("lg_activo" => 0);
		$where = array("lg_usuarios_lg_perfiles_id" => 2, "lg_external_id" => $lg_external_id);
		$this->cm->updateUserVendedor($data, $where);
	}
	public function insertVendedoresCliente()
	{
		$ven_cl_idcliente = $this->input->post("cliente", true);
		$ven_cl_idvendedor = $this->input->post("vendedor", true);
		$data = array();
		$where = array("ven_cl_idcliente" => $ven_cl_idcliente);
		if ($ven_cl_idvendedor != 0) {
			$data = array("ven_cl_idcliente" => $ven_cl_idcliente, "ven_cl_idvendedor" => $ven_cl_idvendedor);
			$vendedoresClientes = $this->cm->getVendedoresClientes($where)->num_rows();

			if ($vendedoresClientes > 0) {
				$this->cm->deleteVendedoresClientes($where);
				$this->cm->insertVendedoresClientes($data);
			} else {
				$this->cm->insertVendedoresClientes($data);
			}
		} else {

			$this->cm->deleteVendedoresClientes($where);
		}
	}
	public function updateVendedores()
	{
		$ven_nombre = $this->input->post("ven_nombre", true);
		$ven_ape_pat = $this->input->post("ven_ape_pat", true);
		$ven_ape_mat = $this->input->post("ven_ape_mat", true);
		$ven_porcentaje = $this->input->post("ven_porcentaje", true);
		$ven_idvendedor = $this->input->post("ven_idvendedor", true);
		$where = array("ven_idvendedor" => $ven_idvendedor);

		$data = array(
			"ven_nombre" => $ven_nombre,
			"ven_ape_pat" => $ven_ape_pat,
			"ven_ape_mat" => $ven_ape_mat,
			"ven_porcentaje" => $ven_porcentaje,
		);
		$this->cm->updateVendedores($data, $where);
	}
	public function deleteVendedores()
	{
		$ven_idvendedor = $this->input->post("id", true);
		$where = array("ven_idvendedor" => $ven_idvendedor);
		$data = array("ven_activo" => 0);
		$this->cm->deleteVendedoresClientes(array("ven_cl_idvendedor" => $ven_idvendedor));
		$this->cm->updateVendedores($data, $where);
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
			//RECORE LAS FACTURAS POR USUARIO
			if (isset($resultadofacturas[$q]->invoices->invoice)) {
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
			if (isset($facturasfinales[$d]->firstname)) {
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
	public function getComisionesTickets()
	{
		$date = $this->input->post("date", true);
		$anio = date("Y", strtotime($date));
		$mes = date("m", strtotime($date));




		$ticketst = [];
		$datosoperadores = json_decode($this->whmcs->funcion('GetAdminUsers', ["responsetype" => "json", "limitnum" => 1000000]));


		$result = json_decode($this->whmcs->funcion('GetTickets', ["responsetype" => "json", "limitnum" => 1000000, "status" => "closed"]));
		$deptid = [4, 6, 7]; //4 SOPORTE TECNICO, 6 Poliza de soporte 7 Consultoria
		//var_dump($result);
		foreach ($result->tickets->ticket as $ticket) {
			//$ticket->flag es el id del operador que esta contestando el ticket
			//check_in_range revisa la fecha en un rango del mes
			if ($this->check_in_range($ticket->lastreply, $anio, $mes) && $ticket->flag != 0) {
				//compara los departamentos si esta asignado en alguno de ellos
				foreach ($deptid as $dep) {
					//(***************** AQUI EMPIEZA A CONTABILIZAR TICKTES)
					if ($dep == $ticket->deptid) {
						foreach ($datosoperadores->admin_users as $useradmin) {
							if ($ticket->flag == $useradmin->id) {
								$ticket->operador = "{$useradmin->firstname} {$useradmin->lastname}";
								$ticket->bono = 100;
								if ($ticket->deptid == 7) {
									$ticket->bono = 250;
								}
							}
						}
						$ticketst[] = $ticket;
						//	echo json_encode($ticket) . "<br><br>";
						//echo "ticket id {$ticket->ticketid}, departamente: {$ticket->deptname}, cliente: {$ticket->name}, asunto: {$ticket->subject}, FECHA {$ticket->date}";
					}
				}
			}
		}
		$ticketsparse = $this->purgarArray($ticketst);
		$data = [];

		if (isset($_POST['id']) && $_POST['id'] != 0) {
			if (isset($ticketsparse[$_POST['id']])) {
				$data = $ticketsparse[$_POST['id']]['tickets'];
			}
		} else {
			foreach ($ticketsparse as $row) {
				foreach ($row['tickets'] as $rows) {
					$data[] = $rows;
				}
			}
		}
		echo json_encode($data);
	}

	function purgarArray($obj)
	{
		$flags = [];
		foreach ($obj as $element) {
			array_push($flags, $element->flag);
		}
		$flagunics = array_unique($flags);


		$result = [];
		foreach ($obj as $o) {
			$ticketstotal = 0;
			foreach ($flagunics as $flag) {
				$ticketstotal = $ticketstotal + 1;
				if ($o->flag == $flag) {
					$result[$flag]['tickets'][] = $o;
				}
			}
		}
		return $result;
	}
	function check_in_range($fecha, $anio, $mes)
	{

		$fechaini = date("{$anio}-{$mes}-01");

		$fechafin = date("{$anio}-{$mes}-t");


		$bool = false;

		$date = date("Y-m-d", strtotime($fecha));
		if (($date >= $fechaini) && ($date <= $fechafin)) {

			$bool = true;
		}
		return $bool;
	}
}
