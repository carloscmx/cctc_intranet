<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CLoginternal extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->helper('url');
		$this->load->library("whmcs");
		$this->load->helper("jseguridad");
		$this->load->model("M_Logininternal", "ml");
		$this->load->library("seguridad");
		//load session library
		$this->load->library('session');
		$this->load->library('datos');
		$this->load->helper('scripts');
	}
	public function index()
	{
		$this->load->view("login");
	}
	public function validarLogin()
	{
		$email = $this->input->post("email", true);
		$password = $this->input->post("password", true);
		$result =  $this->whmcs->funcion('ValidateLogin', array("responsetype" => "json", "email" => $email, "password2" => $password));
		$result = "EMAIL " . $email . " " . $password;
		echo $result;
	}
	public function setLogin()
	{
		$this->load->view("login/login");
	}
	public function login()
	{

		$output = array('error' => false);
		$user = $this->input->post("user", true);
		$password = $this->seguridad->encriptar($this->input->post("password", true));
		$data = $this->ml->login($user, $password);
		if ($data) {
			$this->session->set_userdata('user', $data);
			$output['lg_patch'] = 'directory/changepassword';
			$output['message'] = 'Logging in. Please wait...';
		} else {
			$output['error'] = true;
			$output['message'] = 'Login Invalid. User not found';
		}
		echo json_encode($output);
	}
	public function logout()
	{
		//load session library
		$this->load->library('session');
		$this->session->unset_userdata('user');

		$output['error'] = false;
		$output['message'] = 'Logout success';
		$output['patch'] = url_login_admin();
		echo json_encode($output);
	}
	public function logoutRedirectic()
	{
		//load session library
		$this->load->library('session');
		$this->session->unset_userdata('user');
		redirect(url_login_admin());
	}
	public function setChangePassword()
	{
		if ($this->session->userdata('user')) {
			$sesion = $this->session->userdata('user');
			$external_id = $sesion['lg_external_id'];
			$datos = "";
			switch ($sesion["lg_usuarios_lg_perfiles_id"]) {
				case 1:
					$datos = $this->datos->getPersonasAdministradores($external_id);
					$datos['name'] = $datos['usr_nombre'];

					break;
				case 2:
					$datos = $this->datos->setDatosVendedor($external_id);
					$datos['name'] = $datos['ven_nombre'];
					break;
				default:
					$datos['name'] = "#ERROR#";
					break;
			}
			$data['datos'] = $datos;

			if ($sesion['lg_reset'] == 1) {
				$this->load->view("login/changepassword", $data);
			} else {
				redirect(base_url($sesion['lg_patch']));
			}
		} else {
			// do something when doesn't exist
			redirect(url_login_admin());
		}
	}
	public function changePassword()
	{
		$sesion = $this->session->userdata('user');
		$password = $this->input->post("password", true);
		$passencode = $this->seguridad->encriptar($password);
		$where = array("lg_usuarios_id" => $sesion['lg_usuarios_id']);
		$data = array("lg_usuarios_password" => $passencode, "lg_reset" => 0);
		$this->ml->userUpdate($data, $where);
		echo json_encode($sesion);
	}
}
