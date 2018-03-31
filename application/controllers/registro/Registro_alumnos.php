<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 17-01-2018
 * Time: 10:13
 */

class Registro_alumnos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->layout->setLayout("plantilla");
        $this->load->library('form_validation');
    }
    function index(){
        $datos["boton"] = 1;
        $this->load->model('registro/registro_model','registro_model');
        // todo --> Carga de Datos Alumno Ya registrado
        $id = $this->input->post('id');
        if($id != null && $id != ''){
            $datos["alumno"] = $this->registro_model->obtener_datos_alumno($id);
            $datos["matricula"] = $this->registro_model->obtener_datos_matricula($id);
            $datos["antecedente"] = $this->registro_model->obtener_datos_antecedentes($id);
            $datos["padre"] = $this->registro_model->obtener_datos_padre($id);
            $datos["madre"] = $this->registro_model->obtener_datos_madre($id);
            $datos["familia"] = $this->registro_model->obtener_datos_antecedentes_familiares($id);
            $datos["jefe_hogar"] = $this->registro_model->obtener_datos_jefe_hogar($id);
            $datos["apoderado"] = $this->registro_model->obtener_datos_apoderado($id);
            $datos["boton"] = 2;
            $datos["id"] = $id;
        }
        // Carga de Select
        $datos["comuna"] =$this->registro_model->obtener_comunas();
        $datos["curso"] =$this->registro_model->obtener_curso();
        $datos["establecimiento"] =$this->registro_model->obtener_establecimiento();
        $datos["tipo_establecimiento"] =$this->registro_model->obtener_tipo_establecimiento();
        $datos["especialidad"] =$this->registro_model->obtener_especialidad();
        $datos["ascendencia"] =$this->registro_model->obtener_ascendencia();
        $datos["viaja"] =$this->registro_model->obtener_viaja();
        $datos["sector_vive"] =$this->registro_model->obtener_sector_vive();
        $datos["nivel_educacional"] =$this->registro_model->obtener_nivel_educacional();
        $datos["religion"] =$this->registro_model->obtener_religion();
        $datos["prevision"] =$this->registro_model->obtener_prevision();
        $datos["salud"] =$this->registro_model->obtener_salud();
        $datos["vinculo_alumno"] =$this->registro_model->obtener_vinculo_alumno();
        $datos["tipo_apoderado"] =$this->registro_model->obtener_tipo_apoderado();
        $this->layout->view('vista',$datos);
    }
    function guardar_datos_alumno(){
        $mensaje = new stdClass();
        $this->load->helper('array_utf8');
        if ($this->input->post()) {
            if ($this->validar_datos_alumno() && $this->validar_datos_padre() && $this->validar_datos_madre() && $this->validar_datos_familia() && $this->validar_datos_jefe_hogar()  && $this->validar_datos_apoderado()) {
                $arreglo_alumno = array(
                    'nombres' => $this->input->post('nombres'),
                    'apellido_pat' => $this->input->post('apellido_pat'),
                    'apellido_mat' => $this->input->post('apellido_mat'),
                    'rut' => $this->input->post('rut'),
                    'fecha_nacimiento' => $this->input->post('fecha_nacimiento'),
                    'domicilio' => $this->input->post('domicilio'),
                    'numero' => $this->input->post('numero')
                );

                $arreglo_matricula_alumno = array(
                    'TB_CURSO_ID' => $this->input->post('curso'),
                    // todo -> CAMPO OBTENIDO EN TRANSACCIÓN
                    'TB_ALUMNO_ID' => '',
                    'TB_ESPECIALIDAD_ID' => $this->input->post('especialidad'),
                    'TB_ESTABLECIMIENTO_ID' => $this->input->post('establecimiento'),
                    'ANIO' => (int)date('Y'),
                    'F_MATRICULA' => $this->input->post('fecha_matricula')
                );

                // TODO --> Analizar Check
                $repite_curso=$this->input->post('repite_curso');
                if ($repite_curso == "true"){
                    $repite_curso = 'S';
                    $cual =$this->input->post('cual');
                }else{
                    $repite_curso = 'N';
                    $cual ='';
                }
                $certificado_uno=$this->input->post('certificado_uno');
                if ($certificado_uno === "true"){$certificado_uno = 'S';}else{$certificado_uno = 'N';}
                $certificado_dos=$this->input->post('certificado_dos');
                if ($certificado_dos === "true"){$certificado_dos = 'S';}else{$certificado_dos = 'N';}
                $certificado_tres=$this->input->post('certificado_tres');
                if ($certificado_tres === "true"){$certificado_tres = 'S';}else{$certificado_tres = 'N';}
                $certificado_cuatro=$this->input->post('certificado_cuatro');
                if ($certificado_cuatro === "true"){$certificado_cuatro = 'S';}else{$certificado_cuatro = 'N';}
                $certificado_cinco=$this->input->post('certificado_cinco');
                if ($certificado_cinco === "true"){$certificado_cinco = 'S';}else{$certificado_cinco = 'N';}
                // TODO --> Fin Analizar Check
                $arreglo_antecedentes_alumno = array(
                    'VILLA' => strtoupper($this->input->post('poblacion')),
                    'REPITE_CURSO' => $repite_curso,
                    'CUAL' => strtoupper($cual),
                    'OTROS' => strtoupper($this->input->post('otros')),
                    'CERTIFICADO_UNO' => $certificado_uno,
                    'CERTIFICADO_DOS' => $certificado_dos,
                    'CERTIFICADO_TRES' => $certificado_tres,
                    'CERTIFICADO_CUATRO' => $certificado_cuatro,
                    'CERTIFICADO_CINCO' => $certificado_cinco,
                    'TB_VIAJA_ID' => $this->input->post('viaja'),
                    'TB_SECTOR_VIVE_ID' => $this->input->post('sector_vive'),
                    'TB_ASCENDENCIA_ID' => $this->input->post('ascendencia'),
                    'TB_RELIGION_ID' => $this->input->post('religion'),
                    'TB_PREVISION_ID' => $this->input->post('prevision'),
                    'TB_SALUD_ID' => $this->input->post('salud'),
                    'TB_COMUNA_ID' => $this->input->post('comuna'),
                    // todo -> CAMPO OBTENIDO EN TRANSACCIÓN
                    'TB_ALUMNO_ID' => ''
                );

                // todo --> Formato Rut BD
                $rut_padre = $this->input->post("rut_padre");
                $rut_padre = str_replace('.','',$rut_padre);
                $rut_padre = str_replace('-','',$rut_padre);
                $rut_padre_dv = substr($rut_padre,-1);
                $rut_padre = substr($rut_padre, 0, -1);

                $arreglo_padre = array(
                    'RUT' => $rut_padre,
                    'DV' => $rut_padre_dv,
                    'NOMBRES' => $this->input->post("nombres_padre"),
                    'APELLIDO_PAT' => $this->input->post("apellido_pat_padre"),
                    'APELLIDO_MAT' => $this->input->post("apellido_mat_padre"),
                    'FECHA_NACIMIENTO' => $this->input->post("fecha_nacimiento_padre"),
                    'TELEFONO' => $this->input->post("numero_padre"),
                    'OCUPACION' => $this->input->post("ocupacion_padre"),
                    'DOMICILIO' => $this->input->post("domicilio_padre"),
                    // todo -> CAMPO OBTENIDO EN TRANSACCIÓN
                    'TB_ALUMNO_ID' => '',
                    'TB_NIVEL_EDUCACIONAL_ID' => $this->input->post("nivel_educacional_padre"),
                    'TB_VINCULO_ALUMNO_ID' => 2,
                    'INGRESO' => $this->input->post("ingreso_padre")
                );
                // todo --> Formato Rut BD
                $rut_madre = $this->input->post("rut_madre");
                $rut_madre = str_replace('.','',$rut_madre);
                $rut_madre = str_replace('-','',$rut_madre);
                $rut_madre_dv = substr($rut_madre,-1);
                $rut_madre = substr($rut_madre, 0, -1);

                $arreglo_madre = array(
                    'RUT' => $rut_madre,
                    'DV' => $rut_madre_dv,
                    'NOMBRES' => $this->input->post("nombres_madre"),
                    'APELLIDO_PAT' => $this->input->post("apellido_pat_madre"),
                    'APELLIDO_MAT' => $this->input->post("apellido_mat_madre"),
                    'FECHA_NACIMIENTO' => $this->input->post("fecha_nacimiento_madre"),
                    'TELEFONO' => $this->input->post("numero_madre"),
                    'OCUPACION' => $this->input->post("ocupacion_madre"),
                    'DOMICILIO' => $this->input->post("domicilio_madre"),
                    // todo -> CAMPO OBTENIDO EN TRANSACCIÓN
                    'TB_ALUMNO_ID' => '',
                    'TB_NIVEL_EDUCACIONAL_ID' => $this->input->post("nivel_educacional_madre"),
                    'TB_VINCULO_ALUMNO_ID' => 1,
                    'INGRESO' => $this->input->post("ingreso_madre")
                );

                if ($this->input->post("h_estudiando") == "true"){
                    $h_estudiando ='S';
                }else{
                    $h_estudiando = 'N';
                }

                $arreglo_antecedentes_familiares = array(
                    'N_INTEGRANTES' => $this->input->post("integrantes"),
                    'N_HERMANOS' => $this->input->post("n_hermanos"),
                    'H_ESTUDIANDO' => $h_estudiando,
                    'EDUC_BASICA' => $this->input->post("educ_basica"),
                    'EDUC_MEDIA' => $this->input->post("educ_media"),
                    'EDUC_UNI' => $this->input->post("educ_uni"),
                    'N_ABUELOS' => $this->input->post("abuelos"),
                    'N_TIOS' => $this->input->post("tios"),
                    // todo -> CAMPO OBTENIDO EN TRANSACCIÓN
                    'TB_ALUMNO_ID' => ''
                );

                $rut_jefe_hogar = $this->input->post("rut_jefe_hogar");
                $rut_jefe_hogar = str_replace('.','',$rut_jefe_hogar);
                $rut_jefe_hogar = str_replace('-','',$rut_jefe_hogar);
                $rut_jefe_hogar_dv = substr($rut_jefe_hogar,-1);
                $rut_jefe_hogar = substr($rut_jefe_hogar, 0, -1);

                $arreglo_jefe_hogar = array(
                    'RUT' => $rut_jefe_hogar,
                    'DV' => $rut_jefe_hogar_dv,
                    'TB_VINCULO_ALUMNO_ID' => $this->input->post("jefe_hogar"),
                    // todo -> CAMPO OBTENIDO EN TRANSACCIÓN
                    'TB_ALUMNO_ID' => ''
                );

                $rut_apoderado = $this->input->post("rut_apoderado");
                $rut_apoderado = str_replace('.','',$rut_apoderado);
                $rut_apoderado = str_replace('-','',$rut_apoderado);
                $rut_apoderado_dv = substr($rut_apoderado,-1);
                $rut_apoderado = substr($rut_apoderado, 0, -1);

                $arreglo_apoderado = array(
                    'RUT' => $rut_apoderado,
                    'DV' => $rut_apoderado_dv,
                    'NOMBRES' =>  strtoupper($this->input->post("nombre_apoderado")),
                    'APELLIDO_PAT' =>  strtoupper($this->input->post("apellido_pat_apoderado")),
                    'APELLIDO_MAT' =>  strtoupper($this->input->post("apellido_mat_apoderado")),
                    'NUMERO' =>  strtoupper($this->input->post("numero_apoderado")),
                    'TB_VINCULO_ALUMNO_ID' => $this->input->post("vinculo_alumno"),
                    'TB_TIPO_APODERADO_ID' => $this->input->post("tipo_apoderado"),
                    // todo -> CAMPO OBTENIDO EN TRANSACCIÓN
                    'TB_ALUMNO_ID' => ''
                );

                $this->load->model('registro/registro_model','registro_model');
                $registro = $this->registro_model->transaccion_registrar_alumno($arreglo_alumno,$arreglo_matricula_alumno,$arreglo_antecedentes_alumno,$arreglo_padre,$arreglo_madre,$arreglo_antecedentes_familiares,$arreglo_jefe_hogar,$arreglo_apoderado);
                if($registro == true){
                    $mensaje->respuesta = "S";
                    $mensaje->data = "Informacion Registrada Correctamente";
                }else{
                    $mensaje->respuesta = "N";
                    $mensaje->data = "Error en la Transaccion";
                }

            }else {
                $mensaje->respuesta = "N";
                $mensaje->data = validation_errors();
            }
        }else{
            $mensaje->respuesta = "N";
            $mensaje->data = 'No se pudo procesar la solicitud. Intente recargar la pagina.';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array_utf8_encode($mensaje)));
    }
    function validar_datos_alumno()
    {
        $this->form_validation->set_rules("nombres", "Nombres Alumno", "required|min_length[3]");
        $this->form_validation->set_rules("apellido_pat", "Apellido Paterno Alumno", "required|min_length[3]|max_length[200]");
        $this->form_validation->set_rules("apellido_mat", "Apellido Materno Alumno", "required|min_length[3]|max_length[200]");
        $this->form_validation->set_rules("rut", "Rut Alumno", "required|min_length[11]|max_length[12]");
        $this->form_validation->set_rules("fecha_nacimiento", "Fecha Nacimiento Alumno", "required|exact_length[10]");
        $this->form_validation->set_rules("domicilio", "Direccion Alumno", "required|min_length[3]|max_length[200]");
        //$this->form_validation->set_rules("numero", "Telefono Alumno", "required|min_length[3]|max_length[200]");
        $this->form_validation->set_rules("curso", "Curso Alumno", "required|is_numeric");
        $this->form_validation->set_rules("fecha_matricula", "Fecha Matricula Alumno", "required|exact_length[10]");
        $this->form_validation->set_rules("poblacion", "Poblacion Alumno", "required|min_length[3]|max_length[200]");
        $this->form_validation->set_rules("comuna", "Comuna Alumno", "required|is_numeric");
        $this->form_validation->set_rules("establecimiento", "Establecimiento Alumno", "required|is_numeric");
        if($this->input->post('cual') != "" || $this->input->post('cual') != null){
            $this->form_validation->set_rules("cual", "Cual", "required|min_length[2]|max_length[200]");
        }
        if($this->input->post('donde_vive') != "" || $this->input->post('donde_vive') != null){
            $this->form_validation->set_rules("donde_vive", "Donde Vive", "required|min_length[2]|max_length[200]");
        }
        if($this->input->post('otros') != "" || $this->input->post('otros') != null){
            $this->form_validation->set_rules("otros", "Otros", "required|min_length[2]|max_length[200]");
        }
        $this->form_validation->set_rules("especialidad", "Especialidad Alumno", "required|is_numeric");
        $this->form_validation->set_rules("sector_vive", "Sector Vive Alumno", "required|is_numeric");
        //$this->form_validation->set_rules("ascendencia", "Ascendencia Alumno", "required|is_numeric");
        $this->form_validation->set_rules("viaja", "Viaja Alumno", "required|is_numeric");
        return $this->form_validation->run();
    }
    function validar_datos_padre(){
        if ($this->input->post('nombres_padre') != ''){
            $this->form_validation->set_rules("nombres_padre", "Nombres Padre", "required|min_length[3]|max_length[200]");
            $this->form_validation->set_rules("apellido_pat_padre", "Apellido Paterno Padre", "required|min_length[3]|max_length[200]");
            $this->form_validation->set_rules("apellido_mat_padre", "Apellido Materno Padre", "required|min_length[3]|max_length[200]");
            $this->form_validation->set_rules("nivel_educacional_padre", "Nivel Educacional Padre", "required|is_numeric");
            $this->form_validation->set_rules("rut_padre", "Rut Padre", "required|min_length[3]|max_length[20]");
            $this->form_validation->set_rules("fecha_nacimiento_padre", "Fecha Nacimiento Padre", "required|exact_length[10]");
            $this->form_validation->set_rules("domicilio_padre", "Direccion Padre", "required|min_length[3]|max_length[200]");
            $this->form_validation->set_rules("ingreso_padre", "Ingreso Padre", "required|is_numeric|max_length[20]");
        }else{
            return true;
        }

        return $this->form_validation->run();
    }
    function validar_datos_madre(){
        if ($this->input->post('nombres_madre') != '') {
            $this->form_validation->set_rules("nombres_madre", "Nombres Madre", "required|min_length[3]|max_length[200]");
            $this->form_validation->set_rules("apellido_pat_madre", "Apellido Paterno Madre", "required|min_length[3]|max_length[200]");
            $this->form_validation->set_rules("apellido_mat_madre", "Apellido Materno Madre", "required|min_length[3]|max_length[200]");
            $this->form_validation->set_rules("nivel_educacional_madre", "Nivel Educacional Madre", "required|is_numeric");
            $this->form_validation->set_rules("rut_madre", "Rut Madre", "required|min_length[3]|max_length[20]");
            $this->form_validation->set_rules("fecha_nacimiento_madre", "Fecha Nacimiento Madre", "required|exact_length[10]");
            $this->form_validation->set_rules("domicilio_madre", "Direccion Madre", "required|min_length[3]|max_length[200]");
            $this->form_validation->set_rules("ingreso_madre", "Ingreso Madre", "required|is_numeric|max_length[20]");
        }else{
            return true;
        }
        return $this->form_validation->run();
    }
    function validar_datos_familia(){
        $this->form_validation->set_rules("integrantes", "Cantidad en Integrantes", "required|is_numeric");
        $this->form_validation->set_rules("n_hermanos", "Cantidad en Numero de Hermanos", "required|is_numeric");
        $this->form_validation->set_rules("educ_basica", "Cantidad en Educacion Basica", "required|is_numeric");
        $this->form_validation->set_rules("educ_media", "Cantidad en Educacion Media", "required|is_numeric");
        $this->form_validation->set_rules("educ_uni", "Cantidad en Educacion Universitaria", "required|is_numeric");
        $this->form_validation->set_rules("abuelos", "Cantidad de Abuelos", "required|is_numeric");
        $this->form_validation->set_rules("tios", "Cantidad de Tios", "required|is_numeric");
        return $this->form_validation->run();
    }
    function validar_datos_jefe_hogar(){
        if ($this->input->post('rut_jefe_hogar')){
            $this->form_validation->set_rules("jefe_hogar", "Jefe Hogar", "required|is_numeric");
            $this->form_validation->set_rules("rut_jefe_hogar", "Rut Jefe Hogar", "required|min_length[3]|max_length[20]");
            $this->form_validation->set_rules("religion", "Religion", "required|is_numeric");
            $this->form_validation->set_rules("prevision", "Prevision", "required|is_numeric");
            $this->form_validation->set_rules("salud", "Salud", "required|is_numeric");
        }else{
            return true;
        }
        return $this->form_validation->run();
    }
    function validar_datos_apoderado(){
        $this->form_validation->set_rules("rut_apoderado", "Rut Apoderado", "required|min_length[3]|max_length[20]");
        $this->form_validation->set_rules("nombre_apoderado", "Nombres Apoderado", "required|min_length[3]|max_length[200]");
        $this->form_validation->set_rules("apellido_pat_apoderado", "Apellido Paterno Apoderado", "required|min_length[3]|max_length[200]");
        $this->form_validation->set_rules("apellido_mat_apoderado", "Apellido Materno Apoderado", "required|min_length[3]|max_length[200]");
        $this->form_validation->set_rules("numero_apoderado", "Telefono Apoderado", "required|min_length[3]|max_length[50]");
        $this->form_validation->set_rules("vinculo_alumno", "Religion", "required|is_numeric");
        $this->form_validation->set_rules("tipo_apoderado", "Prevision", "required|is_numeric");
        return $this->form_validation->run();
    }
    function buscar_tipo_establecimiento(){
        $mensaje = new stdClass();
        $this->load->helper('array_utf8');
        if ($this->input->post() && $this->input->post('establecimiento') != ''){
            $this->load->model('registro/registro_model','registro_model');
            $id_establecimiento = $this->input->post('establecimiento');
            $respuesta = $this->registro_model->buscar_tipo_establecimiento($id_establecimiento);
            $mensaje->respuesta = "S";
            $mensaje->data = $respuesta;
        }else{
            $mensaje->respuesta = "N";
            $mensaje->data = 'No se pudo procesar la solicitud. Intente recargar la pagina.';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array_utf8_encode($mensaje)));
    }
    function editar_registro_alumno(){
        $mensaje = new stdClass();
        $this->load->helper('array_utf8');
        if ($this->input->post()) {
            if ($this->validar_datos_alumno() && $this->validar_datos_padre() && $this->validar_datos_madre() && $this->validar_datos_familia() && $this->validar_datos_jefe_hogar()  && $this->validar_datos_apoderado()) {
                $id_alumno = $this->input->post('id_alumno');
                $arreglo_alumno = array(
                    'nombres' => $this->input->post('nombres'),
                    'apellido_pat' => $this->input->post('apellido_pat'),
                    'apellido_mat' => $this->input->post('apellido_mat'),
                    'rut' => $this->input->post('rut'),
                    'fecha_nacimiento' => $this->input->post('fecha_nacimiento'),
                    'domicilio' => $this->input->post('domicilio'),
                    'numero' => $this->input->post('numero')
                );

                $arreglo_matricula_alumno = array(
                    'TB_CURSO_ID' => $this->input->post('curso'),
                    // todo -> CAMPO OBTENIDO EN TRANSACCIÓN
                    'TB_ALUMNO_ID' => '',
                    'TB_ESPECIALIDAD_ID' => $this->input->post('especialidad'),
                    'TB_ESTABLECIMIENTO_ID' => $this->input->post('establecimiento'),
                    'ANIO' => (int)date('Y'),
                    'F_MATRICULA' => $this->input->post('fecha_matricula')
                );

                // TODO --> Analizar Check
                $repite_curso=$this->input->post('repite_curso');
                if ($repite_curso == "true"){
                    $repite_curso = 'S';
                    $cual =$this->input->post('cual');
                }else{
                    $repite_curso = 'N';
                    $cual ='';
                }
                $certificado_uno=$this->input->post('certificado_uno');
                if ($certificado_uno === "true"){$certificado_uno = 'S';}else{$certificado_uno = 'N';}
                $certificado_dos=$this->input->post('certificado_dos');
                if ($certificado_dos === "true"){$certificado_dos = 'S';}else{$certificado_dos = 'N';}
                $certificado_tres=$this->input->post('certificado_tres');
                if ($certificado_tres === "true"){$certificado_tres = 'S';}else{$certificado_tres = 'N';}
                $certificado_cuatro=$this->input->post('certificado_cuatro');
                if ($certificado_cuatro === "true"){$certificado_cuatro = 'S';}else{$certificado_cuatro = 'N';}
                $certificado_cinco=$this->input->post('certificado_cinco');
                if ($certificado_cinco === "true"){$certificado_cinco = 'S';}else{$certificado_cinco = 'N';}
                // TODO --> Fin Analizar Check
                $arreglo_antecedentes_alumno = array(
                    'VILLA' => strtoupper($this->input->post('poblacion')),
                    'REPITE_CURSO' => $repite_curso,
                    'CUAL' => strtoupper($cual),
                    'OTROS' => strtoupper($this->input->post('otros')),
                    'CERTIFICADO_UNO' => $certificado_uno,
                    'CERTIFICADO_DOS' => $certificado_dos,
                    'CERTIFICADO_TRES' => $certificado_tres,
                    'CERTIFICADO_CUATRO' => $certificado_cuatro,
                    'CERTIFICADO_CINCO' => $certificado_cinco,
                    'TB_VIAJA_ID' => $this->input->post('viaja'),
                    'TB_SECTOR_VIVE_ID' => $this->input->post('sector_vive'),
                    'TB_ASCENDENCIA_ID' => $this->input->post('ascendencia'),
                    'TB_RELIGION_ID' => $this->input->post('religion'),
                    'TB_PREVISION_ID' => $this->input->post('prevision'),
                    'TB_SALUD_ID' => $this->input->post('salud'),
                    'TB_COMUNA_ID' => $this->input->post('comuna')
                );

                // todo --> Formato Rut BD
                $rut_padre = $this->input->post("rut_padre");
                $rut_padre = str_replace('.','',$rut_padre);
                $rut_padre = str_replace('-','',$rut_padre);
                $rut_padre_dv = substr($rut_padre,-1);
                $rut_padre = substr($rut_padre, 0, -1);

                $arreglo_padre = array(
                    'RUT' => $rut_padre,
                    'DV' => $rut_padre_dv,
                    'NOMBRES' => $this->input->post("nombres_padre"),
                    'APELLIDO_PAT' => $this->input->post("apellido_pat_padre"),
                    'APELLIDO_MAT' => $this->input->post("apellido_mat_padre"),
                    'FECHA_NACIMIENTO' => $this->input->post("fecha_nacimiento_padre"),
                    'TELEFONO' => $this->input->post("numero_padre"),
                    'OCUPACION' => $this->input->post("ocupacion_padre"),
                    'DOMICILIO' => $this->input->post("domicilio_padre"),
                    'TB_NIVEL_EDUCACIONAL_ID' => $this->input->post("nivel_educacional_padre"),
                    'TB_VINCULO_ALUMNO_ID' => 2,
                    'INGRESO' => $this->input->post("ingreso_padre")
                );
                // todo --> Formato Rut BD
                $rut_madre = $this->input->post("rut_madre");
                $rut_madre = str_replace('.','',$rut_madre);
                $rut_madre = str_replace('-','',$rut_madre);
                $rut_madre_dv = substr($rut_madre,-1);
                $rut_madre = substr($rut_madre, 0, -1);

                $arreglo_madre = array(
                    'RUT' => $rut_madre,
                    'DV' => $rut_madre_dv,
                    'NOMBRES' => $this->input->post("nombres_madre"),
                    'APELLIDO_PAT' => $this->input->post("apellido_pat_madre"),
                    'APELLIDO_MAT' => $this->input->post("apellido_mat_madre"),
                    'FECHA_NACIMIENTO' => $this->input->post("fecha_nacimiento_madre"),
                    'TELEFONO' => $this->input->post("numero_madre"),
                    'OCUPACION' => $this->input->post("ocupacion_madre"),
                    'DOMICILIO' => $this->input->post("domicilio_madre"),
                    'TB_NIVEL_EDUCACIONAL_ID' => $this->input->post("nivel_educacional_madre"),
                    'TB_VINCULO_ALUMNO_ID' => 1,
                    'INGRESO' => $this->input->post("ingreso_madre")
                );

                if ($this->input->post("h_estudiando") == "true"){
                    $h_estudiando ='S';
                }else{
                    $h_estudiando = 'N';
                }

                $arreglo_antecedentes_familiares = array(
                    'N_INTEGRANTES' => $this->input->post("integrantes"),
                    'N_HERMANOS' => $this->input->post("n_hermanos"),
                    'H_ESTUDIANDO' => $h_estudiando,
                    'EDUC_BASICA' => $this->input->post("educ_basica"),
                    'EDUC_MEDIA' => $this->input->post("educ_media"),
                    'EDUC_UNI' => $this->input->post("educ_uni"),
                    'N_ABUELOS' => $this->input->post("abuelos"),
                    'N_TIOS' => $this->input->post("tios")
                );

                $rut_jefe_hogar = $this->input->post("rut_jefe_hogar");
                $rut_jefe_hogar = str_replace('.','',$rut_jefe_hogar);
                $rut_jefe_hogar = str_replace('-','',$rut_jefe_hogar);
                $rut_jefe_hogar_dv = substr($rut_jefe_hogar,-1);
                $rut_jefe_hogar = substr($rut_jefe_hogar, 0, -1);

                $arreglo_jefe_hogar = array(
                    'RUT' => $rut_jefe_hogar,
                    'DV' => $rut_jefe_hogar_dv,
                    'TB_VINCULO_ALUMNO_ID' => $this->input->post("jefe_hogar")
                );

                $rut_apoderado = $this->input->post("rut_apoderado");
                $rut_apoderado = str_replace('.','',$rut_apoderado);
                $rut_apoderado = str_replace('-','',$rut_apoderado);
                $rut_apoderado_dv = substr($rut_apoderado,-1);
                $rut_apoderado = substr($rut_apoderado, 0, -1);

                $arreglo_apoderado = array(
                    'RUT' => $rut_apoderado,
                    'DV' => $rut_apoderado_dv,
                    'NOMBRES' =>  strtoupper($this->input->post("nombre_apoderado")),
                    'APELLIDO_PAT' =>  strtoupper($this->input->post("apellido_pat_apoderado")),
                    'APELLIDO_MAT' =>  strtoupper($this->input->post("apellido_mat_apoderado")),
                    'NUMERO' =>  strtoupper($this->input->post("numero_apoderado")),
                    'TB_VINCULO_ALUMNO_ID' => $this->input->post("vinculo_alumno"),
                    'TB_TIPO_APODERADO_ID' => $this->input->post("tipo_apoderado"),
                );

                $this->load->model('registro/registro_model','registro_model');
                $registro = $this->registro_model->transaccion_editar_alumno($id_alumno,$arreglo_alumno,$arreglo_matricula_alumno,$arreglo_antecedentes_alumno,$arreglo_padre,$arreglo_madre,$arreglo_antecedentes_familiares,$arreglo_jefe_hogar,$arreglo_apoderado);
                if($registro == true){
                    $mensaje->respuesta = "S";
                    $mensaje->data = "Informacion Editada Correctamente";
                }else{
                    $mensaje->respuesta = "N";
                    $mensaje->data = "Error en la Transaccion";
                }

            }else {
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