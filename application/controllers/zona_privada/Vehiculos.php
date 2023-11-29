<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehiculos extends Administrador_Controller {

    public function __construct()
    {
        parent::__construct();

        if(!isset($_SESSION)) session_start();
        if(!isset($this->session->PROD_PAGINA))
            $this->session->set_userdata(array('PROD_PAGINA' => VEHICULOS_POR_PAGINA));

        $filtros = array(
            'MARCA' => '',
            'MODELO' => '',
            'MATRICULA' => '',
            'UBICACION' => '',

            'ORDER_BY' => 'MARCA',
            'ORDER_DIR' => 'ASC'
        );

        if(!isset($this->session->FILTROS_PRIVADO)) $this->session->set_userdata(array('FILTROS_PRIVADO' => $filtros));
        if(!isset($this->session->OFFSET)) $this->session->set_userdata(array('OFFSET' => 0));

        $marcas = array('' => '-');
        $marcas = array_merge($marcas, $this->ZonaPublica_model->get_marcas());
        $this->session->MARCAS = $marcas;
    }

    public function index()
    {
        self::listado();
    }

    public function listado()
    {
        $config = array();
        $config["base_url"] = '/codeigniter/' . RUTA_ADMINISTRACION . '/vehiculos/listado';
        $config["total_rows"] = $this->ZonaPublica_model->vehiculos_totales($this->session->FILTROS_PRIVADO);

        $this->session->PROD_PAGINA = (int) ($this->input->post('productos_por_pagina') ?? $this->session->PROD_PAGINA);

        $config["per_page"] = $this->session->PROD_PAGINA;
        $this->pagination->initialize($config);

        if($this->uri->segment(4) === 'volver') {
            if(isset($this->session->OFFSET)) header('Location: ' . RUTA_ADMINISTRACION . '/vehiculos/listado/listado' . $this->session->OFFSET);
            else header('Location: ' . RUTA_ADMINISTRACION . '/vehiculos/listado/listado');
        }

        $offset = ($this->uri->segment(4)) ? (int) $this->uri->segment(4) : 0;
        $pagina = $offset / $config["per_page"] + 1;
        $this->session->OFFSET = $offset;

        $total_paginas = (int)ceil($config["total_rows"] / $config["per_page"]);

        $data['paginacion'] = array(
            "LIMIT" => $config["per_page"],
            "OFFSET" => $offset,
            "PAGINA" => $pagina,
            "OFFSET_PAGINA" => $pagina !== 0 ? ($pagina - 1) * $config["per_page"] : 0,
            "TOTAL" => (int) $config["total_rows"],
            "TOTAL_PAGINAS" => $total_paginas
        );

        $vehiculos = $this->ZonaPublica_model->get_vehiculos($config["per_page"], $offset, $this->session->FILTROS_PRIVADO);
        $existe_foto = false;
        foreach ($vehiculos as $key => &$vehiculo) {
            $vehiculo['MARCA'] = anchor(site_url(RUTA_ADMINISTRACION . '/vehiculos/ficha/' . $vehiculo['PK_ID_VEHICULO']), $vehiculo['MARCA']);
            $vehiculo['MODELO'] = anchor(site_url(RUTA_ADMINISTRACION . '/vehiculos/ficha/' . $vehiculo['PK_ID_VEHICULO']), $vehiculo['MODELO']);
            $vehiculo['MATRICULA'] = anchor(site_url(RUTA_ADMINISTRACION . '/vehiculos/ficha/' . $vehiculo['PK_ID_VEHICULO']), $vehiculo['MATRICULA']);
            $vehiculo['UBICACION'] = anchor(site_url(RUTA_ADMINISTRACION . '/vehiculos/ficha/' . $vehiculo['PK_ID_VEHICULO']), $vehiculo['UBICACION']);
            if(!is_null($vehiculo['RENOMBRADO'])) {
                $vehiculo['RENOMBRADO'] = '<img style="max-width:200px; max-height:200px;" src="/codeigniter/imagenes/vehiculos/' . $vehiculo['RENOMBRADO'] . '">';
                $existe_foto = true;
            } else unset($vehiculo['RENOMBRADO']);
            unset($vehiculo['PK_ID_VEHICULO']);
        }
        $data['vehiculos'] = $vehiculos;
        $data['existe_foto'] = $existe_foto;

        $data['filtros'] = $this->session->FILTROS_PRIVADO;
        $data['marcas'] = $this->session->MARCAS;

        $this->load->view('administracion/vehiculos/listado', $data);
    }

    public function buscar() {
        $cadenaMarcas = implode(",", $this->session->MARCAS);

        $this->form_validation->set_rules('selMarca', 'Marca', "in_list[$cadenaMarcas]");
        $this->form_validation->set_rules('txModelo', 'Modelo', 'alpha_numeric_spaces');
        $this->form_validation->set_rules('txMatricula', 'Matricula', 'trim|alpha_numeric|max_length[7]');
        $this->form_validation->set_rules('txUbicacion', 'Ubicacion', 'trim');

        if(!$this->form_validation->run()) $this->index();
        else {
            $filtros = $this->session->FILTROS_PRIVADO;
            $filtros['MARCA'] = $this->input->post('selMarca');
            $filtros['MODELO'] = $this->input->post('txModelo');
            $filtros['MATRICULA'] = $this->input->post('txMatricula');
            $filtros['UBICACION'] = $this->input->post('txUbicacion');

            $filtros['ORDER_BY'] = $this->input->post('order_by');
            $filtros['ORDER_DIR'] = $this->input->post('order_dir');
            $this->session->FILTROS_PRIVADO = $filtros;

            $this->index();
        }
    }

    public function ficha(int $id_vehiculo = NULL, $errores=array('foto' => ''))
    {
        if(is_null($id_vehiculo)) {
            http_response_code(404);
            exit;
        }

        if ($id_vehiculo === 0) {
            $vehiculo = NULL;
        }
        else $vehiculo = $this->ZonaPublica_model->vehiculo_por_id($id_vehiculo);
        if(empty($vehiculo)) http_response_code(404);

        $reservas = $this->ZonaPrivada_model->get_reservas_botones($id_vehiculo);
        if(!is_null($vehiculo)) {
            foreach ($reservas as $key => &$reserva) {
                if ($reserva['ESTADO'] === 'Pte. de Aceptar')
                    $reserva['BOTONES'] =
                        '<button 
                            type="button" 
                            onclick="window.location.href=\'' . site_url(RUTA_ADMINISTRACION . '/reservas/aceptar/' . $reserva['PK_ID_RESERVA'] . '/' . $vehiculo['PK_ID_VEHICULO']) . '\'">
                                Aceptar
                        </button>'
                        . ' ' .
                        '<button 
                            type="button" 
                            onclick="window.location.href=\'' . site_url(RUTA_ADMINISTRACION . '/reservas/denegar/' . $reserva['PK_ID_RESERVA'] . '/' . $vehiculo['PK_ID_VEHICULO']) . '\'">
                                Denegar
                        </button>';
                unset($reserva['PK_ID_RESERVA']);
            }
        }


        $data['vehiculo'] = $vehiculo;
        $data['reservas'] = $reservas;
        $data['errores'] = $errores;
        $this->load->view('administracion/vehiculos/ficha', $data);
    }

    public function guardar()
    {
        $id_vehiculo = (int) $this->input->post('intId');
        $this->form_validation->set_rules('txMatricula', 'Matricula', "trim|required|alpha_numeric|max_length[7]|callback_unico[' . $id_vehiculo . ']'");
        $this->form_validation->set_rules('txMarca', 'Marca', "trim|required|alpha");
        $this->form_validation->set_rules('txModelo', 'Modelo', "trim|required|alpha_numeric_spaces");
        $this->form_validation->set_rules('txUbicacion', 'Ubicacion', "trim|required");

        $this->form_validation->set_message('unico', '{field} ya existente.');

        if(!$this->form_validation->run()) {
            $this->ficha($id_vehiculo);
        }
        else {
            $vehiculo = array(
                'MATRICULA' => $this->input->post('txMatricula'),
                'MARCA' => $this->input->post('txMarca'),
                'MODELO' => $this->input->post('txModelo'),
                'UBICACION' => $this->input->post('txUbicacion')
            );

            $this->ZonaPrivada_model->insertar_modificar_vehiculo($id_vehiculo, $vehiculo);

            if (!empty($_FILES['foto_vehiculo']['name']) && !$this->ZonaPrivada_model->existe_foto($id_vehiculo)) {
                $extension = explode('.', $_FILES['foto_vehiculo']['name']);

                $config['file_name'] = 'vehiculo_' . $vehiculo['MATRICULA'] . '.' . end($extension);
                $config['upload_path'] = 'imagenes/vehiculos';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048; // Tamaño máximo en kilobytes

                $this->load->library('upload');
                $this->upload->initialize($config);


                if (!$this->upload->do_upload('foto_vehiculo')) {
                    $errores = array('foto' => $this->upload->display_errors());

                    $this->ficha($id_vehiculo, $errores);
                } else {
                    $foto = array(
                        'FK_ID_VEHICULO' => $id_vehiculo,
                        'ORIGINAL' => $_FILES['foto_vehiculo']['name'],
                        'RENOMBRADO' => $config['file_name']
                    );

                    $this->ZonaPrivada_model->insertar_modificar_foto($foto);
                    $this->resetear();
                }
            }
            else {
                $this->resetear();
            }
        }
    }

    public function resetear() {
        $this->session->FILTROS_PRIVADO = array(
            'MARCA' => '',
            'MODELO' => '',
            'MATRICULA' => '',
            'UBICACION' => '',

            'ORDER_BY' => 'MARCA',
            'ORDER_DIR' => 'ASC'
        );
        $this->listado();
    }

    public function unico($value, $id_vehiculo)
    {
        if($id_vehiculo !== 0) return true;
        return !$this->ZonaPrivada_model->existe_vehiculo($value);
    }
}
