<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CLogin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->helper('url');
		$this->load->helper('scripts');

		$this->load->library("whmcs");
		$this->load->library("session");
	}
	public function index()
	{
		$this->load->view("resellers/login/login");
	}
	public function validarLogin()
	{
		$email = $this->input->post("user", true);
		$password = $this->input->post("password", true);
		$captcha = $this->input->post('g-recaptcha-response', true);

		if (isset($_POST['user']) && isset($_POST['password'])  && isset($_POST['g-recaptcha-response'])) {
			if (!$captcha) {
				echo json_encode(array("result" => "norecaptcha"));
				exit;
			}
			$secretKey = "6Ldw1iEbAAAAAMN6SJ9beT5_RArgaP1uE7Sck_Xj";
			$ip = $_SERVER['REMOTE_ADDR'];
			// post request to server
			$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
			$response = file_get_contents($url);
			$responseKeys = json_decode($response, true);
			// should return JSON with success as true
			if ($responseKeys["success"]) {
				$result =  $this->whmcs->funcion('ValidateLogin', array("responsetype" => "json", "email" => trim($email), "password2" => trim($password)));
				//echo $result;
				$user = json_decode($result);
				if ($user->result == "success") {
					$perfil = $this->validarReseller($email);

					if (!empty($perfil)) {
						if ($perfil->groupid != 0) {
							$perfil->userid = $user->userid;
							$this->session->set_userdata('reseller', $perfil);
							echo json_encode(array("result" => "success"));
						} else {
							echo json_encode(array("result" => "without"));
						}
					} else {
						//echo json_encode($perfil);
						echo json_encode(array("result" => "without"));
					}
				} else {
					echo json_encode(array("result" => "error"));
				}
			} else {
				echo json_encode(array("result" => "spam"));
			}
		} else {
			show_404();
		}
	}
	public function validarReseller($email)
	{
		$result = [];
		$userid = 0;
		$responsdcliente =	json_decode($this->whmcs->funcion('GetUsers', array("responsetype" => "json", "limitnum" => 1000000, "status" => "Active", "search" => $email)));
		if (isset($responsdcliente->users[0]->clients[0])) {
			$userid = $responsdcliente->users[0]->clients[0]->id;
		}
		if ($userid != 0) {
			$result =	json_decode($this->whmcs->funcion('GetClientsDetails', ["responsetype" => "json", "limitnum" => 1000000, "clientid" => $userid]));
		}
		return $result;
	}
	public function logoutRedirectic()
	{
		//load session library
		$this->load->library('session');
		$this->session->unset_userdata('reseller');
		redirect(url_login_resellers());
	}
}
