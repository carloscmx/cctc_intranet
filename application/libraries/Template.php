<?php

/**
 * @package	APIS WHMCS
 * @author	Carlos Cauich
 * @copyright	Copyright (c) Blazar Networks
 * @copyright	Copyright (c) Blazar Networks
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://blazar.mx
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Template
{
	private $CI, $sesion;

	public function __construct()
	{

		$this->CI = &get_instance();
		$this->CI->load->library("session");
		$this->CI->load->library("datos");

		$this->sesion = $this->CI->session->userdata('user');
	}


	public function getHeader($config = null)
	{
		if ($config != null) {
			$config['options'] = $config;
		}
		$config['datos'] = $this->CI->datos->getPersonasAdministradores($this->sesion['lg_external_id']);

		$this->CI->load->view("masterPage/head", $config);
	}

	public function getFooter()
	{
		$this->CI->load->view("masterPage/footer");
	}
}
