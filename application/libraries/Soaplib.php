<?php if (!defined('BASEPATH')) exit('No se permite el acceso directo al script');



class Soaplib
{
	public function __construct()
	{
	}


	function conexiontimbra()
	{
		return  new
			SoapClient(
				"https://ssl.timbraxml.com/ws/emision/certificarComprobante33.php?wsdl",
				array('trace' => 1)
			);
	}
}
