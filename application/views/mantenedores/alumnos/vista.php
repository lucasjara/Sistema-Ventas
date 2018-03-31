<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 14-01-2018
 * Time: 14:53
 */
?>
<br>
<div class="panel panel-primary">
    <div class="panel-heading">Listado de Alumnos</div>
    <div class="panel-body">
        <table id="tabla_alumnos" class="table table-responsive"">
            <thead>
            <tr>
                <th>ID</th>
                <th>RUT</th>
                <th>NOMBRES</th>
                <th>APELLIDOS</th>
                <th>FECHA NACIMIENTO</th>
                <th>DOMICILIO</th>
                <th>NUMERO</th>
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
                <h4 class="modal-title">Editar Alumno</h4>
            </div>
            <div class="modal-body">
                <div id="modal_alerta_editar"></div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="rut">Rut:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" disabled id="edit_rut" name="rut" value="">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="nombres">Nombres:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="edit_nombres" name="nombres" value="">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="apellidos">Apellidos:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" disabled id="edit_apellidos" name="apellidos" value="">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="fecha_nacimiento">Fecha Nacimiento:</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="edit_fecha_nacimiento" name="fecha_nacimiento" value="">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="domicilio">Domicilio:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="edit_domicilio" name="domicilio" value="">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="numero">Telefono:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="edit_numero" name="numero" value="">
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
<script src="<?php echo base_url('/public/js/mantenedores/alumnos/script.js')?>"></script>
