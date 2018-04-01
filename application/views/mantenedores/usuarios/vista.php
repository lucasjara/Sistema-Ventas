<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 31-03-2018
 * Time: 20:59
 */
?>
<br>
<div class="panel panel-primary">
    <div class="panel-heading">Listado de Usuarios</div>
    <div class="panel-body">
        <table id="tabla_usuarios" class="table table-responsive table-bordered table-striped"">
        <thead>
        <tr>
            <th>ID</th>
            <th>USUARIO</th>
            <th>NOMBRES</th>
            <th>ESTADO</th>
            <th>PERFIL</th>
            <th>ACCIONES</th>
        </tr>
        </thead>
        </table>
    </div>
</div>
<!-- INICIO MODAL EDITAR-->
<div class="modal fade" id="modal_editar" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Editar Usuario</h4>
            </div>
            <div class="modal-body">
                <div id="modal_alerta_editar"></div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="usuario">Usuario:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" disabled id="edit_usuario" name="usuario" value="">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="nombres">Nombre:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="edit_nombre" name="nombre" value="">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="apellidos">Estado:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" disabled id="edit_estado" name="estado" value="">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="fecha_nacimiento">Perfil:</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="edit_perfil" name="perfil" value="">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <input type="hidden" name="id_edit" id="id_modificar">
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="submit"  id="btn_editar_modal" class="btn btn-primary">Editar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- TERMINO MODAL EDITAR-->
<script src="<?php echo base_url('/public/js/mantenedores/usuarios/script.js')?>"></script>
