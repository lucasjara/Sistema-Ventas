<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 17-01-2018
 * Time: 11:08
 */

class registro_model extends CI_Model
{
    /**
     *  Metodo transaccion para que si falla uno no registre nada
     * @param $alumno                   Datos tabla tb_alumnos
     * @param $matricula_alumno         Datos tabla tb_matricula
     * @param $antecentes_alumno        Datos tabla tb_antecedentes
     * @param $familiares_padre         Datos tabla tb_familiares
     * @param $familiares_madre         Datos tabla tb_familiares
     * @param $antecentes_familiares    Datos tabla tb_antecedentes_familiares
     * @param $jefe_hogar               Datos tabla tb_jefe_hogar
     * @param $apoderado                Datos tabla tb_apoderado
     * @return stdClass
     */
    function transaccion_registrar_alumno($alumno, $matricula_alumno, $antecentes_alumno, $familiares_padre, $familiares_madre, $antecentes_familiares, $jefe_hogar, $apoderado)
    {
        $mensaje = new stdClass();
        $this->db->trans_begin();
        $id_alumno = $this->ingresar_alumno($alumno);

        $matricula_alumno["TB_ALUMNO_ID"] = $id_alumno;
        $this->ingresar_matricula_alumno($matricula_alumno);
        $antecentes_alumno["TB_ALUMNO_ID"] = $id_alumno;
        $this->ingresar_antecedentes_alumno($antecentes_alumno);
        $antecentes_familiares["TB_ALUMNO_ID"] = $id_alumno;
        $this->ingresar_antecedentes_familiares_alumno($antecentes_familiares);
        $apoderado["TB_ALUMNO_ID"] = $id_alumno;
        $this->ingresar_apoderado($apoderado);
        // todo --> Datos Opcionales Que pueden venir vacios
        $familiares_padre["TB_ALUMNO_ID"] = $id_alumno;
        $this->ingresar_datos_familiar_alumno($familiares_padre);
        $familiares_madre["TB_ALUMNO_ID"] = $id_alumno;
        $this->ingresar_datos_familiar_alumno($familiares_madre);
        $jefe_hogar["TB_ALUMNO_ID"] = $id_alumno;
        $this->ingresar_jefe_hogar($jefe_hogar);
        // todo --> ----------------------------------------
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $mensaje->respuesta = "N";
            $mensaje->data = " No se pudo procesar la transacci�n";
        } else {
            $this->db->trans_commit();
        }
        return $mensaje;
    }
    function transaccion_editar_alumno($id_alumno,$alumno, $matricula_alumno, $antecentes_alumno, $familiares_padre, $familiares_madre, $antecentes_familiares, $jefe_hogar, $apoderado){
        $mensaje = new stdClass();
        $this->db->trans_begin();
        // todo --> Tablas a Actualizar Informacion
        $this->actualizar_datos_alumno($id_alumno,$alumno);
        $this->actualizar_datos_matricula($id_alumno,$matricula_alumno);
        $this->actualizar_datos_antecedentes($id_alumno,$antecentes_alumno);
        $this->actualizar_datos_familiares_padre($id_alumno,$familiares_padre);
        $this->actualizar_datos_familiares_madre($id_alumno,$familiares_madre);
        $this->actualizar_datos_antecedentes_familiares($id_alumno,$antecentes_familiares);
        $this->actualizar_datos_jefe_hogar($id_alumno,$jefe_hogar);
        $this->actualizar_datos_apoderado($id_alumno,$apoderado);
        // todo --> ----------------------------------------
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $mensaje->respuesta = "N";
            $mensaje->data = " No se pudo procesar la transacci�n";
        } else {
            $this->db->trans_commit();
        }
        return $mensaje;
    }
    function actualizar_datos_alumno($id,$alumno){
        //todo |Formato Base de datos --> Rut|
        $alumno["rut"] = str_replace('.', '', $alumno["rut"]);
        $alumno["rut"] = str_replace('-', '', $alumno["rut"]);
        $alumno["dv"] = substr($alumno["rut"], -1);
        $alumno["rut"] = substr($alumno["rut"], 0, -1);
        $this->db->set('RUT', $alumno["rut"]);
        $this->db->set('DV', $alumno["dv"]);
        $this->db->set('NOMBRES', strtoupper($alumno["nombres"]));
        $this->db->set('APELLIDO_PAT', strtoupper($alumno["apellido_pat"]));
        $this->db->set('APELLIDO_MAT', strtoupper($alumno["apellido_mat"]));
        $this->db->set('FECHA_NACIMIENTO', $alumno["fecha_nacimiento"]);
        $this->db->set('DOMICILIO', strtoupper($alumno["domicilio"]));
        $this->db->set('NUMERO', strtoupper($alumno["numero"]));
        $this->db->set('VISIBLE', 'S');
        $this->db->where('ID', $id);
        return $this->db->update('tb_alumnos',$alumno);
    }
    function actualizar_datos_matricula($id,$matricula_alumno){
        $this->db->where('TB_ALUMNO_ID', $id);
        return $this->db->update('tb_matricula',$matricula_alumno);
    }
    function actualizar_datos_antecedentes($id,$antecedentes){
        $this->db->where('TB_ALUMNO_ID', $id);
        return $this->db->update('tb_antecedentes',$antecedentes);
    }
    function actualizar_datos_familiares_padre($id,$padre){
        $this->db->where('TB_ALUMNO_ID', $id);
        $this->db->where('TB_VINCULO_ALUMNO_ID', 2);
        return $this->db->update('tb_familiares',$padre);
    }
    function actualizar_datos_familiares_madre($id,$familiares){
        $this->db->where('TB_ALUMNO_ID', $id);
        $this->db->where('TB_VINCULO_ALUMNO_ID', 1);
        return $this->db->update('tb_familiares',$familiares);
    }
    function actualizar_datos_antecedentes_familiares($id,$antecedentes_familiares){
        $this->db->where('TB_ALUMNO_ID', $id);
        return $this->db->update('tb_antecedentes_familiares',$antecedentes_familiares);
    }
    function actualizar_datos_jefe_hogar($id,$jefe_hogar){
        $this->db->where('TB_ALUMNO_ID', $id);
        return $this->db->update('tb_jefe_hogar',$jefe_hogar);
    }
    function actualizar_datos_apoderado($id,$apoderado){
        $this->db->where('TB_ALUMNO_ID', $id);
        return $this->db->update('tb_apoderados',$apoderado);
    }
    function ingresar_alumno($alumno)
    {
        //todo |Formato Base de datos --> Rut|
        $alumno["rut"] = str_replace('.', '', $alumno["rut"]);
        $alumno["rut"] = str_replace('-', '', $alumno["rut"]);
        $alumno["dv"] = substr($alumno["rut"], -1);
        $alumno["rut"] = substr($alumno["rut"], 0, -1);
        $this->db->set('RUT', $alumno["rut"]);
        $this->db->set('DV', $alumno["dv"]);
        $this->db->set('NOMBRES', strtoupper($alumno["nombres"]));
        $this->db->set('APELLIDO_PAT', strtoupper($alumno["apellido_pat"]));
        $this->db->set('APELLIDO_MAT', strtoupper($alumno["apellido_mat"]));
        $this->db->set('FECHA_NACIMIENTO', $alumno["fecha_nacimiento"]);
        $this->db->set('DOMICILIO', strtoupper($alumno["domicilio"]));
        $this->db->set('NUMERO', strtoupper($alumno["numero"]));
        $this->db->set('VISIBLE', 'S');
        $this->db->insert("tb_alumnos");
        return $this->db->insert_id();
    }

    function ingresar_matricula_alumno($matricula_alumno)
    {
        $this->db->set('VISIBLE', 'S');
        $this->db->insert("tb_matricula", $matricula_alumno);
        return $this->db->insert_id();
    }

    function ingresar_antecedentes_alumno($antecentes_alumno)
    {
        $this->db->set('VISIBLE', 'S');
        $this->db->insert("tb_antecedentes", $antecentes_alumno);
        return $this->db->insert_id();
    }

    function ingresar_datos_familiar_alumno($datos)
    {
        $this->db->set('VISIBLE', 'S');
        $this->db->insert("tb_familiares", $datos);
        return $this->db->insert_id();
    }

    function ingresar_antecedentes_familiares_alumno($antecedentes_familiares)
    {
        $this->db->set('VISIBLE', 'S');
        $this->db->insert("tb_antecedentes_familiares", $antecedentes_familiares);
        return $this->db->insert_id();
    }

    function ingresar_jefe_hogar($datos_jefe_hogar)
    {
        $this->db->set('VISIBLE', 'S');
        $this->db->insert("tb_jefe_hogar", $datos_jefe_hogar);
        return $this->db->insert_id();
    }

    function ingresar_apoderado($datos_apoderado)
    {
        $this->db->set('VISIBLE', 'S');
        $this->db->insert("tb_apoderados", $datos_apoderado);
        return $this->db->insert_id();
    }

    function obtener_comunas()
    {
        $this->db->select("*")->from('tb_comuna');
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_curso()
    {
        $this->db->select("*")->from('tb_curso');
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_establecimiento()
    {
        $this->db->select("*")->from('tb_establecimiento')->order_by("DESCRIPCION");
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_tipo_establecimiento()
    {
        $this->db->select("*")->from('tb_tipo_establecimiento');
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_especialidad()
    {
        $this->db->select("*")->from('tb_especialidad');
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_ascendencia()
    {
        $this->db->select("*")->from('tb_ascendencia');
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_viaja()
    {
        $this->db->select("*")->from('tb_viaja');
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_sector_vive()
    {
        $this->db->select("*")->from('tb_sector_vive');
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_nivel_educacional()
    {
        $this->db->select("*")->from('tb_nivel_educacional');
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_religion()
    {
        $this->db->select("*")->from('tb_religion');
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_prevision()
    {
        $this->db->select("*")->from('tb_prevision');
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_salud()
    {
        $this->db->select("*")->from('tb_salud');
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_vinculo_alumno()
    {
        $this->db->select("*")->from('tb_vinculo_alumno');
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_tipo_apoderado()
    {
        $this->db->select("*")->from('tb_tipo_apoderado');
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_datos_alumno($id)
    {
        $this->db->select("*")->from('tb_alumnos')->where('ID', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_datos_antecedentes($id)
    {
        $this->db->select("*")->from('tb_antecedentes')->where('TB_ALUMNO_ID', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_datos_antecedentes_familiares($id)
    {
        $this->db->select("*")->from('tb_antecedentes_familiares')->where('TB_ALUMNO_ID', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_datos_apoderado($id)
    {
        $this->db->select("*")->from('tb_apoderados')->where('TB_ALUMNO_ID', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_datos_padre($id)
    {
        $this->db->select("*")->from('tb_familiares')->where('TB_ALUMNO_ID', $id)->where('TB_VINCULO_ALUMNO_ID', 2);
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_datos_madre($id)
    {
        $this->db->select("*")->from('tb_familiares')->where('TB_ALUMNO_ID', $id)->where('TB_VINCULO_ALUMNO_ID', 1);
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_datos_jefe_hogar($id)
    {
        $this->db->select("*")->from('tb_jefe_hogar')->where('TB_ALUMNO_ID', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_datos_matricula($id)
    {
        $this->db->select("*")->from('tb_matricula')->where('TB_ALUMNO_ID', $id);
        $query = $this->db->get();
        return $query->result();
    }
    function buscar_tipo_establecimiento($id_establecimiento){
        $this->db->select("tipo.ID, tipo.DESCRIPCION")->from('tb_establecimiento establecimiento')
            ->join("tb_tipo_establecimiento tipo","tipo.ID=establecimiento.TB_TIPO_ESTABLECIMIENTO_ID","INNER")
            ->where('establecimiento.ID', $id_establecimiento);
        $query = $this->db->get();
        return $query->result();
    }
}