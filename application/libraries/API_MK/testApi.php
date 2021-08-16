<?php 
	require('routeros_api.class.php');
	
	$API = new RouterosAPI();
	$data = new StdClass();
	

	if ($API->connect()) {

		   $API->write('/user/print');

		   $READ = $API->read(false);
		   $ARRAY = $API->parseResponse($READ);
		   
		   $API->disconnect();
		   $count=count($ARRAY);
		   $data->c=$count;		
		   $data->estado = 1;

		   if($count>0){
		   	for ($i=0; $i < $count; $i++) { 
		   		$ip = explode('/', $ARRAY[$i]['target']);
		   		$speed = explode('/', $ARRAY[$i]['max-limit']);
		   		$data->id[] = $ARRAY[$i]['.id'];		   
		   		$data->name[] = $ARRAY[$i]['name'];
				$data->group[] = $ARRAY[$i]['group'];
				$data->logged[] = $ARRAY[$i]['last-logged-in'];
				$data->disabled[] = $ARRAY[$i]['disabled'];
				$data->comment[] = $ARRAY[$i]['comment'];				   		   		
		   	}
		   }		
	} else {
			$data->estado = 0;
	}
		echo json_encode($data);
 ?>