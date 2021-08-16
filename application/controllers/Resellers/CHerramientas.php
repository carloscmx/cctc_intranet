<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CHerramientas extends CI_Controller
{
	private $template, $reseller;
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->helper('url');
		$this->load->library("whmcs");
		$this->load->library("session");
		$this->load->helper("scripts");
		$this->reseller = $this->session->userdata('reseller');
		$this->template['head'] = $this->load->view("resellers/masterPage/head", array("reseller" => $this->reseller), true);
		$this->template['footer'] = $this->load->view("resellers/masterPage/footer", array(), true);
		$urlogin = url_login_resellers();

		if (!$this->session->userdata('reseller')) {
			header("Location: {$urlogin}");
		}
	}
	public function setHerramientaVnpApp(){
		$data['template']=$this->template;
		$this->load->view("resellers/directory/vpnapp",$data);
	}
	public function setHerramientaPagos_Blazar(){
		$data['template']=$this->template;
		$this->load->view("resellers/directory/pagos_blazar",$data);
	}
	
}
