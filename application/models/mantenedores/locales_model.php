<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 31-03-2018
 */

class locales_model extends CI_Model
{
    function obtener_locales()
    {
        $this->db->select("*")
            ->from('locales');
        $query = $this->db->get();
        return $query->result();
    }

    function ingresar_local($descripcion)
    {
        $this->db->set('descripcion', $descripcion);
        $this->db->insert("locales");
        return $this->db->insert_id();
    }
    function editar_local($id, $descripcion)
    {
        $this->db->set('descripcion', $descripcion);
        $this->db->where('id', $id);
        return $this->db->update('locales');
    }
}