<?php

use function PHPSTORM_META\map;

defined('BASEPATH') or exit('No direct script access allowed');

class CIpam extends CI_Controller
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
	private $pachpanel = 'https://panel.blazar.mx/';
	private $datosuser = "";

	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->helper('url');
		$this->load->helper('scripts');
		$this->load->library("whmcs");
		$this->load->library("template");
		$this->load->library("session");
		$this->load->library("datos");
		$this->load->library("ovh");
		$this->load->library("utilerias");
		$this->load->library("mikrotik");
		$this->load->model("M_Ipam", "mi");




		$urlogin = url_login_resellers();

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
		$datosuser = $this->datos->getPersonasAdministradores($_SESSION['user']['lg_external_id']);
		if (/*isset($_SESSION['lg_user_autorizacion'])*/true) {
			$arrCredenciales = $this->mi->selectCredenciales();
			$data = [
				//'servicios' => $this->ovh->app1('/dedicated/server'),
				'credenciales' => $arrCredenciales
			];
			//print_r($this->ovh->app1('/dedicated/server/ns556750.ip-54-39-19.net/ips'));

			$this->load->view("masterPageCards/ipam/servers", $data);
		} else {
			//var_dump($datosuser);
			$this->load->view("login/authorization", $datosuser);
		}
	}
	public function changeCredenciales()
	{
		if ($this->input->is_ajax_request()) {
			if (!empty($this->input->post('credencial', true))) {
				$vCredencialIndex = $this->input->post('credencial', true);
				$arrCredenciales = $this->mi->selectCredenciales($vCredencialIndex);

				$arrSetvicios = $this->ovh->app2('/dedicated/server', $arrCredenciales);
				$this->output
					->set_status_header(200)
					->set_content_type('application/json')
					->set_output(json_encode($arrSetvicios));
			} else {
				$this->output
					->set_status_header(400)
					->set_content_type('application/json')
					->set_output(json_encode(['Index::Error']));
			}
		} else {
			$this->output->set_status_header(404);
		}
	}
	public function JsonDedicateServerNameIps()
	{
		$iIdCredencial = $this->input->post('indexCredencial', true);
		$arrCredenciales = $this->mi->selectCredenciales($iIdCredencial);

		$serviceName = $this->input->post("serviceName", true);
		$server = $this->ovh->app2("/dedicated/server/{$serviceName}", $arrCredenciales);
		$direccionesmac = $this->ovh->app2("/dedicated/server/{$serviceName}/virtualMac", $arrCredenciales);
		$result = $this->ovh->app2("/dedicated/server/{$serviceName}/ips", $arrCredenciales);
		$ips = [];
		$macandip = [];
		foreach ($direccionesmac as $vmac) {
			$ipresult = $this->ovh->app2("/dedicated/server/{$serviceName}/virtualMac/{$vmac}/virtualAddress", $arrCredenciales);
			$macandip[] = ['mac' => $vmac, 'ipbuscada' => $ipresult[0]];
		}
		foreach ($result as $ip) {
			$bool = $this->utilerias->isIPV4($ip);
			if ($bool && trim($server['ip'] . "/32") != trim($ip)) {
				$subnet = $this->utilerias->getSubnetIp($ip);
				$subnetAdrress = [];

				if (count($subnet) > 0) {
					foreach ($subnet as $vip) {
						$existemac = false;
						$macbuscada = [];
						foreach ($macandip as $rowipmac) {
							if ($rowipmac['ipbuscada'] == $vip) {
								$existemac = true;
								$macbuscada = $rowipmac['mac'];
							}
						}
						if ($existemac) {
							$map = ["ip_subnet" => $vip, "mac_address" => $macbuscada];
						} else {
							$map = ["ip_subnet" => $vip];
						}
						$subnetAdrress[] = $map;
					}
				}
				$ips[] = ["ip" => $ip, "ips" => $subnetAdrress];
			}
		}

		echo json_encode(['servidor' => $server, 'direcciones' => $ips]);
	}
	public function JsonDedicateServerNameIpsSegment()
	{

		$segmento = $this->input->post('segmento', true);

		$iIdCredencial = $this->input->post('indexCredencial', true);
		$arrCredenciales = $this->mi->selectCredenciales($iIdCredencial);

		$serviceName = $this->input->post("serviceName", true);
		$server = $this->ovh->app2("/dedicated/server/{$serviceName}", $arrCredenciales);
		$direccionesmac = $this->ovh->app2("/dedicated/server/{$serviceName}/virtualMac", $arrCredenciales);
		$result = $this->ovh->app2("/dedicated/server/{$serviceName}/ips", $arrCredenciales);
		$ips = [];
		$macandip = [];
		foreach ($direccionesmac as $vmac) {
			$ipresult = $this->ovh->app2("/dedicated/server/{$serviceName}/virtualMac/{$vmac}/virtualAddress", $arrCredenciales);
			$macandip[] = ['mac' => $vmac, 'ipbuscada' => $ipresult[0]];
		}
		foreach ($result as $ip) {
			$bool = $this->utilerias->isIPV4($ip);
			if ($bool && trim($server['ip'] . "/32") != trim($ip)) {
				$subnet = $this->utilerias->getSubnetIp($ip);
				$subnetAdrress = [];

				if (count($subnet) > 0) {
					foreach ($subnet as $vip) {
						$existemac = false;
						$macbuscada = [];
						foreach ($macandip as $rowipmac) {
							if ($rowipmac['ipbuscada'] == $vip) {
								$existemac = true;
								$macbuscada = $rowipmac['mac'];
							}
						}
						if ($existemac) {
							$map = ["ip_subnet" => $vip, "mac_address" => $macbuscada];
						}
						$subnetAdrress[] = $map;
					}
				}
				if ($ip == $segmento) {
					$ips[] = $subnetAdrress;
				}
			}
		}
		$responseConexiones = $this->mi->getServidorDHCPServicio($serviceName);
		foreach ($ips as $ipsubnet) {
			foreach ($ipsubnet as $ip) {
				$this->mi->insertLeaseDHCP($responseConexiones, $ip['ip_subnet'], $ip['mac_address']);
			}
		}

		// $this->output->set_status_header(200)
		// 	->set_content_type('application/json')
		// 	->set_output(json_encode([
		// 		'message' => 'Proceso finalizado'
		// 	]));


		echo json_encode($ips);
	}
	public function addVirtualMAc()
	{
		$macGenerada = '';
		$serviceName = $this->input->post("serviceName", true);
		$ipAddress  = $this->input->post("ipAddress", true);

		$iIdCredencial = $this->input->post('indexCredencial', true);
		$arrCredenciales = $this->mi->selectCredenciales($iIdCredencial);

		//Credenciales de acceso para el servidor DHCP
		$responseConexiones = $this->mi->getServidorDHCPServicio($serviceName);
		if ($responseConexiones != false) {

			if ($this->ovh->app2("/dedicated/server/{$serviceName}/virtualMac", $arrCredenciales, "post", [
				'ipAddress' => $ipAddress,
				'type' => 'ovh',
				'virtualMachineName' => 'vm'
			])) {

				sleep(25);

				$server = $this->ovh->app2("/dedicated/server/{$serviceName}", $arrCredenciales);
				$result = $this->ovh->app2("/dedicated/server/{$serviceName}/ips", $arrCredenciales);
				$direccionesmac = $this->ovh->app2("/dedicated/server/{$serviceName}/virtualMac", $arrCredenciales);

				$macandip = [];
				foreach ($direccionesmac as $vmac) {
					$ipresult = $this->ovh->app2("/dedicated/server/{$serviceName}/virtualMac/{$vmac}/virtualAddress", $arrCredenciales);
					$macandip[] = ['mac' => $vmac, 'ipbuscada' => $ipresult[0]];
				}
				$resultadoForEach = [];
				foreach ($result as $ip) {
					$bool = $this->utilerias->isIPV4($ip);
					if ($bool && trim($server['ip'] . "/32") != trim($ip)) {
						$subnet = $this->utilerias->getSubnetIp($ip);

						$subnetAdrress = [];
						if (count($subnet) > 0) {
							foreach ($subnet as $vip) {


								if ($ipAddress == $vip) {
									//Para debug y buscar la ip manualmente, borrar despues
									$subnetAdrress[] = $vip;

									foreach ($macandip as $val) {
										if ($val['ipbuscada'] == $vip) {
											$macGenerada = $val['mac'];
											break;
										}
									}
									break;
								}
							}
						}
						//$ips[] = ["ip" => $ip, "ips" => $subnetAdrress];
						$resultadoForEach[] = $subnetAdrress;
					}
				}

				if ($macGenerada != '') {
					if ($resp = $this->mi->insertLeaseDHCP($responseConexiones, $ipAddress, $macGenerada)) {
						if ($resp === true) {
							$this->output->set_status_header(200)
								->set_content_type('application/json')
								->set_output(json_encode([
									'message' => 'Proceso finalizado'
								]));
						} else {
							$this->output->set_status_header(500)
								->set_content_type('application/json')
								->set_output(json_encode([
									'message' => 'Error al agregar servicio al servidor DHCP',
									'log' => $resp
								]));
						}
					} else {
						$this->output->set_status_header(500)
							->set_content_type('application/json')
							->set_output(json_encode(['message' => 'Error en la conexion con el servidor DHCP, registre el servicio manualmente', 'message2' => $resp, 'mac' => $macGenerada,]));
					}
				} else {
					$this->output->set_status_header(400)->set_content_type('application/json')->set_output(json_encode(
						[
							'message' => 'La mac fue asignada, pero deberá relacionar la direccion del servicio y la dirección mac  al servidor DHCP manualmente debido a un error',
							'mac' => $macGenerada,
						]
					));
				}
			}
		} else {
			$this->output->set_status_header(500)
				->set_content_type('application/json')
				->set_output(json_encode([
					'status' => false,
					'message' => 'No se encotró servidor DHCP'
				]));
		}
	}
	public function solicitarOrdenIP()
	{
		$serviceName = $this->input->post("serviceName", true);
		$orden = $this->ovh->app1("/order/cart", "post", [
			"description" => "Direcciones adiccionales para el servicio {$serviceName}",
			"ovhSubsidiary" => "CA"
		]);
		echo json_encode($orden);
	}
	public function servidoresdhcp()
	{
		$data = [
			'servicios' => $this->ovh->app1('/dedicated/server')
		];
		$this->load->view("masterPageCards/ipam/serversdhcp", $data);
	}
	public function JsongetServidoresdhcp()
	{
		$servidoreschr = $this->mi->regresarChr(['int_mk_activo' => 1]);
		$relacionesdhcpservicio = $this->mi->regresarChrRelacionServicio(['int_mk_activo' => 1])->result_array();
		$rows = [];
		foreach ($servidoreschr->result() as $row) {
			$buttons = json_encode(['id' => $row->int_mk_id_conexion, 'nombre' => $row->var_mk_nombre]);
			$row->buttons = "<input type='submit' value='Relacionar Servicio' onclick='verificardhcpservicio({$buttons})' class='btn btn-success'>";
			foreach ($relacionesdhcpservicio as $rowrel) {
				if ($row->int_mk_id_conexion == $rowrel['int_mk_id_dhcp']) {
					foreach ($relacionesdhcpservicio as $rowrel) {
						if ($row->int_mk_id_conexion == $rowrel['int_mk_id_dhcp']) {
							$row->buttons = $rowrel['var_mk_nombre_servicio'];
						}
					}
				}
			}


			$rows[] = $row;
		}
		echo json_encode(['data' => $rows]);
	}
	public function agregarServidorDhcp()
	{
		$txtNombreServidor = $this->input->post("txtNombreServidor", true);
		$txtDireccionServidor = $this->input->post("txtDireccionServidor", true);
		$txtNombreUsuarioServidor = $this->input->post("txtNombreUsuarioServidor", true);
		$txtPasswordServidor = $this->input->post("txtPasswordServidor");
		$txtPuertoServidor = $this->input->post("txtPuertoServidor", true);
		$keys = [
			'var_mk_direccion' => $txtDireccionServidor,
			'var_mk_usuario' => $txtNombreUsuarioServidor,
			'txt_mk_password' => $txtPasswordServidor,
			'int_mk_puerto' => $txtPuertoServidor,
			'var_mk_nombre' => $txtNombreServidor

		];
		$jsonresult = ['result' => 'error'];
		if ($this->mikrotik->testConexion($keys)) {
			$this->mi->insertarChr($keys);
			$jsonresult = ['result' => 'success'];
		}
		echo json_encode($jsonresult);
	}
	public function agregarRelacionDhcp()
	{
		$server = $this->input->post('servername', true);
		if ($this->input->is_ajax_request()) {
			$resp = $this->mi->listarDHCPDisponibles($server);

			$myidDHCP = $this->mi->miServidorDHCP($server);

			$this->output->set_status_header(200)
				->set_content_type('application/json')
				->set_output(json_encode([
					'servidores' => $resp,
					'myDHCP' => ($myidDHCP != false) ? $myidDHCP : false
				]));
		} else {
			$this->output->set_status_header(404);
		}
	}
	public function agregarRelacionDhcp1()
	{
		$serviciorel = $this->input->post('serviciorel', true);
		$servidordhcp = $this->input->post('servidordhcp', true);

		if ($this->input->is_ajax_request()) {

			$this->output->set_status_header(200)->set_content_type("application/json")->set_output(json_encode($this->mi->insertarRelacionServicioDHCP($serviciorel, $servidordhcp)));
		} else {
			$this->output->set_status_header(404);
		}
	}
	public function insertarRelacionDHCP()
	{
		$serviceName = $this->input->post('serviceName', true);
		$iIdDHCP = $this->input->post('dhcpIndex', true);

		$resp = $this->mi->insertarRelacionServicioDHCP($serviceName, $iIdDHCP);
		$this->output->set_status_header(200)
			->set_content_type('application/json')
			->set_output(json_encode($resp));
	}

	public function nuevaConexionServidoresDedicados()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('varNombre', 'Nombre de la conexion', 'required');
		$this->form_validation->set_rules('varApplicationKey', 'Application key', 'required');
		$this->form_validation->set_rules('varApplicationSecret', 'Application secret', 'required');
		$this->form_validation->set_rules('varConsumerKey', 'Consumer key', 'required');
		$this->form_validation->set_rules('varEndPoint', 'End point', 'required');

		if ($this->form_validation->run()) {
			$nombre = $this->input->post('varNombre', true);
			$applicationkey = $this->input->post('varApplicationKey', true);
			$applicationsecret = $this->input->post('varApplicationSecret', true);
			$consumerkey = $this->input->post('varConsumerKey', true);
			$endpoint = $this->input->post('varEndPoint', true);

			$datos = [
				'vApplicationKey' => $applicationkey,
				'vApplicationSecret' => $applicationsecret,
				'vConsumerKey' => $consumerkey,
				'vEndPoint' => $endpoint,
				'vNombre' => $nombre,
			];

			if ($this->mi->insertarNuevaConexion($datos)) {
				$this->output->set_status_header(201)->set_content_type('application/json')->set_output(json_encode([
					'message' => 'Conexion agregada'
				]));
			} else {
				$this->output->set_status_header(500)->set_content_type('application/json')->set_output(json_encode([
					'message' => 'Error al agregar conexion'
				]));
			}
		} else {
			$this->output->set_status_header(400)->set_content_type('application/json')->set_output(json_encode([
				'varNombre' => form_error('varNombre'),
				'varApplicationKey' => form_error('varApplicationKey'),
				'varApplicationSecret' => form_error('varApplicationSecret'),
				'varConsumerKey' => form_error('varConsumerKey'),
				'varEndPoint' => form_error('varEndPoint'),
			]));
		}
	}
}
