<?php

/**
 *
 * @package	CodeIgniter
 * @author	Carlos Cauich
 * @copyright	Copyright (c) Blazar Networks. (https://blazar.mx/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') or exit('No direct script access allowed');


if (!function_exists('input_text_numeric')) {
	/**
	 * setClassById
	 *
	 * Crear un script para agregar una clase adicional mediante un ID.
	 *
	 * @param	string	$id
	 * @param	string	$class
	 * @return	string
	 */
	function init_input_valid_numeric()
	{
		$script = "
		<script>
		function input_text_numeric(evento) {
			evento.value = evento.value.replace(/[^0-9.]/g, '');
		}
		</script>";
		return $script;
	}
}

if (!function_exists('input_valid_numeric')) {
	function input_valid_numeric()
	{
		$script = "onkeyup='input_text_numeric(this)' ";
		return $script;
	}
}
if (!function_exists('init_input_valid_numeric_max')) {
	function init_input_valid_numeric_max($max = null)
	{
		if ($max == null) {
			$max = 100.00;
		}
		$script = "
		<script>
		function changeHandler(val)
		{
			if (val.value > {$max})
			{
			val.value = {$max}
			}
		}
		</script>
		";
		return $script;
	}
}
if (!function_exists('input_valid_numeric_max')) {
	function input_valid_numeric_max()
	{
		$script = " onchange='changeHandler(this)' ";
		return $script;
	}
}
if (!function_exists('setClassById')) {
	/**
	 * setClassById
	 *
	 * Crear un script para agregar una clase adicional mediante un ID.
	 *
	 * @param	string	$id
	 * @param	string	$class
	 * @return	string
	 */
	function setClassById($id, $class)
	{
		$script = "
		<script>
		$(document).ready(function() {
		var elemento = document.getElementById('{$id}');
		elemento.className += ' {$class}';
		});
		</script>";
		return $script;
	}
}
if (!function_exists('loadscript')) {
	/**
	 * setClassById
	 *
	 * Crear un script para agregar una clase adicional mediante un ID.
	 *
	 * @param	string	$id
	 * @param	string	$class
	 * @return	string
	 */
	function loadscript($function, $etiquetas = true)
	{
		if ($etiquetas) {
			$script = "
			<script>
			{$function}();
			</script>
			";
		} else {
			$script = "{$function}()";
		}
		return $script;
	}
}
if (!function_exists('onloadscript')) {
	/**
	 * setClassById
	 *
	 * Crear un script para agregar una clase adicional mediante un ID.
	 *
	 * @param	string	$id
	 * @param	string	$class
	 * @return	string
	 */
	function onloadscript($function, $etiquetas = true)
	{
		if ($etiquetas) {
			$script = "
			<script>
			$( document ).ready(function() {
				{$function}()
			});
			</script>
			";
		} else {
			$script = "
			$( document ).ready(function() {
				{$function}()
			});
			";
		}
		return $script;
	}
}

function setAlert($title, $class = null, $etiquita = false)
{
	if ($class == null) {
		$class = "success";
	}
	$script = "";
	if ($etiquita) {
		$script = "
<script>
Swal.fire({
	position: 'top-end',
	icon: '{$class}',
	title: '{$title}',
	showConfirmButton: false,
	timer: 1500
  })
</script>";
	} else {
		$script = "
		Swal.fire({
			position: 'top-end',
			icon: '{$class}',
			title: '{$title}',
			showConfirmButton: false,
			timer: 1500
		  });";
	}
	return $script;
}



if (!function_exists('setAlertConfirmDelete')) {
	/**
	 * setClassById
	 *
	 * Crear un script para agregar una clase adicional mediante un ID.
	 *
	 * @param	string	$id
	 * @param	string	$class
	 * @return	string
	 */
	function setAlertConfirmDelete($nombrefuncion, $url, $accion = null)
	{
		if ($accion == null) {
			$accion = "console.log('OK TABLE')";
		}
		$script = "
		<script>
	function {$nombrefuncion}(paramet){


	}
	
		</script>";
		return $script;
	}
}

if (!function_exists('setAlertConfirmUpdate')) {
	/**
	 * setClassById
	 *
	 * Crear un script para agregar una clase adicional mediante un ID.
	 *
	 * @param	string	$id
	 * @param	string	$class
	 * @return	string
	 */
	function setAlertConfirmUpdate($nombrefuncion, $url, $accion = null)
	{
		if ($accion == null) {
			$accion = "console.log('CHANGE SET')";
		}
		$script = "
		<script>
	function {$nombrefuncion}(paramet){
		Swal.fire({
			title: '¿Estas seguro?',
			text: 'Esta acción modificara registros en el sistema',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, update it!'
		  }).then((result) => {
			
			if (result.isConfirmed) {
			  Swal.fire(
				'Actualizado!',
				'El registro fue modificado correctamente.',
				'success'
			  );
			  $.post( '{$url}', paramet ,function(){ {$accion} });
			  
			}
		  })
	}
	
		</script>";
		return $script;
	}
}

