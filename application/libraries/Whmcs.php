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

class Whmcs
{

	public function Conexion()
	{
		$whmcsUrl = "https://panel.blazar.mx/";
		$username = "ne5fxinHfAYaqs4maC8vOdamUBmVKMMa";
		$password = "SSzuOsTCH7HvGp0DoH8w6Ri92wrgyU6q";
		return array("dominio" => $whmcsUrl, "usuario" => $username, "password" => $password);
	}
	public function funcion($action, $options = null)
	{

		$conexion = $this->Conexion();
		$postfields = array(
			'username' => $conexion['usuario'],
			'password' => $conexion['password'],
			'action' => $action,
		);
		if ($options == null) {
			$postfields = array_merge($postfields, array("responsetype" => "json"));
		} else {
			$postfields = array_merge($postfields, $options);
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $conexion['dominio'] . 'includes/api.php');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
		$response = curl_exec($ch);
		if (curl_error($ch)) {
			die('Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch));
		}
		curl_close($ch);

		return $response;
	}
	public function buscadorOpcion($arr, $name)
	{
		foreach ($arr as $row) {
			if ($name == $row->name) {
				return $row;
			}
		}
	}
}
