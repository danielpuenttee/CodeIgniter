<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Empleados extends Administrador_Controller
{
    public function __construct()
    {
        parent::__construct();

        if(!isset($this->session->PROD_PAGINA))
            $this->session->set_userdata(array('PROD_PAGINA' => EMPLEADOS_POR_PAGINA));

        $filtros = array(
            'IDENTIFICADOR' => '',
            'NOMBRE' => '',
            'APELLIDOS' => '',
            'FECHA_NACIMIENTO' => '',
            'ORDER_BY' => 'NOMBRE',
            'ORDER_DIR' => 'ASC'
        );

        if(!isset($this->session->FILTROS_EMPLEADOS)) $this->session->set_userdata(array('FILTROS_EMPLEADOS' => $filtros));
        if(!isset($this->session->OFFSET)) $this->session->set_userdata(array('OFFSET' => 0));
    }

    public function index() {
        self::listado();
    }
    public function listado(){
        $config = array();
        $config["base_url"] = '/codeigniter/zona_privada/empleados/listado';
        $config["total_rows"] = $this->ZonaPrivada_model->empleados_totales($this->session->FILTROS_EMPLEADOS);

        $this->session->PROD_PAGINA = (int) ($this->input->post('productos_por_pagina') ?? $this->session->PROD_PAGINA);

        $config["per_page"] = $this->session->PROD_PAGINA;
        $this->pagination->initialize($config);

        if($this->uri->segment(4) === 'volver') {
            if(isset($this->session->OFFSET)) header('Location: /codeigniter/zona_privada/empleados/listado/' . $this->session->OFFSET);
            else header('Location: /codeigniter/zona_privada/empleados/listado');
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

        $empleados = $this->ZonaPrivada_model->get_empleados($config["per_page"], $offset, $this->session->FILTROS_EMPLEADOS);
        foreach ($empleados as $key => &$empleado) {
            $empleado['IDENTIFICADOR'] = anchor(site_url(RUTA_ADMINISTRACION . '/empleados/ficha/' . $empleado['PK_ID_EMPLEADO']), $empleado['IDENTIFICADOR']);
            $empleado['NOMBRE'] = anchor(site_url(RUTA_ADMINISTRACION . '/empleados/ficha/' . $empleado['PK_ID_EMPLEADO']), $empleado['NOMBRE']);
            $empleado['APELLIDOS'] = anchor(site_url(RUTA_ADMINISTRACION . '/empleados/ficha/' . $empleado['PK_ID_EMPLEADO']), $empleado['APELLIDOS']);
            $empleado['FECHA_NACIMIENTO'] = anchor(site_url(RUTA_ADMINISTRACION . '/empleados/ficha/' . $empleado['PK_ID_EMPLEADO']), alt_text(date('d/m/Y', strtotime($empleado['FECHA_NACIMIENTO']))));

            unset($empleado['PK_ID_EMPLEADO']);
        }
        $data['empleados'] = $empleados;

        $data['filtros'] = $this->session->FILTROS_EMPLEADOS;

        $this->load->view('administracion/empleados/listado', $data);
    }

    public function buscar() {
        $ano_actual = date('Y');

        $this->form_validation->set_rules('txIdentificador', 'Identificador', "trim|alpha_numeric|max_length[6]");
        $this->form_validation->set_rules('txNombre', 'Nombre', 'trim|alpha_numeric');
        $this->form_validation->set_rules('txApellidos', 'Apellidos', 'trim|alpha_numeric_spaces');
        $this->form_validation->set_rules('intAno', 'Fecha de Nacimiento', "trim|integer|greater_than_equal_to[1900]|less_than_equal_to[" . $ano_actual . "]");

        if(!$this->form_validation->run()) $this->index();
        else {
            $filtros = $this->session->FILTROS_EMPLEADOS;
            $filtros['IDENTIFICADOR'] = $this->input->post('txIdentificador');
            $filtros['NOMBRE'] = $this->input->post('txNombre');
            $filtros['APELLIDOS'] = $this->input->post('txApellidos');
            $filtros['FECHA_NACIMIENTO'] = (int) $this->input->post('intAno');
            $filtros['ORDER_BY'] = $this->input->post('order_by');
            $filtros['ORDER_DIR'] = $this->input->post('order_dir');
            $this->session->FILTROS_EMPLEADOS = $filtros;

            $this->index();
        }
    }

    public function resetear() {
        $this->session->FILTROS_EMPLEADOS = array(
            'IDENTIFICADOR' => '',
            'NOMBRE' => '',
            'APELLIDOS' => '',
            'FECHA_NACIMIENTO' => '',
            'ORDER_BY' => 'NOMBRE',
            'ORDER_DIR' => 'ASC'
        );
        $this->session->PROD_PAGINA = VEHICULOS_POR_PAGINA;

        $this->index();
    }

    public function ficha(int $id_empleado = NULL, $nuevo_id=NULL)
    {
        if(is_null($id_empleado)) {
            http_response_code(404);
            exit;
        }

        if ($id_empleado === 0) {
            $empleado = NULL;
            $nuevo_id = is_null($nuevo_id) ? random_string('alnum', 6) : $nuevo_id;
        }
        else $empleado = $this->ZonaPrivada_model->empleado_por_id($id_empleado);
        if(!is_null($empleado) && empty($empleado)) {
            http_response_code(404);
            exit;
        }

        $data['empleado'] = $empleado;
        $data['nuevo_id'] = $nuevo_id;
        $this->load->view('administracion/empleados/ficha', $data);
    }

    public function guardar()
    {
        $this->form_validation->set_rules('txNombre', 'Nombre', "trim|required|alpha_numeric");
        $this->form_validation->set_rules('txApellidos', 'Apellidos', "trim|required|alpha_numeric_spaces");
        $this->form_validation->set_rules('txNacimiento', 'Nacimiento', "alpha_numeric");


        if(!$this->form_validation->run()) {
            $this->ficha($this->input->post('intId'), $this->input->post('txIdentificador'));
        }
        else {
            $fecha = date('Y-m-d', strtotime($this->input->post('dtNacimiento')));
            if($fecha === "1970-01-01") $fecha = NULL;

            $empleado = array(
                'IDENTIFICADOR' => $this->input->post('txIdentificador'),
                'NOMBRE' => $this->input->post('txNombre'),
                'APELLIDOS' => $this->input->post('txApellidos'),
                'FECHA_NACIMIENTO' => $fecha
            );

            $this->ZonaPrivada_model->insertar_modificar_empleado((int) $this->input->post('intId'), $empleado);

            $this->resetear();
        }
    }
}