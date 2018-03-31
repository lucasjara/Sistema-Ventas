$(document).ready(function () {
    $('select').select2({
        theme: "bootstrap"
    });
    $(".nav-tabs a").click(function () {
        $(this).tab('show');
    });
    $("#boton_registro").on('click', function () {
        $("#div_alerta").html('');
        $("#div_alerta").removeClass('alert alert-danger');
        var array = {
            // todo Datos Alumno
            nombres: $("input[name=nombres]").val(), //
            apellido_pat: $("input[name=apellido_pat]").val(), //
            apellido_mat: $("input[name=apellido_mat]").val(), //
            rut: $("input[name=rut]").val(), //
            fecha_nacimiento: $("input[name=fecha_nacimiento]").val(), //
            domicilio: $("input[name=domicilio]").val(), //
            numero: $("input[name=numero]").val(), //
            curso: $("select[name=curso]").val(), //
            fecha_matricula: $("input[name=fecha_matricula]").val(), //
            poblacion: $("input[name=poblacion]").val(),
            comuna: $("select[name=comuna]").val(),
            establecimiento: $("select[name=establecimiento]").val(),
            repite_curso: $("#repite_curso").prop('checked'),
            certificado_uno: $("#certificado_uno").prop('checked'),
            certificado_dos: $("#certificado_dos").prop('checked'),
            certificado_tres: $("#certificado_tres").prop('checked'),
            certificado_cuatro: $("#certificado_cuatro").prop('checked'),
            certificado_cinco: $("#certificado_cinco").prop('checked'),
            cual: $("input[name=cual]").val(),
            especialidad: $("select[name=especialidad]").val(),
            sector_vive: $("select[name=sector_vive]").val(),
            donde_vive: $("input[name=donde_vive]").val(),
            ascendencia: $("select[name=ascendencia]").val(),
            viaja: $("select[name=viaja]").val(),
            otros: $("input[name=otros]").val(),
            // todo Datos Padre
            nombres_padre: $("input[name=nombres_padre]").val(),
            apellido_pat_padre: $("input[name=apellido_pat_padre]").val(),
            apellido_mat_padre: $("input[name=apellido_mat_padre]").val(),
            numero_padre: $("input[name=numero_padre]").val(),
            nivel_educacional_padre: $("select[name=nivel_educacional_padre]").val(),
            rut_padre: $("input[name=rut_padre]").val(),
            ocupacion_padre: $("input[name=ocupacion_padre]").val(),
            fecha_nacimiento_padre: $("input[name=fecha_nacimiento_padre]").val(),
            domicilio_padre: $("input[name=domicilio_padre]").val(),
            ingreso_padre: $("input[name=ingreso_padre]").val(),
            // todo Datos Madre
            nombres_madre: $("input[name=nombres_madre]").val(),
            apellido_pat_madre: $("input[name=apellido_pat_madre]").val(),
            apellido_mat_madre: $("input[name=apellido_mat_madre]").val(),
            numero_madre: $("input[name=numero_madre]").val(),
            nivel_educacional_madre: $("select[name=nivel_educacional_madre]").val(),
            rut_madre: $("input[name=rut_madre]").val(),
            ocupacion_madre: $("input[name=ocupacion_madre]").val(),
            fecha_nacimiento_madre: $("input[name=fecha_nacimiento_madre]").val(),
            domicilio_madre: $("input[name=domicilio_madre]").val(),
            ingreso_madre: $("input[name=ingreso_madre]").val(),
            // todo Datos Familia
            integrantes: $("input[name=integrantes]").val(),
            n_hermanos: $("input[name=n_hermanos]").val(),
            h_estudiando: $("#h_estudiando").prop('checked'),
            educ_basica: $("input[name=educ_basica]").val(),
            educ_media: $("input[name=educ_media]").val(),
            educ_uni: $("input[name=educ_uni]").val(),
            abuelos: $("input[name=abuelos]").val(),
            tios: $("input[name=tios]").val(),
            // todo Datos Jefe Hogar
            jefe_hogar: $("select[name=jefe_hogar]").val(),
            rut_jefe_hogar: $("input[name=rut_jefe_hogar]").val(),
            religion: $("select[name=religion]").val(),
            prevision: $("select[name=prevision]").val(),
            salud: $("select[name=salud]").val(),
            // todo Datos Apoderados
            rut_apoderado: $("input[name=rut_apoderado]").val(),
            nombre_apoderado: $("input[name=nombre_apoderado]").val(),
            apellido_pat_apoderado: $("input[name=apellido_pat_apoderado]").val(),
            apellido_mat_apoderado: $("input[name=apellido_mat_apoderado]").val(),
            numero_apoderado: $("input[name=numero_apoderado]").val(),
            vinculo_alumno: $("select[name=vinculo_alumno]").val(),
            tipo_apoderado: $("select[name=tipo_apoderado]").val()

        };
        var request = envia_ajax('/codeigniter/registro/Registro_alumnos/guardar_datos_alumno', array);
        request.fail(function () {
            $("#modal_generico_body").html('Error al enviar peticion porfavor recargue la pagina');
            $("#modal_generico").modal('show');
        });
        request.done(function (data) {
            if (data.respuesta == "S") {
                $("#modal_generico_body").html(data.data);
                $("#modal_generico").modal('show');
            }
            else {
                $("#div_alerta").html(data.data);
                $("#div_alerta").addClass('alert alert-danger');
            }
        })
    });

    function envia_ajax(url, data) {
        var variable = $.ajax({
            url: url,
            method: "POST",
            data: data,
            "dataSrc": "data",
            dataType: "json"
        });
        return variable;
    }

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

    //todo Formato rut Input
    $("input[name=rut]").on('blur', function () {
        var rut = $(this).val();
        if (rut.length >= 8 && rut.length < 10) {
            rut = formateaRut(rut);
            $(this).val(rut);
        }
    });
    $("input[name=rut_padre]").on('blur', function () {
        var rut = $(this).val();
        if (rut.length >= 8 && rut.length < 10) {
            rut = formateaRut(rut);
            $(this).val(rut);
        }
    });
    $("input[name=rut_madre]").on('blur', function () {
        var rut = $(this).val();
        if (rut.length >= 8 && rut.length < 10) {
            rut = formateaRut(rut);
            $(this).val(rut);
        }
    });
    $("input[name=rut_jefe_hogar]").on('blur', function () {
        var rut = $(this).val();
        if (rut.length >= 8 && rut.length < 10) {
            rut = formateaRut(rut);
            $(this).val(rut);
        }
    });
    $("input[name=rut_apoderado]").on('blur', function () {
        var rut = $(this).val();
        if (rut.length >= 8 && rut.length < 10) {
            rut = formateaRut(rut);
            $(this).val(rut);
        }
    });
    $("#establecimiento").on('change', function () {
        var array = {
            'establecimiento': $(this).val()
        }
        var request = envia_ajax('/codeigniter/registro/Registro_alumnos/buscar_tipo_establecimiento', array);
        request.fail(function () {
            $("#modal_generico_body").html('Error al enviar peticion porfavor recargue la pagina');
            $("#modal_generico").modal('show');
        });
        request.done(function (data) {
            if (data.respuesta == "S") {
                $("#tipo_establecimiento").empty().select2({allowClear: true, theme: "bootstrap"});
                $("#tipo_establecimiento").append("<option value='" + data.data[0]["ID"] + "'>" + data.data[0]["DESCRIPCION"] + "</option>");
            }
            else {
                $("#modal_generico_body").html(data.data);
                $("#modal_generico").modal('show');
            }
        })

    });
    $("#jefe_hogar").on('change', function () {
        var numero = $(this).val();
        if (numero == 1 || numero == 2) {
            autocompletar_jefe_hogar(numero);
        }
    });
    $("#vinculo_alumno").on('change',function () {
        var numero = $(this).val();
        if (numero == 1 || numero == 2) {
            autocompletar_apoderado(numero);
        }
    });

    $("#boton_editar").on('click', function () {
        $("#div_alerta").html('');
        $("#div_alerta").removeClass('alert alert-danger');
        var array = {
            // todo Datos Alumno
            id_alumno: $(this).attr('data-id'),
            nombres: $("input[name=nombres]").val(), //
            apellido_pat: $("input[name=apellido_pat]").val(), //
            apellido_mat: $("input[name=apellido_mat]").val(), //
            rut: $("input[name=rut]").val(), //
            fecha_nacimiento: $("input[name=fecha_nacimiento]").val(), //
            domicilio: $("input[name=domicilio]").val(), //
            numero: $("input[name=numero]").val(), //
            curso: $("select[name=curso]").val(), //
            fecha_matricula: $("input[name=fecha_matricula]").val(), //
            poblacion: $("input[name=poblacion]").val(),
            comuna: $("select[name=comuna]").val(),
            establecimiento: $("select[name=establecimiento]").val(),
            repite_curso: $("#repite_curso").prop('checked'),
            certificado_uno: $("#certificado_uno").prop('checked'),
            certificado_dos: $("#certificado_dos").prop('checked'),
            certificado_tres: $("#certificado_tres").prop('checked'),
            certificado_cuatro: $("#certificado_cuatro").prop('checked'),
            certificado_cinco: $("#certificado_cinco").prop('checked'),
            cual: $("input[name=cual]").val(),
            especialidad: $("select[name=especialidad]").val(),
            sector_vive: $("select[name=sector_vive]").val(),
            donde_vive: $("input[name=donde_vive]").val(),
            ascendencia: $("select[name=ascendencia]").val(),
            viaja: $("select[name=viaja]").val(),
            otros: $("input[name=otros]").val(),
            // todo Datos Padre
            nombres_padre: $("input[name=nombres_padre]").val(),
            apellido_pat_padre: $("input[name=apellido_pat_padre]").val(),
            apellido_mat_padre: $("input[name=apellido_mat_padre]").val(),
            numero_padre: $("input[name=numero_padre]").val(),
            nivel_educacional_padre: $("select[name=nivel_educacional_padre]").val(),
            rut_padre: $("input[name=rut_padre]").val(),
            ocupacion_padre: $("input[name=ocupacion_padre]").val(),
            fecha_nacimiento_padre: $("input[name=fecha_nacimiento_padre]").val(),
            domicilio_padre: $("input[name=domicilio_padre]").val(),
            ingreso_padre: $("input[name=ingreso_padre]").val(),
            // todo Datos Madre
            nombres_madre: $("input[name=nombres_madre]").val(),
            apellido_pat_madre: $("input[name=apellido_pat_madre]").val(),
            apellido_mat_madre: $("input[name=apellido_mat_madre]").val(),
            numero_madre: $("input[name=numero_madre]").val(),
            nivel_educacional_madre: $("select[name=nivel_educacional_madre]").val(),
            rut_madre: $("input[name=rut_madre]").val(),
            ocupacion_madre: $("input[name=ocupacion_madre]").val(),
            fecha_nacimiento_madre: $("input[name=fecha_nacimiento_madre]").val(),
            domicilio_madre: $("input[name=domicilio_madre]").val(),
            ingreso_madre: $("input[name=ingreso_madre]").val(),
            // todo Datos Familia
            integrantes: $("input[name=integrantes]").val(),
            n_hermanos: $("input[name=n_hermanos]").val(),
            h_estudiando: $("#h_estudiando").prop('checked'),
            educ_basica: $("input[name=educ_basica]").val(),
            educ_media: $("input[name=educ_media]").val(),
            educ_uni: $("input[name=educ_uni]").val(),
            abuelos: $("input[name=abuelos]").val(),
            tios: $("input[name=tios]").val(),
            // todo Datos Jefe Hogar
            jefe_hogar: $("select[name=jefe_hogar]").val(),
            rut_jefe_hogar: $("input[name=rut_jefe_hogar]").val(),
            religion: $("select[name=religion]").val(),
            prevision: $("select[name=prevision]").val(),
            salud: $("select[name=salud]").val(),
            // todo Datos Apoderados
            rut_apoderado: $("input[name=rut_apoderado]").val(),
            nombre_apoderado: $("input[name=nombre_apoderado]").val(),
            apellido_pat_apoderado: $("input[name=apellido_pat_apoderado]").val(),
            apellido_mat_apoderado: $("input[name=apellido_mat_apoderado]").val(),
            numero_apoderado: $("input[name=numero_apoderado]").val(),
            vinculo_alumno: $("select[name=vinculo_alumno]").val(),
            tipo_apoderado: $("select[name=tipo_apoderado]").val()

        };
        var request = envia_ajax('/codeigniter/registro/Registro_alumnos/editar_registro_alumno', array);
        request.fail(function () {
            $("#modal_generico_body").html('Error al enviar peticion porfavor recargue la pagina');
            $("#modal_generico").modal('show');
        });
        request.done(function (data) {
            if (data.respuesta == "S") {
                $("#modal_generico_body").html(data.data);
                $("#modal_generico").modal('show');
            }
            else {
                $("#div_alerta").html(data.data);
                $("#div_alerta").addClass('alert alert-danger');
            }
        })
    });
    function autocompletar_jefe_hogar(tipo) {
        if(tipo == 1 && $("input[name=rut_madre]").val() != ''){
            $("input[name=rut_jefe_hogar]").val($("input[name=rut_madre]").val());
        }else if(tipo ==2 && $("input[name=rut_padre]").val()){
            $("input[name=rut_jefe_hogar]").val($("input[name=rut_padre]").val());
        }
    }
    function autocompletar_apoderado(tipo) {
        if(tipo ==1){
            var rut_madre=$("input[name=rut_madre]").val();
            var nombres_madre =$("input[name=nombres_madre]").val();
            var apellido_pat_madre= $("input[name=apellido_pat_madre]").val();
            var apellido_mat_madre= $("input[name=apellido_mat_madre]").val();
            var numero_madre =$("input[name=numero_madre]").val();
            if (rut_madre != '' && nombres_madre != '' && apellido_pat_madre != '' && apellido_mat_madre != ''){
                $("input[name=rut_apoderado]").val(rut_madre),
                $("input[name=nombre_apoderado]").val(nombres_madre),
                $("input[name=apellido_pat_apoderado]").val(apellido_pat_madre),
                $("input[name=apellido_mat_apoderado]").val(apellido_mat_madre),
                $("input[name=numero_apoderado]").val(numero_madre)
            }
        }else if(tipo ==2){
            var rut_padre=$("input[name=rut_padre]").val();
            var nombres_padre =$("input[name=nombres_padre]").val();
            var apellido_pat_padre= $("input[name=apellido_pat_padre]").val();
            var apellido_mat_padre= $("input[name=apellido_mat_padre]").val();
            var numero_padre= $("input[name=numero_padre]").val();
            if (rut_padre != '' && nombres_padre != '' && apellido_pat_padre != '' && apellido_mat_padre != ''){
                $("input[name=rut_apoderado]").val(rut_padre),
                    $("input[name=nombre_apoderado]").val(nombres_padre),
                    $("input[name=apellido_pat_apoderado]").val(apellido_pat_padre),
                    $("input[name=apellido_mat_apoderado]").val(apellido_mat_padre),
                    $("input[name=numero_apoderado]").val(numero_padre)
            }
        }
    }
});
