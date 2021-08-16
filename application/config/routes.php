<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


//==INICIO DASHBOARD==//
$route['home/dashboard'] = 'welcome/getDashBoard';
//==LICENCIAMIENTO==//
$route['licenciamiento/tipolicencias'] = 'CLicenciamiento/getTipoLicencias';
$route['licenciamiento/afiliados'] = 'CLicenciamiento/getAfiliados';
$route['licenciamiento/stock'] = 'CLicenciamiento/getStock';
$route['licenciamiento/proveedores'] = 'CLicenciamiento/getProveedores';


//===============COMISIONES======================//
$route['comisiones/vendedores'] = 'CComisiones/vendedores';
$route['comisiones/vendedores-clientes'] = 'CComisiones/vendedoresclientes';
$route['comisiones/reportes'] = 'CComisiones/reportes';
$route['comisiones/reportes-tickets'] = 'CComisiones/reportestickets';


//===============COMISIONES======================//
$route['procesos/internos'] = 'CCProcesos/internos';


//============LOGIN=============//
//$route['directory/login'] = 'CLoginternal/setLogin';
$route['gods'] = 'CLoginternal/setLogin';

$route['directory/logout'] = 'CLoginternal/logoutRedirectic';
$route['directory/changepassword'] = 'CLoginternal/setChangePassword';
$route['directory/services/internal/login/destroy'] = 'CLoginternal/logout';
$route['directory/services/internal/login'] = 'CLoginternal/login';



//=======VISTAS VENDEDORES=========//
$route['directory/vendedores/vendedores-clientes'] = 'CVendedores/CComisiones/vendedoresclientes';
$route['directory/vendedores/reportes/panel'] = 'CVendedores/CComisiones/reportes';

//=======VISTAS USUARIOS=========//
$route['usuarios/administradores'] = 'CVendedores/CComisiones/vendedoresclientes';
//=======VISTAS Facturacion=========//
$route['facturacion/referencias'] = 'CFacturacionadmin/index';


//==============RESELLERS==================//
$route['directory/logout/resellers'] = 'Resellers/CLogin/logoutRedirectic';

//$route['directory/login/resellers'] = 'Resellers/CLogin/index';
$route['login'] = 'Resellers/CLogin/index';

$route['directory/services/external/login/resellers'] = 'Resellers/CLogin/validarLogin';
//$route['directory/resellers/home/index'] = 'Resellers/CResellers/index';
$route['resellers/home/index'] = 'Resellers/CResellers/dashboard';

$route['resellers/home/active'] = 'Resellers/CResellers/index';

$route['resellers/home/history'] = 'Resellers/CResellers/history';

$route['resellers/tools/vpnapp'] = 'Resellers/CHerramientas/setHerramientaVnpApp';
$route['resellers/tools/payments'] = 'Resellers/CHerramientas/setHerramientaPagos_Blazar';

$route['resellers/invoices/services/service/(:any)'] = 'Resellers/CResellers/invoice_for_service';

$route['resellers/invoices/services'] = 'Resellers/CResellers/invoices';

$route['resellers/invoices/services/service/invoice/(:any)'] = 'Resellers/CResellers/obtenerReferencia';

$route['facturacion/templates/cfdi/version/3.3/pagos'] = 'CFacturacion/CFacturav3/index';



$route['resellers/billing/search/file/(:any)'] = 'CFacturacion/CFacturav3/obtenerArchivoInvoice';

$route['facturacion/busqueda/archivo/(:any)'] = 'CFacturacion/CFacturav3admin/obtenerArchivoInvoice';

$route['licenciamiento/pedido/windows/(:any)'] = 'CLicenciamientoext/abrirFormularioPedido';
$route['licenciamiento/pedidos'] = 'CLicenciamiento/obtenerPedidos';


$route['ipam/servers'] = 'CIpam/index';
$route['ipam/servers/dhcp'] = 'CIpam/servidoresdhcp';


$route['resellers/billing/information'] = 'Resellers/CDatosfacturacion/vistaDatosFacturacion';
