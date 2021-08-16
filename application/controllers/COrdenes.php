<?php
defined('BASEPATH') or exit('No direct script access allowed');

class COrdenes extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->helper('url');
		$this->load->library("whmcs");
		$this->load->model("M_Licencias", "modellicencias");
	}
	public function GetOrders()
	{
		return  $this->whmcs->funcion('GetOrders', array("responsetype" => "json", "limitnum" => 1000000, "status" => "Pending"));
	}
	public function GetOrders_relid()
	{
		$results = array();
		$orders = json_decode($this->GetOrders());
		for ($i = 0; $i < $orders->numreturned; $i++) {
			array_push($results, $orders->orders->order[$i]->lineitems->lineitem[0]->relid);
		}
		return $results;
	}
	public function GetClientsProducts_details()
	{
		$servicesid_clients = $this->GetOrders_relid();


		$services = array();
		for ($i = 0; $i < count($servicesid_clients); $i++) {
			$result = $this->whmcs->funcion('GetClientsProducts', array("responsetype" => "json", "limitnum" => 1000000, "serviceid" => $servicesid_clients[$i]));
			$result = json_decode($result);
			array_push($services, $result);
		}
		return $services;
	}
	public function getTiposLicencia($where = null)
	{
		return $this->modellicencias->getTipoLicencia($where);
	}
	public function getLicencias($where = null, $limit = false)
	{
		return $this->modellicencias->getLicencias($where, $limit);
	}
	public function searchLicenciasWindows()
	{

		$detailsProducts = $this->GetClientsProducts_details();
		for ($i = 0; $i < count($detailsProducts); $i++) {
			for ($o = 0; $o < count($detailsProducts[$i]->products->product[0]->configoptions->configoption); $o++) {
				if ($detailsProducts[$i]->products->product[0]->configoptions->configoption[$o]->id == 161) {
					$orderid = $detailsProducts[$i]->products->product[0]->orderid;
					$serviceid = $detailsProducts[$i]->serviceid;
					$tipolicencia = $detailsProducts[$i]->products->product[0]->configoptions->configoption[$o]->value;
					if ($tipolicencia == "Sin licencia") {
						/**AQUI SE PROVICIONADA SI NO TIENE LICENCIAS*/
						$this->whmcs->funcion('AcceptOrder', array("responsetype" => "json", "orderid" => $orderid));
						var_dump($detailsProducts[$i]);
					} else {
						$resultComparativo = $this->getTiposLicencia(array("comparativoPanel" => $tipolicencia));
						if ($resultComparativo->num_rows() == 1) {
							$arrayResult = $resultComparativo->result_array();
							$fecha = date('Y-m-d h:i:s');
							$licenciaactivar = $this->getLicencias(array("idtipolicencia" => $arrayResult[0]['idlicencia'], "activo" => 1))->result_array();
							$idlicenciaactivar = $licenciaactivar[0]["idlicencia"];
							$this->modellicencias->setUpdateLicencia(array("idlicencia" => $idlicenciaactivar), array("activo" => 2, "fechaventa" => $fecha));
							$this->whmcs->funcion('UpdateClientProduct', array("responsetype" => "json", "serviceid" => $serviceid, "customfields" => base64_encode(serialize(array("200" => $licenciaactivar[0]["licencia"])))));
							$this->whmcs->funcion('AcceptOrder', array("responsetype" => "json", "orderid" => $orderid));
						}
					}
				}
			}
		}
	}
}
