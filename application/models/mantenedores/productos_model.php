<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 31-03-2018
 */

class productos_model extends CI_Model
{
    function obtener_productos($id_local = false)
    {
        $this->db->select("*")
            ->from('productos');
        if ($id_local != false){
            $this->db->where("id",$id_local);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function ingresar_producto($cod_producto,$nombre,$descripcion,$id_local)
    {
        $this->db->set('cod_producto', $cod_producto);
        $this->db->set('nombre', $nombre);
        $this->db->set('descripcion', $descripcion);
        $this->db->set('id_local', $id_local);
        $this->db->set('estado', 'S');
        $this->db->insert("productos");
        return $this->db->insert_id();
    }
    function cambia_estado_producto($id,$estado)
    {
        $this->db->set('estado', $estado);
        $this->db->where('ID', $id);
        return $this->db->update('productos');
    }
    function editar_producto($id,$cod_producto,$nombre,$descripcion,$id_local,$estado)
    {
        $this->db->set('cod_producto', $cod_producto);
        $this->db->set('nombre', $nombre);
        $this->db->set('descripcion', $descripcion);
        $this->db->set('id_local', $id_local);
        $this->db->set('estado', $estado);
        $this->db->where('id', $id);
        return $this->db->update('productos');
    }
}