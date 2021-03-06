<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CFacturav3 extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	//variables internas para manejo de errores
	private	$success = "success";
	private	$error = "error";
	private	$idinputmetodopago = 205;
	private	$idinputtipogasto = 206;
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->helper('url');
		$this->load->helper('scripts');
		$this->load->library("whmcs");
		$this->load->library("template");
		$this->load->model("M_Facturas", "mf");
		$this->load->library("utilerias");
		$this->load->library("Sendmail");
		$this->load->library("Soaplib");

		$urlogin = url_login_resellers();

		if (!$this->session->userdata('reseller')) {
			//	header("Location: {$urlogin}");
			show_error("Primero inicie sesion antes de realizar esta operacion. <a href='{$urlogin}'>Iniciar sesion.</a>", "401", "No autorizado");
		}
	}
	public function catalogoinformacionEmisor()
	{
		$infoBlazar = (object)[];
		$infoBlazar->rfc = "BNE170213PV1";
		$infoBlazar->razonsocial = "BLAZAR NETWORKS, SA DE CV.";
		$infoBlazar->regimenfiscal = "601";
		$infoBlazar->codigopostal = "97314";
		$infoBlazar->NoIdentificacion = "9900000100001";
		$infoBlazar->ClaveUnidad = "A9";
		$infoBlazar->ClaveProdServ = "81112401";





		return $infoBlazar;
	}
	public function index()
	{
		$this->load->view('facturacion/cfdi3.3/template/pago.php');
	}
	public function obtenerArchivoInvoice()
	{
		$hash  = $this->uri->segment(5);
		$datosarchivo = $this->mf->buscarArchivos(array("fac_arc_ash" => $hash));
		if ($datosarchivo->num_rows() > 0) {
			$archivo = $datosarchivo->row();
			$archivo = $datosarchivo->row();
			$arrContextOptions = array(
				"ssl" => array(
					"verify_peer" => false,
					"verify_peer_name" => false,
				),
			);
			$file = file_get_contents($archivo->fac_arch_ruta_url, false, stream_context_create($arrContextOptions));
			if ($archivo->fac_arc_tipo == 2) {
				header("Content-Type: application/pdf");
			} else {
				//header("Content-Type: application/xml");
				ob_end_clean();
				ob_start();
				header('Content-Type: application/xml; charset=UTF-8');
				header('Content-Encoding: UTF-8');
				header("Content-Disposition: attachment;filename={$archivo->fac_arc_nombre}");
				header('Expires: 0');
				header('Pragma: cache');
				header('Cache-Control: private');
			}
			echo $file;
		} else {
			show_error("NO AUTORIZADO", 500, "ERROR");
		}
	}
	function catalogoMetodoPago($string)
	{
		$metodo = (object)[];
		switch ($string) {
			case "Transferencia Electr??nica":
				$metodo->codigo = "03";
				$metodo->condicion = "CONTADO";
				$metodo->metodofac = "PUE";
				break;
			case "Tarjeta de Cr??dito":
				$metodo->codigo = "04";
				$metodo->condicion = "TARJETA DE CREDITO";
				$metodo->metodofac = "PUE";

				break;
			case "Tarjeta de D??bito":
				$metodo->codigo = "28";
				$metodo->condicion = "TARJETA DE DEBITO";
				$metodo->metodofac = "PUE";

				break;
			case "Efectivo":
				$metodo->codigo = "01";
				$metodo->condicion = "CONTADO";
				$metodo->metodofac = "PUE";

				break;
			default:
				$metodo->codigo = "99";
				$metodo->condicion = "CONTADO";
				$metodo->metodofac = "PUE";

				break;
		}
		return $metodo;
	}
	function catalogoTipoGasto($string)
	{
		$metodo = "";
		switch ($string) {
			case "G01 - Adquisici??n de Mercanc??as":
				$metodo = "G01";
				break;
			case "G02 - Devoluci??n descuentos o bonificaciones":
				$metodo = "G02";
				break;
			case "G03 - Gastos en General":
				$metodo = "G03";
				break;
			default:
				$metodo = "P01";
				break;
		}
		return $metodo;
	}
	public function generarFactura($idinvoice = null)
	{
		if ($idinvoice == null) {
			if (isset($_POST['idinvoice'])) {
				$idinvoice = $this->input->post("idinvoice", true);
			} else {
				echo json_encode([
					'result' => $this->error,
					'motivo' => 'No se ha recibido ningun parametro.',
					'codigo' => 'FAC000E'
				]);
				exit;
			}
		}
		$datoscliente = [];
		//	$rfccliente = 'XAXX010101000'; GENERICA
		$rfccliente = 'XXXXXXXXXXXXX';  //INVALIDA PARA QUE LO MODIFIQUE

		$diadepagofactura =	date("m-Y");
		$xmlParse = (object)[];
		$xmlParse->receptor = (object)[];
		$xmlParse->factura = (object)[];




		$factura = $this->recibirIDFactura($idinvoice);
		if ($factura->result == $this->success) {
			if ($factura->status == "Paid" && $factura->balance == "0.00") {
				if (!$this->preguntarFacturado($idinvoice)) {
					$datoscliente =	 json_decode($this->whmcs->funcion('GetClientsDetails', array("responsetype" => "json", "limitnum" => 1000000, "clientid" => $factura->userid)));
					$condicion = ($diadepagofactura == date("m-Y", strtotime($factura->date)));
					if ($condicion) {
						//verifacion RFC
						if ($datoscliente->tax_id != "") {
							$rfccliente = $datoscliente->tax_id;
						} else {
						}
						if ($this->utilerias->valida_rfc($rfccliente)) {
							//persona FISICA
							if (!ctype_digit($rfccliente[3])) {
								$xmlParse->receptor->razonsocial = $datoscliente->firstname . " " . $datoscliente->lastname;
							}
							//persona MORAL

							else {
								$xmlParse->receptor->razonsocial = $datoscliente->companyname;
							}
							$xmlParse->receptor->rfc = $rfccliente;
							//AGREGA EL METODO DE PAGO DE LAS FACTURAS
							foreach ($datoscliente->customfields as $row) {
								if ($row->id == $this->idinputmetodopago) {
									$xmlParse->receptor->metodopago = $this->catalogoMetodoPago($row->value);
								}
								//AGREGA EL TIPO DE GASTO DE LAS FACTURAS

								if ($row->id == $this->idinputtipogasto) {
									$xmlParse->receptor->metodopago->tipogasto = $this->catalogoTipoGasto($row->value);
								}
							}
							$xmlParse->factura->fecha = date('Y-m-d\TH:i:s');
							$xmlParse->emisor = $this->catalogoinformacionEmisor();
							$xmlParse->receptor->tipomoneda = $datoscliente->currency_code;
							$xmlParse->factura->id = $factura->invoiceid;
							//EN ESTE LUGAR SE ANIADE LOS DETALLES DE LA FACTURA
							$xmlParse->factura->descripcion = "VENTA POR INTERNET ID REFERENCIA {$factura->invoiceid} NUMERO REFERENCIA {$factura->invoicenum}";
							if (isset($factura->items->item)) {
								$descripcion = "ID REFERENCIA {$factura->invoiceid} NUMERO REFERENCIA {$factura->invoicenum} ";
								foreach ($factura->items->item as $row) {
									$descripcion .= $row->description . " ";
								}
								$xmlParse->factura->descripcion = $descripcion;
								//	$xmlParse->descripcionFactura = $descripcion;
							}
							$xmlParse->factura->numerofactura = $factura->invoicenum;

							$xmlParse->factura->total = $factura->total;
							$xmlParse->factura->subtotal = $factura->subtotal;
							$xmlParse->factura->totalimpuesto = $factura->tax;
							$version = vesion_stash();
							$facturaresponse = $this->setFacturaTXT($xmlParse);
							switch ($facturaresponse->codigo) {
								case "200":
									echo json_encode([
										'result' => $this->success,
										'motivo' => 'Esta factura fue timbrada correctamente, se ha enviado a su correo electronico su factura.',
										'codigo' => 'FAC001S'
									]);
									$idreference = $this->mf->insertarFactura([
										"fac_idinvoice" => $factura->invoiceid,
										"fac_detalle" => "FACTURADA POR INTRANET EN LA VERSION {$version}",
										"fac_tipo" => 1

									]);
									$tokenxml = $this->utilerias->generateToken();

									$urlxml = base_url(base_url_directory_invoice($facturaresponse->nombrefactura . ".xml"));
									$this->mf->insertarFacturaArchivos([
										"fac_arc_nombre" => $facturaresponse->nombrefactura . ".xml",
										"fac_arc_ash" => $tokenxml,
										"id_fac_reference" => $idreference,
										"fac_arc_tipo" => 1,
										"fac_arch_ruta_url" => $urlxml

									]);
									$tokenpdf = $this->utilerias->generateToken();
									$urlpdf = base_url(base_url_directory_invoice($facturaresponse->nombrefactura . ".pdf"));
									$this->mf->insertarFacturaArchivos([
										"fac_arc_nombre" => $facturaresponse->nombrefactura . ".pdf",
										"fac_arc_ash" => $tokenpdf,
										"id_fac_reference" => $idreference,
										"fac_arc_tipo" => 2,
										"fac_arch_ruta_url" => $urlpdf

									]);
									$name = $datoscliente->firstname . " " . $datoscliente->lastname;
									$xmlurl = base_url_directory_invoice_url($tokenxml);
									$pdfurl = base_url_directory_invoice_url($tokenpdf);
									$datosinvoice = [
										"nameperson" => $name,
										"urlxml" => $xmlurl,
										"urlpdf" => $pdfurl,
										"numinvoice" => $factura->invoicenum,

									];

									$folio = $this->utilerias->generarceros($factura->invoicenum, 9);
									$html = $this->returnHTMLTemplate($datosinvoice);
									$this->sendmail->setEmail(1, $datoscliente->email, "FACTURA: I-{$folio} - BLAZAR NETWORKS SA DE CV", $html);

									//CORREO ADMIN COPIA
									$urlxmltoken = base_url_directory_invoice_url_admin($tokenxml);
									$urlpdftoken = base_url_directory_invoice_url_admin($tokenpdf);
									$datosinvoice = [
										"nameperson" => $name,
										"urlxml" => $urlxmltoken,
										"urlpdf" => $urlpdftoken,
										"numinvoice" => $factura->invoicenum,

									];
									$emailcarbon = "facturacion@blazar.com.mx";
									$html = $this->returnHTMLTemplate($datosinvoice);
									$this->sendmail->setEmail(1, $emailcarbon, "FACTURA: I-{$folio} - BLAZAR NETWORKS SA DE CV", $html);

									break;
								case "205":
									echo json_encode([
										'result' => $this->error,
										'motivo' => 'EL CFDI YA SE ENCUENTRA TIMBRADO, VERIFIQUE SERIE/FOLIO.',
										'codigo' => 'FAS008E'
									]);
									break;
								case "301":
									echo json_encode([
										'result' => $this->error,
										'motivo' => 'CREDENCIALES INVALIDAS, VALIDE USUARIO Y/O CONTRASENA 
								ACTIVOS O CORRESPONDEN AL EMISOR SOLICITADO',
										'codigo' => 'FAS007E'
									]);
									break;
								case "302":
									echo json_encode([
										'result' => $this->error,
										'motivo' => 'SIN CREDITOS DISPONIBLES',
										'codigo' => 'FAS06E'
									]);
									break;
								case "303":
									echo json_encode([
										'result' => $this->error,
										'motivo' => 'ESTRUCTURA INCORRECTA: (SE ESPECIFICA EL ERROR)',
										'codigo' => 'FAS005E'
									]);
									break;
								case "304":
									echo json_encode([
										'result' => $this->error,
										'motivo' => 'CERTIFICADO NO CARGADO PARA LA CUENTA.',
										'codigo' => 'FAS004E'
									]);
									break;
								case "305":
									echo json_encode([
										'result' => $this->error,
										'motivo' => 'CERTIFICADO NO CARGADO PARA LA CUENTA',
										'codigo' => 'FAS003E'
									]);
									break;
								case "400":
									echo json_encode([
										'result' => $this->error,
										'motivo' => 'CERTIFICADO NO CARGADO PARA LA CUENTA',
										'codigo' => 'FAS002E'
									]);
									break;
								default:
									echo json_encode([
										'result' => $this->error,
										'motivo' => 'Ha ocurrido un error desconocido informelo inmediatamente en el area de sistemas.',
										'codigo' => 'FAS001E'
									]);
									break;
							}
						} else {
							echo json_encode([
								'result' => $this->error,
								'motivo' => 'El RFC del Receptor es invalido, verique sus datos en su perfil del Panel.',
								'codigo' => 'FAC004E'
							]);
						}
					} else {
						echo json_encode([
							'result' => $this->error,
							'motivo' => 'La factura ya no puede ser generada porque el pago se realizo fuera del rango de fecha de la creacion de la referencia.',
							'codigo' => 'FAC003E'
						]);
					}
				} else {
					echo json_encode([
						'result' => $this->error,
						'motivo' => 'Esta referencia ya fue facturada anteriormente.',
						'codigo' => 'FAC002E'
					]);
				}
			} else {

				echo json_encode([
					'result' => $this->error,
					'motivo' => 'La referencia no ha se encuentra pagada en su totalidad.',
					'codigo' => 'FAC005E'
				]);
			}
		} else {
			echo json_encode([
				'result' => $this->error,
				'motivo' => 'La referencia no fue encotrada.',
				'codigo' => 'FAC001E'
			]);
		}
	}
	//proceso 1 Recibir id factura y validar si existe
	public function recibirIDFactura($idinvoice)
	{
		return json_decode($this->whmcs->funcion('GetInvoice', array("responsetype" => "json", "limitnum" => 1000000, "invoiceid" => $idinvoice)));
	}
	//proceso2 preguntar si ya esta facturado
	public function preguntarFacturado($idinvoice)
	{
		return $this->mf->existeFactura($idinvoice);
	}
	//proceso3 si todo esta bien vamos a generarel xml
	public function generarXMLFactura($data)
	{
		$xml = new XMLWriter();
		$xml->openMemory();
		$xml->setIndent(true);
		$xml->setIndentString('	');
		$xml->startDocument('1.0', 'UTF-8');

		$xml->startElement("cfdi:Comprobante"); //NODO PRINCIPAL COMPROBANTE
		$xml->writeAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
		$xml->writeAttribute('xmlns:cfdi', 'http://www.sat.gob.mx/cfd/3');
		$xml->writeAttribute('xsi:schemaLocation', 'http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd');
		$xml->writeAttribute('Version', '3.3');
		$xml->writeAttribute('Serie', 'A');
		$xml->writeAttribute('Folio', "{$data->factura->numerofactura}");
		$xml->writeAttribute('Fecha', "{$data->factura->fecha}");
		$xml->writeAttribute('Sello', '');
		$xml->writeAttribute('FormaPago', "{$data->receptor->metodopago->codigo}");
		$xml->writeAttribute('NoCertificado', '');
		$xml->writeAttribute('Certificado', '');
		$xml->writeAttribute('CondicionesDePago', "{$data->receptor->metodopago->condicion}");
		$xml->writeAttribute('SubTotal', "{$data->factura->subtotal}");
		$xml->writeAttribute('Descuento', '0.00');
		$xml->writeAttribute('Moneda', "{$data->receptor->tipomoneda}");
		$xml->writeAttribute('TipoCambio', '1');
		$xml->writeAttribute('Total', "{$data->factura->total}");
		$xml->writeAttribute('TipoDeComprobante', 'I');
		$xml->writeAttribute('MetodoPago',  "{$data->receptor->metodopago->metodofac}");
		$xml->writeAttribute('LugarExpedicion', "{$data->emisor->codigopostal}");


		$xml->startElement("cfdi:Emisor"); //Nodo EMISOR
		$xml->writeAttribute('Rfc', "{$data->emisor->rfc}");
		$xml->writeAttribute('Nombre', "{$data->emisor->razonsocial}");
		$xml->writeAttribute('RegimenFiscal', "{$data->emisor->regimenfiscal}");
		$xml->endElement(); //fin NODO EMISOR

		$xml->startElement("cfdi:Receptor"); //Nodo RECEPTOR
		$xml->writeAttribute('Rfc', "{$data->receptor->rfc}");
		$xml->writeAttribute('Nombre', "{$data->receptor->razonsocial}");
		$xml->writeAttribute('UsoCFDI', "{$data->receptor->metodopago->tipogasto}");
		$xml->endElement(); //fin NODO RECEPTOR


		$xml->startElement("cfdi:Conceptos"); //Nodo Conceptos
		$xml->startElement("cfdi:Concepto"); //Nodo Concepto
		$xml->writeAttribute('ClaveProdServ', "{$data->emisor->ClaveProdServ}");
		$xml->writeAttribute('NoIdentificacion', "{$data->emisor->NoIdentificacion}");
		$xml->writeAttribute('Cantidad', '1.000000');
		$xml->writeAttribute('ClaveUnidad', "{$data->emisor->ClaveUnidad}");
		$xml->writeAttribute('Descripcion', "{$data->factura->descripcion}");
		$xml->writeAttribute('ValorUnitario', "{$data->factura->subtotal}");
		$xml->writeAttribute('Importe', "{$data->factura->subtotal}");
		$xml->writeAttribute('Descuento', '0.00');
		$xml->startElement("cfdi:Impuestos"); //Nodo Impuestos

		$xml->startElement("cfdi:Traslados"); //Nodo Traslados
		$xml->writeAttribute('Base', "{$data->factura->subtotal}");
		$xml->writeAttribute('Impuesto', '002');
		$xml->writeAttribute('TipoFactor', 'Tasa');
		$xml->writeAttribute('TasaOCuota', '0.160000');
		$xml->writeAttribute('Importe', "{$data->factura->totalimpuesto}");
		$xml->endElement(); //fin NODO Traslados

		$xml->endElement(); //fin NODO Impuestos




		$xml->endElement(); //fin NODO Concepto

		$xml->endElement(); //fin NODO Conceptos

		$xml->startElement("cfdi:Impuestos"); //Nodo Impuestos
		$xml->writeAttribute('TotalImpuestosTrasladados', "{$data->factura->totalimpuesto}");

		$xml->startElement("cfdi:Traslados"); //Nodo Traslados
		$xml->startElement("cfdi:Traslado"); //Nodo Traslado
		$xml->writeAttribute('Impuesto', '002');
		$xml->writeAttribute('TipoFactor', 'Tasa');
		$xml->writeAttribute('TasaOCuota', '0.160000');
		$xml->writeAttribute('Importe', "{$data->factura->totalimpuesto}");
		$xml->endElement(); //fin NODO Traslado

		$xml->endElement(); //fin NODO Traslados

		$xml->endElement(); //fin NODO Impuestos

		$xml->endElement(); //FIN NODO PRINCIPAL

		$content = $xml->outputMemory();
		ob_end_clean();
		ob_start();
		header('Content-Type: application/xml; charset=UTF-8');
		header('Content-Encoding: UTF-8');
		header("Content-Disposition: attachment;filename=FACT_{$data->factura->numerofactura}.xml");
		header('Expires: 0');
		header('Pragma: cache');
		header('Cache-Control: private');
		echo $content;
	}
	public function setFacturaTXT($data)
	{
		$folio = $this->utilerias->generarceros($data->factura->numerofactura, 9);
		$comprobante = [
			"serie" => "I",
			"folio" => "{$folio}",
			"fechaCFDI" => "{$data->factura->fecha}",
			"formaPago" => "{$data->receptor->metodopago->codigo}",
			"CondicionesPago" => "{$data->receptor->metodopago->condicion}",
			"Moneda" => "{$data->receptor->tipomoneda}",
			"TipoDeCambio" => "",
			"TipoComprobante" => "I",
			"MetodoDePago" => "{$data->receptor->metodopago->metodofac}",
			"LugarExpedicion" => "{$data->emisor->codigopostal}",
			"Confirmacion" => "",
			"Observacion1" => "",
			"Observacion2" => "",
			"TipoRelacion" => "",
		];
		$emisor = [
			"RazonSocialEmisor" => "{$data->emisor->razonsocial}",
			"RFC" => "{$data->emisor->rfc}",
			"RegimenFiscal" => "{$data->emisor->regimenfiscal}",
		];
		$receptor = [
			"RazonSocial" => "{$data->receptor->razonsocial}",
			"RFC" => "{$data->receptor->rfc}",
			"UsoCFDI" => "{$data->receptor->metodopago->tipogasto}",
		];
		$concepto = [
			"ClaveProdServ" => "{$data->emisor->ClaveProdServ}",
			"Noidentificacion" => "{$data->emisor->NoIdentificacion}",
			"Cantidad" => "1.000000",
			"ClaveUnidad" => "{$data->emisor->ClaveUnidad}",
			"Unidad" => "",
			"Descripcion" => "{$data->factura->descripcion}",
			"ValorUnitario" => "{$data->factura->subtotal}",
			"Importe" => "{$data->factura->subtotal}",
			"Descuento" => "",
			"NumeroPedimento" => "",
			"Cuenta Predial" => ""

		];
		//$this->utilerias->crearTXTVerticalBar($comprobante);
		$impuestotrasladoconcepto = [
			"Base" => "{$data->factura->subtotal}",
			"Impuesto" => "002",
			"TipoFactor" => "Tasa",
			"TasaoCuota" => "0.160000",
			"Importe" => "{$data->factura->totalimpuesto}",



		];
		//$this->utilerias->crearTXTVerticalBar($comprobante);
		$impuestotraslado = [
			"Impuesto" => "002",
			"TipoFactor" => "Tasa",
			"TasaoCuota" => "0.160000",
			"Importe" => "{$data->factura->totalimpuesto}",

		];
		$sumario = [
			"Subtotal" => "{$data->factura->subtotal}",
			"Descuento" => "0.00",
			"Total" => "{$data->factura->total}",
			"TotalImpuestosTrasladados" => "{$data->factura->totalimpuesto}",
			"TotalImpuestosRetenidos" => "",
		];
		$txtcomprobante = $this->utilerias->crearTXTVerticalBar($comprobante) . "\n";
		$txtemisor = $this->utilerias->crearTXTVerticalBar($emisor) . "\n";
		$txtreceptor = $this->utilerias->crearTXTVerticalBar($receptor) . "\n";
		$txtconcepto = $this->utilerias->crearTXTVerticalBar($concepto);
		$cadenalimpia = preg_replace("[\n|\r|\n\r]", "", $txtconcepto);
		$txtimpuestotrasladoconcepto = $this->utilerias->crearTXTVerticalBar($impuestotrasladoconcepto) . "\n";
		$txtimpuestotraslado = $this->utilerias->crearTXTVerticalBar($impuestotraslado) . "\n";
		$txtsumario = $this->utilerias->crearTXTVerticalBar($sumario) . "\n";
		$cadena = "COM|" . $txtcomprobante . "EMI|" . $txtemisor . "REC|" . $txtreceptor . "CON|" . $cadenalimpia . "\n" . "ITC|" . $txtimpuestotrasladoconcepto . "TRA|" . $txtimpuestotraslado . "SUM|" . $txtsumario;
		//	echo $cadena;
		$user = "BNE170213PV1";
		$pass = md5("Vz245RRA6zuPYw");
		$xmlB64 = base64_encode($cadena);
		$ws = $this->soaplib->conexiontimbra();


		$resp = $ws->timbrarCFDITxt($user, $pass, $xmlB64, true);
		$respuestas = json_decode($resp);

		$ramdom = rand(0, 9999);
		$nombrefactura = "FACT-{$data->factura->id}-{$data->factura->numerofactura}-{$ramdom}";
		file_put_contents(base_url_directory_invoice("{$nombrefactura}.xml"), $respuestas->xml);
		file_put_contents(base_url_directory_invoice("{$nombrefactura}.pdf"), base64_decode($respuestas->pdf));
		$respuestas->nombrefactura = $nombrefactura;
		return $respuestas;
	}
	public function returnHTMLTemplate($data)
	{
		$data['invoicedata'] = $data;
		return $this->load->view("emailtemplates/setbillings/v1/content.php", $data, TRUE);
	}
}
