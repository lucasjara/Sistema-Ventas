<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 14-01-2018
 * Time: 14:55
 */

class usuarios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->layout->setLayout("plantilla");
        $this->load->library('form_validation');
    }

    function index()
    {
        $this->load->model('mantenedores/usuarios_model', 'usuarios_model');
        $this->load->model('mantenedores/perfiles_model', 'perfiles_model');
        $data["perfiles"] = $this->perfiles_model->obtener_perfiles();
        $this->layout->view('vista', $data);
    }

    function obtener_datos()
    {
        $this->load->helper('array_utf8');
        $this->load->model('mantenedores/usuarios_model', 'usuarios_model');
        $data = $this->usuarios_model->obtener_usuarios();
        for ($i = 0; $i < count($data); $i++) {
            $str = '<button type="submit" data-id="' . $data[$i]->id . '" data-usuario="' . $data[$i]->usuario . '" data-nombres="' . $data[$i]->nombre . '" data-estado="' . $data[$i]->estado . '" data-perfil="' . $data[$i]->perfil . '" data-perfil-d="' . $data[$i]->perfil_d . '" class="btn btn-primary btn-xs btn_editar" title="Editar"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>';
            if ($data[$i]->estado == 'ACTIVO') {
                $str .= ' <button type="submit" data-id="' . $data[$i]->id . '" data-estado="' . $data[$i]->estado . '" class="btn btn-success btn-xs btn_estado" title="Cambiar Estado"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></button>';
                $data[$i]->estado = '<button type="button" class="btn btn-success">'.$data[$i]->estado.'</button>';
            } else {
                $str .= ' <button type="submit" data-id="' . $data[$i]->id . '" data-estado="' . $data[$i]->estado . '" class="btn btn-danger btn-xs btn_estado" title="Cambiar Estado"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></button>';
                $data[$i]->estado = '<button type="button" class="btn btn-danger">'.$data[$i]->estado.'</button>';
            }
            $data[$i]->acciones = $str;

        }
        $datos["data"] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode(array_utf8_encode($datos)));
    }
    function agregar_usuario()
    {
        $mensaje = new stdClass();
        $this->load->helper('array_utf8');
        if ($this->input->post()) {
            $this->form_validation->set_rules("usuario", "Usuario", "required|min_length[5]");
            $this->form_validation->set_rules("password", "contraseña", "required|min_length[5]");
            $this->form_validation->set_rules("nombres", "Nombres", "required|min_length[5]");
            $this->form_validation->set_rules("perfil", "Perfil", "required|is_numeric|exact_length[1]");
            if ($this->form_validation->run() != false) {
                $this->load->model('mantenedores/usuarios_model', 'usuarios_model');
                $usuario = $this->input->post('usuario');
                $password = $this->input->post('password');
                $nombres = $this->input->post('nombres');
                $perfil = $this->input->post('perfil');
                $this->usuarios_model->ingresar_usuario($usuario,$password,$nombres,$perfil);
                $mensaje->respuesta = "S";
                $mensaje->data = "Usuario Modificado Correctamente";
            } else {
                $mensaje->respuesta = "N";
                $mensaje->data = validation_errors();
            }
        } else {
            $mensaje->respuesta = "N";
            $mensaje->data = 'No se pudo procesar la solicitud. Intente recargar la pagina.';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array_utf8_encode($mensaje)));
    }
    function editar_usuario()
    {
        $mensaje = new stdClass();
        $this->load->helper('array_utf8');
        if ($this->input->post()) {
            $this->form_validation->set_rules("id", "id", "required|is_numeric");
            $this->form_validation->set_rules("usuario", "id", "required|min_length[5]");
            $this->form_validation->set_rules("nombres", "id", "required|min_length[5]");
            $this->form_validation->set_rules("perfil", "id", "required|is_numeric|exact_length[1]");
            if ($this->form_validation->run() != false) {
                $this->load->model('mantenedores/usuarios_model', 'usuarios_model');
                $id = $this->input->post('id');
                $usuario = $this->input->post('usuario');
                $nombres = $this->input->post('nombres');
                $perfil = $this->input->post('perfil');
                $this->usuarios_model->editar_usuario($id, $usuario, $nombres, $perfil);
                $mensaje->respuesta = "S";
                $mensaje->data = "Usuario Modificado Correctamente";
            } else {
                $mensaje->respuesta = "N";
                $mensaje->data = validation_errors();
            }
        } else {
            $mensaje->respuesta = "N";
            $mensaje->data = 'No se pudo procesar la solicitud. Intente recargar la pagina.';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array_utf8_encode($mensaje)));
    }

    function cambiar_estado_usuario()
    {
        $mensaje = new stdClass();
        $this->load->helper('array_utf8');
        if ($this->input->post()) {
            $this->form_validation->set_rules("id", "id", "required|is_numeric");
            $this->form_validation->set_rules("estado", "estado", "required|min_length[1]");
            if ($this->form_validation->run() != false) {
                $this->load->model('mantenedores/usuarios_model', 'usuarios_model');
                $id = $this->input->post('id');
                $perfil = $this->input->post('estado');
                if ($perfil == 'ACTIVO') {
                    $this->usuarios_model->cambia_estado_usuario($id, 'N');
                    $mensaje->respuesta = "S";
                } elseif ($perfil == 'INACTIVO') {
                    $this->usuarios_model->cambia_estado_usuario($id, 'S');
                    $mensaje->respuesta = "S";
                } else {
                    $mensaje->respuesta = "N";
                    $mensaje->data = "Error formato estado";
                }
            } else {
                $mensaje->respuesta = "N";
                $mensaje->data = validation_errors();
            }
        } else {
            $mensaje->respuesta = "N";
            $mensaje->data = 'No se pudo procesar la solicitud. Intente recargar la pagina.';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array_utf8_encode($mensaje)));
    }
}