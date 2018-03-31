<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 14-01-2018
 * Time: 14:55
 */

class Alumnos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->layout->setLayout("plantilla");
        $this->load->library('form_validation');
    }

    function index(){
        $this->load->model('mantenedores/alumnos_model','alumnos_model');
        $this->layout->view('vista');
    }
    function obtener_datos(){
        $this->load->helper('array_utf8');
        $this->load->model('mantenedores/alumnos_model','alumnos_model');
        $data=  $this->alumnos_model->obtener_datos();
        for ($i=0;$i<count($data);$i++){
            $data[$i]->ACCIONES ='<button type="submit" data-id="' . $data[$i]->ID . '" data-rut="' . $data[$i]->RUT . '" data-nombres="' . $data[$i]->NOMBRES . '" data-apellidos="' . $data[$i]->APELLIDOS . '" data-fecha-nacimiento="' . $data[$i]->FECHA_NACIMIENTO . '" data-domicilio="' . $data[$i]->DOMICILIO . '" data-numero="' . $data[$i]->NUMERO . '" class="btn btn-success btn-xs btn_editar" title="Editar"><span class="glyphicon glyphicon-pencil" aria-hidden="true"> EDITAR </span></button>
                                  <button type="submit" data-id="' . $data[$i]->ID . '" class="btn btn-danger btn-xs btn_eliminar" title="Eliminar"><span class="glyphicon glyphicon-trash" aria-hidden="true"> ELIMINAR </span></button>
                                  <form action="/codeigniter/registro/registro_alumnos" method="post"  style="margin-top: 2px;">
                                    <input type="hidden" name="id" value="' . $data[$i]->ID . '">
                                    <button type="submit"  class="btn btn-primary btn-xs btn_detalle" title="Detalle"><span class="glyphicon glyphicon-th-list"> DETALLE</span></button>
                                   </form>';
        }
        $datos["data"] =$data;
        $this->output->set_content_type('application/json')->set_output(json_encode(array_utf8_encode($datos)));
    }
    function editar_alumno(){
        $mensaje = new stdClass();
        $this->load->helper('array_utf8');
        if ($this->input->post()) {
            $this->form_validation->set_rules("id", "id", "required|is_numeric");
            $this->form_validation->set_rules("nombres", "id", "required|min_length[3]");
            $this->form_validation->set_rules("fecha_nacimiento", "id", "required|exact_length[10]");
            $this->form_validation->set_rules("domicilio", "id", "required|min_length[10]");
            $this->form_validation->set_rules("numero", "id", "required|min_length[8]");
            if ($this->form_validation->run() != false) {
                $id = $this->input->post('id');
                $nombres = $this->input->post('nombres');
                $fecha_nacimiento = $this->input->post('fecha_nacimiento');
                $domicilio = $this->input->post('domicilio');
                $numero = $this->input->post('numero');
                $this->load->model('mantenedores/alumnos_model','alumnos_model');
                $this->alumnos_model->editar_alumno($id,$nombres,$fecha_nacimiento,$domicilio,$numero);
                $mensaje->respuesta = "S";
                $mensaje->data = "Usuario Modificado Correctamente";
            }else{
                $mensaje->respuesta = "N";
                $mensaje->data = validation_errors();
            }
        }else{
            $mensaje->respuesta = "N";
            $mensaje->data = 'No se pudo procesar la solicitud. Intente recargar la pagina.';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array_utf8_encode($mensaje)));
    }
    function eliminar_alumno(){
        $mensaje = new stdClass();
        $this->load->helper('array_utf8');
        if ($this->input->post()) {
            $this->form_validation->set_rules("id", "id", "required|is_numeric");
            if ($this->form_validation->run() != false) {
                $id = $this->input->post('id');
                $this->load->model('mantenedores/alumnos_model','alumnos_model');
                $this->alumnos_model->eliminar_alumno($id);
                $this->alumnos_model->eliminar_antecedentes($id);
                $this->alumnos_model->eliminar_antecedentes_familiares($id);
                $this->alumnos_model->eliminar_apoderados($id);
                $this->alumnos_model->eliminar_familiares($id);
                $this->alumnos_model->eliminar_jefe_hogar($id);
                $this->alumnos_model->eliminar_matricula($id);
                $mensaje->respuesta = "S";
                $mensaje->data = "Registro Eliminado Correctamente";
            }else{
                $mensaje->respuesta = "N";
                $mensaje->data = validation_errors();
            }
        }else{
            $mensaje->respuesta = "N";
            $mensaje->data = 'No se pudo procesar la solicitud. Intente recargar la pagina.';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array_utf8_encode($mensaje)));
    }
}