if (!function_exists('setDelete')) {
	/**
	 * setClassById
	 *
	 * Crear un script para agregar una clase adicional mediante un ID.
	 *
	 * @param	string	$id
	 * @param	string	$class
	 * @return	string
	 */
	function setDelete($nombrefuncion, $url, $accion = null, $etiquita = true)
	{
		$script = "
		function {$nombrefuncion}(paramet){
			Swal.fire({
				title: '¿Estas seguro?',
				text: 'Esta acción eliminara registros en el sistema',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Eliminar'
			  }).then((result) => {
				
				if (result.isConfirmed) {
				  Swal.fire(
					'Eliminado',
					'El registro fue eliminado correctamente.',
					'success'
				  );
				  $.post( '{$url}', paramet ,function(){ {$accion} });
				  
				}
			  })
		}";
		if ($etiquita) {
			$script = "<script>{$script}</script>";
		}
		return $script;
	}
}







if (!function_exists('setDataTable')) {
	/**
	 * setDataTable
	 *
	 * Crear una instancia del datatable.
	 * @param	string	$nombrefuncion
	 * @param	string	$id
	 * @param	string	$url
	 * @param	array	$orden
	 * @return	string
	 */
	function setDataTable($nombrefuncion, $id, $url, $orden, $atributos = null)
	{
		$columnas = "";
		for ($i = 0; $i < count($orden); $i++) {
			$columnas .= "{ 'data': '{$orden[$i]}' },";
		}

		$script = "
		<script>
	
function {$nombrefuncion}(){
	var table= $('#{$id}').DataTable({
		'language': {
		'url': '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'},
		'ajax': '{$url}',
		'columns': [
			{$columnas}
		]
	  });
	  return table;
}		
var {$nombrefuncion}={$nombrefuncion}();

		</script>";
		return $script;
	}
}
if (!function_exists('vesion_stash')) {
	function vesion_stash()
	{
		$version = " v1.11.093";
		return $version;
	}
}
if (!function_exists('hidelat')) {
	/**
	 * setClassById
	 *
	 * Crear un script para agregar una clase adicional mediante un ID.
	 *
	 * @param	string	$id
	 * @param	string	$class
	 * @return	string
	 */
	function hidelat($etiquetas = true)
	{
		if ($etiquetas) {
			$script = "
			<script>
			$( document ).ready(function() {
				{
					$('#pcoded').attr('vertical-nav-type', 'offcanvas');

				}
			});
			</script>
			";
		} else {
			$script = "
			$( document ).ready(function() {
				{
					$('#pcoded').attr('vertical-nav-type', 'offcanvas');
				}
			});
			";
		}
		return $script;
	}
}
if (!function_exists('reference_bank')) {
	function reference_bank()
	{
		$bank = "Banorte";
		$bussines = "BLAZAR NETWORKS SA DE CV";
		$bussinescount = "0305948436";
		$keybank = "072910003059484365";
		$reference = "";
		$reference .= "<p>Banco {$bank}</p>";
		$reference .= "<p>Empresa: {$bussines}</p>";
		$reference .= "<p>Cuenta: {$bussinescount}</p>";
		$reference .= "<p>CLABE: {$keybank}</p>";
		return $reference;
	}
}
if (!function_exists('reference_paymetto')) {
	function reference_paymetto()
	{

		$reference = "";
		$reference .= "<p>80 686B X 35 \n BOULEVARES MERIDA, YUCATAN. MEXICO \n RFC: IVA </p>";
		return $reference;
	}
}
if (!function_exists('base_url_directory_invoice')) {
	function base_url_directory_invoice($name)
	{

		return "recursos/facturacion/v3/tipos/ingreso/{$name}";
	}
}
if (!function_exists('base_url_directory_invoice_url')) {
	function base_url_directory_invoice_url($name)
	{

		return base_url("resellers/billing/search/file/{$name}");
	}
}
if (!function_exists('base_url_directory_invoice_url_admin')) {
	function base_url_directory_invoice_url_admin($name)
	{

		return base_url("facturacion/busqueda/archivo/{$name}");
	}
}


if (!function_exists('facturacion_fecha_produccion')) {
	function facturacion_fecha_produccion()
	{

		return "01-08-2021";
	}
}
if (!function_exists('url_cliente_factura_archivo')) {
	function url_cliente_factura_archivo($file)
	{

		return "https://facturacion.blazar.mx/billing/search/file/{$file}";
		//return "https://localhost/facturacionblazar/billing/search/file/{$file}";
	}
}
if (!function_exists('nombre_input_licencia_windows')) {
	function nombre_input_licencia_windows()
	{

		return trim("Lic. Windows");
	}
}
