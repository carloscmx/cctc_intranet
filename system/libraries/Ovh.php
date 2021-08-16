<?php if (!defined('BASEPATH')) exit('No se permite el acceso directo al script');
require __DIR__ . '/vendor/autoload.php';

use \Ovh\Api;


class CI_Ovh
{




	protected $CI;
	public function __construct()
	{


		$this->CI = &get_instance();
	}


	function app1($method, $type = "get", $paramets = null)
	{
		$result = [];
		$applicationKey = "MVTOGEyh81n5EUZh";
		$applicationSecret = "eS5vgiIsxwKJ9SZBllcPdBeeSLlZSUKz";
		$consumer_key = "eIVgVpfTxCIX4aZ2OdfnSUNNp9m0jmnu";
		$endpoint = 'ovh-ca';
		$conn = new Api(
			$applicationKey,
			$applicationSecret,
			$endpoint,
			$consumer_key
		);
		if ($paramets == null) {
			$result = $conn->$type($method);
		} else {
			$result = $conn->$type($method, $paramets);
		}
		return $result;
	}
	function app2($method, $credentials, $type = "get", $paramets = null)
	{
		$result = [];
		$applicationKey = $credentials['vApplicationKey'];
		$applicationSecret = $credentials['vApplicationSecret'];
		$consumer_key = $credentials['vConsumerKey'];
		$endpoint = $credentials['vEndPoint'];
		$conn = new Api(
			$applicationKey,
			$applicationSecret,
			$endpoint,
			$consumer_key
		);
		if ($paramets == null) {
			$result = $conn->$type($method);
		} else {
			$result = $conn->$type($method, $paramets);
		}
		return $result;
	}
}
