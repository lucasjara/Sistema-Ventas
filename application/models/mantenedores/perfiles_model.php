<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 31-03-2018
 */

class perfiles_model extends CI_Model
{
    function obtener_perfiles()
    {
        $this->db->select("*")
            ->from('perfiles');
        $query = $this->db->get();
        return $query->result();
    }

    function ingresar_perfil($descripcion)
    {
        $this->db->set('descripcion', $descripcion);
        $this->db->insert("perfiles");
        return $this->db->insert_id();
    }
    function editar_perfil($id, $descripcion)
    {
        $this->db->set('descripcion', $descripcion);
        $this->db->where('id', $id);
        return $this->db->update('perfiles');
    }
}