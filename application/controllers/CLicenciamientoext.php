<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CLicenciamientoext extends CI_Controller
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
	}
	public function index()
	{
		$this->load->view('welcome_message');
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
}
