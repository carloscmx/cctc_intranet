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

class Utilerias
{

	public function set_zero_format($number, $length)
	{
		return substr(str_repeat(0, $length) . $number, -$length);
	}
	function generateToken()
	{
		$longitud = 50;
		$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$password = "";
		//Reconstruimos la contraseña segun la longitud que se quiera
		for ($i = 0; $i < $longitud; $i++) {
			//obtenemos un caracter aleatorio escogido de la cadena de caracteres
			$password .= substr($str, rand(0, 62), 1);
		}

		return $password . md5(date("Y-m-d H:i:s"));
	}
	/**Genera una password segura con la longitud pedida */
	function generatePassword($longitud)
	{
		$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$password = "";
		//Reconstruimos la contraseña segun la longitud que se quiera
		for ($i = 0; $i < $longitud; $i++) {
			//obtenemos un caracter aleatorio escogido de la cadena de caracteres
			$password .= substr($str, rand(0, 62), 1);
		}

		return $password;
	}
	public function valida_rfc($valor)
	{
		$valor = str_replace("-", "", $valor);
		$cuartoValor = substr($valor, 3, 1);
		//RFC sin homoclave
		if (strlen($valor) == 10) {
			$letras = substr($valor, 0, 4);
			$numeros = substr($valor, 4, 6);
			if (ctype_alpha($letras) && ctype_digit($numeros)) {
				return true;
			}
			return false;
		}
		// Sólo la homoclave
		else if (strlen($valor) == 3) {
			$homoclave = $valor;
			if (ctype_alnum($homoclave)) {
				return true;
			}
			return false;
		}
		//RFC Persona Moral.
		else if (ctype_digit($cuartoValor) && strlen($valor) == 12) {
			$letras = substr($valor, 0, 3);
			$numeros = substr($valor, 3, 6);
			$homoclave = substr($valor, 9, 3);
			if (ctype_alpha($letras) && ctype_digit($numeros) && ctype_alnum($homoclave)) {
				return true;
			}
			return false;
			//RFC Persona Física. 
		} else if (ctype_alpha($cuartoValor) && strlen($valor) == 13) {
			$letras = substr($valor, 0, 4);
			$numeros = substr($valor, 4, 6);
			$homoclave = substr($valor, 10, 3);
			if (ctype_alpha($letras) && ctype_digit($numeros) && ctype_alnum($homoclave)) {
				return true;
			}
			return false;
		} else {
			return false;
		}
	} //fin validaRFC
	public function crearTXTVerticalBar($arreglo)
	{
		$txt = "";
		foreach ($arreglo as $row => $value) {
			$txt .= "{$value}|";
		}
		return $txt;
	}
	public function generarceros($number, $length = 10)
	{
		return substr(str_repeat(0, $length) . $number, -$length);
	}
	function fechaproduccion($facharecibida)
	{

		$fechaproduccion = "01-08-2021";
		$fchapro = date('Y-m-d', strtotime($fechaproduccion));
		$fcharecib = date('Y-m-d', strtotime($facharecibida));

		$respuesta = false;

		if ($fcharecib >= $fchapro) {
			$respuesta = true;
		}

		return $respuesta;
	}
	public function generarDecimales($number, $decimales = 2)
	{
		return number_format((float)$number, $decimales, '.', '');
	}
	public function fachageracionrelacionwindows($facharecibida)
	{
		$fechaproduccion = "19-07-2021";
		$fchapro = date('Y-m-d', strtotime($fechaproduccion));
		$fcharecib = date('Y-m-d', strtotime($facharecibida));

		$respuesta = false;

		if ($fcharecib >= $fchapro) {
			$respuesta = true;
		}

		return $respuesta;
	}
	function ip_range($start, $end)
	{
		$start = ip2long($start);
		$end = ip2long($end);
		return array_map('long2ip', range($start, $end));
	}
	function isIPV4($ip)
	{
		$result = true;
		if (strpos($ip, ':') > 0) {
			//if ip range provided is ipv6 then
			$result = false;
		}
		return $result;
	}


	function getSubnetIp($ip)
	{

		$subnet = $this->httspurl_get_array("https://subnet.api.hairmare.ch/subnet/" . $ip);
		return $this->ip_range($subnet->firstIP, $subnet->lastIP);
	}
	function httspurl_get_array($url)
	{

		$ch = curl_init();

		// Check if initialization had gone wrong*    
		if ($ch === false) {
			$resultado = array("error" => "no se inicializo la petición.");
		} else {
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$content = json_decode(curl_exec($ch));

			$resultado = $content;
		}



		return $resultado;
	}
}
