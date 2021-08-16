<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
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
		$this->load->library("session");
		$this->load->library("seguridad");
		$this->load->library("sendmail");
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
		//$this->load->view('welcome_message');
		$urldashboard = base_url("home/dashboard");

		header("Location: {$urldashboard}");
	}
	public function getDashBoard()
	{

		$data['staff'] = json_decode($this->whmcs->funcion('GetStaffOnline', array("responsetype" => "json", "limitnum" => 1000000)));
		$data['tickets'] = json_decode($this->whmcs->funcion('GetTickets', array("responsetype" => "json", "limitnum" => 1000000, "status" => "Awaiting Reply")));
		$data['ordenespendiente'] = json_decode($this->whmcs->funcion('GetOrders', array("responsetype" => "json", "limitnum" => 1000000, "status" => "Pending")));
		$data['patch_panel'] = $this->pachpanel;
		//var_dump($data['tickets']);
		$this->load->view("masterPageCards/dashboard", $data);
	}
	public function test()
	{

		//echo  $this->seguridad->desencriptar('y53YqL3fWIiM');
	}
}
