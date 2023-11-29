<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Administrador extends Administrador_Controller
{
	public function index()
	{
		header("Location:" . site_url(RUTA_ADMINISTRACION . '/inicio'));
		exit;
	}

	/**
	 * Controlador encargado de mostrar el formulario de login y/o de recoger el
	 * envío y realizar el login del administrador
	 */
	public function login()
	{
        $this->session->unset_userdata('FILTROS_PUBLICO');

		$this->load->library('form_validation');
		$this->load->helper('form');

		// Primero compruebo si ya está logueado el usuario
		if (!empty($this->administrador) && isset($this->administrador["PK_ID_ADMINISTRADOR"])) {
			header("Location:" . site_url(RUTA_ADMINISTRACION . '/inicio'));
			exit;
		}

		// Genero las reglas para validar el login del usuario
		$this->form_validation->set_rules('txUsername', 'Email', 'trim|required');
		$this->form_validation->set_rules('txPassword', 'Contraseña', 'required');

		if ($this->form_validation->run() === FALSE) // Devolverá FALSE si no hay POST o existe un error al validar el formulario
		{
			$this->load->view('administracion/login', (isset($this->data)) ? $this->data : array());
			return;
		} else {
			// Obtengo el administrador desde bbdd a través de su email
			$administrador = $this->Administrador_model->get_usuario('EMAIL', $this->input->post('txUsername'));

			// Compruebo que exista el administrador en bbdd
			if (!$administrador) {
				$this->data['validation_errors'][] = "Usuario o contraseña incorrecta";
				$this->load->view('administracion/login', $this->data);
				return;
			}

			// Compruebo la contraseña. Genero el hash en sha-256 y compruebo con la contraseña obtenida de base de datos.
			$password = hash("sha256", $this->input->post('txPassword') ?? '');
			if ($password != $administrador['PASSWORD']) {
				$this->data['validation_errors'][] = "Usuario o contraseña incorrecta";
				$this->load->view('administracion/login', $this->data);
				return;
			}

			// Si llega hasta aquí, está ok. Logueo al administrador
			$usuario_administrador = $this->Administrador_model->get($administrador['PK_ID_ADMINISTRADOR']);
			$this->session->set_userdata('administrador', $usuario_administrador);

			header("Location:" . site_url(RUTA_ADMINISTRACION . '/inicio'));
			exit;
		}
	}

	/**
	 * Función que realiza el logout de la zona privada de la plataforma
	 */
	public function logout()
	{
        $this->session->unset_userdata('FILTROS_EMPLEADOS');
        $this->session->unset_userdata('FILTROS_PRIVADO');

        $this->session->unset_userdata('administrador');
		header("Location:" . site_url(RUTA_ADMINISTRACION . '/administrador/login'));
		exit;
	}
}
