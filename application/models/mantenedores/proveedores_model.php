<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 31-03-2018
 */

class proveedores_model extends CI_Model
{
    function obtener_proveedores()
    {
        $this->db->select("*")
            ->from('proveedores');
        $query = $this->db->get();
        return $query->result();
    }

    function ingresar_proveedor($descripcion)
    {
        $this->db->set('descripcion', $descripcion);
        $this->db->insert("proveedores");
        return $this->db->insert_id();
    }
    function editar_proveedor($id, $descripcion)
    {
        $this->db->set('descripcion', $descripcion);
        $this->db->where('id', $id);
        return $this->db->update('proveedores');
    }
}