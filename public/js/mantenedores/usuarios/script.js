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
            {"data": "perfil"},
            {"data": "acciones"}
        ]
    });
    $("#tabla_usuarios").on('click','> tbody > tr > td:nth-child(6) > button.btn.btn-success.btn-xs.btn_editar', function () {
        //Limpieza alerta
        $("#modal_alerta_editar").html('');
        $("#modal_alerta_editar").removeClass('alert alert-danger');
        // Carga de datos modal editar
        $("#id_modificar").val($(this).attr('data-id'));
        $("#edit_usuario").val(formateaRut($(this).attr('data-usuario')));
        $('#edit_nombres').val($(this).attr('data-nombres'));
        $('#edit_estado').val($(this).attr('data-estado'));
        $('#edit_perfil').val($(this).attr('data-perfil'));
        $("#modal_editar").modal('show');
    });
    $("#btn_editar_modal").on('click', function () {
       var array ={
           'id': $("#id_modificar").val(),
           'usuario':$('#edit_usuario').val(),
           'nombres':$('#edit_nombres').val(),
           'estado':$('#edit_estado').val(),
           'perfil':$('#edit_perfil').val()
       }
        var request = envia_ajax('/codeigniter/mantenedores/usuarios/editar_usuario',array);
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