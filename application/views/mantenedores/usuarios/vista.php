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
    <div class="panel-heading">
        <div class="panel-title pull-left">LISTADO DE USUARIOS</div>
        <div class="panel-title pull-right"><button type="submit" class="btn btn-success" title="Agregar" id="agregar_usuarios"><span class="glyphicon glyphicon-plus" ></span><b> AGREGAR USUARIO</b></button></div>
        <div class="clearfix"></div>
    </div>
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
<!-- INICIO MODAL AGREGAR-->
<div class="modal fade" id="modal_agregar" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">AGREGAR INFORMACION USUARIO</h4>
            </div>
            <div class="modal-body">
                <div id="modal_alerta_agregar"></div>
                <div class="form-group">
                    <label class="control-label col-sm-2 col-sm-offset-2" for="usuario">Usuario:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control"  id="add_usuario" name="usuario" value="">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 col-sm-offset-2" for="apellidos">Contraseña:</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" id="add_password" name="password" value="">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 col-sm-offset-2" for="nombres">Nombre:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="add_nombre" name="nombre" value="">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 col-sm-offset-2" for="fecha_nacimiento">Perfil:</label>
                    <div class="col-sm-6">
                        <select name="perfil" id="add_perfil">
                            <?php if (is_array($perfiles)) {
                                foreach ($perfiles as $perfil){
                                    echo "<option value='$perfil->id'>$perfil->descripcion</option>";
                                }
                            }?>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="submit"  id="btn_agregar_modal" class="btn btn-success">Agregar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- TERMINO MODAL EDITAR-->
<!-- INICIO MODAL EDITAR-->
<div class="modal fade" id="modal_editar" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">EDITAR INFORMACION USUARIO</h4>
            </div>
            <div class="modal-body">
                <div id="modal_alerta_editar"></div>
                <div class="form-group">
                    <label class="control-label col-sm-2 col-sm-offset-2" for="usuario">Usuario:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control"  id="edit_usuario" name="usuario" value="">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 col-sm-offset-2" for="nombres">Nombre:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="edit_nombre" name="nombre" value="">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 col-sm-offset-2" for="apellidos">Estado:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control"  disabled id="edit_estado" name="estado" value="">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 col-sm-offset-2" for="fecha_nacimiento">Perfil:</label>
                    <div class="col-sm-6">
                        <select name="perfil" id="edit_perfil">
                            <?php if (is_array($perfiles)) {
                                foreach ($perfiles as $perfil){
                                    echo "<option value='$perfil->id'>$perfil->descripcion</option>";
                                }
                            }?>
                        </select>
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
