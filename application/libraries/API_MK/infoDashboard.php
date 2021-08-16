<?php 
	require('routeros_api.class.php');
	
	$API = new RouterosAPI();
	$data = new StdClass();

	if ($API->connect()) {
		   $API->write('/system/resource/print');
		   //$API->write('/interface/getall');

		   $READ = $API->read(false);
		   $ARRAY = $API->parseResponse($READ);
		   
		   $API->disconnect();		   

			$data->estado = 1;
			$data->boardname = $ARRAY[0]['board-name'];
			$data->uptime = $ARRAY[0]['uptime'];
			$data->cpuload = $ARRAY[0]['cpu-load'];
			$data->version = $ARRAY[0]['version'];
		



	} else {
		$data->estado = 0;
	}
		echo json_encode($data);
 ?>