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
        $this->db->select("u.id, u.usuario, u.nombre,CASE WHEN u.estado = 'S' THEN 'Activo' ELSE 'Inactivo' END estado, u.id_perfil perfil,p.descripcion perfil_d",false)
            ->from('usuarios u')->join("perfiles p",'p.id=u.id_perfil','inner');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    function ingresar_usuario($usuario,$password,$nombre,$perfil)
    {
        $this->db->set('usuario', $usuario);
        $this->db->set('password', $password);
        $this->db->set('nombre', $nombre);
        $this->db->set('estado', 'S');
        $this->db->set('id_perfil', $perfil);
        $this->db->insert("usuarios");
        return $this->db->insert_id();
    }
    function cambia_estado_usuario($id,$estado)
    {
        $this->db->set('estado', $estado);
        $this->db->where('ID', $id);
        return $this->db->update('usuarios');
    }
    function editar_usuario($id, $usuario,$nombre,$perfil)
    {
        $this->db->set('usuario', $usuario);
        $this->db->set('nombre', $nombre);
        $this->db->set('id_perfil', $perfil);
        $this->db->where('ID', $id);
        return $this->db->update('usuarios');
    }
}