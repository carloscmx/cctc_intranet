<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CLogin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->helper('url');
		$this->load->library("whmcs");
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
}
