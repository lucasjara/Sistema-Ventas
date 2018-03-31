$(document).ready(function () {

    var tabla =$('#tabla_alumnos').DataTable({
        "language": {
            "url": "/codeigniter/public/Spanish.json"
        },
        "ajax": {
            "url": "/codeigniter/mantenedores/alumnos/obtener_datos",
            "datatype": "json",
            "dataSrc": "data",
            "type": "post"
        },
        "columns": [
            {"data": "ID"},
            {
                "data": "RUT", render: function (data) {
                return formateaRut(data);
            }
            },
            {"data": "NOMBRES"},
            {"data": "APELLIDOS"},
            {
                "data": "FECHA_NACIMIENTO", render: function (data) {
                return formato_fecha(data);
            }
            },
            {"data": "DOMICILIO"},
            {"data": "NUMERO"},
            {"data": "ACCIONES"}
        ],

    });
    $("#tabla_alumnos").on('click','> tbody > tr > td:nth-child(8) > button.btn.btn-success.btn-xs.btn_editar', function () {
        //Limpieza alerta
        $("#modal_alerta_editar").html('');
        $("#modal_alerta_editar").removeClass('alert alert-danger');
        // Carga de datos modal editar
        $("#id_modificar").val($(this).attr('data-id'));
        $("#edit_rut").val(formateaRut($(this).attr('data-rut')));
        $('#edit_nombres').val($(this).attr('data-nombres'));
        $('#edit_apellidos').val($(this).attr('data-apellidos'));
        $('#edit_fecha_nacimiento').val($(this).attr('data-fecha-nacimiento'));
        $('#edit_domicilio').val($(this).attr('data-domicilio'));
        $('#edit_numero').val($(this).attr('data-numero'));
        $("#modal_editar").modal('show');
    });
    $("#btn_editar_modal").on('click', function () {
       var array ={
           'id': $("#id_modificar").val(),
           'nombres':$('#edit_nombres').val(),
           'fecha_nacimiento':$('#edit_fecha_nacimiento').val(),
           'domicilio':$('#edit_domicilio').val(),
           'numero':$('#edit_numero').val()
       }
        var request = envia_ajax('/codeigniter/mantenedores/Alumnos/editar_alumno',array);
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
    $("#tabla_alumnos").on('click','> tbody > tr > td:nth-child(8) > button.btn.btn-danger.btn-xs.btn_eliminar', function () {
        if(confirm('Realmente desea eliminar este registro?'))
        {
            var array = {
                'id': $(this).attr('data-id')
            }
            var request = envia_ajax('/codeigniter/mantenedores/Alumnos/eliminar_alumno',array);
            request.fail(function () {
                $("#modal_generico_body").html('Error al enviar peticion porfavor recargue la pagina');
                $("#modal_generico").modal('show');
            });
            request.done(function (data) {
                if (data.respuesta == "S") {
                    tabla.ajax.reload();
                    $("#modal_generico_body").html(data.data);
                    $("#modal_generico").modal('show');
                }
                else {
                    $("#modal_generico_body").html(data.data);
                    $("#modal_generico").modal('show');
                }
            })
        }
    });

    function formateaRut(rut) {
        var actual = rut.replace(/^0+/, "");
        if (actual != '' && actual.length > 1) {
            var sinPuntos = actual.replace(/\./g, "");
            var actualLimpio = sinPuntos.replace(/-/g, "");
            var inicio = actualLimpio.substring(0, actualLimpio.length - 1);
            var rutPuntos = "";
            var i = 0;
            var j = 1;
            for (i = inicio.length - 1; i >= 0; i--) {
                var letra = inicio.charAt(i);
                rutPuntos = letra + rutPuntos;
                if (j % 3 == 0 && j <= inicio.length - 1) {
                    rutPuntos = "." + rutPuntos;
                }
                j++;
            }
            var dv = actualLimpio.substring(actualLimpio.length - 1);
            rutPuntos = rutPuntos + "-" + dv;
        }
        return rutPuntos;
    }
    function formato_fecha(dato) {

        var dia = dato.substring(10, 8);
        var mes = dato.substring(7, 5);
        var anio = dato.substring(0, 4);
        switch (mes) {
            case '01':
                mes = "Enero";
                break;
            case '02':
                mes = "Febrero";
                break;
            case '03':
                mes = "Marzo";
                break;
            case '04':
                mes = "Abril";
                break;
            case '05':
                mes = "Mayo";
                break;
            case '06':
                mes = "Junio";
                break;
            case '07':
                mes = "Julio";
                break;
            case '08':
                mes = "Agosto";
                break;
            case '09':
                mes = "Septiembre";
                break;
            case '10':
                mes = "Octubre";
                break;
            case '11':
                mes = "Noviembre";
                break;
            case '12':
                mes = "Diciembre";
                break;
        }
        var fecha = dia + " de " + mes + " de " + anio;
        return fecha;
    }
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