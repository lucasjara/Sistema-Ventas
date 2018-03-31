<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 31-03-2018
 */

class usuarios_model extends CI_Model
{
    function obtener_usuarios()
    {
        $this->db->select("*")
            ->from('usuarios');
        $query = $this->db->get();
        return $query->result();
    }

    function ingresar_usuario($usuario,$password,$nombre)
    {
        $this->db->set('usuario', $usuario);
        $this->db->set('password', $password);
        $this->db->set('nombre', $nombre);
        $this->db->set('estado', 'S');
        $this->db->insert("usuarios");
        return $this->db->insert_id();
    }
    function cambia_estado_usuario($id,$estado)
    {
        $this->db->set('estado', $estado);
        $this->db->where('ID', $id);
        return $this->db->update('usuarios');
    }
    function editar_usuario($id, $usuario,$password,$nombre,$estado)
    {
        $this->db->set('usuario', $usuario);
        $this->db->set('password', $password);
        $this->db->set('nombre', $nombre);
        $this->db->set('estado', $estado);
        $this->db->where('ID', $id);
        return $this->db->update('usuarios');
    }
}