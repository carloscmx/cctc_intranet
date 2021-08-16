<?php
require_once('API_MK/routeros_api.class.php');
defined('BASEPATH') or exit('No direct script access allowed');



class Mikrotik
{

  // ------------------------------------------------------------------------

  public function __construct()
  {
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------

  public function getConexionesCHR()
  {
    $API = new RouterosAPI();

    if ($API->connect('66.70.226.194', 'syspro', 'Dfr4%1f3', 8728)) {
      $API->write('/tool/user-manager/user/print', false);
      $API->write('?active-sessions', false);
      $API->write('=count-only');
      $READ = $API->read(false);
      $ARR = $API->parseResponse($READ);

      return $ARR[0];
    } else {
      return false;
    }
  }

  /* INSTANCIA EL OBJETO API */
  public function initAPI()
  {
    $API = new RouterosAPI();
    return $API;
  }


  /* INICIA LA CONEXION UNA VEZ INSTANCIADO EL OBJETO API */
  public function initConexion($API, $arrAccess = [])
  {
    if (empty($arrAccess)) {
      if ($API->connect('66.70.226.194', 'syspro', 'Dfr4%1f3', 8728)) {
        return true;
      } else {
        return false;
      }
    } else {
      if ($API->connect("{$arrAccess['direccion']}",  "{$arrAccess['usuario']}", "{$arrAccess['password']}", $arrAccess['puerto'])) {
        return true;
      } else {
        return false;
      }
    }
  }
  public function testConexion($paramets = [])
  {

    $bool = false;
    $API = new RouterosAPI();
    if (!empty($paramets)) {
      if ($API->connect($paramets['var_mk_direccion'], $paramets['var_mk_usuario'], $paramets['txt_mk_password'], $paramets['int_mk_puerto'])) {
        $bool = true;
        $API->disconnect();
      }
    }
    return $bool;
  }



  // ------------------------------------------------------------------------
}

/* End of file Mikrotik.php */
/* Location: ./application/libraries/Mikrotik.php */