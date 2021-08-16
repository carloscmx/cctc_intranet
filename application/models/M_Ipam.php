<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model M_Addons_model
 *
 * This Model for ...
 *
 * @package        CodeIgniter
 * @category    Model
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class M_Ipam extends CI_Model
{

    // ------------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', true);
        $this->load->library('mikrotik');
    }

    // ------------------------------------------------------------------------
    public function insertarChr($data)
    {
        $this->db->insert("mk_conexiones", $data);
    }
    public function insertarChrRelacionServicio($data)
    {
        $this->db->insert("mk_serviciosovh", $data);
    }
    public function regresarChrRelacionServicio($where = null)
    {
        $this->db->where($where);
        $this->db->select('*');
        $this->db->from('mk_serviciosovh');
        return $this->db->get();
    }
    public function regresarChr($where = null)
    {
        $this->db->where($where);
        $this->db->select('*');
        $this->db->from('mk_conexiones');
        return $this->db->get();
    }
    public function selectCredenciales($iId = null)
    {
        $get = '';
        if ($iId == null) {
            $get = $this->db->get('serv_credenciales');
        } else {
            $get = $this->db->get_where('serv_credenciales', ['iIdCredencial' => $iId]);
        }
        if ($get->num_rows() > 0) {
            if ($iId == null) {
                return $get->result_array();
            } else {
                $datos = $get->result_array();
                return $datos[0];
            }
        } else {
            return false;
        }
    }

    public function listarDHCPDisponibles($serverSelected)
    {
        $iMyDHCP = null;
        //Listado completo de tabla servicios OVH
        $getServicios = $this->db->get('mk_serviciosovh');

        //Listado de mi servidor DHCP seleccionado y relacionado con un servicio OVH
        $getMiServicio = $this->db->get_where('mk_serviciosovh', ['var_mk_nombre_servicio' => $serverSelected]);
        if ($getMiServicio->num_rows() > 0) {
            $rMiServicio = $getMiServicio->row();
            $iMyDHCP = $rMiServicio->int_mk_id_dhcp;
        }

        if ($getServicios->num_rows() > 0) {

            $dhcpOcupados = $getServicios->result_array();
            foreach ($dhcpOcupados as $val) {
                if ($iMyDHCP != null) {
                    if ($iMyDHCP != $val['int_mk_id_dhcp']) {
                        $this->db->where('int_mk_id_conexion!=', $val['int_mk_id_dhcp']);
                    }
                } else {
                    $this->db->where('int_mk_id_conexion!=', $val['int_mk_id_dhcp']);
                }
            }
            $this->db->select('int_mk_id_conexion, var_mk_nombre');
            $this->db->from('mk_conexiones');
            $get = $this->db->get();

            return $get->result_array();
        } else {
            $get = $this->db->get('mk_conexiones');
            return $get->result_array();
        }
    }
    public function miServidorDHCP($serverSelected)
    {
        $getMiServicio = $this->db->get_where('mk_serviciosovh', ['var_mk_nombre_servicio' => $serverSelected]);
        if ($getMiServicio->num_rows() > 0) {
            $rowMiServicio = $getMiServicio->row();
            return $rowMiServicio->int_mk_id_dhcp;
        } else {
            return false;
        }
    }

    public function insertarRelacionServicioDHCP($serviceName, $iIdDHCP)
    {
        //Verificando si este servicio ya se encuentra relacionado con el servidor DHCP enviado
        $numRows = $this->db->get_where(
            'mk_serviciosovh',
            [
                'var_mk_nombre_servicio' => $serviceName,
                'int_mk_id_dhcp' => $iIdDHCP
            ]
        )->num_rows();
        if ($numRows > 0) {
            //El servidor DHCP y el servicio ya se encuentran relacionados
            return [
                'status' => false,
                'message' => 'El servidor DHCP ya se encuentra relacionado con este servicio'
            ];
        } else {
            //Validamos si el servidor DHCP se encuentra disponible
            $numRows2 = $this->db->get_where(
                'mk_serviciosovh',
                [
                    'int_mk_id_dhcp' => $iIdDHCP
                ]
            )->num_rows();
            if ($numRows2 > 0) {
                //El servidor DHCP enviado no se encuentra disponible
                return [
                    'status' => false,
                    'message' => 'El servidor DHCP no se encuentra disponible'
                ];
            } else {
                $numRows3 = $this->db->get_where('mk_serviciosovh', ['var_mk_nombre_servicio' => $serviceName])->num_rows();
                if ($numRows3 > 0) {
                    $this->db->update('mk_serviciosovh', ['int_mk_id_dhcp' => $iIdDHCP], ['var_mk_nombre_servicio' => $serviceName]);
                    if ($this->db->affected_rows() > 0) {
                        return [
                            'status' => true,
                            'message' => 'Relacion actualizada'
                        ];
                    } else {
                        return [
                            'status' => false,
                            'message' => 'Error al actualizar relacion'
                        ];
                    }
                } else {
                    $this->db->insert('mk_serviciosovh', ['int_mk_id_dhcp' => $iIdDHCP, 'var_mk_nombre_servicio' => $serviceName]);
                    return [
                        'status' => true,
                        'message' => 'Relacion creada'
                    ];
                    /* if ($this->db->insert_id() > 0) {
                    } else {
                        return [
                            'status' => false,
                            'message' => 'Error al crear relacion'
                        ];
                    } */
                }
            }
        }
    }
    public function getServidorDHCPServicio($serviceName)
    {
        $getDHCPServicios = $this->db->get_where('mk_serviciosovh', ['var_mk_nombre_servicio' => $serviceName]);
        if ($getDHCPServicios->num_rows() > 0) {
            $row = $getDHCPServicios->row();
            $idDHCP = $row->int_mk_id_dhcp;
            $getConexiones = $this->db->get_where('mk_conexiones', ['int_mk_id_conexion' => $idDHCP]);
            if ($getConexiones->num_rows() > 0) {
                $rowConexiones = $getConexiones->row();

                return [
                    'direccion' => $rowConexiones->var_mk_direccion,
                    'usuario' => $rowConexiones->var_mk_usuario,
                    'password' => $rowConexiones->txt_mk_password,
                    'puerto' => $rowConexiones->int_mk_puerto,
                ];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function insertLeaseDHCP($responseConexiones, $ipAddress, $macGenerada)
    {
        $API = $this->mikrotik->initAPI();
        if ($this->mikrotik->initConexion($API, $responseConexiones)) {
            $API->write('/ip/dhcp-server/lease/add', false);
            $API->write("=address=$ipAddress", false);
            $API->write("=mac-address=$macGenerada");
            $READ = $API->read(false);

            $arrResponse = $API->parseResponse($READ);
            $API->disconnect();
            $replaced = explode('*', $arrResponse);
            if ($replaced[1] > 0) {
                return true;
            } else {
                return $arrResponse;
            }
        } else {
            return false;
        }
    }

    public function insertarNuevaConexion($datos)
    {
        $this->db->insert('serv_credenciales', $datos);
        if ($this->db->insert_id() > 0) {
            return true;
        } else {
            return false;
        }
    }
}

/* End of file M_Addons_model.php */
/* Location: ./application/models/M_Addons_model.php */
