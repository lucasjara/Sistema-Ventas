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
        $this->layout->view('vista');
    }

    function obtener_datos()
    {
        $this->load->helper('array_utf8');
        $this->load->model('mantenedores/usuarios_model', 'usuarios_model');
        $data = $this->usuarios_model->obtener_usuarios();
        //var_dump($data[0]->id);
        for($i = 0; $i < count($data); $i++) {
            $data[$i]->acciones = '<button type="submit" data-id="' . $data[$i]->id . '" data-usuario="' . $data[$i]->usuario . '" data-nombres="' . $data[$i]->nombre . '" data-estado="' . $data[$i]->estado . '" data-perfil="' . $data[$i]->perfil . '" class="btn btn-primary btn-xs btn_editar" title="Editar"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
                                  <button type="submit" data-id="' . $data[$i]->id . '" class="btn btn-danger btn-xs btn_estado" title="Cambiar Estado"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></button>';
        }
        $datos["data"] = $data;
        $this->output->set_content_type('application/json')->set_output(json_encode(array_utf8_encode($datos)));
    }

    function editar_usuario()
    {
        $mensaje = new stdClass();
        $this->load->helper('array_utf8');
        if ($this->input->post()) {
            $this->form_validation->set_rules("id", "id", "required|is_numeric");
            $this->form_validation->set_rules("nombres", "id", "required|min_length[3]");
            $this->form_validation->set_rules("fecha_nacimiento", "id", "required|min_length[10]");
            $this->form_validation->set_rules("domicilio", "id", "required|min_length[10]");
            $this->form_validation->set_rules("numero", "id", "required|min_length[8]");
            if ($this->form_validation->run() != false) {

                $id = $this->input->post('id');
                $nombres = $this->input->post('nombres');
                $fecha_nacimiento = $this->input->post('fecha_nacimiento');
                $domicilio = $this->input->post('domicilio');
                $numero = $this->input->post('numero');

                $this->usuarios_model->editar_usuario($id, $nombres, $fecha_nacimiento, $domicilio, $numero);
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
}