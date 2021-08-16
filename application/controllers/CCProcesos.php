
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CCProcesos extends CI_Controller
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

	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->helper('url');
		$this->load->helper('scripts');
		$this->load->library("whmcs");
		$this->load->library("template");
		$this->load->model("M_Procesos", "mp");
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
		$urldashboard = base_url("home/dashboard");
		header("Location: {$urldashboard}");
	}
	public function internos()
	{
		$this->load->view("masterPageCards/procesos/internos.php");
	}
	public function obetenerProcesosInternos()
	{
		$resultfin = array();
		$result = $this->mp->obetenerProcesosInternos(array("ps_activo" => 1, "ps_tipo" => 1))->result();
		foreach ($result as $row) {
			$row->code = "PINT-{$row->ps_id}";
			if ($row->ps_tipo != 1) {

				$row->code = "PEXT-{$row->ps_id}";
			}
			$row->buttons = "<button type='submit' class='btn btn-info btn-sm' onclick='verProceso({$row->ps_id})'>Ver</button> <button type='submit' class='btn btn-primary btn-sm' onclick=editarProceso({$row->ps_id})>Editar</button> <button type='submit' class='btn btn-danger btn-sm' onclick=eliminarProceso({'ps_id':'{$row->ps_id}'})>Eliminar</button>";
			$resultfin[] = $row;
		}
		echo json_encode(array("data" => $resultfin));
	}
	public function obtenerProceso()
	{
		$ps_id = $this->input->post("ps_id", true);
		$result = $this->mp->obetenerProcesosInternos(array("ps_id" => $ps_id))->row();
		$result->code = "PINT-{$result->ps_id}";
		if ($result->ps_tipo != 1) {

			$result->code = "PEXT-{$result->ps_id}";
		}
		echo json_encode(array("data" => $result));
	}
	public function editarProceso()
	{
		$ps_id = $this->input->post("ps_id", true);
		$ps_nombre = $this->input->post("ps_nombre", true);
		$ps_descripcion = $this->input->post("ps_descripcion", true);
		$data = [
			'ps_nombre' => $ps_nombre,
			'ps_descripcion' => $ps_descripcion

		];
		$where = ['ps_id' => $ps_id];
		$this->mp->editarProceso($data, $where);
	}
	public function eliminarProceso()
	{
		$ps_id = $this->input->post("ps_id", true);
		$data = ['ps_activo' => 0];
		$where = ['ps_id' => $ps_id];
		$this->mp->editarProceso($data, $where);
	}
	public function guardarProceso()
	{
		$ps_nombre = $this->input->post("ps_nombre", true);
		$ps_descripcion = $this->input->post("ps_descripcion", true);
		$data = [
			'ps_nombre' => $ps_nombre,
			'ps_descripcion' => $ps_descripcion

		];
		$this->mp->guardarProceso($data);
	}
}
