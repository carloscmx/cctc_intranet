<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CLicenciamiento extends CI_Controller
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
		$this->load->library("utilerias");
		$this->load->library("Sendmail");



		$this->load->model("M_Licencias", "modellicencias");
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
		$this->load->view('welcome_message');
	}
	public function getTipoLicencias()
	{
		$this->load->view("masterPageCards/licenciamiento/tipolicencias");
	}
	public function getAfiliados()

	{
		$this->load->view("masterPageCards/licenciamiento/afiliados");
	}
	public function getStock()

	{

		$where = "activo=1 OR activo=2";
		if (isset($_POST['query'])) {
			unset($_POST['query']);
			$where = $_POST;
		}
		//var_dump($where);
		$proveedores = $this->modellicencias->getProveedores($where)->result();
		$data['proveedores'] = $proveedores;
		$tipolicencia = $this->modellicencias->getTipoLicencia("activo=1 OR activo=2")->result();
		$data['tipolicencia'] = $tipolicencia;

		$data['estatuslicencia'] = [
			['nombre' => 'Disponible', 'value' => 1,],
			['nombre' => 'No disponible', 'value' => 0],
			['nombre' => 'Vendida', 'value' => 2],
		];


		$this->load->view("masterPageCards/licenciamiento/stock", $data);
	}
	public function getProveedores()

	{
		$this->load->view("masterPageCards/licenciamiento/proveedores");
	}

	/**
	 * JSON RETURNS
	 */
	public function getProveedoresdata()
	{
		$where = "activo=1 OR activo=2";
		if (isset($_POST['query'])) {
			unset($_POST['query']);
			$where = $_POST;
		}
		//var_dump($where);
		$proveedores = $this->modellicencias->getProveedores($where)->result_array();
		for ($i = 0; $i < count($proveedores); $i++) {
			$idproveedor = $proveedores[$i]['idprovedor'];
			$nombreproveedor = $proveedores[$i]['nombres'] . " " . $proveedores[$i]['apellidopat'];
			$proveedores[$i]['nombrecompleto'] = $nombreproveedor;
			$proveedores[$i]["buttons"] = "<button type='button' class='btn btn-success' onclick='abrirModificar({$idproveedor})'>Editar</button> <button type='button' class='btn btn-danger' onclick='confirmarEliminar({id:{$idproveedor}})'>Eliminar</button>";
		}


		echo json_encode(array("data" => $proveedores));
	}
	public function insertLicencia()
	{
		$licencia = $this->input->post("mlicencia", true);
		$idtipolicencia = $this->input->post("ntipolicencia", true);
		$activo = $this->input->post("nestatus", true);
		$fechacompra = $this->input->post("fchacompra", true);
		$fechaventa = $this->input->post("fchaventa", true);
		$costocompralic = $this->input->post("ccostocompra", true);
		$costoventalic	 = $this->input->post("ccostoventa", true);
		$idprovedorlic	 = $this->input->post("proveededor", true);
		$cantidadcals	 = $this->input->post("cantidadcals", true);
		$codigocals	 = $this->input->post("codigocals", true);
		$cantidadlicencia = $this->input->post("mnumerolicencia", true);

		$data = [
			'licencia' => $licencia,
			'idtipolicencia' => $idtipolicencia,
			'activo' => $activo,
			'fechacompra' => $fechacompra,
			'fechaventa' => $fechaventa,
			'costocompralic' => $costocompralic,
			'idprovedorlic' => $idprovedorlic,
			'costoventalic' => $costoventalic,
			'cantidadcals' => $cantidadcals,
			'codigocals' => $codigocals,
			'cantidadlicencia' => $cantidadlicencia
		];
		$this->modellicencias->insertLicencia($data);
	}
	public function insertTipoLicencia()
	{
		$nombrelicencia = $this->input->post("nombrelicencia", true);
		$comparativoPanel = $this->input->post("comparativoPanel", true);
		$data = array(
			"nombrelicencia" => $nombrelicencia,
			"comparativoPanel" => $comparativoPanel,
		);
		$this->modellicencias->insertTipoLicencia($data);
	}
	public function insertProveedorLicencia()
	{
		$activo = $this->input->post("activo", true);
		$costocompra = $this->input->post("costocompra", true);
		$idprov = $this->input->post("idprov", true);
		$idtipolicencia = $this->input->post("idtipolicencia", true);
		$data = array(
			"activo" => $activo,

			"costocompra" => $costocompra,

			"idprov" => $idprov,

			"idtipolicencia" => $idtipolicencia,

		);

		//echo json_encode($data);


		$this->modellicencias->insertProveedorLicencia($data);
	}
	public function UpdateProveedorLicencia()
	{
		$idlicprov = $this->input->post("idlicprov", true);
		$activo = $this->input->post("activo", true);
		$costocompra = $this->input->post("costocompra", true);
		$where = array("idlicprov" => $idlicprov);
		$data = array(
			"activo" => $activo,

			"costocompra" => $costocompra
		);

		//echo json_encode($data);


		$this->modellicencias->UpdateProveedorLicencia($where, $data);
	}
	public function getProvedorLicenciaData()
	{
		$where = null;
		if (isset($_POST['query'])) {
			unset($_POST['query']);
			$where = $_POST;
		}
		$proveedores = $this->modellicencias->getProvedorLicencia($where)->result_array();
		$tipolicencia = $this->modellicencias->getTipoLicencia("activo=1")->result_array();
		$data = [];
		$noencontradoarray = [];
		$encontradoarray = [];

		for ($i = 0; $i < count($tipolicencia); $i++) {
			$encontrado = false;
			for ($x = 0; $x < count($proveedores); $x++) {
				if ($tipolicencia[$i]['idlicencia'] == $proveedores[$x]['idtipolicencia']) {
					$encontrado = true;
					$encontradoarray[] = $proveedores[$x];
				}
			}
			if (!$encontrado) {
				$noencontradoarray[] = $tipolicencia[$i];
			}
		}
		$data = array("noencontrado" => $noencontradoarray, "encontrado" => $encontradoarray);



		echo json_encode($data);
	}
	public function deleteProveedores()
	{
		$id = $this->input->post("id", true);
		$where = array("idprovedor" => $id);
		$data = array("activo" => 0);
		$this->modellicencias->setUpdateProveedor($where, $data);
	}
	public function UpdatePredeterminadoProveedores()
	{
		$this->modellicencias->setUpdateProveedor(array("activo" => 2), array("activo" => 1));

		$id = $this->input->post("id", true);
		$where = array("idprovedor" => $id);
		$data = array("activo" => 2);
		$this->modellicencias->setUpdateProveedor($where, $data);
	}
	public function updateProveedores()
	{
		$id = $this->input->post("idprovedor", true);
		$nombres = $this->input->post("nombres", true);
		$apellidopat = $this->input->post("apellidopat", true);
		$apellidomat = $this->input->post("apellidomat", true);
		$correoproveedor = $this->input->post("correoproveedor", true);

		$where = array("idprovedor" => $id);
		$data = array("nombres" => $nombres, "apellidopat" => $apellidopat, "apellidomat" => $apellidomat, "correoproveedor" => $correoproveedor);
		$this->modellicencias->setUpdateProveedor($where, $data);
	}
	public function insertProveedores()
	{
		$id = $this->input->post("idprovedor", true);
		$nombres = $this->input->post("nombres", true);
		$apellidopat = $this->input->post("apellidopat", true);
		$apellidomat = $this->input->post("apellidomat", true);
		$correoproveedor = $this->input->post("correoproveedor", true);
		$data = array("nombres" => $nombres, "apellidopat" => $apellidopat, "apellidomat" => $apellidomat, "correoproveedor" => $correoproveedor);
		$this->modellicencias->insertProveedores($data);
	}
	public function getTiposLicencia()
	{
		$where = array("activo" => 1);
		if (isset($_POST['query'])) {
			unset($_POST['query']);
			$where = $_POST;
		}
		//var_dump($where);
		$tipolicencia = $this->modellicencias->getTipoLicencia($where)->result_array();
		for ($i = 0; $i < count($tipolicencia); $i++) {
			$idtipolicencia = $tipolicencia[$i]['idlicencia'];
			$tipolicencia[$i]["buttons"] = "<button type='button' class='btn btn-success' onclick='abrirModificar({$idtipolicencia})'>Editar</button> <button type='button' class='btn btn-danger' onclick='confirmarEliminar({id:{$idtipolicencia}})'>Eliminar</button>";
		}
		echo json_encode(array("data" => $tipolicencia));
	}

	public function getLicencias($json = null)
	{
		$rows = [];
		$tipolicencia = $this->modellicencias->getLicencias();
		foreach ($tipolicencia->result_array() as $row) {
			if (empty($row['cantidadlicencia'])) {
				$row['cantidadlicencia'] = "-";
			}
			$row['opciones'] = "<input type='submit' value='Relacion' class='btn btn-info' onclick='javascript:verRelacionLicencia({$row['idlicenciawin']})'>";
			$traslado = $this->modellicencias->getTraslados(["id_lic_stock" => $row['idlicenciawin']]);
			if ($traslado->num_rows() > 0) {
				$row['opciones'] = "<input type='submit' value='Detalles' class='btn btn-danger' onclick='javascript:verRelacionLicenciaLicencia({$row['idlicenciawin']})'>";
			}
			if (!$this->utilerias->fachageracionrelacionwindows($row['fechacompra'])) {
				$row['opciones'] = "-";
			}
			$rows[] = $row;
		}
		echo json_encode(array("data" => $rows));
	}
	public function deleteTipoLicencias()
	{
		$id = $this->input->post("id", true);
		$where = array("idlicencia" => $id);
		$data = array("activo" => 0);
		$this->modellicencias->setUpdateTipoLicencias($where, $data);
	}
	public function updateTipoLicencias()
	{
		$idlicencia = $this->input->post("idlicencia", true);
		$nombrelicencia = $this->input->post("nombrelicencia", true);
		$comparativoPanel = $this->input->post("comparativoPanel", true);
		$where = array("idlicencia" => $idlicencia);
		$data = array("nombrelicencia" => $nombrelicencia, "comparativoPanel" => $comparativoPanel);

		$this->modellicencias->setUpdateTipoLicencias($where, $data);
	}
	public function solicitarLicencia()
	{
		$sesion = $this->session->userdata('user');
		$external_id = $sesion['lg_external_id'];
		$datos = "";
		$datos = $this->datos->getPersonasAdministradores($external_id);

		$nombrecrea = $datos['usr_nombre'] . " " . $datos['usr_apellido_pat'];
		$result = ['status' => 'error'];
		$pedidoProveedor = $this->input->post("pedidoProveedor", true);
		$pedidoTipoLicencia = $this->input->post("pedidoTipoLicencia", true);
		$pedidoCantidadPc = $this->input->post("pedidoCantidadPc", true);
		$pedidoNota = $this->input->post("pedidoNota", true);
		$token = $this->utilerias->generateToken();
		$npedido = $this->utilerias->generarceros(rand(0, 99999), 7);

		$costolicencia = 0;
		$urltoken = base_url("licenciamiento/pedido/windows/{$token}");
		$costoLicenciaobj = $this->modellicencias->obtenerCostoLicencia([
			'idtipolicencia' => $pedidoTipoLicencia,
			'idprov' => $pedidoProveedor
		]);
		$proveedordatos = $this->modellicencias->getProveedores([
			'idprovedor' => $pedidoProveedor
		])->row();
		$licenciadatos = $this->modellicencias->getTipoLicencia(['idlicencia' => $pedidoTipoLicencia])->row();
		if ($costoLicenciaobj->num_rows() > 0) {
			$ret = $costoLicenciaobj->row();
			$costolicencia = $ret->costocompra;
			$costocompra = $costolicencia * $pedidoCantidadPc;
			$result = ['status' => 'success'];
			$this->modellicencias->insertarPedidoLicencia([
				'int_id_proveedor' => $pedidoProveedor,
				'int_id_tipo_licencia' => $pedidoTipoLicencia,
				'txt_url_token' => $token,
				'txt_nota' => $pedidoNota,
				'int_cantidad_licencia' => $pedidoCantidadPc,
				'dou_costo_licencia	' => $costolicencia,
				'var_autoriza' => $nombrecrea,
				'var_codigo_pedido' => $npedido,
				'int_activo_pedido' => 1

			]);
			$html = $this->returnHTMLTemplatePedido([
				'nombreProveedor' => $proveedordatos->nombres . " " . $proveedordatos->apellidopat,
				'urltoken' => $urltoken,
				'nombreLicencia' => $licenciadatos->nombrelicencia,
				'cantidadLicencia' => $pedidoCantidadPc,
				'notaPedido' => $pedidoNota,
				'nombreAutoriza' => $nombrecrea,
				'codigoPedido' => $npedido,
				'costoUnitarioPedido' => $this->utilerias->generarDecimales($costolicencia),
				'costoTotalPedido' => $this->utilerias->generarDecimales($costocompra)
			]);
			$this->sendmail->setEmail(1, $proveedordatos->correoproveedor, "Solicitud de licencia.", $html);
		}

		echo json_encode($result);
	}
	public function returnHTMLTemplatePedido($data)
	{
		return $this->load->view("emailtemplates/setorderlicense/v1/content.php", $data, TRUE);
	}
	public function abrirFormularioPedido()
	{
		$token = $this->uri->segment(4);
		$pedido = $this->modellicencias->obtenerPedidoLicencia([
			'txt_url_token' => $token,
		]);
		if ($pedido->num_rows() > 0) {
			$pedido = $pedido->row();
			$proveedor = $this->modellicencias->getProveedores([
				'idprovedor' => $pedido->int_id_proveedor
			])->row();
			$licencia = $this->modellicencias->getTipoLicencia([
				'idlicencia' => $pedido->int_id_tipo_licencia
			])->row();
			$this->load->view("licencias/pedido/v1/index.php", ['pedido' => $pedido, 'proveedor' => $proveedor, 'licencia' => $licencia]);
		} else {
			show_error("NO SE HA ENCONTRADO ESTE PEDIDO", 404, "NO ENCONTRADO");
		}
	}
	public function aceptarPedido()
	{
		$codigolicencia = $this->input->post("licencia", true);
		$estatus = ['status' => 'error'];
		$data = [
			'int_numero_cal' => $this->input->post("cantidadcals", true),
			'var_serie_cal' => $this->input->post("codigocal", true),
			'txt_licencia' => $codigolicencia,
			'int_activo_pedido' => 2,
			'tsp_fecha_entrega' => date("Y-m-d H:i:s")
		];
		if ($this->modellicencias->obtenerPedidoLicencia(['txt_licencia' => $codigolicencia])->num_rows() == 0) {

			$this->modellicencias->actualizarPedidoLicencia($data, ['int_id_pedido' => $this->input->post("idpedido", true)]);


			$pedido = $this->modellicencias->obtenerPedidoLicencia(['int_id_pedido' => $this->input->post("idpedido", true)])->row();
			$costototal = $pedido->int_cantidad_licencia * $pedido->dou_costo_licencia;
			$this->modellicencias->insertLicencia([
				'licencia' => $pedido->txt_licencia,
				'idtipolicencia' => $pedido->int_id_tipo_licencia,
				'activo' => 1,
				'fechacompra' => $pedido->tsp_fecha_pedido,
				'costocompralic' => $costototal,
				"idprovedorlic" => $pedido->int_id_proveedor,
				"cantidadcals" => $pedido->int_numero_cal,
				"codigocals" => $pedido->var_serie_cal,
				"cantidadlicencia" => $pedido->int_cantidad_licencia
			]);
			$estatus = ['status' => 'success'];
		}
		echo json_encode($estatus);
	}
	public function mandarPagoPedido()
	{
		$sesion = $this->session->userdata('user');
		$external_id = $sesion['lg_external_id'];
		$datos = "";
		$datos = $this->datos->getPersonasAdministradores($external_id);

		$nombrecrea = $datos['usr_nombre'] . " " . $datos['usr_apellido_pat'];
		$idpedido = $this->input->post("idpedido");
		$data = [
			'int_estatus_pago' => 1,
			'tsp_fecha_pago' => date("Y-m-d H:i:s"),
			'var_autoriza_pago' => $nombrecrea
		];
		$this->modellicencias->actualizarPedidoLicencia($data, ['int_id_pedido' => $idpedido]);
	}
	public function obtenerPedidos()
	{
		$this->load->view("masterPageCards/licenciamiento/pedidos");
	}
	public function obtenerPedidosJson()
	{
		$rows = [];
		$pedidos = $this->modellicencias->obtenerPedidoLicencia()->result();

		foreach ($pedidos as $row) {
			$vendedor = $this->modellicencias->getProveedores(['idprovedor' => $row->int_id_proveedor])->row();
			$row->vendedor = $vendedor->nombres . " " . $vendedor->apellidopat;
			$licencia = $this->modellicencias->getTipoLicencia(['idlicencia' => $row->int_id_tipo_licencia])->row();
			$row->tipolicencia = $licencia->nombrelicencia;

			$costototal = $row->dou_costo_licencia * $row->int_cantidad_licencia;
			$row->costototal = "$" . $this->utilerias->generarDecimales($costototal);

			$row->verdetalles = "<input type='submit' value='Ver detalles' onclick='javascript:verDetalle({$row->int_id_pedido})' class='btn btn-info'>";

			$row->npedido = "#" . $row->var_codigo_pedido;
			switch ($row->int_activo_pedido) {
				case 0:
					$row->estatuspedido = "<strong style='color:red;'>CANCELADA<strong>";
					break;
				case 1:
					$row->estatuspedido = "<strong style='color:red;'>PENDIENTE DE ENTREGA<strong>";
					break;
				case 2:
					$row->estatuspedido = "<strong style='color:green;'>ENTREGADO<strong>";
					break;
			}
			switch ($row->int_estatus_pago) {
				case 0:
					if ($row->int_activo_pedido == 2) {
						$row->estatuspago = "<input type='submit' value='MARCAR COMO PAGADA' class='btn btn-danger' onclick='javascript:marcarPago({$row->int_id_pedido})'>";
					} else {
						$row->estatuspago = "<strong>-</strong>";
					}
					break;
				case 1:
					$row->estatuspago = "<strong style='color:green;'>PAGADO<strong>";
					break;
			}
			$rows[] = $row;
		}
		echo json_encode(["data" => $rows]);
	}
	public function obtenerPedidosJsonWhere()
	{
		$idpedido = $this->input->post("idpedido");
		$rows = [];
		$pedidos = $this->modellicencias->obtenerPedidoLicencia(["int_id_pedido" => $idpedido])->result();

		foreach ($pedidos as $row) {
			$vendedor = $this->modellicencias->getProveedores(['idprovedor' => $row->int_id_proveedor])->row();
			$row->vendedor = $vendedor->nombres . " " . $vendedor->apellidopat;
			$licencia = $this->modellicencias->getTipoLicencia(['idlicencia' => $row->int_id_tipo_licencia])->row();
			$row->tipolicencia = $licencia->nombrelicencia;

			$costototal = $row->dou_costo_licencia * $row->int_cantidad_licencia;
			$row->costototal = "$" . $this->utilerias->generarDecimales($costototal);

			$row->verdetalles = "<input type='submit' value='Ver detalles' onclick='javascript:verDetalle({$row->int_id_pedido})' class='btn btn-info'>";

			$row->npedido = "#" . $row->var_codigo_pedido;
			switch ($row->int_activo_pedido) {
				case 0:
					$row->estatuspedido = "<strong style='color:red;'>CANCELADA</strong>";
					break;
				case 1:
					$row->estatuspedido = "<strong style='color:red;'>PENDIENTE DE ENTREGA</strong>";
					break;
				case 2:
					$row->estatuspedido = "<strong style='color:green;'>ENTREGADO</strong>";
					break;
			}
			switch ($row->int_estatus_pago) {
				case 0:
					$row->estatuspago = "<strong style='color:red;'>NO PAGADA</strong>";
					break;
				case 1:
					$row->estatuspago = "<strong style='color:green;'>PAGADO</strong>";
					break;
			}
			$rows[] = $row;
		}
		echo json_encode(["data" => $row]);
	}
	public function obtenerDatosRelacionLicencia()
	{
		$resultado = "";
		$tiporelacion = $this->input->post("tiporelacion", true);
		$tiporelacionval = $tiporelacion == 1;
		if ($tiporelacionval) {
			$resultado =	$this->whmcs->funcion('GetClients', ["responsetype" => "json", "limitnum" => 1000000]);
		} else {
			$resultado =	$this->whmcs->funcion('GetClientsProducts', ["responsetype" => "json", "limitnum" => 1000000]);
		}
		$resultado = json_decode($resultado);
		$input = "  <option disabled selected value> -- Seleccione una opcion -- </option>";
		$jsonresult = [];
		$rowsjson = [];
		if ($tiporelacionval) {
			foreach ($resultado->clients->client as $row) {
				$input .= "<option value='{$row->id}'>{$row->firstname} {$row->lastname} - {$row->companyname}</option>";

				$jsonresult['id'] = $row->id;
				$jsonresult['text'] = "{$row->firstname} {$row->lastname} - {$row->companyname}";

				$rowsjson[] = $jsonresult;
			}
		} else {
			foreach ($resultado->products->product as $row) {
				$input .= "<option value='{$row->id}'>{$row->groupname} - {$row->domain}</option>";

				$jsonresult['id'] = $row->id;
				$jsonresult['text'] = "{$row->groupname} - {$row->domain}";
				$rowsjson[] = $jsonresult;
			}
		}
		//echo $input;
		echo json_encode($rowsjson);
	}
	public function transferirLicencia()
	{
		$tipoRegistro = $this->input->post("tipoRegistro", true);
		$fechacambio = date("Y-m-d H:i:s");
		$responsableCambio = $this->datos->obtenerNombreAdminActual();
		$idstocktraslado = $this->input->post("id_lic_stock", true);
		$condiciontraslado = $tipoRegistro == 1;
		$idexterno = $this->input->post("idexterno", true);
		$licencia = $this->modellicencias->getLicencia(['idlicenciawin' => $idstocktraslado])->row();
		$tipolicencia = $this->modellicencias->getTipoLicencia([
			'idlicencia' => $licencia->idtipolicencia
		])->row();
		$data = [
			'id_lic_stock' => $idstocktraslado,
			'var_tras_responsable' => $responsableCambio,
			'tsp_tras_fecha_mov' => $fechacambio,
			'int_tras_tipo' => $tipoRegistro,
			'int_tras_id_externo' => $idexterno
		];

		$this->modellicencias->trasladoStock($data);

		if ($condiciontraslado) {
			$datoscliente = json_decode($this->whmcs->funcion('GetClientsDetails', [
				'clientid' => $idexterno,
				'stats' => false,
				'responsetype' => 'json'
			]))->client;



			$nombrecliente = $datoscliente->fullname;
			$correocliente = $datoscliente->email;
			$mensaje = "Hola {$nombrecliente} tu pedido ha sido entregado correctamente.
			Detalles de pedido
			Licencia: {$licencia->licencia}
			Cantidad de dispositivos: {$licencia->cantidadlicencia}
			Tipo de licencia: {$tipolicencia->nombrelicencia}
			Cantidad de licencia CAL: {$licencia->cantidadcals}
			Codigo CAL: {$licencia->codigocals}
			";
			$mensajehtml = "<p>Hola {$nombrecliente} tu pedido ha sido entregado correctamente.</p>
			<h4>Detalles de pedido<h4>
			<p>Licencia: {$licencia->licencia}</p>
			<p>Cantidad de dispositivos: {$licencia->cantidadlicencia}</p>
			<p>Tipo de licencia: {$tipolicencia->nombrelicencia}</p>
			<p>Cantidad de licencia CAL: {$licencia->cantidadcals}</p>
			<p>Codigo CAL: {$licencia->codigocals}</p>
			";
			$this->whmcs->funcion('OpenTicket', ["deptid" => 5, "subject" => "Licencia Exclusiva {$tipolicencia->nombrelicencia}", "message" => $mensaje, "responsetype" => "json", "clientid" => $idexterno, "admin" => true]);
			$this->whmcs->funcion('SendEmail', ["customsubject" => "Licencia Exclusiva {$tipolicencia->nombrelicencia}", "custommessage" => $mensajehtml, "responsetype" => "json", "id" => $idexterno, "customtype" => "general"]);
			$email = "<p>{$responsableCambio} ha entregado la licencia {$licencia->licencia} al cliente {$nombrecliente} el dia: {$fechacambio}</p>";
			$this->whmcs->funcion('SendAdminEmail', [
				'customsubject' => "Licencia {$tipolicencia->nombrelicencia} entregada correctamente.",
				'custommessage' => $email,
				'responsetype' => 'json',
			]);
		} else {
			$licencia = $this->modellicencias->getLicencia(['idlicenciawin' => $idstocktraslado])->row();
			$datosservicio = json_decode($this->whmcs->funcion('GetClientsProducts', [
				'serviceid' => $idexterno,
				'responsetype' => 'json',
				'limitnum' => 1
			]))->products->product[0];
			$clientid = $datosservicio->clientid;
			//var_dump($datosservicio);
			$result = $this->whmcs->buscadorOpcion($datosservicio->customfields->customfield, nombre_input_licencia_windows());

			$this->whmcs->funcion('UpdateClientProduct', [
				'responsetype' => 'json',
				'serviceid' => $idexterno,
				'customfields' => base64_encode(serialize(array($result->id => $licencia->licencia))),

			]);

			$datoscliente = json_decode($this->whmcs->funcion('GetClientsDetails', [
				'clientid' => $clientid,
				'stats' => false,
				'responsetype' => 'json'
			]))->client;



			$nombrecliente = $datoscliente->fullname;
			$correocliente = $datoscliente->email;
			$mensaje = "Hola {$nombrecliente} tu licencia ha sido entregado correctamente.
			Detalles de pedido
			Licencia: {$licencia->licencia}
			Cantidad de dispositivos: {$licencia->cantidadlicencia}
			Servicio relacionado: {$datosservicio->name}-{$datosservicio->domain}
			Tipo de licencia: {$tipolicencia->nombrelicencia}
			Cantidad de licencia CAL: {$licencia->cantidadcals}
			Codigo CAL: {$licencia->codigocals}
			";
			$this->whmcs->funcion('OpenTicket', ["deptid" => 5, "subject" => "Licencia Exclusiva {$tipolicencia->nombrelicencia}", "message" => $mensaje, "responsetype" => "json", "clientid" => $clientid, "admin" => true]);
			$email = "<p>{$responsableCambio} ha entregado la licencia {$licencia->licencia} al cliente {$nombrecliente} el dia: {$fechacambio}</p>";
			$this->whmcs->funcion('SendAdminEmail', [
				'customsubject' => "Licencia {$tipolicencia->nombrelicencia} entregada correctamente.",
				'custommessage' => $email,
				'responsetype' => 'json',
			]);
			$mensajehtml = "<p>Hola {$nombrecliente} tu pedido ha sido entregado correctamente.</p>
			<h4>Detalles de pedido<h4>
			<p>Licencia: {$licencia->licencia}</p>
			<p>Cantidad de dispositivos: {$licencia->cantidadlicencia}</p>
			<p>Servicio relacionado: {$datosservicio->name}-{$datosservicio->domain}</p>
			<p>Tipo de licencia: {$tipolicencia->nombrelicencia}</p>
			<p>Cantidad de licencia CAL: {$licencia->cantidadcals}</p>
			<p>Codigo CAL: {$licencia->codigocals}</p>
			";
			echo $this->whmcs->funcion('SendEmail', ["customsubject" => "Licencia Exclusiva {$tipolicencia->nombrelicencia}", "custommessage" => $mensajehtml, "responsetype" => "json", "id" => $clientid, "customtype" => "general"]);
		}
	}
	public function getTrasladoIdStockLicencia()
	{
		$idtraslado = $this->input->post("id_lic_stock");
		$traslado = $this->modellicencias->getTraslados(["id_lic_stock" => $idtraslado])->row();
		if ($traslado->int_tras_tipo == 1) {
			$detalle = json_decode($this->whmcs->funcion('GetClientsDetails', ["responsetype" => "json", "clientid" => $traslado->int_tras_id_externo]))->client->fullname;
			$traslado->detalle = "Cliente relacionado: {$detalle}";
		} else {
			$detalle = json_decode($this->whmcs->funcion('GetClientsProducts', ["responsetype" => "json", "serviceid" => $traslado->int_tras_id_externo]))->products->product[0];
			$traslado->detalle = "Servicio relacionado: {$detalle->groupname}-{$detalle->domain}";
		}
		echo json_encode($traslado);
		//echo json_encode(json_decode($this->whmcs->funcion('GetClientsProducts', ["responsetype" => "json", "serviceid" => $traslado->int_tras_id_externo]))->products->product[0]);
	}
}
