<?php if (!defined('BASEPATH')) exit('No se permite el acceso directo al script');



class Seguridad
{
	protected $CI;
	protected $llave = 'iltZw%VbqJ0^bxEADnoExSZfVVzc222P4$9WW^rBEprS@o333U';
	public function __construct()
	{
		$this->CI = &get_instance();
	}



	function encriptar($string, $key = null)
	{

		$result = '';
		if ($key == null) {
			$key = $this->llave;
			for ($i = 0; $i < strlen($string); $i++) {
				$char = substr($string, $i, 1);
				$keychar = substr($key, ($i % strlen($key)) - 1, 1);
				$char = chr(ord($char) + ord($keychar));
				$result .= $char;
			}
		} else {
			for ($i = 0; $i < strlen($string); $i++) {
				$char = substr($string, $i, 1);
				$keychar = substr($key, ($i % strlen($key)) - 1, 1);
				$char = chr(ord($char) + ord($keychar));
				$result .= $char;
			}
		}
		return base64_encode($result);
	}
	function desencriptar($string, $key = null)
	{
		$result = '';
		if ($key == null) {
			$key = $this->llave;
			$string = base64_decode($string);
			for ($i = 0; $i < strlen($string); $i++) {
				$char = substr($string, $i, 1);
				$keychar = substr($key, ($i % strlen($key)) - 1, 1);
				$char = chr(ord($char) - ord($keychar));
				$result .= $char;
			}
		} else {
			$string = base64_decode($string);
			for ($i = 0; $i < strlen($string); $i++) {
				$char = substr($string, $i, 1);
				$keychar = substr($key, ($i % strlen($key)) - 1, 1);
				$char = chr(ord($char) - ord($keychar));
				$result .= $char;
			}
		}

		return $result;
	}
}
