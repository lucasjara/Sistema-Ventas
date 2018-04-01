$(document).ready(function () {
    var tabla =$('#tabla_usuarios').DataTable({
        "language": {
            "url": "/codeigniter/public/Spanish.json"
        },
        "ajax": {
            "url": "/sistema_ventas/mantenedores/usuarios/obtener_datos",
            "datatype": "json",
            "dataSrc": "data",
            "type": "post"
        },
        "columns": [
            {"data": "id"},
            {"data": "usuario"},
            {"data": "nombre"},
            {"data": "estado"},
            {"data": "perfil_d"},
            {"data": "acciones"}
        ]
    });
    $("#add_perfil").select2();
    $("#edit_perfil").select2();
    $("#agregar_usuarios").on('click', function () {
        $("#modal_agregar").modal('show');
    });
    $("#tabla_usuarios").on('click','> tbody > tr > td:nth-child(6) > btn_editar', function () {
        //Limpieza alerta
        $("#modal_alerta_editar").html('');
        $("#modal_alerta_editar").removeClass('alert alert-danger');
        // Carga de datos modal editar
        $("#id_modificar").val($(this).attr('data-id'));
        $("#edit_usuario").val($(this).attr('data-usuario'));
        $('#edit_nombre').val($(this).attr('data-nombres'));
        $('#edit_estado').val($(this).attr('data-estado'));
        $("#edit_perfil").val($(this).attr('data-perfil')).trigger('change.select2');
        $("#modal_editar").modal('show');
    });
    $("#tabla_usuarios").on('click','> tbody > tr > td:nth-child(6) > .btn_estado', function () {
        var array ={
            'id': $.trim($(this).attr('data-id')),
            'estado':$(this).attr('data-estado')
        }
        var request = envia_ajax('/sistema_ventas/mantenedores/usuarios/cambiar_estado_usuario',array);
        request.fail(function () {
            $("#modal_generico_body").html('Error al enviar peticion porfavor recargue la pagina');
            $("#modal_generico").modal('show');
        });
        request.done(function (data) {
            if (data.respuesta == "S") {
                tabla.ajax.reload();
            }
            else {
                $("#modal_generico_body").html(data.data);
                $("#modal_generico").modal('show');
            }
        })
    });
    $("#btn_agregar_modal").on('click', function () {
        var array ={
            'usuario':$('#add_usuario').val(),
            'password': $("#add_password").val(),
            'nombres':$('#add_nombre').val(),
            'perfil':$('#add_perfil').val()
        }
        var request = envia_ajax('/sistema_ventas/mantenedores/usuarios/agregar_usuario',array);
        request.fail(function () {
            $("#modal_generico_body").html('Error al enviar peticion porfavor recargue la pagina');
            $("#modal_generico").modal('show');
        });
        request.done(function (data) {
            if (data.respuesta == "S") {
                tabla.ajax.reload();
                $("#modal_agregar").modal('hide');
                $("#modal_generico_body").html(data.data);
                $("#modal_generico").modal('show');
            }
            else {
                $("#modal_alerta_agregar").html(data.data);
                $("#modal_alerta_agregar").addClass('alert alert-danger');
            }
        })
    });
    $("#btn_editar_modal").on('click', function () {
       var array ={
           'id': $("#id_modificar").val(),
           'usuario':$('#edit_usuario').val(),
           'nombres':$('#edit_nombre').val(),
           'perfil':$('#edit_perfil').val()
       }
        var request = envia_ajax('/sistema_ventas/mantenedores/usuarios/editar_usuario',array);
        request.fail(function () {
            $("#modal_generico_body").html('Error al enviar peticion porfavor recargue la pagina');
            $("#modal_generico").modal('show');
        });
        request.done(function (data) {
            if (data.respuesta == "S") {
                tabla.ajax.reload();
                $("#modal_editar").modal('hide');
                $("#modal_generico_body").html(data.data);
                $("#modal_generico").modal('show');
            }
            else {
                $("#modal_alerta_editar").html(data.data);
                $("#modal_alerta_editar").addClass('alert alert-danger');
            }
        })
    });
    function envia_ajax(url,data) {
        var variable = $.ajax({
            url: url,
            method: "POST",
            data: data,
            "dataSrc": "data",
            dataType: "json"
        });
        return variable;
    }

});